<template>
    <header class="header bg-head-color">
      <div class="container">
        <div class="d-flex align-items-center">
          <h1 class="ms-2 mb-0"><router-link to="/" class="navbar-brand">UXify Workshop Software</router-link></h1>
        </div>
      </div>
      <div class="icon-group">
        <i class="bi bi-bell"><img src="../assets/Notifi.png" class="icon"></i>
        <i class="bi bi-gear"><router-link to="/register" class="nav-link"><img src="../assets/Config.png" class="icon"></router-link></i>
        <i class="bi bi-power"><router-link to="/login" class="nav-link"><img src="../assets/Session.png" class="icon"></router-link></i>
      </div>
    </header>
  </template>
  
  <script>
  export default {
    name: 'Header',
  };
  </script>
  
  <style scoped>
    .header {
      background-color: #6345FB;
      color: white;
      padding: 1rem;
      display: flex;
      align-items: center;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      z-index: 1000;
      max-height: 60px;
      gap: 200px; /* Espacio entre el título y el grupo de iconos */
    }

    .header h1 {
      font-size: 20px;
    }

    .header .icon-group {
      display: inline-flex;
      align-items: center;
      gap: 10px; /* Espacio entre los iconos */
    }

    .header .icon-group .icon {
      width: 18px;
      height: 18px;
      margin-left: 15px; /* Espacio entre cada icono. Puedes ajustar o eliminar si usas gap */
      cursor: pointer;
    }

    .header .icon-group .icon:hover {
      opacity: 0.8;
    }
  </style>