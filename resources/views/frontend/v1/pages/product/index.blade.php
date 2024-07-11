@extends('frontend.v1.layouts.layout')

@section('content')
    @include('frontend.v1.pages.product.parts.breadcrumbs')
    <section class="section-product mb-5">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-7 col-product-images">
                    <div class="product-info-wrap">
                        <div class="product-name">
                            <h1>{{$product->title}}</h1>
                        </div>
                        <div class="product-sku">
                            <div class="product-item-article-wrap">
                                <h3 class="product_item_article">{{__('theme.code')}}: {{$product->onec_id}}</h3>
                            </div>
                        </div>
                        <div class="product-details-wrap">
                            <div class="product-stock-status">
                                @if($product->stock < 1)
                                    <span class="status out-of-stock">{{__('theme.out-of-stock')}}</span>
                                @else
                                    <span class="status in-stock">{{__('theme.in-stock')}}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    @include('frontend.v1.pages.product.parts.gallery')
                </div>
                <div class="col-12 col-lg-5 col-product-info">
                    <div class="product-wrap">
                        <div class="product-price-wrap">
                            @if($product->sale_price !== '')
                                <span class="price">{{$product->sale_price}} {{__('theme.MDL')}}</span>
                                <span class="old_price">{{$product->price}} {{__('theme.MDL')}}</span>
                            @else
                                <span class="price">{{$product->price}} {{__('theme.MDL')}}</span>
                            @endif
                        </div>
                        <hr />
                        <div class="product-add-to-cart-wrap">
                            <div class="qty-select">
                                <label for="product-qty-page" class="qty-label">{{__('theme.quantity')}}</label>
                                <input type="number" name="product-{{$product->id}}-qty" value="1" min="1" max="{{$product->stock}}" id="product-{{$product->id}}-qty" data-product-id="{{$product->onec_id}}" data-price="@if($product->sale_price !== ''){{$product->sale_price}}@else{{$product->price}}@endif" class="product-qty-input product-qty-page-input qty-item-{{$product->id}}">
                            </div>
                            <div class="product-add-to-cart">
                                <a href="#" data-id="{{$product->id}}" id="add-to-cart-{{$product->id}}" class="product-add-to-cart-btn">{{__('theme.add-to-cart')}}</a>
                            </div>
                        </div>
                        <div class="product-card-summary">
                            <p><span class="summary-title">{{__('theme.total')}}</span>
                                <span class="product-card-summary-text" id="product-card-summary-{{$product->onec_id}}">
                            @if($product->sale_price !== '')
                                        {{$product->sale_price}}
                                    @else
                                        {{$product->price}}
                                    @endif
                        </span> {{__('theme.MDL')}}
                            </p>
                        </div>
                        <div class="product-card-summary-cart mt-2">
                            <p>
                                <span class="summary-title">{{__('theme.in-cart')}} </span>
                                <span class="product-card-summary-cart-title" >
                                                @php
                                                    $sessionId = config('shopping_cart.default_session_id');

                                                    if (auth()->guard('user')->user()) {
                                                        $sessionId = auth()->guard('user')->user()->id;
                                                    }

                                                    $item = \Cart::session($sessionId)->get($product->id);
                                                @endphp
                                    {{$item?->quantity ?? 0}}
                                            </span> {{__('theme.unit')}}
                            </p>
                        </div>
                        <hr />
                        <div class="product-add-to-wishlist-wrap">
                            <a href="#" class="add-to-wishlist-btn"
                            ><i class="icon-heart"></i>{{__('theme.add-to-wishlist')}}</a
                            >
                        </div>
                        <hr />
                        <a href="{{route('theme.brand.index', $product->brand_id)}}" class="brand-block">
                            <img src="{{$product->brand->getFirstMediaUrl('media')}}" alt="{{$product->brand->title}}" class="brand-logo">
                            <span class="brand-name">{{$product->brand->title}}</span>
                        </a>
                    <div class="tabs">
                        <button class="tab-button active" data-tab="details">{{__('theme.product-details')}}</button>
                        <button class="tab-button" data-tab="description">{{__('theme.description')}}</button>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane active" id="details">
                            <div class="product-details-wrap">
                                <div class="details-list-wrap">
                                    <ul class="ul-details">
                                        @foreach($product->values as $value)
                                            <li class="item">
                                                <span class="left">{{$value->attribute?->name}}</span><span class="right">{{$value->value}}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="description">
                            <div class="product-description-wrap">
                                @if($product->data->summary === null)
                                    <h4 class="description-heading">{{__('theme.no-description')}}</h4>
                                @else
                                    <p class="description">{{$product->data?->summary}}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    {{--UppSale--}}
                    </div>
                </div>
            </div>
{{--            @include('frontend.v1.pages.product.parts.tabs')--}}
        </div>
    </section>
    <section class="section-standart section-catalog mb-5">
        <div class="container">
            <div class="row-catalog row">
                <div class="col-heading">
                    <div class="heading">
                        <h1>{{__('theme.similar-products')}}</h1>
                    </div>
                </div>
                <div class="col catalog-slider">
                    @foreach($similarProducts as $product)
                        <div class="product_item product-item-category">
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
                                        <a href="javascript:void(0);" id="add_to_wishlist-{{$product->id}}" data-id="{{$product->id}}" data-qty="1" class="add_to_wishlist add-to-wishlist-btn"><i class="fa fa-heart"></i></a>
                                    <div class="product-item-title-wrap">
                                        <h3 class="product_item_name">
                                            <a href="{{route('theme.product.index', $product->slug)}}">{{$product->title}}</a>
                                        </h3>
                                    </div>
                                    <div class="product-item-article-wrap">
                                        <h3 class="product_item_article">{{__('theme.code')}}: {{$product->onec_id}}</h3>
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
                                        <p><span class="summary-title">{{__('theme.total')}}</span>
                                            <span class="product-card-summary-text" id="product-card-summary-{{$product->onec_id}}">
                                                @if($product->sale_price !== '')
                                                    {{$product->sale_price}}
                                                @else
                                                    {{$product->price}}
                                                @endif
                                            </span> {{__('theme.MDL')}}
                                        </p>
                                    </div>
                                    <div class="product-card-summary-cart mt-2">
                                        <p>
                                            <span class="summary-title">{{__('theme.in-cart')}}</span>
                                            <span class="product-card-summary-cart-title" >
                                                @php
                                                    $sessionId = config('shopping_cart.default_session_id');

                                                    if (auth()->guard('user')->user()) {
                                                        $sessionId = auth()->guard('user')->user()->id;
                                                    }

                                                    $item = \Cart::session($sessionId)->get($product->id);
                                                @endphp
                                                                    {{$item?->quantity ?? 0}}
                                            </span> {{__('theme.unit')}}
                                        </p>
                                    </div>
                                    <div class="qty-add-to-cart">
                                        <div class="qty-select">
                                            <input type="number" name="product-{{$product->id}}-qty" data-product-id="{{$product->onec_id}}" data-price="@if($product->sale_price !== ''){{$product->sale_price}}@else{{$product->price}}@endif" class="product-qty-input" value="1" min="1" max="{{$product->stock}}" id="product-{{$product->id}}-qty">
                                        </div>
                                        <a href="#" data-id="{{$product->id}}" id="add-to-cart-{{$product->id}}" class="add_to_cart_btn m-0">{{__('theme.add-to-cart')}}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        Fancybox.bind('[data-fancybox="gallery"]', {
            selector : '.slick-slide:not(.slick-cloned)',
            hash     : false
        });

        $(document).on('click','.product-add-to-cart-btn',function (e) {
            e.preventDefault();
            var product_id = $(this).data('id');
            var product_qty = $('.qty-item-'+product_id).val();
            var token = "{{csrf_token()}}";
            var path = "{{route('theme.product.store')}}";
            $.ajax({
                url: path,
                type: "POST",
                dataType:"JSON",
                data:{
                    product_id: product_id,
                    product_qty: product_qty,
                    _token: token
                },
                beforeSend:function () {
                    $('#add-to-cart-'+product_id).html('<i class="fa fa-spin fa-spinner"></i>');
                },
                complete:function () {
                    $('#add-to-cart-'+product_id).html('{{__('theme.add-to-cart')}}');
                },
                success:function (response) {
                    if (response['status'] == true){
                        $('#cart-update').html(response['cart']);
                        $('.mini-cart-count').html(response['cart_count']);
                        $('.mini-cart-subtotal').html(response['total']);
                        $('.header-cart-widget .count').html(response['cart_count']);
                        $('.header-cart-widget .summ').html(response['total']);
                        $('#cart-page').html(response['cart-page']);
                        toastr["success"](response['msg']);
                    }
                    if (response['status'] == "not_in_stock"){
                        toastr["warning"]("Данного товара нет в наличии больше указанной цифры...")
                        toastr.options = {
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
                    }
                }
            });
        })
        document.addEventListener('DOMContentLoaded', function() {
            const tabButtons = document.querySelectorAll('.tab-button');
            const tabPanes = document.querySelectorAll('.tab-pane');

            tabButtons.forEach(function(button) {
                button.addEventListener('click', function() {
                    const targetTab = this.dataset.tab;

                    // Удаляем класс 'active' со всех вкладок и кнопок
                    tabButtons.forEach(function(btn) {
                        btn.classList.remove('active');
                    });
                    tabPanes.forEach(function(pane) {
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
