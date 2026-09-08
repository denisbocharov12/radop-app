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

function boot() {
    stickyHeaderShadow();
    productRails();
    accordions();
    cartBadge();
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', boot, { once: true });
} else {
    boot();
}
