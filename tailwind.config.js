import defaultTheme from 'tailwindcss/defaultTheme';
import aspectRatio from '@tailwindcss/aspect-ratio';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './modules/*/resources/**/*.blade.php',
        './modules/*/Resources/**/*.blade.php',
        './resources/views/**/*.blade.php',
        './resources/js/alpine/*.js',
        './storage/framework/views/*.php',
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
    ],

    darkMode: 'class',

    plugins: [
        aspectRatio,
        forms,
        typography,
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },
};
