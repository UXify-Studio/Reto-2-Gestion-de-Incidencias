<script>
import CuadrosDatosUsuarios from '@/components/CuadrosDatosUsuarios.vue';
import UserList from '@/components/UserList.vue';

export default {
    components: {
        CuadrosDatosUsuarios,
        UserList,
    }
};
</script>

<template>
    <div class="container-fluid p-4">
        <div class="row mb-4">
            <CuadrosDatosUsuarios />
        </div>
        <div class="row mb-3">
            <div class="col d-flex justify-content-between align-items-center">
                <h3 class="mb-0">Gestión de Usuarios</h3>
                <button class="btn btn-dark">
                    <i class="bi bi-person-plus me-2"></i> Nuevo Usuario
                </button>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <UserList />
            </div>
        </div>
    </div>
</template>

<style scoped>
.container-fluid {
    max-width: 100%;
}
</style>