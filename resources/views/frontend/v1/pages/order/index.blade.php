@extends('frontend.v1.layouts.layout')

@section('sf-page', 1)

@section('content')
    @php
        $statusTone = static fn (?string $status): string => match (true) {
            $status === null => 'bg-ink-100 text-ink-600',
            str_contains($status, 'cancel') => 'bg-danger-50 text-danger-600',
            str_contains($status, 'complet'), str_contains($status, 'deliver'), str_contains($status, 'done') => 'bg-success-50 text-success-600',
            default => 'bg-brand-50 text-brand-700',
        };
    @endphp

    <x-sf-account-shell :title="__('theme.my-orders')">
        @if(! $user->orders->count())
            <div class="sf-card px-6 py-14 text-center">
                <x-sf-icon name="receipt" :size="40" class="mx-auto mb-3 text-ink-300" />
                <p class="text-md font-medium text-ink-700">{{ __('theme.no-orders') }}</p>
                <a href="{{ route('theme.shop.catalog') }}" class="sf-btn-primary mt-5 inline-flex">{{ __('theme.go-to-catalog') }}</a>
            </div>
        @else
            <ul class="space-y-3">
                @foreach($orders as $order)
                    @php
                        $firstLine = $order->products->first();
                        $firstTitle = $firstLine ? $products->where('id', $firstLine->product_id)->first()?->title : null;
                        $statusLabel = $orderStatus[$order->status] ?? $order->status;
                    @endphp
                    <li class="sf-card p-4">
                        <div class="flex flex-wrap items-start justify-between gap-3">
                            <div class="min-w-0 flex-1">
                                <div class="flex flex-wrap items-center gap-2">
                                    <h2 class="text-md font-bold text-ink-900">{{ __('theme.order-number') }}{{ $order->order_number }}</h2>
                                    <span class="rounded-full px-2.5 py-0.5 text-2xs font-semibold {{ $statusTone($order->status) }}">{{ $statusLabel }}</span>
                                </div>
                                <p class="mt-1 text-xs text-ink-500">
                                    {{ __('theme.from') }} <time datetime="{{ $order->created_at?->toIso8601String() }}">{{ $order->created_at?->format('d.m.Y H:i') }}</time>
                                    · {{ $order->products->count() }} {{ __('theme.sort-products') }}
                                </p>
                                @if($firstTitle)
                                    <p class="mt-2 line-clamp-1 text-sm text-ink-700">
                                        {{ $firstTitle }}@if($order->products->count() > 1) <span class="text-ink-400">+{{ $order->products->count() - 1 }}</span>@endif
                                    </p>
                                @endif
                            </div>

                            <p class="text-right">
                                <span class="block text-lg font-bold text-ink-900">{{ number_format((float) $order->total, 2, ',', ' ') }}</span>
                                <span class="text-xs text-ink-500">{{ __('theme.MDL') }}</span>
                            </p>
                        </div>

                        <div class="mt-3 flex flex-wrap gap-2 border-t border-ink-100 pt-3">
                            <a href="{{ route('theme.user.orders.repeat', $order) }}" class="sf-btn-primary sf-btn-sm">
                                <x-sf-icon name="cart" :size="15" />{{ __('theme.order-repeat') }}
                            </a>
                            <a href="{{ route('theme.user.orders.view.invoice', $order) }}" class="sf-btn-secondary sf-btn-sm">
                                <x-sf-icon name="receipt" :size="15" />{{ __('theme.order-view-invoice') }}
                            </a>
                            <a href="{{ route('theme.user.orders.download.invoice', $order) }}" class="sf-btn-ghost sf-btn-sm">
                                <x-sf-icon name="download" :size="15" />{{ __('theme.order-download-invoice') }}
                            </a>
                        </div>
                    </li>
                @endforeach
            </ul>

            {{ $orders->links('vendor.pagination.sf') }}
        @endif
    </x-sf-account-shell>
@endsection
