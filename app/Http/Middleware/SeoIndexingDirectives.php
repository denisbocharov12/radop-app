<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * When the current request carries non-canonical query parameters (sorting,
 * filters, UTM, etc.) share `$seoRobots = 'noindex, follow'` and a clean
 * `$seoCanonical` (URL without query string) with the views, so the head
 * partial can render the appropriate meta + canonical tags.
 *
 * Pagination (`page=`) is intentionally NOT treated as a noindex trigger.
 */
final class SeoIndexingDirectives
{
    /**
     * Query parameters whose presence makes the page a non-canonical duplicate.
     * Matched as PREFIX (so `filter[brand]`, `filter[price]`, `utm_source`,
     * `utm_campaign`, etc. all hit a single entry).
     */
    private const NOINDEX_PREFIXES = [
        'sort',
        'order',
        'perPage',
        'per_page',
        'filter',
        'price_min',
        'price_max',
        'brand',
        'color',
        'attribute',
        'utm_',
        'fbclid',
        'gclid',
        'yclid',
        'msclkid',
        'mc_eid',
        '_ga',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        // Only HTML page requests are relevant — skip API and AJAX.
        $isPageRequest = $request->isMethod('GET') && !$request->expectsJson();

        if ($isPageRequest) {
            $params = $request->query();
            if (is_array($params) && $params !== [] && $this->hasNoindexParam(array_keys($params))) {
                view()->share('seoRobots', 'noindex, follow');
                view()->share('seoCanonical', $request->url());
            }
        }

        return $next($request);
    }

    /**
     * @param list<int|string> $paramKeys
     */
    private function hasNoindexParam(array $paramKeys): bool
    {
        foreach ($paramKeys as $key) {
            $key = (string) $key;
            foreach (self::NOINDEX_PREFIXES as $prefix) {
                if (str_starts_with($key, $prefix)) {
                    return true;
                }
            }
        }

        return false;
    }
}
