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
  
  <style lang="scss" scoped>
  .sidebar {
    background-color: #F8F9FA; // Color de fondo de la barra lateral
    color: blue;
    width: 250px; // Ancho de la barra lateral
    padding: 20px;
    position: fixed; // Barra lateral fija
    top: 72px; // Ajusta según la altura de tu header si es necesario
    left: 0;
    height: calc(100vh - 72px); // Para que la barra lateral ocupe toda la altura menos la del header
    overflow-y: auto;  // Agrega una barra de desplazamiento si el contenido es demasiado largo
    .user-info {
      display: flex;
      align-items: center;
      margin-bottom: 20px;
      .profile-image {
        width: 50px; // Tamaño de la imagen de perfil
        height: 50px;
        border-radius: 50%; // Para hacer la imagen circular
        margin-right: 10px;
      }
      .user-name {
        font-weight: bold;
      }
    }
    .menu {
      .menu-item { // Estilos para los elementos del menú
        display: flex;
        align-items: center; // Alinea icono y texto verticalmente
        padding: 10px 0; // Espacio superior e inferior entre items
        color: lightblue;
        text-decoration: none;
  
        i { // Estilos para los iconos
          margin-right: 10px; // Espacio entre el icono y el texto
          font-size: 1.2rem; // Ajusta el tamaño del icono si es necesario
        }
  
        &.router-link-active { // Clase activa para el elemento del menú actual
            font-weight: bold; // O cualquier otro estilo que quieras aplicar
        }
  
  
      }
    }
  }
  
  </style>