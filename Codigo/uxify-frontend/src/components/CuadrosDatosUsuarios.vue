<template>
  <Container class="text-white py-2">
    <div class="container-fluid">
      <div class="row align-items-center p-2">
        <div class="col-12">
          <div class="d-flex gap-2">
            <!-- Enlace para "Usuarios Totales" (sin filtro) -->
            <router-link
              :to="{ path: 'users', query: { role: '' } }"
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
                <p class="mb-1">Usuarios Totales</p>
                <h3 class="card-title mb-0 display-6">{{ usersTotal > 0 ? usersTotal : 'Cargando...' }}</h3>
              </div>
            </router-link>

            <!-- Enlace para "Usuarios Administradores" -->
            <router-link
              :to="{ path: 'users', query: { role: 'Administrador' } }"
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
                <p class="mb-1">Usuarios Administradores</p>
                <h3 class="card-title mb-0 display-6">{{ usersAdmin > 0 ? usersAdmin : 'Cargando...' }}</h3>
              </div>
            </router-link>

            <!-- Enlace para "Usuarios Técnicos" -->
            <router-link
              :to="{ path: 'users', query: { role: 'Tecnico' } }"
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
                <p class="mb-1">Usuarios Técnicos</p>
                <h3 class="card-title mb-0 display-6">{{ usersTecnico > 0 ? usersTecnico : 'Cargando...' }}</h3>
              </div>
            </router-link>

            <!-- Enlace para "Usuarios Operarios" -->
            <router-link
              :to="{ path: 'users', query: { role: 'Operario' } }"
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
                <p class="mb-1">Usuarios Operarios</p>
                <h3 class="card-title mb-0 display-6">{{ usersOperario > 0 ? usersOperario : 'Cargando...' }}</h3>
              </div>
            </router-link>
          </div>
        </div>
      </div>
    </div>
  </Container>
</template>

<script>
import { useUsersStore } from '../stores/users';
import { computed, onMounted } from 'vue';

export default {
  name: "CuadrosDatosUsuarios",
  data() {
    return {
      selectedRole: this.$route.query.role || 'Todos', // Establecer el valor de 'role' desde la URL
    };
  },
  watch: {
    '$route.query.role': function (newRole) {
      this.selectedRole = newRole || 'Todos'; // Actualizar el valor cuando cambia la URL
    },
  },

  // Usamos setup() para trabajar con Pinia
  setup() {
    const usersStore = useUsersStore();

    // Llama al método para obtener los datos
    onMounted(() => {
      usersStore.fetchUsersTotal();
    });

    // Computed para acceder al estado de manera reactiva
    const usersTotal = computed(() => usersStore.usersTotal);
    const usersAdmin = computed(() => usersStore.usersAdmin);
    const usersTecnico = computed(() => usersStore.usersTenico);
    const usersOperario = computed(() => usersStore.usersOperario);

    return {
      usersTotal, usersAdmin, usersTecnico, usersOperario
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
