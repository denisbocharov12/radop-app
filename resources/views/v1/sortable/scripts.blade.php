{{--
    Reusable sortable behaviour (manual save).

    Expected variables:
      $saveUrl  POST endpoint receiving { order:[{id,position}], _token, ...extra }
      $extra    optional assoc array merged into the POST body (e.g. ['category_id' => ...])

    Requires jQuery, jQuery-UI sortable and (optionally) toastr to be loaded on the page.
--}}
@php $extra = $extra ?? []; @endphp
<script type="text/javascript">
    $(function () {
        var $list   = $('#sortable-contents');
        var saveUrl = @json($saveUrl);
        var extra   = @json((object) $extra);
        var token   = @json(csrf_token());
        var dirty   = false;

        function items() { return $list.children('.sortable-item'); }

        // Re-number the "order" inputs to match current DOM order.
        function renumber() {
            items().each(function (i, el) { $(el).find('.order-input').val(i + 1); });
        }

        function markDirty() {
            dirty = true;
            $('#sortable-save').addClass('btn-warning').removeClass('btn-primary');
        }

        // ── Drag & drop ────────────────────────────────────────────────
        $list.sortable({
            items: '.sortable-item',
            handle: '.sortable-handle',
            cursor: 'grabbing',
            opacity: 0.7,
            placeholder: 'sortable-placeholder',
            forcePlaceholderSize: true,
            update: function () { renumber(); markDirty(); }
        });

        // ── Search (by title + code) ───────────────────────────────────
        $('#sortable-search').on('input', function () {
            var q = $(this).val().toLowerCase().trim();
            items().each(function () {
                var hay = ($(this).data('title') + ' ' + $(this).data('code'));
                $(this).toggleClass('is-hidden', q !== '' && hay.indexOf(q) === -1);
            });
        });

        // ── Move up one position ───────────────────────────────────────
        $list.on('click', '.move-up', function () {
            var $li = $(this).closest('.sortable-item');
            var $prev = $li.prevAll('.sortable-item:not(.is-hidden)').first();
            if ($prev.length) { $prev.before($li); renumber(); markDirty(); }
        });

        // ── Move to the very top ───────────────────────────────────────
        $list.on('click', '.move-top', function () {
            var $li = $(this).closest('.sortable-item');
            $list.prepend($li);
            renumber(); markDirty();
        });

        // ── Manual order input ─────────────────────────────────────────
        $list.on('change', '.order-input', function () {
            var $li  = $(this).closest('.sortable-item');
            var all  = items();
            var pos  = parseInt($(this).val(), 10);
            if (isNaN(pos) || pos < 1) pos = 1;
            if (pos > all.length) pos = all.length;
            $li.detach();
            if (pos === 1) { $list.prepend($li); }
            else { items().eq(pos - 2).after($li); }
            renumber(); markDirty();
        });

        // ── Save ───────────────────────────────────────────────────────
        $('#sortable-save').on('click', function () {
            var $btn = $(this);
            var orig = $btn.html();
            var order = [];
            items().each(function (i, el) {
                order.push({ id: $(el).attr('data-id'), position: i + 1 });
            });

            $btn.prop('disabled', true).html('<em class="icon ni ni-loader ni-spin"></em> Сохранение...');

            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: saveUrl,
                data: $.extend({ order: order, _token: token }, extra),
                success: function (res) {
                    if (res && res.status) {
                        dirty = false;
                        $btn.removeClass('btn-warning').addClass('btn-primary');
                        notify('success', (res.text) ? res.text : 'Сохранено');
                    } else {
                        notify('error', 'Не удалось сохранить порядок');
                    }
                },
                error: function () { notify('error', 'Ошибка сохранения'); },
                complete: function () { $btn.prop('disabled', false).html(orig); }
            });
        });

        // Warn before leaving with unsaved changes.
        window.addEventListener('beforeunload', function (e) {
            if (dirty) { e.preventDefault(); e.returnValue = ''; }
        });

        function notify(type, msg) {
            if (window.toastr) {
                toastr.options = { positionClass: 'toast-bottom-right', timeOut: 4000, closeButton: true, progressBar: true };
                toastr[type](msg);
            } else { alert(msg); }
        }
    });
</script>
