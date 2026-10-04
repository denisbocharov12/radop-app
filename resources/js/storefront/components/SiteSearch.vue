<script setup>
/**
 * Header search: suggestions + recent-search history in one dropdown.
 *
 * Replaces ~300 lines of jQuery in scripts.blade.php that duplicated the whole
 * widget twice (desktop + mobile) and kept two copies of the history list in
 * sync by id. One component, mounted twice, no shared DOM ids.
 *
 * Picking a suggestion submits through `requestSubmit()` rather than
 * `submit()`: only the former fires the `submit` event, which is what the GA4
 * site-search listener in scripts.blade.php hooks.
 */
import { computed, nextTick, onBeforeUnmount, onMounted, ref, watch } from 'vue';
import SfIcon from './SfIcon.vue';
import { csrf, getJson, route } from '../lib/cart.js';

const props = defineProps({
    action: { type: String, required: true },
    value: { type: String, default: '' },
    placeholder: { type: String, default: '' },
    autofocus: { type: Boolean, default: false },
});

const query = ref(props.value);
const suggestions = ref([]);
/** ТЗ 69: сами товары — с фото, названием и ценой. */
const products = ref([]);
const history = ref([]);
/** ТЗ 68: популярные запросы — их видно, пока поле пустое. */
const popular = ref([]);
const open = ref(false);
const busy = ref(false);
const cursor = ref(-1);

const rootEl = ref(null);
const formEl = ref(null);
const inputEl = ref(null);

let debounce = null;
let controller = null;

const showingHistory = computed(() => query.value.trim().length < 2);
/* Популярное показываем только при пустом поле и не дублируем историю. */
const popularVisible = computed(() =>
    showingHistory.value ? popular.value.filter((term) => !history.value.includes(term)) : [],
);
const items = computed(() => (showingHistory.value ? history.value : suggestions.value));

const labelOf = (item) => (typeof item === 'string' ? item : item.text ?? item.query ?? '');

async function loadHistory() {
    try {
        const body = await getJson(route('searchHistory', '/search/history'));
        history.value = (body?.data ?? []).map(labelOf).filter(Boolean);
        popular.value = (body?.popular ?? []).map(labelOf).filter(Boolean);
    } catch {
        history.value = [];
        popular.value = [];
    }
}

async function loadSuggestions(term) {
    controller?.abort();
    controller = new AbortController();
    busy.value = true;
    try {
        const url = new URL(route('searchSuggestions', '/search/suggestions'), window.location.origin);
        url.searchParams.set('query', term);
        const res = await fetch(url, {
            headers: { Accept: 'application/json' },
            credentials: 'same-origin',
            signal: controller.signal,
        });
        const body = await res.json();
        suggestions.value = (body?.data ?? []).slice(0, 8);
        products.value = body?.products ?? [];
    } catch (error) {
        if (error.name !== 'AbortError') {
            suggestions.value = [];
            products.value = [];
        }
    } finally {
        busy.value = false;
    }
}

watch(query, (term) => {
    cursor.value = -1;
    clearTimeout(debounce);
    const trimmed = term.trim();
    if (trimmed.length < 2) {
        suggestions.value = [];
        products.value = [];
        return;
    }
    debounce = setTimeout(() => loadSuggestions(trimmed), 220);
});

let listsLoaded = false;

function focus() {
    open.value = true;
    if (listsLoaded) return;
    listsLoaded = true;
    loadHistory();
}

function pick(item) {
    query.value = labelOf(item);
    open.value = false;
    nextTick(() => formEl.value?.requestSubmit());
}

function submitQuery() {
    open.value = false;
    nextTick(() => formEl.value?.requestSubmit());
}

async function clearHistory() {
    history.value = [];
    try {
        await fetch(route('searchHistoryClear', '/search/history/clear'), {
            method: 'POST',
            headers: { Accept: 'application/json', 'X-CSRF-TOKEN': csrf() },
            credentials: 'same-origin',
        });
    } catch {
        /* the list is already empty for the visitor; a failed sync is harmless */
    }
}

