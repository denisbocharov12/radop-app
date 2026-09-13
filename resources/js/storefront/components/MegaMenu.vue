<script setup>
/**
 * Catalogue button + mega menu.
 *
 * Replaces the previous implementation (6 Blade partials, an AJAX HTML fetch
 * per category hover, and ~16 KB of hand-written mega-menu CSS) with a single
 * component fed by /api/v1/mega-menu/{code}/data.
 *
 * Behaviour notes:
 *  - The panel is anchored under the header, never over it, so the search box
 *    and cart stay reachable while it is open (the old one covered the header).
 *  - Root switching is hover-with-intent: a 90 ms delay stops the right pane
 *    flickering when the pointer travels diagonally towards a child link.
 *  - Fully keyboard operable: Enter/Space opens, arrows move between roots,
 *    Tab walks the links in the open pane, Escape closes and restores focus.
 */
import { computed, nextTick, onBeforeUnmount, onMounted, ref, watch } from 'vue';
import SfIcon from './SfIcon.vue';

const props = defineProps({
    code: { type: String, default: 'main_menu' },
    label: { type: String, default: 'Catalog' },
    /** Absolute origin stored in menu links by the CMS, rewritten to this one. */
    origin: { type: String, default: '' },
});

const open = ref(false);
const loading = ref(false);
const loaded = ref(false);
const failed = ref(false);
const roots = ref([]);
const widgets = ref([]);
const activeIndex = ref(0);

const rootEl = ref(null);
const triggerEl = ref(null);
const panelEl = ref(null);

let hoverTimer = null;

const activeRoot = computed(() => roots.value[activeIndex.value] ?? null);

/**
 * Menu links are stored absolute and often carry a stale origin (an old
 * APP_URL). Re-point them at the origin actually being browsed so the menu
 * never bounces the visitor to another host.
 */
function href(link) {
    if (!link) return '#';
    try {
        const url = new URL(link, window.location.origin);
        return url.pathname + url.search + url.hash;
    } catch {
        return link;
    }
}

/**
 * The CMS tree mixes real categories with heading-only nodes. A node with
 * children is rendered as a column heading; a leaf becomes a plain link.
 */
function columnsFor(root) {
    if (!root?.children?.length) return [];
    return root.children.map((child) => ({
        ...child,
        leaves: child.children ?? [],
    }));
}

async function load() {
    if (loaded.value || loading.value) return;
    loading.value = true;
    failed.value = false;
    try {
        const res = await fetch(`/api/v1/mega-menu/${props.code}/data`, {
            headers: { Accept: 'application/json' },
            credentials: 'same-origin',
        });
        if (!res.ok) throw new Error(`HTTP ${res.status}`);
        const body = await res.json();
        roots.value = body?.data?.categories ?? [];
        widgets.value = body?.data?.widgets ?? [];
        loaded.value = true;
    } catch {
        failed.value = true;
    } finally {
        loading.value = false;
    }
}

function toggle() {
    open.value ? close() : show();
}

function show() {
    open.value = true;
    syncPanelTop();
    load();
}

/**
 * The panel is viewport-anchored, so it needs to know where the header ends.
 * Reading it from the trigger keeps the two in sync no matter how the header
 * reflows (mobile search row, promo bar, sticky shrink).
 */
function syncPanelTop() {
    // The catalogue opens as a full-window layer directly under the sticky
    // header (covering the category strip), down to the bottom of the viewport.
    const header = document.querySelector('[data-sf-header]');
    const bottom = header?.getBoundingClientRect().bottom ?? triggerEl.value?.getBoundingClientRect().bottom ?? 0;
    document.documentElement.style.setProperty('--sf-mega-top', `${Math.round(Math.max(bottom, 0))}px`);
}

function close({ restoreFocus = false } = {}) {
    open.value = false;
    clearTimeout(hoverTimer);
    if (restoreFocus) triggerEl.value?.focus();
}

function hoverRoot(index) {
    clearTimeout(hoverTimer);
    hoverTimer = setTimeout(() => {
        activeIndex.value = index;
    }, 90);
}

function moveRoot(delta) {
    if (!roots.value.length) return;
    const next = (activeIndex.value + delta + roots.value.length) % roots.value.length;
    activeIndex.value = next;
}

function onKeydown(event) {
    if (!open.value) return;
    if (event.key === 'Escape') {
        event.preventDefault();
        close({ restoreFocus: true });
        return;
    }
    if (event.key === 'ArrowDown' || event.key === 'ArrowUp') {
        // Only hijack the arrows while focus is still on the root column.
        const onRoots = panelEl.value?.querySelector('[data-roots]')?.contains(document.activeElement);
        if (onRoots || document.activeElement === triggerEl.value) {
            event.preventDefault();
            moveRoot(event.key === 'ArrowDown' ? 1 : -1);
        }
    }
}

function onPointerDown(event) {
    if (!open.value) return;
    // The panel lives outside rootEl (teleported), so check both.
    if (!rootEl.value?.contains(event.target) && !panelEl.value?.contains(event.target)) close();
}

// Lock the page behind the panel without the layout shifting as the scrollbar
// disappears.
watch(open, async (isOpen) => {
    const { style } = document.body;
    if (isOpen) {
        const gap = window.innerWidth - document.documentElement.clientWidth;
        style.overflow = 'hidden';
        if (gap > 0) style.paddingRight = `${gap}px`;
        await nextTick();
    } else {
        style.overflow = '';
        style.paddingRight = '';
    }
});

onMounted(() => {
    document.addEventListener('keydown', onKeydown);
    document.addEventListener('pointerdown', onPointerDown, true);
    window.addEventListener('resize', syncPanelTop, { passive: true });
});

