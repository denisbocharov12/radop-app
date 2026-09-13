@extends('frontend.v1.layouts.layout-without-errors')

@section('sf-page', 1)

@section('content')
    @php
        // `type_id` 1 is the private customer; anything else (or nothing) opens
        // on the business tab, which is what the old markup did too.
        $active = old('type_id') === '1' ? 'fiz' : 'iur';
    @endphp

    <x-sf-breadcrumbs :with-shop="false" :items="[['url' => null, 'name' => __('theme.registration')]]" />

    <div class="sf-container pb-16">
        <h1 class="mb-1 mt-2 text-2xl font-bold text-ink-900 lg:text-3xl">{{ __('theme.registration') }}</h1>
        <p class="mb-6 text-sm text-ink-500">
            {{ __('theme.log-in-account') }}?
            <a href="javascript:;" data-sf-auth-open class="font-medium text-brand-600 hover:text-brand-700">
                {{ __('theme.enter') }}
            </a>
        </p>

        {{--
            Tabs are radio inputs, so switching needs no JavaScript and the
            chosen panel survives a validation redirect through `old('type_id')`.
        --}}
        <div class="flex max-w-3xl flex-wrap items-start gap-2">
            {{-- Both radios precede everything they style: Tailwind's `peer`
                 variant compiles to a general-sibling selector, so the labels
                 and panels have to be siblings, not descendants of a wrapper. --}}
            <input type="radio" name="sf-register-tab" id="sf-tab-iur" class="peer/iur sf-sr-only" @checked($active === 'iur')>
            <input type="radio" name="sf-register-tab" id="sf-tab-fiz" class="peer/fiz sf-sr-only" @checked($active === 'fiz')>

            <label for="sf-tab-iur" class="sf-tab peer-checked/iur:sf-tab-active">{{ __('theme.legal-person') }}</label>
            <label for="sf-tab-fiz" class="sf-tab peer-checked/fiz:sf-tab-active">{{ __('theme.physical-person') }}</label>

            <div class="mt-4 hidden w-full peer-checked/iur:block">
                @include('frontend.v1.pages.registration.components.form', ['variant' => 'iur'])
            </div>

            <div class="mt-4 hidden w-full peer-checked/fiz:block">
                @include('frontend.v1.pages.registration.components.form', ['variant' => 'fiz'])
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/imask@7/dist/imask.min.js" defer></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            /* Input masks — the phone shape and the digits-only fiscal code are
               the two the previous page applied, now driven by data attributes
               so a new masked field needs no extra script. */
            var applyMasks = function () {
                if (typeof IMask !== 'function') return;
                document.querySelectorAll('[data-sf-mask=phone]').forEach(function (input) {
                    IMask(input, { mask: '{\\0} 00 00 00 00', lazy: false, overwrite: 'shift' });
                });
                document.querySelectorAll('[data-sf-mask=digits]').forEach(function (input) {
                    IMask(input, { mask: /^\d+$/ });
                });
            };
            window.IMask ? applyMasks() : window.addEventListener('load', applyMasks);

            /* Password reveal and the live length rule are shared with the
               account page, so they live in storefront/lib/vitals.js. */
        });
    </script>
@endsection
