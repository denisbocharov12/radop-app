@extends('frontend.v1.layouts.layout')

@section('content')
    <section class="gratitude">
        <div class="container">
            <div class="gratitude__body">
                <div class="gratitude__content">
                    <div class="gratitude__icon">
                        <i class="icon-ok"></i>
                    </div>
                    <h1 class="gratitude__title">{{__('theme.order-successfully-placed')}}</h1>
                        <p class="gratitude__">{{__('theme.check-email')}}</p>
                    <div class="gratitude__row">
                        <a class="gratitude__link" href="{{route('theme.home')}}">{{__('theme.on-homepage')}}</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('frontend.v1.pages.cart.parts.tabs')
@endsection
@section('scripts')
    <script>
        @php($ga4Purchase = session((string) config('analytics.json_payload_keys.order_completed_purchase')))
        @if(is_array($ga4Purchase))
        $(function () {
            window.dataLayer = window.dataLayer || [];
            window.dataLayer.push({ ecommerce: null });
            window.dataLayer.push({
                event: @json(config('analytics.data_layer_event_names.order_completed_purchase')),
                ecommerce: {
                    transaction_id: @json($ga4Purchase['transaction_id'] ?? ''),
                    value: {{ (float) ($ga4Purchase['value'] ?? 0) }},
                    currency: @json($ga4Purchase['currency'] ?? config('analytics.currency', 'MDL')),
                    items: @json($ga4Purchase['items'] ?? [])
                }
            });
        });
        @endif
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
