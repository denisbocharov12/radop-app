@php
    $user = auth()->guard('user')->user();
    $exportRoute = null;
    $buttonText = __('theme.download-catalog');
    
    if (request()->routeIs('theme.shop.sale')) {
        $exportRoute = route('theme.shop.sale.export');
        if ($user && $user->sale) {
            $exportRoute = route('theme.shop.sale.export.personalized');
            $buttonText = __('theme.download-personalized-catalog');
        }
    } elseif (request()->routeIs('theme.shop.popular')) {
        $exportRoute = route('theme.shop.popular.export');
        if ($user && $user->sale) {
            $exportRoute = route('theme.shop.popular.export.personalized');
            $buttonText = __('theme.download-personalized-catalog');
        }
    } elseif (request()->routeIs('theme.shop.new')) {
        $exportRoute = route('theme.shop.new.export');
        if ($user && $user->sale) {
            $exportRoute = route('theme.shop.new.export.personalized');
            $buttonText = __('theme.download-personalized-catalog');
        }
    }
@endphp
<div class="export-excel">
    <a href="{{ $exportRoute }}" class="export-excel-link">
        <span>{{ $buttonText }}</span>
        @include('frontend.v1.pages.shop.parts.excel-svg')
    </a>
</div>
