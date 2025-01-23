<!-- CuadrosDatos.vue (Parent Component) -->
<template>
  <Container class="text-white py-2">
    <div class="container-fluid">
      <div class="row align-items-center p-2">
        <div class="col-md-12 d-flex justify-content-end pb-3">
          <button @click="showModal = true" class="btn btn-primary ">Añadir Ticket</button>
        </div>
        <div class="col-12">
          <div class="d-flex gap-2 " >
            <router-link :to="{ path: '/home', query: { priority: '1' } }"
             class="card text-white bg-danger w-100 text-decoration-none">
                <div class="card-body text-center p-2 d-flex flex-column justify-content-center">
                    <img src="../assets/Prioridad.png" alt="Icono" class="icono-tarjeta mb-2">
                    <p class="mb-1">Incidencias Prioridad 1</p>
                    <h3 class="card-title mb-0 display-6">{{ incidenciasAlta >= 0 ? incidenciasAlta : 'Cargando...' }}</h3>
                </div>
            </router-link>
            <router-link :to="{ path: '/home', query: { priority: '2' } }" class="card text-white bg-warning w-100 text-decoration-none">  
                <div class="card-body text-center p-3 d-flex flex-column justify-content-center">
                    <img src="../assets/Prioridad.png" alt="Icono" class="icono-tarjeta mb-2">
                    <p class="mb-1">Incidencias Prioridad 2</p>
                    <h3 class="card-title mb-0 display-6">{{ incidenciasMedia >= 0 ? incidenciasMedia : 'Cargando...' }}</h3>
                </div>
            </router-link>
            <router-link :to="{ path: '/home', query: { priority: '3' } }" class="card text-white bg-success w-100 text-decoration-none"> 
                <div class="card-body text-center p-3 d-flex flex-column justify-content-center ">
                    <img src="../assets/Prioridad.png" alt="Icono" class="icono-tarjeta mb-2">
                    <p class="mb-1">Incidencias Prioridad 3</p>
                    <h3 class="card-title mb-0 display-6">{{ incidenciasBaja >= 0 ? incidenciasBaja : 'Cargando...' }}</h3>
                </div>
            </router-link>
            <router-link :to="{ path: '/home', query: { priority: '0' } }" class="card text-white bg-resueltos w-100 text-decoration-none">
                <div class="card-body text-center p-3 d-flex flex-column justify-content-center">
                    <img src="../assets/Prioridad.png" alt="Icono" class="icono-tarjeta mb-2">
                    <p class="mb-1">Incidencias Resueltos</p>
                    <h3 class="card-title mb-0 display-6">{{ incidenciasResueltas >= 0 ? incidenciasResueltas : 'Cargando...' }}</h3>
                </div>
            </router-link>
            <router-link to="/Mantenimiento" class="card text-white bg-mantenimiento w-100 text-decoration-none"> 
                <div class="card-body text-center p-3 d-flex flex-column justify-content-center">
                    <img src="../assets/Prioridad.png" alt="Icono" class="icono-tarjeta mb-2">
                    <p class="mb-1">Mantenimientos Preventivos</p>
                    <h3 class="card-title mb-0 display-6">{{ mantenimientos >= 0 ? mantenimientos : 'Cargando...' }}</h3>
                </div>
            </router-link>
          </div>
        </div>
      </div>
    </div>

    <Modal :show="showModal" :title="'Nuevo Ticket'" @close="showModal = false" class="z-5">
      <TicketForm @ticket-submitted="handleTicketSubmitted"/>
    </Modal>
  </Container>
</template>

<script>
import TicketForm from './IncidenciaForm.vue';
import Modal from '@/components/Modal.vue';

import { useIncidenciasStore } from '../stores/incidencias';
import { computed, onMounted } from 'vue';

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
      /*incidencias: [], // Incidencias filtradas
      selectedPriority: this.$route.query.priority || null, // Leer prioridad desde la URL
      */
    };
  },
  /*
  watch: {
    // Observar cambios en el parámetro de la URL
    '$route.query.priority': {
      immediate: true,
      handler(newPriority) {
        this.selectedPriority = newPriority || null;
        this.fetchIncidencias(); // Llamar al backend con el nuevo filtro
      },
    },
  },
  */
  methods: {
    handleTicketSubmitted(ticket) {
      console.log('Ticket received in parent:', ticket);
      // Here you can do something with the submitted ticket data, e.g., send it to an API
      this.showModal = false;
    },

  },

  setup(){
    const incidenciasStore = useIncidenciasStore();

    // Llama al método para obtener los datos
    onMounted(() => {
      incidenciasStore.fetchIncidenciasTotal();
    });

    // Computed para acceder al estado de manera reactiva
    const incidenciasAlta = computed(() => incidenciasStore.incidenciasAlta);
    const incidenciasMedia = computed(() => incidenciasStore.incidenciasMedia);
    const incidenciasBaja = computed(() => incidenciasStore.incidenciasBaja);
    const incidenciasResueltas = computed(() => incidenciasStore.incidenciasResueltas);
    const mantenimientos = computed(() => incidenciasStore.mantenimientos);

    return {
      incidenciasAlta, incidenciasMedia, incidenciasBaja, incidenciasResueltas, mantenimientos
    };
  },
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

