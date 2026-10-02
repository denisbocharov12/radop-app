<?php

declare(strict_types=1);

namespace App\Services\Sitemap;

use Mcamara\LaravelLocalization\LaravelLocalization;

final class LocalizedThemeUrlGenerator
{
    public function __construct(
        private readonly LaravelLocalization $localization,
    ) {
    }

    /**
     * @return list<string>
     */
    public function supportedLocaleKeys(): array
    {
        return array_keys($this->localization->getSupportedLocales());
    }

    public function absolute(string $locale, string $path): string
    {
        $base = rtrim((string) config('app.url'), '/');
        $defaultLocale = $this->localization->getDefaultLocale();
        $localeSegment = '';
        if (!$this->localization->hideDefaultLocaleInURL() || $locale !== $defaultLocale) {
            $localeSegment = '/' . $locale;
        }
        $normalizedPath = trim($path, '/');
        if ($normalizedPath === '') {
            return $localeSegment === '' ? $base . '/' : $base . $localeSegment;
        }

        return $base . $localeSegment . '/' . $normalizedPath;
    }
}
