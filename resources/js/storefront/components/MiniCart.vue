<script setup>
/**
 * Header basket: link, badge, and a preview panel.
 *
 * Restores the hover mini-cart the legacy header had (`header-cart` +
 * `mini-cart.blade.php`), fed by /sf/cart/summary instead of server HTML.
 *
 *  - Pointer devices: the panel opens on hover/focus and briefly on its own
 *    after something is added, so the visitor sees what happened.
 *  - Touch devices: the header link goes straight to the basket; an "added"
 *    bar slides up from the bottom instead of a panel under a finger.
 */
import { computed, onBeforeUnmount, onMounted, ref } from 'vue';
import SfIcon from './SfIcon.vue';
import { fetchSummary, route } from '../lib/cart.js';

const props = defineProps({
    count: { type: Number, default: 0 },
    total: { type: String, default: '0,00' },
    authenticated: { type: Boolean, default: false },
});

const summary = ref({ lines: [], count: props.count, total: props.total, belowMinimum: false });
const loaded = ref(false);
const loading = ref(false);
const open = ref(false);
const toast = ref(null);

const finePointer = window.matchMedia('(hover: hover) and (pointer: fine)').matches;

let closeTimer = null;
let toastTimer = null;

const badge = computed(() => (summary.value.count > 99 ? '99+' : String(summary.value.count)));

async function refresh() {
    loading.value = true;
    try {
        summary.value = await fetchSummary();
        loaded.value = true;
    } catch {
        /* keep the last known state */
    } finally {
        loading.value = false;
    }
}

function show() {
    if (!finePointer) return;
    clearTimeout(closeTimer);
    open.value = true;
    if (!loaded.value) refresh();
}

function hideSoon(delay = 180) {
    clearTimeout(closeTimer);
    closeTimer = setTimeout(() => { open.value = false; }, delay);
}

async function onCartUpdated(event) {
    const detail = event.detail ?? {};
    await refresh();

    if (detail.action !== 'add') return;

    if (finePointer) {
        open.value = true;
        hideSoon(3200);
    } else {
        clearTimeout(toastTimer);
        toast.value = detail.product_title ?? '';
        toastTimer = setTimeout(() => { toast.value = null; }, 3500);
    }
}

onMounted(() => document.addEventListener('sf:cart-updated', onCartUpdated));
onBeforeUnmount(() => {
    document.removeEventListener('sf:cart-updated', onCartUpdated);
    clearTimeout(closeTimer);
    clearTimeout(toastTimer);
});
</script>

