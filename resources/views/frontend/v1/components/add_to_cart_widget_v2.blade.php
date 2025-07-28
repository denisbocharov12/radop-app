@php
    $package = isset($product->packages->where('order_status', true)->first()->value) ? $product->packages->sortBy('value')->first()->value : 1;
@endphp
<div class="qty-add-to-cart qty-add-to-cart-product-card">
    <div class="sc-product-qty qty-block">
        <div class="input-group-btn">
                    <button
            class="sc-product-decrement btn-quantity-product minus"
            type="button"
            id="button-minus"
        >
            -
        </button>
        </div>
        <input
{{--            id="product-{{$product->id}}-qty"--}}
            type="number"
            min="{{$product->min_order ?? 1}}"
            max="{{$product->stock}}"
            placeholder="{{$package}}"
            value="{{$product->min_order ?? 1}}"
            step="{{$product->min_order ?? 1}}"
            name="product-{{$product->id}}-qty"
            data-product-id="{{$product->onec_id}}"
            data-price="{{\App\Services\Theme\Product\ThemeProductManager::getProductTotalSum($product)}}"
            data-package="1"
            class="product-qty-item"
        />
        <div class="input-group-btn">
                    <button
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
