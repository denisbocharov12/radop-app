import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                // Storefront (untouched)
                'resources/sass/app.scss',
                'resources/js/app.js',
                // Admin panel — modern stack (Tailwind + Alpine)
                'resources/css/admin.css',
                'resources/js/admin.js',
            ],
            refresh: true,
        }),
    ],
});
