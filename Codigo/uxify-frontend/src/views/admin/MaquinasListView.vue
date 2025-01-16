<script>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import CuadrosDatosMaquinas from '@/components/CuadrosDatosMaquinas.vue';
import MaquinasListC from '@/components/MaquinasListC.vue';

export default {
    components: {
        CuadrosDatosMaquinas,
        MaquinasListC,
    },
    setup() {
        const maquinas = ref([]);

        onMounted(async () => {
            try {
                const response = await axios.get('http://127.0.0.1:8000/api/maquinas');
                maquinas.value = response.data;
            } catch (error) {
                console.error('Error al obtener las máquinas:', error);
            }
        });

        return {
            maquinas,
        };
    },
};
</script>

<template>
    <div class="container-fluid p-4">
        <div class="row mb-4">
            <CuadrosDatosMaquinas />
        </div>
        <div class="row mb-3">
            <div class="col d-flex justify-content-between align-items-center">
                <h3 class="mb-0">Gestión de Maquinas</h3>
                <button class="btn btn-dark">
                    <i class="bi bi-person-plus me-2"></i> Nueva maquina
                </button>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <MaquinasListC :maquinas="maquinas" />
            </div>
        </div>
    </div>
</template>

<style scoped>
.container-fluid {
    max-width: 100%;
}
</style>