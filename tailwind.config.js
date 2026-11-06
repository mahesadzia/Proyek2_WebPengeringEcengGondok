import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Poppins', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                eg: {
                    dark:  '#2B6A24',
                    deep:  '#1B3F15',
                    leaf:  '#5BBB3D',
                    mint:  '#9FDB8E',
                    lime:  '#D3F9A5',
                    moss:  '#4E8A3A',
                    blush: '#FCBBAA',
                    clay:  '#A44A33',
                    rust:  '#A33D26',
                },
            },
        },
    },
    plugins: [forms],
};