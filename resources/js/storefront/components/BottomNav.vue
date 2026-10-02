<script setup>
/**
 * Mobile tab bar (below `lg`).
 *
 * The five destinations a phone shopper reaches for most, under the thumb:
 * home, the catalogue drawer, favourites, the basket and the account. Signed-in
 * customers had no route to their orders on mobile at all — the header account
 * menu is desktop-only — and this is where they find it now.
 */
import { computed, onBeforeUnmount, onMounted, ref } from 'vue';
import SfIcon from './SfIcon.vue';
import { route } from '../lib/cart.js';

const props = defineProps({
    homeUrl: { type: String, required: true },
    wishlistUrl: { type: String, required: true },
    accountUrl: { type: String, required: true },
    authenticated: { type: Boolean, default: false },
    cartCount: { type: Number, default: 0 },
    wishlistCount: { type: Number, default: 0 },
    /** Which tab the current page belongs to: home|wishlist|cart|account. */
    active: { type: String, default: '' },
    t: { type: Object, default: () => ({}) },
});

const cartCount = ref(props.cartCount);
const wishlistCount = ref(props.wishlistCount);
const drawerOpen = ref(false);

const badge = (n) => (n > 99 ? '99+' : String(n));

const tabClass = (key) => [
    'relative flex min-w-0 flex-1 flex-col items-center justify-center gap-0.5 pt-1.5 text-2xs font-medium transition-colors',
    (props.active === key && !drawerOpen.value) || (key === 'catalog' && drawerOpen.value)
        ? 'text-brand-600'
        : 'text-ink-500 active:text-ink-800',
];

function openCatalog() {
    document.dispatchEvent(new CustomEvent('sf:open-mobile-nav'));
}

function onCart(event) {
    // `cart_count` arrives pluralised for display ("3 produse").
    const n = Number.parseInt(String(event.detail?.cart_count ?? '').replace(/\D+/g, ''), 10);
    if (!Number.isNaN(n)) cartCount.value = n;
}

function onWishlist(event) {
    if (typeof event.detail?.count === 'number') wishlistCount.value = event.detail.count;
}

function onDrawer(event) {
    drawerOpen.value = Boolean(event.detail?.open);
}

onMounted(() => {
    document.addEventListener('sf:cart-updated', onCart);
    document.addEventListener('sf:wishlist-updated', onWishlist);
    document.addEventListener('sf:mobile-nav-state', onDrawer);
});

onBeforeUnmount(() => {
    document.removeEventListener('sf:cart-updated', onCart);
    document.removeEventListener('sf:wishlist-updated', onWishlist);
    document.removeEventListener('sf:mobile-nav-state', onDrawer);
});

const accountAttrs = computed(() => (props.authenticated
    ? { href: props.accountUrl }
    : { href: 'javascript:;', 'data-sf-auth-open': '' }));
</script>

<template>
    <nav
        class="fixed inset-x-0 bottom-0 z-header border-t border-ink-200 bg-white/95 pb-[env(safe-area-inset-bottom)] backdrop-blur supports-[backdrop-filter]:bg-white/85 lg:hidden"
        :aria-label="t.menu"
    >
        <div class="mx-auto flex h-14 max-w-lg items-stretch">
            <a :href="homeUrl" :class="tabClass('home')" :aria-current="active === 'home' ? 'page' : null">
                <SfIcon name="home" :size="22" />
                <span class="truncate">{{ t.home }}</span>
            </a>

            <button type="button" :class="tabClass('catalog')" :aria-expanded="drawerOpen" @click="openCatalog">
                <SfIcon name="grid" :size="22" />
                <span class="truncate">{{ t.catalog }}</span>
            </button>

            <a :href="wishlistUrl" :class="tabClass('wishlist')" :aria-current="active === 'wishlist' ? 'page' : null">
                <span class="relative">
                    <SfIcon name="heart" :size="22" />
                    <span
                        v-if="wishlistCount > 0"
                        class="absolute -right-2.5 -top-1.5 flex h-4 min-w-[1rem] items-center justify-center rounded-full bg-danger-600 px-1 text-2xs font-bold leading-none text-white"
                    >{{ badge(wishlistCount) }}</span>
                </span>
                <span class="truncate">{{ t.wishlist }}</span>
            </a>

            <a :href="route('cart', '/cart')" :class="tabClass('cart')" :aria-current="active === 'cart' ? 'page' : null">
                <span class="relative">
                    <SfIcon name="cart" :size="22" />
                    <span
                        v-if="cartCount > 0"
                        class="absolute -right-2.5 -top-1.5 flex h-4 min-w-[1rem] items-center justify-center rounded-full bg-accent-700 px-1 text-2xs font-bold leading-none text-white"
                    >{{ badge(cartCount) }}</span>
                </span>
                <span class="truncate">{{ t.cart }}</span>
            </a>

            <a v-bind="accountAttrs" :class="tabClass('account')" :aria-current="active === 'account' ? 'page' : null">
                <SfIcon name="user" :size="22" />
                <span class="truncate">{{ authenticated ? t.account : t.signIn }}</span>
            </a>
        </div>
    </nav>
</template>
