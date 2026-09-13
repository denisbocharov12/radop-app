<script setup>
/**
 * Mobile catalogue drawer.
 *
 * Drill-down rather than accordion: on a 360 px screen an accordion of a
 * three-level catalogue pushes the visitor into endless vertical scrolling,
 * so each tap replaces the list and a back row walks the stack up.
 * Shares the /api/v1/mega-menu data with <MegaMenu>, so the tree is fetched
 * once per session and reused.
 */
import { computed, onBeforeUnmount, onMounted, ref, watch } from 'vue';
import SfIcon from './SfIcon.vue';

const props = defineProps({
    code: { type: String, default: 'main_menu' },
    label: { type: String, default: 'Catalog' },
    links: { type: Array, default: () => [] },
    locales: { type: Array, default: () => [] },
    phone: { type: String, default: '' },
    email: { type: String, default: '' },
});

const open = ref(false);
const loading = ref(false);
const roots = ref([]);
/** Breadcrumb of nodes the visitor has drilled into. */
const stack = ref([]);

const current = computed(() => stack.value[stack.value.length - 1] ?? null);
const list = computed(() => (current.value ? current.value.children ?? [] : roots.value));

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
    if (roots.value.length || loading.value) return;
    loading.value = true;
    try {
        const res = await fetch(`/api/v1/mega-menu/${props.code}/data`, {
            headers: { Accept: 'application/json' },
            credentials: 'same-origin',
        });
        const body = await res.json();
        roots.value = body?.data?.categories ?? [];
    } catch {
        roots.value = [];
    } finally {
        loading.value = false;
    }
}

function show() {
    open.value = true;
    load();
}

function close() {
    open.value = false;
    stack.value = [];
}

function enter(node) {
    if (node.children?.length) stack.value.push(node);
    else window.location.href = href(node.link);
}

function back() {
    stack.value.pop();
}

watch(open, (isOpen) => {
    document.body.style.overflow = isOpen ? 'hidden' : '';
    // The bottom tab bar highlights "Catalogue" while the drawer is open.
    document.dispatchEvent(new CustomEvent('sf:mobile-nav-state', { detail: { open: isOpen } }));
});

function onKeydown(event) {
    if (event.key === 'Escape' && open.value) close();
}

onMounted(() => {
    document.addEventListener('keydown', onKeydown);
    document.addEventListener('sf:open-mobile-nav', show);
});
onBeforeUnmount(() => {
    document.removeEventListener('keydown', onKeydown);
    document.removeEventListener('sf:open-mobile-nav', show);
    document.body.style.overflow = '';
});
</script>

<template>
    <div class="lg:hidden">
        <button type="button" class="sf-icon-btn" :aria-label="label" @click="show">
            <SfIcon name="menu" :size="22" />
        </button>

        <Teleport to="body">
            <Transition
                enter-active-class="transition-opacity duration-200"
                enter-from-class="opacity-0"
                leave-active-class="transition-opacity duration-150"
                leave-to-class="opacity-0"
            >
                <div v-if="open" class="sf-overlay lg:hidden" @click="close"></div>
            </Transition>

            <Transition
                enter-active-class="transition-transform duration-250 ease-sf"
                enter-from-class="-translate-x-full"
                leave-active-class="transition-transform duration-200 ease-sf"
                leave-to-class="-translate-x-full"
            >
                <aside
                    v-if="open"
                    class="fixed inset-y-0 left-0 z-modal flex w-[min(22rem,88vw)] flex-col bg-white shadow-pop lg:hidden"
                    role="dialog"
                    :aria-label="label"
                >
                    <header class="flex items-center gap-2 border-b border-ink-100 px-3 py-3">
                        <button v-if="stack.length" type="button" class="sf-icon-btn" @click="back">
                            <SfIcon name="chevronLeft" />
                        </button>
                        <span class="min-w-0 flex-1 truncate text-md font-semibold text-ink-900">
                            {{ current ? current.title : label }}
                        </span>
                        <button type="button" class="sf-icon-btn" :aria-label="$sf.t.close" @click="close">
                            <SfIcon name="close" />
                        </button>
                    </header>

                    <div class="flex-1 overflow-y-auto overscroll-contain">
                        <div v-if="loading" class="space-y-2 p-3">
                            <div v-for="n in 10" :key="n" class="sf-skeleton h-10 w-full"></div>
                        </div>

                        <template v-else>
                            <a
                                v-if="current"
                                :href="href(current.link)"
                                class="flex items-center justify-between border-b border-ink-100 px-4 py-3 text-sm font-semibold text-brand-600"
                            >
                                {{ $sf.t.viewAll }}
                                <SfIcon name="arrowRight" :size="16" />
                            </a>

                            <ul class="divide-y divide-ink-100">
                                <li v-for="node in list" :key="node.id">
                                    <button
                                        type="button"
                                        class="flex w-full items-center gap-3 px-4 py-3 text-left text-base text-ink-800 active:bg-ink-50"
                                        @click="enter(node)"
                                    >
                                        <img
                                            v-if="node.image"
                                            :src="node.image"
                                            alt=""
                                            loading="lazy"
                                            class="h-6 w-6 shrink-0 object-contain opacity-80"
                                        />
                                        <span class="min-w-0 flex-1">{{ node.title }}</span>
                                        <span v-if="node.products_count" class="text-2xs text-ink-400">
                                            {{ node.products_count }}
                                        </span>
                                        <SfIcon v-if="node.children?.length" name="chevronRight" :size="16" class="text-ink-300" />
                                    </button>
                                </li>
                            </ul>

                            <nav v-if="!current && links.length" class="border-t-8 border-ink-50">
                                <a
                                    v-for="link in links"
                                    :key="link.url"
                                    :href="link.url"
                                    class="block border-b border-ink-100 px-4 py-3 text-base text-ink-700"
                                >{{ link.label }}</a>
                            </nav>
                        </template>
                    </div>

                    <footer v-if="!current" class="space-y-3 border-t border-ink-100 p-4">
                        <a v-if="phone" :href="`tel:${phone.replace(/\s/g, '')}`" class="flex items-center gap-2 text-sm font-medium text-ink-800">
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
                                class="rounded-md px-2.5 py-1.5 text-xs font-semibold uppercase"
                                :class="loc.active ? 'bg-brand-600 text-white' : 'bg-ink-100 text-ink-600'"
                            >{{ loc.code }}</a>
                        </div>
                    </footer>
                </aside>
            </Transition>
        </Teleport>
    </div>
</template>
