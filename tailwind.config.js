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
                ec: {
                    forest:    '#2D4A38',
                    mist:      '#E8EFE6',
                    cream:     '#F5F1E8',
                    ink:       '#2A3B30',
                    leaf:      '#5A8F60',
                    moss:      '#3F6B45',
                    sage:      '#DDE9DA',
                    sand:      '#ECE8DC',
                    line:      '#E6E1D6',
                    rose:      '#F5E1DC',
                    rosetext:  '#A34F43',
                    amber:     '#F8EFD7',
                    amberline: '#EAD9A8',
                    amberink:  '#5C4410',
                },
            },
        },
    },
    plugins: [],
};