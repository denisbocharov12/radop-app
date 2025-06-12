<div class="qty-add-to-cart">
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
            id="product-{{$product->conditions->id}}-qty"
            type="number"
            min="{{$product->conditions->min_order ?? 1}}"
            max="{{$product->conditions->stock}}"
            placeholder="{{$product->conditions->min_order ?? 1}}"
            value="{{$product->conditions->min_order ?? 1}}"
            step="{{$product->conditions->min_order ?? 1}}"
            name="product-{{$product->conditions->id}}-qty"
            data-product-id="{{$product->conditions->onec_id}}"
            data-price="@if($product->conditions->sale_price !== ''){{$product->conditions->sale_price}}@else{{$product->conditions->price}}@endif"
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
    <a href="#" data-id="{{$product->conditions->id}}" id="add-to-cart-{{$product->conditions->id}}" class="add_to_cart_btn">{{__('theme.add-to-cart')}}</a>
</div>
