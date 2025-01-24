import { defineStore } from 'pinia';
import axios from 'axios';
import { API_BASE_URL } from '@/config.js';

export const useIncidenciasCountStore = defineStore('incidenciasCount', {
  state: () => ({
    incidenciasPendiente: null, // Cambiado a null
    incidenciasActivas: null, // Cambiado a null
  }),
  actions: {
    async fetchIncidenciasCount() {
      try {
        const response = await axios.get(`${API_BASE_URL}/incidenciasCount`);
        console.log("INCIDENCIAS DATA: ", response.data.data);
        this.incidenciasPendiente = response.data.data.IncidenciasPendiente;
        this.incidenciasActivas = response.data.data.incidenciasActivo;
      } catch (error) {
        console.error('Error al obtener incidencias:', error);
      }
    },
  },
});