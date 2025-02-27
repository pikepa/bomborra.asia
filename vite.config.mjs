import {defineConfig} from 'vite';
import laravel from 'laravel-vite-plugin';
import fs from 'fs';
const host = 'bomborra.test';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            detectTls: host,
            refresh: true,
        }),
    ],
    server: {
        host,
        hmr: { host },

    }
});