<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter;
use Symfony\Component\HttpFoundation\Response;

/**
 * Promote the bundled LaravelLocalizationRedirectFilter response from 302 to 301
 * so that requests to hidden-default-locale prefixed URLs (e.g. `/ro/*` when
 * Romanian is the default) consolidate cleanly onto their canonical
 * non-prefixed counterparts for search engines.
 */
final class LocalizationPermanentRedirect extends LaravelLocalizationRedirectFilter
{
    public function handle($request, Closure $next): Response
    {
        $response = parent::handle($request, $next);

        if ($response instanceof RedirectResponse && $response->getStatusCode() === 302) {
            $response->setStatusCode(301);
        }

        return $response;
    }
}
