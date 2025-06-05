import { defineConfig } from "vite";
import vue from "@vitejs/plugin-vue";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: true,
        }),
        vue(),
    ],
    build: {
        outDir: "public/build",
        manifest: "manifest.json",
        rollupOptions: {
            input: ["resources/css/app.css", "resources/js/app.js"],
            output: {
                entryFileNames: "js/[name].[hash].js",
                chunkFileNames: "js/[name].[hash].js",
                assetFileNames: "assets/[name].[hash][extname]",
            },
        },
        emptyOutDir: true,
    },
    base: "/",
});
