@props([
    'action',
    // Attribute filter groups. Deliberately not named "attributes": that prop
    // name is reserved for Blade's own ComponentAttributeBag.
    'groups' => [],
    'brands' => null,
    'query' => [],
    'priceMax' => 1000,
])

@php
    use App\Repositories\Attribute\AttributeRepository;

    /*
     * One filter form for the whole catalogue (category, shop, brand, search).
     * The legacy code shipped this twice per page — a sidebar copy and a modal
     * copy — which meant two sets of inputs with the same names fighting over
     * the query string. Here it is rendered once and the drawer helper in
     * vitals.js moves it on small screens.
     */
    $priceFrom = data_get($query, 'price.from');
    $priceTo = data_get($query, 'price.to');

    $attributeGroups = collect($groups ?? [])
        ->map(static fn ($values) => collect($values)
            ->map(static function ($attribute) {
                $id = is_array($attribute) ? ($attribute['id'] ?? null) : ($attribute->id ?? null);

                return $id ? app(AttributeRepository::class)->getAttributeValueById((int) $id) : null;
            })
            ->filter()
            ->sortBy('value'))
        ->filter(static fn ($values) => $values->count() > 1);

    $activeCount = collect(data_get($query, 'attribute', []))->flatten()->count()
        + count((array) data_get($query, 'brand', []))
        + (($priceFrom !== null || $priceTo !== null) ? 1 : 0);
@endphp

<form action="{{ $action }}" method="GET" id="filterForm" class="space-y-1" data-sf-filter-form>
    <input type="hidden" name="sort" id="sortInput" value="{{ request('sort') }}">

    <div class="flex items-center justify-between px-1 pb-2">
        <h2 class="text-sm font-bold uppercase tracking-wide text-ink-900">{{ __('theme.show-all-filters') }}</h2>
        @if($activeCount > 0)
            <button type="button" id="filterResetBtn" class="text-xs font-medium text-brand-600 hover:text-brand-700">
                {{ __('theme.reset-filters') }} ({{ $activeCount }})
            </button>
        @endif
    </div>

    <details class="group border-t border-ink-200 py-3" open>
        <summary class="flex cursor-pointer list-none items-center justify-between text-sm font-semibold text-ink-900">
            {{ __('theme.by-price') }}
            <x-sf-icon name="chevronDown" :size="16" class="text-ink-400 transition-transform group-open:rotate-180" />
        </summary>
        <div class="mt-3 flex items-center gap-2">
            <label class="flex-1">
                <span class="sf-sr-only">{{ __('theme.min') }}</span>
                <input
                    type="number"
                    name="filter[price][from]"
                    class="sf-field py-2 text-sm"
                    placeholder="{{ __('theme.min') }}"
                    min="0"
                    value="{{ $priceFrom }}"
                />
            </label>
            <span class="text-ink-300">—</span>
            <label class="flex-1">
                <span class="sf-sr-only">{{ __('theme.max') }}</span>
                <input
                    type="number"
                    name="filter[price][to]"
                    class="sf-field py-2 text-sm"
                    placeholder="{{ __('theme.max') }}"
                    min="0"
                    value="{{ $priceTo }}"
                />
            </label>
        </div>
    </details>

    @foreach($attributeGroups as $label => $values)
        @php
            $groupActive = collect($values)->contains(
                static fn ($v) => isset($query['attribute'][$v->attribute_onec_id])
            );
        @endphp
        <details class="group border-t border-ink-200 py-3" @if($groupActive) open @endif>
            <summary class="flex cursor-pointer list-none items-center justify-between text-sm font-semibold text-ink-900">
                {{ $label }}
                <x-sf-icon name="chevronDown" :size="16" class="text-ink-400 transition-transform group-open:rotate-180" />
            </summary>
            <div class="mt-2 max-h-56 space-y-1 overflow-y-auto pr-1">
                @foreach($values as $attribute)
                    @php
                        $value = str_replace(',', '.', $attribute->value);
                        $checked = in_array($value, (array) data_get($query, "attribute.{$attribute->attribute_onec_id}", []), true);
                    @endphp
                    <label class="flex cursor-pointer items-center gap-2 rounded px-1 py-1 text-sm text-ink-700 hover:bg-ink-50">
                        <input
                            type="checkbox"
                            class="h-4 w-4 shrink-0 rounded border-ink-300 text-brand-600 focus:ring-brand-500"
                            name="filter[attribute][{{ $attribute->attribute_onec_id }}][]"
                            value="{{ $value }}"
                            @checked($checked)
                        />
                        <span class="min-w-0 flex-1 truncate">{{ $attribute->value }}</span>
                    </label>
                @endforeach
            </div>
        </details>
    @endforeach

    @if($brands && count($brands))
        <details class="group border-t border-ink-200 py-3" @if(data_get($query, 'brand')) open @endif>
            <summary class="flex cursor-pointer list-none items-center justify-between text-sm font-semibold text-ink-900">
                {{ __('theme.brand') }}
                <x-sf-icon name="chevronDown" :size="16" class="text-ink-400 transition-transform group-open:rotate-180" />
            </summary>
            <div class="mt-2 max-h-56 space-y-1 overflow-y-auto pr-1">
                @foreach($brands as $brand)
                    @continue(! $brand || trim((string) ($brand->title ?? '')) === '')
                    <label class="flex cursor-pointer items-center gap-2 rounded px-1 py-1 text-sm text-ink-700 hover:bg-ink-50">
                        <input
                            type="checkbox"
                            class="h-4 w-4 shrink-0 rounded border-ink-300 text-brand-600 focus:ring-brand-500"
                            name="filter[brand][]"
                            value="{{ $brand->onec_id }}"
                            @checked(in_array($brand->onec_id, (array) data_get($query, 'brand', [])))
                        />
                        <span class="min-w-0 flex-1 truncate">{{ $brand->title }}</span>
                    </label>
                @endforeach
            </div>
        </details>
    @endif

    <noscript>
        <button type="submit" class="sf-btn-primary sf-btn-block mt-3">{{ __('theme.show-all-filters') }}</button>
    </noscript>
</form>

@once
    @push('scripts')
        <script>
            /*
             * Auto-submit: checkboxes apply immediately, price inputs after a
             * pause so typing "1250" does not fire four navigations.
             */
            document.addEventListener('DOMContentLoaded', function () {
                var form = document.querySelector('[data-sf-filter-form]');
                if (!form) return;

                form.querySelectorAll('input[type=checkbox]').forEach(function (box) {
                    box.addEventListener('change', function () { form.submit(); });
                });

                var timer = null;
                form.querySelectorAll('input[type=number]').forEach(function (input) {
                    input.addEventListener('input', function () {
                        clearTimeout(timer);
                        timer = setTimeout(function () { form.submit(); }, 700);
                    });
                });

                var reset = document.getElementById('filterResetBtn');
                if (reset) {
                    reset.addEventListener('click', function () {
                        var url = new URL(form.action || window.location.href);
                        url.searchParams.delete('filter');
                        url.searchParams.delete('page');
                        url.searchParams.delete('sort');
                        window.location.href = url.toString();
                    });
                }
            });
        </script>
    @endpush
@endonce
