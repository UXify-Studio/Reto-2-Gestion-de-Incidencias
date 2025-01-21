<template>
    <div class="container-fluid p-4">
      <div class="row mb-4">
        <CuadrosDatos />
      </div>
      <div class="row mb-3">
        <div class="col d-flex justify-content-between align-items-center">
          <h3 class="mb-0">Gestión de Secciones</h3>
          <button class="btn btn-dark" @click="openModal('create')">
            <i class="bi bi-plus-circle me-2"></i> Nueva Sección
          </button>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <table class="table table-striped table-hover align-middle">
            <thead class="table-dark">
              <tr>
                <th class="align-middle p-2 px-4">Nombre</th>
                <th class="align-middle p-2 px-4">Número de Sección</th>
                <th class="align-middle p-2 px-4">Campus</th>
                <th class="align-middle p-2 px-4">Estado</th>
                <th class="align-middle p-2 text-end px-4">Acciones</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="seccion in secciones" :key="seccion.id">
                <td class="align-middle px-4">{{ seccion.nombre }}</td>
                <td class="align-middle px-4">{{ seccion.n_seccion }}</td>
                <td class="align-middle px-4">{{ seccion.campus.nombre }}</td>
                <td class="align-middle px-4">
                  <span class="badge bg-success" v-if="seccion.deshabilitado === 0">Habilitada</span>
                  <span class="badge bg-danger" v-if="seccion.deshabilitado === 1">Deshabilitada</span>
                </td>
                <td class="align-middle text-end px-4">
                  <button class="btn btn-sm me-2" @click="openModal('edit', seccion)">
                    <i class="bi bi-pencil"><img src="/src/assets/editar.svg" alt="Editar" class="icon-small"></img></i>
                  </button>
                  <button class="btn btn-sm me-2" @click="disableSeccion(seccion)">
                    <i class="bi bi-trash3"><img src="/src/assets/person-lock.svg" alt="Eliminar" class="icon-small-2"></img></i>
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
  
      <SeccionModal
        v-if="showModal"
        :show="showModal"
        :mode="modalMode"
        :seccion="selectedSeccion"
        :campuses="campuses"
        @close="closeModal"
        @update-secciones="fetchSecciones"
      />
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted } from 'vue';
  import axios from 'axios';
  import { useToast } from 'vue-toastification';
  import CuadrosDatos from '@/components/CuadrosDatos.vue';
  import SeccionModal from '@/components/SeccionModal.vue';
  import { API_BASE_URL } from '@/config.js';
  
  const toast = useToast();
  const secciones = ref([]);
  const showModal = ref(false);
  const modalMode = ref(null);
  const selectedSeccion = ref(null);
  const campuses = ref([]);
  
  const getToken = () => {
    const token = sessionStorage.getItem('token');
    if (!token) {
      toast.error('Error de autenticación. Por favor, inicie sesión.');
      throw new Error('Token not found');
    }
    return token;
  };
  
  const fetchSecciones = async () => {
    try {
      const token = getToken();
      const response = await axios.get(`${API_BASE_URL}/seccionesConCampus`, {
        headers: { Authorization: `Bearer ${token}` },
      });
      secciones.value = response.data;
    } catch (error) {
      toast.error('Error al obtener la lista de secciones.');
    }
  };
  
  const fetchCampuses = async () => {
    try {
      const token = getToken();
      const response = await axios.get(`${API_BASE_URL}/campus/${idCampus}`, {
        headers: { Authorization: `Bearer ${token}` },
      });
      campuses.value = response.data;
    } catch (error) {
      toast.error('Error al obtener la lista de campus.');
    }
  };
  
  onMounted(async () => {
    await Promise.all([fetchSecciones(), fetchCampuses()]);
  });
  
  const openModal = (mode, seccion = null) => {
    modalMode.value = mode;
    selectedSeccion.value = seccion
      ? { ...seccion }
      : {
          id: null,
          nombre: '',
          n_seccion: null,
          id_campus: null,
          deshabilitado: 0,
        };
    showModal.value = true;
  };
  
  const closeModal = () => {
    showModal.value = false;
    modalMode.value = null;
    selectedSeccion.value = null;
  };
  
  const disableSeccion = async (seccion) => {
    try {
      const token = getToken();
      const currentStatus = seccion.deshabilitado;
      const newStatus = currentStatus === 0 ? 1 : 0;
      await axios.put(
        `${API_BASE_URL}/secciones/${seccion.id}/disable`,
        { deshabilitado: newStatus },
        { headers: { Authorization: `Bearer ${token}` } }
      );
      toast.success('Sección actualizada correctamente.');
      fetchSecciones();
    } catch (error) {
      toast.error('Error al actualizar el estado de la sección.');
    }
  };
  </script>