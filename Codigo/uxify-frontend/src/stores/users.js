import { defineStore } from 'pinia';
import axios from 'axios';

export const useUsersStore = defineStore('users', {
  state: () => ({
    usersTotal: 0,
    usersAdmin: 0,
    usersTenico: 0,
    usersOperario: 0,
  }),
  actions: {
    async fetchUsersTotal() {
      try {
        const response = await axios.get('http://127.0.0.1:8000/api/usersCount');
        console.log('Usuarios totales:', response.data.total);
        console.log('Usuarios Admin:', response.data.admin);
        console.log('Usuarios Tecnocos:', response.data.tecnico);
        console.log('Usuarios Operarios:', response.data.operario);

        this.usersTotal = response.data.total;
        this.usersAdmin = response.data.admin;
        this.usersTenico = response.data.tecnico;
        this.usersOperario = response.data.operario;

      } catch (error) {
        console.error('Error al obtener usuarios:', error);
      }
    },
  },
});


