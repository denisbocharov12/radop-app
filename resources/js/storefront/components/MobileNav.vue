<script setup>
/**
 * Mobile navigation (below `lg`) — two surfaces sharing one tree fetch:
 *
 * - `menu`: the header burger. A side drawer with the account entry, the
 *   catalogue button and the site's static pages (shop lists, company,
 *   information), phones and languages — what the old site kept under its
 *   "Other" tab.
 * - `catalog`: the tab bar's "Catalogue". Full screen above the tab bar, as on
 *   the old site: the CMS menu's quick-link widgets as coloured chips, then the
 *   categories with their icons and labels ("NEW"). Drill-down rather than an
 *   accordion — on a 360 px screen a three-level accordion is endless
 *   scrolling — with a back button walking the stack up.
 *
 * Data comes from /api/v1/mega-menu, the same payload the desktop mega menu
 * renders.
 */
import { computed, onBeforeUnmount, onMounted, ref, watch } from 'vue';
import SfIcon from './SfIcon.vue';

const props = defineProps({
    code: { type: String, default: 'main_menu' },
    label: { type: String, default: 'Catalog' },
    /** [{ title, links: [{ label, url }] }] */
    groups: { type: Array, default: () => [] },
    /** { authenticated, url, label, signInLabel } */
    account: { type: Object, default: () => ({}) },
    locales: { type: Array, default: () => [] },
    phones: { type: Array, default: () => [] },
    email: { type: String, default: '' },
    t: { type: Object, default: () => ({}) },
});

const open = ref(false);
/** 'menu' | 'catalog' */
const view = ref('menu');
const loading = ref(false);
const loaded = ref(false);
const widgets = ref([]);
const roots = ref([]);
/** Nodes the visitor has drilled into. */
const stack = ref([]);

const current = computed(() => stack.value[stack.value.length - 1] ?? null);
const list = computed(() => (current.value ? current.value.children ?? [] : roots.value));

/** Menu links are entered in the admin as absolute URLs of whichever host
 *  the editor used; keep only path + query so they work on every host. */
function href(link) {
    if (!link) return '#';
    try {
        const url = new URL(link, window.location.origin);
        return url.pathname + url.search + url.hash;
    } catch {
        return link;
    }
}

async function load() {
    if (loaded.value || loading.value) return;
    loading.value = true;
    try {
        const res = await fetch(`/api/v1/mega-menu/${props.code}/data`, {
            headers: { Accept: 'application/json' },
            credentials: 'same-origin',
        });
        const body = await res.json();
        widgets.value = body?.data?.widgets ?? [];
        roots.value = body?.data?.categories ?? [];
        loaded.value = true;
    } catch {
        roots.value = [];
    } finally {
        loading.value = false;
    }
}

function show(target = 'menu') {
    view.value = target;
    stack.value = [];
    open.value = true;
    if (target === 'catalog') load();
}

function showCatalog() {
    show('catalog');
}

function close() {
    open.value = false;
    stack.value = [];
}

function enter(node) {
    if (node.children?.length) {
        stack.value.push(node);
        document.querySelector('[data-sf-catalog-scroll]')?.scrollTo({ top: 0 });
    } else {
        window.location.href = href(node.link);
    }
}

function back() {
    if (stack.value.length) stack.value.pop();
    else view.value = 'menu';
}

watch([open, view], ([isOpen, which]) => {
    document.body.style.overflow = isOpen ? 'hidden' : '';
    // The tab bar highlights "Catalogue" while the full-screen catalogue is up.
    document.dispatchEvent(new CustomEvent('sf:mobile-nav-state', {
        detail: { open: isOpen && which === 'catalog' },
    }));
});

function onKeydown(event) {
    if (event.key === 'Escape' && open.value) close();
}

onMounted(() => {
    document.addEventListener('keydown', onKeydown);
    document.addEventListener('sf:open-mobile-nav', showCatalog);
});

onBeforeUnmount(() => {
    document.removeEventListener('keydown', onKeydown);
    document.removeEventListener('sf:open-mobile-nav', showCatalog);
    document.body.style.overflow = '';
});
</script>

