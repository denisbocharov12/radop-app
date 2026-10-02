{{-- Push noindex + clean canonical into SEOMeta BEFORE SEOMeta::generate()
     so we don't emit duplicate <link rel="canonical"> tags. Variables come
     from App\Http\Middleware\SeoIndexingDirectives. --}}
@php
    if (isset($seoCanonical) && is_string($seoCanonical) && $seoCanonical !== '') {
        \Artesaos\SEOTools\Facades\SEOMeta::setCanonical($seoCanonical);
    }
    // Pages that set no title of their own fall back to the localized site name.
    // The site name is no longer appended to titles that controllers set.
    if (!\Artesaos\SEOTools\Facades\SEOMeta::getTitle()) {
        \Artesaos\SEOTools\Facades\SEOMeta::setTitle(trans('seo.title', [], app()->getLocale()), false);
    }
    if (isset($seoRobots) && is_string($seoRobots) && $seoRobots !== '') {
        \Artesaos\SEOTools\Facades\SEOMeta::setRobots($seoRobots);
    }
@endphp
