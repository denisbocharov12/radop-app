<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend\v1\Seo;

use App\Http\Controllers\Controller;
use App\Services\Seo\SeoHeadLayers;
use Illuminate\Http\Response;

/**
 * robots.txt отдаём маршрутом, а не файлом: правила собираются из тех же
 * списков, что и директивы индексации (App\Services\Seo\SeoHeadLayers).
 * Раньше файл правили руками, и он отставал — в нём не было ни sort=, ни
 * perPage=, ни filter[], зато был вручную продублирован русский язык.
 */
final class RobotsController extends Controller
{
    public function __invoke(): Response
    {
        $locales = array_keys((array) config('laravellocalization.supportedLocales', []));
        $default = (string) config('app.fallback_locale', 'ro');
        $prefixes = array_values(array_diff($locales, [$default]));

        $lines = ['User-agent: *', ''];

        $lines[] = '# Разделы без индексируемого содержимого';

        foreach (SeoHeadLayers::PRIVATE_SECTIONS as $section) {
            $lines[] = 'Disallow: /' . $section;

            foreach ($prefixes as $prefix) {
                $lines[] = 'Disallow: /' . $prefix . '/' . $section;
            }
        }

        foreach (['admin', 'dashboard'] as $section) {
            $lines[] = 'Disallow: /' . $section;
        }

        $lines[] = '';
        $lines[] = '# Параметры, которые плодят дубли. Индексируем только ' . implode(', ', SeoHeadLayers::INDEXABLE_PARAMS);

        foreach (SeoHeadLayers::NOISY_PARAMS as $param) {
            // filter приходит массивом (filter[brand][]=), знак равенства в
            // правиле отрезал бы его начисто.
            $tail = $param === 'filter' ? '' : '=';
            $lines[] = 'Disallow: /*?' . $param . $tail;
            $lines[] = 'Disallow: /*&' . $param . $tail;
        }

        $lines[] = '';
        $lines[] = '# Обработчики фильтров отвечают только на POST';
        $lines[] = 'Disallow: /filter';
        $lines[] = 'Disallow: /*/filter';
        $lines[] = 'Disallow: /*/filter-by-category';

        $lines[] = '';
        $lines[] = 'Allow: /';
        $lines[] = '';
        $lines[] = 'Sitemap: ' . url('/sitemap.xml');
        $lines[] = '';

        return response(implode("\n", $lines), 200, [
            'Content-Type' => 'text/plain; charset=UTF-8',
            'Cache-Control' => 'public, max-age=3600',
        ]);
    }
}
