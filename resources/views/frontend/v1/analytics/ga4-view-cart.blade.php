@php($ga4ViewCart = $ga4ViewCart ?? null)
@if(!empty($ga4ViewCart))
<script>
    $(function () {
        if (typeof window.radopGa4EcommercePush !== 'function') {
            return;
        }
        window.radopGa4EcommercePush('view_cart', @json($ga4ViewCart));
    });
</script>
@endif
