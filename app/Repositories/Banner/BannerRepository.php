<?php

namespace App\Repositories\Banner;

use App\Models\Banner;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;

final class BannerRepository
{
    private const COUNT_OF_PAGINATION = 20;

    public const FRONT_CACHE_KEY_PREFIX    = 'banners_active_front_';
    public const AUTOPLAY_CACHE_KEY_PREFIX = 'home_page_autoplay_speed_';
    private const CACHE_TTL_SECONDS        = 7200;

    /**
     * Locales whose banner caches we maintain. Kept here (rather than read
     * from config at runtime) so the flush path is deterministic and cheap.
     */
    private const CACHED_LOCALES = ['ro', 'ru'];

    public function getAllPaginated(): LengthAwarePaginator
    {
        return Banner::orderBy('order')
            ->paginate(self::COUNT_OF_PAGINATION)
            ->appends(request()->query());
    }

    /**
     * @return Collection
     */
    public function getAllActiveForFront(): Collection
    {
        $cacheKey = self::FRONT_CACHE_KEY_PREFIX . app()->getLocale();

        return Cache::remember($cacheKey, self::CACHE_TTL_SECONDS, function () {
            return Banner::where('active', true)
                ->orderBy('order')
                ->get();
        });
    }

    public function checkIfBannedWithSameOrderExists(string $order, Banner $banner): bool
    {
        return Banner::where('order', $order)
            ->where('active', true)
            ->where('id', '!=', $banner->id)
            ->exists();
    }

    public function getById(int $id): ?Banner
    {
        return Banner::find($id);
    }

    /**
     * Flush the cached list of front-facing active banners for every locale.
     * Called by BannerObserver whenever a Banner row is saved/deleted/restored
     * so the homepage reflects admin changes immediately instead of waiting
     * for the 2-hour TTL.
     */
    public static function flushFrontCache(): void
    {
        foreach (self::CACHED_LOCALES as $locale) {
            Cache::forget(self::FRONT_CACHE_KEY_PREFIX . $locale);
        }
    }

    /**
     * Flush the cached homepage autoplay speed for every locale. Called by
     * BannerSettingObserver whenever rotation settings are updated.
     */
    public static function flushAutoplayCache(): void
    {
        foreach (self::CACHED_LOCALES as $locale) {
            Cache::forget(self::AUTOPLAY_CACHE_KEY_PREFIX . $locale);
        }
    }

    public static function flushAllCaches(): void
    {
        self::flushFrontCache();
        self::flushAutoplayCache();
    }
}
