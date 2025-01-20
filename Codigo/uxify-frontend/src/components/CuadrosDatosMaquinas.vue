<template>
  <Container class="text-white py-2">
    <div class="container-fluid">
      <div class="row align-items-center p-2">
        <div class="col-12">
          <div class="d-flex gap-2">
            <!-- Enlace para "Maquinas Totales" (sin filtro) -->
            <router-link
              :to="{ path: 'maquinas', query: { prioridad: '' } }"
              class="card text-white bg-danger w-100 text-decoration-none"
            >
              <div
                class="card-body text-center p-2 d-flex flex-column justify-content-center"
              >
                <img
                  src="../assets/totalUsers.svg"
                  alt="Icono"
                  class="icono-tarjeta mb-2"
                />
                <p class="mb-1">Maquinas Totales</p>
                <h3 class="card-title mb-0 display-6">{{ maquinasTotal > 0 ? maquinasTotal : 'Cargando...' }}</h3>
              </div>
            </router-link>

            <!-- Enlace para "Maquinas Prioridad 1" -->
            <router-link
              :to="{ path: 'maquinas', query: { prioridad: '1' } }"
              class="card text-white bg-warning w-100 text-decoration-none"
            >
              <div
                class="card-body text-center p-3 d-flex flex-column justify-content-center"
              >
                <img
                  src="../assets/totalUsers.svg"
                  alt="Icono"
                  class="icono-tarjeta mb-2"
                />
                <p class="mb-1">Maquinas Prioridad 1</p>
                <h3 class="card-title mb-0 display-6">{{ maqPrioridad1 > 0 ? maqPrioridad1 : 'Cargando...' }}</h3>
              </div>
            </router-link>

            <!-- Enlace para "Maquinas Prioridad 2" -->
            <router-link
              :to="{ path: 'maquinas', query: { prioridad: '2' } }"
              class="card text-white bg-success w-100 text-decoration-none"
            >
              <div
                class="card-body text-center p-3 d-flex flex-column justify-content-center"
              >
                <img
                  src="../assets/totalUsers.svg"
                  alt="Icono"
                  class="icono-tarjeta mb-2"
                />
                <p class="mb-1">Maquinas Prioridad 2</p>
                <h3 class="card-title mb-0 display-6">{{ maqPrioridad2 > 0 ? maqPrioridad2 : 'Cargando...' }}</h3>
              </div>
            </router-link>

            <!-- Enlace para "Maquinas Prioridad 3" -->
            <router-link
              :to="{ path: 'maquinas', query: { prioridad: '3' } }"
              class="card text-white bg-resueltos w-100 text-decoration-none"
            >
              <div
                class="card-body text-center p-3 d-flex flex-column justify-content-center"
              >
                <img
                  src="../assets/totalUsers.svg"
                  alt="Icono"
                  class="icono-tarjeta mb-2"
                />
                <p class="mb-1">Maquinas Prioridad 3</p>
                <h3 class="card-title mb-0 display-6">{{ maqPrioridad3 > 0 ? maqPrioridad3 : 'Cargando...' }}</h3>
              </div>
            </router-link>
          </div>
        </div>
      </div>
    </div>
  </Container>
</template>

<script>
import { useMaquinasStore } from '../stores/maquinas';
import { computed, onMounted } from 'vue';

export default {
  name: "CuadrosDatosMaquinas",
  data() {
    return {
      selectedPriority: this.$route.query.prioridad || 'Todos', // Establecer el valor de 'role' desde la URL
    };
  },
  watch: {
    '$route.query.prioridad': function (newPriority) {
      this.selectedPriority = newPriority || 'Todos'; // Actualizar el valor cuando cambia la URL
    },
  },

  // Usamos setup() para trabajar con Pinia
  setup() {
    const maquinasStore = useMaquinasStore();

    // Llama al método para obtener los datos
    onMounted(() => {
      maquinasStore.fetchMaquinasTotal();
    });

    // Computed para acceder al estado de manera reactiva
    const maquinasTotal = computed(() => maquinasStore.maquinasTotal);
    const maqPrioridad1 = computed(() => maquinasStore.maqPrioridad1);
    const maqPrioridad2 = computed(() => maquinasStore.maqPrioridad2);
    const maqPrioridad3 = computed(() => maquinasStore.maqPrioridad3);

    return {
      maquinasTotal, maqPrioridad1, maqPrioridad2, maqPrioridad3
    };
  },
};
</script>

<style scoped>
.icono-tarjeta {
  width: 24px;
  height: 24px;
  margin: 0 auto;
  display: block;
}
</style>
