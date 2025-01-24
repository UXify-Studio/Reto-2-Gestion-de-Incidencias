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
        const data = response.data.mantenimientos;
        console.log("DATA: ", data);
        console.log('Mantenimientos:', data.data);
        console.log('Current Page:', data.current_page);
        console.log('Last Page:', data.last_page);
        console.log('Per Page:', data.per_page);

        this.mantenimientos = data.data;
        this.current_page = data.current_page;
        this.last_page = data.last_page;
        this.per_page = data.per_page;

      } catch (error) {
        console.error('Error al obtener mantenimientos:', error);
      }
    },
  },
});

export const useMantenimientosHechos = defineStore('mantenientosHechos', {
  state: () => ({
    mantenimientosHechos: [],
    current_page: 1,
    last_page: 1,
    per_page: 1,
  }),
  actions: {
    async fetchMantenimientosHechos(page = 1) {
      try {
        const response = await axios.get(`${API_BASE_URL}/mantenimientos?page=${page}`);
        const data = response.data.mantenimientosResueltos;
        console.log("DATA: ", data);
        console.log('Mantenimientos:', data.data);
        console.log('Current Page:', data.current_page);
        console.log('Last Page:', data.last_page);
        console.log('Per Page:', data.per_page);

        this.mantenimientos = data.data;
        this.current_page = data.current_page;
        this.last_page = data.last_page;
        this.per_page = data.per_page;

      } catch (error) {
        console.error('Error al obtener mantenimientos resueltos:', error);
      }
    },
  },
});


