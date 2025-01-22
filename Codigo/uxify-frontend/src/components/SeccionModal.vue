<template>
    <Modal :show="show" :title="modalTitle" @close="close">
      <form @submit.prevent="submit">
        <div class="mb-3">
          <label for="nombre" class="form-label">Nombre</label>
          <input type="text" class="form-control" id="nombre" v-model="seccion.nombre" required>
        </div>
        <div class="mb-3">
          <label for="n_seccion" class="form-label">Número Sección</label>
          <input type="number" class="form-control" id="n_seccion" v-model="seccion.n_seccion" required>
        </div>
        <div class="mb-3">
          <label for="id_campus" class="form-label">Campus</label>
          <select class="form-control" id="id_campus" v-model="seccion.id_campus" required>
              <option v-for="campus in campuses" :key="campus.id" :value="campus.id">{{ campus.nombre }}</option>
          </select>
        </div>
         <div class="mb-3">
          <label for="deshabilitado" class="form-label">Estado</label>
          <select class="form-control" id="deshabilitado" v-model="seccion.deshabilitado">
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
      seccion: { type: Object, default: () => ({}) },
      campuses: { type: Array, required: true },
  });
  
  const emit = defineEmits(['close', 'update-secciones']);
  const toast = useToast();
  const isCreateMode = computed(() => props.mode === 'create');
  const modalTitle = computed(() => (isCreateMode.value ? 'Crear Nueva Sección' : 'Editar Sección'));
  
  const seccion = reactive(props.seccion);
  const campuses = computed(() => props.campuses);
  
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
            console.log('Datos a enviar (crear):', seccion); 
               await axios.post(`${API_BASE_URL}/secciones`, seccion, {
                    headers: {
                        Authorization: `Bearer ${token}`,
                        'Content-Type': 'application/json',
                    },
              });
              toast.success('Sección creada correctamente');
           } else {
              console.log('ID de la sección a actualizar:', seccion.id);
              if (!seccion.id) {
                  console.error('El ID de la sección es nulo. No se puede actualizar.');
                  toast.error('Error al obtener el ID de la sección.');
                  return;
              }
              await axios.put(`${API_BASE_URL}/secciones/${seccion.id}`, seccion, {
                  headers: {
                      Authorization: `Bearer ${token}`,
                      'Content-Type': 'application/json',
                  },
              });
              toast.success('Sección actualizada correctamente');
          }
          emit('update-secciones');
          close();
      } catch (error) {
          console.error('Error al guardar la sección:', error);
          if (error.response && error.response.data && error.response.data.message) {
              toast.error(error.response.data.message);
          } else {
              toast.error('Error al guardar la sección.');
          }
      }
  };
  </script>