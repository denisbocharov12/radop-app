<!DOCTYPE html>
<html lang="{{ App::currentLocale() }}" class="js">
@include('user.v1.head.head')
<body>
@include('user.v1.header.header')
<main>
    @include('user.v1.errors.errors')
    @yield('content')
</main>
@include('user.v1.footer.footer')
@include('user.v1.scripts.scripts')
</body>


