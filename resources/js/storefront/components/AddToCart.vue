<script setup>
/**
 * Quantity stepper + add-to-cart button.
 *
 * Replaces the legacy pairing of `add_to_cart_widget_v2.blade.php` and the
 * delegated jQuery handlers in scripts.blade.php, which addressed inputs by
 * `name="product-{id}-qty"` and re-rendered the header by injecting server
 * HTML. The component owns its own quantity; the header, mini-cart and tab bar
 * listen for one `sf:cart-updated` event.
 *
 * `compact` is the product-card layout: on narrow cards (two-up on phones) the
 * stepper and button stack instead of squeezing the button label to "În…".
 */
import { computed, onBeforeUnmount, onMounted, ref } from 'vue';
import SfIcon from './SfIcon.vue';
import { addToCart, notify } from '../lib/cart.js';

const props = defineProps({
    productId: { type: Number, required: true },
    /** Smallest sellable quantity — also the stepper's increment. */
    step: { type: Number, default: 1 },
    stock: { type: Number, default: 0 },
    /** Unit price already adjusted for the visitor's discount, in MDL. */
    price: { type: Number, default: 0 },
    inCart: { type: Number, default: 0 },
    currency: { type: String, default: 'MDL' },
    labelAdd: { type: String, default: 'Add to cart' },
    labelInCart: { type: String, default: 'In cart' },
    labelTotal: { type: String, default: 'Total' },
    disabled: { type: Boolean, default: false },
    compact: { type: Boolean, default: false },
});

const qty = ref(Math.max(props.step, 1));
const cartQty = ref(props.inCart);
const busy = ref(false);
const justAdded = ref(false);

let addedTimer = null;

const step = computed(() => Math.max(props.step, 1));
const maxQty = computed(() => (props.stock > 0 ? props.stock : Number.MAX_SAFE_INTEGER));
const lineTotal = computed(() => qty.value * props.price);

const formatted = computed(() =>
    new Intl.NumberFormat('ro-MD', { minimumFractionDigits: 2, maximumFractionDigits: 2 })
        .format(lineTotal.value));

function clamp(value) {
    const s = step.value;
    const rounded = Math.round(value / s) * s;
    return Math.min(Math.max(rounded, s), maxQty.value);
}

function bump(delta) {
    qty.value = clamp(qty.value + delta * step.value);
}

function onInput(event) {
    const parsed = Number.parseInt(event.target.value, 10);
    qty.value = Number.isNaN(parsed) ? step.value : clamp(parsed);
    event.target.value = qty.value;
}

async function submit() {
    if (busy.value || props.disabled) return;
    busy.value = true;
    try {
        const response = await addToCart(props.productId, qty.value);
        if (response?.status === true) {
            cartQty.value = Number(response.product_quantity ?? cartQty.value + qty.value);
            justAdded.value = true;
            clearTimeout(addedTimer);
            addedTimer = setTimeout(() => { justAdded.value = false; }, 1600);
        } else {
            notify(response?.msg, 'warning');
        }
    } catch {
        notify(window.__SF__?.t?.menuError, 'error');
    } finally {
        busy.value = false;
    }
}

/** Another control (quick view, the other rail) added the same product. */
function onCartUpdated(event) {
    const detail = event.detail ?? {};
    if (Number(detail.product_id) !== props.productId) return;
    if (detail.action === 'remove') cartQty.value = 0;
    else if (detail.product_quantity != null) cartQty.value = Number(detail.product_quantity);
}

onMounted(() => {
    qty.value = clamp(qty.value);
    document.addEventListener('sf:cart-updated', onCartUpdated);
});

onBeforeUnmount(() => {
    document.removeEventListener('sf:cart-updated', onCartUpdated);
    clearTimeout(addedTimer);
});
</script>

<template>
    <div class="mt-auto space-y-2">
        <!-- Only worth showing once the quantity is more than one pack; at the
             default it just repeats the unit price next to it. -->
        <p v-if="price > 0 && qty > step" class="flex items-baseline justify-between gap-2 text-xs text-ink-500">
            <span class="truncate">{{ labelTotal }}</span>
            <span class="shrink-0 whitespace-nowrap font-semibold text-ink-800">{{ formatted }} {{ currency }}</span>
        </p>

        <!-- In a card the row is sized by the card, not the viewport (the same
             card is 165px wide in a phone grid and 300px in a home rail), so
             the compact layout is driven by a container query in
             storefront.css: narrow cards get stepper + square icon button,
             wider ones the labelled button. -->
        <div :class="compact ? 'sf-atc' : 'flex items-stretch gap-2'">
            <div class="sf-atc-stepper flex h-10 items-stretch overflow-hidden rounded-md border border-ink-200 bg-white">
                <button
                    type="button"
                    class="flex w-9 shrink-0 items-center justify-center text-ink-500 transition-colors hover:bg-ink-100 hover:text-ink-900 disabled:opacity-40"
                    :disabled="qty <= step || disabled"
                    :aria-label="`−${step}`"
                    @click="bump(-1)"
                >
                    <SfIcon name="minus" :size="14" />
                </button>
                <input
                    :value="qty"
                    type="number"
                    inputmode="numeric"
                    class="sf-atc-input w-full min-w-[2.5rem] flex-1 border-x border-ink-200 bg-white text-center text-sm font-semibold text-ink-900 [appearance:textfield] focus:outline-none [&::-webkit-inner-spin-button]:appearance-none [&::-webkit-outer-spin-button]:appearance-none"
                    :class="compact ? '' : 'max-w-[3.5rem]'"
                    :min="step"
                    :max="stock || undefined"
                    :step="step"
                    :disabled="disabled"
                    :aria-label="labelAdd"
                    @change="onInput"
                />
                <button
                    type="button"
                    class="flex w-9 shrink-0 items-center justify-center text-ink-500 transition-colors hover:bg-ink-100 hover:text-ink-900 disabled:opacity-40"
                    :disabled="qty >= maxQty || disabled"
                    :aria-label="`+${step}`"
                    @click="bump(1)"
                >
                    <SfIcon name="plus" :size="14" />
                </button>
            </div>

            <button
                type="button"
                class="sf-atc-button sf-btn h-10 min-w-0 flex-1 px-3 text-sm"
                :class="justAdded ? 'bg-success-500 text-white' : 'bg-brand-600 text-white shadow-card hover:bg-brand-700'"
                :disabled="busy || disabled"
                :aria-label="labelAdd"
                :title="labelAdd"
                @click="submit"
            >
                <SfIcon :name="justAdded ? 'check' : busy ? 'clock' : 'cart'" :size="16" :class="{ 'animate-spin': busy }" />
                <span class="sf-atc-label truncate">{{ labelAdd }}</span>
            </button>
        </div>

        <p v-if="cartQty > 0" class="flex items-center gap-1.5 text-xs font-medium text-success-600">
            <SfIcon name="check" :size="13" />
            {{ labelInCart }} {{ cartQty }}
        </p>
    </div>
</template>
