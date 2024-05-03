<div class="product-appseil-wrap">
    @foreach($randomProducts as $product)
        <div class="product-appseil">
            <div class="product-image">
                <a href="{{route('product.detail', ['slug'=> $product->slug])}}" class="product-link">
                    @if(count($product->images) > 0)
                        @foreach($product->images as $key=>$photo)
                            <img src="{{asset('storage').$photo->image_path}}" alt="{{$product->title}}" />
                        @endforeach
                    @else
                        <img src="{{asset('backend/assets/images/logo-dark.png')}}" alt="#">
                    @endif

                </a>
            </div>
            <div class="product-info">
                <div class="product-info-head">
                    <h5 class="product-title">
                        {{$product->title}}
                    </h5>
                    {{--                                            <div class="rating-css">--}}
                    {{--                                                <div class="star-icon">--}}
                    {{--                                                    <i class="fa fa-star"></i>--}}
                    {{--                                                    <i class="fa fa-star"></i>--}}
                    {{--                                                    <i class="fa fa-star"></i>--}}
                    {{--                                                    <i class="fa fa-star"></i>--}}
                    {{--                                                    <i class="fa fa-star"></i>--}}
                    {{--                                                </div>--}}
                    {{--                                                <span class="rating_count">103</span>--}}
                    {{--                                            </div>--}}
                </div>
                <div class="product-add-to-cart">
                    <div class="wrap">
                        @if($product->productData)
                            @if($product->productData->sale_price)
                                <span class="price">{{$product->productData->sale_price}} MDL</span>
                                <span class="old_price">{{$product->price}}MDL</span>
                            @else
                                <span class="price">{{$product->price}} MDL</span>
                            @endif
                        @else
                            <span class="price">{{$product->price}} MDL</span>
                        @endif
                    </div>
                    <div class="add-to-cart-wrap">
                        <a href="#" data-id="{{$product->id}}" data-qty="1" class="add_to_cart_btn product-appseil-btn">В корзину</a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
