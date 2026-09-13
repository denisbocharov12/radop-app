@extends('frontend.v1.layouts.layout')

@section('sf-page', 1)

@section('content')
    <div class="sf-container py-10 lg:py-16">
        <div class="sf-card mx-auto max-w-xl px-6 py-10 text-center">
            <span class="mx-auto mb-5 flex h-16 w-16 items-center justify-center rounded-full bg-success-50 text-success-600">
                <x-sf-icon name="check" :size="34" stroke-width="2.25" />
            </span>

            <p class="mb-1 text-sm font-semibold uppercase tracking-wide text-success-600">{{ __('theme.sf-order-thanks') }}</p>
            <h1 class="text-2xl font-bold text-ink-900">{{ __('theme.order-successfully-placed') }}</h1>
            <p class="mx-auto mt-3 max-w-md text-sm leading-relaxed text-ink-600">{{ __('theme.check-email') }}</p>

            <div class="mt-7 flex flex-col justify-center gap-2 sm:flex-row">
                @auth('user')
                    <a href="{{ route('theme.user.orders.index') }}" class="sf-btn-primary">
                        <x-sf-icon name="receipt" :size="16" />{{ __('theme.my-orders') }}
                    </a>
                @endauth
                <a href="{{ route('theme.shop.catalog') }}" class="sf-btn-secondary">{{ __('theme.go-to-catalog') }}</a>
                <a href="{{ route('theme.home') }}" class="sf-btn-ghost">{{ __('theme.on-homepage') }}</a>
            </div>
        </div>
    </div>

    @include('frontend.v1.pages.cart.parts.tabs')
@endsection

@section('scripts')
    @php
        $ga4Purchase = session((string) config('analytics.json_payload_keys.order_completed_purchase'));
        $ga4PurchaseEcommerce = is_array($ga4Purchase) ? [
            'transaction_id' => $ga4Purchase['transaction_id'] ?? '',
            'value' => (float) ($ga4Purchase['value'] ?? 0),
            'currency' => $ga4Purchase['currency'] ?? config('analytics.currency', 'MDL'),
            'items' => $ga4Purchase['items'] ?? [],
        ] : null;
    @endphp

    @if($ga4PurchaseEcommerce)
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                window.dataLayer = window.dataLayer || [];
                // Custom event (GTM triggers)
                window.dataLayer.push({ ecommerce: null });
                window.dataLayer.push({
                    event: @json(config('analytics.data_layer_event_names.order_completed_purchase')),
                    ecommerce: @json($ga4PurchaseEcommerce)
                });
                // Standard GA4 'purchase' event (Google Ads conversion + GA4 reports)
                window.dataLayer.push({ ecommerce: null });
                window.dataLayer.push({
                    event: 'purchase',
                    ecommerce: @json($ga4PurchaseEcommerce)
                });
            });
        </script>
    @endif
@endsection
