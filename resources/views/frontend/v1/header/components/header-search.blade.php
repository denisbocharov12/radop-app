<div class="header-search header-with-menu col col-md col-xl col-lg">
    @include('frontend.v1.header.components.top-bar')
    <div class="wrap" id="header-js-sticky">
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
        <form action="{{route('theme.search.index')}}" method="GET">
            @csrf
            <input type="text" class="search" name="search" placeholder="{{__('theme.search-on-site')}}" />
            <button type="submit" class="btn-search"><i class="icon-search"></i></button>
        </form>
        <div id="sticky-cart-block" class="header-account" style="display: none;">
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
        var cartBlock = document.getElementById('sticky-cart-block');
        function toggleCartBlock() {
            if (sticky.classList.contains('header-js-sticky')) {
                cartBlock.style.display = 'block';
            } else {
                cartBlock.style.display = 'none';
            }
        }
        window.addEventListener('scroll', toggleCartBlock);
        toggleCartBlock();
    });
</script>
