<template>
    <aside class="sidebar">
      <div class="user-info">
        <img src="../assets/Ellipse.png" alt="Foto de perfil" class="profile-image">
        <p class="user-name">Juan La Matina</p>
      </div>
      <nav class="menu">
         <router-link to="/" class="menu-item">
           <i class="bi bi-house"></i> Inicio
         </router-link>
        <router-link to="/incidencias" class="menu-item">
          <i class="bi bi-exclamation-triangle"></i> Incidencias
        </router-link>
        <router-link to="/tipos-de-activo" class="menu-item">
          <i class="bi bi-gear"></i> Tipos de activo
        </router-link>
        <router-link to="/administracion" class="menu-item">
          <i class="bi bi-list"></i> Administración
        </router-link>
        <router-link to="/ayuda" class="menu-item">
          <i class="bi bi-question-circle"></i> Ayuda
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

  </style>