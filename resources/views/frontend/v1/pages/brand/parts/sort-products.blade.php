@php
    $currentSort = request()->query('sort');
    $sortOptions = [
        ['key' => 'price', 'label' => __('theme.sort-price-asc')],
        ['key' => 'price_desc', 'label' => __('theme.sort-price-desc')],
        ['key' => 'title', 'label' => __('theme.sort-title')],
        ['key' => 'popular_order', 'label' => __('theme.sort-popular')],
        ['key' => 'condition', 'label' => __('theme.sort-new')],
        //['key' => 'stock', 'label' => __('theme.sort-stock')],
    ];
    $activeOption = $sortOptions[0];
    foreach ($sortOptions as $option) {
        if ($currentSort === $option['key'] || ($currentSort === '-price' && $option['key'] === 'price_desc')) {
            $activeOption = $option;
            break;
        }
    }
@endphp
<div class="page-sort-block">
    <span class="sort-label d-none d-md-block">{{__('theme.sort-label')}}</span>
    <div class="sort-dropdown d-none d-md-block">
        <button type="button" class="sort-dropdown-toggle">
            <span class="sort-option active">{{$activeOption['label']}}</span>
        </button>
        <div class="sort-dropdown-menu">
            @foreach($sortOptions as $option)
                @if($option['key'] !== $activeOption['key'])
                    <a href="#" class="sort-option" data-sort="{{$option['key']}}">{{$option['label']}}</a>
                @endif
            @endforeach
        </div>
    </div>
</div>
