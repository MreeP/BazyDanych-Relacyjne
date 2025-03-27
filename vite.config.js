import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                // JavaScript
                'resources/js/app.js',

                // CSS
                'resources/css/app.css',
            ],
            refresh: [
                'app/Livewire/**',
                'app/View/Components/**',
                'lang/**',
                'resources/lang/**',
                'resources/views/**',
                'routes/**',
                'modules/*/Resources/**/*',
            ],
        }),
    ],
    resolve: {
        alias: {
            '@': '/resources/js',
            '@css': '/resources/css',
            '@modules': '/modules',
            '@vendor': '/vendor',
        }
    },
});
