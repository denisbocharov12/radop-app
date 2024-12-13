<div class="qty-add-to-cart qty-add-to-cart-product-card">
    <div class="sc-product-qty qty-block">
        <div class="input-group-btn">
            <button
                onclick="this.parentNode.parentNode.querySelector('input[type=number]').stepDown()"
                class="sc-product-decrement btn-quantity-product minus"
                type="button"
                id="button-minus"
            >
                -
            </button>
        </div>
        <input
            id="product-{{$product->id}}-qty"
            type="number"
            min="1"
            max="{{$product->stock}}"
            placeholder="1"
            value="1"
            name="product-{{$product->id}}-qty"
            data-product-id="{{$product->onec_id}}"
            data-price="@if($product->sale_price !== ''){{$product->sale_price}}@else{{$product->price}}@endif"
            class="product-qty-item"
        />
        <div class="input-group-btn">
            <button
                onclick="this.parentNode.parentNode.querySelector('input[type=number]').stepUp()"
                class="sc-product-increment btn-quantity-product plus"
                type="button"
                id="button-plus"
            >
                +
            </button>
        </div>
    </div>
    <a href="#" data-id="{{$product->id}}" id="add-to-cart-{{$product->id}}" class="add_to_cart_btn">{{__('theme.add-to-cart')}}</a>
</div>
