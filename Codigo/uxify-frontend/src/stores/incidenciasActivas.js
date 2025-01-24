import { defineStore } from 'pinia';
import axios from 'axios';
import { API_BASE_URL } from '@/config.js';

export const useIncidenciasCountStore = defineStore('incidenciasCount', {
  state: () => ({
    incidenciasPendiente: -1,
    incidenciasActivas: -1,
  }),
  actions: {
    async fetchIncidenciasCount() {
      try {
        const response = await axios.get(`${API_BASE_URL}/incidenciasCount`);
        console.log("DATA: ", response);
        console.log('Incidencias Pendientes:', response.data.data.IncidenciasPendiente);

        this.incidenciasPendiente = response.data.data.IncidenciasPendiente;
        this.incidenciasActivas = response.data.data.incidenciasActivo;

      } catch (error) {
        console.error('Error al obtener incidencias:', error);
      }
    },
  },
});
