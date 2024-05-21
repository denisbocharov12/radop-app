@extends('frontend.v1.layouts.layout')

@section('content')
    <section class="my-account" style="margin-bottom: 100px">
        <div class="container">
            <h1 class="my-account__title title">{{ __('theme.my-coupons') }}</h1>
            <div class="my-account__wrapper">
                @include('frontend.v1.pages.account.sidebar')
                <div class="coupons">
                    <ul class="coupons__list">
                        @if(!$coupons->count())
                            <div class="no-coupons text-center">
                                <p>{{ __('theme.no-coupons') }}</p>
                                <a href="{{ route('theme.shop.index') }}" class="btn btn-primary mt-3">{{ __('theme.go-to-catalog') }}</a>
                            </div>
                        @endif
                        @foreach($coupons as $coupon)
                            <li class="coupons__item coupon">
                                <div class="coupon__block">
                                    <p class="coupon__code">{{ $coupon->code }}</p>
                                    <p class="coupon__description">{{ $coupon->description }}</p>
                                </div>
                                <div class="coupon__block">
                                    <ul class="coupon__details">
                                        <li class="coupon__detail">
                                            <span class="coupon__detail-label">{{ __('theme.start-date') }}:</span>
                                            <time datetime="{{ $coupon->start_date->format('Y-m-d') }}">{{ $coupon->start_date->format('d.m.Y') }}</time>
                                        </li>
                                        <li class="coupon__detail">
                                            <span class="coupon__detail-label">{{ __('theme.end-date') }}:</span>
                                            <time datetime="{{ $coupon->end_date->format('Y-m-d') }}">{{ $coupon->end_date->format('d.m.Y') }}</time>
                                        </li>
                                        <li class="coupon__detail">
                                            <span class="coupon__detail-label">{{ __('theme.discount-type') }}:</span>
                                            @if($coupon->type === 'fixed')
                                                {{ __('theme.fixed-discount') }}
                                            @elseif($coupon->type === 'percent')
                                                {{ __('theme.percent-discount') }}
                                            @endif
                                        </li>
                                        <li class="coupon__detail">
                                            <span class="coupon__detail-label">{{ __('theme.discount-value') }}:</span>
                                            @if($coupon->type === 'fixed')
                                                {{ $coupon->value }} MDL
                                            @elseif($coupon->type === 'percent')
                                                {{ $coupon->value }}%
                                            @endif
                                        </li>
                                        @if($coupon->minimal_total)
                                            <li class="coupon__detail">
                                                <span class="coupon__detail-label">{{ __('theme.minimal_total') }}:</span>
                                                {{ $coupon->minimal_total }}
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </section>
@endsection
