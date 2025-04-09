import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        host: '0.0.0.0',
        allowedHosts: ['mahjong.gappy.online', 'localhost', 'vite.gappy.online'],
        proxy: {
            '/': 'https://mahjong.gappy.online:7777',
        }
    },
});
