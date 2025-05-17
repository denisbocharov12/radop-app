<div class="theme-navbar-menu navbar-menu">
    <div class="navbar-menu__container">
        <div class="navbar-menu__wrapper">
            <a class="navbar-menu__link navbar-menu__link_catalog catalog-btn theme-mobile-catalog-btn">
{{--                <span class="animated-burger-icon"></span>--}}
                <i class="icon-radop-bars"></i>
            </a>
            <a class="navbar-menu__link" href="{{route('theme.cart.index')}}"><i class="icon-shopping-cart"></i></a>
            <a class="navbar-menu__link" href="{{route('theme.wishlist.index')}}"><i class="icon-heart-radop"></i></a>
            <a class="navbar-menu__link" href="#"><i class="icon-user-radop"></i></a>
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
