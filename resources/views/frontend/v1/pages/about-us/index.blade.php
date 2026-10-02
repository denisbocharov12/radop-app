@extends('frontend.v1.layouts.layout')

@section('sf-page', 1)

@section('content')
    @php
        /*
         * The lang file already holds these as lists; rendering each entry as a
         * loose <p> made the page a wall of one-line paragraphs. They are cards
         * and lists now — same strings, no new copy.
         */
        $activities = [
            ['truck', __('about-us.wholesale_distribution'), __('about-us.wholesale_distribution_desc')],
            ['building', __('about-us.retail_supplies'), __('about-us.retail_supplies_desc')],
            ['cart', __('about-us.online_supplies'), __('about-us.online_supplies_desc')],
            ['box', __('about-us.own_production'), __('about-us.own_production_desc')],
        ];

        $companyDetails = [
            __('about-us.company_details.name'),
            __('about-us.company_details.address'),
            __('about-us.company_details.fiscal_code'),
            __('about-us.company_details.vat'),
            __('about-us.company_details.bank'),
            __('about-us.company_details.iban'),
            __('about-us.company_details.bic'),
        ];
    @endphp

    <x-sf-breadcrumbs :with-shop="false" :items="[['url' => null, 'name' => __('about-us.about-us')]]" />

    <div class="sf-container">
        <h1 class="sf-page-title mb-2 lg:mb-3">{{ __('about-us.about-us') }}</h1>
        <p class="mb-6 max-w-[70ch] text-md text-ink-600">{{ __('about-us.welcome') }}</p>

        <div class="sf-prose max-w-none">
            <p>{{ __('about-us.about') }}</p>
            <p>{!! __('about-us.mission') !!}</p>
        </div>

        <section class="sf-section">
            <h2 class="sf-section-title mb-4">{{ __('about-us.offers') }}</h2>
            <div class="sf-prose max-w-none">
                <p>{{ __('about-us.offers-1') }}</p>
                <p>{{ __('about-us.brands') }}</p>
            </div>
        </section>

        <section class="sf-section pt-0">
            <h2 class="sf-section-title mb-4">{{ __('about-us.activities') }}</h2>
            <div class="grid gap-4 sm:grid-cols-2">
                @foreach($activities as [$icon, $title, $text])
                    <div class="sf-card p-4">
                        <span class="mb-3 flex h-10 w-10 items-center justify-center rounded-lg bg-brand-50 text-brand-600">
                            <x-sf-icon :name="$icon" :size="20" />
                        </span>
                        <h3 class="mb-1 text-md font-semibold text-ink-900">{{ $title }}</h3>
                        <p class="text-sm leading-relaxed text-ink-600">{{ $text }}</p>
                    </div>
                @endforeach
            </div>
        </section>

        @foreach([
            [__('about-us.categories'), __('about-us.categories_list')],
            [__('about-us.products'), __('about-us.products_list')],
            [__('about-us.own_production_details'), __('about-us.own_production_list')],
        ] as [$title, $list])
            <section class="sf-section pt-0">
                <h2 class="sf-section-title mb-4">{{ $title }}</h2>
                <ul class="grid gap-x-6 gap-y-1.5 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach($list as $entry)
                        <li class="flex items-start gap-2 text-sm text-ink-700">
                            <x-sf-icon name="check" :size="14" class="mt-1 text-brand-600" />
                            <span>{{ $entry }}</span>
                        </li>
                    @endforeach
                </ul>
            </section>
        @endforeach

        <section class="sf-section pt-0">
            <h2 class="sf-section-title mb-4">{{ __('about-us.advantages') }}</h2>
            <ul class="grid gap-3 sm:grid-cols-2">
                @foreach(__('about-us.advantages_list') as $advantage)
                    <li class="flex items-start gap-2.5 rounded-lg bg-ink-50 p-3 text-sm text-ink-700">
                        <x-sf-icon name="star" :size="16" class="mt-0.5 shrink-0 text-accent-500" />
                        <span>{{ $advantage }}</span>
                    </li>
                @endforeach
            </ul>
        </section>

        <section class="sf-section pt-0">
            <h2 class="sf-section-title mb-4">{{ __('about-us.company_info') }}</h2>
            <div class="sf-card p-5">
                <ul class="space-y-1.5 text-sm text-ink-700">
                    @foreach($companyDetails as $detail)
                        <li>{{ $detail }}</li>
                    @endforeach
                    <li>{!! __('about-us.company_details.phone') !!}</li>
                    <li>{!! __('about-us.company_details.email') !!}</li>
                </ul>
            </div>
        </section>

        <p class="rounded-lg bg-brand-600 px-6 py-5 text-center text-lg font-semibold text-white">
            {{ __('about-us.slogan') }}
        </p>
    </div>
@endsection
