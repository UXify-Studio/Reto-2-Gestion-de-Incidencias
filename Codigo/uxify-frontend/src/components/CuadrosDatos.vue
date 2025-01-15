<template>
    <Container class="bg-primary text-white py-2">
      <div class="container-fluid">
        <div class="row align-items-center p-2" >
          <div class="col-md-12 d-flex justify-content-end pb-3" >
            <button @click="addTicket" class="btn btn-primary">Añadir Ticket</button>
          </div>
          <div class="col-12">
            <div class="d-flex gap-4 " >
              <div class="card text-white text-center p-4 bg-danger justify-content-center align-items-center">
                <img src="../assets/Prioridad.png" alt="Icono" class="mb-2">
                <p class="mb-0">Tickets Prioridad 1</p>
                <h3 class="card-title mb-0">20</h3>
              </div>
              <div class="card text-white text-center p-4 bg-warning justify-content-center align-items-center">
                  <img src="../assets/Prioridad.png" alt="Icono" class="mb-2">
                <p class="mb-0">Tickets Prioridad 2</p>
                <h3 class="card-title mb-0">2</h3>
              </div>
              <div class="card text-white text-center p-4 bg-success justify-content-center align-items-center">
                  <img src="../assets/Prioridad.png" alt="Icono" class="mb-2">
                <p class="mb-0">Tickets Prioridad 3</p>
                <h3 class="card-title mb-0">2</h3>
              </div>
              <div class="card text-white text-center p-4 bg-info justify-content-center align-items-center">
                  <img src="../assets/resuelto.png" alt="Icono" class="mb-2">
                <p class="mb-0">Tickets Resueltos</p>
                <h3 class="card-title mb-0">56</h3>
              </div>
               <div class="card text-white text-center p-2 bg-secondary justify-content-center align-items-center">
                  <img src="../assets/Ticket.png" alt="Icono" class="mb-2">
                <p class="mb-0">Tickets Mantenimiento</p>
                <h3 class="card-title mb-0">56</h3>
              </div>
            </div>
          </div>
        </div>
      </div>
    </Container>
  </template>
  
  <script>
  export default {
    name: 'CuadrosDatos',
  };
  </script>
  
  <style scoped>
    img {
        max-width: 32px;
        max-height: 32px;
    }
  </style>