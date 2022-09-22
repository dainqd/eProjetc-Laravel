import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import eslintPlugin from "vite-plugin-eslint";

export default defineConfig({
    server: {
        open: "http://localhost:8000",
    },
    plugins: [
        laravel(["resources/css/app.css", "resources/js/app.js"]),
        eslintPlugin({
            include: [
                "resources/**/*.js",
                "resources/**/*.jsx",
                "resources/**/*.ts",
                "resources/**/*.tsx",
                "resources/**/*.vue",
            ],
        }),
    ],
});
