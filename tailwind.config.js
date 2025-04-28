import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    mode: 'jit',
    darkMode: 'class',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            /**
             * This is workaround fix to handle viewport height issue on mobile browsers
             * https://stackoverflow.com/questions/37112218/css3-100vh-not-constant-in-mobile-browser
             * 
             * Below are fallback value
             */
            minHeight: {
                "screen": ["100vh", "calc(var(--vh, 1vh) * 100)"],
            },
            height: {
				"screen": ["100vh", "calc(var(--vh, 1vh) * 100)"],
            },
        },
    },

    plugins: [forms],
};
