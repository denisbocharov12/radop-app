<script setup>
/**
 * Product gallery: thumbnail rail, main image, and a self-contained lightbox.
 *
 * Replaces two Slick instances plus Fancybox (a third-party CDN stylesheet and
 * script) with ~120 lines. Zoom is a plain full-screen overlay with arrow and
 * Escape keys, which is all the previous lightbox was actually used for.
 */
import { computed, onBeforeUnmount, onMounted, ref, watch } from 'vue';
import SfIcon from './SfIcon.vue';

const props = defineProps({
    images: { type: Array, default: () => [] },
    alt: { type: String, default: '' },
});

const index = ref(0);
const zoomed = ref(false);

const current = computed(() => props.images[index.value] ?? null);
const hasMany = computed(() => props.images.length > 1);

function step(delta) {
    if (!props.images.length) return;
    index.value = (index.value + delta + props.images.length) % props.images.length;
}

function onKeydown(event) {
    if (!zoomed.value) return;
    if (event.key === 'Escape') zoomed.value = false;
    if (event.key === 'ArrowRight') step(1);
    if (event.key === 'ArrowLeft') step(-1);
}

watch(zoomed, (on) => {
    document.body.style.overflow = on ? 'hidden' : '';
});

onMounted(() => document.addEventListener('keydown', onKeydown));
onBeforeUnmount(() => {
    document.removeEventListener('keydown', onKeydown);
    document.body.style.overflow = '';
});
</script>

<template>
    <div class="flex gap-3">
        <!-- Thumbnails: a column on desktop, a row under the image on mobile -->
        <div
            v-if="hasMany"
            class="sf-scrollbar-none order-2 flex max-h-[28rem] gap-2 overflow-auto sm:order-1 sm:flex-col"
        >
            <button
                v-for="(image, i) in images"
                :key="image.thumb ?? i"
                type="button"
                class="h-16 w-16 shrink-0 overflow-hidden rounded-md border bg-white p-1 transition-colors"
                :class="i === index ? 'border-brand-500' : 'border-ink-200 hover:border-ink-300'"
                :aria-current="i === index"
                @click="index = i"
                @mouseenter="index = i"
            >
                <img :src="image.thumb ?? image.url" :alt="alt" class="h-full w-full object-contain" loading="lazy" />
            </button>
        </div>

        <div class="order-1 min-w-0 flex-1 sm:order-2">
            <button
                type="button"
                class="group relative block w-full cursor-zoom-in overflow-hidden rounded-lg border border-ink-200 bg-white"
                :aria-label="alt"
                @click="zoomed = true"
            >
                <img
                    v-if="current"
                    :src="current.url"
                    :alt="alt"
                    class="aspect-square w-full object-contain p-6"
                    fetchpriority="high"
                    decoding="async"
                />
                <span class="absolute bottom-3 right-3 rounded-md bg-white/90 p-1.5 text-ink-500 opacity-0 shadow-card transition-opacity group-hover:opacity-100">
                    <SfIcon name="search" :size="16" />
                </span>
            </button>
        </div>
    </div>

    <Teleport to="body">
        <Transition
            enter-active-class="transition-opacity duration-150"
            enter-from-class="opacity-0"
            leave-active-class="transition-opacity duration-150"
            leave-to-class="opacity-0"
        >
            <div
                v-if="zoomed"
                class="fixed inset-0 z-modal flex items-center justify-center bg-ink-900/90 p-4"
                role="dialog"
                aria-modal="true"
                @click.self="zoomed = false"
            >
                <button type="button" class="absolute right-4 top-4 text-white/80 hover:text-white" aria-label="×" @click="zoomed = false">
                    <SfIcon name="close" :size="28" />
                </button>

                <button
                    v-if="hasMany"
                    type="button"
                    class="absolute left-4 text-white/80 hover:text-white"
                    aria-label="←"
                    @click.stop="step(-1)"
                >
                    <SfIcon name="chevronLeft" :size="32" />
                </button>

                <img v-if="current" :src="current.url" :alt="alt" class="max-h-full max-w-full object-contain" />

                <button
                    v-if="hasMany"
                    type="button"
                    class="absolute right-4 text-white/80 hover:text-white"
                    aria-label="→"
                    @click.stop="step(1)"
                >
                    <SfIcon name="chevronRight" :size="32" />
                </button>

                <p v-if="hasMany" class="absolute bottom-5 text-sm text-white/70">{{ index + 1 }} / {{ images.length }}</p>
            </div>
        </Transition>
    </Teleport>
</template>
