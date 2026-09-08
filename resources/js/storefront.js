/**
 * Radop storefront — Vue 3 island runtime.
 *
 * The storefront stays server-rendered (200+ Blade templates, SEO-critical
 * category and product pages), so instead of a SPA each interactive widget is
 * mounted as its own small Vue app on a `data-sf-island` element:
 *
 *   <div data-sf-island="mega-menu" data-sf-props='{"code":"main_menu"}'></div>
 *
 * Islands are code-split: a page that has no product gallery never downloads
 * the gallery chunk.
 */
import { createApp, defineAsyncComponent } from 'vue';
import './storefront/lib/vitals.js';

/** Strings printed once by the layout, so components never hardcode copy. */
const bootstrap = window.__SF__ ?? {};
const translations = bootstrap.t ?? {};

const registry = {
    'mega-menu': () => import('./storefront/components/MegaMenu.vue'),
    'site-search': () => import('./storefront/components/SiteSearch.vue'),
    'mobile-nav': () => import('./storefront/components/MobileNav.vue'),
    'hero-slider': () => import('./storefront/components/HeroSlider.vue'),
    'add-to-cart': () => import('./storefront/components/AddToCart.vue'),
    'wishlist-button': () => import('./storefront/components/WishlistButton.vue'),
};

function readProps(el) {
    const raw = el.dataset.sfProps;
    if (!raw) return {};
    try {
        return JSON.parse(raw);
    } catch (error) {
        console.warn('[sf] invalid island props on', el, error);
        return {};
    }
}

function mountIsland(el) {
    const name = el.dataset.sfIsland;
    const loader = registry[name];

    if (!loader) {
        console.warn(`[sf] unknown island "${name}"`);
        return;
    }

    const app = createApp(defineAsyncComponent(loader), readProps(el));

    app.config.globalProperties.$sf = { t: translations, ...bootstrap };
    app.config.errorHandler = (error) => console.error(`[sf:${name}]`, error);
    app.mount(el);

    el.removeAttribute('v-cloak');
}

function mountAll(root = document) {
    root.querySelectorAll('[data-sf-island]:not([data-sf-mounted])').forEach((el) => {
        el.setAttribute('data-sf-mounted', '');
        mountIsland(el);
    });
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => mountAll(), { once: true });
} else {
    mountAll();
}

// Islands injected later (modals, AJAX-loaded fragments) opt in by dispatching
// `sf:mount` on the container they added.
document.addEventListener('sf:mount', (event) => mountAll(event.target ?? document));

export { mountAll };
