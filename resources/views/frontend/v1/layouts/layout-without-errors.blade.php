<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('frontend.v1.head.head')
<body>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MB99NNLC"
                  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<div class="wrapper theme-wrapper">
    <div class="container theme-container-wrapper">
        @include('frontend.v1.search.search-overlay')
    </div>
    <div class="theme-wrapper-bg-white theme-wrapper-sticky">
        <div class="container theme-container-wrapper theme-container-wrapper-sticky">
            @include('frontend.v1.header.header-top')
        </div>
    </div>
    @include('frontend.v1.header.header')
    <div class="container theme-container-wrapper">
        <main id="main">
            @include('frontend.v1.errors.registration-errors')
            @yield('content')
        </main>
    </div>
    @include('frontend.v1.footer.footer')
    @include('frontend.v1.scripts.scripts')
</div>
@cookieconsentview
</body>
