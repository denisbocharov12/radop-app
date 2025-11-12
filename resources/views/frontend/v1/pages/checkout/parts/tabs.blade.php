<section class="section-standart section-cart-tabs">
    <div class="container">
        <div class="col-heading">
            <div class="heading">
                <h1>{{__('theme.сontinue-shopping')}}</h1>
            </div>
        </div>
        <hr />
        <div class="row wrap-vertical-tabs">
            <ul class="vertical-tabs col-lg-3">
                <li class="chosen">{{__('theme.popular-products')}}</li>
                <li>{{__('theme.on-discount')}}</li>
                <li>{{__('theme.recommended')}}</li>
            </ul>
            <div class="vertical-tabs-content-wrap col-lg-9">
                <div class="vertical-tabs-content">
                    <div class="col cart-catalog-slider" style="margin-top: 0">
                        @foreach($popularProducts as $product)
                            <div class="product_item product-item-category">
                                <div class="product-wrap drop-shadow">
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
                                                    <i class="icon-heart"></i>
                                                </a>
                                            @endif
                                        <div class="product-item-title-wrap">
                                            <h3 class="product_item_name">
                                                <a href="{{route('theme.product.index', $product->slug)}}">{{$product->title}}</a>
                                            </h3>
                                        </div>
                                        <div class="product-item-article-wrap">
                                            <h3 class="product_item_article">
                                                <span>@lang('theme.code'):</span>
                                                <span
                                                    class="product-code"
                                                    role="button"
                                                    tabindex="0"
                                                    data-copy-value="{{ $product->onec_id }}"
                                                    data-copy-message="{{ __('theme.product_code_copied') }}"
                                                >{{$product->onec_id}}</span>
                                            </h3>
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
                                        <div class="qty-add-to-cart">
                                            <div class="qty-select">
                                                <input type="hidden" name="product-{{$product->id}}-qty" class="product-qty-input" value="{{$product->min_order ?? 1}}" min="{{$product->min_order ?? 1}}" max="{{$product->stock}}" id="product-{{$product->id}}-qty" step="{{$product->min_order ?? 1}}">
                                            </div>
                                            <a href="#" data-id="{{$product->id}}" id="add-to-cart-{{$product->id}}" class="add_to_cart_btn">{{__('theme.add-to-cart')}}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="vertical-tabs-content">
                    <div class="col cart-catalog-slider" style="margin-top: 0">
                        @foreach($discountProducts as $product)
                            <div class="product_item product-item-category">
                                <div class="product-wrap drop-shadow">
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
                                                    <i class="icon-heart"></i>
                                                </a>
                                            @endif
                                        <div class="product-item-title-wrap">
                                            <h3 class="product_item_name">
                                                <a href="{{route('theme.product.index', $product->slug)}}">{{$product->title}}</a>
                                            </h3>
                                        </div>
                                        <div class="product-item-article-wrap">
                                            <h3 class="product_item_article">
                                                <span>@lang('theme.code'):</span>
                                                <span
                                                    class="product-code"
                                                    role="button"
                                                    tabindex="0"
                                                    data-copy-value="{{ $product->onec_id }}"
                                                    data-copy-message="{{ __('theme.product_code_copied') }}"
                                                >{{$product->onec_id}}</span>
                                            </h3>
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
                                            <span class="stock {{$product->stock > 0 ? 'in-stock' : 'out-of-stock'}}">
                                                @if($product->stock > 0)
                                                    {{__('theme.in-stock')}}
                                                @else
                                                    {{__('theme.out-of-stock')}}
                                                @endif
                                            </span>
                                        </div>
                                        <div class="qty-add-to-cart">
                                            <div class="qty-select">
                                                <input type="hidden" name="product-{{$product->id}}-qty" class="product-qty-input" value="{{$product->min_order ?? 1}}" min="{{$product->min_order ?? 1}}" max="{{$product->stock}}" id="product-{{$product->id}}-qty" step="{{$product->min_order ?? 1}}">
                                            </div>
                                            <a href="#" data-id="{{$product->id}}" id="add-to-cart-{{$product->id}}" class="add_to_cart_btn">{{__('theme.add-to-cart')}}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="vertical-tabs-content">
                    <div class="col cart-catalog-slider" style="margin-top: 0">
                        @foreach($featuredProducts as $product)
                            <div class="product_item product-item-category">
                                <div class="product-wrap drop-shadow">
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
                                                    <i class="icon-heart"></i>
                                                </a>
                                            @endif
                                        <div class="product-item-title-wrap">
                                            <h3 class="product_item_name">
                                                <a href="{{route('theme.product.index', $product->slug)}}">{{$product->title}}</a>
                                            </h3>
                                        </div>
                                        <div class="product-item-article-wrap">
                                            <h3 class="product_item_article">
                                                <span>@lang('theme.code'):</span>
                                                <span
                                                    class="product-code"
                                                    role="button"
                                                    tabindex="0"
                                                    data-copy-value="{{ $product->onec_id }}"
                                                    data-copy-message="{{ __('theme.product_code_copied') }}"
                                                >{{$product->onec_id}}</span>
                                            </h3>
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
                                            <span class="stock {{$product->stock > 0 ? 'in-stock' : 'out-of-stock'}}">
                                                @if($product->stock > 0)
                                                    {{__('theme.in-stock')}}
                                                @else
                                                    {{__('theme.out-of-stock')}}
                                                @endif
                                            </span>
                                        </div>
                                        <div class="qty-add-to-cart">
                                            <div class="qty-select">
                                                <input type="hidden" name="product-{{$product->id}}-qty" class="product-qty-input" value="{{$product->min_order ?? 1}}" min="{{$product->min_order ?? 1}}" max="{{$product->stock}}" id="product-{{$product->id}}-qty" step="{{$product->min_order ?? 1}}">
                                            </div>
                                            <a href="#" data-id="{{$product->id}}" id="add-to-cart-{{$product->id}}" class="add_to_cart_btn">{{__('theme.add-to-cart')}}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
