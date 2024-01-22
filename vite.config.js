import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/css/app.css',
                'resources/css/login.css',
                'resources/js/app.js',
                'resources/css/orders/orders.css',
                'resources/js/orders/orders.js',
                'resources/css/orders/orders-details.css',
                'resources/js/orders/orders-details.js',
            ],
            refresh: true,
        }),
    ],
});
