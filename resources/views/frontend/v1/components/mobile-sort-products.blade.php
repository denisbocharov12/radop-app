@php
    $currentSort = $currentSort ?? request()->query('sort') ?? ($defaultSort ?? 'price');
    $sortOptions = [
        'price' => __('theme.sort-price-asc'),
        '-price' => __('theme.sort-price-desc'),
        'title' => __('theme.sort-title'),
        'popular_order' => __('theme.sort-popular'),
        'condition' => __('theme.sort-new'),
        'stock' => __('theme.sort-stock'),
    ];
    $activeKey = $currentSort;
    $activeLabel = $sortOptions[$activeKey] ?? reset($sortOptions);
@endphp
<div id="mobile-sort-block" class="mobile-sort-block d-md-none" data-default-sort="{{ $activeKey }}">
    <span class="mobile-sort-label">{{ __('theme.sort-label') }}</span>
    <span class="mobile-sort-selected" id="mobileSortSelected">{{ $activeLabel }}</span>
</div>

<div id="mobileSortModal" class="mobile-sort-modal d-md-none">
    <div class="mobile-sort-modal-content">
        @foreach($sortOptions as $key => $label)

            <div class="mobile-sort-option {{ $key === $activeKey ? 'active' : '' }}" data-sort="{{ $key }}">
                {{ $label }}
            </div>
        @endforeach
    </div>
</div>
