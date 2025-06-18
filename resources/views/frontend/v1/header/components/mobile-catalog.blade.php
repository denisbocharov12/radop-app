<div class="theme-navbar-menu navbar-menu">
    <div class="navbar-menu__container">
        <div class="navbar-menu__wrapper icon-block">
            <a class="navbar-menu__link navbar-menu__link_catalog catalog-btn theme-mobile-catalog-btn">
                <i class="icon-radop-bars"></i>
                <p>{{ __('theme.header-catalog-text') }}</p>
            </a>
            <a class="navbar-menu__link" href="#">
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
            <a class="navbar-menu__link" href="#">
                <i class="icon-th-thumb-empty"></i>
                <p>{{ __('theme.other') }}</p>
            </a>
        </div>
    </div>
</div>
<div class="theme-catalog-navbar catalog-navbar">
    <form action="{{route('theme.search.index')}}" method="GET">
        @csrf
        <input type="text" class="catalog-navbar__search" name="search" placeholder="{{__('theme.search-on-site')}}">
    </form>
    <div class="catalog-navbar__catalog">
        <div class="catalog theme-catalog-body">
            <div class="catalog__main-column main-column-catalog">
                <ul class="main-column-catalog__list column-style">
                    @if(!empty($themeParentCategories))
                        @foreach($themeParentCategories as $parentCategory)
                            <li class="main-column-catalog__item">
                                <a class="main-column-catalog__link _icon-women" @if(count($parentCategory->children) > 0) href="#" data-main-category="#{{$parentCategory->id}}" @else href="{{route('theme.category.index', $parentCategory->onec_id)}}"  @endif>
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
                                        <span class="column-catalog__back _icon-arrowslider">{{__('theme.back_btn_text')}}</span>
                                        {{$parentCategoryPhp->name}}
                                    </h3>
                                    <ul class="column-catalog__list drop-menu-list">
                                        @foreach($parentCategory->children as $children)
                                            <li class="drop-menu-list__item">
                                                <a class="drop-menu-list__link" @if(count($children->children) > 0) href="#" data-second-category="#{{$children->id}}" @else  href="{{route('theme.category.index', $children->onec_id)}}" @endif>{{$children->name}}</a>
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
                                        <span class="column-catalog__back _icon-arrowslider">{{__('theme.back_btn_text')}}</span>
                                        {{$parentCategoryPhp->name}}
                                    </h3>
                                    <ul class="column-catalog__list drop-menu-list">
                                        @foreach($parentCategory->children as $children)
                                            <li class="drop-menu-list__item">
                                                <a class="drop-menu-list__link" href="{{route('theme.category.index', $children->onec_id)}}">{{$children->name}}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endforeach
                        @endif
                    @endforeach
                @endif
                <div class="column-catalog__item column-style" id="#skirts">
                    <h3 class="column-catalog__title">
                        <span class="column-catalog__back _icon-arrowslider">{{__('theme.back_btn_text')}}</span> Skirts
                    </h3>
                    <ul class="column-catalog__list drop-menu-list">
                        <li class="drop-menu-list__item">
                            <a class="drop-menu-list__link" href="#">Jeans</a>
                        </li>
                        <li class="drop-menu-list__item">
                            <a class="drop-menu-list__link" href="#">Top</a>
                        </li>
                        <li class="drop-menu-list__item">
                            <a class="drop-menu-list__link" href="#">Pants</a>
                        </li>
                        <li class="drop-menu-list__item">
                            <a class="drop-menu-list__link" href="#">Lingerie</a>
                        </li>
                        <li class="drop-menu-list__item">
                            <a class="drop-menu-list__link" href="#">For mama</a>
                        </li>
                        <li class="drop-menu-list__item">
                            <a class="drop-menu-list__link" href="#">Dress</a>
                        </li>
                        <li class="drop-menu-list__item">
                            <a class="drop-menu-list__link" href="#">Wedding</a>
                        </li>
                        <li class="drop-menu-list__item">
                            <a class="drop-menu-list__link" href="#">Clothes for home</a>
                        </li>
                        <li class="drop-menu-list__item">
                            <a class="drop-menu-list__link" href="#">Hoodie</a>
                        </li>
                        <li class="drop-menu-list__item">
                            <a class="drop-menu-list__link" href="#">Leggings</a>
                        </li>
                        <li class="drop-menu-list__item">
                            <a class="drop-menu-list__link" href="#">Office</a>
                        </li>
                    </ul>
                </div>
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
            <span class="mobile-sticky-header__cart-sum">
                {{number_format(\Cart::session(auth()->guard('user')->user()?->id ?? config('shopping_cart.default_session_id'))->getTotal(), 2, ',', '')}} {{__('theme.MDL')}}
            </span>
        </a>
    </div>
</div>
