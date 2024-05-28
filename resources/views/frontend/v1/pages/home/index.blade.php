@extends('frontend.v1.layouts.layout')

@section('content')
    <section class="section-standart section-main section-primary">
        <div class="container">
            <div class="row">
                <div class="col-12 col-main-content">
                    <div id="main-banner">
                        <div class="item">
                            <a href="#">
                                <img src="https://placehold.co/1110x325?text=Demo" alt="" />
                            </a>
                        </div>
                        <div class="item">
                            <a href="#">
                                <img src="https://placehold.co/1110x325?text=Demo" alt="" />
                            </a>
                        </div>
                        <div class="item">
                            <a href="#">
                                <img src="https://placehold.co/1110x325?text=Demo" alt="" />
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="section-standart">
        <div class="container container-flaer container-flaer-m0">
            <div class="row">
                <div class="col-12 col-lg-4 col-flaer">
                    <div class="flaer-wrap drop-shadow">
                        <a href="#" class="link-flaer">
                            <img src="https://placehold.co/350x220?text=Demo" alt="" />
                        </a>
                    </div>
                </div>
                <div class="col-12 col-lg-4 col-flaer">
                    <div class="flaer-wrap drop-shadow">
                        <a href="#" class="link-flaer">
                            <img src="https://placehold.co/350x220?text=Demo" alt="" />
                        </a>
                    </div>
                </div>
                <div class="col-12 col-lg-4 col-flaer">
                    <div class="flaer-wrap drop-shadow">
                        <a href="#" class="link-flaer">
                            <img src="https://placehold.co/350x220?text=Demo" alt="" />
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="section-standart section-catalog">
        <div class="container">
            <div class="row-catalog row">
                <div class="col-heading">
                    <div class="heading">
                        <h1>{{__('theme.popular-products')}}</h1>
                    </div>
                </div>
                <div class="col catalog-slider">
                    @foreach($popularProducts as $product)
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
                                    <div class="product-item-title-wrap">
                                        <h3 class="product_item_name">
                                            <a href="{{route('theme.product.index', $product->slug)}}">{{$product->title}}</a>
                                        </h3>
                                        <a href="javascript:void(0);" id="add_to_wishlist-{{$product->id}}" data-id="{{$product->id}}" data-qty="1" class="add_to_wishlist add-to-wishlist-btn"><i class="fa fa-heart"></i></a>
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
    <section class="section-standart section-catalog">
        <div class="container">
            <div class="row-catalog row">
                <div class="col-heading">
                    <div class="heading">
                        <h1>{{__('theme.new-products')}}</h1>
                    </div>
                </div>
                <div class="col catalog-slider">
                    @foreach($newProducts as $product)
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
                                    <div class="product-item-title-wrap">
                                        <h3 class="product_item_name">
                                            <a href="{{route('theme.product.index', $product->slug)}}">{{$product->title}} ({{$product->onec_id}})</a>
                                        </h3>
                                        <a href="javascript:void(0);" id="add_to_wishlist-{{$product->id}}" data-id="{{$product->id}}" data-qty="1" class="add_to_wishlist add-to-wishlist-btn"><i class="fa fa-heart"></i></a>
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
    <section class="section-standart section-catalog">
        <div class="container">
            <div class="row-catalog row">
                <div class="col-heading">
                    <div class="heading">
                        <h1>{{__('theme.on-discount')}}</h1>
                    </div>
                </div>
                <div class="col catalog-slider">
                    @foreach($discountProducts as $product)
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
                                    <div class="product-item-title-wrap">
                                        <h3 class="product_item_name">
                                            <a href="{{route('theme.product.index', $product->slug)}}">{{$product->title}} ({{$product->onec_id}})</a>
                                        </h3>
                                        <a href="javascript:void(0);" id="add_to_wishlist-{{$product->id}}" data-id="{{$product->id}}" data-qty="1" class="add_to_wishlist add-to-wishlist-btn"><i class="fa fa-heart"></i></a>
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
    <section class="section-standart">
        <div class="container container-flaer container-flaer-m0">
            <div class="row">
                <div class="col-12 col-flaer">
                    <div class="flaer-wrap drop-shadow">
                        <a href="#" class="link-flaer">
                            <img src="https://placehold.co/1110x120?text=Demo" alt="" />
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="section-standart section-slider">
        <div class="container">
            <div class="row">
                <div class="col-12 col-slider">
                    <div class="wrap-slider" id="partners-slider">
                        @foreach($themeBrands as $brand)
                            <div class="item">
                                <a href="#">
                                    <img src="{{$brand->getFirstMediaUrl('media')}}" alt="{{$brand->title}}" />
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
