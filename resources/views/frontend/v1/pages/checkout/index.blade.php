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
                            <h1>{{__('theme.order-placement')}}</h1>
                        </div>
                        <div class="continue-shopping">
                            <a href="{{route('theme.shop.index')}}" class="link"
                            >{{__('theme.сontinue-shopping')}}<i class="fa fa-arrow-right"></i
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
                                            <label for="first_name">{{__('theme.first-name')}}</label>
                                            <input
                                                type="text"
                                                name="first_name"
                                                class="form-control-ch-input"
                                                required
                                                id="first_name"
                                                value="{{$user?->profile?->first_name}}"
                                            />
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-checkout">
                                        <div class="form-control-ch">
                                            <label for="last_name">{{__('theme.second-name')}}</label>
                                            <input
                                                type="text"
                                                name="last_name"
                                                class="form-control-ch-input"
                                                required
                                                id="last_name"
                                                value="{{$user?->profile?->last_name}}"
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
                                                value="{{$user?->email}}"
                                            />
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-checkout">
                                        <div class="form-control-ch">
                                            <label for="phone">{{__('theme.phone-number')}}</label>
                                            <input
                                                type="text"
                                                id="phone"
                                                name="phone"
                                                class="form-control-ch-input"
                                                required
                                                value="{{$user?->profile?->phone}}"
                                            />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-checkout">
                                        <div class="form-control-ch">
                                            <label for="city">{{__('theme.select-city')}}</label>
                                            <select
                                                name="city"
                                                id="city"
                                                class="select-2-container"
                                            >
                                                @foreach($cities as $city)
                                                    <option value="{{$city->id}}">{{$city->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-checkout">
                                        <div class="form-control-ch">
                                            <label for="address">{{__('theme.full-address')}}</label>
                                            <input
                                                type="text"
                                                name="address"
                                                class="form-control-ch-input"
                                                required
                                                id="address"
                                                value="{{$user?->profile?->address}}"
                                            />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-checkout">
                                        <div class="form-control-ch">
                                            <label for="payment_method">{{__('theme.payment-method')}}</label>
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
                                            <label for="note">{{__('theme.comment')}}</label>
                                            <textarea
                                                name="note"
                                                id="note"
                                                cols="30"
                                                rows="10"
                                            ></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-checkout-heading flex-column" >
                                        <h5 class="d-flex w-100 fw-bold">{{__('theme.iur-person')}}</h5>
                                        <span  style="margin-top: 5px;border-bottom: 1px solid #C9C9C9; display: flex; width: 100%"></span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-checkout">
                                        <div class="form-control-ch">
                                            <label for="company_name">{{__('theme.company-name')}}</label>
                                            <input
                                                type="text"
                                                name="company_name"
                                                class="form-control-ch-input"
                                                required
                                                id="company_name"
                                            />
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-checkout">
                                        <div class="form-control-ch">
                                            <label for="reserve_phone">{{__('theme.backup-phone')}}</label>
                                            <input
                                                type="text"
                                                name="reserve_phone"
                                                class="form-control-ch-input"
                                                required
                                                id="reserve_phone"
                                            />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-checkout">
                                        <div class="form-control-ch">
                                            <label for="bank">{{__('theme.bank')}}</label>
                                            <input
                                                type="text"
                                                name="bank"
                                                class="form-control-ch-input"
                                                required
                                                id="bank"
                                            />
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-checkout">
                                        <div class="form-control-ch">
                                            <label for="idno">IDNO</label>
                                            <input
                                                type="text"
                                                name="idno"
                                                class="form-control-ch-input"
                                                required
                                                id="idno"
                                            />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-checkout">
                                        <div class="form-control-ch">
                                            <label for="tva">TVA</label>
                                            <input
                                                type="text"
                                                name="tva"
                                                class="form-control-ch-input"
                                                required
                                                id="tva"
                                            />
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-checkout">
                                        <div class="form-control-ch">
                                            <label for="registered_city">{{__('theme.registered-city')}}</label>
                                            <input
                                                type="text"
                                                name="registered_city"
                                                class="form-control-ch-input"
                                                required
                                                id="registered_city"
                                            />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-checkout">
                                        <div class="form-control-ch">
                                            <label for="iur_address">{{__('theme.iur-address')}}</label>
                                            <input
                                                type="text"
                                                name="iur_address"
                                                class="form-control-ch-input"
                                                required
                                                id="iur_address"
                                            />
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-checkout">
                                        <div class="form-control-ch">
                                            <label for="shipping_address">{{__('theme.shipping-address')}}</label>
                                            <input
                                                type="text"
                                                name="shipping_address"
                                                class="form-control-ch-input"
                                                required
                                                id="shipping_address"
                                            />
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
                                    <h3>{{__('theme.invoice-payable')}}</h3>
                                </div>
                                @if(session()->has('coupon'))
                                    <div class="sc-details-wrap">
                                        <ul class="details-ul">
                                            <li class="item">
                                                <span class="left">{{__('theme.quantity-shortly')}} </span><span class="right">{{\Cart::session($sessionId)->getContent()->count()}} ед.</span>
                                            </li>
                                            <li class="item">
                                                <span class="left">{{__('theme.summary')}} </span><span class="right">{{\Cart::session($sessionId)->getTotal()}} {{__('theme.MDL')}}</span>
                                            </li>
                                            <li class="item">
                                                <span class="left">{{__('theme.discount')}} </span><span class="right">- {{number_format(session('coupon')['value'],2)}} {{__('theme.MDL')}}</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="total-wrap">
                                        <p class="total-text">{{__('theme.for-payment')}}</p>
                                        <span>{{number_format((float)str_replace(',','', \Cart::session($sessionId)->getTotal()) - session('coupon')['value'],2)}} {{__('theme.MDL')}}</span>
                                    </div>
                                @else
                                    <div class="sc-details-wrap">
                                        <ul class="details-ul">
                                            <li class="item">
                                                <span class="left">{{__('theme.quantity-shortly')}} </span><span class="right">{{\Cart::session($sessionId)->getContent()->count()}} ед.</span>
                                            </li>
                                            <li class="item">
                                                <span class="left">{{__('theme.summary')}} </span><span class="right">{{\Cart::session($sessionId)->getTotal()}} {{__('theme.MDL')}}</span>
                                            </li>
                                            <li class="item">
                                                <span class="left">{{__('theme.discount')}} </span><span class="right">0.00 {{__('theme.MDL')}}</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="total-wrap">
                                        <p class="total-text">{{__('theme.for-payment')}}</p>
                                        <span>{{\Cart::session($sessionId)->getTotal()}} {{__('theme.MDL')}}</span>
                                    </div>
                                @endif
                                <div class="sc-buttons-wrap">
                                    <a href="#" class="sc-btn-checkout sc-btn sc-btn-submit"
                                    >{{__('theme.place-order')}}</a
                                    >
                                    <a href="{{route('theme.shop.index')}}" class="sc-btn-continuie sc-btn"
                                    >{{__('theme.сontinue-shopping')}}</a
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
                        <h5 style="margin-top: 30px; font-size: 30px; font-weight: 600; color: #394360">{{__('theme.empty-cart')}}</h5>
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
        $(document).ready(function() {
            // Добавляем класс active к первому элементу vertical-tabs-content при загрузке страницы
            $('.vertical-tabs-content-wrap .vertical-tabs-content').eq(0).addClass('active');

            $('.vertical-tabs li').click(function() {
                var tabIndex = $(this).index();
                // $('.vertical-tabs li').removeClass('chosen');
                // $(this).addClass('chosen');
                $('.vertical-tabs-content-wrap .vertical-tabs-content').removeClass('active');
                $('.vertical-tabs-content-wrap .vertical-tabs-content').eq(tabIndex).addClass('active');
            });
        });
    </script>
@endsection
