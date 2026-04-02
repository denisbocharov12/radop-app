@php
    $user = auth()->guard('user')->user();
    $exportRoute = route('theme.category.export', $category->onec_id);
    $buttonText = __('theme.download-catalog');
    if ($user && $user->sale) {
        $exportRoute = route('theme.category.export.personalized', $category->onec_id);
        $buttonText = __('theme.download-personalized-catalog');
    }
@endphp
<div class="export-excel export-excel--category-row">
    <a href="{{ $exportRoute }}" class="export-excel-link">
        <span>{{ $buttonText }}</span>
        @include('frontend.v1.pages.shop.parts.excel-svg')
    </a>
</div>
