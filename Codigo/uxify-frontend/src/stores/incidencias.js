import { defineStore } from 'pinia';
import axios from 'axios';
import { API_BASE_URL } from '@/config.js';

export const useIncidenciasStore = defineStore('incidencias', {
  state: () => ({
    incidenciasAlta: -1,
    incidenciasMedia: -1,
    incidenciasBaja: -1,
    incidenciasResueltas: -1,
    mantenimientos: -1,
  }),
  actions: {
    async fetchIncidenciasTotal() {
      try {
        const token = sessionStorage.getItem('token');
        const response = await axios.get(`${API_BASE_URL}/incidencias/prioridad`,{
          headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${token}`,
          },
        });
        console.log("DATA: ", response.data);
        console.log('Inicidencias Prioridad Alta:', response.data.data.alta);
        console.log('Inicidencias Prioridad Media:', response.data.data.media);
        console.log('Inicidencias Prioridad Baja:', response.data.data.baja);
        console.log('Inicidencias Resueltas:', response.data.data.resueltas);
        console.log('Mantenimientos:', response.data.data.mantenimientos);

        this.incidenciasAlta = response.data.data.alta;
        this.incidenciasMedia = response.data.data.media;
        this.incidenciasBaja = response.data.data.baja;
        this.incidenciasResueltas = response.data.data.resueltas;
        this.mantenimientos = response.data.data.mantenimientos;

      } catch (error) {
        console.error('Error al obtener incidencias:', error);
      }
    },
  },
});