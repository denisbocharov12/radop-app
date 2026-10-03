<?php

namespace App\Repositories;

use App\Models\SeoMeta;
use App\Services\Seo\SeoHeadLayers;
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

        $meta = SeoMeta::where('page_type', $type)
            ->where('page_id', $pageId)
            ->where('locale', $locale)
            ->first();

        return $this->shareCanonical($meta);
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

        $meta = Cache::remember($cacheKey, 7200, function () use ($slug, $locale) {
            return SeoMeta::where('page_type', $slug)
                ->where('locale', $locale)
                ->first();
        });

        return $this->shareCanonical($meta);
    }

    /**
     * Колонка canonical в админке есть, но на витрину не попадала. Передаём её
     * слою сборки head — там она перекрывает адрес, собранный из маршрута.
     */
    private function shareCanonical(?SeoMeta $meta): ?SeoMeta
    {
        if ($meta !== null && is_string($meta->canonical) && trim($meta->canonical) !== '') {
            SeoHeadLayers::overrideCanonical(trim($meta->canonical));
        }

        return $meta;
    }
}
