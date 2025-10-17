<section class="section-product mb-5" style="min-width: 80%; max-width: 80%">
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-7 col-product-images">
                @include('frontend.v1.pages.product.components.label')
                @include('frontend.v1.pages.product.parts.quick-gallery')
            </div>
            <div class="col-12 col-lg-5 col-product-info">
                <div class="product-info-wrap">
                    <div class="product-name">
                        <h1>{{$product->title}}</h1>
                    </div>
                    <div class="product-info-row">
                        <div class="product-sku">
                            <div class="product-item-article-wrap">
                                <h3 class="product_item_article">
                                    <span>@lang('theme.code'):</span>
                                    <span class="product-code">{{$product->onec_id}}</span>
                                </h3>
                            </div>
                        </div>
                        <div class="product-add-to-wishlist-wrap">
                            @if(app('wishlist')->get($product->id) !== null)
                                <a href="javascript:void(0);"
                                   id="add_to_wishlist-quick-{{$product->id}}"
                                   data-id="{{$product->id}}"
                                   data-qty="1"
                                   class="add_to_wishlist delete-from-wishlist-btn"
                                   data-has-text="true"
                                   data-quick="true"
                                   tabindex="0">
                                    <i class="fa fa-heart"
                                       style="color: red"></i> {{__('theme.remove-from-wishlist')}}
                                </a>
                            @else
                                <a href="javascript:void(0);"
                                   id="add_to_wishlist-quick-{{$product->id}}"
                                   data-id="{{$product->id}}"
                                   data-qty="1"
                                   class="add_to_wishlist add-to-wishlist-btn"
                                   data-has-text="true"
                                   data-quick="true">
                                    <i class="icon-heart"></i> {{__('theme.add-to-wishlist')}}
                                </a>
                            @endif
                        </div>
                    </div>
                    <hr>
                    <div class="product-additional-info">
                        <ul class="list">
                            @if($product->shtrih_code !== null)
                                <li style="width: fit-content;">
                                    <p>
                                        <span class="mini-heading">{{__('theme.barcode')}}:</span> <span  style="padding: 3px;  border: 1px solid #34af31; color: #000">{{$product->shtrih_code}}</span>
                                    </p>
                                </li>
                            @endif
                            @if(!$product->packages->isEmpty())
                                <li>
                                    <p>
                                        <span class="mini-heading">{{__('theme.package')}}:</span> @foreach($product->packages->sortBy('value') as $package)
                                            {{$package->value}}{{$loop->last ? '' : '/'}}
                                        @endforeach {{__('theme.package_unit')}}</p>
                                </li>
                            @endif
                        </ul>
                    </div>
                    @if($product->brand !== null)
                        <div class="product-mini-brand-wrap">
                            <a href="{{route('theme.brand.index', $product->brand->onec_id)}}"
                               class="product-mini-brand">
                                    <span class="brand-text"><span
                                            class="mini-heading">{{__('theme.all-brand-products')}}</span> {{$product->brand->title}} <i
                                            class="icon-arrow-radop-right"></i></span>
                            </a>
                        </div>
                    @endif
                    <hr/>
                    @include('frontend.v1.pages.product.components.variations')
                </div>
                <div class="product-wrap">
                    <div class="product-price-wrap">
                        @include('frontend.v1.components.product_price')
                    </div>
                    <div class="product-card-summary">
                        <p>
                            <span class="summary-title">
                                {{__('theme.total')}}
                            </span>
                            <span class="product-card-summary-text" id="product-card-summary-quick-{{$product->onec_id}}">
                                @include('frontend.v1.components.product_total')
                            </span>
                            {{__('theme.MDL')}}
                        </p>
                    </div>
                    <div class="product-item">
                        @php
                            $package = isset($product->packages->where('order_status', true)->first()->value) ? $product->packages->sortBy('value')->first()->value : 1;
                        @endphp
                        <div class="add_to_cart_wrap">
                            <div class="qty-add-to-cart">
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
                                        >
                                            +
                                        </button>
                                    </div>
                                </div>
                                <a href="#" data-id="{{$product->id}}" id="add-to-cart-quick-{{$product->id}}"
                                   class="add_to_cart_btn_quick">{{__('theme.add-to-cart')}}</a>
                            </div>
                        </div>
                    </div>
                    @php
                        $sessionId = config('shopping_cart.default_session_id');
                        if (auth()->guard('user')->user()) {
                            $sessionId = auth()->guard('user')->user()->id;
                        }
                        $item = \Cart::session($sessionId)->get($product->id);
                    @endphp
                    <div class="product-card-summary-cart product-card-summary-in-cart product-card-summary-in-cart-page mt-2"
                         id="product-quick-{{$product->id}}-cart-info">
                        @if(\Cart::session($sessionId)->get($product->id) !== null)
                            <p>
                                @if ($item && $item->quantity > 0)
                                    <span class="already-in-cart" style="display: flex; align-items: center;">
                                        <i class="icon-check"></i>
                                        {{__('theme.already-in-cart')}} - {{ $item?->quantity ?? 0 }} {{ __('theme.in_cart_unit') }}
                                    </span>
                                @else
                                    <span class="summary-title"><i
                                            class="icon-check"></i>{{ __('theme.in-cart') }} {{ $item?->quantity ?? 0 }} {{ __('theme.in_cart_unit') }}</span>
                                @endif
                            </p>
                        @endif
                    </div>
                    @if($product->min_order !== null && $product->min_order > 1)
                        <div class="packages-wrap-min-to-order">
                            <p style="text-align: left">{{__('theme.package-min-to-order')}}: {{$product->min_order}} {{__('theme.min_order_unit')}}</p>
                        </div>
                    @endif
                    <hr/>
                    <div class="tabs">
                        <button class="tab-button active"
                                data-tab="details">{{__('theme.product-details')}}</button>
                        <button class="tab-button" data-tab="description">{{__('theme.description')}}</button>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane active" id="details">
                            <div class="product-details-wrap">
                                <div class="details-list-wrap">
                                    <ul class="ul-details">
                                        @foreach($product->values as $value)
                                            <li class="item">
                                                <span class="left">{{$value->attribute?->name}}</span><span
                                                    class="right">{{$value->value}}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="description">
                            <div class="product-description-wrap">
                                @if($product->data?->summary === null)
                                    <h4 class="description-heading">{{__('theme.no-description')}}</h4>
                                @else
                                    <p class="description">{{$product->data?->summary}}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
