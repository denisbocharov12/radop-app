@php
    $user = auth()->guard('user')->user();
    $exportRoute = route('theme.brand.export', $existedBrand->id);
    $buttonText = __('theme.download-catalog');
    
    if ($user && $user->sale) {
        $exportRoute = route('theme.brand.export.personalized', $existedBrand->id);
        $buttonText = __('theme.download-personalized-catalog');
    }
@endphp
<div class="export-excel">
    <a href="{{ $exportRoute }}" class="export-excel-link">
        <span>{{ $buttonText }}</span>
        @include('frontend.v1.pages.shop.parts.excel-svg')
    </a>
</div>
