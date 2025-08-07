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
<div class="page-sort-block">
    <span class="sort-label d-none d-md-block">{{__('theme.sort-label')}}</span>
    <div class="sort-dropdown d-none d-md-block">
        <button type="button" class="sort-dropdown-toggle">
            <span class="sort-option active">{{$activeLabel}}</span>
        </button>
        <div class="sort-dropdown-menu">
            @foreach($sortOptions as $key => $label)
                @if($key !== $activeKey)
                    <a href="#" class="sort-option" data-sort="{{$key}}">{{$label}}</a>
                @endif
            @endforeach
        </div>
    </div>
</div>
