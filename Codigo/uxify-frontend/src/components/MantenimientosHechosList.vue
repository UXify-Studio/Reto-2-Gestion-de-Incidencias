<template>
    <div>
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
                              {{mantenimiento.proxima_fecha }}
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
  import { useMantenimientosHechos, useMantenimientosStore } from '@/stores/mantenimientos';
  
  export default{
      name: 'MantenimientosList',
  
      // Usamos setup() para trabajar con Pinia
      setup(){
      const mantenimientosHechos = useMantenimientosHechos();
  
      // Llama al método para obtener los datos
      onMounted(() => {
        mantenimientosHechos.fetchMantenimientosHechos(1);
      });
  
      // Computed para acceder al estado de manera reactiva
      const mantenimientos = computed(() => mantenimientosHechos.mantenimientos);
      const pagination = computed(() => ({
        current_page: mantenimientosHechos.current_page,
        last_page: mantenimientosHechos.last_page,
        per_page: mantenimientosHechos.per_page,
      }));
  
      // Método para ir a una página específica
      const goToPage = (page) => {
        if (page > 0 && page <= pagination.value.last_page) {
            mantenimientosHechos.fetchMantenimientosProximos(page);
        }
      };
  
      return {
        mantenimientos,
        pagination,
        goToPage,
        pages: computed(() => Array.from({ length: pagination.value.last_page }, (_, i) => i + 1)),
      };
    },
  }
  </script>