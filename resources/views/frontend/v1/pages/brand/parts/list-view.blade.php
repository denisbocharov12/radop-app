@if(count($products) < 1)
    @include('frontend.v1.pages.brand.parts.not-found')
@endif
@foreach($products as $product)
    @php
        $sessionId = config('shopping_cart.default_session_id');
        if (auth()->guard('user')->user()) {
            $sessionId = auth()->guard('user')->user()->id;
        }
        $item = \Cart::session($sessionId)->get($product->id);
    @endphp
    <div class="product-list-item card mb-3 @if($item !== null) product-item-category-in-cart @endif" id="list-product-{{$product->id}}">
        <div class="row g-0">
            <div class="col-lg-3 col-12 text-center">
                <div class="product-item-category" style="margin-bottom: 0; border: none;">
                    <div class="product-wrap">
                        <div class="product-wrap-main">
                            <div class="wrap">
                                @include('frontend.v1.pages.category.parts.product-category-image')
                            </div>
                            @include('frontend.v1.pages.product.components.quick-view')
                            @if(app('wishlist')->get($product->id) !== null)
                                <a href="javascript:void(0);" id="add_to_wishlist-list-{{$product->id}}" data-id="{{$product->id}}"
                                   data-qty="1" class="add_to_wishlist delete-from-wishlist-btn" tabindex="0" data-has-text="false">
                                    <i class="fa fa-heart" style="color: red"></i>
                                </a>
                            @else
                                <a href="javascript:void(0);" id="add_to_wishlist-list-{{$product->id}}" data-id="{{$product->id}}"
                                   data-qty="1" class="add_to_wishlist add-to-wishlist-btn" data-has-text="false">
                                    <i class="fa fa-heart"></i>
                                </a>
                            @endif
                            @include('frontend.v1.pages.product.components.label')
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-lg-6 col-12">
                <div class="card-body p-2">
                    <div class="product-item-category">
                        <div class="product-item-title-wrap">
                            <h3 class="product_item_name">
                                <a href="{{route('theme.product.index', $product->slug)}}">{{\Illuminate\Support\Str::limit($product->title, 80, '...')}}</a>
                            </h3>
                        </div>
                    </div>
                    <div class="product-item-code-wrap">
                        <h3 class="product_item_article"><span>@lang('theme.code'):</span> {{$product->onec_id}}</h3>
                        @if($product->shtrih_code)
                            <h3 class="product_item_barcode"><span>@lang('theme.barcode'):</span> {{$product->shtrih_code}}</h3>
                        @endif
                    </div>
                    <div class="product-item-details">
                        <div class="product-details-wrap">
                            <div class="details-list-wrap">
                                <ul class="ul-details">
                                    @foreach($product->values as $value)
                                        <li class="item">
                                            <span class="left">{{$value->attribute?->name}}</span>
                                            <span class="right">{{$value->value}}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    @if($product->brand !== null)
                        <div class="product-mini-brand-wrap">
                            <a href="{{route('theme.brand.index', $product->brand->onec_id)}}"
                               class="product-mini-brand">
                                    <span class="brand-text"><span
                                        class="mini-heading">{{__('theme.all-brand-products')}}</span> {{$product->brand->title}} <i
                                        class="icon-arrow-radop-right"></i>
                                    </span>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-lg-3 col-12 product-price-wrap">
                <div class="product-item-article-wrap">
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
                <div class="product-item-category" style="margin-bottom: 0; padding: 0">
                    <div class="add_to_cart_wrap" style="margin: 0;">
                        <div class="wrap">
                            @include('frontend.v1.components.product_price')
                        </div>
                        @include('frontend.v1.components.product_card_summary')
                        @include('frontend.v1.components.add_to_cart_widget_v2')
                    </div>
                </div>
                @include('frontend.v1.components.packages_card_wrap')
                @if($product->min_order !== null && $product->min_order > 1)
                    <div class="packages-wrap-min-to-order">
                        <p style="text-align: left">{{__('theme.package-min-to-order')}}: {{$product->min_order}} {{__('theme.min_order_unit')}}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endforeach