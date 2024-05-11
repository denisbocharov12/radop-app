<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="js">
@include('v1.head.head')
<body class="nk-body bg-lighter npc-general has-sidebar ">
<div class="nk-app-root">
    <!-- main @s -->
    <div class="nk-main ">
        @include('v1.sidebar.sidebar')
        <!-- wrap @s -->
        <div class="nk-wrap ">
            <!-- main header @s -->
            @include('v1.header.header')
            <!-- main header @e -->
            <!-- content @s -->
            @yield('content')
            <!-- content @e -->
            @include('v1.footer.footer')
        </div>
        <!-- wrap @e -->
    </div>
    <!-- main @e -->
</div>
<!-- modals -->
@yield('modals')
<!-- modals -->>
<!-- JavaScript -->
@include('v1.scripts.scripts')
</body>


