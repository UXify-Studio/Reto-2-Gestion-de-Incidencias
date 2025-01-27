import { defineStore } from 'pinia';
import axios from 'axios';
import { API_BASE_URL } from '@/config.js';

export const useIncidenciasCountStore = defineStore('incidenciasCount', {
  state: () => ({
    incidenciasPendiente: null,
    incidenciasActivas: null,
  }),
  actions: {
    async fetchIncidenciasCount() {
      try {
          const token = sessionStorage.getItem('token');
        const response = await axios.get(`${API_BASE_URL}/incidenciasCount`, {
          headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${token}`,
          },
        });
        console.log("INCIDENCIAS DATA: ", response.data.data);
        this.incidenciasPendiente = response.data.data.IncidenciasPendiente;
        this.incidenciasActivas = response.data.data.incidenciasActivo;
      } catch (error) {
        console.error('Error al obtener incidencias:', error);
      }
    },
  },
});