async function removeHistoryItem(term) {
    history.value = history.value.filter((entry) => entry !== term);
    try {
        await fetch(route('searchHistoryDelete', '/search/history/delete'), {
            method: 'DELETE',
            headers: { Accept: 'application/json', 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf() },
            credentials: 'same-origin',
            body: JSON.stringify({ query: term }),
        });
    } catch {
        /* optimistic; worst case the entry reappears next page load */
    }
}

function onKeydown(event) {
    if (!open.value || !items.value.length) return;
    if (event.key === 'ArrowDown') {
        event.preventDefault();
        cursor.value = (cursor.value + 1) % items.value.length;
    } else if (event.key === 'ArrowUp') {
        event.preventDefault();
        cursor.value = (cursor.value - 1 + items.value.length) % items.value.length;
    } else if (event.key === 'Enter' && cursor.value >= 0) {
        event.preventDefault();
        pick(items.value[cursor.value]);
    } else if (event.key === 'Escape') {
        open.value = false;
        inputEl.value?.blur();
    }
}

function onPointerDown(event) {
    if (!rootEl.value?.contains(event.target)) open.value = false;
}

/** The bottom bar's "Search" tab focuses whichever search box is visible. */
function onFocusRequest() {
    if (!rootEl.value || rootEl.value.offsetParent === null) return;
    inputEl.value?.focus({ preventScroll: false });
    rootEl.value.scrollIntoView({ block: 'nearest' });
}

onMounted(() => {
    document.addEventListener('pointerdown', onPointerDown, true);
    document.addEventListener('sf:focus-search', onFocusRequest);
    if (props.autofocus) inputEl.value?.focus();
});

onBeforeUnmount(() => {
    document.removeEventListener('pointerdown', onPointerDown, true);
    document.removeEventListener('sf:focus-search', onFocusRequest);
    clearTimeout(debounce);
    controller?.abort();
});
</script>

