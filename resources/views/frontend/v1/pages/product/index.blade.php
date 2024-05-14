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
                            <span>SKU: {{$product->onec_id}}</span>
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
                                <input type="number" value="1" min="1" max="{{$product->stock}}" name="qty" id="product-qty-page" class="product-qty-page-input qty-item-{{$product->id}}">
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
                                @if($product->data)
                                    {{$product->data->summary}}
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
{{--            @include('frontend.v1.pages.product.parts.tabs')--}}
        </div>
    </section>
    <section class="section-standart section-catalog mb-5">
        <div class="container">
            <div class="row-catalog row">
                <div class="col-heading">
                    <div class="heading">
                        <h1>Похожие товары</h1>
                    </div>
                </div>
                <div class="col catalog-slider">
                    <div class="product_item">
                        <div class="product-wrap drop-shadow">
                            <div class="product-wrap-main">
                                <a href="#" class="product-label">
                                    <div class="product-label-wrap">
                                        <span class="product-label-span">- 37%</span>
                                    </div>
                                </a>
                                <a href="#" class="wrap-image">
                                    <img class="primary-image" src="assets/example-content/test.jpg" alt="" />
                                    <img class="secondary-image" src="assets/example-content/test2.jpg" alt="" />
                                </a>
                                <div class="product-item-title-wrap">
                                    <h3 class="product_item_name">
                                        BIC Round Stic Xtra-Life Ballpoint Pen, Medium Point, 1.0mm, Black Ink,
                                        60/Pack (GSM609-BLK)
                                    </h3>
                                    <a href="#" class="add_to_wishlist"><i class="icon-heart"></i></a>
                                </div>
                                <div class="rating-css">
                                    <div class="star-icon">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                    </div>
                                    <span class="rating_count">103</span>
                                </div>
                            </div>
                            <div class="add_to_cart_wrap">
                                <div class="wrap">
                                    <span class="price">120 MDL</span>
                                    <span class="old_price">145 MDL</span>
                                </div>
                                <div class="details-wrap">
                                    <span class="qty-box">24 шт / упаковка</span>
                                    <span class="stock in-stock">В наличии</span>
                                </div>
                                <a href="#" class="add_to_cart_btn">В корзину</a>
                            </div>
                        </div>
                    </div>
                    <div class="product_item">
                        <div class="product-wrap drop-shadow">
                            <div class="product-wrap-main">
                                <a href="#" class="product-label">
                                    <div class="product-label-wrap">
                                        <span class="product-label-span">- 37%</span>
                                    </div>
                                </a>
                                <a href="#" class="wrap-image">
                                    <img class="primary-image" src="assets/example-content/test.jpg" alt="" />
                                    <img class="secondary-image" src="assets/example-content/test2.jpg" alt="" />
                                </a>
                                <div class="product-item-title-wrap">
                                    <h3 class="product_item_name">
                                        BIC Round Stic Xtra-Life Ballpoint Pen, Medium Point, 1.0mm, Black Ink,
                                        60/Pack (GSM609-BLK)
                                    </h3>
                                    <a href="#" class="add_to_wishlist"><i class="icon-heart"></i></a>
                                </div>
                                <div class="rating-css">
                                    <div class="star-icon">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                    </div>
                                    <span class="rating_count">103</span>
                                </div>
                            </div>
                            <div class="add_to_cart_wrap">
                                <div class="wrap">
                                    <span class="price">120 MDL</span>
                                    <span class="old_price">145 MDL</span>
                                </div>
                                <div class="details-wrap">
                                    <span class="qty-box">24 шт / упаковка</span>
                                    <span class="stock in-stock">В наличии</span>
                                </div>
                                <a href="#" class="add_to_cart_btn">В корзину</a>
                            </div>
                        </div>
                    </div>
                    <div class="product_item">
                        <div class="product-wrap drop-shadow">
                            <div class="product-wrap-main">
                                <a href="#" class="product-label">
                                    <div class="product-label-wrap">
                                        <span class="product-label-span">- 37%</span>
                                    </div>
                                </a>
                                <a href="#" class="wrap-image">
                                    <img class="primary-image" src="assets/example-content/test.jpg" alt="" />
                                    <img class="secondary-image" src="assets/example-content/test2.jpg" alt="" />
                                </a>
                                <div class="product-item-title-wrap">
                                    <h3 class="product_item_name">
                                        BIC Round Stic Xtra-Life Ballpoint Pen, Medium Point, 1.0mm, Black Ink,
                                        60/Pack (GSM609-BLK)
                                    </h3>
                                    <a href="#" class="add_to_wishlist"><i class="icon-heart"></i></a>
                                </div>
                                <div class="rating-css">
                                    <div class="star-icon">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                    </div>
                                    <span class="rating_count">103</span>
                                </div>
                            </div>
                            <div class="add_to_cart_wrap">
                                <div class="wrap">
                                    <span class="price">120 MDL</span>
                                    <span class="old_price">145 MDL</span>
                                </div>
                                <div class="details-wrap">
                                    <span class="qty-box">24 шт / упаковка</span>
                                    <span class="stock in-stock">В наличии</span>
                                </div>
                                <a href="#" class="add_to_cart_btn">В корзину</a>
                            </div>
                        </div>
                    </div>
                    <div class="product_item">
                        <div class="product-wrap drop-shadow">
                            <div class="product-wrap-main">
                                <a href="#" class="product-label">
                                    <div class="product-label-wrap">
                                        <span class="product-label-span">- 37%</span>
                                    </div>
                                </a>
                                <a href="#" class="wrap-image">
                                    <img class="primary-image" src="assets/example-content/test.jpg" alt="" />
                                    <img class="secondary-image" src="assets/example-content/test2.jpg" alt="" />
                                </a>
                                <div class="product-item-title-wrap">
                                    <h3 class="product_item_name">
                                        BIC Round Stic Xtra-Life Ballpoint Pen, Medium Point, 1.0mm, Black Ink,
                                        60/Pack (GSM609-BLK)
                                    </h3>
                                    <a href="#" class="add_to_wishlist"><i class="icon-heart"></i></a>
                                </div>
                                <div class="rating-css">
                                    <div class="star-icon">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                    </div>
                                    <span class="rating_count">103</span>
                                </div>
                            </div>
                            <div class="add_to_cart_wrap">
                                <div class="wrap">
                                    <span class="price">120 MDL</span>
                                    <span class="old_price">145 MDL</span>
                                </div>
                                <div class="details-wrap">
                                    <span class="qty-box">24 шт / упаковка</span>
                                    <span class="stock in-stock">В наличии</span>
                                </div>
                                <a href="#" class="add_to_cart_btn">В корзину</a>
                            </div>
                        </div>
                    </div>
                    <div class="product_item">
                        <div class="product-wrap drop-shadow">
                            <div class="product-wrap-main">
                                <a href="#" class="product-label">
                                    <div class="product-label-wrap">
                                        <span class="product-label-span">- 37%</span>
                                    </div>
                                </a>
                                <a href="#" class="wrap-image">
                                    <img class="primary-image" src="assets/example-content/test.jpg" alt="" />
                                    <img class="secondary-image" src="assets/example-content/test2.jpg" alt="" />
                                </a>
                                <div class="product-item-title-wrap">
                                    <h3 class="product_item_name">
                                        BIC Round Stic Xtra-Life Ballpoint Pen, Medium Point, 1.0mm, Black Ink,
                                        60/Pack (GSM609-BLK)
                                    </h3>
                                    <a href="#" class="add_to_wishlist"><i class="icon-heart"></i></a>
                                </div>
                                <div class="rating-css">
                                    <div class="star-icon">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                    </div>
                                    <span class="rating_count">103</span>
                                </div>
                            </div>
                            <div class="add_to_cart_wrap">
                                <div class="wrap">
                                    <span class="price">120 MDL</span>
                                    <span class="old_price">145 MDL</span>
                                </div>
                                <div class="details-wrap">
                                    <span class="qty-box">24 шт / упаковка</span>
                                    <span class="stock in-stock">В наличии</span>
                                </div>
                                <a href="#" class="add_to_cart_btn">В корзину</a>
                            </div>
                        </div>
                    </div>
                    <div class="product_item">
                        <div class="product-wrap drop-shadow">
                            <div class="product-wrap-main">
                                <a href="#" class="product-label">
                                    <div class="product-label-wrap">
                                        <span class="product-label-span">- 37%</span>
                                    </div>
                                </a>
                                <a href="#" class="wrap-image">
                                    <img class="primary-image" src="assets/example-content/test.jpg" alt="" />
                                    <img class="secondary-image" src="assets/example-content/test2.jpg" alt="" />
                                </a>
                                <div class="product-item-title-wrap">
                                    <h3 class="product_item_name">
                                        BIC Round Stic Xtra-Life Ballpoint Pen, Medium Point, 1.0mm, Black Ink,
                                        60/Pack (GSM609-BLK)
                                    </h3>
                                    <a href="#" class="add_to_wishlist"><i class="icon-heart"></i></a>
                                </div>
                                <div class="rating-css">
                                    <div class="star-icon">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                    </div>
                                    <span class="rating_count">103</span>
                                </div>
                            </div>
                            <div class="add_to_cart_wrap">
                                <div class="wrap">
                                    <span class="price">120 MDL</span>
                                    <span class="old_price">145 MDL</span>
                                </div>
                                <div class="details-wrap">
                                    <span class="qty-box">24 шт / упаковка</span>
                                    <span class="stock in-stock">В наличии</span>
                                </div>
                                <a href="#" class="add_to_cart_btn">В корзину</a>
                            </div>
                        </div>
                    </div>
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
                    $('#add-to-cart-'+product_id).html('Loading ...<i class="fa fa-spin fa-spinner"></i>');
                },
                complete:function () {
                    $('#add-to-cart-'+product_id).html('Add to Cart <i class="fa fa-shopping-cart"></i>');
                },
                success:function (response) {
                    if (response['status'] == true){
                        $('#cart-update').html(response['cart']);
                        $('.mini-cart-count').html(response['cart_count']);
                        $('.mini-cart-subtotal').html(response['total']);
                        $('#cart-page').html(response['cart-page']);
                    }
                    if (response['status'] == "not_in_stock"){
                        toastr["warning"]("Данного товара нет в наличии больше указанной цифры...")
                        toastr.options = {
                            "closeButton": false,
                            "debug": false,
                            "newestOnTop": false,
                            "progressBar": false,
                            "positionClass": "toast-top-right",
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
    </script>
@endsection
