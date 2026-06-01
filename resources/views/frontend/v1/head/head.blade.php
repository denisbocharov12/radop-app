<head>
    <script>window.dataLayer=window.dataLayer||[];</script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
    <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>
    <link rel="dns-prefetch" href="https://www.googletagmanager.com">
    <link rel="dns-prefetch" href="https://www.google-analytics.com">
    @include('frontend.v1.head.seo-directives')
    {!! SEOMeta::generate() !!}
    {!! OpenGraph::generate() !!}
    {!! Twitter::generate() !!}
    {!! JsonLd::generate() !!}
    @include('frontend.v1.head.hreflang')
    @include('frontend.v1.head.organization-schema')
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- CSRF Token -->
    <meta name="google-site-verification" content="3My3vefe3bpPRhRn3Uc-1dyuMkVifBzg3frP8RzcBoM" />
    <link rel="shortcut icon" href="{{asset('favicon.ico')}}">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('/v1/frontend/assets')}}/libs/bootstrap/bootstrap.min.css">
    <!-- FontAwesome -->
    <link href="{{asset('/v1/frontend/assets')}}/libs/bootsrap-font/css/font-awesome.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <!-- End  FontAwesome-->
    <!-- Font-icon -->
    <link rel="stylesheet" href="{{asset('/v1/frontend/assets')}}/font-icon/font/css/radop.css" />
    <!-- End Font-icon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />
    <link rel="stylesheet" href="{{asset('/v1/frontend/assets')}}/libs/select2/select2.min.css" />
    <!-- Slick Slider -->
    <link rel="stylesheet" href="{{asset('/v1/frontend/assets')}}/libs/slick/slick-theme.css" />
    <link rel="stylesheet" href="{{asset('/v1/frontend/assets')}}/libs/slick/slick.css" />
    <!-- End Slick Slider -->
    <link rel="stylesheet" href="{{asset('/v1/frontend/assets')}}/css/app.min.css" />
    <link rel="stylesheet" href="{{asset('/v1/frontend/assets')}}/css/style.css?v1.3.6" />
    <link rel="stylesheet" href="{{asset('/v1/frontend/assets')}}/css/mega-menu.css?v1.3.4" />
    @php($gtmId = config('analytics.gtm_container_id'))
    @if(is_string($gtmId) && $gtmId !== '')
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','{{ $gtmId }}');</script>
    @endif
</head>
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-713BYG9HR2"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-713BYG9HR2');
</script>
