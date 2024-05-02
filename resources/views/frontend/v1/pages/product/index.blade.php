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
                            <span>SKU: {{$product->onec_id}} / {{$product->data->sku}}</span>
                        </div>
                        <div class="product-details-wrap">
                            <div class="product-stock-status">
                                @if($product->stock < 1)
                                    <span class="status out-of-stock"> Нет в наличии </span>
                                @else
                                    <span class="status in-stock"> В наличии </span>
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
                                <span class="price">{{$product->sale_price}} MDL</span>
                                <span class="old_price">{{$product->price}} MDL</span>
                            @else
                                <span class="price">{{$product->price}} MDL</span>
                            @endif
                        </div>
                        <hr />
                        <div class="product-add-to-cart-wrap">
                            <div class="qty-select">
                                <label for="product-qty-page" class="qty-label">Количество</label>
                                <select name="qty" id="product-qty-page" class="product-qty-page qty-item-{{$product->id}}">
                                    @for($i=1; $i<=$product->stock; $i++)
                                        <option value="{{$i}}">{{$i}}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="product-add-to-cart">
                                <a href="#" data-id="{{$product->id}}" class="product-add-to-cart-btn">В корзину</a>
                            </div>
                        </div>
                        <hr />
                        <div class="product-add-to-wishlist-wrap">
                            <a href="#" class="add-to-wishlist-btn"
                            ><i class="icon-heart"></i> Добавить в список желаний</a
                            >
                        </div>
                        <hr />
                        <div class="product-description">
                            <p>
                                @if($product->productData)
                                    {{$product->productData->summary}}
                                @endif
                            </p>
                        </div>
                        <div class="product-details-wrap">
                            <h4 class="details-heading">Детали товара:</h4>
                            <div class="details-list-wrap">
                                <ul class="ul-details">
                                    @if($product->brand !== null)
                                        <li class="item">
                                            <span class="left">Брэнд:</span><span class="right" style="font-weight: bold">{{$product->brand->title}}</span>
                                        </li>
                                    @endif
                                    @foreach($product->values as $value)
                                        <li class="item">
                                            <span class="left">{{$value->attribute->name}}</span><span class="right">{{$value->value}}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <hr />
                    {{--UppSale--}}
                    </div>
                </div>
            </div>
            {{--Tabs --}}
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        Fancybox.bind('[data-fancybox="gallery"]', {
            selector : '.slick-slide:not(.slick-cloned)',
            hash     : false
        });
    </script>
@endsection
