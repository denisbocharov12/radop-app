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
                @if($item->children && $item->children->where('type', '!=', 'widget_link')->isNotEmpty())
                    <div class="mega-menu__columns">
                        @php
                            $regularChildren = $item->children->where('type', '!=', 'widget_link')->values();
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
