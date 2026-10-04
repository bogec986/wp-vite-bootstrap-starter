import { defineConfig } from 'vite';
import path from 'node:path';
import { fileURLToPath } from 'node:url';
import LiveReload from 'vite-plugin-live-reload';

const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);

export default defineConfig({
    base: './',

    plugins: [
        LiveReload(__dirname + '/**/*.php', {
            alwaysReload: true,
        }),
    ],

    build: {
        manifest: true,
        outDir: 'dist',
        emptyOutDir: true,
        minify: 'terser',

        terserOptions: {
            compress: {
                drop_console: true,
            },
        },

        rollupOptions: {
            input: {
                app: path.resolve(__dirname, 'resources/js/app.js'),
                editor: path.resolve(__dirname, 'resources/js/editor.js'),
            },
        },
    },

    server: {
        host: '127.0.0.1',
        port: 5173,
        strictPort: true,
        cors: true,

        watch: {
            usePolling: true,
            interval: 100,
        },

        hmr: {
            host: '127.0.0.1',
            protocol: 'ws',
        },
    },
});