onBeforeUnmount(() => {
    document.removeEventListener('keydown', onKeydown);
    document.removeEventListener('pointerdown', onPointerDown, true);
    window.removeEventListener('resize', syncPanelTop);
    document.body.style.overflow = '';
    document.body.style.paddingRight = '';
    clearTimeout(hoverTimer);
});
</script>

<template>
    <div ref="rootEl" class="relative">
        <button
            ref="triggerEl"
            type="button"
            class="sf-btn-primary h-11 w-full justify-start gap-2.5 px-5 lg:w-auto"
            :aria-expanded="open"
            aria-haspopup="true"
            @click="toggle"
            @mouseenter="load"
        >
            <SfIcon :name="open ? 'close' : 'menu'" :size="18" stroke-width="2" />
            <span class="uppercase tracking-wide">{{ label }}</span>
        </button>

        <!-- Panel. Teleported to <body>: the sticky header uses backdrop-filter,
             which makes it the containing block for position:fixed children, so
             inside the header `bottom: 0` meant the header's bottom and the
             full-window panel collapsed to ~1px. -->
        <Teleport to="body">
        <Transition
            enter-active-class="transition duration-200 ease-sf"
            enter-from-class="opacity-0 -translate-y-1"
            leave-active-class="transition duration-150 ease-sf"
            leave-to-class="opacity-0 -translate-y-1"
        >
            <div v-if="open" ref="panelEl" class="sf-mega-panel">
                <div class="sf-container h-full">
                    <div v-if="loading" class="grid gap-4 py-6 lg:grid-cols-[minmax(0,17rem)_1fr]">
                        <div class="space-y-2">
                            <div v-for="n in 8" :key="n" class="sf-skeleton h-9 w-full"></div>
                        </div>
                        <div class="hidden gap-6 lg:grid lg:grid-cols-3">
                            <div v-for="n in 3" :key="n" class="space-y-2">
                                <div class="sf-skeleton h-5 w-2/3"></div>
                                <div v-for="m in 5" :key="m" class="sf-skeleton h-4 w-full"></div>
                            </div>
                        </div>
                    </div>

                    <p v-else-if="failed" class="py-8 text-center text-sm text-ink-500">
                        <SfIcon name="info" class="mx-auto mb-2" />
                        {{ $sf.t.menuError }}
                    </p>

                    <div v-else class="grid h-full lg:grid-cols-[minmax(0,18rem)_1fr]">
                        <!-- Root column -->
                        <nav
                            data-roots
                            class="sf-mega-col border-ink-100 py-3 lg:border-r lg:pr-3"
                            :aria-label="label"
                        >
                            <a
                                v-for="(root, i) in roots"
                                :key="root.id"
                                :href="href(root.link)"
                                class="sf-mega-root"
                                :class="i === activeIndex ? 'sf-mega-root-active' : 'hover:bg-ink-50'"
                                @mouseenter="hoverRoot(i)"
                                @focus="activeIndex = i"
                            >
                                <img
                                    v-if="root.image"
                                    :src="root.image"
                                    alt=""
                                    loading="lazy"
                                    class="h-6 w-6 shrink-0 object-contain opacity-80"
                                />
                                <span class="min-w-0 flex-1 truncate">{{ root.title }}</span>
                                <span
                                    v-if="root.label_name"
                                    class="sf-badge text-white"
                                    :style="{ background: root.label_color || undefined }"
                                >{{ root.label_name }}</span>
                                <SfIcon name="chevronRight" :size="16" class="text-ink-300" />
                            </a>
                        </nav>

                        <!-- Children pane -->
                        <div v-if="activeRoot" class="sf-mega-col py-4 lg:pl-8">
                            <div class="mb-4 flex items-center justify-between gap-4">
                                <a :href="href(activeRoot.link)" class="text-lg font-bold text-ink-900 hover:text-brand-600">
                                    {{ activeRoot.title }}
                                </a>
                                <a :href="href(activeRoot.link)" class="sf-section-link inline-flex items-center gap-1">
                                    {{ $sf.t.viewAll }}
                                    <SfIcon name="arrowRight" :size="14" />
                                </a>
                            </div>

                            <div class="columns-1 gap-8 sm:columns-2 xl:columns-3">
                                <div
                                    v-for="col in columnsFor(activeRoot)"
                                    :key="col.id"
                                    class="mb-5 break-inside-avoid"
                                >
                                    <a :href="href(col.link)" class="sf-mega-group-title">{{ col.title }}</a>
                                    <ul v-if="col.leaves.length" class="space-y-0.5">
                                        <li v-for="leaf in col.leaves" :key="leaf.id">
                                            <a :href="href(leaf.link)" class="sf-mega-leaf">
                                                {{ leaf.title }}
                                                <span v-if="leaf.products_count" class="ml-1 text-2xs text-ink-400">
                                                    {{ leaf.products_count }}
                                                </span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Promoted links -->
                            <div v-if="widgets.length" class="mt-2 flex flex-wrap gap-2 border-t border-ink-100 pt-4">
                                <a
                                    v-for="w in widgets"
                                    :key="w.id"
                                    :href="href(w.link)"
                                    class="inline-flex items-center gap-2 rounded-md border border-ink-200 px-3 py-2 text-sm font-medium text-ink-700 transition-colors hover:border-brand-300 hover:bg-brand-50 hover:text-brand-700"
                                >
                                    <img v-if="w.image" :src="w.image" alt="" loading="lazy" class="h-5 w-5 object-contain" />
                                    {{ w.title }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </Transition>
        </Teleport>
    </div>
</template>
