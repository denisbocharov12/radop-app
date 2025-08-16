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
                <ul class="main-column-catalog__list column-style">
                    @if(!empty($themeParentCategories))
                        @foreach($themeParentCategories as $parentCategory)
                            <li class="main-column-catalog__item">
                                <a class="main-column-catalog__link catalog-category-link" @if(count($parentCategory->children) > 0) href="#" data-main-category="{{$parentCategory->id}}" @else href="{{route('theme.category.index', $parentCategory->onec_id)}}"  @endif>
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
                            <div class="column-catalog__item column-style" id="{{$parentCategory->id}}">
                                <h3 class="column-catalog__title">
                                    <span class="column-catalog__back catalog-back-arrow" title="Назад"></span>
                                    <span class="catalog-category-title">{{$parentCategory->name}}</span>
                                </h3>
                                <ul class="column-catalog__list drop-menu-list">
                                    <li>
                                        <a href="{{ route('theme.shop.catalog') }}" class="catalog-all-link" style="font-weight: bold; font-size: 18px;">{{ __('theme.all-brand-products') }}</a>
                                    </li>
                                    @foreach($parentCategory->children as $secondLevelCategory)
                                        <li class="drop-menu-list__item" style="margin-bottom: 10px;">
                                            <a href="{{ route('theme.category.index', $secondLevelCategory->onec_id) }}" class="drop-menu-list__link" style="font-weight: bold; font-size: 18px;">
                                                {{ $secondLevelCategory->name }}
                                            </a>
                                            @if(count($secondLevelCategory->children) > 0)
                                                <ul class="column-catalog__list drop-menu-list" style="padding-left: 15px; margin-top: 5px;">
                                                    @foreach($secondLevelCategory->children as $thirdLevelCategory)
                                                        <li class="drop-menu-list__item">
                                                            <a href="{{ route('theme.category.index', $thirdLevelCategory->onec_id) }}" class="drop-menu-list__link" style="font-weight: normal; font-size: 16px;">
                                                                {{ $thirdLevelCategory->name }}
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
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
        <a href="{{route('theme.home')}}" class="link-logo">
            <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="20" height="20" viewBox="0 0 50 50" color="#fff" stroke="white" fill="white">
                <path d="M 25 1.0507812 C 24.7825 1.0507812 24.565859 1.1197656 24.380859 1.2597656 L 1.3808594 19.210938 C 0.95085938 19.550938 0.8709375 20.179141 1.2109375 20.619141 C 1.5509375 21.049141 2.1791406 21.129062 2.6191406 20.789062 L 4 19.710938 L 4 46 C 4 46.55 4.45 47 5 47 L 19 47 L 19 29 L 31 29 L 31 47 L 45 47 C 45.55 47 46 46.55 46 46 L 46 19.710938 L 47.380859 20.789062 C 47.570859 20.929063 47.78 21 48 21 C 48.3 21 48.589063 20.869141 48.789062 20.619141 C 49.129063 20.179141 49.049141 19.550938 48.619141 19.210938 L 25.619141 1.2597656 C 25.434141 1.1197656 25.2175 1.0507812 25 1.0507812 z M 35 5 L 35 6.0507812 L 41 10.730469 L 41 5 L 35 5 z"></path>
            </svg>
        </a>
        <a href="{{route('theme.cart.index')}}" class="mobile-sticky-header__cart">
            <i class="icon-shopping-cart"></i>
            <span class="mobile-sticky-header__cart-sum" id="mobile-cart-info">
                {{number_format(\Cart::session(auth()->guard('user')->user()?->id ?? config('shopping_cart.default_session_id'))->getTotal(), 2, ',', '')}} {{__('theme.MDL')}}
            </span>
        </a>
        <a href="tel:+37379782112" class="mobile-sticky-header__phone">
            <svg width="25px" height="25px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M18.4 20.75H18.17C15.5788 20.4681 13.0893 19.5846 10.9 18.17C8.86618 16.8747 7.13938 15.1513 5.84 13.12C4.42216 10.925 3.53852 8.42823 3.26 5.83001C3.22816 5.52011 3.2596 5.20696 3.35243 4.90958C3.44525 4.6122 3.59752 4.33677 3.8 4.10001C3.99694 3.86008 4.24002 3.66211 4.51486 3.51782C4.78969 3.37354 5.09068 3.28587 5.4 3.26001H8C8.56312 3.26058 9.10747 3.46248 9.53476 3.82925C9.96205 4.19602 10.2441 4.70349 10.33 5.26001C10.425 5.97489 10.6028 6.67628 10.86 7.35001C11.0164 7.77339 11.0487 8.23264 10.9531 8.67375C10.8574 9.11485 10.6378 9.51947 10.32 9.84001L9.71 10.45C10.6704 11.9662 11.9587 13.2477 13.48 14.2L14.09 13.6C14.4105 13.2822 14.8152 13.0626 15.2563 12.9669C15.6974 12.8713 16.1566 12.9036 16.58 13.06C17.2545 13.3148 17.9556 13.4926 18.67 13.59C19.236 13.6751 19.7515 13.9638 20.1198 14.402C20.488 14.8403 20.6837 15.3978 20.67 15.97V18.37C20.67 18.9942 20.4227 19.593 19.9823 20.0353C19.5419 20.4776 18.9442 20.7274 18.32 20.73L18.4 20.75ZM8 4.75001H5.61C5.49265 4.75777 5.37809 4.78924 5.27325 4.84252C5.1684 4.8958 5.07545 4.96979 5 5.06001C4.92658 5.14452 4.871 5.24302 4.83663 5.34957C4.80226 5.45612 4.7898 5.56852 4.8 5.68001C5.04249 8.03679 5.83362 10.304 7.11 12.3C8.28664 14.1467 9.85332 15.7134 11.7 16.89C13.6973 18.1798 15.967 18.9878 18.33 19.25C18.4529 19.2569 18.5759 19.2383 18.6912 19.1953C18.8065 19.1522 18.9117 19.0857 19 19C19.1592 18.8368 19.2489 18.6181 19.25 18.39V16C19.2545 15.7896 19.1817 15.5848 19.0453 15.4244C18.9089 15.2641 18.7184 15.1593 18.51 15.13C17.6839 15.0189 16.8724 14.8177 16.09 14.53C15.9359 14.4724 15.7686 14.4596 15.6075 14.4933C15.4464 14.5269 15.2982 14.6055 15.18 14.72L14.18 15.72C14.0629 15.8342 13.912 15.9076 13.7499 15.9292C13.5877 15.9508 13.423 15.9195 13.28 15.84C11.1462 14.6342 9.37997 12.8715 8.17 10.74C8.08718 10.598 8.05402 10.4324 8.07575 10.2694C8.09748 10.1065 8.17286 9.95538 8.29 9.84001L9.29 8.84001C9.40468 8.72403 9.48357 8.57751 9.51726 8.41793C9.55095 8.25835 9.53802 8.09244 9.48 7.94001C9.19119 7.15799 8.98997 6.34637 8.88 5.52001C8.85519 5.30528 8.75133 5.10747 8.58865 4.96513C8.42597 4.82278 8.21613 4.7461 8 4.75001Z"/>
            </svg>
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
