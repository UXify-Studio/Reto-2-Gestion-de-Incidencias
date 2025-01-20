<template>
  <div class="container mt-1">
    <h2 class="text-primary mb-1 fs-4">Incidencias por Categoría</h2>
    <hr>
    <table class="table table-bordered table-striped">
      <thead class="table-light">
        <tr>
          <th class="p-1 text-center align-middle">Categoría</th>
          <th class="p-1 text-center align-middle">Prioridad 1</th>
          <th class="p-1 text-center align-middle">Prioridad 2</th>
          <th class="p-1 text-center align-middle">Prioridad 3</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(categoria, nombre) in categoriasPorNombre" :key="nombre">
          <td class="text-center align-middle">{{ nombre }}</td>
          <td class="text-center align-middle">{{ getCantidadIncidencias(categoria, 1) }}</td>
          <td class="text-center align-middle">{{ getCantidadIncidencias(categoria, 2) }}</td>
          <td class="text-center align-middle">{{ getCantidadIncidencias(categoria, 3) }}</td>
          
          
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import { ref, onMounted, computed } from 'vue';
import axios from 'axios';
import { API_BASE_URL } from '@/config';

export default {
  name: 'IncidenciasPorCategoria',
  data() {
    return {
      incidencias: []
    };
  },
  computed: {
    categoriasPorNombre() {
      const categorias = {};
      if (this.incidencias && this.incidencias.data) { // Verificar si existen datos.
         this.incidencias.data.forEach(incidencia => {
            if (!categorias[incidencia.nombre]) {
                categorias[incidencia.nombre] = [];
            }
            categorias[incidencia.nombre].push(incidencia);
        });
      }
      
      return categorias;
    }
  },
  methods: {
    getCantidadIncidencias(incidenciasCategoria, prioridad) {
      if (!incidenciasCategoria) return 0; // Manejar el caso donde no hay incidencias para una categoría
      return incidenciasCategoria.filter(incidencia => incidencia.prioridad === prioridad)
                                 .reduce((sum, incidencia) => sum + incidencia.cantidad_incidencias, 0);


    }
  },
  created() {
    axios.get(`${API_BASE_URL}/categorias/prioridad`)
      .then(response => {
        this.incidencias = response.data;
      })
      .catch(error => {
        console.error(error);
      });
  }
};
</script>