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
                style="touch-action: manipulation;"
            >
                -
            </button>
        </div>
        <input
            id="product-quick-{{$product->id}}-qty"
            type="number"
            min="{{$product->min_order ?? 1}}"
            max="{{$product->stock}}"
            placeholder="{{$package}}"
            value="{{$product->min_order ?? 1}}"
            step="{{$product->min_order ?? 1}}"
            name="product-quick-{{$product->id}}-qty"
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
                style="touch-action: manipulation;"
            >
                +
            </button>
        </div>
    </div>
    <a href="#" data-id="{{$product->id}}" id="add-to-cart-quick-{{$product->id}}" class="add_to_cart_btn_quick">{{__('theme.add-to-cart')}}</a>
</div>

