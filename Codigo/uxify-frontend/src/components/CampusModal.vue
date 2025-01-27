<template>
  <Modal :show="show" :title="modalTitle" @close="close">
    <form @submit.prevent="submit">
      <div class="mb-3">
        <label for="nombre" class="form-label">Nombre</label>
        <input type="text" class="form-control" id="nombre" v-model="campus.nombre" required>
      </div>
     <div v-if="isCreateMode" class="mb-3">
          <label for="deshabilitado" class="form-label">Estado</label>
          <select class="form-control" id="deshabilitado" v-model="campus.deshabilitado">
            <option :value="0">Habilitado</option>
            <option :value="1">Deshabilitado</option>
          </select>
     </div>
      <button type="submit" class="btn btn-primary">{{ isCreateMode ? 'Crear' : 'Actualizar' }}</button>
    </form>
  </Modal>
</template>

<script setup>
import { reactive, computed } from 'vue';
import { useToast } from 'vue-toastification';
import Modal from '@/components/Modal.vue';
import axios from 'axios';
import { API_BASE_URL } from '@/config.js';

const props = defineProps({
  show: { type: Boolean, required: true },
  mode: { type: String, required: true },
  campus: { type: Object, default: () => ({}) },
});

const emit = defineEmits(['close', 'update-campuses']);

const toast = useToast();

const isCreateMode = computed(() => props.mode === 'create');
const modalTitle = computed(() => isCreateMode.value ? 'Crear Nuevo Campus' : 'Editar Campus');

const campus = reactive(props.campus);

const close = () => {
  emit('close');
};

const submit = async () => {
  try {
    const token = sessionStorage.getItem('token');
    if (!token) {
      console.error('Token not found');
      toast.error('Error de autenticación. Por favor, inicie sesión.');
      return;
    }

    if (isCreateMode.value) {
      await axios.post(`${API_BASE_URL}/campus`, campus, {
        headers: {
          Authorization: `Bearer ${token}`,
          'Content-Type': 'application/json'
        }
      });
      toast.success('Campus creado correctamente');
    } else {
      console.log("ID del campus a actualizar:", campus.id);
      if (!campus.id) {
        console.error("El ID del campus es nulo. No se puede actualizar.");
        toast.error('Error al obtener el ID del campus.');
        return;
      }

      await axios.put(`${API_BASE_URL}/campus/${campus.id}`, campus, {
        headers: {
          Authorization: `Bearer ${token}`,
          'Content-Type': 'application/json'
        }
      });
      toast.success('Campus actualizado correctamente');
    }

    emit('update-campuses');
    close();
  } catch (error) {
    console.error("Error al guardar el campus:", error);
    if (error.response && error.response.data && error.response.data.message) {
      toast.error(error.response.data.message);
    } else {
      toast.error('Error al guardar el campus');
    }
  }
};
</script>
