import { defineStore } from 'pinia';
import axios from 'axios';
import { API_BASE_URL } from '@/config.js';

export const useMantenimientosStore = defineStore('mantenimientos', {
  state: () => ({
    mantenimientos: [],
    current_page: 1,
    last_page: 1,
    per_page: 1,
  }),
  actions: {
    async fetchMantenimientosProximos(page = 1) {
      try {
        const response = await axios.get(`${API_BASE_URL}/mantenimientos?page=${page}`);
        const data = response.data;
        console.log("DATA: ", data.mantenimientos);
        console.log('Mantenimientos:', data.mantenimientos.data);
        console.log('Current Page:', data.mantenimientos.current_page);
        console.log('Last Page:', data.mantenimientos.last_page);
        console.log('Per Page:', data.mantenimientos.per_page);

        this.mantenimientos = data.mantenimientos.data;
        this.current_page = data.mantenimientos.current_page;
        this.last_page = data.mantenimientos.last_page;
        this.per_page = data.mantenimientos.per_page;

      } catch (error) {
        console.error('Error al obtener mantenimientos:', error);
      }
    },
  },
});


