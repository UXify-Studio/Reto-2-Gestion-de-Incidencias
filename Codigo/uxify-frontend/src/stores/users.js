import { defineStore } from 'pinia';
import axios from 'axios';

export const useUsersStore = defineStore('users', {
  state: () => ({
    usersTotal: 0,
  }),
  actions: {
    async fetchUsersTotal() {
      try {
        const response = await axios.get('http://127.0.0.1:8000/api/usersTotal');
        console.log('Usuarios totales recibidos:', response.data);
        this.usersTotal = response.data.total;
      } catch (error) {
        console.error('Error al obtener usuarios totales:', error);
      }
    },
  },
});


