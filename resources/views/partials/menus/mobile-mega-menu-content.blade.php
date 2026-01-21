@if($menu && $menu->is_active && $menu->rootItems->isNotEmpty())
@php
    $locale = app()->getLocale();
    $widgetItems = $menu->rootItems->where('type', 'widget_link')->values();
    $allMobileItems = $menu->rootItems->where('type', '!=', 'widget_link')->values();
@endphp
<div class="catalog theme-catalog-body">
    @if($widgetItems->isNotEmpty())
        <div class="catalog__widgets">
            <div>
                @foreach($widgetItems as $widget)
                    @php
                        $widgetImage = $widget->getFirstMedia('menu_item_image');
                        $widgetTitle = $widget->getTranslation('title', $locale);
                        $widgetLink = $widget->getTranslation('link', $locale);
                        $colorClasses = ['mega-menu__widget--purple', 'mega-menu__widget--green', 'mega-menu__widget--blue', 'mega-menu__widget--red'];
                        $widgetIndex = $loop->index;
                        $colorIndex = $widgetIndex % 4;
                        $colorClass = $colorClasses[$colorIndex];
                    @endphp
                    <div class="mega-menu__widget {{ $colorClass }}">
                        @if($widgetLink)
                            <a href="{{ $widgetLink }}" class="mega-menu__widget-link" target="{{ $widget->target ?? '_self' }}">
                                @if($widgetImage)
                                    <img src="{{ $widgetImage->getUrl() }}" alt="{{ $widgetTitle }}" class="mega-menu__widget-icon">
                                @endif
                                <span class="mega-menu__widget-text">{{ $widgetTitle }}</span>
                            </a>
                        @else
                            <div class="mega-menu__widget-link">
                                @if($widgetImage)
                                    <img src="{{ $widgetImage->getUrl() }}" alt="{{ $widgetTitle }}" class="mega-menu__widget-icon">
                                @endif
                                <span class="mega-menu__widget-text">{{ $widgetTitle }}</span>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    @endif
    <div class="catalog__main-column main-column-catalog">
        <ul class="main-column-catalog__list column-style">
            @foreach($allMobileItems as $item)
                @php
                    $itemTitle = $item->getTranslation('title', $locale);
                    $itemLink = $item->getTranslation('link', $locale);
                    $hasChildren = $item->children && $item->children->where('type', '!=', 'widget_link')->where('type', '!=', 'row')->isNotEmpty();
                @endphp
                <li class="main-column-catalog__item">
                    <a class="main-column-catalog__link catalog-category-link"
                       @if($hasChildren)
                           href="#"
                           data-main-category="{{ $item->id }}"
                       @else
                           href="{{ $itemLink ?? '#' }}"
                       @endif>
                        {{ $itemTitle }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>

    <div class="catalog__second-column column-catalog">
        @foreach($allMobileItems as $item)
            @php
                $itemTitle = $item->getTranslation('title', $locale);
                $itemLink = $item->getTranslation('link', $locale);
                $regularChildren = $item->children ? $item->children->where('type', '!=', 'widget_link')->where('type', '!=', 'row')->values() : collect();
                $rowChildren = $item->children ? $item->children->where('type', 'row')->values() : collect();
            @endphp
            @if($regularChildren->isNotEmpty() || $rowChildren->isNotEmpty())
                <div class="column-catalog__item column-style" id="{{ $item->id }}">
                    <h3 class="column-catalog__title">
                        <span class="column-catalog__back catalog-back-arrow" title="Назад"></span>
                        <span class="catalog-category-title">{{ $itemTitle }}</span>
                    </h3>
                    <ul class="column-catalog__list drop-menu-list">
                        @if($item->type !== 'row')
                            <li>
                                <a href="{{ $itemLink ?? route('theme.shop.catalog') }}" class="catalog-all-link">{{ __('theme.all-mobile-catalog') }}</a>
                            </li>
                        @endif
                        @foreach($regularChildren as $child)
                            @php
                                $childTitle = $child->getTranslation('title', $locale);
                                $childLink = $child->getTranslation('link', $locale);
                                $childHasChildren = $child->children && $child->children->where('type', '!=', 'widget_link')->where('type', '!=', 'row')->isNotEmpty();
                                $childProductsCount = $child->products_count ?? 0;
                            @endphp
                            <li class="drop-menu-list__item">
                                <a href="{{ $childLink ?? '#' }}" class="drop-menu-list__link">
                                    {{ $childTitle }}
                                </a>
                                @if($childHasChildren)
                                    <ul class="column-catalog__list drop-menu-list">
                                        @foreach($child->children->where('type', '!=', 'widget_link')->where('type', '!=', 'row')->values() as $grandChild)
                                            @php
                                                $grandChildTitle = $grandChild->getTranslation('title', $locale);
                                                $grandChildLink = $grandChild->getTranslation('link', $locale);
                                                $grandChildProductsCount = $grandChild->products_count ?? 0;
                                            @endphp
                                            <li class="drop-menu-list__item">
                                                <a href="{{ $grandChildLink ?? '#' }}" class="drop-menu-list__link drop-menu-list__link--third-level">
                                                    {{ $grandChildTitle }}
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
                        @foreach($rowChildren as $row)
                            @php
                                $rowTitle = $row->getTranslation('title', $locale);
                                $rowRegularChildren = $row->children ? $row->children->where('type', '!=', 'widget_link')->where('type', '!=', 'row')->values() : collect();
                            @endphp
                            @if($rowRegularChildren->isNotEmpty())
                                <li class="drop-menu-list__item">
                                    @if($rowTitle)
                                        <div class="drop-menu-list__row-title">{{ $rowTitle }}</div>
                                    @endif
                                    <ul class="column-catalog__list drop-menu-list">
                                        @foreach($rowRegularChildren as $rowChild)
                                            @php
                                                $rowChildTitle = $rowChild->getTranslation('title', $locale);
                                                $rowChildLink = $rowChild->getTranslation('link', $locale);
                                                $rowChildProductsCount = $rowChild->products_count ?? 0;
                                            @endphp
                                            <li class="drop-menu-list__item">
                                                <a href="{{ $rowChildLink ?? '#' }}" class="drop-menu-list__link">
                                                    {{ $rowChildTitle }}
                                                    @if($rowChildProductsCount > 0)
                                                        <span class="mega-menu__category-count--mobile">{{ $rowChildProductsCount }}</span>
                                                    @endif
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            @endif
        @endforeach
    </div>
    <button class="catalog__close-btn _icon-close" type="button"></button>
</div>
@endif
