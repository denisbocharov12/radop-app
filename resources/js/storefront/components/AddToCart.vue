<script setup>
/**
 * Кнопка покупки и счётчик количества.
 *
 * Общая механика витрины: пока товара нет в корзине, видна одна кнопка
 * «Добавить». После добавления на её месте появляется счётчик строки корзины —
 * слева корзина (переход к оформлению), дальше количество и «+». Как только
 * количество больше минимального, слева встаёт «−». Количество правится и
 * руками, ноль убирает строку.
 *
 * Счётчик работает прямо по корзине: каждое изменение уходит на сервер, а
 * шапка, мини-корзина и нижняя панель слушают одно событие `sf:cart-updated`.
 *
 * `compact` — раскладка карточки товара: на узких карточках кнопка и счётчик
 * занимают всю ширину (см. контейнерные запросы в storefront.css).
 */
import { computed, onBeforeUnmount, onMounted, ref } from 'vue';
import SfIcon from './SfIcon.vue';
import { addToCart, notify, removeFromCart, route, updateCart } from '../lib/cart.js';

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

const cartQty = ref(Math.max(0, Number(props.inCart) || 0));
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
const inCartNow = computed(() => cartQty.value > 0);
/** На минимальном количестве слева стоит корзина, дальше — «−». */
const atMinimum = computed(() => cartQty.value <= step.value);
const lineTotal = computed(() => cartQty.value * props.price);
const cartUrl = computed(() => route('cart', '/cart'));

const formatted = computed(() =>
    new Intl.NumberFormat('ro-MD', { minimumFractionDigits: 2, maximumFractionDigits: 2 })
        .format(lineTotal.value));

function clamp(value) {
    const s = step.value;
    const rounded = Math.round(value / s) * s;
    return Math.min(Math.max(rounded, s), maxQty.value);
}

