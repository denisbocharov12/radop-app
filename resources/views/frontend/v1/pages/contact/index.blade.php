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
    {{-- ТЗ 16: форма заявки. Событие generate_lead шлём только после успешного
         ответа сервера, а не по клику на кнопку. --}}
    <div class="sf-container">
        <div class="sf-card mt-6 p-5 lg:p-6">
            <h2 class="text-lg font-bold text-ink-900">{{ __('contact.form_title') }}</h2>
            <p class="mt-1 text-sm text-ink-600">{{ __('contact.form_lead') }}</p>

            <form
                class="mt-4 grid gap-4 sm:grid-cols-2"
                method="POST"
                action="{{ route('theme.contacts.lead') }}"
                data-sf-lead-form
                novalidate
            >
                @csrf
                <input type="hidden" name="page" value="{{ url()->current() }}">

                <label class="block">
                    <span class="sf-label">{{ __('contact.form_name') }}<span class="text-danger-600">*</span></span>
                    <input type="text" name="name" required maxlength="120" autocomplete="name" class="sf-field">
                </label>

                <label class="block">
                    <span class="sf-label">{{ __('contact.form_phone') }}</span>
                    <input type="tel" name="phone" maxlength="40" autocomplete="tel" class="sf-field">
                </label>

                <label class="block">
                    <span class="sf-label">{{ __('contact.form_email') }}</span>
                    <input type="email" name="email" maxlength="150" autocomplete="email" class="sf-field">
                </label>

                {{-- Ловушка для роботов: поле скрыто от человека и остаётся пустым. --}}
                <label class="hidden" aria-hidden="true">
                    <span>Company</span>
                    <input type="text" name="company" tabindex="-1" autocomplete="off">
                </label>

                <label class="block sm:col-span-2">
                    <span class="sf-label">{{ __('contact.form_message') }}<span class="text-danger-600">*</span></span>
                    <textarea name="message" rows="4" required maxlength="2000" class="sf-field"></textarea>
                </label>

                <div class="flex flex-wrap items-center gap-3 sm:col-span-2">
                    <button type="submit" class="sf-btn-primary h-11 px-5" data-sf-lead-submit>
                        {{ __('contact.form_submit') }}
                    </button>
                    <p class="text-sm" data-sf-lead-message role="status" aria-live="polite"></p>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        (function () {
            var form = document.querySelector('[data-sf-lead-form]');
            if (!form) return;

            var button = form.querySelector('[data-sf-lead-submit]');
            var note = form.querySelector('[data-sf-lead-message]');

            function say(text, ok) {
                if (!note) return;
                note.textContent = text;
                note.className = 'text-sm ' + (ok ? 'text-success-600' : 'text-danger-600');
            }

            form.addEventListener('submit', function (event) {
                event.preventDefault();

                if (!form.reportValidity()) return;

                button.disabled = true;
                say('', true);

                fetch(form.action, {
                    method: 'POST',
                    headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
                    body: new FormData(form),
                    credentials: 'same-origin'
                })
                    .then(function (response) {
                        return response.json().then(function (body) { return { ok: response.ok, body: body }; });
                    })
                    .then(function (result) {
                        if (!result.ok || !result.body || result.body.status !== true) {
                            var errors = result.body && result.body.errors ? Object.values(result.body.errors).flat() : [];
                            say(errors.length ? errors.join(' ') : (result.body && result.body.message) || @json(__('contact.form_error')), false);

                            return;
                        }

                        form.reset();
                        say(result.body.message, true);

                        var names = window.radopAnalyticsDataLayerEventNames || {};
                        if (typeof window.radopGa4EventPush === 'function' && names.contact_lead_submitted) {
                            window.radopGa4EventPush(names.contact_lead_submitted, {
                                currency: window.radopGaCurrency || 'MDL',
                                value: 0,
                                lead_source: (result.body.lead && result.body.lead.lead_source) || 'contact_form',
                                form_location: (result.body.lead && result.body.lead.form_location) || window.location.pathname
                            });
                        }
                    })
                    .catch(function () {
                        say(@json(__('contact.form_error')), false);
                    })
                    .finally(function () {
                        button.disabled = false;
                    });
            });
        })();
    </script>
@endsection
