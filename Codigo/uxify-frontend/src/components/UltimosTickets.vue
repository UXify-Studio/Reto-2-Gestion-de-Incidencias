<template>
  <div class="container mt-2z">
    <h2 class="text-primary mb-1 fs-4">Ultimas Incidencias</h2>
    <hr>
    <div class="table-responsive">
      <table class="table table-bordered table-striped">
      <thead class="table-light">
        <tr>
          <th class="p-1 text-center align-middle">ID Ticket</th>
          <th class="p-1 text-center align-middle">Título</th>
          <th class="p-1 text-center align-middle">Maquina</th>
          <th class="p-1 text-center align-middle">Prioridad</th>
          <th class="p-1 text-center align-middle">Estado</th>
          <th class="p-1 text-center align-middle">Fec. creación</th>
          <th class="p-1 text-center align-middle">Categoría</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="incidencias in incidencias" :key="incidencias.id">
          <td class="fs-6 p-1 text-center align-middle">{{ incidencias.id }}</td>
          <td class="fs-6 p-1 text-center align-middle">{{ incidencias.titulo }}</td>
          <td class="fs-6 p-1 text-center align-middle">{{ incidencias.nombre_maquina }}</td>
          <td class="fs-6 p-1 text-center align-middle">{{ incidencias.prioridad }}</td>
          <td class="fs-6 p-1 text-center align-middle">
            <span v-if="incidencias.estado === 1" class="badge bg-success">Activa</span>
            <span v-else class="badge bg-danger">Inactiva</span>
          </td>
          <td class="fs-6 p-1 text-center align-middle">{{ incidencias.fecha_creacion }}</td>
          <td class="fs-6 p-1 text-center align-middle">{{ incidencias.categoria }}</td>
        </tr>
      </tbody>
    </table>
    </div>
    
  </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { API_BASE_URL } from '@/config.js';

export default {
  name: 'UltimosTickets',
  data() {
        return {
            incidencias: []
        };
    },
    created() {
        axios.get(`${API_BASE_URL}/incidencias/latest`)
            .then(response => {
              this.incidencias = response.data.data;
            })
            .catch(error => {
                console.error(error);
            });
    }
};
</script>
<style scoped>

</style>
  