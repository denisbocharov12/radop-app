<header id="header">
    <section class="section-header" id="section-header">
        <div class="container">
            <div class="row row-main">
                <div class="header-logo col-auto col-sm-auto col-md-auto col-lg-auto col-xl-auto">
                    <a href="{{route('theme.home')}}" class="link-logo">
                        <img src="{{asset('/v1/frontend/assets')}}/images/logo.svg" alt="Radop Moldova" />
                    </a>
                </div>
                <div class="header-menu">
                    <div class="header-main-menu">
                        <ul class="menu w-100 justify-content-center">
                            @if(!empty($themeParentCategories))
                                @foreach($themeParentCategories as $parentCategory)
                                    @include('frontend.v1.header.components.header-menu-item', $parentCategory)
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
                <div class="header-search col col-md col-xl col-lg">
                    <div class="wrap">
                        <form action="{{route('theme.search.index')}}" method="GET">
                            @csrf
                            <input type="text" class="search" name="search" placeholder="{{__('theme.search-on-site')}}" />
                            <button type="submit" class="btn-search"><i class="icon-search"></i></button>
                        </form>
                    </div>
                </div>
                <div class="header-account header-account-responsive col-auto col-sm-auto col-md-auto col-lg-auto">
                    <div class="login-registration-block icon-block">
                        <a
                            class="user icon-block-link"
                            data-fancybox
                            data-src="#loginModal"
                            href="javascript:;"
                        >
                            <i class="icon-user-radop"></i>
                        </a>
                    </div>
                    <div class="wishlist-block icon-block">
                        <a href="{{route('theme.wishlist.index')}}" class="wishlist icon-block-link">
                            <i class="icon-heart-radop"></i>
                        </a>
                    </div>
                    <div class="cart-block icon-block mini-shopping-cart">
                        <a href="{{route('theme.cart.index')}}" class="cart icon-block-link">
                            @php
                                $sessionId = config('shopping_cart.default_session_id');

                                if (auth()->guard('user')->user()) {
                                    $sessionId = auth()->guard('user')->user()->id;
                                }
                            @endphp
                            <div class="wrap-cart-block-info header-cart-widget">
                                <span class="summ">{{number_format(\Cart::session($sessionId)->getTotal(), 2, ',', '')}}</span> <span>{{__('theme.MDL')}}</span>
                            </div>
                            <i class="icon-shopping-cart"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="row row-main row-mobile-search">
                <div class="header-search header-mobile-search col col-md col-xl col-lg">
                    <div class="wrap">
                        <form action="{{route('theme.search.index')}}" method="GET">
                            @csrf
                            <input type="text" class="search" name="search" placeholder="{{__('theme.search-on-site')}}" />
                            <button type="submit" class="btn-search"><i class="icon-search"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</header>
{{--<div class="theme-navbar-menu navbar-menu">--}}
{{--    <div class="navbar-menu__container">--}}
{{--        <div class="navbar-menu__wrapper">--}}
{{--            <a class="navbar-menu__link navbar-menu__link_catalog"><span class="navbar-menu__icon _icon-catalog-search"></span></a>--}}
{{--            <a class="navbar-menu__link" href="#"><span class="navbar-menu__icon _icon-cart"></span></a>--}}
{{--            <a class="navbar-menu__link" href="#"><span class="navbar-menu__icon _icon-favorite"></span></a>--}}
{{--            <a class="navbar-menu__link" href="#"><span class="navbar-menu__icon _icon-user"></span></a>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}
{{--<div class="theme-navbar-menu catalog-navbar">--}}
{{--    <div class="catalog-navbar__search">Search...</div>--}}
{{--    <div class="catalog-navbar__catalog"></div>--}}
{{--</div>--}}
{{--<div class="theme-navbar-menu search-menu-navbar">--}}
{{--    <div class="search-menu-navbar__wrapper">--}}
{{--        <div class="search-menu-navbar__search">--}}
{{--            <button class="search-menu-navbar__close">Отмена</button>--}}
{{--        </div>--}}
{{--        <ul class="search-menu-navbar__list">--}}
{{--            <li class="search-menu-navbar__item">--}}
{{--                <a class="search-menu-navbar__link _icon-search" href="#">jeans</a>--}}
{{--            </li>--}}
{{--            <li class="search-menu-navbar__item">--}}
{{--                <a class="search-menu-navbar__link _icon-search" href="#">top</a>--}}
{{--            </li>--}}
{{--            <li class="search-menu-navbar__item">--}}
{{--                <a class="search-menu-navbar__link _icon-search" href="#">pants</a>--}}
{{--            </li>--}}
{{--            <li class="search-menu-navbar__item">--}}
{{--                <a class="search-menu-navbar__link _icon-search" href="#">lingerie</a>--}}
{{--            </li>--}}
{{--            <li class="search-menu-navbar__item">--}}
{{--                <a class="search-menu-navbar__link _icon-search" href="#">dress</a>--}}
{{--            </li>--}}

{{--            <li class="search-menu-navbar__item">--}}
{{--                <a class="search-menu-navbar__link _icon-search" href="#">top</a>--}}
{{--            </li>--}}
{{--            <li class="search-menu-navbar__item">--}}
{{--                <a class="search-menu-navbar__link _icon-search" href="#">pants</a>--}}
{{--            </li>--}}
{{--            <li class="search-menu-navbar__item">--}}
{{--                <a class="search-menu-navbar__link _icon-search" href="#">lingerie</a>--}}
{{--            </li>--}}
{{--            <li class="search-menu-navbar__item">--}}
{{--                <a class="search-menu-navbar__link _icon-search" href="#">dress</a>--}}
{{--            </li>--}}
{{--        </ul>--}}
{{--    </div>--}}
{{--</div>--}}
