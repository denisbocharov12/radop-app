@extends('frontend.v1.layouts.layout')

@section('sf-page', 1)

@section('content')
    @php
        $isBusiness = $user->type->key_name === 'iur';

        /* Field names, routes and validation are unchanged; only the markup is new. */
        $profileFields = array_values(array_filter([
            $isBusiness ? ['organization_name', __('theme.company-name'), 'text', $user->profile->organization_name, false, 'organization'] : null,
            $isBusiness ? ['cod_fiscal', __('theme.cod-fiscal'), 'text', $user->profile->cod_fiscal, false, 'off'] : null,
            ['first_name', __('theme.first-name'), 'text', $user->profile->first_name, true, 'given-name'],
            ['last_name', __('theme.second-name'), 'text', $user->profile->last_name, true, 'family-name'],
            $isBusiness ? ['contact_name', __('theme.contact-person'), 'text', $user->profile->contact_name, false, 'name'] : null,
            ['phone', __('theme.phone-number'), 'tel', $user->profile->phone, true, 'tel'],
            ['email', 'Email', 'email', $user->email, true, 'email'],
            ['address', __('theme.address'), 'text', $user->profile->address, true, 'street-address'],
        ]));
    @endphp

    <x-sf-account-shell :title="__('theme.account-details')" :subtitle="__('theme.personal-information-save')">
        <div class="grid gap-5 xl:grid-cols-[minmax(0,1fr)_22rem] xl:items-start">
            <form
                action="{{ route('theme.user.account.update', auth()->guard('user')->user()) }}"
                method="POST"
                class="sf-card p-5"
            >
                @csrf
                <h2 class="mb-4 text-md font-bold text-ink-900">{{ __('theme.personal-information') }}</h2>

                <div class="grid gap-4 sm:grid-cols-2">
                    @foreach($profileFields as [$name, $label, $type, $value, $required, $autocomplete])
                        <label class="block">
                            <span class="sf-label">{{ $label }}@if($required)<span class="text-danger-500">*</span>@endif</span>
                            <input
                                type="{{ $type }}"
                                name="{{ $name }}"
                                id="{{ $name }}"
                                value="{{ old($name, $value) }}"
                                autocomplete="{{ $autocomplete }}"
                                class="sf-field @error($name) sf-field-error @enderror"
                                @required($required)
                            />
                            @error($name)<span class="sf-error">{{ $message }}</span>@enderror
                        </label>
                    @endforeach

                    <label class="block">
                        <span class="sf-label">{{ __('theme.city-label') }}</span>
                        <select name="city_id" id="city_id" class="sf-field pr-8 @error('city_id') sf-field-error @enderror">
                            @foreach($cities as $city)
                                <option value="{{ $city->id }}" @selected((int) old('city_id', $user->city_id) === $city->id)>{{ $city->name }}</option>
                            @endforeach
                        </select>
                        @error('city_id')<span class="sf-error">{{ $message }}</span>@enderror
                    </label>
                </div>

                <button type="submit" class="sf-btn-primary mt-5">
                    <x-sf-icon name="check" :size="16" />{{ __('theme.save') }}
                </button>
            </form>

            <form action="{{ route('theme.user.account.password.update') }}" method="POST" class="sf-card p-5">
                @csrf
                <h2 class="mb-1 text-md font-bold text-ink-900">{{ __('theme.password') }}</h2>

                <div class="mb-4 mt-3 rounded-lg bg-ink-50 p-3 text-xs text-ink-600">
                    <p class="mb-1.5 font-semibold text-ink-800">{{ __('theme.password-recommendations') }}:</p>
                    <ul class="space-y-1">
                        @foreach(['uppercase', 'lowercase', 'numbers'] as $rule)
                            <li class="flex items-start gap-1.5">
                                <x-sf-icon name="check" :size="13" class="mt-0.5 text-brand-600" />
                                {{ __('theme.password-recommendations-' . $rule) }}
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="space-y-3">
                    @foreach([
                        ['current_password', __('theme.current-password'), 'current-password'],
                        ['password', __('theme.new-password'), 'new-password'],
                        ['confirm_password', __('theme.confirm-password'), 'new-password'],
                    ] as [$name, $label, $autocomplete])
                        <label class="block">
                            <span class="sf-label">{{ $label }}</span>
                            <span class="relative block">
                                <input
                                    type="password"
                                    name="{{ $name }}"
                                    id="{{ $name }}"
                                    autocomplete="{{ $autocomplete }}"
                                    class="sf-field pr-11 @error($name) sf-field-error @enderror"
                                    required
                                />
                                <button
                                    type="button"
                                    class="absolute right-1 top-1/2 flex h-9 w-9 -translate-y-1/2 items-center justify-center text-ink-400 hover:text-ink-700"
                                    data-sf-reveal="{{ $name }}"
                                    aria-pressed="false"
                                    aria-label="{{ $label }}"
                                >
                                    <x-sf-icon name="eye" :size="17" />
                                </button>
                            </span>
                            @error($name)<span class="sf-error">{{ $message }}</span>@enderror
                        </label>
                    @endforeach

                    <p class="flex items-center gap-2 text-xs text-ink-500" data-sf-password-rule="password">
                        <x-sf-icon name="info" :size="14" />
                        <span>{{ __('theme.password-rule-length') }}</span>
                    </p>
                </div>

                <button type="submit" class="sf-btn-secondary sf-btn-block mt-5">{{ __('theme.save') }}</button>
            </form>
        </div>
    </x-sf-account-shell>
@endsection
