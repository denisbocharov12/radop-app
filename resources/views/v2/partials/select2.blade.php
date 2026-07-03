{{--
    Select2 — fully self-contained module (CSS + JS).

    Everything select2 lives here so it can be reasoned about in one place and
    can't leak into / be broken by the rest of the admin styles:
      • CDN CSS + JS (jQuery plugin) are loaded here;
      • theming to match the v2 form controls is in the <style> below (loads
        AFTER the CDN CSS, so overrides win — !important beats the CDN);
      • the initializer is guarded (bails cleanly if jQuery/select2 is missing);
      • stacking is controlled from this one place.

    Requires jQuery — included AFTER jQuery in scripts.blade.php.

    DROPDOWN PLACEMENT
    ------------------
    Non-modal selects use select2's DEFAULT parent (document.body). This is the
    only reliable way to keep the results list from being clipped by a card's
    `overflow-hidden`/`overflow-x: clip` — the previous per-field `dropdownParent`
    parented the list inside the card and it got cut off (the "списки не
    отображаются" bug). Page-overflow from a body-appended list is prevented by
    the `max-width` guards in the CSS below.

    Inside an Alpine modal ([x-show]) the list IS re-parented into the modal so it
    forms the modal's stacking context and renders on top within it.

    Z-INDEX (single source for select2; other layers documented in admin.css):
      content 0 · select2 closed 20 / open 25 · header 30 · sidebar 50 ·
      table-actions 70 · modal 80 · confirm 90 · palette 95 · toasts 100 · swal 100000
--}}
<link href="{{ asset('/v1/frontend/assets/libs/select2/select2.min.css') }}" rel="stylesheet" />

<style>
    /* The INLINE (closed) selection box fills its form column. The OPEN dropdown
       is body-appended and sized by select2 itself to match the field width — we
       only cap it to the page width so it can never cause horizontal overflow
       (100% of the containing block, not 100vw, to avoid the scrollbar gutter). */
    .select2-container:not([style*="absolute"]) { width: 100% !important; }
    .select2-container[style*="absolute"]        { max-width: 100% !important; }

    .select2-container--default .select2-selection--single {
        height: 38px !important; border: 1px solid #d1d5db !important; border-radius: 0.5rem !important;
        display: flex !important; align-items: center !important; padding: 0 0.75rem !important; background-color: #fff;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered { color: #111827; line-height: 1.4; padding: 0; font-size: 0.875rem; }
    .select2-container--default .select2-selection--single .select2-selection__placeholder { color: #9ca3af; }
    .select2-container--default .select2-selection--single .select2-selection__arrow { height: 36px !important; right: 8px !important; }
    .select2-container--default.select2-container--open .select2-selection--single,
    .select2-container--default.select2-container--focus .select2-selection--single {
        border-color: #0f86bd !important; box-shadow: 0 0 0 2px rgba(15, 134, 189, .2) !important; outline: none !important;
    }

    .select2-container--default .select2-selection--multiple { min-height: 38px !important; border: 1px solid #d1d5db !important; border-radius: 0.5rem !important; padding: 2px 6px; }
    .select2-container--default.select2-container--focus .select2-selection--multiple { border-color: #0f86bd !important; box-shadow: 0 0 0 2px rgba(15, 134, 189, .2) !important; }
    .select2-container--default .select2-selection--multiple .select2-selection__choice { background: #eef8fc !important; border: 1px solid #aedcf1 !important; color: #015589 !important; border-radius: 0.375rem !important; padding: 2px 8px; }
    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove { color: #0f86bd !important; border: none; }

    .select2-dropdown { border: 1px solid #d1d5db !important; border-radius: 0.5rem !important; box-shadow: 0 10px 25px -5px rgba(0, 0, 0, .12) !important; overflow: hidden; }
    .select2-container--default .select2-results__option { font-size: 0.875rem; padding: 0.5rem 0.75rem; color: #374151; }
    .select2-container--default .select2-results__option--highlighted[aria-selected],
    .select2-container--default .select2-results__option--highlighted { background-color: #0068a7 !important; color: #fff !important; }
    .select2-container--default .select2-results__option[aria-selected=true] { background-color: #eef8fc; color: #015589; }
    .select2-search--dropdown .select2-search__field { border: 1px solid #d1d5db !important; border-radius: 0.375rem; padding: 0.4rem 0.5rem; outline: none; }
    .select2-search--dropdown .select2-search__field:focus { border-color: #0f86bd !important; }

    /* Stacking. The OPEN dropdown is body-appended and must render above all
       page content and the sticky header — a too-low value was hiding it behind
       the content/header. Kept below SweetAlert2 (100000). */
    .select2-container       { z-index: 20; }
    .select2-container--open { z-index: 9990 !important; }
    .select2-container--open .select2-dropdown,
    .select2-dropdown        { z-index: 9990 !important; }
</style>

<script src="{{ asset('/v1/frontend/assets/libs/select2/select2.min.js') }}"></script>
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
                        var opts = {
                            width: '100%',
                            placeholder: $el.find('option:first').text() || '',
                        };
                        // Only re-parent inside a modal; otherwise use the default
                        // (document.body) so a card's overflow can't clip the list.
                        var $modal = $el.closest('[x-show]');
                        if ($modal.length) { opts.dropdownParent = $modal; }

                        $el.select2(opts);
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
