<template>
  <div>
    <CuadrosDatos />
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
      <h2 class="text-primary mb-1 fs-4">Incidencias <span v-if="priorityText">{{ priorityText }}</span></h2>
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
              <router-link :to="{ name: 'IncidenciaDetalles', query: { id: incidencia.id } }"
                class="d-block text-decoration-none" style="color: inherit;">
                {{ incidencia.id }}
              </router-link>
            </td>
            <td class="fs-6 p-1 text-center align-middle">
              <router-link :to="{ name: 'IncidenciaDetalles', query: { id: incidencia.id } }"
                class="d-block text-decoration-none" style="color: inherit;">
                {{ incidencia.titulo }}
              </router-link>
            </td>
            <td class="fs-6 p-1 text-center align-middle">
              <router-link :to="{ name: 'IncidenciaDetalles', query: { id: incidencia.id } }"
                class="d-block text-decoration-none" style="color: inherit;">
                {{ incidencia.nombre_maquina }}
              </router-link>
            </td>
            <td class="fs-6 p-1 text-center align-middle">
              <router-link :to="{ name: 'IncidenciaDetalles', query: { id: incidencia.id } }"
                class="d-block text-decoration-none" style="color: inherit;">
                <span v-if="incidencia.prioridad === 1" class="badge bg-danger">Alta</span>
                <span v-else-if="incidencia.prioridad === 2" class="badge bg-warning">Media</span>
                <span v-else class="badge bg-success">Baja</span>
              </router-link>
            </td>
            <td class="fs-6 p-1 text-center align-middle">
              <router-link :to="{ name: 'IncidenciaDetalles', query: { id: incidencia.id } }"
                class="d-block text-decoration-none" style="color: inherit;">
                <span v-if="incidencia.gravedad_incidencia === 1" class="badge bg-danger">Parada</span>
                <span v-else class="badge bg-success">Operativa</span>
              </router-link>
            </td>
            <td class="fs-6 p-1 text-center align-middle">
              <router-link :to="{ name: 'IncidenciaDetalles', query: { id: incidencia.id } }"
                class="d-block text-decoration-none" style="color: inherit;">
                {{ incidencia.fecha_creacion }}
              </router-link>
            </td>
            <td class="fs-6 p-1 text-center align-middle">
              <router-link :to="{ name: 'IncidenciaDetalles', query: { id: incidencia.id } }"
                class="d-block text-decoration-none" style="color: inherit;">
                {{ incidencia.categoria }}
              </router-link>
            </td>
          </tr>
        </tbody>
      </table>
      <!-- Paginación -->
      <div class="row">
        <div class="col d-flex justify-content-center">
          <nav aria-label="Page navigation">
            <ul class="pagination">
              <li class="page-item" :class="{ disabled: pagination.current_page === 1 }">
                <button class="page-link"
                        :disabled="pagination.current_page === 1"
                        @click="fetchIncidencias(null, pagination.current_page - 1)">
                  Anterior
                </button>
              </li>
              <li class="page-item" v-for="page in pages" :key="page"
                :class="{ active: page === pagination.current_page }">
                <button class="page-link" @click="fetchIncidencias(null, page)">{{ page }}</button>
              </li>
              <li class="page-item" :class="{ disabled: pagination.current_page === pagination.last_page }">
                <button class="page-link"
                        :disabled="pagination.current_page === pagination.last_page"
                        @click="fetchIncidencias(null, pagination.current_page + 1)">
                  Siguiente
                </button>
              </li>
            </ul>
          </nav>
        </div>
      </div>

      <hr>
      <h2 class="text-primary mb-1 fs-4">Mantenimientos</h2>
      <hr>
      <MantenimientosList />
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import CuadrosDatos from '@/components/CuadrosDatos.vue';
import IncidenciasList from '@/components/IncidenciasList.vue';
import FiltroCampus from '@/components/FiltroCampus.vue';
import MantenimientosList from '@/components/MantenimientosList.vue';
import { API_BASE_URL } from '@/config.js';

export default {
  name: 'Home',
  components: {
    CuadrosDatos,
    IncidenciasList,
    FiltroCampus,
    MantenimientosList,
  },
  data() {
    return {
      incidencias: [],
      selectedCampusId: null,
      selectedSectionId: null,
      resetFilters: false,
      pagination: {
        current_page: 1,
        last_page: 1,
        per_page: 10,
      },
      token: sessionStorage.getItem('token'),
    };
  },
  computed: {
    priorityText() {
      const priority = this.$route.query.priority;
      switch (priority) {
        case '1':
          return 'Prioridad 1';
        case '2':
          return 'Prioridad 2';
        case '3':
          return 'Prioridad 3';
        case '0':
          return 'Resueltas';
        default:
          return '';
      }
    },
    pages() {
      return Array.from({ length: this.pagination.last_page }, (_, i) => i + 1);
    },
  },
  watch: {
    '$route.query.priority': {
      immediate: true,
      handler(newPriority) {
        this.fetchIncidencias(newPriority);
      },
    },
  },
  methods: {
    fetchIncidencias(priority = null, page = 1) {
      let url = `${API_BASE_URL}/incidencias?page=${page}`;
      if (priority) {
        url += `&priority=${priority}`;
      }

      axios
        .get(url, {
          headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${this.token}`,
          },
        })
        .then((response) => {
          const apiResponse = response.data?.data;
          this.incidencias = apiResponse?.data || [];
          this.pagination = {
            current_page: apiResponse.current_page,
            last_page: apiResponse.last_page,
            per_page: apiResponse.per_page,
          };
        })
        .catch((error) => {
          console.error('Error al obtener las incidencias:', error);
          this.incidencias = [];
        });
    },
    aplicarFiltro() {
      console.log("Campus ID:", this.selectedCampusId);
      console.log("Section ID:", this.selectedSectionId);

      let url = `${API_BASE_URL}/incidencias`;
      
      if (this.selectedCampusId > 0) {
        console.log('campus ID: ', this.selectedCampusId);
        console.log('Section ID: ', this.selectedSectionId);
        if ( this.selectedSectionId > 0){
          url += `/section/${this.selectedSectionId}`;
        } else {
          url += `/campus/${this.selectedCampusId}`;
        }
        console.log('URL: ', url);
        
      }
      
      axios
        .get(url, {
          headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${this.token}`,
          },
        })
        .then((response) => {
          this.incidencias = response.data.data;
        })
        .catch((error) => {
          console.error(error);
        });
    },
    borrarFiltros() {
      this.selectedCampusId = null;
      this.selectedSectionId = null;
      this.resetFilters = true;
      setTimeout(() => {
        this.resetFilters = false;
      }, 0);
      this.$router.push('/home');
    },
    handleSelections({ campusId, sectionId }) {
      this.selectedCampusId = campusId;
      this.selectedSectionId = sectionId;
    },
  },
  created() {
    this.fetchIncidencias();
  },
};
</script>