import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                // sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                'sans': ['Poppins', 'sans-serif'],
            },
            colors: {
                primary: '#FFE5B6', // Ganti dengan warna primary Anda
                secondary: '#3d372b',
                primary_hover: '#ddc79e',
                secondary_hover:'#25211a',
            },
        },
    },

    plugins: [forms],
};
