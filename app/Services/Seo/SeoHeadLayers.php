<?php

declare(strict_types=1);

namespace App\Services\Seo;

use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\TwitterCard;
use Illuminate\Http\Request;

/**
 * Сборка тегов <head> по слоям, один раз на запрос.
 *
 * Слои идут снизу вверх, каждый следующий дополняет предыдущий и может его
 * переопределить:
 *
 *   1. значения по умолчанию (config/seotools.php и языковые файлы seo.php);
 *   2. запасные значения по типу страницы (SeoFallbackGenerator);
 *   3. запись в seo_metas (её кладут контроллеры);
 *   4. то, что страница задала сама через SEOTools;
 *   5. этот слой — канонический адрес, директивы индексации, суффикс
 *      заголовка, номер страницы, OG и Twitter.
 *
 * Раньше канонический адрес брался из полного URL, поэтому в него попадали
 * сортировка, фильтры и чужие метки; директивы индексации жили в отдельном
 * middleware, суффикс «| Radop.md» добавлялся в двух местах и местами
 * задваивался. Теперь это одно место, которое вызывается из head.
 */
final class SeoHeadLayers
{
    /**
     * Параметры, с которыми страница остаётся в индексе и попадает в
     * канонический адрес. Всё остальное — дубль: noindex и канонический адрес
     * без параметров.
     */
    public const INDEXABLE_PARAMS = ['page'];

    /** Разделы без индексируемого содержимого. */
    public const PRIVATE_SECTIONS = [
        'search', 'cart', 'wishlist', 'checkout', 'login',
        'registration', 'reset-password', 'user', 'thank-you',
    ];

    /**
     * Параметры, которые чаще всего плодят дубли. Полный запрет описать в
     * robots.txt нельзя (там нет «всё, кроме page»), поэтому перечисляем шумные
     * — этим же списком пользуется robots.txt.
     */
    public const NOISY_PARAMS = [
        'sort', 'order', 'perPage', 'per_page', 'filter',
        'utm_source', 'utm_medium', 'utm_campaign', 'utm_term', 'utm_content',
        'fbclid', 'gclid', 'yclid', 'msclkid', 'mc_eid', '_ga',
    ];

    private const BRAND_SUFFIX = 'Radop.md';

    /**
     * Запасные заголовки для страниц, которых нет в seo_metas и которые не
     * задают заголовок сами: раздел адреса → ключ перевода.
     */
    private const SECTION_TITLES = [
        'login' => 'theme.log-in-account',
        'registration' => 'theme.registration',
        'reset-password' => 'theme.reset-password',
        'cart' => 'theme.cart',
        'wishlist' => 'theme.wishlist',
    ];

    /** Адрес из seo_metas.canonical для текущей страницы, если он задан. */
    private static ?string $canonicalOverride = null;

    public static function overrideCanonical(?string $url): void
    {
        self::$canonicalOverride = $url;
    }

    public function apply(Request $request): void
    {
        $locale = app()->getLocale();
        $page = $this->pageNumber($request);

        $canonical = $this->canonicalOverride($request) ?? $this->canonical($request, $page);
        // Переопределение живёт ровно один рендер — иначе в долгоживущем
        // процессе оно утекло бы на следующую страницу.
        self::$canonicalOverride = null;

        SEOMeta::setCanonical($canonical);
        SEOMeta::setRobots($this->robots($request));

        $title = $this->title((string) SEOMeta::getTitle(), $locale, $page);
        SEOMeta::setTitle($title, false);

        $description = $this->description($locale);
        SEOMeta::setDescription($description);

        $this->openGraph($title, $description, $canonical, $locale);
    }

    /**
     * Канонический адрес: путь текущего языка плюс только те параметры,
     * которые мы индексируем.
     */
    private function canonical(Request $request, int $page): string
    {
        // Берём путь текущего запроса: он уже приведён к каноническому виду
        // редиректами (без /ro, без завершающего слеша, без index.php).
        $base = url($request->getPathInfo());

        $keep = [];

        foreach (self::INDEXABLE_PARAMS as $param) {
            $value = $request->query($param);

            if (is_scalar($value) && (string) $value !== '') {
                $keep[$param] = (string) $value;
            }
        }

        // Первая страница — тот же адрес, что и раздел без параметров.
        if ($page <= 1) {
            unset($keep['page']);
        }

        return $keep === [] ? $base : $base . '?' . http_build_query($keep);
    }

