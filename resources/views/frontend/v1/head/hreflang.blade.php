@php
    /** @var \Mcamara\LaravelLocalization\LaravelLocalization $localizer */
    $localizer = app('laravellocalization');
    // The default (hidden) locale must point at the unprefixed canonical URL, never a /ro/ duplicate.
    $roUrl = \App\Support\LocaleUrl::canonical('ro');
    $ruUrl = \App\Support\LocaleUrl::canonical('ru');
@endphp
<link rel="alternate" hreflang="ro-MD"    href="{{ $roUrl }}" />
<link rel="alternate" hreflang="ru-MD"    href="{{ $ruUrl }}" />
<link rel="alternate" hreflang="x-default" href="{{ $roUrl }}" />
