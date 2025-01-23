<template>
    <div class="col-12">
        <div v-if="loading">Cargando categorías...</div>
        <div v-else-if="error">Error al cargar las categorías: {{ error.message }}</div>
        <div v-else>
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
                            <button class="btn btn-sm" @click="$emit('edit-categoria',categoria)">
                                <img src="../assets/editar.svg" alt="Editar" class="icon-small">
                            </button>
                            <button class="btn btn-sm" @click="$emit('toggle-categoria-status', categoria)">
                                <img src="../assets/person-lock.svg"
                                :alt="categoria.deshabilitado ===0 ? 'Deshabilitar' : 'Habilitar' " class="icon-small-2">
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
<script>

export default {
    name: 'CategoriaList',
    props: {
        categorias: {
            type: Array,
            required: true,
        },
    },
    emits:['edit-categoria', 'toggle-categoria-status'],
    setup(props, { emit }) {
        return {
        };
    },
};
</script>
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