    /**
     * Переопределение из админки принимаем только внутри того же языка: в базе
     * есть русские записи с адресом без префикса /ru, и такой canonical увёл бы
     * русскую страницу на румынскую.
     */
    private function canonicalOverride(Request $request): ?string
    {
        $url = self::$canonicalOverride;

        if ($url === null || $url === '') {
            return null;
        }

        $path = (string) (parse_url($url, PHP_URL_PATH) ?: '/');
        $locale = app()->getLocale();
        $default = (string) config('app.fallback_locale', 'ro');
        $prefixed = str_starts_with($path, '/' . $locale . '/') || $path === '/' . $locale;

        if ($locale !== $default && ! $prefixed) {
            return null;
        }

        if ($locale === $default && $this->hasLocalePrefix($path)) {
            return null;
        }

        return $url;
    }

    private function hasLocalePrefix(string $path): bool
    {
        foreach (array_keys((array) config('laravellocalization.supportedLocales', [])) as $locale) {
            if (str_starts_with($path, '/' . $locale . '/') || $path === '/' . $locale) {
                return true;
            }
        }

        return false;
    }

    private function robots(Request $request): string
    {
        if ($this->isPrivatePage($request)) {
            return 'noindex, follow';
        }

        foreach (array_keys($request->query()) as $key) {
            if (! in_array((string) $key, self::INDEXABLE_PARAMS, true)) {
                return 'noindex, follow';
            }
        }

        return 'index, follow';
    }

    /**
     * Суффикс бренда ставится ровно один раз, номер страницы — в конце,
     * чтобы вторая страница раздела не повторяла первую слово в слово.
     */
    private function title(string $title, string $locale, int $page): string
    {
        $title = trim($title);

        if ($title === '') {
            $title = $this->sectionTitle(request(), $locale) ?? (string) trans('seo.title', [], $locale);
        }

        if ($page > 1) {
            $title .= $locale === 'ru' ? " — страница {$page}" : " — pagina {$page}";
        }

        // Заголовки из базы часто уже содержат «Radop», «Radop.md» или
        // «Radop Moldova» — второй раз бренд не добавляем.
        if (preg_match('/radop/iu', $title)) {
            return $title;
        }

        return $title . ' | ' . self::BRAND_SUFFIX;
    }

    private function description(string $locale): string
    {
        $description = trim((string) SEOMeta::getDescription());

        return $description !== ''
            ? $description
            : (string) trans('seo.description', [], $locale);
    }

    /**
     * og:type раньше заполнялся значениями, которых в словаре OpenGraph нет
     * («category», «articles», «search»), og:site_name и og:locale не
     * выводились вовсе, карточка Twitter собиралась по остаткам.
     */
    private function openGraph(string $title, string $description, string $canonical, string $locale): void
    {
        $type = $this->openGraphType();

        OpenGraph::setTitle($title);
        OpenGraph::setDescription($description);
        OpenGraph::setUrl($canonical);
        OpenGraph::setType($type);
        OpenGraph::setSiteName('Radop');
        OpenGraph::addProperty('locale', $locale === 'ru' ? 'ru_MD' : 'ro_MD');
        OpenGraph::addProperty('locale:alternate', $locale === 'ru' ? 'ro_MD' : 'ru_MD');

        TwitterCard::setType('summary_large_image');
        TwitterCard::setTitle($title);
        TwitterCard::setDescription($description);
    }

    private function openGraphType(): string
    {
        $route = (string) (request()->route()?->getName() ?? '');

        return str_contains($route, 'product.index') ? 'product' : 'website';
    }

    private function pageNumber(Request $request): int
    {
        $page = $request->query('page');

        return is_numeric($page) ? max(1, (int) $page) : 1;
    }

    private function sectionTitle(Request $request, string $locale): ?string
    {
        $section = $this->firstSegment($request);
        $key = $section === null ? null : (self::SECTION_TITLES[$section] ?? null);

        return $key === null ? null : (string) trans($key, [], $locale);
    }

    private function isPrivatePage(Request $request): bool
    {
        $section = $this->firstSegment($request);

        return $section !== null && in_array($section, self::PRIVATE_SECTIONS, true);
    }

    /** Первый раздел адреса без префикса языка. */
    private function firstSegment(Request $request): ?string
    {
        $segments = $request->segments();
        $locales = array_keys((array) config('laravellocalization.supportedLocales', []));

        if ($segments !== [] && in_array($segments[0], $locales, true)) {
            array_shift($segments);
        }

        return $segments[0] ?? null;
    }
}
