{{--
    Reusable drag-and-drop reorder script.
    Required: $orderUrl. Optional: $sortableId (default 'sortable-contents'),
              $itemClass (default 'sortable-item'), $orderExtra (assoc array merged
              into the POST body, e.g. ['category_id'=>123]), $positionBase (default 1).
    Posts {order:[{id,position}], ...extra}. Feedback via Alpine toast store.
--}}
@php
    $sortableId   = $sortableId   ?? 'sortable-contents';
    $itemClass    = $itemClass    ?? 'sortable-item';
    $positionBase = $positionBase ?? 1;
@endphp
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<style>
    #{{ $sortableId }} .sortable-placeholder { height: 44px; background: #eef8fc; border: 1px dashed #76c4e6; border-radius: 8px; }
</style>
<script>
    $(function () {
        if (!$.fn.sortable) return;
        $('#{{ $sortableId }}').sortable({
            items: '.{{ $itemClass }}',
            cursor: 'grabbing',
            opacity: 0.7,
            placeholder: 'sortable-placeholder',
            forcePlaceholderSize: true,
            update: function () {
                var order = [];
                $('#{{ $sortableId }} .{{ $itemClass }}').each(function (i) {
                    order.push({ id: $(this).attr('data-id'), position: i + {{ $positionBase }} });
                });
                var payload = { order: order };
                @isset($orderExtra)
                    Object.assign(payload, @json($orderExtra));
                @endisset
                window.axios.post(@json($orderUrl), payload)
                    .then(function (r) { window.Alpine.store('toast').add((r.data && r.data.text) ? r.data.text : 'Порядок сохранён', 'success'); })
                    .catch(function () { window.Alpine.store('toast').add('Ошибка при сохранении порядка', 'error'); });
            }
        });
    });
</script>
