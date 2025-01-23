<template>
    <div class="container-fluid p-4">
        <div class="row mb-4">
            <CuadrosDatos />
        </div>
        <div class="row mb-3">
            <div class="col d-flex justify-content-between align-items-center">
                <h3 class="mb-0">Gestión de Categorias</h3>
                <button class="btn btn-dark">
                    <i class="bi bi-person-plus me-2"></i> Nueva Categoria
                </button>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <CategoriasList />
            </div>
        </div>
    </div>
</template>
<script>
import { ref, onMounted } from 'vue';
import axios from 'axios';

import CuadrosDatos from '@/components/CuadrosDatos.vue';
import CategoriasList from '@/components/CategoriasList.vue';
import CategorModal from '@/components/CategoriasModal.vue';

import { API_BASE_URL } from '@/config.js';

export default {
    components: {
        CuadrosDatos,
        CategoriasList,
        CategorModal,
    },
    setup(){
        const showModal = ref(false);
        const categoriaModal = ref(false);
        const categoriaSelected = ref(null);
    }
};
</script>