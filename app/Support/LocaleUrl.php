<?php

declare(strict_types=1);

namespace App\Support;

/**
 * Locale-aware URLs for hreflang tags and the language switcher.
 *
 * The default locale is hidden in the URL, so its canonical address has no
 * /{locale} prefix. Links and hreflang targets must never point at the
 * prefixed duplicate (which CanonicalPathRedirect answers with a 301).
 */
final class LocaleUrl
{
    /**
     * Canonical URL of the current page in the given locale.
     */
    public static function canonical(string $locale): string
    {
        $url = app('laravellocalization')->getLocalizedURL($locale, null, [], true);
        if (!is_string($url)) {
            return url()->current();
        }

        $default = (string) config('app.fallback_locale');
        if ($locale !== $default || !config('laravellocalization.hideDefaultLocaleInURL')) {
            return $url;
        }

        $path = (string) (parse_url($url, PHP_URL_PATH) ?? '/');
        $path = (string) preg_replace('#^/' . preg_quote($default, '#') . '(?=/|$)#', '', $path);

        return self::withPath($url, $path === '' ? '/' : $path);
    }

    private static function withPath(string $url, string $path): string
    {
        $parts = parse_url($url);
        $out = ($parts['scheme'] ?? 'https') . '://' . ($parts['host'] ?? '');
        if (isset($parts['port'])) {
            $out .= ':' . $parts['port'];
        }
        $out .= $path;
        if (isset($parts['query']) && $parts['query'] !== '') {
            $out .= '?' . $parts['query'];
        }

        return $out;
    }
}
