@extends('frontend.v1.layouts.layout')

@section('content')
    <section class="section-page">
        <div class="order-guide-section">
            <div class="container">
                <h1>{{ __('order-guide.introduction') }}</h1>
                <p>{!! __('order-guide.introduction-1') !!}</p>
                <p>{{ __('order-guide.introduction-2') }}</p>
                <p>{!! __('order-guide.introduction-3') !!}</p>
                <p>{!! __('order-guide.introduction-4') !!}</p>
                <h2>{{ __('order-guide.note') }}</h2>
                <p>{{ __('order-guide.note-1') }}</p>
                <p>{!! __('order-guide.note-2') !!}</p>
                <p>{{ __('order-guide.note-3') }}</p>
                <p>{{ __('order-guide.note-4') }}</p>
                <h2>{{ __('order-guide.delivery') }}</h2>
                <p>{{ __('order-guide.delivery-1') }}</p>
                <p>{{ __('order-guide.delivery-2') }}</p>
                <p>{!! __('order-guide.delivery-3') !!}</p>
                <h2>{{ __('order-guide.order-receive') }}</h2>
                <p>{{ __('order-guide.order-receive-1') }}</p>
                <p>{{ __('order-guide.order-receive-2') }}</p>
                <p>{{ __('order-guide.order-receive-3') }}</p>
                <p>{{ __('order-guide.order-receive-4') }}</p>
                <h2>{{ __('order-guide.payment-method') }}</h2>
                <p>{{ __('order-guide.payment-method-1') }}</p>
                <p>{{ __('order-guide.payment-method-2') }}</p>
                <p>{{ __('order-guide.payment-method-3') }}</p>
                <p>{{ __('order-guide.payment-method-4') }}</p>
                <p>{{ __('order-guide.payment-method-5') }}</p>
                <h2>{{ __('order-guide.warning') }}</h2>
                <p>{!! __('order-guide.warning-1') !!}</p>
                <h2>{{ __('order-guide.customer-note') }}</h2>
                <p>{{ __('order-guide.customer-note-1') }}</p>
                <p>{{ __('order-guide.customer-note-2') }}</p>
                <p>{{ __('order-guide.customer-note-3') }}</p>
                <p>{{ __('order-guide.customer-note-4') }}</p>
                <p>{{ __('order-guide.customer-note-5') }}</p>
            </div>
        </div>
    </section>
@endsection
