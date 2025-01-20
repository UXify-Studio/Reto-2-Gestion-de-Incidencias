<template>
    <div class="container-fluid p-4">
        <div class="row mb-4">
            <CuadroDatosMaquinas />
        </div>
        <div class="row mb-3">
            <div class="col d-flex justify-content-between align-items-center">
                <h3 class="mb-0">Gestión de Máquinas</h3>
                <button class="btn btn-dark" @click="openModal('register')">
                    <i class="bi bi-plus-circle me-2"></i> Nueva Máquina
                </button>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <MachineList :machines="machines" :pagination="pagination" @edit-machine="openModal('edit', $event)"
                    @update:machines="machines = $event" @update:pagination="pagination = $event" />
            </div>
        </div>

        <!-- Modal -->
        <MachineModal :show="showModal" :mode="modalMode" :machine="selectedMachine" @close="closeModal"
            @update-machines="fetchMachines" />
    </div>
</template>

<script>
import { ref, reactive } from 'vue';
import CuadroDatosMaquinas from '@/components/CuadrosDatosMaquinas.vue';
import MachineList from '@/components/MaquinasListC.vue';
import MachineModal from '@/components/MachineModal.vue';
import axios from 'axios';

export default {
    components: {
        CuadroDatosMaquinas,
        MachineList,
        MachineModal
    },
    setup() {
        const showModal = ref(false);
        const modalMode = ref('register');
        const selectedMachine = ref(null);
        const machines = ref([]);
        const pagination = reactive({
            current_page: 1,
            last_page: 1,
            per_page: 10
        });

        const openModal = (mode, machine = null) => {
            modalMode.value = mode;
            selectedMachine.value = machine;
            showModal.value = true;
        };

        const closeModal = () => {
            showModal.value = false;
            selectedMachine.value = null;
        };

        const fetchMachines = async (page = 1) => {
            try {
                const response = await axios.get(`http://127.0.0.1:8000/api/maquinas?page=${page}`);
                machines.value = response.data.data;
                pagination.current_page = response.data.current_page;
                pagination.last_page = response.data.last_page;
                pagination.per_page = response.data.per_page;
            } catch (error) {
                console.error(error);
            }
        };

        return {
            showModal,
            modalMode,
            selectedMachine,
            machines,
            pagination,
            openModal,
            closeModal,
            fetchMachines
        };
    },
    created() {
        this.fetchMachines();
    }
};
</script>

<style scoped>
.container-fluid {
    max-width: 100%;
}
</style>