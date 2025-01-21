<script>
import axios from 'axios';
import SelectCampus from '@/components/SelectCampus.vue';
import CuadrosDatos from '@/components/CuadrosDatos.vue';
import { API_BASE_URL } from '@/config.js';

export default {
  name: 'Home',
  components: {
    SelectCampus,
    CuadrosDatos,
  },
  data() {
    return {
      incidencias: [],
      selectedCampusId: null,
      selectedSectionId: null,
    };
  },
  created() {
    this.fetchIncidencias();
  },
  methods: {
    async fetchIncidencias(campusId = null, sectionId = null) {
      try {
        const token = sessionStorage.getItem('token');
        if (!token) {
          throw new Error('No token found');
        }
        let url = `${API_BASE_URL}/incidencias`;
        if (campusId > 0) {
          url += `?campus_id=${campusId}`;
        }
        if (sectionId > 0) {
          url += campusId > 0 ? `&section_id=${sectionId}` : `?section_id=${sectionId}`;
        }
        const response = await axios.get(url, {
          headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${token}`
          }
        });
        this.incidencias = response.data.data;
      } catch (error) {
        console.error('Error al obtener las incidencias:', error);
      }
    }
  }
};
</script>

<template>
  <CuadrosDatos />
  
  
  <div class="container mt-2z">
    <div class="row mb-3">
      <div class="col d-flex align-items-center">
        <SelectCampus 
        v-model:selectedCampusId="selectedCampusId" 
        v-model:selectedSectionId="selectedSectionId" />
        <button class="btn btn-dark" @click="aplicarFiltro">Aplicar Filtro</button>
      </div>
    </div>
    <h2 class="text-primary mb-1 fs-4">Incidencias</h2>
    <hr>
    <table class="table table-bordered table-striped">
      <thead class="table-light">
        <tr>
          <th class="p-1 text-center align-middle">ID Incidencia</th>
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
          <td class="fs-6 p-1 text-center align-middle">
            <span v-if="incidencias.prioridad === 1" class="badge bg-danger">Alta</span>
            <span v-else-if="incidencias.prioridad === 2" class="badge bg-warning">Media</span>
            <span v-else class="badge bg-success">Baja</span>
          </td>
          <td class="fs-6 p-1 text-center align-middle">
            <span v-if="incidencias.gravedad_incidencia === 1" class="badge bg-danger">Parada</span>
            <span v-else class="badge bg-success">Operativa</span>
          </td>
          <td class="fs-6 p-1 text-center align-middle">{{ incidencias.fecha_creacion }}</td>
          <td class="fs-6 p-1 text-center align-middle">{{ incidencias.categoria }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>