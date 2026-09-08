<script setup>
/**
 * Sign-in / password-recovery dialog.
 *
 * Replaces a Fancybox-hosted markup blob that duplicated its whole body for the
 * logged-in and anonymous cases, nested a second modal inside the first, and
 * toggled password visibility by swapping between two <input> elements with the
 * same `name` — a pattern that submits whichever one is visible.
 *
 * The forms still POST normally, so server-side validation and flash errors
 * keep working; only presentation moved.
 */
import { onBeforeUnmount, onMounted, ref, watch } from 'vue';
import SfIcon from './SfIcon.vue';

const props = defineProps({
    loginAction: { type: String, required: true },
    forgotAction: { type: String, required: true },
    registerUrl: { type: String, required: true },
    logo: { type: String, default: '' },
    csrf: { type: String, default: '' },
    t: { type: Object, default: () => ({}) },
});

const open = ref(false);
const view = ref('login');
const revealed = ref(false);
const dialogEl = ref(null);

function show(next = 'login') {
    view.value = next;
    open.value = true;
}

function close() {
    open.value = false;
}

function onDocumentClick(event) {
    // Any control on the page can request the dialog.
    const trigger = event.target.closest('[data-sf-auth-open], .cart-auth-modal-btn');
    if (!trigger) return;
    event.preventDefault();
    show(trigger.dataset.sfAuthOpen === 'forgot' ? 'forgot' : 'login');
}

function onKeydown(event) {
    if (event.key === 'Escape' && open.value) close();
}

watch(open, (isOpen) => {
    document.body.style.overflow = isOpen ? 'hidden' : '';
    if (isOpen) {
        requestAnimationFrame(() => dialogEl.value?.querySelector('input')?.focus());
    }
});

onMounted(() => {
    document.addEventListener('click', onDocumentClick);
    document.addEventListener('keydown', onKeydown);
});

onBeforeUnmount(() => {
    document.removeEventListener('click', onDocumentClick);
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
                class="fixed inset-0 z-modal flex items-start justify-center overflow-y-auto bg-ink-900/50 p-4 pt-[10vh] backdrop-blur-[2px]"
                @click.self="close"
            >
                <div
                    ref="dialogEl"
                    class="w-full max-w-sm rounded-xl bg-white p-6 shadow-pop"
                    role="dialog"
                    aria-modal="true"
                >
                    <button
                        type="button"
                        class="sf-icon-btn -mr-2 -mt-2 ml-auto"
                        :aria-label="t.close"
                        @click="close"
                    >
                        <SfIcon name="close" />
                    </button>

                    <img v-if="logo" :src="logo" alt="Radop" class="mx-auto mb-4 h-12 w-auto" />

                    <!-- Sign in -->
                    <template v-if="view === 'login'">
                        <h2 class="mb-5 text-center text-lg font-bold text-ink-900">{{ t.signIn }}</h2>

                        <form :action="loginAction" method="POST" class="space-y-3">
                            <input type="hidden" name="_token" :value="csrf" />

                            <label class="block">
                                <span class="sf-label">Email</span>
                                <input type="text" name="username" required autocomplete="username" class="sf-field" />
                            </label>

                            <label class="block">
                                <span class="sf-label">{{ t.password }}</span>
                                <span class="relative block">
                                    <input
                                        :type="revealed ? 'text' : 'password'"
                                        name="password"
                                        required
                                        autocomplete="current-password"
                                        class="sf-field pr-10"
                                    />
                                    <button
                                        type="button"
                                        class="absolute right-2 top-1/2 -translate-y-1/2 p-1 text-ink-400 hover:text-ink-700"
                                        :aria-label="t.password"
                                        :aria-pressed="revealed"
                                        @click="revealed = !revealed"
                                    >
                                        <SfIcon :name="revealed ? 'eyeOff' : 'eye'" :size="16" />
                                    </button>
                                </span>
                            </label>

                            <button type="submit" class="sf-btn-primary sf-btn-block sf-btn-lg">{{ t.enter }}</button>
                        </form>

                        <div class="my-4 flex items-center gap-3 text-xs text-ink-400">
                            <span class="h-px flex-1 bg-ink-200"></span>{{ t.or }}<span class="h-px flex-1 bg-ink-200"></span>
                        </div>

                        <a :href="registerUrl" class="sf-btn-secondary sf-btn-block">{{ t.register }}</a>

                        <button
                            type="button"
                            class="mx-auto mt-4 block text-xs text-ink-500 hover:text-brand-600"
                            @click="view = 'forgot'"
                        >{{ t.forgot }}</button>
                    </template>

                    <!-- Password recovery -->
                    <template v-else>
                        <h2 class="mb-2 text-center text-lg font-bold text-ink-900">{{ t.recovery }}</h2>
                        <p class="mb-5 text-center text-sm text-ink-500">{{ t.recoveryHint }}</p>

                        <form :action="forgotAction" method="POST" class="space-y-3">
                            <input type="hidden" name="_token" :value="csrf" />
                            <label class="block">
                                <span class="sf-label">Email</span>
                                <input type="email" name="email" required autocomplete="email" class="sf-field" />
                            </label>
                            <button type="submit" class="sf-btn-primary sf-btn-block sf-btn-lg">{{ t.send }}</button>
                        </form>

                        <button
                            type="button"
                            class="mx-auto mt-4 block text-xs text-ink-500 hover:text-brand-600"
                            @click="view = 'login'"
                        >{{ t.signIn }}</button>
                    </template>
                </div>
            </div>
        </Transition>
    </Teleport>
</template>
