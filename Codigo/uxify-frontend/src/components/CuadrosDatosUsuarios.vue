<template>
    <Container class="text-white py-2">
      <div class="container-fluid">
        <div class="row align-items-center p-2" >
          <div class="col-12">
            <div class="d-flex gap-2 " >
                <router-link to="users" class="card text-white bg-danger w-100 text-decoration-none">
                    <div class="card-body text-center p-2 d-flex flex-column justify-content-center">
                        <img src="../assets/totalUsers.svg" alt="Icono" class="icono-tarjeta mb-2">
                        <p class="mb-1">Usuarios Totales</p>
                        <h3 class="card-title mb-0 display-6">20</h3>
                    </div>
                </router-link>
                <router-link to="administradores" class="card text-white bg-warning w-100 text-decoration-none">
                    <div class="card-body text-center p-3 d-flex flex-column justify-content-center">
                        <img src="../assets/totalUsers.svg" alt="Icono" class="icono-tarjeta mb-2">
                        <p class="mb-1">Usuarios Administradores</p>
                        <h3 class="card-title mb-0 display-6">2</h3>
                    </div>
                </router-link>
                <router-link to="tecnicos" class="card text-white bg-success w-100 text-decoration-none"> 
                    <div class="card-body text-center p-3 d-flex flex-column justify-content-center ">
                        <img src="../assets/totalUsers.svg" alt="Icono" class="icono-tarjeta mb-2">
                        <p class="mb-1">Usuarios Tecnicos</p>
                        <h3 class="card-title mb-0 display-6">2</h3>
                    </div>
                </router-link>
                <router-link to="operarios" class="card text-white bg-resueltos w-100 text-decoration-none">
                    <div class="card-body text-center p-3 d-flex flex-column justify-content-center">
                        <img src="../assets/totalUsers.svg" alt="Icono" class="icono-tarjeta mb-2">
                        <p class="mb-1">Usuarios Operarios</p>
                        <h3 class="card-title mb-0 display-6">56</h3>
                    </div>
                </router-link>
            </div>
          </div>
        </div>
      </div>
    </Container>
  </template>
  
  <script>
  export default {
    name: 'CuadrosDatosUsuarios',
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