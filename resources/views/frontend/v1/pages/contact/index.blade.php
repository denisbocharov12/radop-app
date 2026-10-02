@extends('frontend.v1.layouts.layout')

@section('sf-page', 1)

@section('content')
    @php
        /*
         * Contact details as data rather than three hand-copied Bootstrap
         * columns. Numbers and addresses are unchanged; the dead commented-out
         * warehouse block was dropped rather than carried forward.
         */
        $departments = [
            [
                'title' => __('contact.online_store'),
                'phones' => [['0 (22) 78 21 12', '+37322782112'], ['079 78 21 12', '+37379782112']],
                'email' => 'support@radop.md',
            ],
            [
                'title' => __('contact.wholesale_clients'),
                'phones' => [['0 (22) 78 21 00', '+37322782100'], ['060 90 88 20', '+37360908820']],
                'email' => 'sales@radop.md',
            ],
            [
                'title' => __('contact.corporate_clients'),
                'phones' => [['0 (22) 78 21 01', '+37322782101'], ['060 90 88 22', '+37360908822']],
                'email' => 'sales@radop.md',
            ],
        ];

        $locations = [
            [
                'title' => __('contact.our_contacts'),
                'address' => __('contact.chisinau') . ' ' . __('contact.street_sarmizegetusa'),
                'hours' => [
                    __('contact.monday_friday') . ' ' . __('contact.time_0800_1700'),
                    __('contact.saturday') . ', ' . __('contact.sunday') . ' ' . __('contact.weekends'),
                ],
                'phones' => [],
                'email' => null,
            ],
            [
                'title' => __('contact.brand_store'),
                'address' => __('contact.chisinau') . ' ' . __('contact.street_sarmizegetusa'),
                'hours' => [
                    __('contact.monday_friday') . ' ' . __('contact.time_0830_1930'),
                    __('contact.saturday') . ': ' . __('contact.time_0830_1700'),
                    __('contact.sunday') . ' ' . __('contact.weekend'),
                ],
                'phones' => [['0 (22) 78 21 11', '+37322782111']],
                'email' => 'contextlux@yandex.ru',
            ],
        ];
    @endphp

    <x-sf-breadcrumbs :with-shop="false" :items="[['url' => null, 'name' => __('contact.our_contacts')]]" />

    <div class="sf-container">
        <h1 class="sf-page-title">{{ __('contact.our_contacts') }}</h1>

        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($departments as $department)
                <div class="sf-card p-4">
                    <h2 class="mb-3 text-md font-bold text-ink-900">{{ $department['title'] }}</h2>
                    <ul class="space-y-2 text-sm">
                        @foreach($department['phones'] as [$label, $number])
                            <li>
                                <a href="tel:{{ $number }}" class="flex items-center gap-2 font-medium text-ink-800 hover:text-brand-600">
                                    <x-sf-icon name="phone" :size="15" class="text-brand-600" />{{ $label }}
                                </a>
                            </li>
                        @endforeach
                        <li>
                            <a href="mailto:{{ $department['email'] }}" class="flex items-center gap-2 text-ink-600 hover:text-brand-600">
                                <x-sf-icon name="mail" :size="15" class="text-brand-600" />{{ $department['email'] }}
                            </a>
                        </li>
                    </ul>
                </div>
            @endforeach
        </div>

        <div class="mt-8 grid gap-6 lg:grid-cols-[1fr_1.2fr] lg:items-start">
            <div class="space-y-4">
                @foreach($locations as $location)
                    <div class="sf-card p-4">
                        <h2 class="mb-3 text-md font-bold text-ink-900">{{ $location['title'] }}</h2>

                        <p class="flex items-start gap-2 text-sm text-ink-700">
                            <x-sf-icon name="building" :size="15" class="mt-0.5 text-brand-600" />
                            <span>{{ $location['address'] }}</span>
                        </p>

                        <div class="mt-3 flex items-start gap-2 text-sm text-ink-600">
                            <x-sf-icon name="clock" :size="15" class="mt-0.5 text-brand-600" />
                            <div class="space-y-0.5">
                                @foreach($location['hours'] as $line)
                                    <p>{{ $line }}</p>
                                @endforeach
                            </div>
                        </div>

                        @foreach($location['phones'] as [$label, $number])
                            <p class="mt-3">
                                <a href="tel:{{ $number }}" class="flex items-center gap-2 text-sm font-medium text-ink-800 hover:text-brand-600">
                                    <x-sf-icon name="phone" :size="15" class="text-brand-600" />{{ $label }}
                                </a>
                            </p>
                        @endforeach

                        @if($location['email'])
                            <p class="mt-2">
                                <a href="mailto:{{ $location['email'] }}" class="flex items-center gap-2 text-sm text-ink-600 hover:text-brand-600">
                                    <x-sf-icon name="mail" :size="15" class="text-brand-600" />{{ $location['email'] }}
                                </a>
                            </p>
                        @endif
                    </div>
                @endforeach
            </div>

            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2721.3464825991464!2d28.8620954763489!3d46.994169330068!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x40c979000d7b986b%3A0xd6b10473ab164368!2sRadop!5e0!3m2!1sru!2s!4v1743005622222!5m2!1sru!2s"
                class="h-[26rem] w-full rounded-lg border border-ink-200"
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"
                title="{{ __('contact.address') }}"
                allowfullscreen
            ></iframe>
        </div>

        <div class="sf-card mt-8 p-5">
            <h2 class="mb-3 text-md font-bold text-ink-900">{{ __('contact.support_service') }}</h2>
            <div class="sf-prose max-w-none">
                <p>{{ __('contact.support_text_1') }}</p>
                <p>{{ __('contact.support_text_2') }}</p>
            </div>
            <div class="mt-4 flex flex-wrap gap-x-6 gap-y-2 text-sm">
                <a href="tel:+37322782112" class="flex items-center gap-2 font-medium text-ink-800 hover:text-brand-600">
                    <x-sf-icon name="phone" :size="15" class="text-brand-600" />022 78 21 12
                </a>
                <a href="tel:+37379782112" class="flex items-center gap-2 font-medium text-ink-800 hover:text-brand-600">
                    <x-sf-icon name="phone" :size="15" class="text-brand-600" />079 78 21 12
                </a>
                <a href="mailto:support@radop.md" class="flex items-center gap-2 text-ink-600 hover:text-brand-600">
                    <x-sf-icon name="mail" :size="15" class="text-brand-600" />support@radop.md
                </a>
            </div>
        </div>
    </div>
@endsection
