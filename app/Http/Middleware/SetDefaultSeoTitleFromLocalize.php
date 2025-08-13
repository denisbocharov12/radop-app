<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Artesaos\SEOTools\Facades\SEOMeta;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

final class SetDefaultSeoTitleFromLocalize
{
    public function handle(Request $request, Closure $next)
    {
        SEOMeta::setTitleDefault(trans('seo.title', [], app()->getLocale()));

        return $next($request);
    }
}
