<div class="header-search header-with-menu col col-md col-xl col-lg">
    @include('frontend.v1.header.components.top-bar')
    <div class="wrap wrap-with-history" id="header-js-sticky">
        <div class="header-logo col-auto col-sm-auto col-md-auto col-lg-auto col-xl-auto" id="sticky-header-logo" style="display: none">
            <a href="{{route('theme.home')}}" class="link-logo">
                <img src="{{ asset('/v1/frontend/assets/images/logo.svg') }}" alt="Radop" style="height: 28px; width: auto; display: block; filter: brightness(0) invert(1);">
            </a>
        </div>
        <div class="btn-header-catalog-wrap">
            @php
                $mainMenu = app('App\Services\MenuRenderService')->getMenuData('main_menu');
            @endphp
            @if($mainMenu && $mainMenu->is_active && $mainMenu->rootItems->isNotEmpty())
                @renderMenu('main_menu')
            @else
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
            @endif
        </div>
        <div class="sticky-search-wrapper">
            <form action="{{route('theme.search.index')}}" method="GET" class="form-with-history">
                <input type="text" class="search search-sticky" name="search" value="{{ e((string) (request('search') ?? request('filter.search') ?? '')) }}" placeholder="{{__('theme.search-on-site')}}" autocomplete="off" />
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
{{-- Sticky-header scroll handling is owned by `initStickyHeader` in
     public/v1/frontend/assets/js/scripts.js — single source of truth. --}}
