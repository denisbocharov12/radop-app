@php
    if (request()->routeIs('theme.shop.sale')) {
        $exportRoute = route('theme.shop.sale.export');
    } elseif (request()->routeIs('theme.shop.popular')) {
        $exportRoute = route('theme.shop.popular.export');
    } elseif (request()->routeIs('theme.shop.new')) {
        $exportRoute = route('theme.shop.new.export');
    } else {
        $exportRoute = null;
    }
@endphp
<div class="export-excel">
    <a href="{{ $exportRoute }}" class="export-excel-link">
        <span>{{ __('theme.download-catalog') }}</span>
        @include('frontend.v1.pages.shop.parts.excel-svg')
    </a>
</div>
