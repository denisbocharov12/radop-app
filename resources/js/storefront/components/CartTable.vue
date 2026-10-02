<script setup>
/**
 * Basket contents.
 *
 * The legacy page changed a line by POSTing, then replacing three separate
 * regions of the document with server-rendered HTML from the same response.
 * Here the lines are component state: the server is still the authority on
 * totals (it applies per-customer discounts), but only the numbers travel.
 */
import { computed, ref } from 'vue';
import SfIcon from './SfIcon.vue';
import { notify, removeFromCart, updateCart } from '../lib/cart.js';

/** На минимуме «−» превращается в удаление строки — как в привычных корзинах. */
const atMinimum = (row) => row.qty <= Math.max(row.step, 1);

const props = defineProps({
    lines: { type: Array, default: () => [] },
    total: { type: String, default: '0,00' },
    currency: { type: String, default: 'MDL' },
    /** Order value below which checkout is blocked; 0 disables the rule. */
    minOrderSum: { type: Number, default: 0 },
    checkoutUrl: { type: String, default: '' },
    continueUrl: { type: String, default: '' },
    destroyUrl: { type: String, default: '' },
    deliveryUrl: { type: String, default: '' },
    /** Customer's personal discount in percent; prices are already reduced. */
    personalDiscount: { type: Number, default: 0 },
    authenticated: { type: Boolean, default: false },
    t: { type: Object, default: () => ({}) },
});

const rows = ref(props.lines.map((line) => ({ ...line, busy: false })));
const total = ref(props.total);

const money = new Intl.NumberFormat('ro-MD', { minimumFractionDigits: 2, maximumFractionDigits: 2 });

const totalNumber = computed(() => Number.parseFloat(String(total.value).replace(/\s/g, '').replace(',', '.')) || 0);
const belowMinimum = computed(() => props.minOrderSum > 0 && totalNumber.value < props.minOrderSum);
const remaining = computed(() => money.format(Math.max(props.minOrderSum - totalNumber.value, 0)));
const empty = computed(() => rows.value.length === 0);

function lineTotal(row) {
    return money.format(row.qty * row.price);
}

function clamp(row, value) {
    const step = Math.max(row.step, 1);
    const rounded = Math.round(value / step) * step;
    return Math.min(Math.max(rounded, step), row.stock > 0 ? row.stock : rounded);
}

async function setQty(row, value) {
    const next = clamp(row, value);
    if (next === row.qty) return;

    const previous = row.qty;
    row.qty = next;
    row.busy = true;

    try {
        const response = await updateCart(row.id, next);
        if (response?.status === true) {
            total.value = response.total ?? total.value;
        } else {
            row.qty = previous;
            notify(response?.msg, 'warning');
        }
    } catch {
        row.qty = previous;
    } finally {
        row.busy = false;
    }
}

async function remove(row) {
    row.busy = true;
    try {
        const response = await removeFromCart(row.id);
        rows.value = rows.value.filter((r) => r.id !== row.id);
        total.value = response?.total ?? total.value;
    } catch {
        row.busy = false;
    }
}
</script>

