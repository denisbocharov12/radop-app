<div class="theme-navbar-menu navbar-menu">
    <div class="navbar-menu__container">
        <div class="navbar-menu__wrapper icon-block">
            <a class="navbar-menu__link navbar-menu__link_catalog catalog-btn theme-mobile-catalog-btn">
                <i class="icon-radop-bars"></i>
                <p>{{ __('theme.header-catalog-text') }}</p>
            </a>
            <a class="navbar-menu__link navbar-menu__link_search">
                <i class="icon-search"></i>
                <p>{{ __('theme.search_footer') }}</p>
            </a>
            <a
                    class="navbar-menu__link user icon-block-link"
                    data-fancybox
                    data-src="#loginModal"
                    href="javascript:;"
            >
                <i class="icon-user-radop"></i>
                <p>{{ __('theme.login_register') }}</p>
            </a>
            <a class="navbar-menu__link" href="{{route('theme.wishlist.index')}}">
                <i class="icon-heart-radop"></i>
                <p>{{ __('theme.wishlist') }}</p>
            </a>
            <a class="navbar-menu__link navbar-menu__link_other">
                <i class="icon-th-thumb-empty"></i>
                <p>{{ __('theme.other') }}</p>
            </a>
        </div>
    </div>
</div>
<div class="search-navbar">
    <div class="search-navbar-wrap">
        <form action="{{route('theme.search.index')}}" method="GET">
            @csrf
            <input type="text" class="catalog-navbar__search" name="search" placeholder="{{__('theme.search-on-site')}}">
            <button type="submit" class="btn-search"><i class="icon-search"></i></button>
        </form>
    </div>
</div>
<div class="other-navbar">
    <div class="other-navbar-wrap">
        <div class="other-navbar__category">
            <button type="button" class="other-navbar__category-btn">
                {{ __('theme.shop') }}
                <span class="other-navbar__arrow">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                        <path d="M6 9L12 15L18 9"
                              stroke="white"
                              stroke-width="2.5"
                              stroke-linecap="round"
                              stroke-linejoin="round"/>
                    </svg>
                </span>
            </button>
            <div class="other-navbar__submenu">
                <a href="{{route('theme.shop.catalog')}}" class="other-navbar__link">{{ __('theme.shop') }}</a>
                <a href="{{ route('theme.home') }}#popular-products-home-anchor" class="other-navbar__link">{{ __('theme.popular-products') }}</a>
                <a href="{{ route('theme.home') }}#new-products-home-anchor" class="other-navbar__link">{{ __('theme.new-products') }}</a>
                <a href="{{ route('theme.home') }}#discount-products-home-anchor" class="other-navbar__link">{{ __('theme.promotion') }}</a>
                <a href="{{ route('theme.home') }}#brands-home-anchor" class="other-navbar__link">{{ __('theme.home-brands') }}</a>
            </div>
        </div>
        <div class="other-navbar__category">
            <button type="button" class="other-navbar__category-btn">
                {{ __('theme.about-company') }}
                <span class="other-navbar__arrow">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                        <path d="M6 9L12 15L18 9"
                            stroke="white"
                            stroke-width="2.5"
                            stroke-linecap="round"
                            stroke-linejoin="round"/>
                    </svg>
                </span>
            </button>
            <div class="other-navbar__submenu">
                <a href="{{route('theme.contacts.index')}}" class="other-navbar__link">{{ __('theme.contact') }}</a>
                <a href="{{route('theme.delivery.index')}}" class="other-navbar__link">{{ __('theme.delivery') }}</a>
                <a href="#" class="other-navbar__link">{{ __('theme.news') }}</a>
                <a href="#" class="other-navbar__link">{{ __('theme.updates') }}</a>
            </div>
        </div>
        <div class="other-navbar__category">
            <button type="button" class="other-navbar__category-btn">
                {{ __('theme.information') }}
                <span class="other-navbar__arrow">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                        <path d="M6 9L12 15L18 9"
                              stroke="white"
                              stroke-width="2.5"
                              stroke-linecap="round"
                              stroke-linejoin="round"/>
                    </svg>
                </span>
            </button>
            <div class="other-navbar__submenu">
                <a href="{{route('theme.order-guide.index')}}" class="other-navbar__link">{{ __('theme.how-to-order') }}</a>
                <a href="{{route('theme.terms-and-conditions.index')}}" class="other-navbar__link">{{ __('theme.terms-of-use') }}</a>
                <a href="{{route('theme.privacy-policy.index')}}" class="other-navbar__link">{{ __('theme.privacy-policy') }}</a>
                <a href="{{route('theme.cookie.index')}}" class="other-navbar__link">{{ __('theme.cookie') }}</a>
                <a href="{{route('theme.return-rules.index')}}" class="other-navbar__link">{{ __('theme.return_and_exchange_products') }}</a>
            </div>
        </div>
    </div>
