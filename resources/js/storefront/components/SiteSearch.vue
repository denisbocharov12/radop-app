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
const history = ref([]);
const open = ref(false);
const busy = ref(false);
const cursor = ref(-1);

const rootEl = ref(null);
const formEl = ref(null);
const inputEl = ref(null);

let debounce = null;
let controller = null;

const showingHistory = computed(() => query.value.trim().length < 2);
const items = computed(() => (showingHistory.value ? history.value : suggestions.value));

const labelOf = (item) => (typeof item === 'string' ? item : item.text ?? item.query ?? '');

async function loadHistory() {
    try {
        const body = await getJson(route('searchHistory', '/search/history'));
        history.value = (body?.data ?? []).map(labelOf).filter(Boolean);
    } catch {
        history.value = [];
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
    } catch (error) {
        if (error.name !== 'AbortError') suggestions.value = [];
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
        return;
    }
    debounce = setTimeout(() => loadSuggestions(trimmed), 220);
});

function focus() {
    open.value = true;
    if (!history.value.length) loadHistory();
}

function pick(item) {
    query.value = labelOf(item);
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
                v-if="open && (items.length || busy)"
                class="absolute inset-x-0 top-full z-menu mt-2 overflow-hidden rounded-lg border border-ink-200 bg-white shadow-pop"
            >
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
            </div>
        </Transition>
    </div>
</template>
