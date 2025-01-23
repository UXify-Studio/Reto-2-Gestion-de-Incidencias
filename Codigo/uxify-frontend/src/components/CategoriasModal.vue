<template>
    <Modal :show="show" :title="modalTitle" @close="closeModal">
        <form @submit.prevent="submitForm">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" v-model="categoriaForm.nombre" required>
            </div>
            <button type="submit" class="btn btn-primary">
                {{ mode === 'register' ? 'Registrar' : 'Guardar Cambios' }}
            </button>
        </form>
    </Modal>
</template>

<script>
import { ref, reactive, watch } from 'vue';
import { useToast } from 'vue-toastification';
import Modal from '@/components/Modal.vue';
import axios from 'axios';
import { API_BASE_URL } from '@/config.js';

export default {
    name: 'CategoriasModal',
    components: {
        Modal
    },
    props: {
        show: {
            type: Boolean,
            default: false
        },
        mode: {
            type: String,
            default: 'register'
        },
        categoria: {
            type: Object,
            default: null
        }
    },
    emits: ['close', 'update-categoria'],
    setup(props, { emit }) {
        const isRegisterMode = ref(props.mode === 'register');
        const modalTitle = ref(isRegisterMode.value ? 'Registro de Nueva Categoría' : 'Editar Categoría');
        const categoriaForm = reactive({
           nombre: '',
           descripcion: '',
          });

        const toast = useToast();
        const loading = ref(false);
        const error = ref(null);

        watch(() => props.categoria, (newCategoria) => {
            if (newCategoria) {
              Object.assign(categoriaForm, newCategoria); // Actualiza el formulario con un Object.assign
            } else {
              categoriaForm.nombre = '';
              categoriaForm.deshabilitado = 0;
            }
         }, { immediate: true });


        watch(() => props.mode, (newMode) => {
            isRegisterMode.value = newMode === 'register';
            modalTitle.value = isRegisterMode.value ? 'Registro de Nueva Categoría' : 'Editar Categoría';
          });

        const resetForm = () =>{
             categoriaForm.nombre = '';
             categoriaForm.descripcion = '';
             categoriaForm.deshabilitado = 0;
        }


      const submitForm = async () => {
          loading.value = true;
          error.value = null;
          try {
            const token = sessionStorage.getItem('token');
            if (!token) {
              throw new Error('Token not found');
             }

            let url = `${API_BASE_URL}/categorias`;
            let method = 'post';


              if (props.mode === 'edit') {
                   url = `${API_BASE_URL}/categorias/${props.categoria.id}`;
                   method = 'put';
                }
            const dataToSend = {
                nombre: categoriaForm.nombre,
                deshabilitado: categoriaForm.deshabilitado,
            };
            if (props.mode === 'edit') {
               dataToSend.descripcion = categoriaForm.descripcion;
             }
            await axios({
                 url,
                 method,
               data: dataToSend,
                headers: {
                   'Content-Type': 'application/json',
                     Authorization: `Bearer ${token}`
                 }
            });

            toast.success(isRegisterMode.value ? 'Categoría registrada con éxito' : 'Categoría actualizada con éxito');
            emit('update-categoria');
             closeModal();
          } catch (err) {
              if (err.response) {
                    console.error('Error data:', err.response.data);
                    toast.error('Error al registrar la categoría: ' + err.response.data.message);
              } else {
                  console.error('Error:', err.message);
                  toast.error('Error al registrar la categoría');
               }

          } finally {
             loading.value = false;
        }
     };


        const closeModal = () => {
            emit('close');
            resetForm();
        };

        return {
            isRegisterMode,
            modalTitle,
            categoriaForm,
            submitForm,
           closeModal,
           loading,
           error
        };
    }
};
</script>

<style scoped>
</style>