<header id="header">
    <section class="section-header" id="section-header">
        <div class="container">
            <div class="row row-main">
                <div class="header-logo col-auto col-sm-auto col-md-auto col-lg-auto col-xl-auto">
                    <a href="{{route('theme.home')}}" class="link-logo">
                        <img src="{{asset('/v1/frontend/assets')}}/images/logo.svg" alt="Radop Moldova" />
                    </a>
                </div>
                <div class="col-auto d-block d-md-none contact-info-mobile text-center">
                    <div class="phone-number">
                        <a href="tel:+37379782112">079 782 112</a>
                    </div>
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
                    <div class="wishlist-block icon-block d-none d-lg-block">
                        <a href="{{route('theme.wishlist.index')}}" class="wishlist icon-block-link">
                            <i class="icon-heart-radop"></i>
                        </a>
                    </div>
                    <div class="login-registration-block icon-block d-none d-lg-block">
                        <a
                                class="user icon-block-link"
                                data-fancybox
                                data-src="#loginModal"
                                href="javascript:;"
                        >
                            <i class="icon-user-radop"></i>
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
                            <i class="icon-shopping-cart"></i>
                            <div class="wrap-cart-block-info header-cart-widget">
                                <span class="summ">{{number_format(\Cart::session($sessionId)->getTotal(), 2, ',', '')}}</span> <span>{{__('theme.MDL')}}</span>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="language-switch-mobile col-auto d-flex d-lg-none">
                    <div class="language-switcher">
                        @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                            <a href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}"
                               class="lang-option @if(LaravelLocalization::getCurrentLocale() == $localeCode) active @endif">
                                {{ strtoupper($localeCode) }}
                            </a>
                        @endforeach
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
@include('frontend.v1.header.components.mobile-catalog')