<template>
    <div ref="rootEl" class="relative w-full">
        <form ref="formEl" :action="action" method="GET" role="search" class="relative">
            <input
                ref="inputEl"
                v-model="query"
                type="search"
                name="search"
                enterkeyhint="search"
                autocomplete="off"
                :placeholder="placeholder"
                :aria-label="placeholder"
                class="sf-field h-11 pl-10 pr-12 sm:pr-24"
                @focus="focus"
                @keydown="onKeydown"
            />
            <SfIcon
                name="search"
                :size="18"
                class="pointer-events-none absolute left-3.5 top-1/2 -translate-y-1/2 text-ink-400"
            />
            <button
                type="submit"
                class="sf-btn-primary absolute right-1 top-1/2 h-9 -translate-y-1/2 px-2.5 sm:px-3"
                :aria-label="$sf.t.search"
            >
                <SfIcon name="search" :size="16" class="sm:hidden" />
                <span class="hidden text-sm sm:inline">{{ $sf.t.search }}</span>
            </button>
        </form>

        <Transition
            enter-active-class="transition duration-150 ease-sf"
            enter-from-class="opacity-0 -translate-y-1"
            leave-active-class="transition duration-100"
            leave-to-class="opacity-0"
        >
            <div
                v-if="open && (items.length || popularVisible.length || busy || !showingHistory)"
                class="absolute inset-x-0 top-full z-menu mt-2 overflow-hidden rounded-lg border border-ink-200 bg-white shadow-pop"
            >
                <!-- ТЗ 68: популярные запросы — пока поле пустое, это самый
                     короткий путь к тому, что ищут чаще всего. -->
                <div v-if="popularVisible.length" class="border-b border-ink-100 px-3 py-2">
                    <p class="mb-1.5 text-xs font-semibold uppercase tracking-wide text-ink-500">
                        {{ $sf.t.popularSearches }}
                    </p>
                    <div class="flex flex-wrap gap-1.5">
                        <button
                            v-for="term in popularVisible"
                            :key="term"
                            type="button"
                            class="rounded-md border border-ink-200 px-2 py-1 text-xs text-ink-700 hover:border-brand-300 hover:bg-brand-50 hover:text-brand-700"
                            @click="pick(term)"
                        >
                            {{ term }}
                        </button>
                    </div>
                </div>

                <div
                    v-if="showingHistory && history.length"
                    class="flex items-center justify-between border-b border-ink-100 px-3 py-2"
                >
                    <span class="text-xs font-semibold uppercase tracking-wide text-ink-500">
                        {{ $sf.t.searchHistory }}
                    </span>
                    <button
                        type="button"
                        class="inline-flex items-center gap-1 text-xs text-ink-500 hover:text-danger-600"
                        @click="clearHistory"
                    >
                        <SfIcon name="trash" :size="14" />
                        {{ $sf.t.clearAll }}
                    </button>
                </div>

                <!-- ТЗ 69: сами товары — фото, название, код и цена. Человек чаще
                     ищет товар, а не слово, поэтому они стоят первыми. -->
                <div v-if="products.length" class="border-b border-ink-100">
                    <p class="px-3 pt-2 text-xs font-semibold uppercase tracking-wide text-ink-500">
                        {{ $sf.t.suggestedProducts }}
                    </p>
                    <ul class="py-1">
                        <li v-for="product in products" :key="product.id">
                            <a :href="product.url" class="flex items-center gap-3 px-3 py-2 hover:bg-ink-50">
                                <img
                                    v-if="product.image"
                                    :src="product.image"
                                    :alt="product.title"
                                    class="h-10 w-10 shrink-0 rounded border border-ink-100 bg-white object-contain"
                                    loading="lazy"
                                    decoding="async"
                                />
                                <span
                                    v-else
                                    class="flex h-10 w-10 shrink-0 items-center justify-center rounded border border-ink-100 text-ink-300"
                                >
                                    <SfIcon name="box" :size="18" />
                                </span>
                                <span class="min-w-0 flex-1">
                                    <span class="line-clamp-2 text-sm text-ink-800">{{ product.title }}</span>
                                    <span class="mt-0.5 block text-xs text-ink-500">
                                        {{ $sf.t.code }}: {{ product.code }}
                                    </span>
                                </span>
                                <span class="shrink-0 whitespace-nowrap text-sm font-semibold text-ink-900">
                                    {{ product.price }} {{ $sf.t.currency }}
                                </span>
                            </a>
                        </li>
                    </ul>
                </div>

                <ul class="max-h-80 overflow-y-auto py-1">
                    <li v-for="(item, i) in items" :key="labelOf(item) + i" class="group/item flex items-center">
                        <button
                            type="button"
                            class="flex min-w-0 flex-1 items-center gap-2.5 px-3 py-2.5 text-left text-sm"
                            :class="i === cursor ? 'bg-brand-50 text-brand-700' : 'text-ink-700 hover:bg-ink-50'"
                            @mouseenter="cursor = i"
                            @click="pick(item)"
                        >
                            <SfIcon :name="showingHistory ? 'clock' : 'search'" :size="15" class="text-ink-400" />
                            <span class="min-w-0 flex-1 truncate">{{ labelOf(item) }}</span>
                        </button>
                        <button
                            v-if="showingHistory"
                            type="button"
                            class="mr-1 flex h-8 w-8 shrink-0 items-center justify-center rounded text-ink-300 hover:bg-ink-100 hover:text-danger-600"
                            :aria-label="$sf.t.clearAll"
                            @click="removeHistoryItem(labelOf(item))"
                        >
                            <SfIcon name="close" :size="14" />
                        </button>
                    </li>
                </ul>

                <div v-if="busy && !items.length" class="space-y-2 p-3">
                    <div v-for="n in 3" :key="n" class="sf-skeleton h-4 w-full"></div>
                </div>

                <!-- Always offer the full search: suggestions are only a shortcut,
                     and a term with no suggestion ("pixuri") still has results. -->
                <button
                    v-if="!showingHistory"
                    type="button"
                    class="flex w-full items-center gap-2.5 border-t border-ink-100 bg-ink-50/60 px-3 py-2.5 text-left text-sm font-medium text-brand-700 hover:bg-brand-50"
                    @click="submitQuery"
                >
                    <SfIcon name="search" :size="15" />
                    <span class="min-w-0 flex-1 truncate">{{ $sf.t.search }}: „{{ query.trim() }}"</span>
                    <SfIcon name="chevronRight" :size="15" class="text-brand-400" />
                </button>
            </div>
        </Transition>
    </div>
</template>
