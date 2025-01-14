<template>
  <aside class="sidebar bg-light border-end">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12 d-flex align-items-center flex-column user-info p-3 pt-4">
          <img src="../assets/example.png" alt="Foto de perfil"
            class="profile-image rounded-circle mb-2 border border-secondary">
          <p class="user-name text-primary fw-bold mb-4">Juan La Matina</p>
        </div>
      </div>
      <nav class="menu">
        <router-link to="/" class="menu-item row d-flex align-items-center py-2 px-3 text-decoration-none text-primary">
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
        <router-link to="/administracion"
          class="menu-item row d-flex align-items-center py-2 px-3 text-decoration-none text-primary">
          <div class="col-auto">
            <i class="bi bi-list me-2">
              <img src="../assets/Administracion.png" alt="Administración" class="menu-icon">
            </i>
          </div>
          <div class="col">
            <span>Administración</span>
          </div>
        </router-link>
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
  </aside>
</template>

<script>
export default {
  name: 'Sidebar',
};
</script>

<style scoped>
.sidebar {
  width: 220px;
  height: 100vh;
  display: flex;
  flex-direction: column;
}

.menu-item:hover {
  background-color: #e9ecef;
}

.menu-icon {
  width: 16px;
  /* Adjust icon size */
  height: 16px;
  vertical-align: middle;
  margin-right: 8px;
}
</style>