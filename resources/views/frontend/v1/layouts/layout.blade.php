<!DOCTYPE html>
<html lang="{{ App::currentLocale() }}">
@include('frontend.v1.head.head')
<body>
@include('frontend.v1.search.search-overlay')
@include('frontend.v1.header.top-bar')
@include('frontend.v1.header.header-top')
@include('frontend.v1.header.header')
<main id="main">
    @include('frontend.v1.errors.errors')
    @yield('content')
</main>
@include('frontend.v1.footer.footer')
@include('frontend.v1.scripts.scripts')
</body>


