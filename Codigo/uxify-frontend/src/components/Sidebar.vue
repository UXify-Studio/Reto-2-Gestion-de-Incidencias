<template>
    <aside class="sidebar">
      <div class="user-info">
        <img src="../assets/example.png" alt="Foto de perfil" class="profile-image">
        <p class="user-name">Juan La Matina</p>
      </div>
      <nav class="menu">
         <router-link to="/" class="menu-item">
           <i class="bi bi-house"><img src="../assets/Inicio.png"></i> Inicio
         </router-link>
        <router-link to="/incidencias" class="menu-item">
          <i class="bi bi-exclamation-triangle"><img src="../assets/Incidencias.png"></i> Incidencias
        </router-link>
        <router-link to="/tipos-de-activo" class="menu-item">
          <i class="bi bi-gear"><img src="../assets/Maquinas.png"></i> Tipos de activo
        </router-link>
        <router-link to="/administracion" class="menu-item">
          <i class="bi bi-list"><img src="../assets/Administracion.png"></i> Administración
        </router-link>
        <router-link to="/ayuda" class="menu-item">
          <i class="bi bi-question-circle"><img src="../assets/Ayuda.png"></i> Ayuda
        </router-link>
      </nav>
    </aside>
  </template>
  
  <script>
  export default {
    name: 'Sidebar',
  };
  </script>
  
  <style scoped>
  .sidebar {
  background-color: #F8F9FA;
  color: blue;
  width: 250px;
  padding: 20px;
  position: fixed;
  top: 56px;
  left: 0;
  height: calc(100vh - 56px); /* Corregido: 100vh, no 1000vh */
  overflow-y: auto;
}

.sidebar .user-info {
  display: flex;
  align-items: center;
  margin-bottom: 20px;
}

.sidebar .user-info .profile-image {
  width: 50px;
  height: 50px;
  border-radius: 50%;
  margin-right: 10px;
}

.sidebar .user-info .user-name {
  font-weight: bold;
}

.sidebar .menu .menu-item {
  display: flex;
  align-items: center;
  padding: 10px 0;
  color: #007BFF;
  text-decoration: none;
}

.sidebar .menu .menu-item i {
  margin-right: 10px;
  font-size: 1.2rem;
}

.sidebar .menu .menu-item.router-link-active {
  font-weight: bold;
}
  </style>