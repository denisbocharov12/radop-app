@php($ga4ItemLists = $ga4ItemLists ?? [])
@if(!empty($ga4ItemLists) && is_array($ga4ItemLists))
<script>
    $(function () {
        if (typeof window.radopGa4EcommercePush !== 'function') {
            return;
        }
        @foreach($ga4ItemLists as $ga4ItemListPayload)
        @if(!empty($ga4ItemListPayload))
        window.radopGa4EcommercePush('view_item_list', @json($ga4ItemListPayload));
        @endif
        @endforeach
    });
</script>
@endif
