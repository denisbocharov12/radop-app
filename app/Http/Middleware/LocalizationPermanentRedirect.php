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
 *
 * Only the filter's own redirect is promoted. When no locale redirect is
 * needed the parent passes the request on and returns the application's
 * response — promoting that as well turned every ordinary 302 into a 301:
 * a guest opening /checkout was sent "permanently" to the home page, and the
 * browser kept replaying that cached redirect after the visitor signed in.
 */
final class LocalizationPermanentRedirect extends LaravelLocalizationRedirectFilter
{
    public function handle($request, Closure $next): Response
    {
        $reachedApplication = false;

        $response = parent::handle($request, function ($request) use ($next, &$reachedApplication) {
            $reachedApplication = true;

            return $next($request);
        });

        if (! $reachedApplication
            && $response instanceof RedirectResponse
            && $response->getStatusCode() === 302) {
            $response->setStatusCode(301);
        }

        return $response;
    }
}
