import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './app/Livewire/**/*.php',
        './app/View/Components/**/*.php'
    ],

    darkMode: 'class',

    theme: {
        extend: {
            colors: {
                'f-primary': 'rgb(var(--f-primary) / <alpha-value>)',
                'f-primary-dark': 'rgb(var(--f-primary-dark) / <alpha-value>)',
                'f-primary-light': 'rgb(var(--f-primary-light) / <alpha-value>)',
                'f-secondary': 'rgb(var(--f-secondary) / <alpha-value>)',
                'f-background': 'rgb(var(--f-background) / <alpha-value>)',
                'f-surface': 'rgb(var(--f-surface) / <alpha-value>)',
            },
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms, typography],
};
