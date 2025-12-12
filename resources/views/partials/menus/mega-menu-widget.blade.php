@php
    $locale = app()->getLocale();
    $widgetImage = $widget->getFirstMedia('menu_item_image');
    $widgetTitle = $widget->getTranslation('title', $locale);
    $widgetLink = $widget->getTranslation('link', $locale);
@endphp
<div class="mega-menu__widget">
    @if($widgetLink)
        <a href="{{ $widgetLink }}" class="mega-menu__widget-link" target="{{ $widget->target ?? '_self' }}">
            @if($widgetImage)
                <div class="mega-menu__widget-image">
                    <img src="{{ $widgetImage->getUrl() }}" alt="{{ $widgetTitle }}">
                </div>
            @endif
            <div class="mega-menu__widget-content">
                <h4 class="mega-menu__widget-title">{{ $widgetTitle }}</h4>
                @if($widget->content_data && isset($widget->content_data['description']))
                    <p class="mega-menu__widget-description">{{ $widget->content_data['description'] }}</p>
                @endif
            </div>
        </a>
    @else
        <div class="mega-menu__widget-link">
            @if($widgetImage)
                <div class="mega-menu__widget-image">
                    <img src="{{ $widgetImage->getUrl() }}" alt="{{ $widgetTitle }}">
                </div>
            @endif
            <div class="mega-menu__widget-content">
                <h4 class="mega-menu__widget-title">{{ $widgetTitle }}</h4>
                @if($widget->content_data && isset($widget->content_data['description']))
                    <p class="mega-menu__widget-description">{{ $widget->content_data['description'] }}</p>
                @endif
            </div>
        </div>
    @endif
</div>

