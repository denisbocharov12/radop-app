@php
    /*
     * One registration form for both customer types.
     *
     * `fiz.blade.php` and `iur.blade.php` were 246 and 249 near-identical lines
     * — same wrappers, same error markup, same password-reveal handler, each
     * with its own copy of an inline SVG per field. The fields differ, so they
     * are declared as data and the markup is written once.
     */
    $suffix = $variant === 'fiz' ? '_fiz' : '_iur';
    $userType = \App\Models\UserType::where('key_name', $variant)->first();

    $fields = $variant === 'fiz'
        ? [
            ['name' => 'first_name', 'label' => __('theme.first-name'), 'icon' => 'user', 'required' => true],
            ['name' => 'last_name', 'label' => __('theme.second-name'), 'icon' => 'user'],
            ['name' => 'email_fiz', 'label' => 'Email', 'type' => 'email', 'icon' => 'mail', 'required' => true, 'autocomplete' => 'email'],
            ['name' => 'phone_fiz', 'label' => __('theme.phone-number'), 'icon' => 'phone', 'required' => true, 'mask' => 'phone', 'autocomplete' => 'tel'],
            ['name' => 'city_id_fiz', 'label' => __('theme.select-city'), 'type' => 'city', 'icon' => 'building', 'required' => true],
            ['name' => 'address_fiz', 'label' => __('theme.address'), 'icon' => 'building'],
        ]
        : [
            ['name' => 'organization_name', 'label' => __('theme.company-name'), 'icon' => 'building', 'required' => true],
            ['name' => 'email_iur', 'label' => 'Email', 'type' => 'email', 'icon' => 'mail', 'required' => true, 'autocomplete' => 'email'],
            ['name' => 'phone_iur', 'label' => __('theme.phone-number'), 'icon' => 'phone', 'required' => true, 'mask' => 'phone', 'autocomplete' => 'tel'],
            ['name' => 'cod_fiscal', 'label' => __('theme.fiscal-code'), 'icon' => 'receipt', 'required' => true, 'mask' => 'digits'],
            ['name' => 'city_id_iur', 'label' => __('theme.select-city'), 'type' => 'city', 'icon' => 'building'],
            ['name' => 'address_iur', 'label' => __('theme.address'), 'icon' => 'building', 'required' => true],
        ];
@endphp

<form action="{{ route('user.registration.store') }}" method="POST" class="space-y-4" data-sf-register>
    @csrf
    <input type="hidden" name="type_id" value="{{ $userType?->id }}">

    <div class="grid gap-4 sm:grid-cols-2">
        @foreach($fields as $field)
            @php($name = $field['name'])
            <label class="block">
                <span class="sf-label">
                    {{ $field['label'] }}
                    @if($field['required'] ?? false)<span class="text-danger-500">*</span>@endif
                </span>

                <span class="relative block">
                    <x-sf-icon
                        :name="$field['icon']"
                        :size="16"
                        class="pointer-events-none absolute left-3 top-1/2 z-10 -translate-y-1/2 text-ink-400"
                    />

                    @if(($field['type'] ?? 'text') === 'city')
                        <select
                            name="{{ $name }}"
                            id="{{ $name }}"
                            class="sf-field pl-9 pr-8 @error($name) sf-field-error @enderror"
                            @required($field['required'] ?? false)
                        >
                            <option value="">{{ $field['label'] }}</option>
                            @foreach($cities as $city)
                                <option value="{{ $city->id }}" @selected(old($name) == $city->id)>{{ $city->name }}</option>
                            @endforeach
                        </select>
                    @else
                        <input
                            type="{{ $field['type'] ?? 'text' }}"
                            name="{{ $name }}"
                            id="{{ $name }}"
                            value="{{ old($name) }}"
                            placeholder="{{ $field['label'] }}"
                            class="sf-field pl-9 @error($name) sf-field-error @enderror"
                            @if(isset($field['autocomplete'])) autocomplete="{{ $field['autocomplete'] }}" @endif
                            @if(isset($field['mask'])) data-sf-mask="{{ $field['mask'] }}" @endif
                            @required($field['required'] ?? false)
                        />
                    @endif
                </span>

                @error($name)<span class="sf-error">{{ $message }}</span>@enderror
            </label>
        @endforeach

        @foreach([
            ['password' . $suffix, __('theme.password'), 'new-password'],
            ['password_confirmation' . $suffix, __('theme.password_confirmation'), 'new-password'],
        ] as [$name, $label, $autocomplete])
            <label class="block">
                <span class="sf-label">{{ $label }}<span class="text-danger-500">*</span></span>
                <span class="relative block">
                    <input
                        type="password"
                        name="{{ $name }}"
                        id="{{ $name }}"
                        placeholder="{{ $label }}"
                        autocomplete="{{ $autocomplete }}"
                        class="sf-field pr-10 @error($name) sf-field-error @enderror"
                        required
                    />
                    <button
                        type="button"
                        class="absolute right-2 top-1/2 -translate-y-1/2 p-1 text-ink-400 hover:text-ink-700"
                        data-sf-reveal="{{ $name }}"
                        aria-label="{{ $label }}"
                    >
                        <x-sf-icon name="eye" :size="16" />
                    </button>
                </span>
                @error($name)<span class="sf-error">{{ $message }}</span>@enderror
            </label>
        @endforeach
    </div>

    <p
        class="flex items-center gap-2 text-xs text-ink-500"
        data-sf-password-rule="password{{ $suffix }}"
    >
        <x-sf-icon name="info" :size="14" />
        <span>{{ __('theme.password-rule-length') }}</span>
    </p>

    <label class="flex cursor-pointer items-start gap-2.5 text-sm text-ink-600">
        <input
            type="checkbox"
            name="terms{{ $suffix }}"
            value="1"
            class="mt-0.5 h-4 w-4 shrink-0 rounded border-ink-300 text-brand-600 focus:ring-brand-500"
            required
        />
        <span>
            {{ __('theme.agree-with') }}
            <a href="{{ route('theme.terms-and-conditions.index') }}" target="_blank" class="font-medium text-brand-600 hover:text-brand-700">
                {{ __('theme.terms-of-use') }}
            </a>
            {{ __('theme.and') }}
            <a href="{{ route('theme.return-rules.index') }}" target="_blank" class="font-medium text-brand-600 hover:text-brand-700">
                {{ __('theme.refund-policy') }}
            </a>
        </span>
    </label>

    <p class="text-xs leading-relaxed text-ink-500">
        {!! __('theme.registration-privacy-notice', ['url' => route('theme.privacy-policy.index')]) !!}
    </p>

    <button type="submit" class="sf-btn-primary sf-btn-lg sm:w-auto">{{ __('theme.sign-up') }}</button>
</form>
