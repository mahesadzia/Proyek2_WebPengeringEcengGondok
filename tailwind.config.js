import defaultTheme from 'tailwindcss/defaultTheme';

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
                    deep:  '#27501F',
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
    plugins: [],
};