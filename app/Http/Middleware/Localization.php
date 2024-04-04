<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

final class Localization
{
    private const X_LOCALIZATION_HEADER = 'x-localization';

    public function handle(Request $request, Closure $next): Response
    {
        $fallbackLocale = config('app.fallback_locale');
        $locale = $this->resolveLocaleFromRequest($request, $fallbackLocale);

        App::setLocale($locale);

        return $next($request);
    }

    private function resolveLocaleFromRequest(Request $request, string $fallbackLocale): string
    {
        if ($request->hasHeader(self::X_LOCALIZATION_HEADER)) {
            $locale = $request->header(self::X_LOCALIZATION_HEADER);

            return config("app.locales.{$locale}", $fallbackLocale);
        }

        return $fallbackLocale;
    }
}
