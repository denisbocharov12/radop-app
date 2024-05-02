<div class="col-lg-9 col-cart-contents">
    <div class="cart-items-wrap">
        @foreach(Cart::instance('cart')->content() as $item)
            <div class="cart-item drop-shadow">
                <div class="cart-item-wrap">
                    <div class="cart-product">
                        <a href="{{route('theme.product.index',$item->model->slug)}}" class="d-flex">
                            @foreach($item->model->images as $key=>$photo)
                                @switch($key)
                                    @case(0)
                                    <img src="{{asset('storage').$item->model->images->first()->image_path}}" alt="{{$item->model->title}}" class="sc-image"/>
                                    @break
                                @endswitch
                            @endforeach
                        </a>
                        <h5 class="item-title">
                            {{$item->model->title}}
                        </h5>
                    </div>
                    <div class="cart-item-info">
                        <div class="sc-product-qty qty-block">
                            <div class="input-group-btn">
                                <button
                                    onclick="this.parentNode.parentNode.querySelector('input[type=number]').stepDown()"
                                    class="sc-product-decrement btn-quantity-cart minus"
                                    type="button"
                                    id="button-minus"
                                >
                                    -
                                </button>
                            </div>
                            <input
                                data-id="{{$item->rowId}}"
                                id="qty-item-cart-{{$item->rowId}}"
                                type="number"
                                min="1"
                                placeholder="1"
                                value="{{$item->qty}}"
                                class="sc-qty"
                            />
                            <input type="hidden" data-id="{{$item->rowId}}" data-product-stock="{{$item->model->stock}}" id="update-cart-page-{{$item->rowId}}">
                            <div class="input-group-btn">
                                <button
                                    onclick="this.parentNode.parentNode.querySelector('input[type=number]').stepUp()"
                                    class="sc-product-increment btn-quantity-cart plus"
                                    type="button"
                                    id="button-plus"
                                >
                                    +
                                </button>
                            </div>
                        </div>

                        <div class="price-wrap">
                            @if($product->sale_price !== '')
                                <span class="price">{{$product->sale_price}} MDL</span>
                                <span class="old_price">{{$product->price}} MDL</span>
                            @else
                                <span class="price">{{$product->price}} MDL</span>
                            @endif
                        </div>
                    </div>
                    <div class="delete-cart-item">
                        <a href="javascript:void(0)" data-id="{{$item->rowId}}" class="item-delete remove-cart-btn"><i class="icon-trash-radop"></i></a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
