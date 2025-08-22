
import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import vue from '@vitejs/plugin-vue'
import vueJSX from '@vitejs/plugin-vue-jsx'

export default defineConfig({
    // base: '/build/',
    plugins: [
        laravel({
            input: 'resources/js/app.js',
        }),

        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),

        vueJSX(),
    ],
    server: {
        host: '0.0.0.0', // Permite que el servidor sea accesible desde otras máquinas
        port: 5173, // Cambia si tienes conflictos con este puerto
        strictPort: true, // Asegura que use este puerto exactamente
        hmr: {
            host: '192.168.1.82', // Reemplaza con tu IP local
            port: 5173, // Debe coincidir con el puerto del servidor
        },
    },
})
