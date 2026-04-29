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
                display: ['"Playfair Display"', 'Georgia', 'serif'],
                sans: ['Inter', 'ui-sans-serif', 'system-ui'],
            },
            colors: {
                brand: {
                    DEFAULT: '#e67e22',
                    dark: '#ca6f1e',
                    light: '#f39c12',
                }
            },
        },
    },
    plugins: [
        require('@tailwindcss/typography'),
        require('@tailwindcss/line-clamp'),
    ],
};
