<script setup>
/**
 * Quick view dialog — restores the legacy card's "quick view" button.
 *
 * One instance lives in the layout. Any `[data-sf-quick-view="<id>"]` control
 * opens it; the product is fetched from /sf/product/{id}/preview as JSON and
 * rendered with the same gallery and add-to-cart islands the product page
 * uses, instead of the legacy endpoint's HTML fragment (which needed Slick,
 * Fancybox and ~400 lines of re-initialisation code).
 */
import { computed, nextTick, onBeforeUnmount, onMounted, ref, watch } from 'vue';
import SfIcon from './SfIcon.vue';
import ProductGallery from './ProductGallery.vue';
import AddToCart from './AddToCart.vue';
import WishlistButton from './WishlistButton.vue';
import { getJson, route } from '../lib/cart.js';

const open = ref(false);
const loading = ref(false);
const failed = ref(false);
const product = ref(null);
const dialogEl = ref(null);

let lastFocus = null;

const money = new Intl.NumberFormat('ro-MD', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
const price = computed(() => (product.value ? money.format(product.value.displayPrice) : ''));
const oldPrice = computed(() => (product.value?.oldPrice ? money.format(product.value.oldPrice) : null));
const unitPrice = computed(() => (product.value ? money.format(product.value.unitPrice) : ''));
const badges = computed(() => [
    product.value?.salePercent ? { label: `-${product.value.salePercent}%`, class: 'sf-badge-sale' } : null,
    product.value?.condition === 'new' ? { label: 'NEW', class: 'sf-badge-new' } : null,
    product.value?.condition === 'popular' ? { label: 'HIT', class: 'sf-badge-hit' } : null,
].filter(Boolean));

async function load(id) {
    lastFocus = document.activeElement;
    open.value = true;
    loading.value = true;
    failed.value = false;
    product.value = null;
    try {
        product.value = await getJson(route('productPreview', '/sf/product/__ID__/preview').replace('__ID__', id));
    } catch {
        failed.value = true;
    } finally {
        loading.value = false;
        nextTick(() => dialogEl.value?.focus());
    }
}

function close() {
    open.value = false;
    lastFocus?.focus?.();
}

function onClick(event) {
    const trigger = event.target.closest('[data-sf-quick-view]');
    if (!trigger) return;
    event.preventDefault();
    event.stopPropagation();
    load(trigger.dataset.sfQuickView);
}

function onKeydown(event) {
    if (event.key === 'Escape' && open.value) close();
}

watch(open, (isOpen) => {
    document.body.style.overflow = isOpen ? 'hidden' : '';
});

onMounted(() => {
    document.addEventListener('click', onClick, true);
    document.addEventListener('keydown', onKeydown);
});

onBeforeUnmount(() => {
    document.removeEventListener('click', onClick, true);
    document.removeEventListener('keydown', onKeydown);
    document.body.style.overflow = '';
});
</script>

<template>
    <Teleport to="body">
        <Transition
            enter-active-class="transition-opacity duration-150"
            enter-from-class="opacity-0"
            leave-active-class="transition-opacity duration-150"
            leave-to-class="opacity-0"
        >
            <div
                v-if="open"
                class="fixed inset-0 z-modal flex items-end justify-center bg-ink-900/50 backdrop-blur-[2px] sm:items-center sm:p-6"
                @click.self="close"
            >
                <div
                    ref="dialogEl"
                    tabindex="-1"
                    class="relative flex max-h-[92vh] w-full flex-col overflow-hidden rounded-t-2xl bg-white shadow-pop outline-none sm:max-w-4xl sm:rounded-xl"
                    role="dialog"
                    aria-modal="true"
                    :aria-label="product?.title ?? $sf.t.details"
                >
                    <button type="button" class="sf-icon-btn absolute right-2 top-2 z-10 bg-white/90" :aria-label="$sf.t.close" @click="close">
                        <SfIcon name="close" />
                    </button>

                    <div class="overflow-y-auto p-4 sm:p-6">
                        <div v-if="loading" class="grid gap-6 md:grid-cols-2">
                            <div class="sf-skeleton aspect-square w-full"></div>
                            <div class="space-y-3">
                                <div class="sf-skeleton h-6 w-3/4"></div>
                                <div class="sf-skeleton h-4 w-1/3"></div>
                                <div class="sf-skeleton h-10 w-1/2"></div>
                                <div v-for="n in 5" :key="n" class="sf-skeleton h-4 w-full"></div>
                            </div>
                        </div>

                        <p v-else-if="failed" class="py-12 text-center text-sm text-ink-500">
                            <SfIcon name="info" class="mx-auto mb-2" />{{ $sf.t.menuError }}
                        </p>

                        <div v-else-if="product" class="grid gap-6 md:grid-cols-2">
                            <div class="relative">
                                <ProductGallery
                                    v-if="product.images.length"
                                    :images="product.images.map((url) => ({ url, thumb: url }))"
                                    :alt="product.title"
                                    :badges="badges"
                                />
                                <div v-else class="flex aspect-square items-center justify-center rounded-lg border border-ink-200 text-ink-300">
                                    <SfIcon name="box" :size="48" />
                                </div>
                            </div>

                            <div class="flex min-w-0 flex-col gap-4">
                                <div>
                                    <h2 class="pr-8 text-lg font-bold leading-snug text-ink-900">{{ product.title }}</h2>
                                    <p class="mt-1 flex flex-wrap gap-x-4 gap-y-1 text-xs text-ink-500">
                                        <span>{{ $sf.t.code }}: <b class="font-medium text-ink-700">{{ product.code }}</b></span>
                                        <a v-if="product.brand" :href="product.brand.url" class="font-medium text-brand-600 hover:text-brand-700">{{ product.brand.title }}</a>
                                    </p>
                                </div>

                                <div>
                                    <div class="flex flex-wrap items-baseline gap-2">
                                        <span class="text-2xl font-bold leading-none" :class="oldPrice ? 'text-accent-600' : 'text-ink-900'">{{ price }}</span>
                                        <span class="text-sm text-ink-500">
                                            {{ $sf.currency }}<template v-if="product.minOrder"> / {{ product.minOrder }} {{ $sf.t.unit }}</template>
                                        </span>
                                        <span v-if="oldPrice" class="sf-product-price-old">{{ oldPrice }}</span>
                                    </div>
                                    <ul class="mt-2 flex flex-wrap gap-1.5 text-xs">
                                        <li v-if="product.personalPercent" class="rounded-full bg-brand-50 px-2.5 py-1 font-semibold text-brand-700">
                                            {{ $sf.t.personalPrice }} −{{ product.personalPercent }}%
                                        </li>
                                        <li v-if="product.minOrder" class="rounded-full bg-ink-100 px-2.5 py-1 text-ink-700">
                                            {{ $sf.t.minOrder }}: {{ product.minOrder }} {{ $sf.t.unit }} · {{ unitPrice }} {{ $sf.currency }}/{{ $sf.t.unit }}
                                        </li>
                                        <li v-if="product.lowStock" class="rounded-full bg-accent-50 px-2.5 py-1 font-medium text-accent-700">
                                            {{ $sf.t.lowStock.replace(':qty', product.lowStock) }}
                                        </li>
                                    </ul>
                                </div>

                                <p class="flex items-center gap-1.5 text-sm">
                                    <SfIcon :name="product.stock > 0 ? 'check' : 'info'" :size="15" :class="product.stock > 0 ? 'text-success-500' : 'text-ink-400'" />
                                    <span :class="product.stock > 0 ? 'font-medium text-success-600' : 'text-ink-500'">
                                        {{ product.stock > 0 ? $sf.t.inStock : $sf.t.outOfStock }}
                                    </span>
                                    <span v-if="product.packages" class="ml-auto text-xs text-ink-400">
                                        {{ $sf.t.package }}: {{ product.packages }} {{ $sf.t.packageUnit }}
                                    </span>
                                </p>

                                <AddToCart
                                    :key="product.id"
                                    :product-id="product.id"
                                    :step="product.step"
                                    :stock="product.stock"
                                    :price="product.unitPrice"
                                    :in-cart="product.inCart"
                                    :currency="$sf.currency"
                                    :label-add="$sf.t.addToCart"
                                    :label-in-cart="$sf.t.inCart"
                                    :label-total="$sf.t.total"
                                    :disabled="product.stock <= 0"
                                />

                                <div class="grid grid-cols-2 gap-2">
                                    <WishlistButton
                                        variant="inline"
                                        :product-id="product.id"
                                        :active="product.inWishlist"
                                        :label-add="$sf.t.addToWishlist"
                                        :label-remove="$sf.t.removeFromWishlist"
                                    />
                                    <a :href="product.url" class="sf-btn-secondary">
                                        {{ $sf.t.openProduct }}<SfIcon name="arrowRight" :size="15" />
                                    </a>
                                </div>

                                <dl v-if="product.specs.length" class="divide-y divide-ink-100 rounded-lg border border-ink-200 text-sm">
                                    <div v-for="spec in product.specs.slice(0, 8)" :key="spec.name" class="flex gap-3 px-3 py-2">
                                        <dt class="w-1/2 shrink-0 text-ink-500">{{ spec.name }}</dt>
                                        <dd class="min-w-0 flex-1 font-medium text-ink-800">{{ spec.value }}</dd>
                                    </div>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </Transition>
    </Teleport>
</template>
