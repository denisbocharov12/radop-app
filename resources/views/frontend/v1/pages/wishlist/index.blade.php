@extends('frontend.v1.layouts.layout')

@section('content')
    @include('frontend.v1.pages.wishlist.parts.breadcrumbs')
    @include('frontend.v1.pages.wishlist.parts.shop')
@endsection

@section('scripts')
    <script>
        $(function () {
            if (typeof window.radopGa4EventPush === 'function' && window.radopAnalyticsDataLayerEventNames) {
                window.radopGa4EventPush(window.radopAnalyticsDataLayerEventNames.wishlist_page_viewed, @json($ga4ViewWishlist ?? ['wishlist_item_count' => 0]));
            }
        });
    </script>
@endsection