<template>
    <div class="relative" @mouseenter="show" @mouseleave="hideSoon()" @focusin="show" @focusout="hideSoon(300)">
        <a
            :href="route('cart', '/cart')"
            class="relative inline-flex h-11 items-center gap-2.5 rounded-md bg-brand-50 px-3 text-brand-700 transition-colors hover:bg-brand-100 sm:px-3.5"
            :aria-label="$sf.t.goToCart"
            :aria-expanded="open"
        >
            <span class="relative">
                <SfIcon name="cart" :size="21" />
                <span
                    v-show="summary.count > 0"
                    class="absolute -right-2 -top-2 flex h-4 min-w-[1rem] items-center justify-center rounded-full bg-accent-500 px-1 text-2xs font-bold text-white"
                    data-sf-cart-count
                >{{ badge }}</span>
            </span>
            <span class="hidden whitespace-nowrap font-num text-sm font-bold sm:inline">
                {{ summary.total }} {{ $sf.currency }}
            </span>
        </a>

        <!-- Desktop preview panel -->
        <Transition
            enter-active-class="transition duration-150 ease-sf"
            enter-from-class="opacity-0 translate-y-1"
            leave-active-class="transition duration-100"
            leave-to-class="opacity-0"
        >
            <div
                v-if="open"
                class="absolute right-0 top-full z-menu mt-2 w-[22rem] overflow-hidden rounded-xl border border-ink-200 bg-white shadow-pop"
            >
                <div v-if="loading && !loaded" class="space-y-3 p-4">
                    <div v-for="n in 3" :key="n" class="flex gap-3">
                        <div class="sf-skeleton h-12 w-12"></div>
                        <div class="flex-1 space-y-2"><div class="sf-skeleton h-3 w-full"></div><div class="sf-skeleton h-3 w-1/2"></div></div>
                    </div>
                </div>

                <div v-else-if="!summary.lines.length" class="p-6 text-center">
                    <SfIcon name="cart" :size="32" class="mx-auto mb-2 text-ink-300" />
                    <p class="text-sm text-ink-600">{{ $sf.t.emptyCart }}</p>
                </div>

                <template v-else>
                    <ul class="max-h-80 divide-y divide-ink-100 overflow-y-auto">
                        <li v-for="line in summary.lines" :key="line.id" class="flex items-center gap-3 px-4 py-2">
                            <a :href="line.url" class="h-11 w-11 shrink-0 rounded-md border border-ink-100 p-1">
                                <img v-if="line.image" :src="line.image" :alt="line.title" class="h-full w-full object-contain" loading="lazy" />
                            </a>
                            <div class="min-w-0 flex-1">
                                <a :href="line.url" class="line-clamp-2 text-xs font-medium text-ink-800 hover:text-brand-600">{{ line.title }}</a>
                                <p class="mt-0.5 text-2xs text-ink-500"><span class="font-num">{{ line.qty }}</span> × · {{ $sf.t.code }} <span class="font-num">{{ line.code }}</span></p>
                            </div>
                            <span class="shrink-0 whitespace-nowrap font-num text-xs font-bold text-ink-900">{{ line.lineTotal }}</span>
                        </li>
                    </ul>

                    <div class="space-y-3 border-t border-ink-100 bg-ink-50 p-4">
                        <p class="flex items-baseline justify-between">
                            <span class="text-sm text-ink-600">{{ $sf.t.total }}</span>
                            <span class="font-num text-lg font-bold text-ink-900">{{ summary.total }} {{ $sf.currency }}</span>
                        </p>
                        <p v-if="summary.belowMinimum" class="rounded-md bg-accent-50 px-2.5 py-2 text-xs text-accent-700">
                            {{ $sf.t.minOrderAddMore }} <b>{{ summary.remaining }} {{ $sf.currency }}</b>
                        </p>
                        <div class="grid grid-cols-2 gap-2">
                            <a :href="route('cart', '/cart')" class="sf-btn-secondary sf-btn-sm">{{ $sf.t.goToCart }}</a>
                            <a
                                v-if="authenticated && !summary.belowMinimum"
                                :href="route('checkout', '/checkout')"
                                class="sf-btn-primary sf-btn-sm"
                            >{{ $sf.t.checkout }}</a>
                            <a v-else :href="route('cart', '/cart')" class="sf-btn-primary sf-btn-sm">{{ $sf.t.checkout }}</a>
                        </div>
                    </div>
                </template>
            </div>
        </Transition>

        <!-- Touch: confirmation bar above the bottom navigation -->
        <Teleport to="body">
            <Transition
                enter-active-class="transition duration-200 ease-sf"
                enter-from-class="translate-y-4 opacity-0"
                leave-active-class="transition duration-150"
                leave-to-class="translate-y-4 opacity-0"
            >
                <div
                    v-if="toast !== null"
                    class="fixed inset-x-3 bottom-[calc(4.25rem+env(safe-area-inset-bottom))] z-modal flex items-center gap-3 rounded-xl bg-ink-900 px-4 py-3 text-white shadow-pop lg:hidden"
                    role="status"
                >
                    <SfIcon name="check" :size="18" class="shrink-0 text-success-500" />
                    <div class="min-w-0 flex-1">
                        <p class="text-sm font-semibold">{{ $sf.t.addedToCart }}</p>
                        <p v-if="toast" class="truncate text-xs text-white/70">{{ toast }}</p>
                    </div>
                    <a :href="route('cart', '/cart')" class="shrink-0 rounded-md bg-white px-3 py-1.5 text-xs font-bold text-ink-900">
                        {{ $sf.t.goToCart }}
                    </a>
                </div>
            </Transition>
        </Teleport>
    </div>
</template>
