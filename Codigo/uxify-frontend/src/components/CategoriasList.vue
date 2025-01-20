<script>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { API_BASE_URL } from '@/config.js';

export default {
    setup() {
        const categorias = ref([]);

        onMounted(async () => {
            try {
                const response = await axios.get(`${API_BASE_URL}/categorias`);
                categorias.value = response.data;
            } catch (error) {
                console.error('Error al obtener las categorías:', error);
            }
        });

        return {
            categorias,
        };
    },
};
</script>

<template>
    <div class="col-12">
        <table class="table table-striped table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Nombre</th>
                    <th>Estado</th>
                    <th class="text-end px-4 ">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="categoria in categorias" :key="categoria.id">
                    <td>{{ categoria.nombre }}</td>
                    <td>
                        <span class="badge bg-success" v-if="categoria.deshabilitado === 0">Habilitada</span>
                        <span class="badge bg-danger" v-if="categoria.deshabilitado === 1">Deshabilitada</span>
                    </td>
                    <td class="text-end">
                        <button class="btn btn-sm">
                            <img src="../assets/editar.svg" alt="Editar" class="icon-small">
                        </button>
                        <button class="btn btn-sm">
                            <img src="../assets/person-lock.svg" alt="Eliminar" class="icon-small-2">
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<style scoped>
.icon-small {
    width: 40px;
    height: 40px;
}

.icon-small-2 {
    width: 20px;
    height: 20px;
}
</style>