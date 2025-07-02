@if(app('wishlist')->getContent()->count() < 1)
    @include('frontend.v1.pages.wishlist.parts.not-found')
@endif
@foreach(app('wishlist')->getContent()->sort() as $product)
    @php
        $sessionId = config('shopping_cart.default_session_id');

        if (auth()->guard('user')->user()) {
            $sessionId = auth()->guard('user')->user()->id;
        }

        $item = \Cart::session($sessionId)->get($product->id);
    @endphp
    <div class="col-lg-3 col-md-4 col-6 product-item-category drop-shadow @if($item !== null) product-item-category-in-cart @endif"
         id="item-wishlist-{{$product->conditions->id}}" data-id="{{$product->id}}">
        <div class="product-wrap">
            <div class="product-wrap-main {{$product->conditions->sale_price !== '' ? 'product-wrap-main-with-sale' : ''}}">
                @include('frontend.v1.pages.product.components.label', ['product' => $product->conditions])
                @if($product->conditions->sale_price !== '')
                    <a href="{{route('theme.product.index', $product->conditions->slug)}}" class="product-label">
                        <div class="product-label-wrap">
                            <span class="product-label-span">
                                - {{\App\Services\Theme\Product\ThemeProductManager::getProductSaleForLabel($product->conditions)}}%
                            </span>
                        </div>
                    </a>
                @endif
                <div class="wrap">
                    @include('frontend.v1.pages.wishlist.parts.product-image')
                </div>
                @if(app('wishlist')->get($product->conditions->id) !== null)
                    <a href="javascript:void(0);" id="add_to_wishlist-{{$product->conditions->id}}"
                       data-id="{{$product->conditions->id}}" data-qty="1"
                       class="add_to_wishlist delete-from-wishlist-btn" tabindex="0"><i class="fa fa-heart"
                                                                                        style="color: red"></i>
                    </a>
                @else
                    <a href="javascript:void(0);" id="add_to_wishlist-{{$product->conditions->id}}"
                       data-id="{{$product->conditions->id}}" data-qty="1" class="add_to_wishlist add-to-wishlist-btn">
                        <i class="fa fa-heart"></i>
                    </a>
                @endif
                <div class="product-item-title-wrap">
                    <h3 class="product_item_name">
                        <a href="{{route('theme.product.index', $product->conditions->slug)}}">{{\Illuminate\Support\Str::limit($product->conditions->title, 80, '...')}}</a>
                    </h3>
                </div>
                <div class="product-item-article-wrap">
                    <h3 class="product_item_article">{{__('theme.code')}}: {{$product->conditions->onec_id}}</h3>
                    <div class="details-wrap">
                    <span class="stock {{$product->conditions->stock > 0 ? 'in-stock' : 'out-of-stock'}}">
                        @if($product->conditions->stock > 0)
                            {{__('theme.in-stock')}}
                        @else
                            {{__('theme.out-of-stock')}}
                        @endif
                    </span>
                    </div>
                </div>
                <div class="product-list-mini-brand-wrap">
                    @if($product->conditions->brand !== null && $product->conditions->brand->onec_id !== null)
                        <a href="{{route('theme.brand.index', $product->conditions->brand?->onec_id)}}"
                           class="product-mini-brand" data-id="{{$product->conditions->brand?->onec_id}}">
                        <span class="brand-text"><span class="mini-heading">{{__('theme.all-brand-products')}}</span> {{$product->conditions->brand->title}} <i
                                class="icon-arrow-radop-right"></i></span>
                        </a>
                    @endif
                </div>
            </div>
            <div class="add_to_cart_wrap">
                <hr class="product-card-item">
                <div class="wrap">
                    @include('frontend.v1.components.product_price', ['product' => $product->conditions])
                </div>
                @include('frontend.v1.components.product_card_summary', ['product' => $product->conditions])
                @php
                    $package = isset($product->conditions->packages->where('order_status', true)->first()->value) ? $product->conditions->packages->sortBy('value')->first()->value : 1;
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
                            id="product-{{$product->conditions->id}}-qty"
                            type="number"
                            min="{{$product->conditions->min_order ?? $package}}"
                            max="{{$product->conditions->stock}}"
                            placeholder="{{$product->conditions->min_order ?? $package}}"
                            value="{{$product->conditions->min_order ?? $package}}"
                            step="{{$product->conditions->min_order ?? $package}}"
                            name="product-{{$product->conditions->id}}-qty"
                            data-product-id="{{$product->conditions->onec_id}}"
                            data-price="{{\App\Services\Theme\Product\ThemeProductManager::getProductTotalSum($product->conditions)}}"
                            data-package="{{$package}}"
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
                    </script>
                    <a href="#" data-id="{{$product->conditions->id}}" id="add-to-cart-{{$product->conditions->id}}"
                       class="add_to_cart_btn">{{__('theme.add-to-cart')}}</a>
                </div>
            </div>
            @if(!$product->conditions->packages->isEmpty())
                @include('frontend.v1.components.packages_card_wrap', ['product' => $product->conditions])
            @endif
        </div>
        @include('frontend.v1.components.in_cart_widget')
    </div>
@endforeach

@section('scripts')
    <script>
        $('.delete-from-wishlist-btn').click(function (e) {
            e.preventDefault();
            var productId = $(this).data('id');
            $('#item-wishlist-' + productId).fadeOut();
        })
    </script>
@endsection
