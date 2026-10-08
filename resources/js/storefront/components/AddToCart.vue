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
import { addToCart, notify, removeFromCart } from '../lib/cart.js';

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
    labelRemove: { type: String, default: 'Remove' },
    labelTotal: { type: String, default: 'Total' },
    disabled: { type: Boolean, default: false },
    compact: { type: Boolean, default: false },
});

const qty = ref(Math.max(props.step, 1));
const cartQty = ref(props.inCart);
const busy = ref(false);
const justAdded = ref(false);
/* ТЗ 67: короткое предупреждение прямо у счётчика вместо большого уведомления. */
const hint = ref('');
let hintTimer = null;

let addedTimer = null;

/** Оставляем одну строку: «Минимальный заказ: 10 шт.» вместо абзаца текста. */
function showHint(message) {
    const text = String(message ?? '').replace(/\s+/g, ' ').trim();
    hint.value = text.length > 80 ? `${text.slice(0, 77)}…` : text;
    clearTimeout(hintTimer);
    hintTimer = setTimeout(() => { hint.value = ''; }, 4000);
}

const step = computed(() => Math.max(props.step, 1));
const maxQty = computed(() => (props.stock > 0 ? props.stock : Number.MAX_SAFE_INTEGER));
const lineTotal = computed(() => qty.value * props.price);
/* Товар уже в корзине и количество на минимуме — «−» становится удалением. */
const showRemove = computed(() => cartQty.value > 0 && qty.value <= step.value);

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

async function removeLine() {
    if (busy.value) return;
    busy.value = true;
    try {
        const response = await removeFromCart(props.productId);
        if (response?.status === true) cartQty.value = 0;
        else notify(response?.msg, 'warning');
    } catch {
        notify(window.__SF__?.t?.menuError, 'error');
    } finally {
        busy.value = false;
    }
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
            showHint(response?.msg);
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
    clearTimeout(hintTimer);
});
</script>

<template>
    <div class="mt-auto space-y-2">
        <!-- Одна строка постоянной высоты над счётчиком: пока набрана одна
             упаковка, она пустая, дальше показывает сумму, а для товара,
             который уже в корзине, — отметку. Высота карточки от этого не
             меняется, и ряд не прыгает от «+» и «−». -->
        <p class="flex h-5 items-center justify-between gap-2 text-xs" aria-live="polite">
            <template v-if="price > 0 && qty > step">
                <span class="truncate text-ink-500">{{ labelTotal }}</span>
                <span class="shrink-0 whitespace-nowrap font-medium text-ink-800">{{ formatted }} {{ currency }}</span>
            </template>
            <span v-else-if="cartQty > 0" class="flex items-center gap-1.5 font-medium text-success-600">
                <SfIcon name="check" :size="13" />
                {{ labelInCart }} {{ cartQty }}
            </span>
        </p>

        <!-- ТЗ 67: подсказка висит над счётчиком и уходит сама. -->
        <Transition
            enter-active-class="transition duration-150 ease-sf"
            enter-from-class="translate-y-1 opacity-0"
            leave-active-class="transition duration-150"
            leave-to-class="opacity-0"
        >
            <p
                v-if="hint"
                class="rounded-md border border-accent-200 bg-accent-50 px-2 py-1 text-2xs leading-4 text-accent-800"
                role="status"
            >{{ hint }}</p>
        </Transition>

        <!-- In a card the row is sized by the card, not the viewport (the same
             card is 165px wide in a phone grid and 300px in a home rail), so
             the compact layout is driven by a container query in
             storefront.css: narrow cards get stepper + square icon button,
             wider ones the labelled button. -->
        <div :class="compact ? 'sf-atc' : 'flex items-stretch gap-2'">
            <div
                class="sf-atc-stepper flex items-stretch overflow-hidden rounded-md border border-ink-200 bg-white"
                :class="compact ? 'h-10' : 'h-12'"
            >
                <button
                    type="button"
                    class="flex w-9 shrink-0 items-center justify-center transition-colors disabled:opacity-40"
                    :class="showRemove ? 'text-danger-600 hover:bg-danger-50' : 'text-ink-500 hover:bg-ink-100 hover:text-ink-900'"
                    :disabled="disabled || busy || (!showRemove && qty <= step)"
                    :aria-label="showRemove ? labelRemove : $sf.t.qtyDecrease"
                    :title="showRemove ? labelRemove : $sf.t.qtyDecrease"
                    @click="showRemove ? removeLine() : bump(-1)"
                >
                    <SfIcon :name="showRemove ? 'trash' : 'minus'" :size="14" />
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
                    :aria-label="$sf.t.qtyIncrease"
                    :title="$sf.t.qtyIncrease"
                    @click="bump(1)"
                >
                    <SfIcon name="plus" :size="14" />
                </button>
            </div>

            <button
                type="button"
                class="sf-atc-button sf-btn min-w-0 flex-1 px-3"
                :class="[
                    compact ? 'h-10 text-sm' : 'h-12 text-md font-semibold',
                    justAdded ? 'bg-success-600 text-white' : 'bg-brand-600 text-white shadow-card hover:bg-brand-700',
                ]"
                :disabled="busy || disabled"
                :aria-label="disabled ? $sf.t.outOfStock : labelAdd"
                :title="disabled ? $sf.t.outOfStock : labelAdd"
                @click="submit"
            >
                <SfIcon :name="justAdded ? 'check' : busy ? 'clock' : 'cart'" :size="16" :class="{ 'animate-spin': busy }" />
                <span class="sf-atc-label truncate">{{ labelAdd }}</span>
            </button>
        </div>
    </div>
</template>
