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

        // Optional autoplay (`data-sf-rail-autoplay="ms"`): one item at a time,
        // back to the start at the end. Pauses while the visitor is pointing
        // at, focused in or touching the rail, and never runs for visitors
        // who prefer reduced motion.
        const delay = Number(wrapper.dataset.sfRailAutoplay || 0);
        if (!delay || window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

        let paused = false;
        const pause = () => { paused = true; };
        const resume = () => { paused = false; };
        wrapper.addEventListener('mouseenter', pause);
        wrapper.addEventListener('mouseleave', resume);
        wrapper.addEventListener('focusin', pause);
        wrapper.addEventListener('focusout', resume);
        rail.addEventListener('touchstart', pause, { passive: true });
        rail.addEventListener('touchend', () => setTimeout(resume, 4000), { passive: true });

        setInterval(() => {
            if (paused || document.hidden) return;
            const item = rail.firstElementChild;
            const gap = Number.parseFloat(getComputedStyle(rail).columnGap) || 0;
            const itemStep = item ? item.getBoundingClientRect().width + gap : step();
            const atEnd = rail.scrollLeft >= rail.scrollWidth - rail.clientWidth - 2;
            rail.scrollTo({ left: atEnd ? 0 : rail.scrollLeft + itemStep, behavior: 'smooth' });
        }, delay);
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

function toast(type, message) {
    if (!message) return;
    if (window.toastr?.[type]) window.toastr[type](message);
}

/**
 * "Download catalogue" links (`<x-sf-export-button>`). The endpoint builds the
 * workbook and answers JSON: either the file URL, or — for personalised
 * price lists, which are generated in the background — a notice.
 */
function exportLinks() {
    document.addEventListener('click', async (event) => {
        const link = event.target.closest('[data-sf-export]');
        if (!link) return;
        event.preventDefault();
        if (link.dataset.busy) return;

        const t = window.__SF__?.t ?? {};
        link.dataset.busy = '1';
        link.setAttribute('aria-busy', 'true');
        link.classList.add('pointer-events-none', 'opacity-60');

        try {
            const res = await fetch(link.href, {
                credentials: 'same-origin',
                headers: { Accept: 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
            });
            const data = await res.json().catch(() => ({}));

            if (data.success && data.url) {
                window.location.href = data.url;
                toast('success', data.message || t.exportStarted);
            } else if (data.success) {
                toast('info', data.message || t.exportPersonalized);
            } else {
                toast('error', data.message || t.exportError);
            }
        } catch {
            toast('error', t.exportError);
        } finally {
            delete link.dataset.busy;
            link.removeAttribute('aria-busy');
            link.classList.remove('pointer-events-none', 'opacity-60');
        }
    });
}

/** Grid / list switch on catalogue pages; remembered per visitor. */
function catalogView() {
    const grid = document.querySelector('.sf-grid-products[data-sf-view]');
    const buttons = document.querySelectorAll('[data-sf-view-set]');
    if (!grid || !buttons.length) return;

    const apply = (view) => {
        grid.dataset.sfView = view;
        buttons.forEach((button) => button.setAttribute('aria-pressed', String(button.dataset.sfViewSet === view)));
        try { localStorage.setItem('sf.catalog.view', view); } catch { /* storage blocked */ }
    };

    let saved = 'grid';
    try { saved = localStorage.getItem('sf.catalog.view') || 'grid'; } catch { /* storage blocked */ }
    // Lists are a desktop/tablet affordance; phones always get the grid.
    apply(window.matchMedia('(min-width: 640px)').matches ? saved : 'grid');

    buttons.forEach((button) => button.addEventListener('click', () => apply(button.dataset.sfViewSet)));
}

/** "Reset" in the mobile filter drawer drops every filter but keeps search. */
function filterReset() {
    document.addEventListener('click', (event) => {
        if (!event.target.closest('[data-sf-filter-reset]')) return;
        const form = document.getElementById('filterForm');
        const url = new URL(form?.action || window.location.href, window.location.origin);
        const search = new URL(window.location.href).searchParams.get('filter[search]');
        url.search = '';
        if (search) url.searchParams.set('filter[search]', search);
        window.location.href = url.toString();
    });
}

/**
 * `[data-sf-sticky-when-hidden="#target"]` shows itself (data-visible=true)
 * only while #target is out of the viewport — the product page's mobile buy
 * bar appears once the real buy box has scrolled away.
 */
function stickyWhenHidden() {
    document.querySelectorAll('[data-sf-sticky-when-hidden]').forEach((bar) => {
        const target = document.querySelector(bar.dataset.sfStickyWhenHidden);
        if (!target || !('IntersectionObserver' in window)) return;

        new IntersectionObserver(([entry]) => {
            const visible = !entry.isIntersecting && entry.boundingClientRect.top < 0;
            bar.dataset.visible = String(visible);
            bar.setAttribute('aria-hidden', String(!visible));
        }).observe(target);

        bar.querySelector('a[href^="#"]')?.addEventListener('click', (event) => {
            event.preventDefault();
            target.scrollIntoView({ behavior: 'smooth', block: 'center' });
            target.querySelector('button:not([disabled])')?.focus({ preventScroll: true });
        });
    });
}

/**
 * Form helpers shared by registration and the account page:
 *  - `[data-sf-reveal="inputId"]` toggles a password field's visibility;
 *  - `[data-sf-password-rule="inputId"]` turns green once the length rule
 *    (8–20 characters, the server's validation) is met.
 */
function formHelpers() {
    document.addEventListener('click', (event) => {
        const toggle = event.target.closest('[data-sf-reveal]');
        if (!toggle) return;
        const input = document.getElementById(toggle.dataset.sfReveal);
        if (!input) return;
        input.type = input.type === 'password' ? 'text' : 'password';
        toggle.classList.toggle('text-brand-600', input.type === 'text');
        toggle.setAttribute('aria-pressed', String(input.type === 'text'));
    });

    document.querySelectorAll('[data-sf-password-rule]').forEach((rule) => {
        const input = document.getElementById(rule.dataset.sfPasswordRule);
        if (!input) return;
        const check = () => {
            const ok = input.value.length >= 8 && input.value.length <= 20;
            rule.classList.toggle('text-success-600', ok);
            rule.classList.toggle('text-ink-500', !ok);
        };
        input.addEventListener('input', check);
        check();
    });
}

/**
 * Category strip dropdowns open under their own item; when that would push
 * the panel past the strip container's right edge, slide it left just enough.
 * Runs on hover/focus, when the panel is displayed and measurable.
 */
function navPanels() {
    const nav = document.querySelector('.sf-nav');
    if (!nav) return;
    const container = nav.querySelector('.sf-container');

    const place = (item) => {
        const panel = item.querySelector('.sf-nav-panel');
        if (!panel || !container) return;
        panel.style.left = '0px';
        requestAnimationFrame(() => {
            const bounds = container.getBoundingClientRect();
            const gutter = Number.parseFloat(getComputedStyle(container).paddingRight) || 0;
            const limit = bounds.right - gutter;
            const rect = panel.getBoundingClientRect();
            const overflow = rect.right - limit;
            if (overflow > 0) panel.style.left = `${-Math.ceil(overflow)}px`;
        });
    };

    nav.querySelectorAll('[data-sf-nav-item]').forEach((item) => {
        item.addEventListener('mouseenter', () => place(item));
        item.addEventListener('focusin', () => place(item));
    });
}

/**
 * Table of contents for long-form pages (<x-sf-page>): built from the `h2`
 * headings when there are at least four, shown on desktop, with the section
 * currently in view highlighted.
 */
function tableOfContents() {
    document.querySelectorAll('[data-sf-toc-scope]').forEach((scope) => {
        const aside = scope.querySelector('[data-sf-toc]');
        const list = scope.querySelector('[data-sf-toc-list]');
        const headings = [...scope.querySelectorAll('.sf-prose h2')];
        if (!aside || !list || headings.length < 4) {
            // No contents column: drop the grid and restore the prose measure.
            scope.classList.remove('lg:grid');
            scope.querySelector('.sf-prose')?.classList.remove('lg:max-w-none');
            return;
        }

        const links = headings.map((heading, index) => {
            if (!heading.id) heading.id = `section-${index + 1}`;
            const link = document.createElement('a');
            link.href = `#${heading.id}`;
            link.textContent = heading.textContent.trim();
            list.append(link);
            return link;
        });

        aside.classList.remove('hidden');
        aside.classList.add('hidden', 'lg:block');

        if (!('IntersectionObserver' in window)) return;
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) return;
                links.forEach((link) => link.setAttribute('aria-current', String(link.hash === `#${entry.target.id}`)));
            });
        }, { rootMargin: '-20% 0px -70% 0px' });
        headings.forEach((heading) => observer.observe(heading));
    });
}

