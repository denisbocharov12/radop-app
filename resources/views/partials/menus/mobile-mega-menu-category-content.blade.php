@php
    $locale = app()->getLocale();
    $itemTitle = $item->getTranslation('title', $locale);
    $itemLink = $item->getTranslation('link', $locale);
    $regularChildren = $item->children 
        ? $item->children
            ->where('type', '!=', 'widget_link')
            ->where('type', '!=', 'row')
            ->sortBy(function($child) {
                return ($child->column ?? 1) * 1000 + ($child->column_order ?? $child->order ?? 0);
            })
            ->values() 
        : collect();
    $rowChildren = $item->children ? $item->children->where('type', 'row')->values() : collect();
@endphp
<div class="column-catalog__item column-style" data-category-id="{{ $item->id }}">
    <h3 class="column-catalog__title">
        <span class="column-catalog__back catalog-back-arrow" title="Назад"></span>
        <span class="catalog-category-title">{{ $itemTitle }}</span>
        <button class="column-catalog__close catalog-close-icon" style="display: none" type="button" title="Закрыть">
            <i class="_icon-close"></i>
        </button>
    </h3>
    <ul class="column-catalog__list drop-menu-list">
        <li>
            <a href="{{ $itemLink ?? route('theme.shop.catalog') }}" class="catalog-all-link">{{ __('theme.all-mobile-catalog') }}</a>
        </li>
        @foreach($regularChildren as $child)
            @php
                $childTitle = $child->getTranslation('title', $locale);
                $childLink = $child->getTranslation('link', $locale);
                $childHasChildren = $child->children && $child->children->where('type', '!=', 'widget_link')->where('type', '!=', 'row')->isNotEmpty();
                $childProductsCount = $child->products_count ?? 0;
                $childLabelNameRaw = $child->getRawOriginal('label_name');
                $childLabelName = is_array(json_decode($childLabelNameRaw, true))
                    ? $child->getTranslation('label_name', $locale)
                    : ($childLabelNameRaw ?? null);
                $childLabelColor = $child->label_color;
            @endphp
            <li class="drop-menu-list__item">
                <a href="{{ $childLink ?? '#' }}" class="drop-menu-list__link">
                    {{ $childTitle }}
                    @if($childLabelName && $childLabelColor)
                        <span class="mega-menu__label-badge" style="color: {{ $childLabelColor }};">
                            {{ $childLabelName }}
                        </span>
                    @endif
                </a>
                @if($childHasChildren)
                    <ul class="column-catalog__list drop-menu-list">
                        @foreach($child->children->where('type', '!=', 'widget_link')->where('type', '!=', 'row')->values() as $grandChild)
                            @php
                                $grandChildTitle = $grandChild->getTranslation('title', $locale);
                                $grandChildLink = $grandChild->getTranslation('link', $locale);
                                $grandChildProductsCount = $grandChild->products_count ?? 0;
                                $grandChildLabelNameRaw = $grandChild->getRawOriginal('label_name');
                                $grandChildLabelName = is_array(json_decode($grandChildLabelNameRaw, true))
                                    ? $grandChild->getTranslation('label_name', $locale)
                                    : ($grandChildLabelNameRaw ?? null);
                                $grandChildLabelColor = $grandChild->label_color;
                            @endphp
                            <li class="drop-menu-list__item">
                                <a href="{{ $grandChildLink ?? '#' }}" class="drop-menu-list__link drop-menu-list__link--third-level">
                                    {{ $grandChildTitle }}
                                    @if($grandChildLabelName && $grandChildLabelColor)
                                        <span class="mega-menu__label-badge" style="color: {{ $grandChildLabelColor }};">
                                            {{ $grandChildLabelName }}
                                        </span>
                                    @endif
                                    @if($grandChildProductsCount > 0)
                                        <span class="mega-menu__category-count--mobile">{{ $grandChildProductsCount }}</span>
                                    @endif
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </li>
        @endforeach
        @if($rowChildren->isNotEmpty())
            @foreach($rowChildren as $row)
                @php
                    $rowTitle = $row->getTranslation('title', $locale);
                    $rowLink = $row->getTranslation('link', $locale);
                    $rowChildren = $row->children ? $row->children->where('type', '!=', 'widget_link')->where('type', '!=', 'row')->values() : collect();
                @endphp
                @if($row->display_title)
                    <li class="drop-menu-list__item">
                        <h4 class="mega-menu__category-subtitle">{{ $rowTitle }}</h4>
                    </li>
                @endif
                @if($rowChildren->isNotEmpty())
                    <ul class="column-catalog__list drop-menu-list">
                        @foreach($rowChildren as $rowChild)
                            @php
                                $rowChildTitle = $rowChild->getTranslation('title', $locale);
                                $rowChildLink = $rowChild->getTranslation('link', $locale);
                                $rowChildLabelNameRaw = $rowChild->getRawOriginal('label_name');
                                $rowChildLabelName = is_array(json_decode($rowChildLabelNameRaw, true))
                                    ? $rowChild->getTranslation('label_name', $locale)
                                    : ($rowChildLabelNameRaw ?? null);
                                $rowChildLabelColor = $rowChild->label_color;
                            @endphp
                            <li class="drop-menu-list__item">
                                <a href="{{ $rowChildLink ?? '#' }}" class="drop-menu-list__link">
                                    {{ $rowChildTitle }}
                                    @if($rowChildLabelName && $rowChildLabelColor)
                                        <span class="mega-menu__label-badge" style="color: {{ $rowChildLabelColor }};">
                                            {{ $rowChildLabelName }}
                                        </span>
                                    @endif
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            @endforeach
        @endif
    </ul>
</div>
