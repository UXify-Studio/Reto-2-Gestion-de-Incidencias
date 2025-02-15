<template>
  <div class="container-fluid p-4">
    <div class="row mb-4">
      <CuadrosDatos />
    </div>
    <div class="row mb-3">
      <div class="col d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Gestión de Campus</h3>
        <button class="btn btn-dark" @click="openModal('create')">
          <i class="bi bi-plus-circle me-2"></i> Nuevo Campus
        </button>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="table-responsive">
          <table class="table table-striped table-hover align-middle">
          <thead class="table-dark">
            <tr>
              <th class="align-middle p-2 px-4">Nombre</th>
              <th class="align-middle p-2 px-4">Estado</th>
              <th class="align-middle p-2 text-end px-4">Acciones</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="campus in campuses" :key="campus.id">
              <td class="align-middle px-4">{{ campus.nombre }}</td>
              <td class="align-middle px-4">
                <span class="badge bg-success" v-if="campus.deshabilitado === 0">Habilitada</span>
                <span class="badge bg-danger" v-if="campus.deshabilitado === 1">Deshabilitada</span>
              </td>
              <td class="align-middle text-end px-4">
                <button class="btn btn-sm me-2" @click="openModal('edit', campus)">
                  <i class="bi bi-pencil">
                    <img src="/src/assets/editar.svg" alt="Editar" class="icon-small">
                  </i>
                </button>
                <button class="btn btn-sm me-2" @click="toggleCampusStatus(campus)">
                  <i class="bi bi-trash3">
                    <img src="/src/assets/person-lock.svg" alt="Eliminar" class="icon-small-2">
                  </i>
                </button>
              </td>
            </tr>
          </tbody>
        </table>
        </div>
      </div>
    </div>

    <CampusModal v-if="showModal" :show="showModal" :mode="modalMode" :campus="selectedCampus" @close="closeModal"
      @update-campuses="fetchCampuses" />
  </div>
</template>

<script setup>
import { ref, reactive, onMounted } from 'vue';
import axios from 'axios';
import { useToast } from 'vue-toastification';
import CuadrosDatos from '@/components/CuadrosDatos.vue';
import CampusModal from '@/components/CampusModal.vue';
import { API_BASE_URL } from '@/config.js';

const toast = useToast();
const campuses = ref([]);
const showModal = ref(false);
const modalMode = ref(null);
const selectedCampus = ref(null);

const getToken = () => {
  const token = sessionStorage.getItem('token');
  if (!token) {
    console.error('Token no encontrado');
    toast.error('Error de autenticación. Por favor, inicie sesión.');
    throw new Error('Token not found');
  }
  return token;
};

const fetchCampuses = async () => {
  try {
    const token = sessionStorage.getItem('token');
    if (!token) throw new Error('Token not found');

    const response = await axios.get(`${API_BASE_URL}/campus`, {
      headers: {
        Authorization: `Bearer ${token}`,
        'Content-Type': 'application/json',
      },
    });

    campuses.value = response.data;
  } catch (error) {
    console.error('Error al obtener la lista de campus:', error);

    if (error.message !== 'Token not found') {
      toast.error('Error al obtener la lista de campus.');
    }
  }
};

onMounted(fetchCampuses);

const openModal = (mode, campus = null) => {
  modalMode.value = mode;
  selectedCampus.value = campus ? { ...campus } : {
    id: null,
    nombre: '',
    deshabilitado: 0
  };
  showModal.value = true;
};

const closeModal = () => {
  showModal.value = false;
  modalMode.value = null;
  selectedCampus.value = null;
};

const updateCampusInList = (updatedCampus) => {
    campuses.value = campuses.value.map(campus =>
        campus.id === updatedCampus.id ? updatedCampus : campus
    );
}

const toggleCampusStatus = async (campus) => {
  try {
    const token = sessionStorage.getItem('token');
    if (!token) {
      throw new Error('Token not found');
    }

    const url = campus.deshabilitado === 0
      ? `${API_BASE_URL}/campus/${campus.id}/disable`
      : `${API_BASE_URL}/campus/${campus.id}/enable`;

    const response = await axios.put(url, {}, {
      headers: {
        'Content-Type': 'application/json',
        Authorization: `Bearer ${token}`,
      },
    });

    if (response && response.data) {
      const updatedCampus = { ...campus, deshabilitado: campus.deshabilitado === 0 ? 1 : 0 };
      updateCampusInList(updatedCampus);
      toast.success(`Campus ${updatedCampus.deshabilitado ? 'deshabilitado' : 'habilitado'} con éxito`);
    }

  } catch (error) {
    console.error("Error al cambiar el estado del campus:", error);
    toast.error('Error al cambiar el estado del campus.');
  }
};

const createCampus = async (newCampus) => {
  try {
    const token = getToken();
    await axios.post(`${API_BASE_URL}/campus`, newCampus, {
      headers: {
        Authorization: `Bearer ${token}`,
        'Content-Type': 'application/json',
      },
    });
    toast.success('Campus creado correctamente');
    fetchCampuses();
  } catch (error) {
    console.error("Error al crear el campus:", error);
    if (error.message !== 'Token not found') {
      toast.error('Error al crear el campus.');
    }
  }
};

const updateCampus = async (campus) => {
  try {
    const token = getToken();
    await axios.put(`${API_BASE_URL}/campus/${campus.id}`, campus, {
      headers: {
        Authorization: `Bearer ${token}`,
        'Content-Type': 'application/json',
      },
    });
    toast.success('Campus actualizado correctamente');
    fetchCampuses();
  } catch (error) {
    console.error("Error al actualizar el campus:", error);
    if (error.message !== 'Token not found') {
      toast.error('Error al actualizar el campus.');
    }
  }
};
</script>