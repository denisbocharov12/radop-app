<script setup>
/**
 * Favourite toggle on a product card. Optimistic: the heart fills immediately
 * and reverts if the request fails, because the round trip is otherwise long
 * enough for people to tap it twice.
 *
 * Every instance for the same product stays in sync (a product can appear in
 * two rails on one page), the header count updates, and the server's GA4
 * wishlist payload is pushed as the legacy handler did.
 */
import { onBeforeUnmount, onMounted, ref } from 'vue';
import SfIcon from './SfIcon.vue';
import { notify, postJson, pushEcommerce, route } from '../lib/cart.js';

const props = defineProps({
    productId: { type: Number, required: true },
    active: { type: Boolean, default: false },
    labelAdd: { type: String, default: '' },
    labelRemove: { type: String, default: '' },
    /** `overlay` sits on a card image; `inline` is a labelled button. */
    variant: { type: String, default: 'overlay' },
    /** Уменьшенный вариант: в карточке сердечко стоит у цены и не спорит с ней. */
    small: { type: Boolean, default: false },
});

const on = ref(props.active);
const busy = ref(false);

function onSync(event) {
    if (event.detail?.productId === props.productId) on.value = event.detail.active;
}

async function toggle() {
    if (busy.value) return;
    const previous = on.value;
    on.value = !previous;
    busy.value = true;

    try {
        const response = await postJson(
            previous
                ? route('wishlistRemove', '/wishlist/deleteFromWishList')
                : route('wishlistAdd', '/wishlist/addToWishList'),
            { product_id: props.productId },
        );
        if (response?.status !== true) throw new Error('rejected');

        pushEcommerce(previous ? 'wishlist_line_item_removed' : 'wishlist_line_item_added', response, {
            quantityPayload: false,
        });
        document.dispatchEvent(new CustomEvent('sf:wishlist-updated', {
            detail: { productId: props.productId, active: !previous, count: response.wishlist_count },
        }));
        notify(response.msg, previous ? 'info' : 'success');
    } catch {
        on.value = previous;
    } finally {
        busy.value = false;
    }
}

onMounted(() => document.addEventListener('sf:wishlist-updated', onSync));
onBeforeUnmount(() => document.removeEventListener('sf:wishlist-updated', onSync));
</script>

<template>
    <!-- ТЗ 58-59: в блоке покупки — только сердечко, без рамки и подписи. -->
    <button
        v-if="variant === 'icon'"
        type="button"
        class="flex shrink-0 items-center justify-center rounded-md text-ink-400 transition-colors hover:bg-ink-50 hover:text-danger-500"
        :class="[small ? 'h-8 w-8' : 'h-10 w-10', { 'text-danger-500': on }]"
        :aria-pressed="on"
        :aria-label="on ? labelRemove : labelAdd"
        :title="on ? labelRemove : labelAdd"
        @click.prevent="toggle"
    >
        <SfIcon name="heart" :size="small ? 17 : 22" :stroke-width="on ? 2 : 1.6" :style="on ? { fill: 'currentColor' } : null" />
    </button>

    <button
        v-else-if="variant === 'inline'"
        type="button"
        class="sf-btn-secondary w-full"
        :class="{ 'border-danger-500/40 text-danger-600': on }"
        :aria-pressed="on"
        @click.prevent="toggle"
    >
        <SfIcon name="heart" :size="17" :style="on ? { fill: 'currentColor' } : null" />
        {{ on ? labelRemove : labelAdd }}
    </button>

    <button
        v-else
        type="button"
        class="absolute right-2 top-2 z-10 flex h-9 w-9 items-center justify-center rounded-full bg-white/90 text-ink-400 shadow-card backdrop-blur transition-colors hover:text-danger-500"
        :class="{ 'text-danger-500': on }"
        :aria-pressed="on"
        :aria-label="on ? labelRemove : labelAdd"
        :title="on ? labelRemove : labelAdd"
        @click.prevent="toggle"
    >
        <SfIcon name="heart" :size="17" :stroke-width="on ? 2 : 1.75" :style="on ? { fill: 'currentColor' } : null" />
    </button>
</template>
