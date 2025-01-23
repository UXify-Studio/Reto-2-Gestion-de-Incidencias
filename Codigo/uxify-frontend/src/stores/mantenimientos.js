import { defineStore } from 'pinia';
import axios from 'axios';
import { API_BASE_URL } from '@/config.js';

export const useMantenimientosStore = defineStore('mantenimientos', {
  state: () => ({
    mantenimientos: [],
  }),
  actions: {
    async fetchMantenimientosTotal() {
      try {
        const response = await axios.get(`${API_BASE_URL}/mantenimientos`);
        console.log("DATA: ", response.data);
        console.log('Mantenimientos:', response.data.mantenimientos);
        this.mantenimientos = response.data.mantenimientos;

      } catch (error) {
        console.error('Error al obtener mantenimientos:', error);
      }
    },
  },
});


