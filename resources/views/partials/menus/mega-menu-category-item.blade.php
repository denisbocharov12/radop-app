@php
    $locale = app()->getLocale();
    $hasChildren = $item->children && $item->children->where('type', '!=', 'widget_link')->where('type', '!=', 'row')->isNotEmpty();
    $itemTitle = $item->getTranslation('title', $locale);
    $itemLink = $item->getTranslation('link', $locale);
    $itemImage = $item->getFirstMedia('menu_item_image');
    $productsCount = $item->products_count ?? 0;
@endphp

<div class="mega-menu__category-item">
    @if($itemLink)
        <a href="{{ $itemLink }}" class="mega-menu__category-link" target="{{ $item->target ?? '_self' }}">
            @if($itemImage)
                <img src="{{ $itemImage->getUrl() }}" alt="{{ $itemTitle }}" class="mega-menu__category-icon">
            @endif
            <span class="mega-menu__category-title">{{ $itemTitle }}</span>
        </a>
    @else
        <div class="mega-menu__category-link">
            @if($itemImage)
                <img src="{{ $itemImage->getUrl() }}" alt="{{ $itemTitle }}" class="mega-menu__category-icon">
            @endif
            <span class="mega-menu__category-title">{{ $itemTitle }}</span>
        </div>
    @endif

    @if($hasChildren)
        <ul class="mega-menu__category-sublist">
            @foreach($item->children->where('type', '!=', 'widget_link')->where('type', '!=', 'row')->values() as $child)
                @php
                    $childTitle = $child->getTranslation('title', $locale);
                    $childLink = $child->getTranslation('link', $locale);
                    $childProductsCount = $child->products_count ?? 0;
                @endphp
                <li class="mega-menu__category-subitem">
                    <a href="{{ $childLink ?? '#' }}" class="mega-menu__category-sublink" target="{{ $child->target ?? '_self' }}">
                        {{ $childTitle }}
                        @if($childProductsCount > 0)
                            <span class="mega-menu__category-count">{{ $childProductsCount }}</span>
                        @endif
                    </a>
                </li>
            @endforeach
        </ul>
    @endif
</div>

