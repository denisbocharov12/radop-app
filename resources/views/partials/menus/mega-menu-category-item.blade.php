@php
    $locale = app()->getLocale();
    $hasChildren = $item->children && $item->children->isNotEmpty();
    $itemTitle = $item->getTranslation('title', $locale);
    $itemLink = $item->getTranslation('link', $locale);
    $itemImage = $item->getFirstMedia('menu_item_image');
    $labelNameRaw = $item->getRawOriginal('label_name');
    $labelName = is_array(json_decode($labelNameRaw, true))
        ? $item->getTranslation('label_name', $locale)
        : ($labelNameRaw ?? null);
    $labelColor = $item->label_color;
    
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

<div class="mega-menu__category-item @if($item->type === 'row') mega-menu__category-item--row @endif">
    @if($item->type === 'row' && $item->display_title)
        <h3 class="mega-menu__category-title mega-menu__category-title--row">{{ $itemTitle }}</h3>
    @endif
    @if($item->type === 'row')
        @php
            $displayAsLink = $item->display_as_link ?? true;
        @endphp
        @if($displayAsLink)
            @if($itemLink)
                <a href="{{ $itemLink }}" class="mega-menu__category-link" target="{{ $item->target ?? '_self' }}">
                    @if($itemImage)
                        <img src="{{ $itemImage->getUrl() }}" alt="{{ $itemTitle }}" class="mega-menu__category-icon">
                    @endif
                    @if(!$item->display_title)
                        <span class="mega-menu__category-title mega-menu__category-title--row-item">{{ $itemTitle }}</span>
                    @endif
                    @if($labelName && $labelColor)
                        <span class="mega-menu__label-badge" style="color: {{ $labelColor }};">
                            {{ $labelName }}
                        </span>
                    @endif
                </a>
            @else
                <div class="mega-menu__category-link">
                    @if($itemImage)
                        <img src="{{ $itemImage->getUrl() }}" alt="{{ $itemTitle }}" class="mega-menu__category-icon">
                    @endif
                    @if(!$item->display_title)
                        <span class="mega-menu__category-title mega-menu__category-title--row-item">{{ $itemTitle }}</span>
                    @endif
                    @if($labelName && $labelColor)
                        <span class="mega-menu__label-badge" style="color: {{ $labelColor }};">
                            {{ $labelName }}
                        </span>
                    @endif
                </div>
            @endif
        @else
            <h4 class="mega-menu__category-subtitle">
                {{ $itemTitle }}
                @if($labelName && $labelColor)
                    <span class="mega-menu__label-badge" style="color: {{ $labelColor }};">
                        {{ $labelName }}
                    </span>
                @endif
            </h4>
        @endif
    @else
        @if($itemLink)
            <a href="{{ $itemLink }}" class="mega-menu__category-link" target="{{ $item->target ?? '_self' }}">
                @if($itemImage)
                    <img src="{{ $itemImage->getUrl() }}" alt="{{ $itemTitle }}" class="mega-menu__category-icon">
                @endif
                <span class="mega-menu__category-title">{{ $itemTitle }}</span>
                @if($labelName && $labelColor)
                    <span class="mega-menu__label-badge" style="color: {{ $labelColor }};">
                        {{ $labelName }}
                    </span>
                @endif
            </a>
        @else
            <div class="mega-menu__category-link">
                @if($itemImage)
                    <img src="{{ $itemImage->getUrl() }}" alt="{{ $itemTitle }}" class="mega-menu__category-icon">
                @endif
                <span class="mega-menu__category-title">{{ $itemTitle }}</span>
                @if($labelName && $labelColor)
                    <span class="mega-menu__label-badge" style="color: {{ $labelColor }};">
                        {{ $labelName }}
                    </span>
                @endif
            </div>
        @endif
    @endif

    @if($hasChildren)
        <ul class="mega-menu__category-sublist">
            @foreach($item->children->values() as $child)
                @php
                    $childTitle = $child->getTranslation('title', $locale);
                    $childLink = $child->getTranslation('link', $locale);
                    $childLabelNameRaw = $child->getRawOriginal('label_name');
                    $childLabelName = is_array(json_decode($childLabelNameRaw, true))
                        ? $child->getTranslation('label_name', $locale)
                        : ($childLabelNameRaw ?? null);
                    $childLabelColor = $child->label_color;

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
                        @if($childLabelName && $childLabelColor)
                            <span class="mega-menu__label-badge" style="color: {{ $childLabelColor }};">
                                {{ $childLabelName }}
                            </span>
                        @endif
                        @if($childProductsCount > 0)
                            <span class="mega-menu__category-count">{{ $childProductsCount }}</span>
                        @endif
                    </a>
                </li>
            @endforeach
        </ul>
    @endif
</div>

