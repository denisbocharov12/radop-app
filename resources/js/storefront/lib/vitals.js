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

function boot() {
    stickyHeaderShadow();
    productRails();
    accordions();
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', boot, { once: true });
} else {
    boot();
}
