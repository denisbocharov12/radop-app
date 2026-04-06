<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Radop - Магазин канцтоваров в Молдове">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Fav Icon  -->
    <link rel="shortcut icon" href="{{asset('favicon.ico')}}">
    <!-- Page Title  -->
    <title>Панель управления - Radop</title>
    <!-- StyleSheets  -->
    <link rel="stylesheet" href="{{asset('/v1/dashboard')}}/assets/css/dashlite.min.css?ver=3.0.1">
    <link rel="stylesheet" href="{{asset('/v1/dashboard')}}/assets/css/theme.css?ver=3.0.1">
    @yield('styles')
</head>
<style>
    @media (max-width: 575.98px) {
        .nk-block-tools-toggle .toggle-expand-content {
            left: 0;
            width: auto;
        }
    }
    .gap-1,
    .gap-2 {
        height: auto;!important;
    }
</style>
