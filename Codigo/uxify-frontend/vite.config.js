import { fileURLToPath, URL } from 'node:url'

import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import vueDevTools from 'vite-plugin-vue-devtools'

// https://vite.dev/config/
export default defineConfig({
  plugins: [
    vue(),
    vueDevTools(),
  ],
  resolve: {
    alias: {
      '@': fileURLToPath(new URL('./src', import.meta.url)),
    },
  },
  server: {
    host: '0.0.0.0', // Esto asegura que el servidor sea accesible desde fuera del contenedor
    port: 5173, // Puerto donde estará disponible la app
    strictPort: true, // Esto asegura que Vite no cambie el puerto si 5173 está ocupado
  },
})
