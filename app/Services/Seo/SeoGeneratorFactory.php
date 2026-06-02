<?php

declare(strict_types=1);

namespace App\Services\Seo;

use App\Services\Seo\Contracts\SeoGeneratorContract;

/**
 * Resolves the SEO generator for a given AI provider.
 *
 * Provider precedence: explicit argument → config('seo_ai.provider') default.
 * Unknown providers fall back to the configured default.
 */
final class SeoGeneratorFactory
{
    public const PROVIDER_GEMINI = 'gemini';
    public const PROVIDER_CLAUDE = 'claude';

    /**
     * @return list<string>
     */
    public static function providers(): array
    {
        return [self::PROVIDER_GEMINI, self::PROVIDER_CLAUDE];
    }

    public function default(): string
    {
        $configured = (string) config('seo_ai.provider', self::PROVIDER_GEMINI);

        return in_array($configured, self::providers(), true)
            ? $configured
            : self::PROVIDER_GEMINI;
    }

    /**
     * Normalise an arbitrary provider string to a supported one.
     */
    public function normalize(?string $provider): string
    {
        $provider = strtolower(trim((string) $provider));

        return in_array($provider, self::providers(), true)
            ? $provider
            : $this->default();
    }

    public function make(?string $provider = null): SeoGeneratorContract
    {
        return match ($this->normalize($provider)) {
            self::PROVIDER_CLAUDE => app(ClaudeSeoGeneratorService::class),
            default               => app(GeminiSeoGeneratorService::class),
        };
    }
}
