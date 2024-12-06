import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    presets: [
        require("./vendor/wireui/wireui/tailwind.config.js"),
    ],
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './app/Livewire/**/*.php',
        './resources/**/*.js',
        './resources/**/*.vue',
        "./vendor/wireui/wireui/src/*.php",
        "./vendor/wireui/wireui/ts/**/*.ts",
        "./vendor/wireui/wireui/src/WireUi/**/*.php",
        "./vendor/wireui/wireui/src/Components/**/*.php",
    ],
    theme: {
        container: {
            center: true,
        },
        extend: {
            fontFamily: {
                sans: ['Inter', 'Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: {
                    100: '#ffec3d',
                    500: '#f8e000',
                    600: '#d9c50f',
                },
                secondary: {
                    100: '#192b55',
                },
            },
        },
    },
    plugins: [],
};
