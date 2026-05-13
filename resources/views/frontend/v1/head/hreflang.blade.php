@php
    /** @var \Mcamara\LaravelLocalization\LaravelLocalization $localizer */
    $localizer = app('laravellocalization');
    $roUrl = $localizer->getLocalizedURL('ro', null, [], true);
    $ruUrl = $localizer->getLocalizedURL('ru', null, [], true);
@endphp
<link rel="alternate" hreflang="ro-MD"    href="{{ $roUrl }}" />
<link rel="alternate" hreflang="ru-MD"    href="{{ $ruUrl }}" />
<link rel="alternate" hreflang="x-default" href="{{ $roUrl }}" />
