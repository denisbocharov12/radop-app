@extends('frontend.v1.layouts.layout')

@section('content')
    <section class="section-standart section-main section-primary">
        <div class="container">
            <div class="row">
                <div class="col-12 col-main-content">
                    <div id="main-banner" data-autoplay-speed="{{ $autoplaySpeed }}" class="theme-slider">
                        @foreach($banners as $banner)
                            <div class="item">
                                <a href="{{ $banner->link }}">
                                    <img src="{{ asset('storage/' . ($locale === 'ro' ? $banner->image_path_ro : $banner->image_path_ru)) }}" alt="Radop - Magazin online" loading="lazy">
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="section-standart section-flaer d-none d-sm-block">
        <div class="container container-flaer container-flaer-m0">
            <div class="row">
                <div class="col-12 col-lg-4 col-flaer">
                    <div class="flaer-wrap drop-shadow">
                        <a href="{{route('theme.brand.index', 1)}}" class="link-flaer">
                            <img src="{{asset('/v1/frontend/assets')}}/images/grid_slide_1_{{str_replace('_', '-', app()->getLocale())}}.jpg" alt="Radop - Magazin online" loading="lazy"/>
                        </a>
                    </div>
                </div>
                <div class="col-12 col-lg-4 col-flaer">
                    <div class="flaer-wrap drop-shadow">
                        <a href="{{route('theme.brand.index', 35)}}" class="link-flaer">
                            <img src="{{asset('/v1/frontend/assets')}}/images/grid_slide_2_{{str_replace('_', '-', app()->getLocale())}}.jpg" alt="Radop - Magazin online" loading="lazy"/>
                        </a>
                    </div>
                </div>
                <div class="col-12 col-lg-4 col-flaer">
                    <div class="flaer-wrap drop-shadow">
                        <a href="{{route('theme.brand.index', 2)}}" class="link-flaer">
                            <img src="{{asset('/v1/frontend/assets')}}/images/grid_slide_3_{{str_replace('_', '-', app()->getLocale())}}.jpg" alt="Radop - Magazin online" loading="lazy"/>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="section-standart section-catalog section-home" id="popular-products-home-anchor">
        <div class="container">
            <div class="row-catalog row">
                <div class="col-heading">
                    <div class="heading heading-with-btn">
                        <h1>{{__('theme.popular-products')}}</h1>
                        <a class="section-home-btn" href="{{route('theme.shop.popular')}}">{{__('theme.view-all')}}</a>
                    </div>
                </div>
                <div class="col catalog-slider">
                    @foreach($popularProducts as $product)
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
                                <div class="product-wrap-main {{$product->sale_price !== '' ? 'product-wrap-main-with-sale' : ''}}">
                                    @include('frontend.v1.pages.product.components.label')
                                    @include('frontend.v1.components.product_sale_label')
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
                                            <i class="fa fa-heart"></i>
                                        </a>
                                    @endif
                                    <div class="product-item-title-wrap">
                                        <h3 class="product_item_name">
                                            <a href="{{route('theme.product.index', $product->slug)}}">{{\Illuminate\Support\Str::limit($product->title, 80, '...')}}</a>
                                        </h3>
                                    </div>
                                    @include('frontend.v1.components.product-item-article')
                                    @include('frontend.v1.pages.product.components.variations-product-card')
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
    <section class="section-standart section-catalog section-home" id="new-products-home-anchor">
        <div class="container">
            <div class="row-catalog row">
                <div class="col-heading">
                    <div class="heading heading-with-btn">
                        <h1>{{__('theme.new-products')}}</h1>
                        <a class="section-home-btn" href="{{route('theme.shop.new')}}">{{__('theme.view-all')}}</a>
                    </div>
                </div>
                <div class="col catalog-slider">
                    @foreach($newProducts as $product)
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
                                <div class="product-wrap-main {{$product->sale_price !== '' ? 'product-wrap-main-with-sale' : ''}}">
                                    @include('frontend.v1.pages.product.components.label')
                                    @include('frontend.v1.components.product_sale_label')
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
                                            <i class="fa fa-heart"></i>
                                        </a>
                                    @endif
                                    <div class="product-item-title-wrap">
                                        <h3 class="product_item_name">
                                            <a href="{{route('theme.product.index', $product->slug)}}">{{\Illuminate\Support\Str::limit($product->title, 80, '...')}}</a>
                                        </h3>
                                    </div>
                                    @include('frontend.v1.components.product-item-article', ['product' => $product])
                                    @include('frontend.v1.pages.product.components.variations-product-card')
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
    <section class="section-standart section-catalog section-home" id="discount-products-home-anchor" >
        <div class="container">
            <div class="row-catalog row">
                <div class="col-heading">
                    <div style="position: relative; top: -110px; visibility: hidden;"></div>
                    <div class="heading heading-with-btn">
                        <h1>{{__('theme.on-discount')}}</h1>
                        <a class="section-home-btn" href="{{route('theme.shop.sale')}}">{{__('theme.view-all')}}</a>
                    </div>
                </div>
                <div class="col catalog-slider">
                    @foreach($discountProducts as $product)
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
                                <div class="product-wrap-main {{$product->sale_price !== '' ? 'product-wrap-main-with-sale' : ''}}">
                                    @include('frontend.v1.pages.product.components.label')
                                    @include('frontend.v1.components.product_sale_label')
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
                                            <i class="fa fa-heart"></i>
                                        </a>
                                    @endif
                                    <div class="product-item-title-wrap">
                                        <h3 class="product_item_name">
                                            <a href="{{route('theme.product.index', $product->slug)}}">{{\Illuminate\Support\Str::limit($product->title, 80, '...')}}</a>
                                        </h3>
                                    </div>
                                    @include('frontend.v1.components.product-item-article', ['product' => $product])
                                    @include('frontend.v1.pages.product.components.variations-product-card')
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
    <section class="section-standart section-slider section-brand-slider section-home" id="brands-home-anchor">
        <div class="container">
            <div class="row">
                <div class="col-12 col-slider">
                    <div class="col-heading">
                        <div class="heading heading-with-btn">
                            <h1>{{__('theme.home-brands')}}</h1>
                        </div>
                    </div>
                    <div class="wrap-slider theme-slider" id="partners-slider">
                        @foreach($themeBrands as $brand)
                            <div class="item">
                                <a href="{{route('theme.brand.index', $brand->onec_id)}}">
                                    <img src="{{$brand->getFirstMediaUrl('media')}}" alt="{{$brand->title}}" loading="lazy"/>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
