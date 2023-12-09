import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            plugins: [
                laravel(['resources/js/app.jsx']),
                react(),
            ],
        }),
    ],
});
