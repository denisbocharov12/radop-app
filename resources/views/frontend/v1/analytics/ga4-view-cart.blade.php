@php($ga4ViewCart = $ga4ViewCart ?? null)
@if(!empty($ga4ViewCart))
<script>
    $(function () {
        if (typeof window.radopGa4EcommercePush !== 'function' || !window.radopAnalyticsDataLayerEventNames) {
            return;
        }
        window.radopGa4EcommercePush(window.radopAnalyticsDataLayerEventNames.shopping_cart_page_viewed, @json($ga4ViewCart));
    });
</script>
@endif
