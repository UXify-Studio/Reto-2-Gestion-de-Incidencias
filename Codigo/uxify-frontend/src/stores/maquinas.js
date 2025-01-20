import { defineStore } from 'pinia';
import axios from 'axios';

export const useMaquinasStore = defineStore('maquinas', {
  state: () => ({
    maquinasTotal: 0,
    maqPrioridad1: 0,
    maqPrioridad2: 0,
    maqPrioridad3: 0,
  }),
  actions: {
    async fetchMaquinasTotal() {
      try {
        const response = await axios.get('http://127.0.0.1:8000/api/maquinasCount');
        console.log('Maquinas totales:', response.data.total);
        console.log('Maquinas Prioridad 1:', response.data.prioridad1);
        console.log('Maquinas Prioridad 2:', response.data.prioridad2);
        console.log('Maquinas Prioridad 3:', response.data.prioridad3);

        this.maquinasTotal = response.data.total;
        this.maqPrioridad1 = response.data.prioridad1;
        this.maqPrioridad2 = response.data.prioridad2;
        this.maqPrioridad3 = response.data.prioridad3;

      } catch (error) {
        console.error('Error al obtener maquinas:', error);
      }
    },
  },
});