</div>
<div class="theme-catalog-navbar catalog-navbar">
    <div class="catalog-navbar__catalog">
        <div class="catalog theme-catalog-body">
            <div class="catalog__main-column main-column-catalog">
                <a href="{{ route('theme.shop.catalog') }}" class="catalog-all-link">Все товары</a>
                <ul class="main-column-catalog__list column-style">
                    @if(!empty($themeParentCategories))
                        @foreach($themeParentCategories as $parentCategory)
                            <li class="main-column-catalog__item">
                                <a class="main-column-catalog__link catalog-category-link _icon-women" @if(count($parentCategory->children) > 0) href="#" data-main-category="#{{$parentCategory->id}}" @else href="{{route('theme.category.index', $parentCategory->onec_id)}}"  @endif>
                                    {{$parentCategory->name}}
                                </a>
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>

            <div class="catalog__second-column column-catalog">
                @if(!empty($themeParentCategories))
                    @foreach($themeParentCategories as $parentCategory)
                        @if(count($parentCategory->children) > 0)
                            @php
                            if ($parentCategory->children->first()?->parent_id !== null) {
                                $parentCategoryPhp = \App\Models\Category::where('onec_id', $parentCategory->children->first()->parent_id)->first();
                            }
                            @endphp
                                <div class="column-catalog__item column-style" id="#{{$parentCategoryPhp->id}}">
                                    <h3 class="column-catalog__title">
                                        <span class="column-catalog__back catalog-back-arrow" title="Назад"></span>
                                        <span class="catalog-category-title">{{$parentCategoryPhp->name}}</span>
                                    </h3>
                                    <ul class="column-catalog__list drop-menu-list">
                                        @foreach($parentCategory->children as $children)
                                            <li class="drop-menu-list__item">
                                                <a class="drop-menu-list__link catalog-subcategory-link" @if(count($children->children) > 0) href="#" data-second-category="#{{$children->id}}" @else  href="{{route('theme.category.index', $children->onec_id)}}" @endif>{{$children->name}}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                        @endif
                    @endforeach
                @endif
            </div>

            <div class="catalog__third-column column-catalog">
                @if(!empty($themeParentCategories))
                    @foreach($themeParentCategories as $parentCategory)
                        @if(count($parentCategory->children) > 0)
                            @foreach($parentCategory->children as $parentCategory)
                                @php
                                    if ($parentCategory->children->first()?->parent_id !== null) {
                                        $parentCategoryPhp = \App\Models\Category::where('onec_id', $parentCategory->children->first()->parent_id)->first();
                                    }
                                @endphp
                                <div class="column-catalog__item column-style" id="#{{$parentCategoryPhp->id}}">
                                    <h3 class="column-catalog__title">
                                        <span class="column-catalog__back catalog-back-arrow" title="Назад"></span>
                                        <span class="catalog-category-title">{{$parentCategoryPhp->name}}</span>
                                    </h3>
                                    <ul class="column-catalog__list drop-menu-list">
                                        @foreach($parentCategory->children as $children)
                                            <li class="drop-menu-list__item">
                                                <a class="drop-menu-list__link catalog-subcategory-link" href="{{route('theme.category.index', $children->onec_id)}}">{{$children->name}}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endforeach
                        @endif
                    @endforeach
                @endif
            </div>

            <button class="catalog__close-btn _icon-close" type="button"></button>
        </div>
    </div>
</div>
<div class="mobile-sticky-header d-md-none">
    <div class="mobile-sticky-header__inner">
        <a href="tel:+37379782112" class="mobile-sticky-header__phone">
            <i class="icon-phone"></i> +373 79 78 21 12
        </a>
        <a href="{{route('theme.cart.index')}}" class="mobile-sticky-header__cart">
            <i class="icon-shopping-cart"></i>
            <span class="mobile-sticky-header__cart-sum" id="mobile-cart-info">
                {{number_format(\Cart::session(auth()->guard('user')->user()?->id ?? config('shopping_cart.default_session_id'))->getTotal(), 2, ',', '')}} {{__('theme.MDL')}}
            </span>
        </a>
    </div>
</div>
<script>
    document.querySelectorAll('.other-navbar__category-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            setTimeout(function() {
                var submenu = btn.parentElement.querySelector('.other-navbar__submenu');
                var arrow = btn.querySelector('.other-navbar__arrow');
                var isOpen = submenu.classList.contains('open');
                document.querySelectorAll('.other-navbar__submenu').forEach(function(el) { el.classList.remove('open'); });
                document.querySelectorAll('.other-navbar__category-btn').forEach(function(b) { b.classList.remove('open'); });
                if (!isOpen) {
                    submenu.classList.add('open');
                    btn.classList.add('open');
                }
            }, 800);
        });
    });
</script>
