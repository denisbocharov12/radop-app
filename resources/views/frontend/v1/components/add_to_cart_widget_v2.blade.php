@php
    $package = isset($product->packages->sortBy('value')->first()->value) ? $product->packages->sortBy('value')->first()->value : 1;
@endphp
<div class="qty-add-to-cart qty-add-to-cart-product-card">
    <div class="sc-product-qty qty-block">
        <div class="input-group-btn">
            <button
                onclick="decrementQuantity(this, {{$package}})"
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
            min="{{$package}}"
            max="{{$product->stock}}"
            placeholder="{{$package}}"
            value="{{$package}}"
            name="product-{{$product->id}}-qty"
            data-product-id="{{$product->onec_id}}"
            data-price="{{\App\Services\Theme\Product\ThemeProductManager::getProductTotalSum($product)}}"
            class="product-qty-item"
        />
        <div class="input-group-btn">
            <button
                onclick="incrementQuantity(this, {{$package}})"
                class="sc-product-increment btn-quantity-product plus"
                type="button"
                id="button-plus"
            >
                +
            </button>
        </div>
    </div>

    <script>
        function incrementQuantity(button, packageSize) {
            var input = button.parentNode.parentNode.querySelector('input[type=number]');
            var newValue = parseInt(input.value) + packageSize;
            if (newValue <= parseInt(input.max)) {
                input.value = newValue;
            }
        }

        function decrementQuantity(button, packageSize) {
            var input = button.parentNode.parentNode.querySelector('input[type=number]');
            var newValue = parseInt(input.value) - packageSize;
            if (newValue >= parseInt(input.min)) {
                input.value = newValue;
            }
        }
    </script>    <a href="#" data-id="{{$product->id}}" id="add-to-cart-{{$product->id}}" class="add_to_cart_btn">{{__('theme.add-to-cart')}}</a>
</div>
