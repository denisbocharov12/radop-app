@if($menu && $menu->is_active && $menu->rootItems->isNotEmpty())
@php
    $locale = app()->getLocale();
    $nameRaw = $menu->getRawOriginal('name');
    $menuName = is_array(json_decode($nameRaw, true))
        ? $menu->getTranslation('name', $locale)
        : ($nameRaw ?? '');
    $linkRaw = $menu->getRawOriginal('link');
    $menuLink = is_array(json_decode($linkRaw, true))
        ? $menu->getTranslation('link', $locale)
        : ($linkRaw ?? '');
@endphp
<div class="mega-menu {{ $cssClass ?? '' }}" data-menu-code="{{ $code ?? '' }}">
    @if($menuLink)
        <a href="{{ $menuLink }}" id="btn-header-catalog" class="btn-header-catalog" data-mega-menu-toggle>
            <span class="animated-burger-icon"></span>
            <span class="btn-header-catalog-text">{{ $menuName }}</span>
        </a>
    @else
        <button id="btn-header-catalog" class="btn-header-catalog" data-mega-menu-toggle>
            <span class="animated-burger-icon"></span>
            <span class="btn-header-catalog-text">{{ $menuName }}</span>
        </button>
    @endif

    <div class="mega-menu__overlay" data-mega-menu-overlay></div>

    <div class="mega-menu__dropdown" data-mega-menu-dropdown>
        <div class="mega-menu__container">
            <div class="mega-menu__sidebar">
                <div class="mega-menu__sidebar-header" data-mega-menu-close>
                    <button type="button" class="mega-menu__close">
                        <span class="mega-menu__close-icon"></span>
                    </button>
                    <h3 class="mega-menu__sidebar-title">{{ __('theme.mega-menu-title-btn') }}</h3>
                </div>
                <ul class="mega-menu__sidebar-list">
                    @foreach($menu->rootItems->where('type', '!=', 'widget_link')->where('type', '!=', 'row')->values() as $index => $item)
                        @php
                            $itemTitle = $item->getTranslation('title', $locale);
                            $itemLink = $item->getTranslation('link', $locale);
                            $itemLabelNameRaw = $item->getRawOriginal('label_name');
                            $itemLabelName = is_array(json_decode($itemLabelNameRaw, true))
                                ? $item->getTranslation('label_name', $locale)
                                : ($itemLabelNameRaw ?? null);
                            $itemLabelColor = $item->label_color;
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
                                @if($itemLabelName && $itemLabelColor)
                                    <span class="mega-menu__label-badge" style="color: {{ $itemLabelColor }};">
                                        {{ $itemLabelName }}
                                    </span>
                                @endif
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
                                @php
                                    $allChildren = $item->children->where('type', '!=', 'widget_link')->values();
                                    $groups = collect();
                                    $currentGroup = collect();
                                    $currentGroupType = null;
                                    
                                    foreach ($allChildren as $child) {
                                        if ($child->type === 'row') {
                                            if ($currentGroup->isNotEmpty() && $currentGroupType !== 'row') {
                                                $groups->push(['type' => 'regular', 'items' => $currentGroup]);
                                                $currentGroup = collect();
                                            }
                                            $currentGroup->push($child);
                                            $currentGroupType = 'row';
                                        } else {
                                            if ($currentGroupType === 'row') {
                                                $groups->push(['type' => 'row', 'items' => $currentGroup]);
                                                $currentGroup = collect();
                                            }
                                            $currentGroup->push($child);
                                            $currentGroupType = 'regular';
                                        }
                                    }
                                    
                                    if ($currentGroup->isNotEmpty()) {
                                        $groups->push(['type' => $currentGroupType, 'items' => $currentGroup]);
                                    }
                                @endphp
                                @foreach($groups as $group)
                                    @if($group['type'] === 'row')
                                        <div class="mega-menu__columns_with_row">
                                            @foreach($group['items'] as $rowChild)
                                                @include('partials.menus.mega-menu-category-item', ['item' => $rowChild])
                                            @endforeach
                                        </div>
                                    @else
                                        @php
                                            $regularItems = $group['items'];
                                            $columnCount = 3;
                                            $columns = $regularItems->chunk(ceil($regularItems->count() / $columnCount));
                                        @endphp
                                        <div class="mega-menu__columns" style="display: grid; grid-template-columns: repeat({{ $columnCount }}, 1fr); gap: 20px;">
                                            @foreach($columns as $column)
                                                <div class="mega-menu__column">
                                                    @foreach($column as $child)
                                                        @include('partials.menus.mega-menu-category-item', ['item' => $child])
                                                    @endforeach
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                @endforeach
                            @else
                                <div class="mega-menu__empty">
                                    <p>{{ __('theme.no-subcategories') }}</p>
                                </div>
                            @endif
                        </div>
                    @endforeach
            </div>
        </div>
    </div>
</div>
@endif

