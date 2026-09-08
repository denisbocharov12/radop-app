/**
 * Small progressive enhancements that do not deserve a Vue island:
 * they touch DOM the server already rendered and hold no state worth
 * reactivity.
 */

/** Header gains a shadow only once the page has actually scrolled. */
function stickyHeaderShadow() {
    const header = document.querySelector('[data-sf-header]');
    if (!header) return;

    const apply = () => header.classList.toggle('shadow-card', window.scrollY > 4);
    apply();
    window.addEventListener('scroll', apply, { passive: true });
}

/**
 * Scroll-snap rails get prev/next buttons on pointer devices; touch users
 * already have the native swipe, and the buttons are hidden there by CSS.
 */
function productRails() {
    document.querySelectorAll('[data-sf-rail]').forEach((wrapper) => {
        const rail = wrapper.querySelector('.sf-rail');
        const prev = wrapper.querySelector('[data-sf-rail-prev]');
        const next = wrapper.querySelector('[data-sf-rail-next]');
        if (!rail) return;

        const step = () => rail.clientWidth * 0.8;

        const sync = () => {
            const max = rail.scrollWidth - rail.clientWidth - 1;
            prev?.toggleAttribute('disabled', rail.scrollLeft <= 0);
            next?.toggleAttribute('disabled', rail.scrollLeft >= max);
        };

        prev?.addEventListener('click', () => rail.scrollBy({ left: -step(), behavior: 'smooth' }));
        next?.addEventListener('click', () => rail.scrollBy({ left: step(), behavior: 'smooth' }));
        rail.addEventListener('scroll', sync, { passive: true });
        window.addEventListener('resize', sync, { passive: true });
        sync();
    });
}

/** <details data-sf-accordion> groups behave as a single-open accordion. */
function accordions() {
    document.querySelectorAll('[data-sf-accordion]').forEach((group) => {
        const panels = [...group.querySelectorAll(':scope > details')];
        panels.forEach((panel) => {
            panel.addEventListener('toggle', () => {
                if (!panel.open) return;
                panels.filter((other) => other !== panel).forEach((other) => { other.open = false; });
            });
        });
    });
}

/**
 * Keep the header basket in step with whatever island last changed the cart,
 * without re-rendering the header from server HTML the way the old code did.
 */
function cartBadge() {
    document.addEventListener('sf:cart-updated', (event) => {
        const { total, cart_count: count } = event.detail ?? {};

        const totalEl = document.querySelector('[data-sf-cart-total]');
        if (totalEl && total != null) totalEl.textContent = total;

        const countEl = document.querySelector('[data-sf-cart-count]');
        if (!countEl) return;

        // `cart_count` arrives pluralised for display ("3 produse"); the badge
        // wants the bare number.
        const n = Number.parseInt(String(count ?? '').replace(/\D+/g, ''), 10);
        if (Number.isNaN(n)) return;
        countEl.textContent = n > 99 ? '99+' : String(n);
        countEl.hidden = n === 0;
    });
}

/**
 * Off-canvas panels driven by data attributes, so a panel's contents can stay
 * server-rendered and appear exactly once in the DOM:
 *
 *   <button data-sf-drawer-open="filters">
 *   <div data-sf-drawer="filters"> … <button data-sf-drawer-close> … </div>
 *
 * The catalogue sidebar uses this to be a column on desktop and a slide-over on
 * mobile without the form being duplicated the way the legacy modal did it.
 */
function drawers() {
    const setOpen = (panel, open) => {
        panel.classList.toggle('translate-x-0', open);
        panel.classList.toggle('-translate-x-full', !open);
        panel.dataset.sfDrawerOpen = open ? 'true' : 'false';

        const overlay = document.querySelector(`[data-sf-drawer-overlay="${panel.dataset.sfDrawer}"]`);
        if (overlay) overlay.hidden = !open;

        document.body.style.overflow = open ? 'hidden' : '';
    };

    document.addEventListener('click', (event) => {
        const opener = event.target.closest('[data-sf-drawer-open]');
        if (opener) {
            const panel = document.querySelector(`[data-sf-drawer="${opener.dataset.sfDrawerOpen}"]`);
            if (panel) {
                event.preventDefault();
                setOpen(panel, true);
            }
            return;
        }

        const closer = event.target.closest('[data-sf-drawer-close], [data-sf-drawer-overlay]');
        if (!closer) return;
        const id = closer.dataset.sfDrawerOverlay ?? closer.closest('[data-sf-drawer]')?.dataset.sfDrawer;
        const panel = document.querySelector(`[data-sf-drawer="${id}"]`);
        if (panel) setOpen(panel, false);
    });

    document.addEventListener('keydown', (event) => {
        if (event.key !== 'Escape') return;
        document.querySelectorAll('[data-sf-drawer][data-sf-drawer-open="true"]')
            .forEach((panel) => setOpen(panel, false));
    });
}

/** Copy a product code to the clipboard from anywhere on the page. */
function copyButtons() {
    document.addEventListener('click', async (event) => {
        const el = event.target.closest('[data-copy-value]');
        if (!el) return;
        try {
            await navigator.clipboard.writeText(el.dataset.copyValue);
            if (window.toastr?.success) window.toastr.success(el.dataset.copyMessage ?? '');
        } catch {
            /* clipboard blocked (insecure origin, denied permission) — ignore */
        }
    });
}

function boot() {
    stickyHeaderShadow();
    productRails();
    accordions();
    cartBadge();
    drawers();
    copyButtons();
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', boot, { once: true });
} else {
    boot();
}
