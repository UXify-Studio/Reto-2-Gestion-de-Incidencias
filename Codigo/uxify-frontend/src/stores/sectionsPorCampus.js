import { defineStore } from 'pinia';
import axios from 'axios';

export const useSectionsStore = defineStore('sections', {
  state: () => ({
    campus: 0,
    sections: [],
  }),
  actions: {
    async fetchSectionsByCampus() {
      try {
        const response = await axios.get(`http://127.0.0.1:8000/api/sectionByCampus/${this.campus}`);
        console.log('Campus: ', this.campus);
        console.log('Secciones: ', response.data);

        this.sections = response.data.sections

      } catch (error) {
        console.error('Error al obtener usuarios:', error);
      }
    },
  },
});


