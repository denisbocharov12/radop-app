<script setup>
/**
 * Sign-in / password-recovery dialog.
 *
 * Both requests go over fetch because the server requires it: the login
 * action throws NotAjaxRequestException for a plain form POST and answers
 * `{status: bool}` as JSON. Failures are shown inside the dialog so the visitor
 * can retry without it closing — the same behaviour upstream added to the
 * Fancybox modal this replaces.
 */
import { nextTick, onBeforeUnmount, onMounted, ref, watch } from 'vue';
import SfIcon from './SfIcon.vue';
import { csrf } from '../lib/cart.js';

const props = defineProps({
    loginAction: { type: String, required: true },
    forgotAction: { type: String, required: true },
    registerUrl: { type: String, required: true },
    redirectUrl: { type: String, default: '/orders' },
    logo: { type: String, default: '' },
    t: { type: Object, default: () => ({}) },
});

const open = ref(false);
const view = ref('login');
const revealed = ref(false);
const busy = ref(false);
const error = ref('');
const success = ref('');
const dialogEl = ref(null);

const login = ref({ username: '', password: '' });
const forgotEmail = ref('');

let lastFocus = null;

function show(next = 'login') {
    lastFocus = document.activeElement;
    view.value = next;
    error.value = '';
    success.value = '';
    open.value = true;
}

function close() {
    open.value = false;
    lastFocus?.focus?.();
}

function switchTo(next) {
    view.value = next;
    error.value = '';
    success.value = '';
    nextTick(focusFirst);
}

function focusFirst() {
    dialogEl.value?.querySelector('input:not([type=hidden])')?.focus();
}

