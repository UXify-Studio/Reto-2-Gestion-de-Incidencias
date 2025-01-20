<template>
    <div class="container-fluid p-4">
        <div class="row mb-4">
            <CuadrosDatosUsuarios />
        </div>
        <div class="row mb-3">
            <div class="col d-flex justify-content-between align-items-center">
                <h3 class="mb-0">Gestión de Usuarios</h3>
                <button class="btn btn-dark" @click="showModal = true">
                    <i class="bi bi-person-plus me-2"></i> Nuevo Usuario
                </button>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <UserList />
            </div>
        </div>

        <!-- Modal -->
        <Modal :show="showModal" title="Registro de Nuevo Usuario" @close="showModal = false">
            <form @submit.prevent="submit">
                <div class="mb-3">
                    <label for="name" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="name" v-model="data.name" required>
                </div>
                <div class="mb-3">
                    <label for="username" class="form-label">Nombre de Usuario</label>
                    <input type="text" class="form-control" id="username" v-model="data.username" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Correo Electrónico</label>
                    <input type="email" class="form-control" id="email" v-model="data.email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" class="form-control" id="password" v-model="data.password" required>
                </div>
                <div class="mb-3">
                    <label for="role" class="form-label">Rol</label>
                    <select v-model="data.id_rol" class="form-control" required>
                        <option disabled value="">Seleccione un rol</option>
                        <option v-for="role in roles" :key="role.id" :value="role.id">{{ role.nombre }}</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Registrar</button>
            </form>
        </Modal>
    </div>
</template>

<script>
  import { ref, reactive } from 'vue';
  import { useToast } from 'vue-toastification';
  import axios from 'axios';
  import { API_BASE_URL } from '@/config.js';
  
  export default {
    setup() {
      const showModal = ref(false);
      const data = reactive({
        name: '',
        username: '',
        email: '',
        password: '',
        id_rol: ''
      });
  
      const toast = useToast();
  
      const submit = async () => {
        try {
          console.log(data);
          const token = sessionStorage.getItem('token');
          if (!token) {
            throw new Error('No token found');
          }
          await axios.post(`${API_BASE_URL}/auth/register`, {
            name: data.name,
            username: data.username,
            email: data.email,
            password: data.password,
            id_rol: data.id_rol
          }, {
            headers: {
              'Content-Type': 'application/json',
              'Authorization': `Bearer ${token}`
            }
          });
          toast.success('Registro exitoso');
          showModal.value = false;
        } catch (error) {
          if (error.response) {
            console.error('Error data:', error.response.data);
            toast.error('Error al registrar el usuario: ' + error.response.data.message);
          } else {
            console.error('Error:', error.message);
            toast.error('Error al registrar el usuario');
          }
        }
      };
  
      return {
        showModal,
        data,
        submit,
      };
    },
    data() {
      return {
        roles: []
      };
    },
    created() {
      axios.get(`${API_BASE_URL}/roles`)
        .then(response => {
          this.roles = response.data;
        })
        .catch(error => {
          console.error(error);
        });
    }
  };
  </script>

<style scoped>
.container-fluid {
    max-width: 100%;
}
</style>

