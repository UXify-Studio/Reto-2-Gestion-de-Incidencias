<template>
    <header class="header">
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
  
  <style lang="scss" scoped>
  
  .header {
  background-color: #6345FB;
  color: white;
  padding: 1rem;
  display: flex;
  align-items: center;
  position: fixed; /* Para que la barra esté fija en la parte superior */
  top: 0;
  left: 0;
  width: 100%;
  z-index: 1000; // Asegura que el header esté por encima de otros elementos
  max-height: 60px;
  gap: 200px;
  
  h1{
    font-size:20px;
  }

  .icon-group {
    display: inline-flex;
    align-items: center;
    gap: 10px;

    .icon { // Estilos para las imágenes de los iconos
      width: 18px; // Ajusta el tamaño según sea necesario
      height: 18px;
      margin-left: 15px;
      cursor: pointer;
      &:hover {
        opacity: 0.8;
      }
    }

  }
}
  </style>