import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                // Admin panel — Tailwind + Alpine (already redesigned, untouched here)
                'resources/css/admin.css',
                'resources/js/admin.js',
                // Storefront v2 — Tailwind design system + Vue 3 islands
                'resources/css/storefront.css',
                'resources/js/storefront.js',
            ],
            refresh: [
                'resources/views/**',
                'resources/js/storefront/**',
            ],
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    build: {
        // The storefront ships one CSS file and one JS chunk per island group;
        // anything below this is inlined rather than becoming a request.
        assetsInlineLimit: 2048,
        rollupOptions: {
            output: {
                manualChunks(id) {
                    if (id.includes('node_modules/@vue') || id.includes('node_modules/vue')) {
                        return 'vue';
                    }
                    return undefined;
                },
            },
        },
    },
});
