<head>
    <script>window.dataLayer=window.dataLayer||[];</script>
    <meta charset="utf-8">
    {{-- `initial-scale=1` was missing, which is why the old storefront rendered
         zoomed-out on iOS and Android. --}}
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="theme-color" content="#0068a7">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="dns-prefetch" href="https://www.googletagmanager.com">
    <link rel="dns-prefetch" href="https://www.google-analytics.com">

    @include('frontend.v1.head.seo-directives')
    {!! SEOMeta::generate() !!}
    {!! OpenGraph::generate() !!}
    {!! Twitter::generate() !!}
    {!! JsonLd::generate() !!}
    @include('frontend.v1.head.hreflang')
    @include('frontend.v1.head.organization-schema')

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="google-site-verification" content="3My3vefe3bpPRhRn3Uc-1dyuMkVifBzg3frP8RzcBoM" />
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

    {{-- Four weights instead of the previous eighteen (ital × 9 weights): the
         design system only ever asks for 400/500/600/700. --}}
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap"
        rel="stylesheet"
    >

    {{--
        LEGACY STOREFRONT CSS — ~1.2 MB across eight files (Bootstrap,
        FontAwesome and its webfonts, the bespoke `radop` icon font, Select2,
        Slick, app.min.css, style.css).

        Pages converted to the design system declare `@section('sf-page')` and
        skip the lot; only the views still on the old markup (checkout and the
        account area) pay for it. Delete this block once those are converted.
    --}}
    @unless(View::hasSection('sf-page'))
        <link rel="stylesheet" href="{{ asset('/v1/frontend/assets') }}/libs/bootstrap/bootstrap.min.css">
        <link rel="stylesheet" href="{{ asset('/v1/frontend/assets') }}/libs/bootsrap-font/css/font-awesome.min.css">
        <link rel="stylesheet" href="{{ asset('/v1/frontend/assets') }}/font-icon/font/css/radop.css">
        <link rel="stylesheet" href="{{ asset('/v1/frontend/assets') }}/libs/select2/select2.min.css">
        <link rel="stylesheet" href="{{ asset('/v1/frontend/assets') }}/libs/slick/slick.css">
        <link rel="stylesheet" href="{{ asset('/v1/frontend/assets') }}/libs/slick/slick-theme.css">
        <link rel="stylesheet" href="{{ asset('/v1/frontend/assets') }}/css/app.min.css">
        <link rel="stylesheet" href="{{ asset('/v1/frontend/assets') }}/css/style.css?v1.3.99">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css">
    @endunless

    {{-- Toast notifications are still shared by both stacks. --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    {{-- Storefront v2 design system. Loaded last so its utilities win any
         specificity tie with the legacy sheets above. --}}
    @vite(['resources/css/storefront.css', 'resources/js/storefront.js'])

    {{-- Strings the Vue islands render, resolved server-side so the bundle
         carries no copy and no locale logic. --}}
    @php
        $sfBootstrap = [
            'locale' => app()->getLocale(),
            'currency' => __('theme.MDL'),
            'authenticated' => auth()->guard('user')->check(),
            /*
             * Localised endpoints. Hard-coded paths resolve to the default
             * locale, so on /ru pages the server would answer (and toast) in
             * Romanian — the legacy scripts avoided that by using route().
             */
            'routes' => [
                'cartAdd' => route('theme.product.store'),
                'cartUpdate' => route('theme.product.update'),
                'cartRemove' => route('theme.product.delete'),
                'cartSummary' => route('theme.sf.cart.summary'),
                'cart' => route('theme.cart.index'),
                'checkout' => route('theme.checkout.index'),
                'wishlistAdd' => route('theme.wishlist.store'),
                'wishlistRemove' => route('theme.wishlist.delete'),
                'productPreview' => route('theme.sf.product.preview', ['product' => '__ID__']),
                'searchHistory' => route('theme.search.history.get'),
                'searchSuggestions' => route('theme.search.suggestions.get'),
                'searchHistoryClear' => route('theme.search.history.clear'),
                'searchHistoryDelete' => route('theme.search.history.delete'),
            ],
            't' => [
                'search' => __('theme.search'),
                'searchHistory' => __('theme.search_history'),
                'clearAll' => __('theme.search_history_clear_all'),
                'viewAll' => __('theme.view-all'),
                'close' => __('theme.notification_close_btn_text'),
                'menuError' => __('theme.menu-load-error'),
                'addedToCart' => __('theme.sf-added-to-cart'),
                'goToCart' => __('theme.sf-go-to-cart'),
                'checkout' => __('theme.place-order'),
                'emptyCart' => __('theme.empty-cart'),
                'total' => __('theme.for-payment'),
                'minOrder' => __('theme.min_order_sum_warning_message'),
                'minOrderAddMore' => __('theme.min_order_add_more'),
                'code' => __('theme.code'),
                'inStock' => __('theme.in-stock'),
                'outOfStock' => __('theme.out-of-stock'),
                'addToCart' => __('theme.add-to-cart'),
                'inCart' => __('theme.in-cart'),
                'details' => __('theme.product-details'),
                'openProduct' => __('theme.sf-open-product'),
                'addToWishlist' => __('theme.add-to-wishlist'),
                'removeFromWishlist' => __('theme.remove-from-wishlist'),
                'package' => __('theme.package'),
                'packageUnit' => __('theme.package_unit'),
                'exportStarted' => __('theme.export-download-started'),
                'exportError' => __('theme.export-error'),
                'exportPersonalized' => __('theme.personalized-export-started'),
                'personalPrice' => __('theme.sf-personal-price'),
                'minOrder' => __('theme.package-min-to-order'),
                'unit' => __('theme.min_order_unit'),
                'lowStock' => __('theme.sf-low-stock'),
            ],
        ];
    @endphp
    <script>
        window.__SF__ = {!! json_encode($sfBootstrap, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP) !!};
    </script>

    @php($gtmId = config('analytics.gtm_container_id'))
    @if(is_string($gtmId) && $gtmId !== '')
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','{{ $gtmId }}');</script>
    @endif

    {{-- GA4. Was previously emitted *after* </head>, which is invalid markup;
         same property, same behaviour, just in a legal position now. --}}
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-713BYG9HR2"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'G-713BYG9HR2');
    </script>

    @cookieconsentscripts
    {{-- Recolour the cookie-consent dialog to the Radop brand (package default
         is #7959EF). Its stylesheet loads after this block with equal
         specificity, so !important is needed to win the default state. --}}
    <style>
        #cookies-policy .cookiesBtn__link { background: #0068a7 !important; border-color: #0068a7 !important; }
        #cookies-policy .cookiesBtn__link:focus,
        #cookies-policy .cookiesBtn__link:hover { background: #015589 !important; border-color: #015589 !important; opacity: 1 !important; }
        #cookies-policy .cookies__category input:checked + .cookies__box:after { background: #0068a7 !important; }
        #cookies-policy .cookies__details,
        #cookies-policy .cookies__details:focus,
        #cookies-policy .cookies__details:hover,
        #cookies-policy .cookies__intro a:focus,
        #cookies-policy .cookies__intro a:hover { color: #0068a7 !important; }
        /* Phones: sit above the fixed tab bar instead of covering it. */
        @media (max-width: 1023px) {
            #cookies-policy.cookies { bottom: calc(3.5rem + env(safe-area-inset-bottom)) !important; }
        }
    </style>

    @stack('head')
</head>
