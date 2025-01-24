import { defineStore } from 'pinia';
import axios from 'axios';
import { API_BASE_URL } from '@/config.js';

export const useMantenimientosCountStore = defineStore('mantenimientosCount', {
  state: () => ({
    MantenimeitnoHechos: -1,
    MantenimeitnoProximos: -1,
  }),
  actions: {
    async fetchMantenimientosCount() {
      try {
        const response = await axios.get(`${API_BASE_URL}/mantenimientosCount`);
        console.log("DATA: ", response);

        this.MantenimientoHechos = response.data.data.MantenimientoHechos;
        this.MantenimientoProximos = response.data.data.MantenimientoProximos;

      } catch (error) {
        console.error('Error al obtener Mantenimientos:', error);
      }
    },
  },
});