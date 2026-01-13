@php
    $locale = app()->getLocale();
    $widgetImage = $widget->getFirstMedia('menu_item_image');
    $widgetTitle = $widget->getTranslation('title', $locale);
    $widgetLink = $widget->getTranslation('link', $locale);
    $colorClasses = ['mega-menu__widget--yellow', 'mega-menu__widget--red', 'mega-menu__widget--green', 'mega-menu__widget--blue'];
    $widgetIndex = $widgetIndex ?? 0;
    $colorIndex = $widgetIndex % 4;
    $colorClass = $colorClasses[$colorIndex];
    
    $widgetProductsCount = 0;
    if ($widget->category_id) {
        $category = \App\Models\Category::where('onec_id', $widget->category_id)->first();
        if ($category) {
            $widgetProductsCount = $category->products()
                ->where('status', true)
                ->where('site_status', true)
                ->where('stock', '!=', 0)
                ->count();
        }
    }
@endphp
<div class="mega-menu__widget {{ $colorClass }}">
    @if($widgetLink)
        <a href="{{ $widgetLink }}" class="mega-menu__widget-link" target="{{ $widget->target ?? '_self' }}">
            @if($widgetImage)
                <img src="{{ $widgetImage->getUrl() }}" alt="{{ $widgetTitle }}" class="mega-menu__widget-icon">
            @endif
            <span class="mega-menu__widget-text">{{ $widgetTitle }}</span>
            @if($widgetProductsCount > 0)
                <span class="mega-menu__widget-count">({{ $widgetProductsCount }})</span>
            @endif
        </a>
    @else
        <div class="mega-menu__widget-link">
            @if($widgetImage)
                <img src="{{ $widgetImage->getUrl() }}" alt="{{ $widgetTitle }}" class="mega-menu__widget-icon">
            @endif
            <span class="mega-menu__widget-text">{{ $widgetTitle }}</span>
            @if($widgetProductsCount > 0)
                <span class="mega-menu__widget-count">({{ $widgetProductsCount }})</span>
            @endif
        </div>
    @endif
</div>