<template>
    <div v-if="empty" class="py-20 text-center">
        <SfIcon name="cart" :size="48" class="mx-auto mb-3 text-ink-500" />
        <p class="text-lg font-semibold text-ink-800">{{ t.empty }}</p>
        <a :href="continueUrl" class="sf-btn-primary mt-5 inline-flex">{{ t.continue }}</a>
    </div>

    <div v-else class="grid gap-6 lg:grid-cols-[minmax(0,1fr)_20rem] lg:items-start">
        <div class="sf-card overflow-hidden">
            <ul class="divide-y divide-ink-100">
                <li
                    v-for="row in rows"
                    :key="row.id"
                    class="grid grid-cols-[4rem_minmax(0,1fr)_auto] items-center gap-x-3 gap-y-2 p-3 transition-opacity sm:grid-cols-[4rem_minmax(0,1fr)_7rem_7rem_2.25rem] sm:gap-x-4"
                    :class="{ 'opacity-50': row.busy }"
                >
                    <a :href="row.url" class="col-start-1 row-span-2 row-start-1 h-16 w-16 shrink-0 rounded-md border border-ink-100 p-1 sm:row-span-1">
                        <img v-if="row.image" :src="row.image" :alt="row.title" class="h-full w-full object-contain" loading="lazy" />
                        <span v-else class="flex h-full w-full items-center justify-center text-ink-500">
                            <SfIcon name="box" :size="22" />
                        </span>
                    </a>

                    <div class="col-span-2 col-start-2 row-start-1 min-w-0 sm:col-span-1 sm:col-start-2">
                        <a :href="row.url" class="line-clamp-2 text-sm font-medium text-ink-800 hover:text-brand-600">
                            {{ row.title }}
                        </a>
                        <p class="mt-0.5 text-2xs text-ink-500">{{ t.code }}: {{ row.code }}</p>
                    </div>

                    <div class="col-start-2 row-start-2 flex w-[7rem] items-stretch overflow-hidden rounded-md border border-ink-200 sm:col-start-3 sm:row-start-1 sm:w-full">
                        <button
                            type="button"
                            class="px-2 transition-colors disabled:opacity-40"
                            :class="atMinimum(row) ? 'text-danger-600 hover:bg-danger-50' : 'text-ink-500 hover:bg-ink-100'"
                            :disabled="row.busy"
                            :aria-label="atMinimum(row) ? t.remove : $sf.t.qtyDecrease"
                            :title="atMinimum(row) ? t.remove : $sf.t.qtyDecrease"
                            @click="atMinimum(row) ? remove(row) : setQty(row, row.qty - row.step)"
                        >
                            <SfIcon :name="atMinimum(row) ? 'trash' : 'minus'" :size="14" />
                        </button>
                        <input
                            :value="row.qty"
                            type="number"
                            inputmode="numeric"
                            class="w-10 min-w-0 flex-1 border-x border-ink-200 px-0 text-center font-num text-sm font-semibold [appearance:textfield] focus:outline-none [&::-webkit-inner-spin-button]:appearance-none [&::-webkit-outer-spin-button]:appearance-none"
                            :min="row.step"
                            :max="row.stock || undefined"
                            :step="row.step"
                            @change="setQty(row, Number.parseInt($event.target.value, 10) || row.step)"
                        />
                        <button
                            type="button"
                            class="px-2 text-ink-500 hover:bg-ink-100 disabled:opacity-40"
                            :disabled="row.busy || (row.stock > 0 && row.qty >= row.stock)"
                            :aria-label="$sf.t.qtyIncrease"
                            :title="$sf.t.qtyIncrease"
                            @click="setQty(row, row.qty + row.step)"
                        >
                            <SfIcon name="plus" :size="14" />
                        </button>
                    </div>

                    <p class="col-start-3 row-start-2 whitespace-nowrap text-right font-num text-sm font-bold text-ink-900 sm:col-start-4 sm:row-start-1">
                        {{ lineTotal(row) }} <span class="text-2xs font-normal text-ink-500">{{ currency }}</span>
                    </p>

                    <button
                        v-if="!atMinimum(row)"
                        type="button"
                        class="hidden h-8 w-8 shrink-0 sf-icon-btn hover:text-danger-600 sm:col-start-5 sm:row-start-1 sm:inline-flex"
                        :disabled="row.busy"
                        :aria-label="t.remove"
                        @click="remove(row)"
                    >
                        <SfIcon name="trash" :size="16" />
                    </button>
                    <span v-else class="hidden h-8 w-8 sm:col-start-5 sm:row-start-1 sm:block" aria-hidden="true"></span>
                </li>
            </ul>

            <div class="border-t border-ink-100 p-3">
                <a :href="destroyUrl" class="text-xs text-ink-500 hover:text-danger-600">{{ t.destroy }}</a>
            </div>
        </div>

        <aside class="sf-card sticky top-24 space-y-4 p-4">
            <h2 class="text-md font-bold text-ink-900">{{ t.payable }}</h2>

            <dl class="space-y-2 text-sm">
                <div class="flex justify-between">
                    <dt class="text-ink-500">{{ t.quantity }}</dt>
                    <dd class="font-medium text-ink-800">{{ rows.length }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-ink-500">{{ t.summary }}</dt>
                    <dd class="font-num font-medium text-ink-800">{{ total }} {{ currency }}</dd>
                </div>
            </dl>

            <p v-if="personalDiscount > 0" class="flex items-start gap-2 rounded-md bg-brand-50 p-2.5 text-xs text-brand-700">
                <SfIcon name="star" :size="14" class="mt-0.5 shrink-0" style="fill: currentColor" />
                <span><b>{{ t.personalPrice }} −{{ personalDiscount }}%.</b> {{ t.yourDiscount }}</span>
            </p>

            <div class="flex items-baseline justify-between border-t border-ink-100 pt-3">
                <span class="text-sm font-semibold text-ink-700">{{ t.forPayment }}</span>
                <span class="font-num text-xl font-bold text-ink-900">{{ total }} {{ currency }}</span>
            </div>

            <!-- Minimum order: how much is missing, not just the threshold
                 (ported from upstream's cart banner). -->
            <div v-if="belowMinimum" class="flex gap-2.5 rounded-lg border border-accent-200 bg-accent-50 p-3 text-xs text-accent-800" role="alert">
                <SfIcon name="info" :size="16" class="mt-0.5 shrink-0" />
                <div class="space-y-1">
                    <p>{{ t.minOrder }} <b>{{ money.format(minOrderSum) }} {{ currency }}</b></p>
                    <p class="font-semibold">{{ t.minOrderAddMore }} {{ remaining }} {{ currency }}</p>
                    <a v-if="deliveryUrl" :href="deliveryUrl" class="inline-block underline underline-offset-2 hover:text-accent-900">{{ t.deliveryLink }}</a>
                </div>
            </div>

            <a
                v-if="!belowMinimum"
                :href="authenticated ? checkoutUrl : 'javascript:;'"
                :class="['sf-btn-primary sf-btn-block sf-btn-lg', { 'cart-auth-modal-btn': !authenticated }]"
            >{{ t.checkout }}</a>

            <a :href="continueUrl" class="sf-btn-secondary sf-btn-block">{{ t.continue }}</a>
        </aside>
    </div>
</template>
