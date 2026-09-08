@props([
    'products',
    'action',
    'defaultSort' => 'price',
])

@php
    $current = request()->query('sort') ?? $defaultSort;

    $sortOptions = [
        'price' => __('theme.sort-price-asc'),
        '-price' => __('theme.sort-price-desc'),
        'title' => __('theme.sort-title'),
        'popular_order' => __('theme.sort-popular'),
        'condition' => __('theme.sort-new'),
    ];

    $perPageOptions = [24, 48, 72, 96];
    $perPage = (int) (request()->query('perPage') ?? $products->perPage());
@endphp

{{--
    Sort, page size and the mobile filter trigger. Submits as a plain GET form
    so the state stays in the URL and remains shareable and cacheable; the
    inline script only removes the need to press a button.
--}}
<form
    action="{{ $action }}"
    method="GET"
    class="flex flex-wrap items-center gap-3 border-b border-ink-200 py-3"
    data-sf-toolbar
>
    @foreach(request()->except(['sort', 'perPage', 'page']) as $key => $value)
        @if(is_array($value))
            @foreach(Arr::dot([$key => $value]) as $flatKey => $flatValue)
                <input type="hidden" name="{{ $flatKey }}" value="{{ $flatValue }}">
            @endforeach
        @else
            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
        @endif
    @endforeach

    <button
        type="button"
        class="sf-btn-secondary sf-btn-sm lg:hidden"
        data-sf-drawer-open="catalog-filters"
    >
        <x-sf-icon name="filter" :size="15" />
        {{ __('theme.filters') }}
    </button>

    <p class="hidden text-sm text-ink-500 sm:block">
        {{ $products->total() }} {{ __('theme.sort-products') }}
    </p>

    <div class="ml-auto flex items-center gap-3">
        <label class="flex items-center gap-2">
            <span class="hidden text-xs text-ink-500 sm:inline">{{ __('theme.sort-label') }}</span>
            <select name="sort" class="sf-field w-auto py-2 pr-8 text-sm">
                @foreach($sortOptions as $key => $label)
                    <option value="{{ $key }}" @selected($current === $key)>{{ $label }}</option>
                @endforeach
            </select>
        </label>

        <label class="hidden items-center gap-2 sm:flex">
            <span class="sf-sr-only">{{ __('theme.sort-products') }}</span>
            <select name="perPage" class="sf-field w-auto py-2 pr-8 text-sm">
                @foreach($perPageOptions as $option)
                    <option value="{{ $option }}" @selected($perPage === $option)>{{ $option }}</option>
                @endforeach
            </select>
        </label>

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
