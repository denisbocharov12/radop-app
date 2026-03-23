@extends('frontend.v1.layouts.layout')

@section('content')
    @include('frontend.v1.pages.product.parts.breadcrumbs')
    <section class="section-product mb-5">
        <div class="container">
            <div class="row">
                <div class="col-12">
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
                        @include('frontend.v1.pages.product.components.variations')
                    </div>
                </div>
            </div>
            <div class="row product-v2-main-row">
                <div class="col-12 col-lg-45 col-product-gallery">
                    @include('frontend.v1.pages.product.components.label')
                    @include('frontend.v1.pages.product.parts.gallery-v2')
                </div>
                <div class="col-12 col-lg-30 col-product-characteristics">
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
                <div class="col-12 col-lg-25 col-product-cart-widget">
                    <div class="product-cart-widget-wrap-v2 @if(\Cart::session($sessionId)->get($product->id) !== null) product-cart-widget-in-cart @endif">
                        <div class="product-price-wrap">
                            @include('frontend.v1.components.product_price')
                        </div>
                        @include('frontend.v1.components.product_card_summary')
                        @php
                            $package = isset($product->packages->where('order_status', true)->first()->value) ? $product->packages->sortBy('value')->first()->value : 1;
                        @endphp
                        <div class="add_to_cart_wrap">
                            @include('frontend.v1.components.add_to_cart_widget_v2')
                        </div>
                        @include('frontend.v1.components.packages_card_wrap')
                        <div class="product-card-summary-in-cart-v2" id="product-card-summary-in-cart-{{$product->id}}">
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
        </div>
    </section>
    <section class="section-product-description mb-5">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2 class="description-block-heading">{{__('theme.description')}}</h2>
                    <div class="product-description-content">
                        @if($product->data?->getTranslation('summary', app()->getLocale()) === null || empty(strip_tags($product->data?->getTranslation('summary', app()->getLocale()))))
                            <p class="description-text">{{__('theme.no-description')}}</p>
                        @else
                            <div class="description-text">{!! $product->data?->getTranslation('summary', app()->getLocale()) !!}</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('frontend.v1.pages.product.components.reviews')

    @if($similarProducts !== null)
        <section class="section-standart section-catalog mb-5 section-similar-product">
            <div class="container">
                <div class="row-catalog row">
                    <div class="col-heading">
                        <div class="heading heading-with-btn">
                            <h1>{{__('theme.similar-products')}}</h1>
                        </div>
                    </div>
                    <div class="col catalog-slider">
                        @foreach($similarProducts as $product)
                            @php
                                $sessionId = config('shopping_cart.default_session_id');

                                if (auth()->guard('user')->user()) {
                                    $sessionId = auth()->guard('user')->user()->id;
                                }

                                $item = \Cart::session($sessionId)->get($product->id);
                            @endphp
                            <div class="product_item product-item-category drop-shadow @if($item !== null) product-item-category-in-cart @endif"
                                 id="col-product-{{$product->id}}">
                                <div class="product-wrap">
                                    @include('frontend.v1.pages.product.components.label')
                                    <div class="product-wrap-main">
                                        @if($product->sale_price !== '')
                                            <a href="{{route('theme.product.index', $product->slug)}}"
                                               class="product-label">
                                                <div class="product-label-wrap">
                                                    <span class="product-label-span">- {{round((((float)$product->price - (float)$product->sale_price) / $product->price) * 100)}}%</span>
                                                </div>
                                            </a>
                                        @endif
                                        @include('frontend.v1.pages.shop.parts.product-image')
                                        @include('frontend.v1.pages.product.components.quick-view')
                                        @if(app('wishlist')->get($product->id) !== null)
                                            <a href="javascript:void(0);" id="add_to_wishlist-{{$product->id}}"
                                               data-id="{{$product->id}}" data-qty="1"
                                               class="add_to_wishlist delete-from-wishlist-btn" tabindex="0"><i
                                                        class="fa fa-heart" style="color: red"></i>
                                            </a>
                                        @else
                                            <a href="javascript:void(0);" id="add_to_wishlist-{{$product->id}}"
                                               data-id="{{$product->id}}" data-qty="1"
                                               class="add_to_wishlist add-to-wishlist-btn">
                                                <i class="icon-heart"></i>
                                            </a>
                                        @endif
                                        <div class="product-item-title-wrap">
                                            <h3 class="product_item_name">
                                                <a href="{{route('theme.product.index', $product->slug)}}">{{$product->title}}</a>
                                            </h3>
                                        </div>
                                        @include('frontend.v1.components.product-item-article')
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
                    </div>
                </div>
            </div>
        </section>
    @endif
