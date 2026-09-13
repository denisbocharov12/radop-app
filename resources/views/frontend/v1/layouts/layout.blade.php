<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('frontend.v1.head.head')
{{-- Bottom padding on phones reserves room for the fixed tab bar. --}}
<body class="min-h-screen bg-white pb-[calc(3.5rem+env(safe-area-inset-bottom))] lg:pb-0">
@php($gtmId = config('analytics.gtm_container_id'))
@if(is_string($gtmId) && $gtmId !== '')
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id={{ $gtmId }}"
                      height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
@endif

<a href="#main" class="sf-sr-only focus:not-sr-only focus:absolute focus:left-4 focus:top-4 focus:z-modal focus:h-auto focus:w-auto focus:rounded-md focus:bg-brand-600 focus:px-4 focus:py-2 focus:text-white">
    {{ __('theme.navigation-menu') }}
</a>

@include('frontend.v1.chrome.topbar')
@include('frontend.v1.chrome.header')
@include('frontend.v1.chrome.nav')

<main id="main" class="min-h-[50vh]">
    <div class="sf-container">
        @include('frontend.v1.errors.errors')
    </div>

    {{--
        Pages migrated to the storefront design system declare
        @section('sf-page', 1) and lay out their own containers.
        Everything still on the legacy stylesheet keeps the Bootstrap
        `.container` wrapper it was written against.
    --}}
    @hasSection('sf-page')
        @yield('content')
    @else
        <div class="container theme-container-wrapper">
            @yield('content')
        </div>
    @endif
</main>

@include('frontend.v1.chrome.footer')
@include('frontend.v1.chrome.overlays')
@include('frontend.v1.scripts.scripts')
{{-- Components push their own behaviour here (catalogue toolbar, filters). --}}
@stack('scripts')
@cookieconsentview
</body>
</html>
