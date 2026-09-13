{{--
    Branch (filial) form shared by create and edit. Field names, the phone
    mask and the routes are the legacy ones; the two old templates differed
    only in the action, the heading and the pre-filled values.

    @param string          $action
    @param string          $heading
    @param string          $submit
    @param \App\Models\Filial|null $filial
--}}
<x-sf-account-shell :title="$heading">
    <form action="{{ $action }}" method="POST" class="sf-card max-w-2xl p-5">
        @csrf

        <div class="grid gap-4 sm:grid-cols-2">
            <label class="block sm:col-span-2">
                <span class="sf-label">{{ __('theme.filial_input_address') }}<span class="text-danger-500">*</span></span>
                <input
                    type="text"
                    name="address"
                    id="address"
                    value="{{ old('address', $filial?->address) }}"
                    autocomplete="street-address"
                    class="sf-field @error('address') sf-field-error @enderror"
                    required
                />
                @error('address')<span class="sf-error">{{ $message }}</span>@enderror
            </label>

            <label class="block">
                <span class="sf-label">{{ __('theme.filial_input_city') }}</span>
                <select name="city_id" id="city_id" class="sf-field pr-8 @error('city_id') sf-field-error @enderror">
                    @foreach($cities as $city)
                        <option value="{{ $city->id }}" @selected((int) old('city_id', $filial?->city_id) === $city->id)>{{ $city->name }}</option>
                    @endforeach
                </select>
                @error('city_id')<span class="sf-error">{{ $message }}</span>@enderror
            </label>

            <label class="block">
                <span class="sf-label">{{ __('theme.filial_input_phone') }}</span>
                <input
                    type="tel"
                    name="phone"
                    id="phone"
                    value="{{ old('phone', $filial?->phone) }}"
                    autocomplete="tel"
                    class="sf-field @error('phone') sf-field-error @enderror"
                />
                @error('phone')<span class="sf-error">{{ $message }}</span>@enderror
            </label>
        </div>

        <div class="mt-5 flex flex-wrap gap-2">
            <button type="submit" class="sf-btn-primary">
                <x-sf-icon name="check" :size="16" />{{ $submit }}
            </button>
            <a href="{{ route('theme.user.filial.index') }}" class="sf-btn-ghost">{{ __('theme.sf-error-back') }}</a>
        </div>
    </form>
</x-sf-account-shell>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/imask@7/dist/imask.min.js" defer></script>
    <script>
        window.addEventListener('load', function () {
            var phone = document.getElementById('phone');
            if (phone && window.IMask) {
                IMask(phone, { mask: '{\\0} 000 00 000', lazy: false, overwrite: 'shift' });
            }
        });
    </script>
@endpush
