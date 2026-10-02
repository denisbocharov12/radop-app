<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Permanently redirects duplicate spellings of a page onto its canonical path,
 * in a single hop:
 *
 * - /index.php[/...]        -> / or /...
 * - /{default-locale}/...   -> /...   (the default locale is hidden in URLs)
 * - /path/                  -> /path  (the root stays "/")
 *
 * The package redirect filters cannot do this: laravellocalization.httpMethodsIgnored
 * contains GET, so they skip every page request.
 */
final class CanonicalPathRedirect
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!in_array($request->getMethod(), ['GET', 'HEAD'], true)) {
            return $next($request);
        }

        $original = (string) (parse_url($request->getRequestUri(), PHP_URL_PATH) ?? '/');
        $path = $original;

        if (preg_match('#^/index\.php(/.*)?$#', $path, $m) === 1) {
            $path = ($m[1] ?? '') !== '' ? $m[1] : '/';
        }

        $default = (string) config('app.fallback_locale');
        if ($default !== '' && config('laravellocalization.hideDefaultLocaleInURL')) {
            $path = (string) preg_replace('#^/' . preg_quote($default, '#') . '(?=/|$)#', '', $path);
            if ($path === '') {
                $path = '/';
            }
        }

        if ($path !== '/' && str_ends_with($path, '/')) {
            $path = rtrim($path, '/');
            if ($path === '') {
                $path = '/';
            }
        }

        if ($path === $original) {
            return $next($request);
        }

        $query = $request->getQueryString();

        return new RedirectResponse(
            $request->getSchemeAndHttpHost() . $path . ($query ? '?' . $query : ''),
            301
        );
    }
}
