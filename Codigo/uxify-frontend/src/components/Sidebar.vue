<script>
import { ref } from 'vue';

export default {
  setup() {
    const showGestionSubmenu = ref(false);

    const toggleGestionSubmenu = () => {
      showGestionSubmenu.value = !showGestionSubmenu.value;
    };

    return {
      showGestionSubmenu,
      toggleGestionSubmenu,
    };
  },
};
</script>

<template>
  <div class="container-fluid bg-light border-end vh-100 height-100">
    <div class="row">
      <div class="col-12 d-flex align-items-center flex-column user-info p-3 pt-4">
        <img src="../assets/example.png" alt="Foto de perfil"
          class="profile-image rounded-circle mb-2 border border-secondary">
        <p class="user-name text-primary fw-bold mb-4">Juan La Matina</p>
      </div>
    </div>
    <nav class="menu">
      <router-link to="/home"
        class="menu-item row d-flex align-items-center py-2 px-3 text-decoration-none text-primary">
        <div class="col-auto">
          <i class="bi bi-house me-2">
            <img src="../assets/Inicio.png" alt="Inicio" class="menu-icon">
          </i>
        </div>
        <div class="col">
          <span>Inicio</span>
        </div>
      </router-link>
      <router-link to="/incidencias"
        class="menu-item row d-flex align-items-center py-2 px-3 text-decoration-none text-primary">
        <div class="col-auto">
          <i class="bi bi-exclamation-triangle me-2">
            <img src="../assets/Incidencias.png" alt="Incidencias" class="menu-icon">
          </i>
        </div>
        <div class="col">
          <span>Incidencias</span>
        </div>
      </router-link>
      <router-link to="/tipos-de-activo"
        class="menu-item row d-flex align-items-center py-2 px-3 text-decoration-none text-primary">
        <div class="col-auto">
          <i class="bi bi-gear me-2">
            <img src="../assets/Maquinas.png" alt="Tipos de activo" class="menu-icon">
          </i>
        </div>
        <div class="col">
          <span>Tipos de activo</span>
        </div>
      </router-link>
      <div class="menu-item row d-flex align-items-center py-2 px-3 text-decoration-none text-primary cursor-pointer"
        @click="toggleGestionSubmenu">
        <div class="col-auto">
          <i class="bi bi-list me-2">
            <img src="../assets/Administracion.png" alt="Administración" class="menu-icon">
          </i>
        </div>
        <div class="col">
          <span>Administración</span>
        </div>
        <div class="col-auto">
          <i :class="showGestionSubmenu ? 'bi bi-chevron-up' : 'bi bi-chevron-down'"></i>
        </div>
      </div>
      <div v-if="showGestionSubmenu" class="submenu pl-4">
        <router-link to="/gestion/users"
          class="menu-item row d-flex align-items-center py-2 px-3 text-decoration-none text-primary">
          <div class="col-auto">
            <i class="bi bi-person"></i>
          </div>
          <div class="col">
            <span>Gestión de Usuarios</span>
          </div>
        </router-link>
        <router-link to="/gestion/maquinas"
          class="menu-item row d-flex align-items-center py-2 px-3 text-decoration-none text-primary">
          <div class="col-auto">
            <i class="bi bi-cpu"></i>
          </div>
          <div class="col">
            <span>Gestión de Máquinas</span>
          </div>
        </router-link>
        <router-link to="/gestion/categorias"
          class="menu-item row d-flex align-items-center py-2 px-3 text-decoration-none text-primary">
          <div class="col-auto">
            <i class="bi bi-tags"></i>
          </div>
          <div class="col">
            <span>Gestión de Categorías</span>
          </div>
        </router-link>
        <router-link to="/gestion/campus"
          class="menu-item row d-flex align-items-center py-2 px-3 text-decoration-none text-primary">
          <div class="col-auto">
            <i class="bi bi-building"></i>
          </div>
          <div class="col">
            <span>Gestión de Campus</span>
          </div>
        </router-link>
        <router-link to="/gestion/secciones"
          class="menu-item row d-flex align-items-center py-2 px-3 text-decoration-none text-primary">
          <div class="col-auto">
            <i class="bi bi-diagram-3"></i>
          </div>
          <div class="col">
            <span>Gestión de Secciones</span>
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
          <span>Ayuda</span>
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