@endsection

@section('scripts')
    <script>
        @if(!empty($ga4ViewItem))
        $(function () {
            if (typeof window.radopGa4EcommercePush === 'function') {
                window.radopGa4EcommercePush('view_item', @json($ga4ViewItem));
            }
        });
        @endif
        Fancybox.bind('[data-fancybox="gallery"]', {
            selector: '.slick-slide:not(.slick-cloned)',
            hash: false
        });

        $(document).on('click', '.product-add-to-cart-btn', function (e) {
            e.preventDefault();
            var product_id = $(this).data('id');
            var product_qty = $('.qty-item-' + product_id).val();
            var token = "{{csrf_token()}}";
            var path = "{{route('theme.product.store')}}";
            $.ajax({
                url: path,
                type: "POST",
                dataType: "JSON",
                data: {
                    product_id: product_id,
                    product_qty: product_qty,
                    _token: token
                },
                beforeSend: function () {
                    $('#add-to-cart-' + product_id).html('<i class="fa fa-spin fa-spinner"></i>');
                },
                complete: function () {
                    $('#add-to-cart-' + product_id).html('{{__('theme.add-to-cart')}}');
                },
                success: function (response) {
                    if (response['status'] == true) {
                        $('.cart-update').html(response['cart']);
                        $('.mini-cart-count').html(response['cart_count']);
                        $('.mini-cart-subtotal').html(response['total']);
                        $('.header-cart-widget .count').html(response['cart_count']);
                        $('.header-cart-widget .summ').html(response['total']);
                        $('.cart-page').html(response['cart-page']);
                        toastr["success"](response['msg']);
                        if (response['ga4_add'] && typeof window.radopGa4EcommercePush === 'function') {
                            var g = response['ga4_add'];
                            window.radopGa4EcommercePush('add_to_cart', {
                                currency: window.radopGaCurrency || 'MDL',
                                value: g.price * g.quantity,
                                items: [{ item_id: String(g.item_id), item_name: String(g.item_name), price: g.price, quantity: g.quantity }]
                            });
                        }
                    }
                    if (response['status'] == "not_in_stock") {
                        var _msg = (response['msg'] || '').toString().replace(/\n/g,'<br/>');
                        toastr.options = {
                            "escapeHtml": false,
                            "closeButton": false,
                            "debug": false,
                            "newestOnTop": false,
                            "progressBar": false,
                            "positionClass": "toast-bottom-right",
                            "preventDuplicates": false,
                            "onclick": null,
                            "showDuration": "300",
                            "hideDuration": "1000",
                            "timeOut": "5000",
                            "extendedTimeOut": "1000",
                            "showEasing": "swing",
                            "hideEasing": "linear",
                            "showMethod": "fadeIn",
                            "hideMethod": "fadeOut"
                        }
                        toastr["warning"](_msg)
                    }
                }
            });
        })

        $(document).on('input change', '.product-qty-item', function () {
            var qtyCount = $(this).val();
            var max = $(this).attr('max');
            if (max !== undefined && max !== '' && Number(qtyCount) > Number(max)) {
                $(this).val(max);
                if (!$(this).data('warnedMaxShown')) {
                    var msgs = (typeof window.getLimitedStockWarnings === 'function') ? window.getLimitedStockWarnings(max, $(this).attr('data-unit') || undefined) : null;
                    if (typeof toastr !== 'undefined') {
                        if (msgs && msgs.length) {
                            var html = msgs.join('<br/><br/>');
                            toastr.options = Object.assign({}, toastr.options, { escapeHtml: false });
                            toastr["warning"](html);
                        } else {
                            toastr["warning"]('Доступно только ' + max);
                        }
                    }
                    $(this).data('warnedMaxShown', true);
                }
                qtyCount = max;
            } else {
                $(this).data('warnedMaxShown', false);
            }
            var productId = $(this).data('product-id');
            var productPrice = $(this).data('price');
            var packageCount = $(this).data('package');
            var changedElement = $('#product-card-summary-' + productId);
            if (changedElement.length === 0) {
                changedElement = $('#product-card-summary-cart-' + productId);
            }
            if (changedElement.length === 0) {
                changedElement = $('#product-card-summary-in-cart-' + productId);
            }
            if (changedElement.length === 0) {
                changedElement = $('#product-' + productId + '-cart-info');
            }
            var result = (qtyCount * productPrice) / packageCount;
            changedElement.html(result.toFixed(2).replace('.', ','));
        });
    </script>
@endsection

