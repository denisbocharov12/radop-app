@extends('frontend.v1.layouts.layout')

@section('sf-page', 1)

@section('content')
    @php
        /*
         * Same copy as before, restructured: the page used four <h1> elements
         * and carried ~20 lines of commented-out paragraphs. Delivery tiers are
         * cards now, and the "attention" line is a callout rather than a
         * paragraph with a `warning` class the storefront no longer defines.
         */
        $tiers = [
            [__('delivery.conditions-1'), [__('delivery.conditions-2'), __('delivery.conditions-3'), __('delivery.conditions-4')]],
            [__('delivery.conditions-6'), [__('delivery.conditions-7'), __('delivery.conditions-8'), __('delivery.conditions-4')]],
            [__('delivery.conditions-9'), [__('delivery.conditions-10'), __('delivery.conditions-8'), __('delivery.conditions-4-1')]],
        ];

        $paymentMethods = [
            __('delivery.payment-method-1'),
            __('delivery.payment-method-2'),
            __('delivery.payment-method-3'),
        ];

        $information = [
            __('delivery.information-1'),
            __('delivery.information-2'),
            __('delivery.information-3'),
            __('delivery.information-4'),
            __('delivery.information-5'),
            __('delivery.information-6'),
        ];
    @endphp

    <x-sf-breadcrumbs :with-shop="false" :items="[['url' => null, 'name' => __('delivery.delivery')]]" />

    <div class="sf-container sf-page-body">
        <h1 class="sf-page-title">{{ __('delivery.delivery') }}</h1>

        <section>
            <h2 class="sf-section-title mb-3">{{ __('delivery.rules') }}</h2>
            <div class="sf-prose max-w-none">
                <p>{!! __('delivery.rules-1') !!}</p>
            </div>

            <p class="my-4 flex items-start gap-2.5 rounded-lg border border-accent-200 bg-accent-50 p-3.5 text-sm text-accent-800">
                <x-sf-icon name="info" :size="16" class="mt-0.5 shrink-0" />
                <span>{!! __('delivery.rules-2') !!}</span>
            </p>

            <div class="sf-prose max-w-none">
                <p>{!! __('delivery.rules-3') !!}</p>
            </div>
        </section>

        <section class="sf-section">
            <h2 class="sf-section-title mb-4">{{ __('delivery.conditions') }}</h2>
            <div class="grid gap-4 lg:grid-cols-3">
                @foreach($tiers as [$title, $lines])
                    <div class="sf-card flex flex-col p-4">
                        <span class="mb-3 flex h-10 w-10 items-center justify-center rounded-lg bg-brand-50 text-brand-600">
                            <x-sf-icon name="truck" :size="20" />
                        </span>
                        <h3 class="mb-2 text-md font-semibold text-ink-900">{!! $title !!}</h3>
                        <div class="space-y-1.5 text-sm leading-relaxed text-ink-600">
                            @foreach($lines as $line)
                                <p>{!! $line !!}</p>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        <section class="sf-section pt-0">
            <h2 class="sf-section-title mb-3">{{ __('delivery.payment-condition') }}</h2>
            <div class="sf-prose max-w-none">
                <p>{!! __('delivery.payment-condition-1') !!}</p>
            </div>
        </section>

        <section class="sf-section pt-0">
            <h2 class="sf-section-title mb-4">{{ __('delivery.payment-method') }}</h2>
            <ul class="grid gap-3 sm:grid-cols-3">
                @foreach($paymentMethods as $method)
                    <li class="flex items-start gap-2.5 rounded-lg bg-ink-50 p-3.5 text-sm text-ink-700">
                        <x-sf-icon name="check" :size="16" class="mt-0.5 shrink-0 text-success-500" />
                        <span>{!! $method !!}</span>
                    </li>
                @endforeach
            </ul>
        </section>

        <section class="sf-section pt-0">
            <h2 class="sf-section-title mb-3">{{ __('delivery.information') }}</h2>
            <div class="sf-prose max-w-none">
                @foreach($information as $line)
                    <p>{!! $line !!}</p>
                @endforeach
            </div>
        </section>
    </div>
@endsection
