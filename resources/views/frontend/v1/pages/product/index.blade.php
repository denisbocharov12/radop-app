@extends('frontend.v1.layouts.layout')

@section('content')
    @include('frontend.v1.pages.product.parts.breadcrumbs')
    <section class="section-product mb-3">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-7 col-product-images">
                    @include('frontend.v1.pages.product.components.label')
                    @include('frontend.v1.pages.product.parts.gallery')
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
                            <div class="product-add-to-wishlist-wrap">
                                @if(app('wishlist')->get($product->id) !== null)
                                    <a href="javascript:void(0);"
                                       id="add_to_wishlist-{{$product->id}}"
                                       data-id="{{$product->id}}"
                                       data-qty="1"
                                       class="add_to_wishlist delete-from-wishlist-btn"
                                       data-has-text="true"
                                       tabindex="0">
                                        <i class="fa fa-heart"
                                           style="color: red"></i> {{__('theme.remove-from-wishlist')}}
                                    </a>
                                @else
                                    <a href="javascript:void(0);"
                                       id="add_to_wishlist-{{$product->id}}"
                                       data-id="{{$product->id}}"
                                       data-qty="1"
                                       class="add_to_wishlist add-to-wishlist-btn"
                                       data-has-text="true">
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
                                            <span class="mini-heading">{{__('theme.barcode')}}:</span>
                                            <span
                                                class="product-code product-code--barcode"
                                                role="button"
                                                tabindex="0"
                                                data-copy-value="{{ $product->shtrih_code }}"
                                                data-copy-message="{{ __('theme.product_code_copied') }}"
                                            >{{$product->shtrih_code}}</span>
                                        </p>
                                    </li>
                                @endif
                                @if($product->article !== null && $product->article !== '')
                                    <li style="width: fit-content;">
                                        <p>
                                            <span class="mini-heading">{{__('theme.article')}}:</span>
                                            <span
                                                class="product-code product-code--article"
                                                role="button"
                                                tabindex="0"
                                                data-copy-value="{{ $product->article }}"
                                                data-copy-message="{{ __('theme.product_code_copied') }}"
                                            >{{$product->article}}</span>
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
                        @include('frontend.v1.components.product-mini-brand-wrap')
                        <hr/>
                        @include('frontend.v1.pages.product.components.variations')
                    </div>
                    <div class="product-wrap">
                        <div class="product-price-wrap">
                            @include('frontend.v1.components.product_price')
                        </div>
                        @include('frontend.v1.components.product_card_summary')
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
{{--                                            id="product-{{$product->id}}-qty"--}}
                                            type="number"
                                            min="{{$product->min_order ?? 1}}"
                                            max="{{$product->stock}}"
                                            placeholder="{{$package}}"
                                            value="{{$product->min_order ?? 1}}"
                                            step="{{$product->min_order ?? 1}}"
                                            name="product-{{$product->id}}-qty"
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
                                    <a href="#" data-id="{{$product->id}}" id="add-to-cart-{{$product->id}}"
                                       class="add_to_cart_btn">{{__('theme.add-to-cart')}}</a>
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
                             id="product-{{$product->id}}-cart-info">
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
                                    @if($product->data?->getTranslation('summary', app()->getLocale()) === null || empty(strip_tags($product->data?->getTranslation('summary', app()->getLocale()))))
                                        <h4 class="description-heading">{{__('theme.no-description')}}</h4>
                                    @else
                                        <div class="description description-text">{!! $product->data?->getTranslation('summary', app()->getLocale()) !!}</div>
                                    @endif
                                </div>
                            </div>
                        </div>
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
                                        @if($product->brand !== null)
                                            @include('frontend.v1.components.product-list-mini-brand-wrap')
                                        @endif
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

        // динамический пересчёт итоговой цены и ограничение по max + предупреждение
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

        document.addEventListener('DOMContentLoaded', function () {
            const tabButtons = document.querySelectorAll('.tab-button');
            const tabPanes = document.querySelectorAll('.tab-pane');

            tabButtons.forEach(function (button) {
                button.addEventListener('click', function () {
                    const targetTab = this.dataset.tab;

                    // Удаляем класс 'active' со всех вкладок и кнопок
                    tabButtons.forEach(function (btn) {
                        btn.classList.remove('active');
                    });
                    tabPanes.forEach(function (pane) {
                        pane.classList.remove('active');
                    });

                    // Добавляем класс 'active' к выбранной вкладке и кнопке
                    this.classList.add('active');
                    const targetPane = document.getElementById(targetTab);
                    targetPane.classList.add('active');
                });
            });
        });
    </script>
@endsection
