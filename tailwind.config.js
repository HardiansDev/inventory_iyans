// tailwind.config.js
module.exports = {
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    darkMode: 'class', // <--- penting biar bisa dark mode pakai class
    theme: {
        extend: {},
    },
    plugins: [],
}
