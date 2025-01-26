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
                    @toggle-categoria-status="toggleCategoriaStatus"
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
import { useToast } from 'vue-toastification';

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
        const toast = useToast();
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
    const token = sessionStorage.getItem('token');
    if (!token) throw new Error('Token no disponible');

    const response = await axios.get(`${API_BASE_URL}/categorias`, {
      headers: {
        Authorization: `Bearer ${token}`,
        'Content-Type': 'application/json',
      },
    });

    categorias.value = response.data;
  } catch (err) {
    error.value = err;
    console.error('Error fetching categorías:', err);
    toast.error('Error al cargar las categorías');
  } finally {
    loading.value = false;
  }
};


        const updateCategoriaInList = (updatedCategoria) => {
            const index = categorias.value.findIndex(cat => cat.id === updatedCategoria.id);
            if (index !== -1) {
                Object.assign(categorias.value[index], updatedCategoria);
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

                if (response && response.data) {
                    // Optimistically update the category status in the list:
                    const updatedCategoria = { ...categoria, deshabilitado: categoria.deshabilitado === 0 ? 1 : 0 };
                    updateCategoriaInList(updatedCategoria);

                     toast.success(`Categoría ${updatedCategoria.deshabilitado ? 'deshabilitada' : 'habilitada'} con éxito`);
                }
            }
           catch (error){
              console.error(error);
                 toast.error('Error al cambiar el estado de la categoría');
            }
         };

        const handleCategoriaUpdate = async () => {
             try {
                await fetchCategorias(); // Refetch all categories or update specific one if your API returns it
                toast.success('Categorías actualizadas con éxito.');
            } catch (error) {
                console.error('Error fetching categories:', error);
                toast.error('Error al actualizar las categorías.');
            }
        };


        onMounted(() => {
            fetchCategorias();
        });

        return{
            toast,
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