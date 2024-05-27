@if(count($products) < 1)
    @include('frontend.v1.pages.shop.parts.not-found')
@endif
@foreach($products as $product)
    <div class="col-lg-4 col-md-4 col-6 product-item-category">
        <div class="product-wrap drop-shadow">
            <div class="product-wrap-main">
                @if($product->sale_price !== '')
                    <a href="{{route('theme.product.index', $product->slug)}}" class="product-label">
                        <div class="product-label-wrap">
                            <span class="product-label-span">- {{round((((float)$product->price - (float)$product->sale_price) / $product->price) * 100)}}%</span>
                        </div>
                    </a>
                @endif
                @include('frontend.v1.pages.shop.parts.product-image')
                <div class="product-item-title-wrap">
                    <h3 class="product_item_name">
                        <a href="{{route('theme.product.index', $product->slug)}}">{{$product->title}}</a>
                    </h3>
                    <a href="javascript:void(0);" id="add_to_wishlist-{{$product->id}}" data-id="{{$product->id}}" data-qty="1" class="add_to_wishlist add-to-wishlist-btn"><i class="fa fa-heart"></i></a>
                </div>
                <div class="product-item-article-wrap">
                    <h3 class="product_item_article">Код: {{$product->onec_id}}</h3>
                </div>
            </div>
            <div class="add_to_cart_wrap">
                <div class="wrap">
                    @if($product->sale_price !== '')
                        <span class="price">{{$product->sale_price}} {{__('theme.MDL')}}</span>
                        <span class="old_price">{{$product->price}} {{__('theme.MDL')}}</span>
                    @else
                        <span class="price">{{$product->price}} {{__('theme.MDL')}}</span>
                    @endif
                </div>
                <div class="details-wrap">
                    {{--                    <span class="qty-box">24 шт / упаковка</span>--}}
                    <span class="stock {{$product->stock > 0 ? 'in-stock' : 'out-of-stock'}}">
                        @if($product->stock > 0)
                            {{__('theme.in-stock')}}
                        @else
                            {{__('theme.out-of-stock')}}
                        @endif
                    </span>
                </div>
                <div class="product-card-summary">
                    <p><span class="summary-title">Итого:</span>
                        <span class="product-card-summary-text" id="product-card-summary-{{$product->onec_id}}">
                            @if($product->sale_price !== '')
                                {{$product->sale_price}}
                            @else
                                {{$product->price}}
                            @endif
                        </span> {{__('theme.MDL')}}
                    </p>
                </div>
                <div class="qty-add-to-cart">
                    <div class="qty-select">
                        <input type="number" name="product-{{$product->id}}-qty" data-product-id="{{$product->onec_id}}" data-price="@if($product->sale_price !== ''){{$product->sale_price}}@else{{$product->price}}@endif" class="product-qty-input" value="1" min="1" max="{{$product->stock}}" id="product-{{$product->id}}-qty">
                    </div>
                    <a href="#" data-id="{{$product->id}}" id="add-to-cart-{{$product->id}}" class="add_to_cart_btn">{{__('theme.add-to-cart')}}</a>
                </div>
            </div>
        </div>
    </div>
@endforeach
