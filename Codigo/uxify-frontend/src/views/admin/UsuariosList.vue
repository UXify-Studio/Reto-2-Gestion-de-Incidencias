<script>
import Header from '@/components/Header.vue';
import Sidebar from '@/components/Sidebar.vue';
import CuadrosDatosUsuarios from '@/components/CuadrosDatosUsuarios.vue';
import UserList from '@/components/UserList.vue';
import axios from 'axios';

export default {
    components: {
        Header,
        Sidebar,
        CuadrosDatosUsuarios,
        UserList,
    },
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
                        <UserList :users="users" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>