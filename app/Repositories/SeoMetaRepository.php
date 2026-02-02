<?php

namespace App\Repositories;

use App\Models\SeoMeta;
use Illuminate\Support\Facades\Cache;

class SeoMetaRepository
{
    /**
     * Получить SEO-мета по типу, id и языку
     *
     * @param string $type
     * @param int|null $pageId
     * @param string|null $locale
     * @return SeoMeta|null
     */
    public function get(string $type, $pageId = null, ?string $locale = null): ?SeoMeta
    {
        $locale = $locale ?? app()->getLocale();

        return SeoMeta::where('page_type', $type)
            ->where('page_id', $pageId)
            ->where('locale', $locale)
            ->first();
    }

    /**
     * Получить SEO-мета по slug статической страницы
     *
     * @param string $slug
     * @param string|null $locale
     * @return SeoMeta|null
     */
    public function getStatic(string $slug, ?string $locale = null): ?SeoMeta
    {
        $locale = $locale ?? app()->getLocale();
        $cacheKey = 'seo_meta_static_' . $slug . '_' . $locale;

        return Cache::remember($cacheKey, 7200, function () use ($slug, $locale) {
            return SeoMeta::where('page_type', $slug)
                ->where('locale', $locale)
                ->first();
        });
    }
}
