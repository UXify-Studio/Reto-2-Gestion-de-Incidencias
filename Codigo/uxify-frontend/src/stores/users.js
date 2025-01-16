import { defineStore } from 'pinia';
import axios from 'axios';

export const useUsersStore = defineStore('users', {
  state: () => ({
    usersTotal: [],
  }),
  actions: {
    async fetchUsersTotal() {
      try {
        const response = await axios.get('http://127.0.0.1:8000/api/usersTotal');
        this.usersTotal = response.data;
      } catch (error) {
        console.error(error);
      }
    },
  },
});
