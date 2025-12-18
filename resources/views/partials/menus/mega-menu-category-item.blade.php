@php
    $locale = app()->getLocale();
    $hasChildren = $item->children && $item->children->isNotEmpty();
    $itemTitle = $item->getTranslation('title', $locale);
    $itemLink = $item->getTranslation('link', $locale);
    $itemImage = $item->getFirstMedia('menu_item_image');
    
    $productsCount = 0;
    if ($item->category_id) {
        $category = \App\Models\Category::where('onec_id', $item->category_id)->first();
        if ($category) {
            $productsCount = $category->products()
                ->where('status', true)
                ->where('site_status', true)
                ->where('stock', '!=', 0)
                ->count();
        }
    }
@endphp

<div class="mega-menu__category-item">
    @if($itemLink)
        <a href="{{ $itemLink }}" class="mega-menu__category-link" target="{{ $item->target ?? '_self' }}">
            @if($itemImage)
                <img src="{{ $itemImage->getUrl() }}" alt="{{ $itemTitle }}" class="mega-menu__category-icon">
            @endif
            <span class="mega-menu__category-title">{{ $itemTitle }}</span>
            @if($productsCount > 0)
                <span class="mega-menu__category-count">({{ $productsCount }})</span>
            @elseif($hasChildren)
                <span class="mega-menu__category-count">({{ $item->children->count() }})</span>
            @endif
        </a>
    @else
        <div class="mega-menu__category-link">
            @if($itemImage)
                <img src="{{ $itemImage->getUrl() }}" alt="{{ $itemTitle }}" class="mega-menu__category-icon">
            @endif
            <span class="mega-menu__category-title">{{ $itemTitle }}</span>
            @if($productsCount > 0)
                <span class="mega-menu__category-count">({{ $productsCount }})</span>
            @elseif($hasChildren)
                <span class="mega-menu__category-count">({{ $item->children->count() }})</span>
            @endif
        </div>
    @endif
    
    @if($hasChildren)
        <ul class="mega-menu__category-sublist">
            @foreach($item->children->sortBy(function($child) use ($locale) {
                $titleRaw = $child->getRawOriginal('title');
                $title = is_array(json_decode($titleRaw, true))
                    ? $child->getTranslation('title', $locale)
                    : ($titleRaw ?? '');
                return mb_strtolower($title);
            }) as $child)
                @php
                    $childTitle = $child->getTranslation('title', $locale);
                    $childLink = $child->getTranslation('link', $locale);
                    
                    $childProductsCount = 0;
                    if ($child->category_id) {
                        $childCategory = \App\Models\Category::where('onec_id', $child->category_id)->first();
                        if ($childCategory) {
                            $childProductsCount = $childCategory->products()
                                ->where('status', true)
                                ->where('site_status', true)
                                ->where('stock', '!=', 0)
                                ->count();
                        }
                    }
                @endphp
                <li class="mega-menu__category-subitem">
                    <a href="{{ $childLink ?? '#' }}" class="mega-menu__category-sublink" target="{{ $child->target ?? '_self' }}">
                        {{ $childTitle }}
                        @if($childProductsCount > 0)
                            <span class="mega-menu__category-count">({{ $childProductsCount }})</span>
                        @endif
                    </a>
                </li>
            @endforeach
        </ul>
    @endif
</div>

