<template>
  <div class="table-responsive">
    <table class="table table-bordered table-striped">
            <thead class="table-light">
            <tr>
                <th class="p-1 text-center align-middle">ID Mantenimiento</th>
                <th class="p-1 text-center align-middle">Descripcion</th>
                <th class="p-1 text-center align-middle">Maquina</th>
                <th class="p-1 text-center align-middle">Abierto Por</th>
                <th class="p-1 text-center align-middle">Periodo</th>
                <th class="p-1 text-center align-middle">Proxima Fecha</th>
            </tr>
            </thead>
            <tbody>
                <tr v-for="mantenimiento in mantenimientos" :key="mantenimiento.id">
                    <td class="fs-6 p-1 text-center align-middle">
                        <router-link :to="{ name: 'MantenimientosDetalles', query: { id: mantenimiento.id } }"
                            class="d-block text-decoration-none" style="color: inherit;">
                            {{ mantenimiento.id }}
                        </router-link>
                    </td>
                    <td class="fs-6 p-1 text-center align-middle">
                        <router-link :to="{ name: 'MantenimientosDetalles', query: { id: mantenimiento.id } }"
                            class="d-block text-decoration-none" style="color: inherit;">
                            {{mantenimiento.descripcion }}
                        </router-link>
                    </td>                        
                    <td class="fs-6 p-1 text-center align-middle">
                        <router-link :to="{ name: 'MantenimientosDetalles', query: { id: mantenimiento.id } }"
                            class="d-block text-decoration-none" style="color: inherit;">
                            {{mantenimiento.maquina.nombre }}
                        </router-link>
                    </td>
                    <td class="fs-6 p-1 text-center align-middle">
                        <router-link :to="{ name: 'MantenimientosDetalles', query: { id: mantenimiento.id } }"
                            class="d-block text-decoration-none" style="color: inherit;">
                            {{mantenimiento.usuario.username }}
                        </router-link>
                    </td>
                    <td class="fs-6 p-1 text-center align-middle">
                        <router-link :to="{ name: 'MantenimientosDetalles', query: { id: mantenimiento.id } }"
                            class="d-block text-decoration-none" style="color: inherit;">
                            {{mantenimiento.periodo }}
                        </router-link>
                    </td>
                    <td class="fs-6 p-1 text-center align-middle">
                        <router-link :to="{ name: 'MantenimientosDetalles', query: { id: mantenimiento.id } }"
                            class="d-block text-decoration-none" style="color: inherit;">
                            {{ formatDate(mantenimiento.proxima_fecha) }}
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
                        @click="goToPage(pagination.current_page - 1)">
                  Anterior
                </button>
              </li>
              <li class="page-item" v-for="page in pages" :key="page"
                :class="{ active: page === pagination.current_page }">
                <button class="page-link" @click="goToPage(page)">{{ page }}</button>
              </li>
              <li class="page-item" :class="{ disabled: pagination.current_page === pagination.last_page }">
                <button class="page-link" 
                        :disabled="pagination.current_page === pagination.last_page" 
                        @click="goToPage(pagination.current_page + 1)">
                  Siguiente
                </button>
              </li>
            </ul>
          </nav>
        </div>
      </div>
  </div>
</template>


<script>
import { computed, onMounted } from 'vue';
import { useMantenimientosStore } from '@/stores/mantenimientos';

export default{
    name: 'MantenimientosList',

    // Usamos setup() para trabajar con Pinia
    setup(){
    const mantenimientosStore = useMantenimientosStore();

    // Llama al método para obtener los datos
    onMounted(() => {
        mantenimientosStore.fetchMantenimientosProximos(1);
    });

    // Computed para acceder al estado de manera reactiva
    const mantenimientos = computed(() => mantenimientosStore.mantenimientos);
    const pagination = computed(() => ({
      current_page: mantenimientosStore.current_page,
      last_page: mantenimientosStore.last_page,
      per_page: mantenimientosStore.per_page,
    }));

    // Método para ir a una página específica
    const goToPage = (page) => {
      if (page > 0 && page <= pagination.value.last_page) {
        mantenimientosStore.fetchMantenimientosProximos(page);
      }
    };
    const formatDate = (dateString) => {
      if (!dateString) return '';

      try {
        const date = new Date(dateString);
        const day = String(date.getDate()).padStart(2, '0');
        const month = String(date.getMonth() + 1).padStart(2, '0'); // Month is 0-indexed
        const year = date.getFullYear();
        return `${day}/${month}/${year}`;
      } catch (error) {
        console.error("Error formatting date:", error, dateString);
        return 'Invalid Date Format';
      }
    };

    return {
      mantenimientos,
      pagination,
      goToPage,
      pages: computed(() => Array.from({ length: pagination.value.last_page }, (_, i) => i + 1)),
      formatDate,
    };
  },
}
</script>