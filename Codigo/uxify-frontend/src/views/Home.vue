<template>
  <div>
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
    </div>
  </div>
</template>

<script>
import CuadrosDatos from '@/components/CuadrosDatos.vue';
import IncidenciasList from '@/components/IncidenciasList.vue';

export default {
  name: 'Home',
  components: {
    CuadrosDatos,
    IncidenciasList,
  },
};
</script>
