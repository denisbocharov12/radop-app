<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('frontend.v1.head.head')
<body>
<div class="wrapper theme-wrapper">
    <div class="container theme-container-wrapper">
    @include('frontend.v1.search.search-overlay')
    @include('frontend.v1.header.top-bar')
    @include('frontend.v1.header.header-top')
    </div>
    @include('frontend.v1.header.header')
    <div class="container theme-container-wrapper">
        <main id="main">
            @include('frontend.v1.errors.errors')
            @yield('content')
        </main>
    </div>
    @include('frontend.v1.footer.footer')
    @include('frontend.v1.scripts.scripts')
</div>
</body>


