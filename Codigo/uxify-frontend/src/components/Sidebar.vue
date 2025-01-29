<script>
import { ref } from 'vue';
import { computed, onMounted } from 'vue';
import { useLoggedUser }  from '@/stores/loggedUser';

export default {
  setup() {
    const loggedUserStore = useLoggedUser();
    const showGestionSubmenu = ref(false);

    onMounted(() => {
      loggedUserStore.fetchUsersTotal();
    });

    const toggleGestionSubmenu = () => {
      showGestionSubmenu.value = !showGestionSubmenu.value;
    };

    const loggedUser = computed(() => loggedUserStore.userName);

    return {
      showGestionSubmenu,
      toggleGestionSubmenu,
      loggedUser,
    };
  },
};
</script>

<template>
  <div class="container-fluid bg-light border-end vh-100 height-100">
    <nav class="menu">
      <div class="col-12 d-flex align-items-center flex-column user-info p-3 pt-4">
        <img src="../assets/example.png" alt="Foto de perfil"
          class="profile-image rounded-circle mb-2 border border-secondary">
        <p class="user-name text-primary fw-bold mb-4">{{ loggedUser }}</p>
      </div>
      <router-link to="/home"
        class="menu-item row d-flex align-items-center py-2 px-3 text-decoration-none text-primary">
        <div class="col-auto">
          <i class="bi bi-house me-2">
            <img src="../assets/Inicio.png" alt="Inicio" class="menu-icon">
          </i>
        </div>
        <div class="col">
          <span class="d-none d-md-block">Inicio</span>
        </div>
      </router-link>
      <router-link to="/estadisticas"
        class="menu-item row d-flex align-items-center py-2 px-3 text-decoration-none text-primary">
        <div class="col-auto">
          <i class="bi bi-exclamation-triangle me-2">
            <img src="../assets/Incidencias.png" alt="Estadisticas" class="menu-icon">
          </i>
        </div>
        <div class="col">
          <span class="d-none d-md-block">Estadisticas</span>
        </div>
      </router-link>
      <div class="menu-item row d-flex align-items-center py-2 px-3 text-decoration-none text-primary cursor-pointer"
        @click="toggleGestionSubmenu">
        <div class="col-auto">
          <i class="bi bi-list me-2">
            <img src="../assets/Administracion.png" alt="Administración" class="menu-icon ">
          </i>
        </div>
        <div class="col">
          <span class="d-none d-md-block">Administración</span>
        </div>
        <div class="col-auto">
          <i :class="showGestionSubmenu ? 'bi bi-chevron-up' : 'bi bi-chevron-down'"></i>
        </div>
      </div>
      <div v-if="showGestionSubmenu" class="submenu pl-4">
        <router-link to="/gestion/users"
          class="menu-item row d-flex align-items-center py-2 px-3 text-decoration-none text-primary">
          <div class="col-auto">
            <i class="bi">
              <img src="../assets/people-fill.svg" alt="Gestion de Usuarios">
            </i>
          </div>
          <div class="col">
            <span class="d-none d-md-block">Gestión de Usuarios</span>
          </div>
        </router-link>
        <router-link to="/gestion/maquinas"
          class="menu-item row d-flex align-items-center py-2 px-3 text-decoration-none text-primary">
          <div class="col-auto">
            <i class="bi">
              <img src="../assets/tools.svg" alt="Gestion de Maquinas">
            </i>
          </div>
          <div class="col">
            <span class="d-none d-md-block">Gestión de Máquinas</span>
          </div>
        </router-link>
        <router-link to="/gestion/categorias"
          class="menu-item row d-flex align-items-center py-2 px-3 text-decoration-none text-primary">
          <div class="col-auto">
            <i class="bi">
              <img src="../assets/tags-fill.svg" alt="Gestion de Categorias">
            </i>
          </div>
          <div class="col">
            <span class="d-none d-md-block">Gestión de Categorías</span>
          </div>
        </router-link>
        <router-link to="/gestion/campus"
          class="menu-item row d-flex align-items-center py-2 px-3 text-decoration-none text-primary">
          <div class="col-auto">
            <i class="bi">
              <img src="../assets/buildings-fill.svg" alt="Gestion de Campus">
            </i>
          </div>
          <div class="col">
            <span class="d-none d-md-block">Gestión de Campus</span>
          </div>
        </router-link>
        <router-link to="/gestion/secciones"
          class="menu-item row d-flex align-items-center py-2 px-3 text-decoration-none text-primary">
          <div class="col-auto">
            <i class="bi">
              <img src="../assets/box-seam-fill.svg" alt="Gestion de Secciones">
            </i>
          </div>
          <div class="col">
            <span class="d-none d-md-block">Gestión de Secciones</span>
          </div>
        </router-link>
      </div>
      <router-link to="/ayuda"
        class="menu-item row d-flex align-items-center py-2 px-3 text-decoration-none text-primary">
        <div class="col-auto">
          <i class="bi bi-question-circle me-2">
            <img src="../assets/Ayuda.png" alt="Ayuda" class="menu-icon">
          </i>
        </div>
        <div class="col">
          <span class="d-none d-md-block">Ayuda</span>
        </div>
      </router-link>
    </nav>
  </div>
</template>

<style scoped>
.sidebar {
  width: 100%;
}
.menu-item {
  cursor: pointer;
}
.submenu {
  padding-left: 1rem;
}
</style>