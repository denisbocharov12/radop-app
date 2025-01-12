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
    @endphp
    <div class="col-lg-3 col-md-3 col-6 product-item-category drop-shadow @if($item !== null) product-item-category-in-cart @endif" id="col-product-{{$product->id}}">
        <div class="product-wrap">
            @include('frontend.v1.pages.product.components.label')
            <div class="product-wrap-main">
                @if($product->sale_price !== '')
                    <a href="{{route('theme.product.index', $product->slug)}}" class="product-label">
                        <div class="product-label-wrap">
                            <span class="product-label-span">- {{round((((float)$product->price - (float)$product->sale_price) / $product->price) * 100)}}%</span>
                        </div>
                    </a>
                @endif
                @include('frontend.v1.pages.shop.parts.product-image')
                    @if(app('wishlist')->get($product->id) !== null)
                        <a href="javascript:void(0);" id="add_to_wishlist-{{$product->id}}" data-id="{{$product->id}}" data-qty="1"  class="add_to_wishlist delete-from-wishlist-btn" tabindex="0"><i class="fa fa-heart" style="color: red"></i>
                        </a>
                    @else
                        <a href="javascript:void(0);" id="add_to_wishlist-{{$product->id}}" data-id="{{$product->id}}" data-qty="1" class="add_to_wishlist add-to-wishlist-btn">
                            <i class="fa fa-heart"></i>
                        </a>
                    @endif
                <div class="product-item-title-wrap">
                    <h3 class="product_item_name">
                        <a href="{{route('theme.product.index', $product->slug)}}">{{\Illuminate\Support\Str::words($product->title, 8, ' ...')}}</a>
                    </h3>
                </div>
                <div class="product-item-article-wrap">
                    <h3 class="product_item_article">{{__('theme.code')}}: {{$product->onec_id}}</h3>
                    <div class="details-wrap">
                    <span class="stock {{$product->stock > 0 ? 'in-stock' : 'out-of-stock'}}">
                        @if($product->stock > 0)
                            {{__('theme.in-stock')}}
                        @else
                            {{__('theme.out-of-stock')}}
                        @endif
                    </span>
                    </div>
                </div>
            </div>
            <div class="add_to_cart_wrap">
                <hr class="product-card-item">
                <div class="wrap">
                    @include('frontend.v1.components.product_price')
                </div>
                <div class="product-card-summary">
                    <p><span class="summary-title">{{__('theme.total')}}</span>
                        <span class="product-card-summary-text" id="product-card-summary-{{$product->onec_id}}">
                            @include('frontend.v1.components.product_total')
                        </span> {{__('theme.MDL')}}
                    </p>
                </div>
                @include('frontend.v1.components.add_to_cart_widget_v2')
            </div>
            @include('frontend.v1.components.packages_card_wrap')
        </div>
        @include('frontend.v1.components.in_cart_widget')
    </div>
@endforeach
