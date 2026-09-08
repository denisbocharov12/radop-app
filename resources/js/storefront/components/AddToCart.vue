<script setup>
/**
 * Quantity stepper + add-to-cart button for one product card.
 *
 * Replaces the legacy pairing of `add_to_cart_widget_v2.blade.php` and the
 * delegated jQuery handlers in scripts.blade.php, which addressed inputs by
 * `name="product-{id}-qty"` and re-rendered the header by injecting server
 * HTML. Here the component owns its own quantity and the header listens for
 * one `sf:cart-updated` event.
 */
import { computed, onMounted, ref } from 'vue';
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
});

const qty = ref(Math.max(props.step, 1));
const cartQty = ref(props.inCart);
const busy = ref(false);

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
}

async function submit() {
    if (busy.value || props.disabled) return;
    busy.value = true;
    try {
        const response = await addToCart(props.productId, qty.value);
        if (response?.status === true) {
            cartQty.value = Number(response.product_quantity ?? cartQty.value + qty.value);
            notify(response.msg, 'success');
        } else {
            notify(response?.msg, 'warning');
        }
    } catch {
        notify(null);
    } finally {
        busy.value = false;
    }
}

onMounted(() => {
    qty.value = clamp(qty.value);
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

        <div class="flex items-stretch gap-2">
            <div class="flex items-stretch overflow-hidden rounded-md border border-ink-200">
                <button
                    type="button"
                    class="px-2 text-ink-500 transition-colors hover:bg-ink-100 hover:text-ink-900 disabled:opacity-40"
                    :disabled="qty <= step"
                    :aria-label="'-' + step"
                    @click="bump(-1)"
                >
                    <SfIcon name="minus" :size="14" />
                </button>
                <input
                    :value="qty"
                    type="number"
                    inputmode="numeric"
                    class="w-11 border-x border-ink-200 bg-white text-center text-sm font-semibold text-ink-900 focus:outline-none"
                    :min="step"
                    :max="stock || undefined"
                    :step="step"
                    @change="onInput"
                />
                <button
                    type="button"
                    class="px-2 text-ink-500 transition-colors hover:bg-ink-100 hover:text-ink-900 disabled:opacity-40"
                    :disabled="qty >= maxQty"
                    :aria-label="'+' + step"
                    @click="bump(1)"
                >
                    <SfIcon name="plus" :size="14" />
                </button>
            </div>

            <button
                type="button"
                class="sf-btn-primary sf-btn-sm flex-1"
                :disabled="busy || disabled"
                @click="submit"
            >
                <SfIcon :name="busy ? 'clock' : 'cart'" :size="15" />
                <span class="truncate">{{ labelAdd }}</span>
            </button>
        </div>

        <p v-if="cartQty > 0" class="flex items-center gap-1.5 text-xs font-medium text-success-600">
            <SfIcon name="check" :size="13" />
            {{ labelInCart }} {{ cartQty }}
        </p>
    </div>
</template>
