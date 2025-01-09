@extends('frontend.v1.layouts.layout')

@section('content')
    <section class="my-account" style="margin-bottom: 100px">
        <div class="container">
            <h1 class="my-account__title title">{{ __('theme.my-sale') }}</h1>
            <div class="my-account__wrapper">
                @include('frontend.v1.pages.account.sidebar')
                <div class="coupons">
                    <ul class="coupons__list">
                        @if($user->sale === null || $user->sale === 0 || $user->sale === 0.0)
                            <div class="no-coupons text-center">
                                <p>{{ __('theme.no-my-sale') }}</p>
                                <a href="{{ route('theme.shop.index') }}" class="btn btn-primary mt-3">{{ __('theme.go-to-catalog') }}</a>
                            </div>
                        @else
                            <li class="coupons__item coupon">
                                <div class="coupon__block" style="flex-direction: column; justify-content: flex-start; align-items: flex-start">
                                    <p class="coupon__code">{{ __('theme.sale-heading') }} {{$user->sale}}%</p>
                                    <p class="coupon__description" style="margin-top: 15px">{{ __('theme.sale-description-info') }}</p>
                                </div>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </section>
@endsection
