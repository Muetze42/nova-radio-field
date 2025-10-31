import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        vue(),
    ],
    build: {
        outDir: 'dist',
        emptyOutDir: true,
        lib: {
            entry: 'resources/js/field.js',
            name: 'NovaRadioField',
            formats: ['iife'],
            fileName: () => 'js/field.js',
        },
        rollupOptions: {
            external: ['vue', 'laravel-nova'],
            output: {
                globals: {
                    vue: 'Vue',
                },
                assetFileNames: (assetInfo) => {
                    if (assetInfo.name === 'style.css') {
                        return 'css/field.css';
                    }
                    return assetInfo.name;
                },
            },
        },
    },
    define: {
        'process.env.NODE_ENV': JSON.stringify(process.env.NODE_ENV || 'production'),
    },
});

