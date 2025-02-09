import { defineStore } from 'pinia';
import axios from 'axios';
import { API_BASE_URL } from '@/config.js';

export const useMantenimientosCountStore = defineStore('mantenimientosCount', {
  state: () => ({
    MantenimientoHechos: null,
    MantenimientoProximos: null,
  }),
  actions: {
    async fetchMantenimientosCount() {
      try {
        const token = sessionStorage.getItem('token');
        const response = await axios.get(`${API_BASE_URL}/mantenimientosCount`, {
          headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${token}`,
          },
        });
        console.log("MANTENIMIENTOS DATA: ", response.data.data);

        this.MantenimientoHechos = response.data.data.MantenimientoTotal;
        this.MantenimientoProximos = response.data.data.MantenimientoProximos;

      } catch (error) {
        console.error('Error al obtener Mantenimientos:', error);
      }
    },
  },
});