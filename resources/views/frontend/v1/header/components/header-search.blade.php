<div class="header-search header-with-menu col col-md col-xl col-lg">
    @include('frontend.v1.header.components.top-bar')
    <div class="wrap wrap-with-history" id="header-js-sticky">
        <div class="header-logo col-auto col-sm-auto col-md-auto col-lg-auto col-xl-auto" id="sticky-header-logo" style="display: none">
            <a href="{{route('theme.home')}}" class="link-logo">
                <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="20" height="20" viewBox="0 0 50 50" color="#fff" stroke="white" fill="white">
                    <path d="M 25 1.0507812 C 24.7825 1.0507812 24.565859 1.1197656 24.380859 1.2597656 L 1.3808594 19.210938 C 0.95085938 19.550938 0.8709375 20.179141 1.2109375 20.619141 C 1.5509375 21.049141 2.1791406 21.129062 2.6191406 20.789062 L 4 19.710938 L 4 46 C 4 46.55 4.45 47 5 47 L 19 47 L 19 29 L 31 29 L 31 47 L 45 47 C 45.55 47 46 46.55 46 46 L 46 19.710938 L 47.380859 20.789062 C 47.570859 20.929063 47.78 21 48 21 C 48.3 21 48.589063 20.869141 48.789062 20.619141 C 49.129063 20.179141 49.049141 19.550938 48.619141 19.210938 L 25.619141 1.2597656 C 25.434141 1.1197656 25.2175 1.0507812 25 1.0507812 z M 35 5 L 35 6.0507812 L 41 10.730469 L 41 5 L 35 5 z"></path>
                </svg>
            </a>
        </div>
        <div class="btn-header-catalog-wrap">
            <button id="btn-header-catalog" class="btn-header-catalog">
                <span class="animated-burger-icon"></span>
                <span class="btn-header-catalog-text">{{__('theme.header-catalog-text')}}</span>
            </button>
            <div class="row row-menu row-header-catalog row-header-catalog-wrap">
                <div class="header-catalog" id="header-catalog-action">
                    <div class="row row-header-catalog">
                        @if(!empty($themeParentCategories))
                            @foreach($themeParentCategories->sortBy('catalog_order') as $parentCategory)
                                @include('frontend.v1.header.components.header-catalog-item', $parentCategory)
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="sticky-search-wrapper">
            <form action="{{route('theme.search.index')}}" method="GET" class="form-with-history">
                <input type="text" class="search search-sticky" name="search" placeholder="{{__('theme.search-on-site')}}" autocomplete="off" />
                <button type="submit" class="btn-search"><i class="icon-search"></i></button>
            </form>
            <div class="search-history-dropdown search-history-sticky" id="search-history-dropdown-sticky" style="display: none;">
                <div class="search-history-header">
                    <span class="search-history-title" data-history-title="{{__('theme.search_history')}}" data-suggestions-title="{{__('theme.search_suggestions')}}">{{__('theme.search_history')}}</span>
                    <button type="button" class="search-history-clear" id="search-history-clear-sticky" data-empty-text="{{__('theme.search_history_empty')}}">
                        <i class="icon-trash"></i> {{__('theme.search_history_clear_all')}}
                    </button>
                </div>
                <div class="search-history-list" id="search-history-list-sticky"></div>
            </div>
        </div>
        <div id="sticky-account-blocks" class="header-account" style="display: none;">
            <div class="wishlist-block icon-block">
                <a href="{{route('theme.wishlist.index')}}" class="wishlist icon-block-link">
                    <i class="icon-heart-radop"><span class="wishlist_count" id="wishlist_count_sticky" @if(app('wishlist')->getContent()->count() == 0) style="display:none"@endif>{{app('wishlist')->getContent()->count()}}</span></i>
                </a>
            </div>
            <div class="login-registration-block icon-block">
                @php
                    $user = Auth::guard('user')->user()
                @endphp

                @if($user)
                    <a
                        class="icon-block-link"
                        href="{{route('theme.user.orders.index')}}"
                    >
                        <span class="theme-text-sp-lg">
                            @if($user->type->key_name === "fiz")
                                {{$user->profile->first_name . ' ' . $user->profile->last_name}}
                            @else
                                {{$user->profile->organization_name}}
                            @endif
                        </span>
                        <i class="icon-user-radop"></i>
                    </a>
                    <div class="account-dropdown-menu">
                        <ul class="account-dropdown-list">
                            <li class="account-dropdown-item">
                                <a class="account-dropdown-link" href="{{route('theme.user.orders.index')}}">
                                    <i class="icon-your-order"></i>{{__('theme.my-orders')}}
                                </a>
                            </li>
                            @if($user->type->key_name === 'iur')
                                <li class="account-dropdown-item">
                                    <a class="account-dropdown-link" href="{{route('theme.user.filial.index')}}">
                                        <i class="icon-building"></i>{{__('theme.filials')}}
                                    </a>
                                </li>
                            @endif
                            <li class="account-dropdown-item">
                                <a class="account-dropdown-link" href="{{route('theme.user.account.index')}}">
                                    <i class="icon-account"></i>{{__('theme.account')}}
                                </a>
                            </li>
                            <li class="account-dropdown-item">
                                <a class="account-dropdown-link" href="{{route('theme.user.logout')}}">
                                    <i class="icon-user"></i>{{__('theme.logout')}}
                                </a>
                            </li>
                        </ul>
                    </div>
                @else
                    <a
                        class="user icon-block-link"
                        data-fancybox
                        data-src="#loginModal"
                        href="javascript:;"
                    >
                        <span class="theme-text-sp">
                           {{__('theme.login-registration')}}
                        </span>
                        <i class="icon-user-radop"></i>
                    </a>
                @endif
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
                        <span class="count">{{\Cart::session($sessionId)->getContent()->count()}}</span> <span>{{__('theme.product')}}</span>
                        <span>/</span>
                        <span class="summ">{{number_format(\Cart::session($sessionId)->getTotal(), 2, ',', '')}}</span> <span>{{__('theme.MDL')}}</span>
                    </div>
                </a>
                <div class="wrap-shopping-cart">
                    <div class="contents-shopping-cart cart-update">
                        @include('frontend.v1.components.mini-cart-sticky')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var sticky = document.getElementById('header-js-sticky');
        var accountBlocks = document.getElementById('sticky-account-blocks');
        var logo = document.getElementById("sticky-header-logo");
        function toggleStickyBlocks() {
            if (sticky.classList.contains('header-js-sticky')) {
                accountBlocks.style.display = 'flex';
                logo.style.display = 'block';
            } else {
                accountBlocks.style.display = 'none';
                logo.style.display = 'none';
            }
        }
        window.addEventListener('scroll', toggleStickyBlocks);
        toggleStickyBlocks();
    });
</script>