<template>
    <div class="lg:hidden">
        <button type="button" class="sf-icon-btn" :aria-label="t.menu || label" @click="show('menu')">
            <SfIcon name="menu" :size="22" />
        </button>

        <Teleport to="body">
            <!-- ============================================ side menu -->
            <Transition
                enter-active-class="transition-opacity duration-200"
                enter-from-class="opacity-0"
                leave-active-class="transition-opacity duration-150"
                leave-to-class="opacity-0"
            >
                <div v-if="open && view === 'menu'" class="sf-overlay lg:hidden" @click="close"></div>
            </Transition>

            <Transition
                enter-active-class="transition-transform duration-250 ease-sf"
                enter-from-class="-translate-x-full"
                leave-active-class="transition-transform duration-200 ease-sf"
                leave-to-class="-translate-x-full"
            >
                <aside
                    v-if="open && view === 'menu'"
                    class="fixed inset-y-0 left-0 z-modal flex w-[min(22rem,88vw)] flex-col bg-white shadow-pop lg:hidden"
                    role="dialog"
                    aria-modal="true"
                    :aria-label="t.menu"
                >
                    <header class="flex items-center gap-2 border-b border-ink-100 py-2 pl-4 pr-2">
                        <span class="min-w-0 flex-1 truncate text-md font-bold text-ink-900">{{ t.menu }}</span>
                        <button type="button" class="sf-icon-btn" :aria-label="t.close" @click="close">
                            <SfIcon name="close" />
                        </button>
                    </header>

                    <div class="flex-1 overflow-y-auto overscroll-contain">
                        <div class="space-y-2 p-4">
                            <a
                                v-if="account.authenticated"
                                :href="account.url"
                                class="flex items-center gap-3 rounded-lg bg-ink-50 px-3 py-2.5 text-sm font-semibold text-ink-900"
                            >
                                <span class="flex h-9 w-9 items-center justify-center rounded-full bg-brand-600 text-white">
                                    <SfIcon name="user" :size="18" />
                                </span>
                                <span class="min-w-0 flex-1 truncate">{{ account.label }}</span>
                                <SfIcon name="chevronRight" :size="16" class="text-ink-400" />
                            </a>
                            <button
                                v-else
                                type="button"
                                data-sf-auth-open
                                class="flex w-full items-center gap-3 rounded-lg bg-ink-50 px-3 py-2.5 text-left text-sm font-semibold text-ink-900"
                                @click="close"
                            >
                                <span class="flex h-9 w-9 items-center justify-center rounded-full bg-white text-brand-600 ring-1 ring-ink-200">
                                    <SfIcon name="user" :size="18" />
                                </span>
                                <span class="min-w-0 flex-1">{{ account.signInLabel }}</span>
                                <SfIcon name="chevronRight" :size="16" class="text-ink-400" />
                            </button>

                            <button type="button" class="sf-btn-primary sf-btn-block h-11" @click="showCatalog">
                                <SfIcon name="grid" :size="18" />
                                {{ label }}
                            </button>
                        </div>

                        <nav v-for="group in groups" :key="group.title" class="border-t border-ink-100 px-2 py-3">
                            <p class="px-2 pb-1 text-2xs font-bold uppercase tracking-wider text-ink-400">{{ group.title }}</p>
                            <a
                                v-for="link in group.links"
                                :key="link.url"
                                :href="link.url"
                                class="flex items-center justify-between gap-2 rounded-md px-2 py-2.5 text-sm font-medium text-ink-800 active:bg-ink-50"
                            >
                                <span class="min-w-0 truncate">{{ link.label }}</span>
                                <SfIcon name="chevronRight" :size="15" class="shrink-0 text-ink-300" />
                            </a>
                        </nav>
                    </div>

                    <footer class="space-y-2.5 border-t border-ink-100 bg-ink-50/60 p-4">
                        <a
                            v-for="phone in phones"
                            :key="phone"
                            :href="`tel:+373${phone.replace(/\D/g, '').replace(/^0/, '')}`"
                            class="flex items-center gap-2 text-sm font-semibold text-ink-800"
                        >
                            <SfIcon name="phone" :size="16" class="text-brand-600" />{{ phone }}
                        </a>
                        <a v-if="email" :href="`mailto:${email}`" class="flex items-center gap-2 text-sm text-ink-600">
                            <SfIcon name="mail" :size="16" class="text-brand-600" />{{ email }}
                        </a>
                        <div v-if="locales.length" class="flex gap-1.5 pt-1">
                            <a
                                v-for="loc in locales"
                                :key="loc.code"
                                :href="loc.url"
                                class="rounded-md px-3 py-1.5 text-xs font-bold uppercase"
                                :class="loc.active ? 'bg-brand-600 text-white' : 'bg-white text-ink-600 ring-1 ring-ink-200'"
                            >{{ loc.code }}</a>
                        </div>
                    </footer>
                </aside>
            </Transition>

            <!-- ============================================ full-screen catalogue -->
            <Transition
                enter-active-class="transition duration-200 ease-sf"
                enter-from-class="translate-y-3 opacity-0"
                leave-active-class="transition duration-150"
                leave-to-class="opacity-0"
            >
                <section
                    v-if="open && view === 'catalog'"
                    class="fixed inset-x-0 top-0 bottom-[calc(3.5rem+env(safe-area-inset-bottom))] z-modal flex flex-col bg-white lg:hidden"
                    role="dialog"
                    aria-modal="true"
                    :aria-label="label"
                >
                    <header class="flex items-center gap-1 border-b border-ink-100 py-2 pl-2 pr-2">
                        <button type="button" class="sf-icon-btn" :aria-label="t.back" @click="current ? back() : close()">
                            <SfIcon name="chevronLeft" />
                        </button>
                        <span class="min-w-0 flex-1 truncate text-md font-bold text-ink-900">
                            {{ current ? current.title : label }}
                        </span>
                        <button type="button" class="sf-icon-btn" :aria-label="t.close" @click="close">
                            <SfIcon name="close" />
                        </button>
                    </header>

                    <div class="flex-1 overflow-y-auto overscroll-contain" data-sf-catalog-scroll>
                        <div v-if="loading" class="space-y-3 p-4">
                            <div class="grid grid-cols-2 gap-2">
                                <div v-for="n in 4" :key="`w${n}`" class="sf-skeleton h-11"></div>
                            </div>
                            <div v-for="n in 8" :key="n" class="sf-skeleton h-12 w-full"></div>
                        </div>

                        <template v-else>
                            <!-- Quick links from the CMS menu, as the old site's chips. -->
                            <div v-if="!current && widgets.length" class="grid grid-cols-2 gap-2 p-4 pb-2">
                                <a
                                    v-for="widget in widgets"
                                    :key="widget.id"
                                    :href="href(widget.link)"
                                    :target="widget.target || '_self'"
                                    class="flex min-h-[2.75rem] items-center gap-2 rounded-lg border-2 bg-white px-2.5 py-1.5 text-sm font-semibold leading-tight text-ink-900 active:bg-ink-50"
                                    :class="widget.label_color ? '' : 'border-brand-600'"
                                    :style="widget.label_color ? { borderColor: widget.label_color } : null"
                                >
                                    <img
                                        v-if="widget.image"
                                        :src="widget.image"
                                        alt=""
                                        loading="lazy"
                                        class="h-7 w-7 shrink-0 rounded-full bg-ink-50 object-contain p-0.5"
                                    />
                                    <span class="line-clamp-2 min-w-0">{{ widget.title }}</span>
                                </a>
                            </div>

                            <a
                                v-if="current"
                                :href="href(current.link)"
                                class="mx-4 mt-3 flex items-center justify-between rounded-lg bg-brand-50 px-3 py-2.5 text-sm font-semibold text-brand-700"
                            >
                                {{ t.viewAll }}
                                <SfIcon name="arrowRight" :size="16" />
                            </a>

                            <ul class="px-4 py-2">
                                <li v-for="node in list" :key="node.id" class="border-b border-ink-100 last:border-b-0">
                                    <button
                                        type="button"
                                        class="flex w-full items-center gap-3 py-3 text-left active:bg-ink-50"
                                        @click="enter(node)"
                                    >
                                        <span v-if="!current" class="flex h-9 w-9 shrink-0 items-center justify-center">
                                            <img
                                                v-if="node.image"
                                                :src="node.image"
                                                alt=""
                                                loading="lazy"
                                                class="h-8 w-8 object-contain"
                                            />
                                            <SfIcon v-else name="box" :size="22" class="text-ink-300" />
                                        </span>
                                        <span
                                            class="min-w-0 flex-1 text-ink-900"
                                            :class="current ? 'text-sm font-medium' : 'text-base font-semibold'"
                                        >{{ node.title }}</span>
                                        <span
                                            v-if="node.label_name"
                                            class="shrink-0 text-2xs font-extrabold uppercase tracking-wide"
                                            :style="{ color: node.label_color || undefined }"
                                        >{{ node.label_name }}</span>
                                        <SfIcon
                                            v-if="node.children?.length"
                                            name="chevronRight"
                                            :size="18"
                                            class="shrink-0 text-ink-400"
                                        />
                                    </button>
                                </li>
                            </ul>
                        </template>
                    </div>
                </section>
            </Transition>
        </Teleport>
    </div>
</template>
