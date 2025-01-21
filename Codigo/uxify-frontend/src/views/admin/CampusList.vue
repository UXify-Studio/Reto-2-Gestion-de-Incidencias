<script>
import { ref, onMounted } from 'vue';
import axios from 'axios';

import CuadrosDatos from '@/components/CuadrosDatos.vue';
import { API_BASE_URL } from '@/config.js';

export default {
    components: {
        CuadrosDatos,
    },
    data() {
        return {
            campuses: []
        };
    },
    created() {
        axios.get(`${API_BASE_URL}/campus`)
            .then(response => {
                this.campuses = response.data;
            })
            .catch(error => {
                console.error(error);
            });
    }
};
</script>

<template>
    <div class="container-fluid p-4">
        <div class="row mb-4">
            <CuadrosDatos/>
        </div>
        <div class="row mb-3">  <!-- Reduced margin -->
            <div class="col d-flex justify-content-between align-items-center">
                <h3 class="mb-0">Gestión de Campus</h3>
                <button class="btn btn-dark" @click="openModal">  <!-- Simplified openModal -->
                    <i class="bi bi-plus-circle me-2"></i> Nuevo Campus
                </button>
            </div>
        </div>
        <div class="row">
            <div class="col"> <!-- Added col for better responsiveness -->
                
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th class="align-middle p-2">Nombre</th>
                            <th class="align-middle p-2">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="campus in campuses" :key="campus.id">
                            <td class="align-middle">{{ campus.nombre }}</td>
                            <td class="align-middle">
                                <i class="bi bi-pencil" @click="openModal('edit', campus)"></i> <!-- Pass campus data for editing -->
                                <i class="bi bi-trash3"></i>
                                <button class="btn btn-sm">
                                    <img src="/src/assets/editar.svg" alt="Editar" class="icon-small">
                                </button>
                                <button class="btn btn-sm">
                                    <img src="/src/assets/person-lock.svg" alt="Eliminar" class="icon-small-2">
                                </button>
                            </td>  
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal -->
        <CampusModal :show="showModal" :mode="modalMode" :campus="selectedCampus" @close="closeModal" @update-campuses="fetchCampuses" />
    </div>
</template>