<div class="col-lg-3 col-cart-total">
    <div class="shopping-cart-total-wrap">
        @if(!session()->has('coupon'))
            <div class="shopping-cart-bonus-code-wrap">
                <form action="" id="coupon-form" method="post" class="cs-form">
                    @csrf
                    <div class="form-control-sc">
                        <input
                            type="text"
                            class="cart-input"
                            placeholder="Введите код для скидки"
                            name="code"
                        />
                        <button type="submit" class="cart-btn-code">Применить</button>
                    </div>
                </form>
            </div>
        @endif
        <div class="shopping-cart-total">
            <div class="total-heading">
                <h3>Счёт к оплате</h3>
            </div>
            @if(session()->has('coupon'))
                <div class="sc-details-wrap">
                    <ul class="details-ul">
                        <li class="item">
                            <span class="left">Кол-во: </span><span class="right">{{Cart::instance('cart')->count()}} ед.</span>
                        </li>
                        <li class="item">
                            <span class="left">Сумма: </span><span class="right">{{Cart::instance('cart')->subtotal()}} MDL</span>
                        </li>
                        <li class="item">
                            <span class="left">Скидка: </span><span class="right">- {{number_format(session('coupon')['value'],2)}} MDL</span>
                        </li>
                    </ul>
                </div>
                <div class="total-wrap">
                    <p class="total-text">К оплате:</p>
                    <span>{{number_format((float)str_replace(',','', Cart::instance('cart')->total()) - session('coupon')['value'],2)}} MDL</span>
                </div>
            @else
                <div class="sc-details-wrap">
                    <ul class="details-ul">
                        <li class="item">
                            <span class="left">Кол-во: </span><span class="right">{{Cart::instance('cart')->count()}} ед.</span>
                        </li>
                        <li class="item">
                            <span class="left">Сумма: </span><span class="right">{{Cart::instance('cart')->subtotal()}} MDL</span>
                        </li>
                        <li class="item">
                            <span class="left">Скидка: </span><span class="right">0.00 MDL</span>
                        </li>
                    </ul>
                </div>
                <div class="total-wrap">
                    <p class="total-text">К оплате:</p>
                    <span>{{Cart::instance('cart')->total()}} MDL</span>
                </div>
            @endif
            <div class="sc-buttons-wrap">
                <a href="" class="sc-btn-checkout sc-btn">Оформить заказ</a>
                <a href="" class="sc-btn-continuie sc-btn">Продолжить покупки</a>
            </div>
        </div>
        <hr>
{{--        <div class="product-appseil-wrap">--}}
{{--            <div class="product-appseil">--}}
{{--                <div class="product-image">--}}
{{--                    <a href="#" class="product-link">--}}
{{--                        <img src="{{asset('frontend')}}/assets/example-content/appseil-1.jpg" alt="" />--}}
{{--                    </a>--}}
{{--                </div>--}}
{{--                <div class="product-info">--}}
{{--                    <div class="product-info-head">--}}
{{--                        <h5 class="product-title">--}}
{{--                            Бумага для печати и индивидуальных творчеких работ RED 500 шт.--}}
{{--                        </h5>--}}
{{--                        <div class="rating-css">--}}
{{--                            <div class="star-icon">--}}
{{--                                <i class="fa fa-star"></i>--}}
{{--                                <i class="fa fa-star"></i>--}}
{{--                                <i class="fa fa-star"></i>--}}
{{--                                <i class="fa fa-star"></i>--}}
{{--                                <i class="fa fa-star"></i>--}}
{{--                            </div>--}}
{{--                            <span class="rating_count">103</span>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="product-add-to-cart">--}}
{{--                        <div class="wrap">--}}
{{--                            <span class="price">120 MDL</span>--}}
{{--                            <span class="old_price">145 MDL</span>--}}
{{--                        </div>--}}
{{--                        <div class="add-to-cart-wrap">--}}
{{--                            <a href="#" class="add_to_cart_btn">В корзину</a>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="product-appseil">--}}
{{--                <div class="product-image">--}}
{{--                    <a href="#" class="product-link">--}}
{{--                        <img src="{{asset('frontend')}}/assets/example-content/appseil-2.jpg" alt="" />--}}
{{--                    </a>--}}
{{--                </div>--}}
{{--                <div class="product-info">--}}
{{--                    <div class="product-info-head">--}}
{{--                        <h5 class="product-title">--}}
{{--                            Бумага для печати и индивидуальных творчеких работ RED 500 шт.--}}
{{--                        </h5>--}}
{{--                        <div class="rating-css">--}}
{{--                            <div class="star-icon">--}}
{{--                                <i class="fa fa-star"></i>--}}
{{--                                <i class="fa fa-star"></i>--}}
{{--                                <i class="fa fa-star"></i>--}}
{{--                                <i class="fa fa-star"></i>--}}
{{--                                <i class="fa fa-star"></i>--}}
{{--                            </div>--}}
{{--                            <span class="rating_count">103</span>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="product-add-to-cart">--}}
{{--                        <div class="wrap">--}}
{{--                            <span class="price">120 MDL</span>--}}
{{--                            <span class="old_price">145 MDL</span>--}}
{{--                        </div>--}}
{{--                        <div class="add-to-cart-wrap">--}}
{{--                            <a href="#" class="add_to_cart_btn">В корзину</a>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
    </div>
</div>
