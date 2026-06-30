{{--
    Reusable sortable behaviour (MANUAL save).
    Required: $orderUrl. Optional: $orderExtra (assoc array merged into the POST
    body, e.g. ['category_id' => 123]).
    Posts {order:[{id,position}], _token, ...extra}. Requires jQuery + jQuery-UI.
--}}
@php $orderExtra = $orderExtra ?? []; @endphp
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<style>
    #sortable-contents .sortable-placeholder { height: 60px; border: 1px dashed #76c4e6; background: #eef8fc; border-radius: 8px; }
</style>
<script>
$(function () {
    var $list = $('#sortable-contents');
    if (!$list.length) return;

    var saveUrl = @json($orderUrl);
    var extra   = @json((object) $orderExtra);
    var token   = @json(csrf_token());
    var dirty   = false;

    function items()   { return $list.children('.sortable-item'); }
    function renumber(){ items().each(function (i, el) { $(el).find('.order-input').val(i + 1); }); }

    function notify(type, msg) {
        if (window.Alpine && Alpine.store('toast')) Alpine.store('toast').add(msg, type === 'error' ? 'error' : 'success');
        else if (window.Swal) Swal.fire({ toast: true, position: 'top-end', icon: type, title: msg, showConfirmButton: false, timer: 3000, timerProgressBar: true });
        else alert(msg);
    }
    function markDirty() {
        dirty = true;
        $('#sortable-save').removeClass('btn-primary').addClass('btn-warning');
    }

    // ── Drag & drop (no auto-save) ─────────────────────────────────
    if ($.fn.sortable) {
        $list.sortable({
            items: '.sortable-item',
            handle: '.sortable-handle',
            cursor: 'grabbing',
            opacity: 0.7,
            placeholder: 'sortable-placeholder',
            forcePlaceholderSize: true,
            update: function () { renumber(); markDirty(); }
        });
    }

    // ── Search (name + code) ───────────────────────────────────────
    $('#sortable-search').on('input', function () {
        var q = $(this).val().toLowerCase().trim();
        var shown = 0, total = 0;
        items().each(function () {
            total++;
            var match = q === '' || (($(this).attr('data-search') || '').indexOf(q) !== -1);
            $(this).toggle(match);
            if (match) shown++;
        });
        $('#sortable-count').text(q ? (shown + ' / ' + total) : total);
    });

    // ── Move up one (skips filtered-out rows) ──────────────────────
    $list.on('click', '.move-up', function () {
        var $li = $(this).closest('.sortable-item');
        var $prev = $li.prevAll('.sortable-item:visible').first();
        if ($prev.length) { $prev.before($li); renumber(); markDirty(); }
    });

    // ── Move to the very top ───────────────────────────────────────
    $list.on('click', '.move-top', function () {
        var $li = $(this).closest('.sortable-item');
        $list.prepend($li); renumber(); markDirty();
    });

    // ── Manual order input ─────────────────────────────────────────
    $list.on('change', '.order-input', function () {
        var $li = $(this).closest('.sortable-item');
        var all = items();
        var pos = parseInt($(this).val(), 10);
        if (isNaN(pos) || pos < 1) pos = 1;
        if (pos > all.length) pos = all.length;
        $li.detach();
        if (pos === 1) $list.prepend($li);
        else items().eq(pos - 2).after($li);
        renumber(); markDirty();
    });

    // ── Save ───────────────────────────────────────────────────────
    $('#sortable-save').on('click', function () {
        var $btn = $(this), orig = $btn.html();
        var order = [];
        items().each(function (i, el) { order.push({ id: $(el).attr('data-id'), position: i + 1 }); });

        $btn.prop('disabled', true).html('<i data-lucide="loader" class="w-4 h-4 animate-spin"></i> Сохранение...');
        if (window.renderIcons) window.renderIcons();

        $.ajax({
            type: 'POST', dataType: 'json', url: saveUrl,
            data: $.extend({ order: order, _token: token }, extra),
            success: function (res) {
                if (res && res.status) {
                    dirty = false;
                    $('#sortable-save').removeClass('btn-warning').addClass('btn-primary');
                    notify('success', res.text ? res.text : 'Порядок сохранён');
                } else {
                    notify('error', 'Не удалось сохранить порядок');
                }
            },
            error: function () { notify('error', 'Ошибка сохранения'); },
            complete: function () { $btn.prop('disabled', false).html(orig); if (window.renderIcons) window.renderIcons(); }
        });
    });

    // Warn before leaving with unsaved changes.
    window.addEventListener('beforeunload', function (e) { if (dirty) { e.preventDefault(); e.returnValue = ''; } });
});
</script>
