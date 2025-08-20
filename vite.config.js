import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
                'resources/sass/dashboard.scss',
                'resources/js/dashboard.js',
                'resources/js/charts.js',
                'resources/sass/login.scss',
                'resources/js/login.js',
            ],
            refresh: true,
        }),
    ],
});
