/** @type {import('tailwindcss').Config} */
export default {
    // Scoped to the admin panel only — the storefront keeps its own stack.
    // Add new module view globs here as they are migrated to the modern layout.
    content: [
        './resources/views/v2/**/*.blade.php',
        './resources/views/components/**/*.blade.php',
        './resources/views/dashboard/**/*.blade.php',
        './resources/views/client/**/*.blade.php',
        './resources/views/order/**/*.blade.php',
        './resources/views/category/**/*.blade.php',
        './resources/views/product/**/*.blade.php',
        './resources/views/brand/**/*.blade.php',
        './resources/views/attribute/**/*.blade.php',
        './resources/views/city/**/*.blade.php',
        './resources/views/coupon/**/*.blade.php',
        './resources/views/filial/**/*.blade.php',
        './resources/views/deliveryMethod/**/*.blade.php',
        './resources/views/banner/**/*.blade.php',
        './resources/views/manager/**/*.blade.php',
        './resources/views/v1/auth/**/*.blade.php',
        './resources/views/review/**/*.blade.php',
        './resources/views/discount_period/**/*.blade.php',
        './resources/views/reports/**/*.blade.php',
        './resources/views/manager-export/**/*.blade.php',
        './resources/views/active-pages-export/**/*.blade.php',
        './resources/views/onec/**/*.blade.php',
        './resources/views/v1/manager/**/*.blade.php',
        './resources/views/v1/seo_meta/**/*.blade.php',
        './resources/views/admin/**/*.blade.php',
        './resources/views/menu/**/*.blade.php',
        './resources/views/header-menu/**/*.blade.php',
        './resources/js/admin.js',
    ],
    theme: {
        extend: {
            colors: {
                // Radop brand — azure (#0068a7 is the single colour of the brand logo)
                brand: {
                    50:  '#eef8fc',
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
                // Dark navy-teal sidebar that complements the azure brand
                sidebar: {
                    bg:     '#0c2233',
                    hover:  '#193a4f',
                    active: '#0068a7',
                    text:   '#c2d2de',
                    muted:  '#6b8497',
                    border: '#1b3647',
                },
            },
            fontFamily: {
                sans: ['Inter', 'Nunito', 'system-ui', '-apple-system', 'sans-serif'],
            },
        },
    },
    plugins: [],
};
