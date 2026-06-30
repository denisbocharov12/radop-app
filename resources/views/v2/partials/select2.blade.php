{{--
    Select2 — isolated initializer (jQuery plugin, loaded from CDN).

    Kept in its own partial, separate from the rest of the inline scripts, so:
      • a select2 failure can't break sibling scripts — every call is wrapped in
        try/catch and the whole thing bails cleanly if jQuery/select2 is missing;
      • its stacking layer is controlled from ONE place. See the
        "Z-INDEX LAYERS" block in resources/css/admin.css.

    Requires jQuery — must be included AFTER jQuery in scripts.blade.php.

    Stacking contract: the select2 container/dropdown live in the CONTENT layer
    (admin.css: .select2-container z-index 20 / --open 25) — BELOW the sticky
    header (30) and therefore below everything the header bounds (command palette,
    user menu). Inside an Alpine modal the dropdown is re-parented (dropdownParent)
    into that modal, which forms its own stacking context, so it still renders on
    top within the modal.
--}}
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    (function () {
        if (typeof window.jQuery === 'undefined') {
            console.warn('[select2] jQuery is not loaded — select2 init skipped.');
            return;
        }
        var $ = window.jQuery;
        if (!$.fn || !$.fn.select2) {
            console.warn('[select2] select2 plugin is not loaded — init skipped.');
            return;
        }

        function initSelect2() {
            $('select')
                .not('.no-select2')
                .not('.select2-hidden-accessible')
                .not('.swal2-select')            // SweetAlert2's built-in hidden <select>
                .not('.swal2-container select')  // any <select> living inside a SweetAlert2 popup
                .each(function () {
                var $el = $(this);
                try {
                    var $modal = $el.closest('[x-show]');
                    // Non-modal: anchor the dropdown to the field's own wrapper so its
                    // width is constrained to the field and it stacks inside the content
                    // layer. In a modal, parent it into the modal's stacking context.
                    var $parent = $modal.length ? $modal : $el.parent();
                    if (!$modal.length) $parent.css('position', 'relative');
                    $el.select2({
                        width: '100%',
                        placeholder: $el.find('option:first').text() || '',
                        dropdownParent: $parent,
                    });
                } catch (e) {
                    console.error('[select2] init failed for element', this, e);
                }
            });
        }
        // Exposed so per-page scripts can re-run it after injecting markup.
        window.initSelect2 = initSelect2;

        $(function () {
            try { initSelect2(); } catch (e) { console.error('[select2] initial init failed', e); }

            var t;
            new MutationObserver(function (m) {
                if (m.some(function (x) { return x.addedNodes.length > 0; })) {
                    clearTimeout(t);
                    t = setTimeout(function () {
                        try { initSelect2(); } catch (e) { console.error('[select2] re-init failed', e); }
                    }, 300);
                }
            }).observe(document.body, { childList: true, subtree: true });
        });
    })();
</script>
