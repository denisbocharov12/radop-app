@if($menu && $menu->is_active && $menu->rootItems->isNotEmpty())
@php
    $locale = app()->getLocale();
    $widgetItems = $menu->rootItems->where('type', 'widget_link');
    $categoryItems = $menu->rootItems->where('type', '!=', 'widget_link')->where('type', '!=', 'row')->values();
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
            @foreach($categoryItems as $index => $item)
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
        @if($widgetItems->isNotEmpty())
            <div class="mega-menu__widgets">
                @foreach($widgetItems->values() as $widget)
                    @include('partials.menus.mega-menu-widget', ['widget' => $widget, 'widgetIndex' => $loop->index])
                @endforeach
            </div>
        @endif
        @if($categoryItems->isNotEmpty())
            @foreach($categoryItems as $index => $item)
                <div class="mega-menu__category-panel @if($index === 0) mega-menu__category-panel--active @endif"
                     data-category-panel="{{ $item->id }}">
                    @if($index === 0)
                        @include('partials.menus.mega-menu-category-content', ['item' => $item])
                    @endif
                </div>
            @endforeach
        @endif
    </div>
</div>
@endif
