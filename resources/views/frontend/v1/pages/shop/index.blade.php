@extends('frontend.v1.layouts.layout')

@section('content')
    @include('frontend.v1.pages.shop.parts.breadcrumbs')
    @include('frontend.v1.pages.shop.parts.shop', ['defaultSort' => $defaultSort])
@endsection

@section('scripts')
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
