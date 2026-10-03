@extends('frontend.v1.layouts.layout')

@section('sf-page', 1)

@section('content')
    @php
        /*
         * Checkout. Field names, ids, the form action, the delivery/minimum-sum
         * data attributes and the GA4 events are exactly the legacy ones — the
         * server side is untouched. What changed:
         *  - the submit is a real <button form="checkout"> instead of a link
         *    submitted by jQuery, and it is disabled after the first click;
         *  - the delivery charge row the recalculation script wrote to
         *    (`#delivery-charge`) now exists;
         *  - the branch picker updates the totals too, not only the city picker;
         *  - the basket lines are visible next to the total.
         */
        $sessionId = $user ? $user->id : config('shopping_cart.default_session_id');
        $cart = \Cart::session($sessionId);

        $isBusiness = $user?->type?->key_name === 'iur';
        $usesFilials = $isBusiness && $user->filials->count() > 0;

        $minSum = (float) $user->minOrderSum();
        $isSupplement = $user->isSupplementWindowOpen();
        $cartTotal = (float) $cart->getTotal();
        $belowMin = ! $isSupplement && $cartTotal < $minSum;
        $cartRemaining = max($minSum - $cartTotal, 0);
        $initialDelivery = (float) ($user?->city?->delivery_sum ?? 0);

        $lines = $cart->getContent()->sortBy('attributes.added_at');
        $money = static fn ($value) => number_format((float) $value, 2, '.', '');
    @endphp

    <x-sf-breadcrumbs
        :with-shop="false"
        :items="[['url' => route('theme.cart.index'), 'name' => __('theme.cart')], ['url' => null, 'name' => __('theme.order-placement')]]"
    />

    <div class="sf-container">
        <h1 class="mb-5 mt-2 text-2xl font-bold text-ink-900 lg:text-3xl">{{ __('theme.order-placement') }}</h1>

        @if($cart->isEmpty())
            <div class="sf-card px-6 py-16 text-center">
                <x-sf-icon name="cart" :size="44" class="mx-auto mb-3 text-ink-300" />
                <p class="text-lg font-semibold text-ink-800">{{ __('theme.empty-cart') }}</p>
                <a href="{{ route('theme.shop.catalog') }}" class="sf-btn-primary mt-5 inline-flex">{{ __('theme.сontinue-shopping') }}</a>
            </div>
        @else
            <div
                id="checkout-min-banner"
                class="mb-5 flex gap-3 rounded-lg border border-accent-200 bg-accent-50 p-3.5 text-sm text-accent-800"
                role="alert"
                @unless($belowMin) hidden @endunless
            >
                <x-sf-icon name="info" :size="18" class="mt-0.5 shrink-0" />
                <p>
                    {{ __('theme.min_order_sum_warning_message') }}
                    <b><span class="cmb-min">{{ $money($minSum) }}</span> {{ __('theme.MDL') }}</b>.
                    <b class="whitespace-nowrap">{{ __('theme.min_order_add_more') }} <span class="cmb-remaining">{{ $money($cartRemaining) }}</span> {{ __('theme.MDL') }}</b>
                    <a href="{{ route('theme.delivery.index') }}" class="ml-1 underline underline-offset-2">{{ __('theme.min_order_delivery_link') }}</a>
                </p>
            </div>

            <div class="grid gap-6 lg:grid-cols-[minmax(0,1fr)_22rem] lg:items-start">
                <form action="{{ route('theme.checkout.store') }}" method="POST" id="checkout" class="sf-card p-5">
                    @csrf

                    <h2 class="mb-4 flex items-center gap-2 text-md font-bold text-ink-900">
                        <span class="flex h-6 w-6 items-center justify-center rounded-full bg-brand-600 text-xs text-white">1</span>
                        {{ __('theme.personal-information') }}
                    </h2>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <label class="block">
                            <span class="sf-label">{{ $isBusiness ? __('theme.fio_iur') : __('theme.fio') }}<span class="text-danger-500">*</span></span>
                            <input
                                type="text"
                                name="fio"
                                id="fio"
                                required
                                autocomplete="{{ $isBusiness ? 'organization' : 'name' }}"
                                class="sf-field @error('fio') sf-field-error @enderror"
                                value="{{ old('fio', $isBusiness ? $user?->profile?->organization_name : trim(($user?->profile?->first_name ?? '') . ' ' . ($user?->profile?->last_name ?? ''))) }}"
                            />
                            @error('fio')<span class="sf-error">{{ $message }}</span>@enderror
                        </label>

                        <label class="block">
                            <span class="sf-label">{{ __('theme.phone-number') }}<span class="text-danger-500">*</span></span>
                            <input
                                type="tel"
                                name="phone"
                                id="phone"
                                required
                                autocomplete="tel"
                                class="sf-field @error('phone') sf-field-error @enderror"
                                value="{{ old('phone', $user?->profile?->phone) }}"
                            />
                            @error('phone')<span class="sf-error">{{ $message }}</span>@enderror
                        </label>

                        <label class="block sm:col-span-2">
                            <span class="sf-label">Email<span class="text-danger-500">*</span></span>
                            <input
                                type="email"
                                name="email"
                                id="email"
                                required
                                autocomplete="email"
                                class="sf-field @error('email') sf-field-error @enderror"
                                value="{{ old('email', $user?->email) }}"
                            />
                            @error('email')<span class="sf-error">{{ $message }}</span>@enderror
                        </label>
                    </div>

                    <h2 class="mb-4 mt-7 flex items-center gap-2 text-md font-bold text-ink-900">
                        <span class="flex h-6 w-6 items-center justify-center rounded-full bg-brand-600 text-xs text-white">2</span>
                        {{ __('theme.delivery') }}
                    </h2>

                    <div class="grid gap-4 sm:grid-cols-2">
                        @if($usesFilials)
                            <label class="block sm:col-span-2">
                                <span class="sf-label">{{ __('theme.select_filial') }}<span class="text-danger-500">*</span></span>
                                <select
                                    name="filial_id"
                                    id="filial_id"
                                    required
                                    class="sf-field pr-8 @error('filial_id') sf-field-error @enderror"
                                    data-sf-delivery-select
                                >
                                    <option value="" data-delivery-charge="0" data-required-sum="{{ $minSum }}">{{ __('theme.select_filial') }}</option>
                                    @foreach($user->filials as $filial)
                                        <option
                                            value="{{ $filial->id }}"
                                            data-delivery-charge="{{ (float) $filial->city?->delivery_sum }}"
                                            data-required-sum="{{ (float) $filial->city?->required_sum }}"
                                            @selected((string) old('filial_id') === (string) $filial->id)
                                        >{{ $filial->address }}@if($filial->city) — {{ $filial->city->name }}@endif</option>
                                    @endforeach
                                </select>
                                @error('filial_id')<span class="sf-error">{{ $message }}</span>@enderror
                            </label>
                        @else
                            <label class="block">
                                <span class="sf-label">{{ __('theme.select-city') }}</span>
                                <select
                                    name="city_id"
                                    id="city_id"
                                    class="sf-field pr-8 @error('city_id') sf-field-error @enderror"
                                    data-sf-delivery-select
                                >
                                    <option value="0" data-delivery-charge="0" data-required-sum="{{ $minSum }}" @selected(! $user?->city_id)>{{ __('theme.select-city') }}</option>
                                    @foreach($cities as $city)
                                        <option
                                            value="{{ $city->id }}"
                                            data-delivery-charge="{{ (float) $city->delivery_sum }}"
                                            data-required-sum="{{ (float) $city->required_sum }}"
                                            @selected((int) old('city_id', $user?->city_id) === $city->id)
                                        >{{ $city->name }}</option>
                                    @endforeach
                                </select>
                                @error('city_id')<span class="sf-error">{{ $message }}</span>@enderror
                            </label>

                            <label class="block">
                                <span class="sf-label">{{ __('theme.full-address') }}<span class="text-danger-500">*</span></span>
                                <input
                                    type="text"
                                    name="address"
                                    id="address"
                                    required
                                    autocomplete="street-address"
                                    class="sf-field @error('address') sf-field-error @enderror"
                                    value="{{ old('address', $user?->profile?->address) }}"
                                />
                                @error('address')<span class="sf-error">{{ $message }}</span>@enderror
                            </label>
                        @endif

                        <label class="block {{ $usesFilials ? 'sm:col-span-2' : '' }}">
                            <span class="sf-label">{{ __('theme.payment-method') }}<span class="text-danger-500">*</span></span>
                            <select name="payment_method" id="payment_method" required class="sf-field pr-8 @error('payment_method') sf-field-error @enderror">
                                @foreach($paymentMethods as $key => $label)
                                    <option
                                        value="{{ $key }}"
                                        @selected(old('payment_method', $isBusiness && $usesFilials ? 'transfer' : null) === $key)
                                    >{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('payment_method')<span class="sf-error">{{ $message }}</span>@enderror
                        </label>
                    </div>

                    <details class="group mt-4 rounded-lg border border-ink-200 px-3.5 py-3" @if(old('recommended_time')) open @endif>
                        <summary class="flex cursor-pointer list-none items-center justify-between gap-3 text-sm text-ink-700">
                            <span class="flex items-center gap-2"><x-sf-icon name="clock" :size="16" class="text-brand-600" />{{ __('theme.recommended_time_title') }}</span>
                            <x-sf-icon name="chevronDown" :size="16" class="shrink-0 text-ink-400 transition-transform group-open:rotate-180" />
                        </summary>
                        <label class="mt-3 block">
                            <span class="sf-label">{{ __('theme.recommended_time_heading') }}</span>
                            <input type="text" name="recommended_time" id="recommended_time" class="sf-field" value="{{ old('recommended_time') }}" />
                        </label>
                    </details>

                    <label class="mt-4 block">
                        <span class="sf-label">{{ __('theme.comment') }}</span>
                        <textarea name="note" id="note" rows="4" class="sf-field resize-y">{{ old('note') }}</textarea>
                    </label>
                </form>

                <aside class="sf-card space-y-4 p-4 lg:sticky lg:top-24" id="checkout-summary">
                    <h2 class="text-md font-bold text-ink-900">{{ __('theme.invoice-payable') }}</h2>

                    <details class="group rounded-lg bg-ink-50 px-3 py-2.5" open>
                        <summary class="flex cursor-pointer list-none items-center justify-between text-sm font-medium text-ink-700">
                            {{ $lines->count() }} {{ __('theme.cart-quantity') }}
                            <x-sf-icon name="chevronDown" :size="15" class="text-ink-400 transition-transform group-open:rotate-180" />
                        </summary>
                        <ul class="mt-2 max-h-64 space-y-2 overflow-y-auto pr-1">
                            @foreach($lines as $line)
                                <li class="flex items-start justify-between gap-3 text-xs">
                                    <span class="min-w-0 text-ink-700"><span class="line-clamp-2">{{ $line->associatedModel?->title ?? $line->name }}</span><span class="text-ink-400">{{ $line->quantity }} ×</span></span>
                                    <span class="shrink-0 font-semibold text-ink-900">{{ $money($line->price * $line->quantity) }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </details>

                    <dl class="space-y-2 text-sm">
                        <div class="flex justify-between"><dt class="text-ink-500">{{ __('theme.summary') }}</dt><dd class="font-medium text-ink-800">{{ $money($cartTotal) }} {{ __('theme.MDL') }}</dd></div>
                        <div class="flex justify-between"><dt class="text-ink-500">{{ __('theme.delivery') }}</dt><dd class="font-medium text-ink-800"><span id="delivery-charge">{{ $money($initialDelivery) }}</span> {{ __('theme.MDL') }}</dd></div>
                        <div class="flex justify-between"><dt class="text-ink-500">{{ __('theme.discount') }}</dt><dd class="font-medium text-ink-800">0.00 {{ __('theme.MDL') }}</dd></div>
                    </dl>

                    <p class="flex items-baseline justify-between border-t border-ink-100 pt-3">
                        <span class="text-sm font-semibold text-ink-700">{{ __('theme.for-payment') }}</span>
                        <span class="text-2xl font-bold text-ink-900">
                            <span id="checkout-final-price" data-total="{{ $cartTotal }}">{{ $money($cartTotal + $initialDelivery) }}</span>
                            <span class="text-sm font-medium text-ink-500">{{ __('theme.MDL') }}</span>
                        </span>
                    </p>

                    @if($isSupplement)
                        <p class="rounded-md bg-brand-50 p-2.5 text-xs text-brand-700">
                            {{ __('theme.supplement_order_note') }} <b>{{ $user->supplementParentNumber() }}</b>
                        </p>
                    @endif

                    <button
                        type="submit"
                        form="checkout"
                        class="sf-btn-primary sf-btn-block sf-btn-lg"
                        data-sf-checkout-submit
                        @if($belowMin) hidden @endif
                    >
                        <x-sf-icon name="check" :size="18" />{{ __('theme.place-order') }}
                    </button>

                    <a href="{{ route('theme.cart.index') }}" class="sf-btn-ghost sf-btn-block">
                        <x-sf-icon name="chevronLeft" :size="16" />{{ __('theme.cart') }}
                    </a>
                </aside>
            </div>

            {{-- Phones: total + submit stay reachable while filling the form. --}}
            <div
                class="fixed inset-x-0 bottom-[calc(3.5rem+env(safe-area-inset-bottom))] z-header translate-y-full border-t border-ink-200 bg-white/95 px-4 py-2.5 opacity-0 shadow-pop backdrop-blur transition-all duration-200 ease-sf data-[visible=true]:translate-y-0 data-[visible=true]:opacity-100 lg:hidden"
                data-sf-sticky-when-hidden="#checkout-summary"
                data-visible="false"
                aria-hidden="true"
            >
                <div class="mx-auto flex max-w-lg items-center gap-3">
                    <p class="min-w-0 flex-1">
                        <span class="block text-xs text-ink-500">{{ __('theme.for-payment') }}</span>
                        <span class="text-lg font-bold text-ink-900"><span data-sf-checkout-total>{{ $money($cartTotal + $initialDelivery) }}</span> <span class="text-xs font-medium text-ink-500">{{ __('theme.MDL') }}</span></span>
                    </p>
                    <a href="#checkout-summary" class="sf-btn-primary h-11 shrink-0 px-5" tabindex="-1">{{ __('theme.place-order') }}</a>
                </div>
            </div>
        @endif
    </div>

    @include('frontend.v1.pages.cart.parts.tabs')
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var events = window.radopAnalyticsDataLayerEventNames || {};

            @if(!empty($ga4Checkout))
                if (typeof window.radopGa4EcommercePush === 'function' && events.checkout_flow_started) {
                    window.radopGa4EcommercePush(events.checkout_flow_started, @json($ga4Checkout));
                }
            @endif

            var form = document.getElementById('checkout');
            if (!form) return;

            // GA4: first interaction with the form (once).
            form.addEventListener('focusin', function onFirstFocus() {
                form.removeEventListener('focusin', onFirstFocus);
                if (typeof window.radopGa4EventPush === 'function' && events.checkout_form_interaction_started) {
                    window.radopGa4EventPush(events.checkout_form_interaction_started, {
                        form_id: 'checkout',
                        form_destination: window.location.pathname
                    });
                }
            });

            /*
             * Шаги воронки: доставка и оплата. Шлём один раз на шаг и только
             * когда значение выбрано — состав корзины берём из того же набора,
             * что ушёл в begin_checkout.
             */
            @if(!empty($ga4Checkout))
            var checkoutEcommerce = @json($ga4Checkout);
            var sentSteps = {};

            function pushCheckoutStep(key, extra) {
                if (sentSteps[key] || typeof window.radopGa4EcommercePush !== 'function' || !events[key]) return;
                sentSteps[key] = true;
                var payload = Object.assign({}, checkoutEcommerce, extra || {});
                window.radopGa4EcommercePush(events[key], payload);
            }

            function labelOf(select) {
                var option = select.options[select.selectedIndex];
                return option ? (option.textContent || '').replace(/\s+/g, ' ').trim() : '';
            }

            document.querySelectorAll('[data-sf-delivery-select]').forEach(function (select) {
                select.addEventListener('change', function () {
                    if (!select.value) return;
                    pushCheckoutStep('checkout_shipping_info_added', { shipping_tier: labelOf(select) });
                });
            });

            var paymentSelect = document.getElementById('payment_method');
            if (paymentSelect) {
                paymentSelect.addEventListener('change', function () {
                    if (!paymentSelect.value) return;
                    pushCheckoutStep('checkout_payment_info_added', { payment_type: labelOf(paymentSelect) });
                });
            }
            @endif

            // One order per click: disable the button once the browser accepts
            // the submission (invalid forms never reach this event).
            var submitButton = document.querySelector('[data-sf-checkout-submit]');
            form.addEventListener('submit', function () {
                if (submitButton) submitButton.disabled = true;
            });

            // Delivery charge and minimum-sum rule follow the chosen city/branch.
            var isSupplementOrder = @json($isSupplement);
            var finalPrice = document.getElementById('checkout-final-price');
            var total = parseFloat(finalPrice.dataset.total) || 0;
            var banner = document.getElementById('checkout-min-banner');
            var deliveryEl = document.getElementById('delivery-charge');
            var stickyTotal = document.querySelector('[data-sf-checkout-total]');

            document.querySelectorAll('[data-sf-delivery-select]').forEach(function (select) {
                select.addEventListener('change', function () {
                    var option = select.options[select.selectedIndex];
                    var requiredSum = parseFloat(option.dataset.requiredSum) || 0;
                    var deliveryCharge = parseFloat(option.dataset.deliveryCharge) || 0;
                    var belowMin = !isSupplementOrder && total < requiredSum;

                    deliveryEl.textContent = deliveryCharge.toFixed(2);
                    banner.querySelector('.cmb-min').textContent = requiredSum.toFixed(2);
                    banner.querySelector('.cmb-remaining').textContent = Math.max(requiredSum - total, 0).toFixed(2);
                    banner.hidden = !belowMin;
                    if (submitButton) submitButton.hidden = belowMin;

                    var sum = (total + deliveryCharge).toFixed(2);
                    finalPrice.textContent = sum;
                    if (stickyTotal) stickyTotal.textContent = sum;
                });
            });
        });
    </script>
@endsection
