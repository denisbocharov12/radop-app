{{--
    Same chrome as `layout.blade.php`; only the error partial differs.
    Kept as a separate file because the registration page renders field-level
    validation errors itself and would otherwise show them twice.
--}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('frontend.v1.head.head')
<body class="min-h-screen bg-white">
@php($gtmId = config('analytics.gtm_container_id'))
@if(is_string($gtmId) && $gtmId !== '')
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id={{ $gtmId }}"
                      height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
@endif

@include('frontend.v1.chrome.topbar')
@include('frontend.v1.chrome.header')

<main id="main" class="min-h-[50vh]">
    <div class="sf-container">
        @include('frontend.v1.errors.registration-errors')
    </div>

    @hasSection('sf-page')
        @yield('content')
    @else
        <div class="container theme-container-wrapper">
            @yield('content')
        </div>
    @endif
</main>

@include('frontend.v1.chrome.footer')
@include('frontend.v1.scripts.scripts')
@stack('scripts')
@cookieconsentview
</body>
</html>