/**
 * Фильтры, сортировка и размер страницы без перезагрузки (ТЗ 48).
 *
 * Запрашиваем ту же страницу и подменяем три куска: сетку товаров,
 * чипсы выбранных фильтров и пагинацию, плюс счётчик найденного в панели.
 * Боковую колонку не трогаем — её обработчики (раскрытие брендов, поиск по
 * ним) остаются живыми, а состояние раскрытых блоков не сбрасывается.
 */
function catalogLiveFilter() {
    const grid = document.querySelector('.sf-grid-products');
    const form = document.querySelector('[data-sf-filter-form]');
    const toolbar = document.querySelector('[data-sf-toolbar]');

    if (!grid || (!form && !toolbar)) return;

    // Инлайновые скрипты страницы видят флаг и не делают обычный submit.
    document.documentElement.dataset.sfLiveFilter = '1';

    const desktop = window.matchMedia('(min-width: 1024px)');
    let controller = null;
    let priceTimer = null;

    const buildUrl = () => {
        const params = new URLSearchParams();

        if (form) {
            new FormData(form).forEach((value, key) => {
                if (String(value).trim() !== '') params.append(key, value);
            });
        } else if (toolbar) {
            // На поиске колонки фильтров нет — параметры лежат в скрытых полях панели.
            toolbar.querySelectorAll('input[type=hidden]').forEach((input) => {
                if (String(input.value).trim() !== '') params.append(input.name, input.value);
            });
        }

        if (toolbar) {
            toolbar.querySelectorAll('select').forEach((select) => {
                params.delete(select.name);
                if (String(select.value).trim() !== '') params.set(select.name, select.value);
            });
        }

        const action = form?.getAttribute('action') || toolbar?.getAttribute('action') || window.location.pathname;
        const query = params.toString();

        return query ? `${action}?${query}` : action;
    };

    const swapChips = (doc) => {
        const next = doc.querySelector('[data-sf-filter-chips]');
        const current = document.querySelector('[data-sf-filter-chips]');

        if (next && current) current.replaceWith(next);
        else if (next) grid.parentElement.insertBefore(next, grid);
        else if (current) current.remove();
    };

    const swapPagination = (doc) => {
        const next = doc.querySelector('nav[role="navigation"]');
        const current = document.querySelector('nav[role="navigation"]');

        if (next && current) current.replaceWith(next);
        else if (next) grid.parentElement.insertBefore(next, grid.nextSibling);
        else if (current) current.remove();
    };

    const swapCount = (doc) => {
        const next = doc.querySelector('[data-sf-toolbar] b');
        const current = document.querySelector('[data-sf-toolbar] b');

        if (next && current) current.textContent = next.textContent;
    };

    const apply = async (url, push = true) => {
        controller?.abort();
        controller = new AbortController();
        grid.setAttribute('aria-busy', 'true');
        grid.classList.add('opacity-50', 'transition-opacity');

        try {
            const response = await fetch(url, {
                headers: { 'X-Requested-With': 'fetch' },
                credentials: 'same-origin',
                signal: controller.signal,
            });
            const doc = new DOMParser().parseFromString(await response.text(), 'text/html');
            const nextGrid = doc.querySelector('.sf-grid-products');

            grid.innerHTML = nextGrid ? nextGrid.innerHTML : '';
            swapChips(doc);
            swapPagination(doc);
            swapCount(doc);

            if (push) window.history.pushState({ sfFilter: true }, '', url);

            grid.dispatchEvent(new CustomEvent('sf:mount', { bubbles: true }));
            window.scrollTo({ top: Math.max(0, grid.getBoundingClientRect().top + window.scrollY - 140), behavior: 'smooth' });
        } catch (error) {
            if (error.name !== 'AbortError') window.location.href = url;
        } finally {
            grid.classList.remove('opacity-50');
            grid.removeAttribute('aria-busy');
        }
    };

    if (form) {
        form.addEventListener('change', (event) => {
            // На телефоне фильтры применяются кнопкой в выезжающей панели.
            if (!desktop.matches || event.target.type !== 'checkbox') return;
            apply(buildUrl());
        });

        form.addEventListener('input', (event) => {
            if (!desktop.matches || event.target.type !== 'number') return;
            clearTimeout(priceTimer);
            priceTimer = setTimeout(() => apply(buildUrl()), 700);
        });
    }

    if (toolbar) {
        toolbar.addEventListener('change', (event) => {
            if (event.target.tagName !== 'SELECT') return;
            apply(buildUrl());
        });
    }

    // Пагинация и чипсы — обычные ссылки, перехватываем их тут же.
    document.addEventListener('click', (event) => {
        const link = event.target.closest('nav[role="navigation"] a, [data-sf-filter-chips] a');
        if (!link || event.metaKey || event.ctrlKey || event.shiftKey) return;
        event.preventDefault();
        apply(link.href);
    });

    window.addEventListener('popstate', () => apply(window.location.href, false));
}
function boot() {
    tableOfContents();
    navPanels();
    formHelpers();
    stickyWhenHidden();
    stickyHeaderShadow();
    productRails();
    accordions();
    drawers();
    copyButtons();
    exportLinks();
    catalogView();
    catalogLiveFilter();
    filterReset();
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', boot, { once: true });
} else {
    boot();
}
