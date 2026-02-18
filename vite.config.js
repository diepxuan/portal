import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    server: {
        host: '0.0.0.0',
        port: 5173,
        cors: {
            origin: [
                'https://portaldev.diepxuan.io.vn',
                'https://portalvite.diepxuan.io.vn',
                'http://localhost:8000',
                'http://localhost:5173'
            ],
            credentials: true,
            methods: ['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS'],
            allowedHeaders: ['Content-Type', 'Authorization']
        },
        allowedHosts: [
            'portalvite.diepxuan.io.vn',
            'portaldev.diepxuan.io.vn',
            'localhost',
            '127.0.0.1',
            '[::1]'
        ],
        hmr: {
            host: 'portalvite.diepxuan.io.vn',
            clientPort: 443,
            protocol: 'wss'
        }
    }
});
