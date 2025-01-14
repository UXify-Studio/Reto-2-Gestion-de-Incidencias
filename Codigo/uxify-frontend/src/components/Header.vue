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

  </style>