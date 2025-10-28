@php
    $user = auth()->guard('user')->user();
    $exportRoute = route('theme.category.export', $existedCategory->onec_id);
    $buttonText = __('theme.download-catalog');
    
    if ($user && $user->sale) {
        $exportRoute = route('theme.category.export.personalized', $existedCategory->onec_id);
        $buttonText = __('theme.download-personalized-catalog');
    }
@endphp
<div class="export-excel">
    <a href="{{ $exportRoute }}" class="export-excel-link">
        <span>{{ $buttonText }}</span>
        @include('frontend.v1.pages.shop.parts.excel-svg')
    </a>
</div>
