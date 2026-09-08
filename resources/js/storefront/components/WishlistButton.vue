<script setup>
/**
 * Favourite toggle on a product card. Optimistic: the heart fills immediately
 * and reverts if the request fails, because the round trip is otherwise long
 * enough for people to tap it twice.
 */
import { ref } from 'vue';
import SfIcon from './SfIcon.vue';
import { notify } from '../lib/cart.js';

const props = defineProps({
    productId: { type: Number, required: true },
    active: { type: Boolean, default: false },
    labelAdd: { type: String, default: '' },
    labelRemove: { type: String, default: '' },
});

const on = ref(props.active);
const busy = ref(false);

async function toggle() {
    if (busy.value) return;
    const previous = on.value;
    on.value = !previous;
    busy.value = true;

    try {
        const res = await fetch(previous ? '/wishlist/deleteFromWishList' : '/wishlist/addToWishList', {
            method: 'POST',
            credentials: 'same-origin',
            headers: {
                Accept: 'application/json',
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content ?? '',
            },
            body: JSON.stringify({ product_id: props.productId, id: props.productId, qty: 1 }),
        });
        if (!res.ok) throw new Error(`HTTP ${res.status}`);
        const body = await res.json().catch(() => ({}));
        notify(body?.msg, previous ? 'info' : 'success');
    } catch {
        on.value = previous;
    } finally {
        busy.value = false;
    }
}
</script>

<template>
    <button
        type="button"
        class="absolute right-2 top-2 z-10 flex h-8 w-8 items-center justify-center rounded-full bg-white/90 text-ink-400 shadow-card backdrop-blur transition-colors hover:text-danger-500"
        :class="{ 'text-danger-500': on }"
        :aria-pressed="on"
        :aria-label="on ? labelRemove : labelAdd"
        @click.prevent="toggle"
    >
        <SfIcon name="heart" :size="16" :stroke-width="on ? 2 : 1.75" :style="on ? { fill: 'currentColor' } : null" />
    </button>
</template>
