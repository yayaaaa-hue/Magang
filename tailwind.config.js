import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    theme: {
        extend: {
            colors: {
                primary: 'var(--color-primary, #3B82F6)',
                'blue-light': 'var(--color-blue-light, #93C5FD)',
                pink: 'var(--color-pink, #EC4899)',
                'pink-light': 'var(--color-pink-light, #F9A8D4)',
                navy: 'var(--color-navy, #172554)',
            },
        },
    },
    plugins: [],
};
