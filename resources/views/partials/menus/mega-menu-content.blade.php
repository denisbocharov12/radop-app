@if($menu && $menu->is_active && $menu->rootItems->isNotEmpty())
@php
    $locale = app()->getLocale();
@endphp
<div class="mega-menu__container">
    <div class="mega-menu__sidebar">
        <div class="mega-menu__sidebar-header" data-mega-menu-close>
            <button type="button" class="mega-menu__close">
                <span class="mega-menu__close-icon"></span>
            </button>
            <h3 class="mega-menu__sidebar-title">{{ __('theme.mega-menu-title-btn') }}</h3>
        </div>
        <ul class="mega-menu__sidebar-list">
            @foreach($menu->rootItems->where('type', '!=', 'widget_link')->values() as $index => $item)
                @php
                    $itemTitle = $item->getTranslation('title', $locale);
                    $itemLink = $item->getTranslation('link', $locale);
                @endphp
                <li class="mega-menu__sidebar-item @if($index === 0) mega-menu__sidebar-item--active @endif"
                    data-category-id="{{ $item->id }}">
                    <a href="{{ $itemLink ?? '#' }}" class="mega-menu__sidebar-link">
                        @php
                            $itemImage = $item->getFirstMedia('menu_item_image');
                        @endphp
                        @if($itemImage)
                            <img src="{{ $itemImage->getUrl() }}" alt="{{ $itemTitle }}" class="mega-menu__sidebar-icon">
                        @endif
                        <span class="mega-menu__sidebar-text">{{ $itemTitle }}</span>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
    <div class="mega-menu__content">
        @php
            $widgetItems = $menu->rootItems->where('type', 'widget_link');
            $categoryItems = $menu->rootItems->where('type', '!=', 'widget_link')->values();
        @endphp
        @if($widgetItems->isNotEmpty())
            <div class="mega-menu__widgets">
                @foreach($widgetItems->values() as $widget)
                    @include('partials.menus.mega-menu-widget', ['widget' => $widget, 'widgetIndex' => $loop->index])
                @endforeach
            </div>
        @endif
        @foreach($categoryItems as $index => $item)
            <div class="mega-menu__category-panel @if($index === 0) mega-menu__category-panel--active @endif"
                 data-category-panel="{{ $item->id }}">
                @php
                    $regularChildren = $item->children ? $item->children->where('type', '!=', 'widget_link')->where('type', '!=', 'row')->values() : collect();
                    $rowChildren = $item->children ? $item->children->where('type', 'row')->values() : collect();
                @endphp
                @if($regularChildren->isNotEmpty() || $rowChildren->isNotEmpty())
                    @if($regularChildren->isNotEmpty())
                        <div class="mega-menu__columns">
                            @php
                                $columns = $regularChildren->chunk(ceil($regularChildren->count() / 3));
                            @endphp
                            @foreach($columns as $column)
                                <div class="mega-menu__column">
                                    @foreach($column as $child)
                                        @include('partials.menus.mega-menu-category-item', ['item' => $child])
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    @endif
                    @if($rowChildren->isNotEmpty())
                        @foreach($rowChildren as $row)
                            @php
                                $rowTitle = $row->getTranslation('title', $locale);
                            @endphp
                            <div class="mega-menu__row">
                                @if($rowTitle)
                                    <h3 class="mega-menu__row-title">{{ $rowTitle }}</h3>
                                @endif
                                @if($row->children && $row->children->where('type', '!=', 'widget_link')->where('type', '!=', 'row')->isNotEmpty())
                                    <div class="mega-menu__columns">
                                        @php
                                            $rowItemsChildren = $row->children->where('type', '!=', 'widget_link')->where('type', '!=', 'row')->values();
                                            $rowColumns = $rowItemsChildren->chunk(ceil($rowItemsChildren->count() / 3));
                                        @endphp
                                        @foreach($rowColumns as $column)
                                            <div class="mega-menu__column">
                                                @foreach($column as $child)
                                                    @include('partials.menus.mega-menu-category-item', ['item' => $child])
                                                @endforeach
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    @endif
                @else
                    <div class="mega-menu__empty">
                        <p>{{ __('theme.no-subcategories') }}</p>
                    </div>
                @endif
            </div>
        @endforeach
    </div>
</div>
@endif
