@extends('frontend.v1.layouts.layout')

@section('content')
    @include('frontend.v1.pages.checkout.parts.breadcrumbs')
    @php
        $sessionId = config('shopping_cart.default_session_id');

        if (auth()->guard('user')->user()) {
            $sessionId = auth()->guard('user')->user()->id;
        }

        $minSum = $user->minOrderSum();
        $isSupplement = $user->isSupplementWindowOpen();
        $cartTotal = \Cart::session($sessionId)->getTotal();
        $belowMin = !$isSupplement && $cartTotal < $minSum;
        $cartRemaining = max($minSum - $cartTotal, 0);
    @endphp
    @if (!Cart::session($sessionId)->isEmpty())
        <section class="section-content section-checkout padding-y bg" id="checkout-page">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-checkout-heading">
                        <div class="heading">
                            <h1>{{ __('theme.order-placement') }}</h1>
                        </div>
                        {{--                        <div class="continue-shopping"> --}}
                        {{--                            <a href="{{route('theme.shop.catalog')}}" class="link" --}}
                        {{--                            >{{__('theme.сontinue-shopping')}}<i class="fa fa-arrow-right"></i --}}
                        {{--                                ></a> --}}
                        {{--                        </div> --}}
                        <hr />
                    </div>
                    <style>
                        .min-order-banner{display:flex;align-items:center;gap:12px;background:#FCE9D4;border:1px solid #F4C88A;border-radius:12px;padding:14px 18px;margin-bottom:20px;color:#8A5518;font-size:15px;line-height:1.45;}
                        .min-order-banner-icon{flex:0 0 24px;width:24px;height:24px;border-radius:50%;background:#F5A623;color:#fff;font-weight:700;display:flex;align-items:center;justify-content:center;font-size:15px;}
                        .min-order-banner-text b{color:#7A4A12;font-weight:700;}
                        .min-order-banner-add{margin-left:4px;white-space:nowrap;}
                        .min-order-banner-link{display:inline-flex;align-items:center;gap:4px;margin-left:8px;color:#8A5518;text-decoration:underline;font-size:13px;opacity:.85;}
                        .min-order-banner-link:hover{opacity:1;color:#7A4A12;}
                        .min-order-banner-ico{width:1em;height:1em;flex:0 0 auto;}
                    </style>
                    <div class="col-12">
                        <div class="min-order-banner" id="checkout-min-banner" @if(!$belowMin) style="display:none;" @endif role="alert">
                            <span class="min-order-banner-icon">!</span>
                            <span class="min-order-banner-text">
                                {{ __('theme.min_order_sum_warning_message') }} <b><span class="cmb-min">{{ number_format($minSum, 2, '.', '') }}</span> {{ __('theme.MDL') }}</b>.
                                <b class="min-order-banner-add">{{ __('theme.min_order_add_more') }} <span class="cmb-remaining">{{ number_format($cartRemaining, 2, '.', '') }}</span> {{ __('theme.MDL') }}</b>
                                <a href="{{ route('theme.delivery.index') }}" class="min-order-banner-link"><svg class="min-order-banner-ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>{{ __('theme.min_order_delivery_link') }}</a>
                            </span>
                        </div>
                    </div>
                    <div class="col-lg-8 col-xl-9 col-checkout-form">
                        <div class="checkout-form-wrap">
                            <form action="{{ route('theme.checkout.store') }}" method="POST" id="checkout" class="checkout">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6 col-checkout">
                                        <div class="form-control-ch">
                                            <label for="fio">
                                                @if (auth()->guard('user')->user() !== null &&
                                                    auth()->guard('user')->user()->type->key_name === 'iur')
                                                    {{ __('theme.fio_iur') }}
                                                @else
                                                    {{ __('theme.fio') }}
                                                @endif
                                            </label>
                                            <input type="text" name="fio"
                                                   class="form-control-ch-input @error('fio') input-error-validation @enderror"
                                                   required id="fio"
                                                   value="@if (auth()->guard('user')->user() !== null && auth()->guard('user')->user()->type->key_name === 'iur'){{ $user?->profile?->organization_name }}@else{{ $user?->profile?->first_name }} {{ $user?->profile?->last_name }}@endif"/>
                                            @error('fio')
                                            <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-checkout">
                                        <div class="form-control-ch">
                                            <label for="phone">{{ __('theme.phone-number') }}</label>
                                            <input type="text" id="phone" name="phone"
                                                   class="form-control-ch-input @error('phone') input-error-validation @enderror"
                                                   required value="{{ $user?->profile?->phone }}" />
                                            @error('phone')
                                            <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-checkout">
                                        <div class="form-control-ch">
                                            <label for="email">Email</label>
                                            <input type="email" name="email"
                                                   class="form-control-ch-input @error('email') input-error-validation @enderror"
                                                   required id="email" value="{{ $user?->email }}" />
                                            @error('email')
                                            <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-checkout">
                                        <div class="form-control-ch">
                                            @if (auth()->guard('user')->user() !== null &&
                                                    auth()->guard('user')->user()->type->key_name === 'iur' &&
                                                    auth()->guard('user')->user()->filials->count() > 0)
                                                <label for="filial_id">{{ __('theme.select_filial') }}</label>
                                                <select name="filial_id" id="filial_id" required
                                                        class="select-2-container @error('filial_id') input-error-validation @enderror">
                                                    <option>{{ __('theme.select_filial') }}</option>
                                                    @foreach (auth()->guard('user')->user()->filials as $filial)
                                                        <option
                                                            data-delivery-charge="{{ (float) $filial->city->delivery_sum }}"
                                                            data-required-sum="{{ (float) $filial->city->required_sum }}"
                                                            value="{{ $filial->id }}">{{ $filial->address }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('filial_id')
                                                <span class="invalid-feedback d-block" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            @else
                                                <label for="city_id">{{ __('theme.select-city') }}</label>
                                                <select name="city_id" id="city_id"
                                                        class="select-2-container @error('city_id') input-error-validation @enderror">
                                                    <option data-delivery-charge="{{ 0 }}"
                                                            data-required-sum="{{ (float) $user->minOrderSum() }}"
                                                            value="0" selected>{{ __('theme.select-city') }}</option>
                                                    @foreach ($cities as $city)
                                                        <option data-delivery-charge="{{ (float) $city->delivery_sum }}"
                                                                data-required-sum="{{ (float) $city->required_sum }}"
                                                                @if (auth()->guard('user')->user() !== null && auth()->guard('user')->user()->city !== null) {{ auth()->guard('user')->user()->city_id === $city->id ? 'selected' : '' }} @endif
                                                                value="{{ $city->id }}">{{ $city->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('city_id')
                                                <span class="invalid-feedback d-block" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    @if (auth()->guard('user')->user() !== null &&
                                            auth()->guard('user')->user()->type->key_name === 'iur' &&
                                            auth()->guard('user')->user()->filials->count() > 0)
                                        <div class="col-md-6 col-checkout">
                                            <div class="form-control-ch">
                                                <label for="payment_method">{{ __('theme.payment-method') }}</label>
                                                <select name="payment_method" id="payment_method"
                                                        class="form-select @error('payment_method') input-error-validation @enderror"
                                                        required>
                                                    @foreach ($paymentMethods as $key => $value)
                                                        @if (auth()->guard('user')->user() !== null &&
                                                            auth()->guard('user')->user()->type->key_name === 'iur' && $key === 'transfer')
                                                            <option value="{{ $key }}" selected>{{ $value }}</option>
                                                        @else
                                                            <option value="{{ $key }}">{{ $value }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                                @error('payment_method')
                                                <span class="invalid-feedback d-block" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    @else
                                        <div class="col-md-6 col-checkout">
                                            <div class="form-control-ch">
                                                <label for="payment_method">{{ __('theme.payment-method') }}</label>
                                                <select name="payment_method" id="payment_method"
                                                        class="form-select @error('payment_method') input-error-validation @enderror"
                                                        required>
                                                    @foreach ($paymentMethods as $key => $value)
                                                        <option value="{{ $key }}">{{ $value }}</option>
                                                    @endforeach
                                                </select>
                                                @error('payment_method')
                                                <span class="invalid-feedback d-block" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-checkout">
                                            <div class="form-control-ch">
                                                <label for="address">{{ __('theme.full-address') }}</label>
                                                <input type="text" name="address"
                                                       class="form-control-ch-input @error('address') input-error-validation @enderror"
                                                       required id="address" value="{{ $user?->profile?->address }}" />
                                                @error('address')
                                                <span class="invalid-feedback d-block" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror

                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="row">
                                    <div class="col-12 col-checkout">
                                        <div class="form-control-ch">
                                            <p class="recommended_time_text">{{ __('theme.recommended_time_title') }} <span
                                                    class="show_recommended_time_btn show">{{ __('theme.show_title_text') }}</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row row-recommended-time hide">
                                    <div class="col-md-6 col-checkout">
                                        <div class="form-control-ch">
                                            <label
                                                for="recommended_time">{{ __('theme.recommended_time_heading') }}</label>
                                            <input type="text" id="recommended_time" name="recommended_time"
                                                   class="form-control-ch-input" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-checkout">
                                        <div class="form-control-ch">
                                            <label for="note">{{ __('theme.comment') }}</label>
                                            <textarea name="note" id="note" cols="30" rows="10"></textarea>
                                        </div>
                                    </div>
                                </div>
                                {{-- Iur Part --}}
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-4 col-xl-3">
                        {{--                        <div class="shopping-cart-total-discount-grade-wrap"> --}}
                        {{--                            <a class="btn-sales-period" data-fancybox --}}
                        {{--                               data-src="#salesPeriodModal" --}}
                        {{--                               href="javascript:;">{{__('theme.discount_period_link')}}</a> --}}
                        {{--                        </div> --}}
                        <div class="shopping-cart-total-wrap">
                            <div class="shopping-cart-total">
                                <div class="total-heading">
                                    <h3>{{ __('theme.invoice-payable') }}</h3>
                                </div>
                                <div class="sc-details-wrap">
                                    <ul class="details-ul">
                                        <li class="item">
                                            <span class="left">{{ __('theme.quantity-shortly') }} </span><span
                                                class="right">{{ \Cart::session($sessionId)->getContent()->count() }}
                                                {{ __('theme.cart-quantity') }}</span>
                                        </li>
                                        <li class="item">
                                            <span class="left">{{ __('theme.summary') }} </span><span
                                                class="right">{{ number_format(\Cart::session($sessionId)->getTotal(), 2, '.', '') }}
                                                {{ __('theme.MDL') }}</span>
                                        </li>
                                        <li class="item">
                                            <span class="left">{{ __('theme.discount') }} </span><span
                                                class="right"><span>0.00</span> {{ __('theme.MDL') }}</span>
                                        </li>
                                        {{--                                        <li class="item"> --}}
                                        {{--                                            <span class="left">{{__('theme.order-delivery')}} </span><span class="right"><span id="delivery-charge">0.00</span> {{__('theme.MDL')}}</span> --}}
                                        {{--                                        </li> --}}
                                    </ul>
                                </div>
                                <div class="total-wrap">
                                    <p class="total-text">{{ __('theme.for-payment') }}</p>
                                    {{--                                    @if ($foundedDiscountPeriod !== null) --}}
                                    {{--                                        <span><span id="checkout-final-price" data-total="{{\Cart::session($sessionId)->getTotal() - \Cart::session($sessionId)->getTotal() * $foundedDiscountPeriod->discount_koef / 100}}">{{number_format(\Cart::session($sessionId)->getTotal() + (float)$user?->city?->delivery_sum - \Cart::session($sessionId)->getTotal() * $foundedDiscountPeriod->discount_koef / 100, 2, ',', '')}}</span> {{__('theme.MDL')}}</span> --}}
                                    {{--                                    @else --}}
                                    {{--                                        <span><span id="checkout-final-price" data-total="{{\Cart::session($sessionId)->getTotal() - \Cart::session($sessionId)->getTotal()}}">{{number_format(\Cart::session($sessionId)->getTotal() + (float)$user?->city?->delivery_sum, 2, ',', '')}}</span> {{__('theme.MDL')}}</span> --}}
                                    {{--                                    @endif --}}
                                    <span><span id="checkout-final-price"
                                                data-total="{{ \Cart::session($sessionId)->getTotal() }}">{{ number_format(\Cart::session($sessionId)->getTotal() + (float) $user?->city?->delivery_sum, 2, '.', '') }}</span>
                                        {{ __('theme.MDL') }}</span>
                                </div>
                                <div class="sc-buttons-wrap">
                                    @if ($isSupplement)
                                        <p class="supplement-order-note show">
                                            {{ __('theme.supplement_order_note') }}
                                            <span class="sum">{{ $user->supplementParentNumber() }}</span>
                                        </p>
                                    @endif
                                    <a href="#"
                                       class="sc-btn-checkout sc-btn sc-btn-submit {{ $belowMin ? 'hide-important' : '' }}">{{ __('theme.place-order') }}</a>
                                    <a href="{{ route('theme.shop.catalog') }}"
                                       class="sc-btn-continuie sc-btn">{{ __('theme.сontinue-shopping') }}</a>
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
                    <div class="col-12 pt-4 pb-2 d-flex"
                         style="justify-content: center; align-items: center; flex-direction: column">
                        <h5 style="margin-top: 30px; font-size: 30px; font-weight: 600; color: #394360">
                            {{ __('theme.empty-cart') }}</h5>
                    </div>
                </div>
            </div>
        </section>
    @endif
    @include('frontend.v1.pages.cart.parts.tabs')
    {{--    @include('frontend.v1.components.sales_period_modal') --}}
@endsection

@section('scripts')
    <script>
        @if(!empty($ga4Checkout))
        $(function () {
            if (typeof window.radopGa4EcommercePush === 'function' && window.radopAnalyticsDataLayerEventNames) {
                window.radopGa4EcommercePush(window.radopAnalyticsDataLayerEventNames.checkout_flow_started, @json($ga4Checkout));
            }
        });
        @endif
        (function () {
            var $form = $('#checkout');
            if (!$form.length) {
                return;
            }
            $form.one('focusin', 'input, select, textarea', function () {
                if (typeof window.radopGa4EventPush === 'function' && window.radopAnalyticsDataLayerEventNames) {
                    window.radopGa4EventPush(window.radopAnalyticsDataLayerEventNames.checkout_form_interaction_started, {
                        form_id: 'checkout',
                        form_destination: window.location.pathname
                    });
                }
            });
        })();
        $('.sc-btn-submit').click(function(e) {
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
            var isSupplementOrder = {{ $isSupplement ? 'true' : 'false' }};
            $('#city_id').change(function() {
                var total = $('#checkout-final-price').data('total');
                var requiredSum = parseFloat($(this).find(':selected').data('required-sum')) || 0;
                var deliveryCharge = parseFloat($(this).find(':selected').data('delivery-charge')) || 0;
                $('#delivery-charge').text(deliveryCharge.toFixed(2));

                var belowMin = !isSupplementOrder && total < requiredSum;
                if (belowMin) {
                    // Same widget as in the cart: min sum for the selected region + how much to add.
                    $('#checkout-min-banner .cmb-min').text(requiredSum.toFixed(2));
                    $('#checkout-min-banner .cmb-remaining').text((requiredSum - total).toFixed(2));
                    $('#checkout-min-banner').show();
                    $('.sc-btn-submit').addClass('hide').addClass('hide-important');
                } else {
                    $('#checkout-min-banner').hide();
                    $('.sc-btn-submit').removeClass('hide').removeClass('hide-important');
                }

                $('#checkout-final-price').text((total + deliveryCharge).toFixed(2));
            });

            // $('#filial_id').change(function() {
            //     var total = $('#checkout-final-price').data('total');
            //     $('#delivery-charge').text($(this).find(':selected').data('delivery-charge').toFixed(2));
            //     if (total < $(this).find(':selected').data('required-sum')) {
            //         $('.sc-btn-submit').addClass('hide');
            //         $('.min-order-sum-warning-text').addClass('show');
            //         $('.min-order-sum-warning-text').find('.sum').text($(this).find(':selected').data(
            //             'required-sum'));
            //     } else {
            //         $('.sc-btn-submit').removeClass('hide');
            //         $('.min-order-sum-warning-text').removeClass('show');
            //     }
            //
            //     $('#checkout-final-price').text((total + $(this).find(':selected').data('delivery-charge'))
            //         .toFixed(2));
            // });

            $('.show_recommended_time_btn').click(function() {
                if ($(this).hasClass('show')) {
                    $(this).addClass('hide').removeClass('show').html('{{ __('theme.hide_title_text') }}');
                } else {
                    $(this).addClass('show').removeClass('hide').html('{{ __('theme.show_title_text') }}');
                }

                $('.row-recommended-time').toggleClass('hide');
            });
        });
    </script>
@endsection
