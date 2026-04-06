import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
    ],
    theme: {
        extend: {
            fontFamily: {
                // Font bawaan (figtree)
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                
                // Tambahkan font Archive disini
                archive: ['Archive', 'sans-serif'], 
            },
        },
    },
    plugins: [],
};