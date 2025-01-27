<template>
    <div>
        <!-- Tabla de usuarios -->
        <table class="table table-striped table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="user in users" :key="user.id">
                    <td>{{ user.name }}</td>
                    <td>{{ user.email }}</td>
                    <td>
                        <span class="badge text-bg-warning" v-if="user.rol.nombre === 'Administrador'">
                            {{ user.rol.nombre }}
                        </span>
                        <span class="badge text-bg-success" v-if="user.rol.nombre === 'Tecnico'">
                            {{ user.rol.nombre }}
                        </span>
                        <span class="badge text-bg-resueltos text-white" v-if="user.rol.nombre === 'Operario'">
                            {{ user.rol.nombre }}
                        </span>
                    </td>
                    <td>
                        <span class="badge text-bg-success" v-if="user.deshabilitado === 0">
                            Habilitado
                        </span>
                        <span class="badge text-bg-danger" v-if="user.deshabilitado === 1">
                            Deshabilitado
                        </span>
                    </td>
                    <td>
                        <button class="btn btn-sm" @click="$emit('edit-user', user)">
                            <img src="../assets/editar.svg" alt="Editar" class="icon-small">
                        </button>
                        <button class="btn btn-sm" @click="$emit('toggle-user-status', user)">
                            <img src="../assets/person-lock.svg"
                                :alt="user.deshabilitado === 0 ? 'Deshabilitar' : 'Habilitar'" class="icon-small-2">
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Paginación -->
        <div class="row">
            <div class="col d-flex justify-content-center">
                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        <li class="page-item" :class="{ disabled: pagination.current_page === 1 }">
                            <button class="page-link"  :disabled="pagination.current_page === 1" @click="fetchUsers(pagination.current_page - 1)">
                                Anterior
                            </button>
                        </li>
                        <li class="page-item" v-for="page in pages" :key="page"
                            :class="{ active: page === pagination.current_page }">
                            <button class="page-link" @click="fetchUsers(page)">{{ page }}</button>
                        </li>
                        <li class="page-item" :class="{ disabled: pagination.current_page === pagination.last_page }">
                            <button class="page-link" :disabled="pagination.current_page === pagination.last_page" @click="fetchUsers(pagination.current_page + 1)">
                                Siguiente
                            </button>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import { API_BASE_URL } from '@/config.js';

export default {
    name: 'UserList',
    props: {
        users: {
            type: Array,
            required: true
        },
        pagination: {
            type: Object,
            required: true,
            default: () => ({
                current_page: 1,
                last_page: 1,
                per_page: 10
            })
        }
    },
        data() {
        return {
           selectedRole: this.$route.query.role || '',
           token: sessionStorage.getItem('token'),
        };
    },
      computed: {
      pages() {
        return Array.from({ length: this.pagination.last_page }, (_, i) => i + 1);
        },
      },
    watch: {
        // Observar cambios en la ruta y ejecutar fetchUsers cuando cambie el filtro
        '$route.query.role'(newValue) {
            this.selectedRole = newValue; // Actualizar selectedRole
            this.fetchUsers(); // Refrescar la lista de usuarios cuando cambie el filtro
        }
    },
    created() {
        this.fetchUsers(); // Fetch inicial de usuarios
    },
    methods: {
          fetchUsers(page = 1) {
      let url = `${API_BASE_URL}/users?page=${page}`;

      // Si hay un rol seleccionado, añadirlo como parámetro de la URL
      if (this.selectedRole) {
        url += `&role=${this.selectedRole}`;
      }
    

      if (!this.token) {
        console.error('Token not found');
        return;
      }

      axios
        .get(url, {
          headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${this.token}`,
          },
        })
        .then((response) => {
          this.$emit('update:users', response.data.data);
          this.$emit('update:pagination', {
            current_page: response.data.current_page,
            last_page: response.data.last_page,
            per_page: response.data.per_page,
          });
        })
        .catch((error) => {
          console.error('Error al obtener usuarios:', error);
        });
    },

        // Método para manejar el cambio del rol en el filtro
        handleRoleChange(event) {
            this.selectedRole = event.target.value; // Establecer el rol seleccionado
            // Cambiar la URL sin recargar la página (añadir el filtro como parámetro)
            this.$router.push({ query: { role: this.selectedRole } });
        },
    },
};
</script>

<style scoped>
.icon-small {
    width: 35px;
    height: 35px;
}

.icon-small-2 {
    width: 20px;
    height: 20px;
}
</style>