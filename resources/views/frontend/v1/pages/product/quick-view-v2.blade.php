<section class="section-product section-quick-view mb-5" style="min-width: 80%; max-width: 80%">
    <div class="container">
        <div class="product-info-wrap-v2">
            <div class="product-name-v2">
                <h1>{{$product->title}}</h1>
            </div>
            <div class="product-meta-info">
                <div class="product-sku-v2">
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
                @if($product->shtrih_code !== null)
                    <div class="product-barcode-v2">
                        <h3 class="product_item_barcode">
                            <span>{{__('theme.barcode')}}:</span>
                            <span
                                class="product-code product-code--barcode"
                                role="button"
                                tabindex="0"
                                data-copy-value="{{ $product->shtrih_code }}"
                                data-copy-message="{{ __('theme.product_code_copied') }}"
                                style="padding: 3px; border: 1px solid #34af31; color: #000"
                            >{{$product->shtrih_code}}</span>
                        </h3>
                    </div>
                @endif
                @if($product->brand !== null)
                    <div class="product-brand-v2">
                        <span class="mini-heading">{{__('theme.all-brand-products')}}</span>
                        <a href="{{route('theme.brand.index', $product->brand->onec_id)}}" class="product-mini-brand">
                            <span class="brand-text">
                                {{$product->brand->title}}
                            </span>
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <div class="product-v2-main-row">
            <div class="col-product-gallery col-lg-45">
                @include('frontend.v1.pages.product.parts.quick-gallery-v2')
            </div>

            <div class="col-product-characteristics col-lg-30">
                <div class="product-details-wrap-v2">
                    <h3 class="details-heading">{{__('theme.product-details')}}</h3>
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

            @php
                $sessionId = config('shopping_cart.default_session_id');
                if (auth()->guard('user')->user()) {
                    $sessionId = auth()->guard('user')->user()->id;
                }
                $item = \Cart::session($sessionId)->get($product->id);
            @endphp
            <div class="col-product-cart-widget col-lg-25">
                <div class="product-cart-widget-wrap-v2 @if(\Cart::session($sessionId)->get($product->id) !== null) product-cart-widget-in-cart @endif">
                    <div class="product-price-wrap">
                        @include('frontend.v1.components.product_price')
                    </div>
                    @include('frontend.v1.components.product_card_summary')
                    <div class="add_to_cart_wrap">
                        @include('frontend.v1.components.add_to_cart_widget_v2_quick')
                    </div>
                    @include('frontend.v1.components.packages_card_wrap')
                    <div class="product-card-summary-in-cart-v2" id="product-card-summary-in-cart-quick-{{$product->id}}">
                        @if(\Cart::session($sessionId)->get($product->id) !== null)
                            <p>
                                <span class="summary-title"><i class="icon-check"></i>{{__('theme.in-cart')}}</span>
                                <span class="product-card-summary-cart-title">{{ $item?->quantity ?? 0 }}</span>
                                {{__('theme.in_cart_unit')}}
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="section-product-description-quick mt-4">
            <h3 class="description-block-heading">{{__('theme.description')}}</h3>
            <div class="product-description-content">
                @if($product->data?->getTranslation('summary', app()->getLocale()) === null || empty(strip_tags($product->data?->getTranslation('summary', app()->getLocale()))))
                    <p class="description-text">{{__('theme.no-description')}}</p>
                @else
                    <div class="description-text">{!! $product->data?->getTranslation('summary', app()->getLocale()) !!}</div>
                @endif
            </div>
        </div>
    </div>
</section>

