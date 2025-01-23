<template>
    <div class="container-fluid p-4">
        <div class="row mb-4">
            <CuadrosDatos />
        </div>
        <div class="row mb-3">
            <div class="col d-flex justify-content-between align-items-center">
                <h3 class="mb-0">Gestión de Categorias</h3>
                <button class="btn btn-dark" @click="openModal('register')">
                    <i class="bi bi-person-plus me-2"></i> Nueva Categoria
                </button>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <CategoriasList
                    :categorias="categorias"
                    @edit-categoria="openModal('edit', $event)"
                    @toggle-categoria-status="toggleCategoriaStatus($event)"
                />
            </div>
        </div>

        <CategoriasModal
            :show="showModal"
            :mode="modalMode"
            :categoria="categoriaSelected"
            @close="closeModal"
           @update-categoria="handleCategoriaUpdate"
        />

    </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import axios from 'axios';

import CuadrosDatos from '@/components/CuadrosDatos.vue';
import CategoriasList from '@/components/CategoriasList.vue';
import CategoriasModal from '@/components/CategoriasModal.vue';

import { API_BASE_URL } from '@/config.js';

export default {
    components: {
        CuadrosDatos,
        CategoriasList,
        CategoriasModal,
    },
    setup(){
        const showModal = ref(false);
        const modalMode = ref('register');
        const categoriaSelected = ref(null);
        const categorias = ref([]);
     

         const loading = ref(false);
        const error = ref(null);

        const openModal = (mode, categoria = null) => {
            modalMode.value = mode;
            categoriaSelected.value = categoria;
            showModal.value = true;
        }

        const closeModal = () => {
            showModal.value = false;
            categoriaSelected.value = null;
        }

        const fetchCategorias = async () => {
           loading.value = true;
           error.value = null;
            try {
                const response = await axios.get(`${API_BASE_URL}/categorias`);
                 // Actualiza los datos de la lista y usa el operador de propagación para actualizar reactivamente
                 categorias.value = [...response.data]
                 return response; // Devuelve la respuesta

            } catch (err) {
                error.value = err;
                console.error('Error fetching categorías:', err);
            } finally {
              loading.value = false;
            }
        };


        const toggleCategoriaStatus = async(categoria) => {
            try{
                const token = sessionStorage.getItem('token');
                if (!token){
                    throw new Error('Token not found');
                }
                const url = categoria.deshabilitado === 0
                 ? `${API_BASE_URL}/categorias/${categoria.id}/disable`
                 : `${API_BASE_URL}/categorias/${categoria.id}/enable`;
                const response = await axios.put(url, {}, {
                    headers: {
                         'Content-Type': 'application/json',
                         Authorization: `Bearer ${token}`
                    }
                 });
                  if (response && response.data){ // comprueba que response y response.data existen
                    await fetchCategorias();
                 }
            }
           catch (error){
              console.error(error);
            }
         };


         const handleCategoriaUpdate = async () => {
            const response = await fetchCategorias();
            if (response && response.data) {
                categorias.value = [...response.data]; // Actualiza las categorías
            }
        };
        onMounted(() => {
            fetchCategorias();
        });

        return{
            showModal,
            modalMode,
            categoriaSelected,
            categorias,
            openModal,
            closeModal,
            fetchCategorias,
            toggleCategoriaStatus,
            handleCategoriaUpdate,
            loading,
            error
        };
    },
};
</script>

<style scoped>
    .container-fluid{
        max-width: 100%;
    }
</style>