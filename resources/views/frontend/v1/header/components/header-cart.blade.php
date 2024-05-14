<div class="cart-block icon-block mini-shopping-cart">
    <a href="#" class="cart icon-block-link">
        {{__('theme.cart')}}
        <i class="icon-cart-radop"></i>
        @php
            $sessionId = config('shopping_cart.default_session_id');

            if (auth()->guard('user')->user()) {
                $sessionId = auth()->guard('user')->user()->id;
            }
        @endphp
        <span class="count mini-cart-count">{{\Cart::session($sessionId)->getContent()->count()}}</span>
    </a>
    <div class="wrap-shopping-cart">
        <div class="contents-shopping-cart" id="cart-update">
            @include('frontend.v1.components.mini-cart')
        </div>
        <div class="bottom-shopping-cart">
            <a href="{{route('theme.shop.index')}}" class="btn-shopping-cart">{{__('theme.сontinue-shopping')}}</a>
            <a href="{{route('theme.cart.index')}}" class="btn-shopping-cart red">{{__('theme.place-order')}}</a>
        </div>
    </div>
</div>
