<template>
    <div>
        <!-- Filtro de roles -->
        <div class="mb-3">
            <label for="roleFilter" class="form-label">Filtrar por Rol</label>
            <select id="roleFilter" class="form-select" v-model="selectedRole" @change="handleRoleChange">
                <option value="">Todos</option>
                <option value="Administrador">Administrador</option>
                <option value="Tecnico">Técnico</option>
                <option value="Operario">Operario</option>
            </select>
        </div>

        <!-- Tabla de usuarios -->
        <table class="table table-striped table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Rol</th>
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
                        <span class="badge text-bg-resueltos" v-if="user.rol.nombre === 'Operario'">
                            {{ user.rol.nombre }}
                        </span>
                    </td>
                    <td>
                        <button class="btn btn-sm btn-outline-secondary me-2">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-danger">
                            <i class="bi bi-trash3"></i>
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
                            <button class="page-link" @click="fetchUsers(pagination.current_page - 1)">
                                Anterior
                            </button>
                        </li>
                        <li class="page-item" v-for="page in pagination.last_page" :key="page"
                            :class="{ active: page === pagination.current_page }">
                            <button class="page-link" @click="fetchUsers(page)">{{ page }}</button>
                        </li>
                        <li class="page-item" :class="{ disabled: pagination.current_page === pagination.last_page }">
                            <button class="page-link" @click="fetchUsers(pagination.current_page + 1)">
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

export default {
    data() {
        return {
            users: [],
            pagination: {
                current_page: 1,
                last_page: 1,
                per_page: 10,
            },
            selectedRole: this.$route.query.role || '', // Obtener el filtro desde la URL
        };
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
            let url = `http://127.0.0.1:8000/api/users?page=${page}`;
            
            // Si hay un rol seleccionado, añadirlo como parámetro de la URL
            if (this.selectedRole) {
                url += `&role=${this.selectedRole}`;
            }

            axios
                .get(url)
                .then((response) => {
                    this.users = response.data.data;
                    this.pagination.current_page = response.data.current_page;
                    this.pagination.last_page = response.data.last_page;
                    this.pagination.per_page = response.data.per_page;
                })
                .catch((error) => {
                    console.error(error);
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
/* Estilos opcionales para la tabla o el filtro */
</style>
