@extends('frontend.v1.layouts.layout')

@section('content')
    @include('frontend.v1.pages.category.parts.breadcrumbs')
    @include('frontend.v1.components.breadcrumb-schema', ['items' => $breadcrumbs])
    @include('frontend.v1.pages.category.parts.category')
    @include('frontend.v1.components.seo-content', ['seoContent' => $seoContent ?? null])
@endsection

@section('scripts')
    @include('frontend.v1.analytics.ga4-item-lists')
    <script>
        $(document).ready(function(){
            $('.select-sort-per-page').change(function(){
                const currentValue = $(this).val();

                function updateUrlWithParams(params) {
                    const url = new URL(window.location.href);
                    for (const [key, value] of Object.entries(params)) {
                        if (value) {
                            url.searchParams.set(key, value);
                        }
                    }
                    return url.toString();
                }

                function applySort(perPage) {
                    const newUrl = updateUrlWithParams({ perPage: perPage });
                    window.location.href = newUrl;
                }

                applySort(currentValue);
            })
        })
    </script>
@endsection
