@extends('frontend.v1.layouts.layout')

@section('content')
    @php
        $sessionId = config('shopping_cart.default_session_id');

        if (auth()->guard('user')->user()) {
            $sessionId = auth()->guard('user')->user()->id;
        }
    @endphp
    @if(!Cart::session($sessionId)->isEmpty())
        <section
            class="section-content section-checkout padding-y bg"
            id="checkout-page"
            style="padding-top: 50px"
        >
            <div class="container">
                <div class="row">
                    <div class="col-12 col-checkout-heading">
                        <div class="heading">
                            <h1>Оформление заказа</h1>
                        </div>
                        <div class="continue-shopping">
                            <a href="{{route('theme.shop.index')}}" class="link"
                            >Продолжить покупки <i class="fa fa-arrow-right"></i
                                ></a>
                        </div>
                    </div>
                    <hr />
                    <div class="col-lg-8 col-xl-9 col-checkout-form">
                        <div class="checkout-form-wrap">
                            <form action="{{route('theme.checkout.store')}}" method="POST" id="checkout" class="checkout">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6 col-checkout">
                                        <div class="form-control-ch">
                                            <label for="first_name">Имя</label>
                                            <input
                                                type="text"
                                                name="first_name"
                                                class="form-control-ch-input"
                                                required
                                                id="first_name"
                                            />
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-checkout">
                                        <div class="form-control-ch">
                                            <label for="last_name">Фамилия</label>
                                            <input
                                                type="text"
                                                name="last_name"
                                                class="form-control-ch-input"
                                                required
                                                id="last_name"
                                            />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-checkout">
                                        <div class="form-control-ch">
                                            <label for="email">Email</label>
                                            <input
                                                type="email"
                                                name="email"
                                                class="form-control-ch-input"
                                                required
                                                id="email"
                                            />
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-checkout">
                                        <div class="form-control-ch">
                                            <label for="phone">Номер телефона</label>
                                            <input
                                                type="text"
                                                id="phone"
                                                name="phone"
                                                class="form-control-ch-input"
                                                required
                                            />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-checkout">
                                        <div class="form-control-ch">
                                            <label for="city">Выберите город</label>
                                            <select
                                                name="city"
                                                id="city"
                                                class="select-2-container"
                                            >
                                                <option value="chisinau">Кишинёв</option>
                                                <option value="comrat">Комрат</option>
                                                <option value="belti">Бельцы</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-checkout">
                                        <div class="form-control-ch">
                                            <label for="address">Введите полный адрес</label>
                                            <input
                                                type="text"
                                                name="address"
                                                class="form-control-ch-input"
                                                required
                                                id="address"
                                            />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-checkout">
                                        <div class="form-control-ch">
                                            <label for="payment_method">Выберите способ оплаты</label>
                                            <select
                                                name="payment_method"
                                                id="payment_method"
                                                class="select-2-container"
                                                required
                                            >
                                                @foreach($paymentMethods as $key => $value)
                                                    <option value="{{$key}}">{{$value}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-12 col-checkout">
                                        <div class="form-control-ch">
                                            <label for="note">Комментарий</label>
                                            <textarea
                                                name="note"
                                                id="note"
                                                cols="30"
                                                rows="10"
                                            ></textarea>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-4 col-xl-3">
                        <div class="shopping-cart-total-wrap">
                            <div class="shopping-cart-total">
                                <div class="total-heading">
                                    <h3>Счёт к оплате</h3>
                                </div>
                                @if(session()->has('coupon'))
                                    <div class="sc-details-wrap">
                                        <ul class="details-ul">
                                            <li class="item">
                                                <span class="left">Кол-во: </span><span class="right">{{\Cart::session($sessionId)->getContent()->count()}} ед.</span>
                                            </li>
                                            <li class="item">
                                                <span class="left">Сумма: </span><span class="right">{{\Cart::session($sessionId)->getTotal()}} MDL</span>
                                            </li>
                                            <li class="item">
                                                <span class="left">Скидка: </span><span class="right">- {{number_format(session('coupon')['value'],2)}} MDL</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="total-wrap">
                                        <p class="total-text">К оплате:</p>
                                        <span>{{number_format((float)str_replace(',','', \Cart::session($sessionId)->getTotal()) - session('coupon')['value'],2)}} MDL</span>
                                    </div>
                                @else
                                    <div class="sc-details-wrap">
                                        <ul class="details-ul">
                                            <li class="item">
                                                <span class="left">Кол-во: </span><span class="right">{{\Cart::session($sessionId)->getContent()->count()}} ед.</span>
                                            </li>
                                            <li class="item">
                                                <span class="left">Сумма: </span><span class="right">{{\Cart::session($sessionId)->getTotal()}} MDL</span>
                                            </li>
                                            <li class="item">
                                                <span class="left">Скидка: </span><span class="right">0.00 MDL</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="total-wrap">
                                        <p class="total-text">К оплате:</p>
                                        <span>{{\Cart::session($sessionId)->getTotal()}} MDL</span>
                                    </div>
                                @endif
                                <div class="sc-buttons-wrap">
                                    <a href="#" class="sc-btn-checkout sc-btn sc-btn-submit"
                                    >Оформить заказ</a
                                    >
                                    <a href="{{route('theme.shop.index')}}" class="sc-btn-continuie sc-btn"
                                    >Продолжить покупки</a
                                    >
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @else
        <section class="section-content padding-y bg">
            <div class="container pt-5 pb-5">
                <div class="row">
                    <div class="col-12 pt-4 pb-2 d-flex" style="justify-content: center; align-items: center; flex-direction: column">
                        <h5 style="margin-top: 30px; font-size: 30px; font-weight: 600; color: #394360">Упс... Корзина пуста :(</h5>
                    </div>
                </div>
            </div>
        </section>
    @endif
    @include('frontend.v1.pages.checkout.parts.tabs')
@endsection

@section('scripts')
    <script>
        $('.sc-btn-submit').click(function (e){
            e.preventDefault();
            $('form#checkout').submit();
        });
    </script>
@endsection
