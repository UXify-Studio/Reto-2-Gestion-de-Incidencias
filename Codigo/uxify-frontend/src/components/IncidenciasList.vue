<template>
    <div class="container mt-2z">
      <div class="row mb-3">
        <div class="col d-flex align-items-center">
            <FiltroCampus
            :resetFilters="resetFilters"
            @updateSelections="handleSelections"
            />
            <button class="btn btn-dark" @click="aplicarFiltro">Aplicar Filtro</button>
            <button class="btn btn-dark" @click="borrarFiltros">Borrar Filtros</button>
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
          <tr v-for="incidencia in incidencias" :key="incidencia.id">
            <td class="fs-6 p-1 text-center align-middle">
              <router-link :to="{ name: 'IncidenciaDetalles', params: { id: incidencia.id } }"
                class="d-block text-decoration-none" style="color: inherit;">
                {{ incidencia.id }}
              </router-link>
            </td>
            <td class="fs-6 p-1 text-center align-middle">
              <router-link :to="{ name: 'IncidenciaDetalles', params: { id: incidencia.id } }"
                class="d-block text-decoration-none" style="color: inherit;">
                {{ incidencia.titulo }}
              </router-link>
            </td>
            <td class="fs-6 p-1 text-center align-middle">
              <router-link :to="{ name: 'IncidenciaDetalles', params: { id: incidencia.id } }"
                class="d-block text-decoration-none" style="color: inherit;">
                {{ incidencia.nombre_maquina }}
              </router-link>
            </td>
            <td class="fs-6 p-1 text-center align-middle">
              <router-link :to="{ name: 'IncidenciaDetalles', params: { id: incidencia.id } }"
                class="d-block text-decoration-none" style="color: inherit;">
                <span v-if="incidencia.prioridad === 1" class="badge bg-danger">Alta</span>
                <span v-else-if="incidencia.prioridad === 2" class="badge bg-warning">Media</span>
                <span v-else class="badge bg-success">Baja</span>
              </router-link>
            </td>
            <td class="fs-6 p-1 text-center align-middle">
              <router-link :to="{ name: 'IncidenciaDetalles', params: { id: incidencia.id } }"
                class="d-block text-decoration-none" style="color: inherit;">
                <span v-if="incidencia.gravedad_incidencia === 1" class="badge bg-danger">Parada</span>
                <span v-else class="badge bg-success">Operativa</span>
              </router-link>
            </td>
            <td class="fs-6 p-1 text-center align-middle">
              <router-link :to="{ name: 'IncidenciaDetalles', params: { id: incidencia.id } }"
                class="d-block text-decoration-none" style="color: inherit;">
                {{ incidencia.fecha_creacion }}
              </router-link>
            </td>
            <td class="fs-6 p-1 text-center align-middle">
              <router-link :to="{ name: 'IncidenciaDetalles', params: { id: incidencia.id } }"
                class="d-block text-decoration-none" style="color: inherit;">
                {{ incidencia.categoria }}
              </router-link>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </template>

<script>
import axios from 'axios';
import SelectCampus from '@/components/SelectCampus.vue';
import CuadrosDatos from '@/components/CuadrosDatos.vue';
import FiltroCampus from '@/components/FiltroCampus.vue';
import { API_BASE_URL } from '@/config.js';

export default {
  name: 'IncidenciasList',
  components: {
    SelectCampus,
    CuadrosDatos,
    FiltroCampus,
  },
  data() {
    return {
      incidencias: [],
      selectedCampusId: null,
      selectedSectionId: null,
      resetFilters: false,
    };
  },
  watch: {
    // Observar cambios en el parámetro de consulta "priority"
    '$route.query.priority': {
      immediate: true,
      handler(newPriority) {
        this.fetchIncidencias(newPriority);
      },
    },
  },
  methods: {
    /*
    fetchIncidencias(campusId = null, sectionId = null) {
      let url = `${API_BASE_URL}/incidencias`;

      if (campusId > 0) {
        console.log('campus ID: ', campusId);
        console.log('Section ID: ', sectionId);
        if (sectionId > 0) {
          url += `/section/${sectionId}`;
        } else {
          url += `/campus/${campusId}`;
        }
        console.log('URL: ', url);

      }
      axios.get(url)
        .then(response => {
          this.incidencias = response.data.data;
        })
        .catch(error => {
          console.error(error);
        });
    },
    */

    fetchIncidencias(priority) {
      const params = {};
      if (priority) {
        params.priority = priority;
      }

      axios
        .get(`${API_BASE_URL}/incidencias`, { params })
        .then((response) => {
          this.incidencias = response.data.data || [];
        })
        .catch((error) => {
          console.error('Error al obtener las incidencias:', error);
        });
    },

    created() {
      this.fetchIncidencias();
    },

//this.fetchIncidencias(this.selectedCampusId, this.selectedSectionId);
    aplicarFiltro() {
        console.log("Campus ID:", this.selectedCampusId);
        console.log("Section ID:", this.selectedSectionId);
    },

    borrarFiltros() {
        this.selectedCampusId = null;
        this.selectedSectionId = null;
        this.resetFilters = true; // Activa el reset en el hijo
        setTimeout(() => {
            this.resetFilters = false; // Desactiva el reset después de un ciclo
        }, 0);
        this.$router.push('/home');
    },
    handleSelections({ campusId, sectionId }) {
        this.selectedCampusId = campusId;
        this.selectedSectionId = sectionId;
    },
  }
};
</script>