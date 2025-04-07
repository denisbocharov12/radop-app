<div class="product-card-summary-in-cart" id="product-card-summary-in-cart-{{$product->id}}">
    @if(\Cart::session($sessionId)->get($product->id) !== null)
        <p>
            <span class="summary-title"><i class="icon-check"></i>{{__('theme.in-cart')}}</span>
            <span class="product-card-summary-cart-title" >
            {{$item?->quantity ?? 0}}
        </span>
            {{__('theme.in_cart_unit')}}
        </p>
    @endif
</div>
