@props([
    'action',
    // Attribute filter groups. Deliberately not named "attributes": that prop
    // name is reserved for Blade's own ComponentAttributeBag.
    'groups' => [],
    'brands' => null,
    /** Leaf categories with `products_count` (shop and brand listings). */
    'categories' => null,
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

    $attributeId = static fn ($attribute) => (int) (is_array($attribute) ? ($attribute['id'] ?? 0) : ($attribute->id ?? 0));

    // One query for every value in every group; the legacy lookup ran
    // AttributeValue::find() per value (27 queries on a pen category).
    $valueIds = collect($groups ?? [])->flatten(1)->map($attributeId)->filter()->unique()->values();
    $valuesById = $valueIds->isEmpty()
        ? collect()
        : \App\Models\AttributeValue::query()->whereIn('id', $valueIds)->get()->keyBy('id');

    $attributeGroups = collect($groups ?? [])
        ->map(static fn ($values) => collect($values)
            ->map(static fn ($attribute) => $valuesById->get($attributeId($attribute)))
            ->filter()
            ->sortBy('value'))
        ->filter(static fn ($values) => $values->count() > 1);

    // filter[category] arrives as "id", "id1,id2" or an array of either.
    $selectedCategories = collect((array) data_get($query, 'category', []))
        ->flatMap(static fn ($value) => explode(',', (string) $value))
        ->filter()
        ->values()
        ->all();

    $categoryItems = collect($categories ?? [])->filter(static fn ($category) => ($category->products_count ?? 0) > 0);
    $brandCount = count((array) data_get($query, 'brand', []));

    $activeCount = collect(data_get($query, 'attribute', []))->flatten()->count()
        + $brandCount
        + count($selectedCategories)
        + (($priceFrom !== null || $priceTo !== null) ? 1 : 0);

    $countBadge = 'inline-flex h-5 min-w-[1.25rem] shrink-0 items-center justify-center rounded-full bg-brand-600 px-1.5 text-2xs font-bold text-white';
    $summaryClass = 'flex cursor-pointer list-none items-center justify-between gap-2 text-sm font-semibold text-ink-900 hover:text-brand-600';
    $optionClass = 'flex cursor-pointer items-center gap-2 rounded px-1 py-1 text-sm text-ink-700 hover:bg-ink-50';
    $checkboxClass = 'h-4 w-4 shrink-0 rounded border-ink-300 text-brand-600 focus:ring-brand-500';
@endphp

<form
    action="{{ $action }}"
    method="GET"
    id="filterForm"
    class="[&>details:first-of-type]:border-t-0 lg:[&>details]:px-4"
    data-sf-filter-form
>
    <input type="hidden" name="sort" id="sortInput" value="{{ request('sort') }}">

    {{-- The phone drawer has its own title bar, so the title is desktop-only.
         On desktop the row is 4rem tall, like the catalogue toolbar, and
         stays pinned while a long filter list scrolls. --}}
    <div class="flex items-center justify-between gap-3 px-1 pb-2 lg:sticky lg:top-0 lg:z-10 lg:h-16 lg:border-b lg:border-ink-200 lg:bg-white lg:px-4 lg:pb-0">
        <h2 class="hidden items-center gap-2 text-sm font-bold uppercase tracking-wide text-ink-900 lg:flex">
            <x-sf-icon name="filter" :size="15" class="text-brand-600" />
            {{ __('theme.filters') }}
        </h2>
        @if($activeCount > 0)
            <button type="button" id="filterResetBtn" class="text-xs font-medium text-brand-600 hover:text-brand-700">
                {{ __('theme.reset-filters') }} ({{ $activeCount }})
            </button>
        @endif
    </div>

    {{-- Price: a two-handle slider for quick ranges plus exact inputs, as on
         the old site. Only the number inputs carry names; the sliders just
         drive them. --}}
    <details class="group border-t border-ink-200 py-3" open>
        <summary class="{{ $summaryClass }}">
            {{ __('theme.by-price') }}
            <x-sf-icon name="chevronDown" :size="16" class="text-ink-400 transition-transform group-open:rotate-180" />
        </summary>

        <div class="mt-4 px-1" data-sf-price-range data-max="{{ (int) $priceMax }}">
            <div class="sf-range">
                <div class="sf-range-track"><div class="sf-range-fill" data-sf-range-fill></div></div>
                <input
                    type="range"
                    min="0"
                    max="{{ (int) $priceMax }}"
                    step="1"
                    value="{{ (int) ($priceFrom ?? 0) }}"
                    aria-label="{{ __('theme.min') }}"
                    data-sf-range-min
                >
                <input
                    type="range"
                    min="0"
                    max="{{ (int) $priceMax }}"
                    step="1"
                    value="{{ (int) ($priceTo ?? $priceMax) }}"
                    aria-label="{{ __('theme.max') }}"
                    data-sf-range-max
                >
            </div>
        </div>

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
                    data-sf-price-from
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
                    data-sf-price-to
                />
            </label>
        </div>
    </details>

    @if($categoryItems->isNotEmpty())
        <details class="group border-t border-ink-200 py-3" open>
            <summary class="{{ $summaryClass }}">
                <span class="flex items-center gap-2">
                    {{ __('theme.categories') }}
                    @if(count($selectedCategories))
                        <span class="{{ $countBadge }}">{{ count($selectedCategories) }}</span>
                    @endif
                </span>
                <x-sf-icon name="chevronDown" :size="16" class="text-ink-400 transition-transform group-open:rotate-180" />
            </summary>
            <div class="mt-2 max-h-64 space-y-0.5 overflow-y-auto pr-1">
                @foreach($categoryItems as $category)
                    <label class="{{ $optionClass }}">
                        <input
                            type="checkbox"
                            class="{{ $checkboxClass }}"
                            name="filter[category][]"
                            value="{{ $category->onec_id }}"
                            @checked(in_array((string) $category->onec_id, $selectedCategories, true))
                        />
                        <span class="min-w-0 flex-1 truncate" title="{{ $category->name }}">{{ $category->name }}</span>
                        <span class="shrink-0 rounded bg-ink-100 px-1.5 text-2xs font-medium tabular-nums text-ink-500">{{ $category->products_count }}</span>
                    </label>
                @endforeach
            </div>
        </details>
    @endif

    @foreach($attributeGroups as $label => $values)
        @php
            $groupCount = collect($values)->pluck('attribute_onec_id')->unique()
                ->sum(static fn ($id) => count((array) data_get($query, "attribute.{$id}", [])));
        @endphp
        <details class="group border-t border-ink-200 py-3" @if($groupCount > 0) open @endif>
            <summary class="{{ $summaryClass }}">
                <span class="flex min-w-0 items-center gap-2">
                    <span class="truncate">{{ $label }}</span>
                    @if($groupCount > 0)
                        <span class="{{ $countBadge }}">{{ $groupCount }}</span>
                    @endif
                </span>
                <x-sf-icon name="chevronDown" :size="16" class="text-ink-400 transition-transform group-open:rotate-180" />
            </summary>
            <div class="mt-2 max-h-56 space-y-1 overflow-y-auto pr-1">
                @foreach($values as $attribute)
                    @php
                        $value = str_replace(',', '.', $attribute->value);
                        $checked = in_array($value, (array) data_get($query, "attribute.{$attribute->attribute_onec_id}", []), true);
                    @endphp
                    <label class="{{ $optionClass }}">
                        <input
                            type="checkbox"
                            class="{{ $checkboxClass }}"
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
        <details class="group border-t border-ink-200 py-3" @if($brandCount) open @endif>
            <summary class="{{ $summaryClass }}">
                <span class="flex items-center gap-2">
                    {{ __('theme.brand') }}
                    @if($brandCount)
                        <span class="{{ $countBadge }}">{{ $brandCount }}</span>
                    @endif
                </span>
                <x-sf-icon name="chevronDown" :size="16" class="text-ink-400 transition-transform group-open:rotate-180" />
            </summary>
            @php
                $brandList = collect($brands)->filter(static fn ($b) => $b && trim((string) ($b->title ?? '')) !== '')->values();
                // Отмеченные бренды всегда видны, даже если они в конце списка.
                $selectedBrands = (array) data_get($query, 'brand', []);
                $visibleLimit = 7;
            @endphp

            <div class="mt-2" data-sf-brand-filter>
                @if($brandList->count() > 10)
                    <label class="relative mb-2 block">
                        <span class="sf-sr-only">{{ __('theme.sf-brand-search') }}</span>
                        <input
                            type="search"
                            class="sf-field h-9 py-0 pl-8 text-sm"
                            placeholder="{{ __('theme.sf-brand-search') }}"
                            data-sf-brand-search
                            autocomplete="off"
                        />
                        <x-sf-icon name="search" :size="15" class="pointer-events-none absolute left-2.5 top-1/2 -translate-y-1/2 text-ink-400" />
                    </label>
                @endif

                <div class="max-h-56 space-y-1 overflow-y-auto pr-1" data-sf-brand-list>
                    @foreach($brandList as $index => $brand)
                        @php($checked = in_array($brand->onec_id, $selectedBrands))
                        <label
                            @class([
                                $optionClass,
                                'hidden' => $index >= $visibleLimit && ! $checked,
                            ])
                            data-sf-brand-option="{{ mb_strtolower($brand->title) }}"
                            @if($index >= $visibleLimit && ! $checked) data-sf-brand-extra @endif
                        >
                            <input
                                type="checkbox"
                                class="{{ $checkboxClass }}"
                                name="filter[brand][]"
                                value="{{ $brand->onec_id }}"
                                @checked($checked)
                            />
                            <span class="min-w-0 flex-1 truncate">{{ $brand->title }}</span>
                        </label>
                    @endforeach
                </div>

                @if($brandList->count() > $visibleLimit)
                    <button
                        type="button"
                        class="mt-1 px-1 text-xs font-semibold text-brand-600 hover:text-brand-700"
                        data-sf-brand-toggle
                        data-label-more="{{ __('theme.sf-brands-show-all') }} ({{ $brandList->count() }})"
                        data-label-less="{{ __('theme.sf-brands-collapse') }}"
                    >{{ __('theme.sf-brands-show-all') }} ({{ $brandList->count() }})</button>
                @endif
            </div>
        </details>
    @endif

    {{-- Desktop footer reset, like the old sidebar; the phone drawer has its
         own Reset / Apply bar. --}}
    @if($activeCount > 0)
        <div class="hidden border-t border-ink-200 p-4 lg:block">
            <button type="button" class="sf-btn-secondary sf-btn-block" data-sf-filter-reset>
                <x-sf-icon name="close" :size="14" />
                {{ __('theme.reset-filters') }}
            </button>
        </div>
    @endif

    <noscript>
        <button type="submit" class="sf-btn-primary sf-btn-block mt-3">{{ __('theme.filter') }}</button>
    </noscript>
</form>

@once
    @push('scripts')
        <script>
            /*
             * Auto-submit: checkboxes apply immediately, price inputs and the
             * slider after a pause so dragging or typing "1250" does not fire
             * a navigation per step.
             */
            document.addEventListener('DOMContentLoaded', function () {
                var form = document.querySelector('[data-sf-filter-form]');
                if (!form) return;

                /* Auto-apply only where the form is a permanent sidebar. In the
                   phone drawer each tick would reload the page and close the
                   drawer mid-selection, so there the "Apply" button submits. */
                var desktop = window.matchMedia('(min-width: 1024px)');
                var timer = null;

                function submitSoon(delay) {
                    if (!desktop.matches) return;
                    clearTimeout(timer);
                    timer = setTimeout(function () { form.requestSubmit ? form.requestSubmit() : form.submit(); }, delay);
                }

                form.querySelectorAll('input[type=checkbox]').forEach(function (box) {
                    box.addEventListener('change', function () { submitSoon(0); });
                });

                /* Two-handle price slider bound to the number inputs. */
                var range = form.querySelector('[data-sf-price-range]');
                var fromInput = form.querySelector('[data-sf-price-from]');
                var toInput = form.querySelector('[data-sf-price-to]');

                if (range && fromInput && toInput) {
                    var max = Number(range.dataset.max) || 1000;
                    var minHandle = range.querySelector('[data-sf-range-min]');
                    var maxHandle = range.querySelector('[data-sf-range-max]');
                    var fill = range.querySelector('[data-sf-range-fill]');

                    var paint = function () {
                        var lo = Math.min(Number(minHandle.value), Number(maxHandle.value));
                        var hi = Math.max(Number(minHandle.value), Number(maxHandle.value));
                        fill.style.left = (lo / max * 100) + '%';
                        fill.style.right = (100 - hi / max * 100) + '%';
                    };

                    var fromHandles = function (event) {
                        var lo = Number(minHandle.value);
                        var hi = Number(maxHandle.value);
                        if (lo > hi) {
                            if (event.target === minHandle) minHandle.value = hi; else maxHandle.value = lo;
                        }
                        fromInput.value = Number(minHandle.value) > 0 ? minHandle.value : '';
                        toInput.value = Number(maxHandle.value) < max ? maxHandle.value : '';
                        paint();
                        submitSoon(700);
                    };

                    var fromNumbers = function () {
                        minHandle.value = Math.min(Number(fromInput.value) || 0, max);
                        maxHandle.value = toInput.value === '' ? max : Math.min(Number(toInput.value), max);
                        paint();
                        submitSoon(700);
                    };

                    minHandle.addEventListener('input', fromHandles);
                    maxHandle.addEventListener('input', fromHandles);
                    fromInput.addEventListener('input', fromNumbers);
                    toInput.addEventListener('input', fromNumbers);
                    paint();
                }

                /* Empty price bounds and an unset sort would otherwise travel as
                   filter[price][from]= and sort= in the address. */
                form.addEventListener('submit', function () {
                    /* A typed "from 400 to 250" would match nothing; read it as 250–400. */
                    if (fromInput && toInput && fromInput.value !== '' && toInput.value !== ''
                        && Number(fromInput.value) > Number(toInput.value)) {
                        var swap = fromInput.value;
                        fromInput.value = toInput.value;
                        toInput.value = swap;
                    }

                    form.querySelectorAll('input[type=number], input[name=sort]').forEach(function (input) {
                        if (input.value === '') input.disabled = true;
                    });
                });

                /* ТЗ 42, 43: первые семь брендов, остальное по кнопке; поиск по списку. */
                var brandBox = form.querySelector('[data-sf-brand-filter]');
                if (brandBox) {
                    var toggle = brandBox.querySelector('[data-sf-brand-toggle]');
                    var extras = brandBox.querySelectorAll('[data-sf-brand-extra]');
                    var expanded = false;

                    if (toggle) {
                        toggle.addEventListener('click', function () {
                            expanded = !expanded;
                            extras.forEach(function (el) { el.classList.toggle('hidden', !expanded); });
                            toggle.textContent = expanded ? toggle.dataset.labelLess : toggle.dataset.labelMore;
                        });
                    }

                    var search = brandBox.querySelector('[data-sf-brand-search]');
                    if (search) {
                        search.addEventListener('input', function () {
                            var term = search.value.trim().toLowerCase();
                            if (toggle) { toggle.classList.toggle('hidden', term !== ''); }
                            brandBox.querySelectorAll('[data-sf-brand-option]').forEach(function (option) {
                                var matches = option.dataset.sfBrandOption.indexOf(term) !== -1;
                                var hiddenByCollapse = option.hasAttribute('data-sf-brand-extra') && !expanded;
                                option.classList.toggle('hidden', term === '' ? hiddenByCollapse : !matches);
                            });
                        });
                    }
                }

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
