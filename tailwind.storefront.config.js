/**
 * Radop — Storefront design system (v2)
 * ------------------------------------------------------------------
 * Deliberately separate from `tailwind.config.js` (admin panel) so the
 * two bundles never leak utilities into each other. Referenced from
 * `resources/css/storefront.css` via the `@config` directive.
 *
 * Everything visual on the storefront must resolve to a token below —
 * no ad-hoc hex values in Blade or Vue.
 */
/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './resources/views/frontend/**/*.blade.php',
        './resources/views/components/sf-*.blade.php',
        // Error pages and the paginator live outside frontend/; without these
        // globs their utility classes were silently missing from the build.
        './resources/views/errors/*.blade.php',
        './resources/views/vendor/pagination/sf.blade.php',
        './resources/js/storefront.js',
        './resources/js/storefront/**/*.{js,vue}',
    ],
    theme: {
        // Container is handled by the `.sf-container` component class instead
        // of Tailwind's container plugin, so the gutter stays consistent.
        extend: {
            colors: {
                // Brand azure — the single colour of the Radop logo (#0068a7).
                brand: {
                    50: '#eef8fc',
                    100: '#d4ecf8',
                    200: '#aedcf1',
                    300: '#76c4e6',
                    400: '#37a4d4',
                    500: '#0f86bd',
                    600: '#0068a7',
                    700: '#015589',
                    800: '#084a71',
                    900: '#0c3e5d',
                    950: '#07273d',
                },
                // Warm accent used sparingly: sale prices, urgency, CTA on dark.
                accent: {
                    50: '#fff6ed',
                    100: '#ffead5',
                    200: '#fed1aa',
                    300: '#fdb174',
                    400: '#fb873c',
                    500: '#f96a16',
                    600: '#ea4f0c',
                    700: '#c23a0c',
                    800: '#9a2f12',
                    900: '#7c2a12',
                },
                // Single neutral ramp — replaces the four greys the old CSS used.
                ink: {
                    50: '#f7f8fa',
                    100: '#eef0f4',
                    200: '#dfe3ea',
                    300: '#c6ccd8',
                    400: '#98a2b3',
                    500: '#6b7688',
                    600: '#4d5768',
                    700: '#3a4354',
                    800: '#252d3b',
                    900: '#151b26',
                },
                success: { 50: '#eefbf3', 500: '#16a34a', 600: '#15803d' },
                danger: { 50: '#fef2f2', 500: '#e11d48', 600: '#be123c' },
            },
            fontFamily: {
                sans: ['Montserrat', 'system-ui', '-apple-system', 'Segoe UI', 'sans-serif'],
            },
            fontSize: {
                // Compact e-commerce scale — dense catalogues need small steps.
                '2xs': ['0.6875rem', { lineHeight: '1rem' }],
                xs: ['0.75rem', { lineHeight: '1.125rem' }],
                sm: ['0.8125rem', { lineHeight: '1.25rem' }],
                base: ['0.875rem', { lineHeight: '1.375rem' }],
                md: ['0.9375rem', { lineHeight: '1.5rem' }],
                lg: ['1.0625rem', { lineHeight: '1.625rem' }],
                xl: ['1.25rem', { lineHeight: '1.75rem' }],
                '2xl': ['1.5rem', { lineHeight: '2rem' }],
                '3xl': ['1.875rem', { lineHeight: '2.25rem' }],
                '4xl': ['2.25rem', { lineHeight: '2.5rem' }],
            },
            borderRadius: {
                DEFAULT: '0.5rem',
                sm: '0.375rem',
                md: '0.5rem',
                lg: '0.75rem',
                xl: '1rem',
            },
            boxShadow: {
                // Two elevations only. Anything deeper is a modal/overlay.
                card: '0 1px 2px 0 rgb(21 27 38 / 0.04), 0 1px 3px 0 rgb(21 27 38 / 0.06)',
                'card-hover': '0 4px 6px -1px rgb(21 27 38 / 0.07), 0 10px 20px -6px rgb(21 27 38 / 0.12)',
                pop: '0 10px 15px -3px rgb(21 27 38 / 0.08), 0 20px 40px -12px rgb(21 27 38 / 0.18)',
            },
            transitionTimingFunction: {
                sf: 'cubic-bezier(0.22, 1, 0.36, 1)',
            },
            zIndex: {
                header: '60',
                overlay: '70',
                menu: '80',
                modal: '90',
            },
            maxWidth: {
                sf: '1400px',
            },
            keyframes: {
                'sf-fade-in': {
                    from: { opacity: '0' },
                    to: { opacity: '1' },
                },
                'sf-slide-down': {
                    from: { opacity: '0', transform: 'translateY(-6px)' },
                    to: { opacity: '1', transform: 'translateY(0)' },
                },
                'sf-shimmer': {
                    '100%': { transform: 'translateX(100%)' },
                },
            },
            animation: {
                'sf-fade-in': 'sf-fade-in .18s ease-out both',
                'sf-slide-down': 'sf-slide-down .2s cubic-bezier(0.22,1,0.36,1) both',
            },
        },
    },
    plugins: [],
};
