<script setup>
/**
 * Home hero. Replaces Slick (plus its jQuery dependency and two stylesheets)
 * with native scroll-snap: the browser does the panning, so the slider works
 * before hydration and costs no layout thrash.
 *
 * The first slide is eager and `fetchpriority="high"` — it is almost always
 * the Largest Contentful Paint element.
 */
import { onBeforeUnmount, onMounted, ref } from 'vue';
import SfIcon from './SfIcon.vue';

const props = defineProps({
    slides: { type: Array, default: () => [] },
    /** Milliseconds between automatic advances; 0 disables autoplay. */
    autoplay: { type: Number, default: 0 },
});

const trackEl = ref(null);
const index = ref(0);
let timer = null;
let paused = false;

function goTo(i) {
    const track = trackEl.value;
    if (!track) return;
    const target = (i + props.slides.length) % props.slides.length;
    track.scrollTo({ left: track.clientWidth * target, behavior: 'smooth' });
    index.value = target;
}

function onScroll() {
    const track = trackEl.value;
    if (!track) return;
    index.value = Math.round(track.scrollLeft / track.clientWidth);
}

function start() {
    if (!props.autoplay || props.slides.length < 2) return;
    stop();
    timer = setInterval(() => {
        if (!paused) goTo(index.value + 1);
    }, props.autoplay);
}

function stop() {
    if (timer) clearInterval(timer);
    timer = null;
}

onMounted(() => {
    // Respect the visitor's motion preference rather than autoplaying anyway.
    if (!window.matchMedia('(prefers-reduced-motion: reduce)').matches) start();
});

onBeforeUnmount(stop);
</script>

<template>
    <!-- `#main-banner` is the hook scripts.blade.php uses to report GA4
         promotion clicks; keep the id. -->
    <section
        id="main-banner"
        class="relative"
        @mouseenter="paused = true"
        @mouseleave="paused = false"
        @focusin="paused = true"
        @focusout="paused = false"
    >
        <div
            ref="trackEl"
            class="sf-scrollbar-none flex snap-x snap-mandatory overflow-x-auto rounded-lg"
            @scroll.passive="onScroll"
        >
            <a
                v-for="(slide, i) in slides"
                :key="slide.id"
                :href="slide.url"
                class="w-full shrink-0 snap-center"
                :data-promotion-id="slide.id"
                data-promotion-name="homepage_banner"
                data-creative-slot="main_banner"
            >
                <img
                    :src="slide.image"
                    :alt="slide.alt"
                    class="aspect-[1232/400] w-full rounded-lg object-cover"
                    :loading="i === 0 ? 'eager' : 'lazy'"
                    :fetchpriority="i === 0 ? 'high' : 'auto'"
                    decoding="async"
                />
            </a>
        </div>

        <template v-if="slides.length > 1">
            <button
                type="button"
                class="absolute left-3 top-1/2 hidden h-10 w-10 -translate-y-1/2 items-center justify-center rounded-full bg-white/85 text-ink-700 shadow-card backdrop-blur transition hover:bg-white lg:flex"
                aria-label="←"
                @click="goTo(index - 1)"
            >
                <SfIcon name="chevronLeft" />
            </button>
            <button
                type="button"
                class="absolute right-3 top-1/2 hidden h-10 w-10 -translate-y-1/2 items-center justify-center rounded-full bg-white/85 text-ink-700 shadow-card backdrop-blur transition hover:bg-white lg:flex"
                aria-label="→"
                @click="goTo(index + 1)"
            >
                <SfIcon name="chevronRight" />
            </button>

            <div class="absolute inset-x-0 bottom-3 flex justify-center gap-1.5">
                <button
                    v-for="(slide, i) in slides"
                    :key="slide.id"
                    type="button"
                    class="h-1.5 rounded-full transition-all duration-200"
                    :class="i === index ? 'w-6 bg-brand-600' : 'w-1.5 bg-white/80 hover:bg-white'"
                    :aria-label="`${i + 1}`"
                    :aria-current="i === index"
                    @click="goTo(i)"
                ></button>
            </div>
        </template>
    </section>
</template>
