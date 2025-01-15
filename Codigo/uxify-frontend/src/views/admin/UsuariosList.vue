<script>
import Header from '@/components/Header.vue';
import Sidebar from '@/components/Sidebar.vue';
import CuadrosDatosUsuarios from '@/components/CuadrosDatosUsuarios.vue';
import axios from 'axios';

export default {
    components: {
        Header,
        Sidebar,
        CuadrosDatosUsuarios
    },
    data() {
        return {
            users: []
        };
    },
    created() {
        axios
            .get('http://127.0.0.1:8000/api/users')
            .then((response) => {
                this.users = response.data;
            })
            .catch((error) => {
                console.error(error);
            });
    },
    methods: {
        addUser() {
            // Lógica para agregar un nuevo usuario
        }
    }
};
</script>

<template>
    <div class="container-fluid">
        <!-- Header -->
        <div class="row">
            <Header />
        </div>

        <div class="row">
            <!-- Sidebar -->
            <div class="col-2 bg-light p-0 vh-100">
                <Sidebar />
            </div>

            <!-- Main Content -->
            <div class="col-10 p-4">
                <!-- Cuadros de datos -->
                <div class="row mb-4">
                    <CuadrosDatosUsuarios />
                </div>

                <!-- Gestión de Usuarios -->
                <div class="row mb-3">
                    <div class="col d-flex justify-content-between align-items-center">
                        <h3 class="mb-0">Gestión de Usuarios</h3>
                        <button class="btn btn-dark">
                            <i class="bi bi-person-plus me-2"></i> Nuevo Usuario
                        </button>
                    </div>
                </div>

                <!-- Tabla de usuarios -->
                <div class="row">
                    <div class="col">
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
                                        <span
                                            class="badge text-bg-warning"
                                            v-if="user.rol.nombre === 'Administrador'"
                                        >
                                            {{ user.rol.nombre }}
                                        </span>
                                        <span
                                            class="badge text-bg-success"
                                            v-if="user.rol.nombre === 'Tecnico'"
                                        >
                                            {{ user.rol.nombre }}
                                        </span>
                                        <span
                                            class="badge text-bg-resueltos "
                                            v-if="user.rol.nombre === 'Operario'"
                                        >
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
