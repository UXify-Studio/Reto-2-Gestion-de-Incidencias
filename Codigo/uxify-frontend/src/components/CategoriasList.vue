<script>
import axios from 'axios';

export default {
    data() {
        return {
            categorias: []
        };
    },
    created() {
        axios.get('http://127.0.0.1:8000/api/categorias')
            .then(response => {
                this.categorias = response.data;
            })
            .catch(error => {
                console.error(error);
            });
    }
};
</script>

<template>
    <div class="col-12">
        <table class="table table-striped table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Nombre</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="categoria in categorias" :key="categoria.id">
                    <td>{{ categoria.nombre }}</td>
                    <td>
                        <span class="badge bg-success" v-if="categoria.deshabilitado === 0">Habilitada</span>
                        <span class="badge bg-danger" v-if="categoria.deshabilitado === 1">Deshabilitada</span>
                    </td>
                    <td>
                        <button class="btn btn-sm">
                            <img src="../assets/editar.svg" alt="Editar" class="icon-small">
                        </button>
                        <button class="btn btn-sm">
                            <img src="../assets/eliminar.svg" alt="Eliminar" class="icon-small">
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<style scoped>
.icon-small {
    width: 35px;
    height: 35px;
}
</style>