@php
    $locale = app()->getLocale();
    $widgetImage = $widget->getFirstMedia('menu_item_image');
    $widgetTitle = $widget->getTranslation('title', $locale);
    $widgetLink = $widget->getTranslation('link', $locale);
    $colorClasses = ['mega-menu__widget--purple', 'mega-menu__widget--green', 'mega-menu__widget--blue', 'mega-menu__widget--red'];
    $widgetIndex = $widgetIndex ?? 0;
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

