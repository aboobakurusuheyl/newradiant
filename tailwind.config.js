/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            colors: {
                "newradiant-blue": "#1e40af",
                "newradiant-light-blue": "#3b82f6",
                "newradiant-dark-blue": "#1e3a8a",
                "newradiant-accent": "#f59e0b",
                "newradiant-success": "#10b981",
            },
        },
    },
    plugins: [require("@tailwindcss/forms")],
};
