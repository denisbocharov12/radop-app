<?php

declare(strict_types=1);

namespace App\Services\ViewCount;

use Illuminate\Support\Facades\Cache;

/**
 * Lightweight, batched view recorder (replaces the per-request queued job).
 *
 * How it works (industry-standard "throttle + batch"):
 *   1. Bots/crawlers are ignored (user-agent filter).
 *   2. Each unique visitor (session + IP) counts a given entity at most once per
 *      DEDUP_MINUTES window — this is the "unique view every 15 minutes" the shop
 *      wants, and it makes totals resistant to refresh/spam.
 *   3. Qualifying views are accumulated in a per-type cache buffer keyed by
 *      "{id}|{ip}|{session}" → count. NO database write and NO queued job per hit.
 *   4. A scheduled command (view-counts:flush, every 15 min) drains the buffer into
 *      the *_view_counts tables in one batch and clears it (the "reset the counter").
 *
 * Buffer read-modify-write is guarded by an atomic cache lock so concurrent page
 * views don't lose increments.
 */
final class ViewCountRecorder
{
    /** Supported entity types → cache namespace. */
    public const TYPES = ['product', 'category', 'brand'];

    /** A visitor counts the same entity at most once per this many minutes. */
    private const DEDUP_MINUTES = 15;

    /** Seconds to wait for the buffer lock before giving up (never block a page load long). */
    private const LOCK_WAIT = 3;

    public function record(string $type, int $id, string $ip, string $sessionId, ?string $userAgent): void
    {
        if (!in_array($type, self::TYPES, true) || $id <= 0) {
            return;
        }

        if ($this->isBot($userAgent)) {
            return;
        }

        // 15-minute per-visitor dedup for this entity.
        $seenKey = "vc:seen:{$type}:{$id}:" . md5($ip . '|' . $sessionId);
        if (Cache::has($seenKey)) {
            return;
        }
        Cache::put($seenKey, 1, now()->addMinutes(self::DEDUP_MINUTES));

        $composite = $id . '|' . $ip . '|' . $sessionId;
        $bufferKey = $this->bufferKey($type);

        $this->withBufferLock($type, function () use ($bufferKey, $composite) {
            $buffer = Cache::get($bufferKey, []);
            $buffer[$composite] = ($buffer[$composite] ?? 0) + 1;
            Cache::forever($bufferKey, $buffer);
        });
    }

    /**
     * Atomically drain and clear the buffer for a type.
     *
     * @return array<string, int> map of "{id}|{ip}|{session}" => buffered count
     */
    public function drain(string $type): array
    {
        $bufferKey = $this->bufferKey($type);
        $buffer = [];

        $this->withBufferLock($type, function () use ($bufferKey, &$buffer) {
            $buffer = Cache::pull($bufferKey, []);
        });

        return is_array($buffer) ? $buffer : [];
    }

    private function bufferKey(string $type): string
    {
        return "vc:buffer:{$type}";
    }

    private function withBufferLock(string $type, callable $callback): void
    {
        $lock = Cache::lock("vc:lock:{$type}", 10);

        try {
            if ($lock->block(self::LOCK_WAIT)) {
                $callback();
            }
        } catch (\Throwable $e) {
            // Never let view accounting break a page render.
        } finally {
            optional($lock)->release();
        }
    }

    private function isBot(?string $userAgent): bool
    {
        if ($userAgent === null || trim($userAgent) === '') {
            return true;
        }

        return (bool) preg_match(
            '~bot|crawl|spider|slurp|bing|google|yandex|baidu|duckduck|facebookexternalhit|'
            . 'ahrefs|semrush|mj12|dotbot|petalbot|bytespider|headless|python-requests|'
            . 'curl|wget|axios|okhttp|scrapy~i',
            $userAgent
        );
    }
}
