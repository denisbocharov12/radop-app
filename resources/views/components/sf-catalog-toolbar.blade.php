@props([
    'products',
    'action',
    'defaultSort' => 'price',
    /** На странице поиска слева нет колонки фильтров — кнопка не нужна. */
    'withFilters' => true,
])

@php
    $current = request()->query('sort') ?? $defaultSort;

    // Порядок по ТЗ 50: популярность, новинки, цена вверх/вниз, название.
    $sortOptions = [
        'popular_order' => __('theme.sort-popular'),
        'condition' => __('theme.sort-new'),
        'price' => __('theme.sort-price-asc'),
        '-price' => __('theme.sort-price-desc'),
        'title' => __('theme.sort-title'),
    ];

    $perPageOptions = [24, 48, 72, 96];
    $perPage = (int) (request()->query('perPage') ?? $products->perPage());

    $activeFilters = collect(request('filter', []))->except('search')->flatten()->filter(fn ($v) => $v !== null && $v !== '')->count();
@endphp

{{--
    Sort, page size, grid/list switch and the mobile filter trigger. Sort and
    page size submit as a plain GET form so the state stays in the URL; the
    layout choice is a per-visitor preference kept in localStorage.
--}}
<form
    action="{{ $action }}"
    method="GET"
    class="flex flex-wrap items-center gap-2 border-b border-ink-200 py-3 sm:gap-3"
    data-sf-toolbar
>
    @foreach(request()->except(['sort', 'perPage', 'page']) as $key => $value)
        @if(is_array($value))
            @foreach(Arr::dot([$key => $value]) as $flatKey => $flatValue)
                @php
                    // Arr::dot gives "filter.brand.0"; the query string wants "filter[brand][0]".
                    $segments = explode('.', $flatKey);
                    $fieldName = array_shift($segments) . collect($segments)->map(fn ($s) => "[{$s}]")->implode('');
                @endphp
                <input type="hidden" name="{{ $fieldName }}" value="{{ $flatValue }}">
            @endforeach
        @else
            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
        @endif
    @endforeach

    @if($withFilters)
    <button
        type="button"
        class="sf-btn-secondary h-10 px-3 text-sm lg:hidden"
        data-sf-drawer-open="catalog-filters"
    >
        <x-sf-icon name="filter" :size="15" />
        {{ __('theme.filters') }}
        @if($activeFilters > 0)
            <span class="flex h-5 min-w-[1.25rem] items-center justify-center rounded-full bg-brand-600 px-1 text-2xs font-bold text-white">{{ $activeFilters }}</span>
        @endif
    </button>
    @endif

    <p class="hidden text-sm text-ink-500 sm:block">
        <b class="font-semibold text-ink-800">{{ $products->total() }}</b> {{ __('theme.sort-products') }}
    </p>

    <div class="ml-auto flex min-w-0 items-center gap-2 sm:gap-3">
        <label class="flex min-w-0 items-center gap-2">
            <span class="hidden text-xs text-ink-500 md:inline">{{ __('theme.sort-label') }}</span>
            <select name="sort" class="sf-field h-10 w-auto min-w-0 max-w-[11rem] py-0 pr-8 text-sm sm:max-w-none">
                @if($defaultSort === '')
                    <option value="" @selected($current === '')>{{ __('theme.sf-sort-relevance') }}</option>
                @endif
                @foreach($sortOptions as $key => $label)
                    <option value="{{ $key }}" @selected($current === $key)>{{ $label }}</option>
                @endforeach
            </select>
        </label>

        <label class="hidden items-center gap-2 md:flex">
            <span class="sf-sr-only">{{ __('theme.sort-products') }}</span>
            <select name="perPage" class="sf-field h-10 w-auto py-0 pr-8 text-sm">
                @foreach($perPageOptions as $option)
                    <option value="{{ $option }}" @selected($perPage === $option)>{{ $option }}</option>
                @endforeach
            </select>
        </label>

        <div class="hidden h-10 items-stretch overflow-hidden rounded-md border border-ink-200 sm:flex" role="group" aria-label="{{ __('theme.view') }}">
            <button
                type="button"
                class="sf-view-toggle"
                data-sf-view-set="grid"
                aria-pressed="true"
                title="{{ __('theme.sf-view-grid') }}"
            >
                <x-sf-icon name="grid" :size="16" />
                <span class="sf-sr-only">{{ __('theme.sf-view-grid') }}</span>
            </button>
            <button
                type="button"
                class="sf-view-toggle border-l border-ink-200"
                data-sf-view-set="list"
                aria-pressed="false"
                title="{{ __('theme.sf-view-list') }}"
            >
                <x-sf-icon name="list" :size="16" />
                <span class="sf-sr-only">{{ __('theme.sf-view-list') }}</span>
            </button>
        </div>

        <noscript>
            <button type="submit" class="sf-btn-secondary sf-btn-sm">OK</button>
        </noscript>
    </div>
</form>

@once
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var toolbar = document.querySelector('[data-sf-toolbar]');
                if (!toolbar) return;
                toolbar.querySelectorAll('select').forEach(function (select) {
                    select.addEventListener('change', function () { toolbar.submit(); });
                });
            });
        </script>
    @endpush
@endonce
