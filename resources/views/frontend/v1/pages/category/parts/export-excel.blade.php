<div class="export-excel">
    <a href="{{route('theme.category.export', $existedCategory->onec_id)}}" class="export-excel-link">
        <span>{{ __('theme.download-catalog') }}</span>
        @include('frontend.v1.pages.shop.parts.excel-svg')
    </a>
</div>
