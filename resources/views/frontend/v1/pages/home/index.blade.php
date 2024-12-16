@extends('frontend.v1.layouts.layout')

@section('content')
    <section class="section-standart section-main section-primary">
        <div class="container">
            <div class="row">
                <div class="col-12 col-main-content">
                    <div id="main-banner" class="theme-slider">
                        <div class="item">
                            <a href="{{route('theme.category.index', 10)}}">
                                <img src="{{asset('/v1/frontend/assets')}}/images/banner_home_slide_3.jpg" alt="" />
                            </a>
                        </div>
                        <div class="item">
                            <a href="{{route('theme.category.index', 10)}}">
                                <img src="{{asset('/v1/frontend/assets')}}/images/banner_home_slide_4.jpg" alt="" />
                            </a>
                        </div>
                        <div class="item">
                            <a href="{{route('theme.brand.index', 85)}}">
                                <img src="{{asset('/v1/frontend/assets')}}/images/banner_home_slide_2.png" alt="" />
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="section-standart section-flaer">
        <div class="container container-flaer container-flaer-m0">
            <div class="row">
                <div class="col-12 col-lg-4 col-flaer">
                    <div class="flaer-wrap drop-shadow">
                        <a href="{{route('theme.category.index', 6)}}" class="link-flaer">
                            <img src="{{asset('/v1/frontend/assets')}}/images/grid_slide_1.jpg" alt="" />
                        </a>
                    </div>
                </div>
                <div class="col-12 col-lg-4 col-flaer">
                    <div class="flaer-wrap drop-shadow">
                        <a href="{{route('theme.brand.index', 82)}}" class="link-flaer">
                            <img src="{{asset('/v1/frontend/assets')}}/images/grid_slide_2.jpg" alt="" />
                        </a>
                    </div>
                </div>
                <div class="col-12 col-lg-4 col-flaer">
                    <div class="flaer-wrap drop-shadow">
                        <a href="{{route('theme.brand.index', 2)}}" class="link-flaer">
                            <img src="{{asset('/v1/frontend/assets')}}/images/grid_slide_3.jpg" alt="" />
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="section-standart section-catalog section-home">
        <div class="container">
            <div class="row-catalog row">
                <div class="col-heading">
                    <div class="heading heading-with-btn">
                        <h1>{{__('theme.popular-products')}}</h1>
                        <a class="section-home-btn" href="#">{{__('theme.view-all')}}</a>
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
                        <div class="product_item product-item-category drop-shadow @if($item !== null) product-item-category-in-cart @endif" id="col-product-{{$product->id}}">
                            <div class="product-wrap">
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
                                                <i class="fa fa-heart"></i>
                                            </a>
                                        @endif
                                    <div class="product-item-title-wrap">
                                        <h3 class="product_item_name">
                                            <a href="{{route('theme.product.index', $product->slug)}}">{{$product->title}}</a>
                                        </h3>
                                    </div>
                                        <div class="product-item-article-wrap">
                                            <h3 class="product_item_article">{{__('theme.code')}}: {{$product->onec_id}}</h3>
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
                                </div>
                                <div class="add_to_cart_wrap">
                                    <hr class="product-card-item">
                                    <div class="wrap">
                                        @if($product->sale_price !== '')
                                            <span class="price">{{ number_format($product->sale_price, 2, ',', '') }} {{__('theme.MDL')}}</span>
                                            <span class="old_price">{{ number_format($product->price, 2, ',', '') }} {{__('theme.MDL')}}</span>
                                        @else
                                            <span class="price">{{ number_format($product->price, 2, ',', '') }} {{__('theme.MDL')}}</span>
                                        @endif
                                    </div>
                                    <div class="product-card-summary">
                                        <p><span class="summary-title">{{__('theme.total')}}</span>
                                            <span class="product-card-summary-text" id="product-card-summary-{{$product->onec_id}}">
                            @if($product->sale_price !== '')
                                                    {{ number_format($product->sale_price, 2, ',', '') }}
                                                @else
                                                    {{ number_format($product->price, 2, ',', '') }}
                                                @endif
                        </span> {{__('theme.MDL')}}
                                        </p>
                                    </div>
                                    <div class="qty-add-to-cart qty-add-to-cart-product-card">
                                        <div class="sc-product-qty qty-block">
                                            <div class="input-group-btn">
                                                <button
                                                    onclick="this.parentNode.parentNode.querySelector('input[type=number]').stepDown()"
                                                    class="sc-product-decrement btn-quantity-product minus"
                                                    type="button"
                                                    id="button-minus"
                                                >
                                                    -
                                                </button>
                                            </div>
                                            <input
                                                id="product-{{$product->id}}-qty"
                                                type="number"
                                                min="1"
                                                max="{{$product->stock}}"
                                                placeholder="1"
                                                value="1"
                                                name="product-{{$product->id}}-qty"
                                                data-product-id="{{$product->onec_id}}"
                                                data-price="@if($product->sale_price !== ''){{$product->sale_price}}@else{{$product->price}}@endif"
                                                class="product-qty-item"
                                            />
                                            <div class="input-group-btn">
                                                <button
                                                    onclick="this.parentNode.parentNode.querySelector('input[type=number]').stepUp()"
                                                    class="sc-product-increment btn-quantity-product plus"
                                                    type="button"
                                                    id="button-plus"
                                                >
                                                    +
                                                </button>
                                            </div>
                                        </div>
                                        <a href="#" data-id="{{$product->id}}" id="add-to-cart-{{$product->id}}" class="add_to_cart_btn">{{__('theme.add-to-cart')}}</a>
                                    </div>
                                </div>
                                @include('frontend.v1.components.packages_card_wrap')
                            </div>
                            @include('frontend.v1.components.in_cart_widget')
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    <section class="section-standart section-catalog section-home">
        <div class="container">
            <div class="row-catalog row">
                <div class="col-heading">
                    <div class="heading heading-with-btn">
                        <h1>{{__('theme.new-products')}}</h1>
                        <a class="section-home-btn" href="#">{{__('theme.view-all')}}</a>
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
                        <div class="product_item product-item-category drop-shadow @if($item !== null) product-item-category-in-cart @endif" id="col-product-{{$product->id}}">
                            <div class="product-wrap">
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
                                            <i class="fa fa-heart"></i>
                                        </a>
                                    @endif
                                    <div class="product-item-title-wrap">
                                        <h3 class="product_item_name">
                                            <a href="{{route('theme.product.index', $product->slug)}}">{{$product->title}}</a>
                                        </h3>
                                    </div>
                                    <div class="product-item-article-wrap">
                                        <h3 class="product_item_article">{{__('theme.code')}}: {{$product->onec_id}}</h3>
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
                                </div>
                                <div class="add_to_cart_wrap">
                                    <hr class="product-card-item">
                                    <div class="wrap">
                                        @if($product->sale_price !== '')
                                            <span class="price">{{ number_format($product->sale_price, 2, ',', '') }} {{__('theme.MDL')}}</span>
                                            <span class="old_price">{{ number_format($product->price, 2, ',', '') }} {{__('theme.MDL')}}</span>
                                        @else
                                            <span class="price">{{ number_format($product->price, 2, ',', '') }} {{__('theme.MDL')}}</span>
                                        @endif
                                    </div>
                                    <div class="product-card-summary">
                                        <p><span class="summary-title">{{__('theme.total')}}</span>
                                            <span class="product-card-summary-text" id="product-card-summary-{{$product->onec_id}}">
                            @if($product->sale_price !== '')
                                                    {{ number_format($product->sale_price, 2, ',', '') }}
                                                @else
                                                    {{ number_format($product->price, 2, ',', '') }}
                                                @endif
                        </span> {{__('theme.MDL')}}
                                        </p>
                                    </div>
                                    <div class="qty-add-to-cart qty-add-to-cart-product-card">
                                        <div class="sc-product-qty qty-block">
                                            <div class="input-group-btn">
                                                <button
                                                    onclick="this.parentNode.parentNode.querySelector('input[type=number]').stepDown()"
                                                    class="sc-product-decrement btn-quantity-product minus"
                                                    type="button"
                                                    id="button-minus"
                                                >
                                                    -
                                                </button>
                                            </div>
                                            <input
                                                id="product-{{$product->id}}-qty"
                                                type="number"
                                                min="1"
                                                max="{{$product->stock}}"
                                                placeholder="1"
                                                value="1"
                                                name="product-{{$product->id}}-qty"
                                                data-product-id="{{$product->onec_id}}"
                                                data-price="@if($product->sale_price !== ''){{$product->sale_price}}@else{{$product->price}}@endif"
                                                class="product-qty-item"
                                            />
                                            <div class="input-group-btn">
                                                <button
                                                    onclick="this.parentNode.parentNode.querySelector('input[type=number]').stepUp()"
                                                    class="sc-product-increment btn-quantity-product plus"
                                                    type="button"
                                                    id="button-plus"
                                                >
                                                    +
                                                </button>
                                            </div>
                                        </div>
                                        <a href="#" data-id="{{$product->id}}" id="add-to-cart-{{$product->id}}" class="add_to_cart_btn">{{__('theme.add-to-cart')}}</a>
                                    </div>
                                </div>
                                @include('frontend.v1.components.packages_card_wrap')
                            </div>
                            @include('frontend.v1.components.in_cart_widget')
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    <section class="section-standart section-catalog section-home">
        <div class="container">
            <div class="row-catalog row">
                <div class="col-heading">
                    <div class="heading heading-with-btn">
                        <h1>{{__('theme.on-discount')}}</h1>
                        <a class="section-home-btn" href="#">{{__('theme.view-all')}}</a>
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
                        <div class="product_item product-item-category drop-shadow @if($item !== null) product-item-category-in-cart @endif" id="col-product-{{$product->id}}">
                            <div class="product-wrap">
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
                                            <i class="fa fa-heart"></i>
                                        </a>
                                    @endif
                                    <div class="product-item-title-wrap">
                                        <h3 class="product_item_name">
                                            <a href="{{route('theme.product.index', $product->slug)}}">{{$product->title}}</a>
                                        </h3>
                                    </div>
                                    <div class="product-item-article-wrap">
                                        <h3 class="product_item_article">{{__('theme.code')}}: {{$product->onec_id}}</h3>
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
                                </div>
                                <div class="add_to_cart_wrap">
                                    <hr class="product-card-item">
                                    <div class="wrap">
                                        @if($product->sale_price !== '')
                                            <span class="price">{{ number_format($product->sale_price, 2, ',', '') }} {{__('theme.MDL')}}</span>
                                            <span class="old_price">{{ number_format($product->price, 2, ',', '') }} {{__('theme.MDL')}}</span>
                                        @else
                                            <span class="price">{{ number_format($product->price, 2, ',', '') }} {{__('theme.MDL')}}</span>
                                        @endif
                                    </div>
                                    <div class="product-card-summary">
                                        <p><span class="summary-title">{{__('theme.total')}}</span>
                                            <span class="product-card-summary-text" id="product-card-summary-{{$product->onec_id}}">
                            @if($product->sale_price !== '')
                                                    {{ number_format($product->sale_price, 2, ',', '') }}
                                                @else
                                                    {{ number_format($product->price, 2, ',', '') }}
                                                @endif
                        </span> {{__('theme.MDL')}}
                                        </p>
                                    </div>
                                    <div class="qty-add-to-cart qty-add-to-cart-product-card">
                                        <div class="sc-product-qty qty-block">
                                            <div class="input-group-btn">
                                                <button
                                                    onclick="this.parentNode.parentNode.querySelector('input[type=number]').stepDown()"
                                                    class="sc-product-decrement btn-quantity-product minus"
                                                    type="button"
                                                    id="button-minus"
                                                >
                                                    -
                                                </button>
                                            </div>
                                            <input
                                                id="product-{{$product->id}}-qty"
                                                type="number"
                                                min="1"
                                                max="{{$product->stock}}"
                                                placeholder="1"
                                                value="1"
                                                name="product-{{$product->id}}-qty"
                                                data-product-id="{{$product->onec_id}}"
                                                data-price="@if($product->sale_price !== ''){{$product->sale_price}}@else{{$product->price}}@endif"
                                                class="product-qty-item"
                                            />
                                            <div class="input-group-btn">
                                                <button
                                                    onclick="this.parentNode.parentNode.querySelector('input[type=number]').stepUp()"
                                                    class="sc-product-increment btn-quantity-product plus"
                                                    type="button"
                                                    id="button-plus"
                                                >
                                                    +
                                                </button>
                                            </div>
                                        </div>
                                        <a href="#" data-id="{{$product->id}}" id="add-to-cart-{{$product->id}}" class="add_to_cart_btn">{{__('theme.add-to-cart')}}</a>
                                    </div>
                                </div>
                                @include('frontend.v1.components.packages_card_wrap')
                            </div>
                            @include('frontend.v1.components.in_cart_widget')
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    <section class="section-standart section-slider section-brand-slider section-home">
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
                                <a href="{{route('theme.brand.index', $brand->id)}}">
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
