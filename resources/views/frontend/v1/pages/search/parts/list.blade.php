@if(count($products) < 1)
    @include('frontend.v1.pages.shop.parts.not-found')
@endif
@foreach($products as $product)
    @php
        $sessionId = config('shopping_cart.default_session_id');

        if (auth()->guard('user')->user()) {
            $sessionId = auth()->guard('user')->user()->id;
        }

        $item = \Cart::session($sessionId)->get($product->id);
        $ga4ItemListId = $ga4ItemListId ?? '';
        $ga4ItemListName = $ga4ItemListName ?? '';
        $ga4ItemId = (string) ($product->onec_id ?? $product->id);
        $ga4Title = $product->getTranslation('title', app()->getLocale(), false);
        if (!is_string($ga4Title) || $ga4Title === '') {
            $ga4Title = is_string($product->title) ? $product->title : 'item';
        }
        $ga4Title = strip_tags($ga4Title);
        $ga4Price = (float) \App\Services\Theme\Product\ThemeProductManager::getProductTotalSum($product);
    @endphp
    <div class="col-lg-3 col-md-3 col-6 product-item-category drop-shadow @if($item !== null) product-item-category-in-cart @endif"
         id="col-product-{{$product->id}}"
         data-ga4-item-id="{{ e($ga4ItemId) }}"
         data-ga4-item-name="{{ e($ga4Title) }}"
         data-ga4-price="{{ $ga4Price }}"
         @if($ga4ItemListId !== '') data-ga4-item-list-id="{{ e($ga4ItemListId) }}" @endif
         @if($ga4ItemListName !== '') data-ga4-item-list-name="{{ e($ga4ItemListName) }}" @endif>
        <div class="product-wrap">
            <div class="product-wrap-main {{$product->sale_price !== '' ? 'product-wrap-main-with-sale' : ''}}">
                @include('frontend.v1.pages.product.components.label')
                @include('frontend.v1.components.product_sale_label')
                <div class="wrap">
                    @include('frontend.v1.pages.category.parts.product-category-image')
                </div>
                @include('frontend.v1.pages.product.components.quick-view')
                @if(app('wishlist')->get($product->id) !== null)
                    <a href="javascript:void(0);" id="add_to_wishlist-{{$product->id}}" data-id="{{$product->id}}"
                       data-qty="1" class="add_to_wishlist delete-from-wishlist-btn" tabindex="0" data-has-text="false">
                        <i class="fa fa-heart" style="color: red"></i>
                    </a>
                @else
                    <a href="javascript:void(0);" id="add_to_wishlist-{{$product->id}}" data-id="{{$product->id}}"
                       data-qty="1" class="add_to_wishlist add-to-wishlist-btn" data-has-text="false">
                        <i class="icon-heart"></i>
                    </a>
                @endif
                <div class="product-item-title-wrap">
                    <h3 class="product_item_name">
                        <a href="{{route('theme.product.index', $product->slug)}}">{{\Illuminate\Support\Str::limit($product->title, 80, '...')}}</a>
                    </h3>
                </div>
                @include('frontend.v1.components.product-item-article')
                @include('frontend.v1.pages.product.components.variations-product-card')
                @include('frontend.v1.components.product-list-mini-brand-wrap')
            </div>
            <div class="product-card-bottom">
                <div class="add_to_cart_wrap">
                    <hr class="product-card-item">
                    <div class="wrap">
                        @include('frontend.v1.components.product_price')
                    </div>
                    @include('frontend.v1.components.product_card_summary')
                    @include('frontend.v1.components.add_to_cart_widget_v2')
                </div>
                @include('frontend.v1.components.packages_card_wrap')
            </div>
        </div>
        @include('frontend.v1.components.in_cart_widget')
    </div>
@endforeach
