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
        <div class="container container-flaer">
            <div class="row">
                <div class="col-12 col-lg-6 col-flaer">
                    <div class="flaer-wrap drop-shadow">
                        <a href="#" class="link-flaer">
                            <img src="https://placehold.co/1416x504?text=Demo" alt="" />
                        </a>
                    </div>
                </div>
                <div class="col-12 col-lg-6 col-flaer">
                    <div class="flaer-wrap drop-shadow">
                        <a href="#" class="link-flaer">
                            <img src="https://placehold.co/1416x504?text=Demo" alt="" />
                        </a>
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
                        <h1>Популярные товары</h1>
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
                                    <img class="primary-image" src="{{asset('/v1/frontend/assets')}}/example-content/test.jpg" alt="" />
                                    <img class="secondary-image" src="{{asset('/v1/frontend/assets')}}/example-content/test2.jpg" alt="" />
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
                                    <img class="primary-image" src="{{asset('/v1/frontend/assets')}}/example-content/test.jpg" alt="" />
                                    <img class="secondary-image" src="{{asset('/v1/frontend/assets')}}/example-content/test2.jpg" alt="" />
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
                                    <img class="primary-image" src="{{asset('/v1/frontend/assets')}}/example-content/test.jpg" alt="" />
                                    <img class="secondary-image" src="{{asset('/v1/frontend/assets')}}/example-content/test2.jpg" alt="" />
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
                                    <img class="primary-image" src="{{asset('/v1/frontend/assets')}}/example-content/test.jpg" alt="" />
                                    <img class="secondary-image" src="{{asset('/v1/frontend/assets')}}/example-content/test2.jpg" alt="" />
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
                                    <img class="primary-image" src="{{asset('/v1/frontend/assets')}}/example-content/test.jpg" alt="" />
                                    <img class="secondary-image" src="{{asset('/v1/frontend/assets')}}/example-content/test2.jpg" alt="" />
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
                                    <img class="primary-image" src="{{asset('/v1/frontend/assets')}}/example-content/test.jpg" alt="" />
                                    <img class="secondary-image" src="{{asset('/v1/frontend/assets')}}/example-content/test2.jpg" alt="" />
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
    <section class="section-standart section-catalog">
        <div class="container">
            <div class="row-catalog row">
                <div class="col-heading">
                    <div class="heading">
                        <h1>Новинки</h1>
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
                                    <img class="primary-image" src="{{asset('/v1/frontend/assets')}}/example-content/test.jpg" alt="" />
                                    <img class="secondary-image" src="{{asset('/v1/frontend/assets')}}/example-content/test2.jpg" alt="" />
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
                                    <img class="primary-image" src="{{asset('/v1/frontend/assets')}}/example-content/test.jpg" alt="" />
                                    <img class="secondary-image" src="{{asset('/v1/frontend/assets')}}/example-content/test2.jpg" alt="" />
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
                                    <img class="primary-image" src="{{asset('/v1/frontend/assets')}}/example-content/test.jpg" alt="" />
                                    <img class="secondary-image" src="{{asset('/v1/frontend/assets')}}/example-content/test2.jpg" alt="" />
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
                                    <img class="primary-image" src="{{asset('/v1/frontend/assets')}}/example-content/test.jpg" alt="" />
                                    <img class="secondary-image" src="{{asset('/v1/frontend/assets')}}/example-content/test2.jpg" alt="" />
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
                                    <img class="primary-image" src="{{asset('/v1/frontend/assets')}}/example-content/test.jpg" alt="" />
                                    <img class="secondary-image" src="{{asset('/v1/frontend/assets')}}/example-content/test2.jpg" alt="" />
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
                                    <img class="primary-image" src="{{asset('/v1/frontend/assets')}}/example-content/test.jpg" alt="" />
                                    <img class="secondary-image" src="{{asset('/v1/frontend/assets')}}/example-content/test2.jpg" alt="" />
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
    <section class="section-standart section-catalog">
        <div class="container">
            <div class="row-catalog row">
                <div class="col-heading">
                    <div class="heading">
                        <h1>На акции</h1>
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
                                    <img class="primary-image" src="{{asset('/v1/frontend/assets')}}/example-content/test.jpg" alt="" />
                                    <img class="secondary-image" src="{{asset('/v1/frontend/assets')}}/example-content/test2.jpg" alt="" />
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
                                    <img class="primary-image" src="{{asset('/v1/frontend/assets')}}/example-content/test.jpg" alt="" />
                                    <img class="secondary-image" src="{{asset('/v1/frontend/assets')}}/example-content/test2.jpg" alt="" />
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
                                    <img class="primary-image" src="{{asset('/v1/frontend/assets')}}/example-content/test.jpg" alt="" />
                                    <img class="secondary-image" src="{{asset('/v1/frontend/assets')}}/example-content/test2.jpg" alt="" />
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
                                    <img class="primary-image" src="{{asset('/v1/frontend/assets')}}/example-content/test.jpg" alt="" />
                                    <img class="secondary-image" src="{{asset('/v1/frontend/assets')}}/example-content/test2.jpg" alt="" />
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
                                    <img class="primary-image" src="{{asset('/v1/frontend/assets')}}/example-content/test.jpg" alt="" />
                                    <img class="secondary-image" src="{{asset('/v1/frontend/assets')}}/example-content/test2.jpg" alt="" />
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
                                    <img class="primary-image" src="{{asset('/v1/frontend/assets')}}/example-content/test.jpg" alt="" />
                                    <img class="secondary-image" src="{{asset('/v1/frontend/assets')}}/example-content/test2.jpg" alt="" />
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
                        <div class="item">
                            <a href="#">
                                <img src="{{asset('/v1/frontend/assets')}}/images/runpay.svg" alt="" />
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
