<!-- CuadrosDatos.vue (Parent Component) -->
<template>
  <Container class="text-white py-2">
    <div class="container-fluid">
      <div class="row align-items-center p-2">
        <div class="col-md-12 d-flex justify-content-end pb-3">
          <button @click="showModal = true" class="btn btn-primary">Añadir Ticket</button>
        </div>
        <div class="col-12">
          <div class="d-flex gap-2 " >
            <router-link to="/prioridad1" class="card text-white bg-danger w-100 text-decoration-none">
                <div class="card-body text-center p-2 d-flex flex-column justify-content-center">
                    <img src="../assets/Prioridad.png" alt="Icono" class="icono-tarjeta mb-2">
                    <p class="mb-1">Incidencias Prioridad 1</p>
                    <h3 class="card-title mb-0 display-6">20</h3>
                </div>
            </router-link>
            <router-link to="/prioridad2" class="card text-white bg-warning w-100 text-decoration-none">  
                <div class="card-body text-center p-3 d-flex flex-column justify-content-center">
                    <img src="../assets/Prioridad.png" alt="Icono" class="icono-tarjeta mb-2">
                    <p class="mb-1">Incidencias Prioridad 2</p>
                    <h3 class="card-title mb-0 display-6">2</h3>
                </div>
            </router-link>
            <router-link to="/prioridad3" class="card text-white bg-success w-100 text-decoration-none"> 
                <div class="card-body text-center p-3 d-flex flex-column justify-content-center ">
                    <img src="../assets/Prioridad.png" alt="Icono" class="icono-tarjeta mb-2">
                    <p class="mb-1">Incidencias Prioridad 3</p>
                    <h3 class="card-title mb-0 display-6">2</h3>
                </div>
            </router-link>
            <router-link to="/Resueltos" class="card text-white bg-resueltos w-100 text-decoration-none">
                <div class="card-body text-center p-3 d-flex flex-column justify-content-center">
                    <img src="../assets/Prioridad.png" alt="Icono" class="icono-tarjeta mb-2">
                    <p class="mb-1">Incidencias Resueltos</p>
                    <h3 class="card-title mb-0 display-6">56</h3>
                </div>
            </router-link>
            <router-link to="/Mantenimiento" class="card text-white bg-mantenimiento w-100 text-decoration-none"> 
                <div class="card-body text-center p-3 d-flex flex-column justify-content-center">
                    <img src="../assets/Prioridad.png" alt="Icono" class="icono-tarjeta mb-2">
                    <p class="mb-1">Mantenimientos Preventivos</p>
                    <h3 class="card-title mb-0 display-6">45</h3>
                </div>
            </router-link>
          </div>
        </div>
      </div>
    </div>

    <Modal :show="showModal" :title="'Nuevo Ticket'" @close="showModal = false">
      <TicketForm @ticket-submitted="handleTicketSubmitted"/>
    </Modal>
  </Container>
</template>

<script>
import TicketForm from './TicketForm.vue';
import Modal from '@/components/Modal.vue';

export default {
  name: 'CuadrosDatos',
  components: {
    TicketForm,
    Modal
  },
  data() {
    return {
      showModal: false,
    };
  },
  methods: {
    handleTicketSubmitted(ticket) {
      console.log('Ticket received in parent:', ticket);
      // Here you can do something with the submitted ticket data, e.g., send it to an API
      this.showModal = false;
    }
  }
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

