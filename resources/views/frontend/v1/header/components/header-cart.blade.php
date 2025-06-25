<div class="cart-block icon-block mini-shopping-cart">
    <a href="{{route('theme.cart.index')}}" class="cart icon-block-link">
        @php
            $sessionId = config('shopping_cart.default_session_id');

            if (auth()->guard('user')->user()) {
                $sessionId = auth()->guard('user')->user()->id;
            }

            /** @var \Darryldecode\Cart\CartCollection $cartContent */
            /** @var \Darryldecode\Cart\Cart $item */
            $total = 0;
            $cartContent = \Cart::session($sessionId)->getContent();
            foreach($cartContent as $item) {
                $total += \App\Helpers\PriceHelper::roundPrice($item->price) * $item->quantity;
            }
        @endphp
        <i class="icon-shopping-cart"></i>
        <div class="wrap-cart-block-info header-cart-widget">
            <span class="count">{{\Cart::session($sessionId)->getContent()->count()}}</span> <span>{{__('theme.product')}}</span>
            <span>/</span>
            <span class="summ">{{ number_format($total, 2, ',', '') }}</span> <span>{{__('theme.MDL')}}</span>
        </div>
    </a>
    <div class="wrap-shopping-cart">
        <div class="contents-shopping-cart cart-update">
            @include('frontend.v1.components.mini-cart')
        </div>
    </div>
</div>
