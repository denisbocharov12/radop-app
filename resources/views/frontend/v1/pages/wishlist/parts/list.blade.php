@if(app('wishlist')->getContent()->count() < 1)
    @include('frontend.v1.pages.wishlist.parts.not-found')
@endif
@foreach(app('wishlist')->getContent()->sortBy("attributes.added_at") as $product)
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
                @include('frontend.v1.pages.product.components.quick-view', ['product' => $product->conditions])
                @if(app('wishlist')->get($product->conditions->id) !== null)
                    <a href="javascript:void(0);" id="add_to_wishlist-{{$product->conditions->id}}"
                       data-id="{{$product->conditions->id}}" data-qty="1"
                       class="add_to_wishlist delete-from-wishlist-btn" tabindex="0"><i class="fa fa-heart"
                                                                                        style="color: red"></i>
                    </a>
                @else
                    <a href="javascript:void(0);" id="add_to_wishlist-{{$product->conditions->id}}"
                       data-id="{{$product->conditions->id}}" data-qty="1" class="add_to_wishlist add-to-wishlist-btn">
                        <i class="icon-heart"></i>
                    </a>
                @endif
                <div class="product-item-title-wrap">
                    <h3 class="product_item_name">
                        <a href="{{route('theme.product.index', $product->conditions->slug)}}">{{\Illuminate\Support\Str::limit($product->conditions->title, 80, '...')}}</a>
                    </h3>
                </div>
                @include('frontend.v1.components.product-item-article')
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
            <div class="product-card-bottom">
                <div class="add_to_cart_wrap">
                    <hr class="product-card-item">
                    <div class="wrap">
                        @include('frontend.v1.components.product_price', ['product' => $product->conditions])
                    </div>
                    @include('frontend.v1.components.product_card_summary', ['product' => $product->conditions])
                    @include('frontend.v1.components.add_to_cart_widget_v2', ['product' => $product->conditions])
                </div>
                @include('frontend.v1.components.packages_card_wrap', ['product' => $product->conditions])
            </div>
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
