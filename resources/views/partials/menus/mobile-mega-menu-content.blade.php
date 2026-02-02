@if($menu && $menu->is_active && $menu->rootItems->isNotEmpty())
@php
    $locale = app()->getLocale();
    $widgetItems = $menu->rootItems->where('type', 'widget_link')->values();
    $categoryItems = $menu->rootItems->where('type', '!=', 'widget_link')->where('type', '!=', 'row')->values();
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
            @foreach($categoryItems as $item)
                @php
                    $itemTitle = $item->getTranslation('title', $locale);
                    $itemLink = $item->getTranslation('link', $locale);
                    $hasChildren = $item->children && $item->children->where('type', '!=', 'widget_link')->where('type', '!=', 'row')->isNotEmpty();
                    $labelNameRaw = $item->getRawOriginal('label_name');
                    $labelName = is_array(json_decode($labelNameRaw, true))
                        ? $item->getTranslation('label_name', $locale)
                        : ($labelNameRaw ?? null);
                    $labelColor = $item->label_color;
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
                        @if($labelName && $labelColor)
                            <span class="mega-menu__label-badge" style="color: {{ $labelColor }};">
                                {{ $labelName }}
                            </span>
                        @endif
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
    <div class="catalog__second-column column-catalog" data-category-content-container></div>
</div>
@endif