async function add() {
    if (busy.value || props.disabled) return;
    busy.value = true;

    try {
        const response = await addToCart(props.productId, step.value);

        if (response?.status === true) {
            cartQty.value = Number(response.product_quantity ?? step.value);
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

/** Новое количество строки корзины; ноль и меньше убирают её целиком. */
async function setQty(value) {
    if (busy.value || props.disabled) return;

    if (value < step.value) {
        await removeLine();
        return;
    }

    const next = clamp(value);
    const previous = cartQty.value;

    // Счётчик отзывается сразу, а при отказе сервера возвращается как было.
    cartQty.value = next;
    busy.value = true;

    try {
        const response = await updateCart(props.productId, next);

        if (response?.status !== true) {
            cartQty.value = previous;
            showHint(response?.msg);
        } else if (response.product_quantity != null) {
            cartQty.value = Number(response.product_quantity);
        }
    } catch {
        cartQty.value = previous;
        notify(window.__SF__?.t?.menuError, 'error');
    } finally {
        busy.value = false;
    }
}

function bump(delta) {
    setQty(cartQty.value + delta * step.value);
}

function onInput(event) {
    const parsed = Number.parseInt(event.target.value, 10);

    if (Number.isNaN(parsed) || parsed <= 0) {
        event.target.value = cartQty.value;
        setQty(0);
        return;
    }

    const next = clamp(parsed);
    event.target.value = next;
    setQty(next);
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

/** Another control (quick view, the other rail) added the same product. */
function onCartUpdated(event) {
    const detail = event.detail ?? {};
    if (Number(detail.product_id) !== props.productId) return;
    if (detail.action === 'remove') cartQty.value = 0;
    else if (detail.product_quantity != null) cartQty.value = Number(detail.product_quantity);
}

onMounted(() => document.addEventListener('sf:cart-updated', onCartUpdated));

onBeforeUnmount(() => {
    document.removeEventListener('sf:cart-updated', onCartUpdated);
    clearTimeout(addedTimer);
    clearTimeout(hintTimer);
});
</script>

<template>
    <div class="mt-auto space-y-2">
        <!-- Сумма строки нужна, когда набрано больше одной упаковки: на минимуме
             она просто повторяет цену рядом. Место под неё держим всегда —
             иначе от «+» и «−» карточка подрастает и ряд прыгает. -->
        <p
            class="flex h-5 items-baseline justify-between gap-2 text-xs text-ink-500"
            :class="{ invisible: !(price > 0 && cartQty > step) }"
            aria-hidden="true"
        >
            <span class="truncate">{{ labelTotal }}</span>
            <span class="shrink-0 whitespace-nowrap font-medium text-ink-800">{{ formatted }} {{ currency }}</span>
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

        <div :class="compact ? 'sf-atc' : 'flex items-stretch gap-2'">
            <!-- Товара ещё нет в корзине: одна кнопка на всю ширину. -->
            <button
                v-if="!inCartNow"
                type="button"
                class="sf-atc-button sf-btn w-full min-w-0 flex-1 px-3"
                :class="[
                    compact ? 'h-10 text-sm' : 'h-12 text-md font-semibold',
                    justAdded ? 'bg-success-600 text-white' : 'bg-brand-600 text-white shadow-card hover:bg-brand-700',
                ]"
                :disabled="busy || disabled"
                :aria-label="disabled ? $sf.t.outOfStock : labelAdd"
                :title="disabled ? $sf.t.outOfStock : labelAdd"
                @click="add"
            >
                <SfIcon :name="justAdded ? 'check' : busy ? 'clock' : 'plus'" :size="16" :class="{ 'animate-spin': busy }" />
                <span class="sf-atc-label truncate">{{ labelAdd }}</span>
            </button>

            <!-- Товар в корзине: счётчик правит строку корзины напрямую. -->
            <div
                v-else
                class="sf-atc-stepper flex w-full items-stretch overflow-hidden rounded-md border border-ink-200 bg-white"
                :class="compact ? 'h-10' : 'h-12'"
            >
                <a
                    v-if="atMinimum"
                    :href="cartUrl"
                    class="flex w-9 shrink-0 items-center justify-center text-brand-600 transition-colors hover:bg-brand-50"
                    :aria-label="labelInCart"
                    :title="labelInCart"
                >
                    <SfIcon name="cart" :size="15" />
                </a>
                <button
                    v-else
                    type="button"
                    class="flex w-9 shrink-0 items-center justify-center text-ink-500 transition-colors hover:bg-ink-100 hover:text-ink-900 disabled:opacity-40"
                    :disabled="busy || disabled"
                    :aria-label="$sf.t.qtyDecrease"
                    :title="$sf.t.qtyDecrease"
                    @click="bump(-1)"
                >
                    <SfIcon name="minus" :size="14" />
                </button>

                <input
                    :value="cartQty"
                    type="number"
                    inputmode="numeric"
                    class="sf-atc-input w-full min-w-[2.5rem] flex-1 border-x border-ink-200 bg-white text-center text-sm font-semibold text-ink-900 [appearance:textfield] focus:outline-none [&::-webkit-inner-spin-button]:appearance-none [&::-webkit-outer-spin-button]:appearance-none"
                    :class="compact ? '' : 'max-w-[4rem]'"
                    min="0"
                    :max="stock || undefined"
                    :step="step"
                    :disabled="disabled"
                    :aria-label="labelInCart"
                    @change="onInput"
                />

                <button
                    type="button"
                    class="flex w-9 shrink-0 items-center justify-center text-ink-500 transition-colors hover:bg-ink-100 hover:text-ink-900 disabled:opacity-40"
                    :disabled="busy || disabled || cartQty >= maxQty"
                    :aria-label="$sf.t.qtyIncrease"
                    :title="$sf.t.qtyIncrease"
                    @click="bump(1)"
                >
                    <SfIcon name="plus" :size="14" />
                </button>
            </div>
        </div>
    </div>
</template>
