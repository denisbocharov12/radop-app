@extends('frontend.v1.layouts.layout')

@section('sf-page', 1)

@section('content')
    @php
        /*
         * The legacy view ran two Product queries per line (and printed the
         * literal word "Address" instead of the order's address). Products are
         * loaded once here.
         */
        $productsById = \App\Models\Product::whereIn('id', $order->products->pluck('product_id'))->get()->keyBy('id');
        $statusLabel = $orderStatus[$order->status] ?? $order->status;
        $canceled = $order->status === 'canceled';
    @endphp

    <x-sf-account-shell :title="__('theme.order-number') . $order->order_number">
        <x-slot:actions>
            <a href="{{ route('theme.user.orders.repeat', $order) }}" class="sf-btn-primary">
                <x-sf-icon name="cart" :size="16" />{{ __('theme.order-repeat') }}
            </a>
        </x-slot:actions>

        <div class="sf-card mb-4 grid gap-4 p-4 sm:grid-cols-2 lg:grid-cols-4">
            <div>
                <p class="text-xs text-ink-500">{{ __('theme.order-status') }}</p>
                <span @class([
                    'mt-1 inline-block rounded-full px-2.5 py-0.5 text-xs font-semibold',
                    'bg-danger-50 text-danger-600' => $canceled,
                    'bg-brand-50 text-brand-700' => ! $canceled,
                ])>{{ $statusLabel }}</span>
            </div>
            <div>
                <p class="text-xs text-ink-500">{{ __('theme.data') }}</p>
                <p class="mt-1 text-sm font-medium text-ink-800">{{ $order->created_at?->format('d.m.Y H:i') }}</p>
            </div>
            <div>
                <p class="text-xs text-ink-500">{{ __('theme.phone-number') }}</p>
                <p class="mt-1 text-sm font-medium text-ink-800">{{ $order->phone ?: '—' }}</p>
            </div>
            <div>
                <p class="text-xs text-ink-500">{{ __('theme.order_payment_method') }}</p>
                <p class="mt-1 text-sm font-medium text-ink-800">
                    {{ match ($order->payment_method) { 'cash' => __('theme.cash'), 'card' => __('theme.card'), default => '—' } }}
                </p>
            </div>
            @if($order->address)
                <div class="sm:col-span-2 lg:col-span-4">
                    <p class="text-xs text-ink-500">{{ __('theme.address') }}</p>
                    <p class="mt-1 text-sm font-medium text-ink-800">{{ $order->address }}</p>
                </div>
            @endif
        </div>

        {{-- Table on wide screens, stacked rows on phones. --}}
        <div class="sf-card overflow-hidden">
            <table class="hidden w-full text-sm md:table">
                <thead class="bg-ink-50 text-left text-xs uppercase tracking-wide text-ink-500">
                    <tr>
                        <th class="px-4 py-3 font-semibold">{{ __('theme.code') }}</th>
                        <th class="px-4 py-3 font-semibold">{{ __('theme.product-name') }}</th>
                        <th class="px-4 py-3 text-right font-semibold">{{ __('theme.price') }}</th>
                        <th class="px-4 py-3 text-right font-semibold">{{ __('theme.order_show_qty') }}</th>
                        <th class="px-4 py-3 text-right font-semibold">{{ __('theme.order_sum') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-ink-100">
                    @foreach($order->products as $item)
                        @php($product = $productsById->get($item->product_id))
                        <tr>
                            <td class="whitespace-nowrap px-4 py-3 text-ink-500">{{ $product?->onec_id }}</td>
                            <td class="px-4 py-3">
                                @if($product)
                                    <a href="{{ route('theme.product.index', $product->slug) }}" class="font-medium text-ink-800 hover:text-brand-600">{{ $product->title }}</a>
                                @endif
                            </td>
                            <td class="whitespace-nowrap px-4 py-3 text-right text-ink-700">{{ number_format((float) $item->price, 2, ',', ' ') }}</td>
                            <td class="px-4 py-3 text-right text-ink-700">{{ $item->quantity }}</td>
                            <td class="whitespace-nowrap px-4 py-3 text-right font-semibold text-ink-900">{{ number_format((float) $item->price * $item->quantity, 2, ',', ' ') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <ul class="divide-y divide-ink-100 md:hidden">
                @foreach($order->products as $item)
                    @php($product = $productsById->get($item->product_id))
                    <li class="flex gap-3 p-3 text-sm">
                        <div class="min-w-0 flex-1">
                            <p class="font-medium text-ink-800">{{ $product?->title }}</p>
                            <p class="mt-0.5 text-xs text-ink-500">{{ $product?->onec_id }} · {{ $item->quantity }} × {{ number_format((float) $item->price, 2, ',', ' ') }}</p>
                        </div>
                        <p class="shrink-0 font-semibold text-ink-900">{{ number_format((float) $item->price * $item->quantity, 2, ',', ' ') }}</p>
                    </li>
                @endforeach
            </ul>

            <dl class="space-y-1.5 border-t border-ink-200 bg-ink-50 p-4 text-sm">
                <div class="flex justify-between"><dt class="text-ink-500">{{ __('theme.order_for_payment') }}</dt><dd class="font-medium">{{ number_format((float) $order->subtotal, 2, ',', ' ') }} {{ __('theme.MDL') }}</dd></div>
                <div class="flex justify-between"><dt class="text-ink-500">{{ __('theme.discount') }}</dt><dd class="font-medium">0,00 {{ __('theme.MDL') }}</dd></div>
                <div class="flex items-baseline justify-between border-t border-ink-200 pt-2"><dt class="font-semibold text-ink-800">{{ __('theme.for-payment') }}</dt><dd class="text-lg font-bold text-ink-900">{{ number_format((float) $order->total, 2, ',', ' ') }} {{ __('theme.MDL') }}</dd></div>
            </dl>
        </div>
    </x-sf-account-shell>
@endsection
