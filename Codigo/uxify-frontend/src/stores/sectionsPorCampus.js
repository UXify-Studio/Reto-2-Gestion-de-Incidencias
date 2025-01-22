import { defineStore } from 'pinia';
import axios from 'axios';
import { API_BASE_URL } from '@/config.js';

export const useSectionsStore = defineStore('sections', {
  state: () => ({
    campus: 0,
    sections: [],
  }),
  actions: {
    async fetchSectionsByCampus() {
      try {
        const response = await axios.get(`${API_BASE_URL}/sectionByCampus/${this.campus}`);
        console.log('Campus: ', this.campus);
        console.log('Secciones: ', response.data);

        this.sections = response.data.sections

      } catch (error) {
        console.error('Error al obtener usuarios:', error);
      }
    },
  },
});


