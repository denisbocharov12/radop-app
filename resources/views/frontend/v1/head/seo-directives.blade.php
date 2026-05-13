{{-- Push noindex + clean canonical into SEOMeta BEFORE SEOMeta::generate()
     so we don't emit duplicate <link rel="canonical"> tags. Variables come
     from App\Http\Middleware\SeoIndexingDirectives. --}}
@php
    if (isset($seoCanonical) && is_string($seoCanonical) && $seoCanonical !== '') {
        \Artesaos\SEOTools\Facades\SEOMeta::setCanonical($seoCanonical);
    }
    if (isset($seoRobots) && is_string($seoRobots) && $seoRobots !== '') {
        \Artesaos\SEOTools\Facades\SEOMeta::setRobots($seoRobots);
    }
@endphp
