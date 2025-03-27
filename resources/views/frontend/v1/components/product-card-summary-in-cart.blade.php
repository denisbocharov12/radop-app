<div class="product-card-summary-in-cart" id="product-card-summary-in-cart-{{$product->id}}">
    <p>
        <span class="summary-title"><i class="icon-check"></i>{{__('theme.in-cart')}}</span>
        <span class="product-card-summary-cart-title" >
            @php
                                $sessionId = config('shopping_cart.default_session_id');

                                if (auth()->guard('user')->user()) {
                                    $sessionId = auth()->guard('user')->user()->id;
                                }

                                $item = \Cart::session($sessionId)->get($product->id);
            @endphp
            {{$item?->quantity ?? 0}}
        </span>
        {{__('theme.in_cart_unit')}}
    </p>
</div>
