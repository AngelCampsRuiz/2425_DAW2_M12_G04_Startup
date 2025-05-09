/** @type {import('tailwindcss').Config} */
module.exports = {
    darkMode: 'class',
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            colors: {
                'dark': {
                    DEFAULT: '#000000',
                    'lighter': '#333333',
                    'border': '#333333'
                }
            }
        },
    },
    plugins: [],
}; 