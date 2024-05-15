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
                <li class="chosen">Популярное</li>
                <li>Недавно просмотренные</li>
                <li>Похожие товары</li>
            </ul>
            <div class="vertical-tabs-content-wrap col-lg-9">
                <div class="vertical-tabs-content active">
                    <div class="col cart-catalog-slider" style="margin-top: 0">
                        @foreach($popularProducts as $product)
                            <div class="product_item">
                                <div class="product-wrap drop-shadow">
                                    <div class="product-wrap-main">
                                        @if($product->sale_price !== '')
                                            <a href="{{route('theme.product.index', $product->slug)}}" class="product-label">
                                                <div class="product-label-wrap">
                                                    <span class="product-label-span">- {{round((((float)$product->price - (float)$product->sale_price) / $product->price) * 100, 2)}}%</span>
                                                </div>
                                            </a>
                                        @endif
                                        <a href="#" class="wrap-image">
                                            <img class="primary-image" src="https://placehold.co/120x120?text=Demo 1" alt="" />
                                            <img
                                                class="secondary-image"
                                                src="https://placehold.co/120x120?text=Demo 1"
                                                alt=""
                                            />
                                        </a>
                                        <div class="product-item-title-wrap">
                                            <h3 class="product_item_name">
                                                {{$product->title}}
                                            </h3>
                                            <a href="#" class="add_to_wishlist"><i class="icon-heart"></i></a>
                                        </div>
                                    </div>
                                    <div class="add_to_cart_wrap">
                                        <div class="wrap">
                                            @if($product->sale_price !== '')
                                                <span class="price">{{$product->sale_price}} MDL</span>
                                                <span class="old_price">{{$product->price}} MDL</span>
                                            @else
                                                <span class="price">{{$product->price}} MDL</span>
                                            @endif
                                        </div>
                                        <div class="details-wrap">
{{--                                            <span class="qty-box">24 шт / упаковка</span>--}}
                                            <span class="stock {{$product->stock > 0 ? 'in-stock' : 'out-of-stock'}}">
                                            @if($product->stock > 0)
                                                    {{__('theme.in-stock')}}
                                                @else
                                                    {{__('theme.out-of-stock')}}
                                                @endif
                                            </span>
                                        </div>
                                        <a href="#" class="add_to_cart_btn">{{__('theme.add-to-cart')}}</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="vertical-tabs-content"></div>
                <div class="vertical-tabs-content"></div>
            </div>
        </div>
    </div>
</section>