async function submitLogin() {
    if (busy.value) return;
    busy.value = true;
    error.value = '';

    const body = new FormData();
    body.append('_token', csrf());
    body.append('username', login.value.username);
    body.append('password', login.value.password);

    try {
        const res = await fetch(props.loginAction, {
            method: 'POST',
            body,
            credentials: 'same-origin',
            headers: { Accept: 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
        });
        const data = await res.json().catch(() => ({}));

        if (!res.ok || !data.status) {
            error.value = props.t.loginError;
            login.value.password = '';
            return;
        }

        const keys = window.radopAnalyticsJsonPayloadKeys ?? {};
        const events = window.radopAnalyticsDataLayerEventNames ?? {};
        if (keys.customer_account_login_succeeded && data[keys.customer_account_login_succeeded]
            && typeof window.radopGa4EventPush === 'function') {
            window.radopGa4EventPush(events.customer_account_login_succeeded, data[keys.customer_account_login_succeeded]);
        }

        window.location.assign(props.redirectUrl);
    } catch {
        error.value = props.t.genericError;
    } finally {
        busy.value = false;
    }
}

async function submitForgot() {
    if (busy.value) return;
    busy.value = true;
    error.value = '';
    success.value = '';

    const body = new FormData();
    body.append('_token', csrf());
    body.append('email', forgotEmail.value);

    try {
        // The action redirects on success, so any 2xx after the redirect is a
        // success; validation failures (unknown e-mail) come back as 422 JSON.
        const res = await fetch(props.forgotAction, {
            method: 'POST',
            body,
            credentials: 'same-origin',
            headers: { Accept: 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
        });

        if (res.ok) {
            success.value = props.t.recoverySent;
            forgotEmail.value = '';
            return;
        }

        const data = await res.json().catch(() => ({}));
        error.value = data?.errors ? Object.values(data.errors).flat()[0] : (data?.message || props.t.genericError);
    } catch {
        error.value = props.t.genericError;
    } finally {
        busy.value = false;
    }
}

function onDocumentClick(event) {
    const trigger = event.target.closest('[data-sf-auth-open], .cart-auth-modal-btn');
    if (!trigger) return;
    event.preventDefault();
    show(trigger.dataset.sfAuthOpen === 'forgot' ? 'forgot' : 'login');
}

function onKeydown(event) {
    if (!open.value) return;
    if (event.key === 'Escape') {
        close();
        return;
    }
    // Keep Tab inside the dialog.
    if (event.key === 'Tab' && dialogEl.value) {
        const focusable = [...dialogEl.value.querySelectorAll('a[href], button:not([disabled]), input:not([type=hidden])')];
        if (!focusable.length) return;
        const first = focusable[0];
        const last = focusable[focusable.length - 1];
        if (event.shiftKey && document.activeElement === first) {
            event.preventDefault();
            last.focus();
        } else if (!event.shiftKey && document.activeElement === last) {
            event.preventDefault();
            first.focus();
        }
    }
}

watch(open, (isOpen) => {
    document.body.style.overflow = isOpen ? 'hidden' : '';
    if (isOpen) nextTick(focusFirst);
});

onMounted(() => {
    document.addEventListener('click', onDocumentClick);
    document.addEventListener('keydown', onKeydown);
    // Deep link: /?auth=login opens the dialog (used by guarded pages).
    const params = new URLSearchParams(window.location.search);
    if (params.get('auth') === 'login' || params.get('auth') === 'forgot') show(params.get('auth'));
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
                class="fixed inset-0 z-modal flex items-end justify-center bg-ink-900/50 backdrop-blur-[2px] sm:items-start sm:overflow-y-auto sm:p-4 sm:pt-[10vh]"
                @click.self="close"
            >
                <div
                    ref="dialogEl"
                    class="relative w-full rounded-t-2xl bg-white p-6 pb-[max(1.5rem,env(safe-area-inset-bottom))] shadow-pop sm:max-w-sm sm:rounded-xl sm:pb-6"
                    role="dialog"
                    aria-modal="true"
                    :aria-label="view === 'login' ? t.signIn : t.recovery"
                >
                    <!-- Grab handle hints the sheet can be dismissed on phones -->
                    <span class="mx-auto -mt-2 mb-3 block h-1 w-10 rounded-full bg-ink-200 sm:hidden"></span>

                    <button
                        type="button"
                        class="sf-icon-btn absolute right-3 top-3"
                        :aria-label="t.close"
                        @click="close"
                    >
                        <SfIcon name="close" />
                    </button>

                    <img v-if="logo" :src="logo" alt="Radop" class="mx-auto mb-3 h-12 w-auto" />

                    <p
                        v-if="error"
                        class="mb-4 flex items-start gap-2 rounded-lg bg-danger-50 p-3 text-sm text-danger-600"
                        role="alert"
                    >
                        <SfIcon name="info" :size="16" class="mt-0.5" />
                        <span>{{ error }}</span>
                    </p>

                    <p
                        v-if="success"
                        class="mb-4 flex items-start gap-2 rounded-lg bg-success-50 p-3 text-sm text-success-600"
                        role="status"
                    >
                        <SfIcon name="check" :size="16" class="mt-0.5" />
                        <span>{{ success }}</span>
                    </p>

                    <!-- Sign in -->
                    <template v-if="view === 'login'">
                        <h2 class="mb-5 text-center text-lg font-bold text-ink-900">{{ t.signIn }}</h2>

                        <form class="space-y-3" novalidate @submit.prevent="submitLogin">
                            <label class="block">
                                <span class="sf-label">Email</span>
                                <input
                                    v-model.trim="login.username"
                                    type="email"
                                    inputmode="email"
                                    name="username"
                                    required
                                    autocomplete="username"
                                    class="sf-field h-11"
                                    :class="{ 'sf-field-error': error }"
                                />
                            </label>

                            <label class="block">
                                <span class="flex items-baseline justify-between">
                                    <span class="sf-label">{{ t.password }}</span>
                                    <button
                                        type="button"
                                        class="text-xs font-medium text-brand-600 hover:text-brand-700"
                                        @click="switchTo('forgot')"
                                    >{{ t.forgot }}</button>
                                </span>
                                <span class="relative block">
                                    <input
                                        v-model="login.password"
                                        :type="revealed ? 'text' : 'password'"
                                        name="password"
                                        required
                                        autocomplete="current-password"
                                        class="sf-field h-11 pr-11"
                                        :class="{ 'sf-field-error': error }"
                                    />
                                    <button
                                        type="button"
                                        class="absolute right-1 top-1/2 flex h-9 w-9 -translate-y-1/2 items-center justify-center text-ink-400 hover:text-ink-700"
                                        :aria-label="t.password"
                                        :aria-pressed="revealed"
                                        @click="revealed = !revealed"
                                    >
                                        <SfIcon :name="revealed ? 'eyeOff' : 'eye'" :size="17" />
                                    </button>
                                </span>
                            </label>

                            <button
                                type="submit"
                                class="sf-btn-primary sf-btn-block sf-btn-lg"
                                :disabled="busy || !login.username || !login.password"
                            >
                                <SfIcon v-if="busy" name="clock" :size="17" class="animate-spin" />
                                {{ t.enter }}
                            </button>
                        </form>

                        <div class="my-4 flex items-center gap-3 text-xs text-ink-400">
                            <span class="h-px flex-1 bg-ink-200"></span>{{ t.or }}<span class="h-px flex-1 bg-ink-200"></span>
                        </div>

                        <a :href="registerUrl" class="sf-btn-secondary sf-btn-block">{{ t.register }}</a>
                    </template>

                    <!-- Password recovery -->
                    <template v-else>
                        <h2 class="mb-2 text-center text-lg font-bold text-ink-900">{{ t.recovery }}</h2>
                        <p class="mb-5 text-center text-sm text-ink-500">{{ t.recoveryHint }}</p>

                        <form class="space-y-3" @submit.prevent="submitForgot">
                            <label class="block">
                                <span class="sf-label">Email</span>
                                <input
                                    v-model.trim="forgotEmail"
                                    type="email"
                                    inputmode="email"
                                    name="email"
                                    required
                                    autocomplete="email"
                                    class="sf-field h-11"
                                />
                            </label>
                            <button type="submit" class="sf-btn-primary sf-btn-block sf-btn-lg" :disabled="busy || !forgotEmail">
                                {{ t.send }}
                            </button>
                        </form>

                        <button
                            type="button"
                            class="mx-auto mt-4 flex items-center gap-1 text-sm text-ink-500 hover:text-brand-600"
                            @click="switchTo('login')"
                        >
                            <SfIcon name="chevronLeft" :size="15" />{{ t.signIn }}
                        </button>
                    </template>
                </div>
            </div>
        </Transition>
    </Teleport>
</template>
