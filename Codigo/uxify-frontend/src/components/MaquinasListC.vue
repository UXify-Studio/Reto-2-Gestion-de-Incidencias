<template>
    <div>
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Nombre</th>
                    <th>Prioridad</th>
                    <th>Estado</th>
                    <th>Campus</th>
                    <th>Sección</th>
                    <th>Habilitación</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="maquina in maquinas" :key="maquina.id">
                    <td class="align-middle">{{ maquina.nombre }}</td>
                    <td class="align-middle">{{ maquina.prioridad }}</td>
                    <td class="align-middle">
                        <span class="badge text-bg-success" v-if="maquina.estado === 1">Operativa</span>
                        <span class="badge text-bg-danger" v-if="maquina.estado === 2">Fuera de Servicio</span>
                        <span class="badge text-bg-resueltos text-white" v-if="maquina.estado === 3">En
                            Mantenimiento</span>
                    </td>
                    <td class="align-middle">{{ maquina.section.campus.nombre }}</td>
                    <td class="align-middle">{{ maquina.section.n_seccion }}</td>
                    <td class="align-middle">
                        <span class="badge text-bg-success" v-if="maquina.deshabilitado === 0">Habilitada</span>
                        <span class="badge text-bg-danger" v-if="maquina.deshabilitado === 1">Deshabilitada</span>
                    </td>
                    <td class="align-middle">
                        <button class="btn btn-sm" @click="editMachine(maquina)">
                            <img src="../assets/editar.svg" alt="Editar" class="icon-small">
                        </button>
                        <button class="btn btn-sm" @click="toggleMachineStatus(maquina)">
                            <img src="../assets/person-lock.svg"
                                :alt="maquina.deshabilitado === 0 ? 'Deshabilitar' : 'Habilitar'" class="icon-small-2">
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
        </div>
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                <li class="page-item" :class="{ disabled: currentPage === 1 }">
                    <a class="page-link" href="#" @click.prevent="fetchMaquinas(currentPage - 1)">Anterior</a>
                </li>
                <li class="page-item" v-for="page in totalPages" :key="page" :class="{ active: currentPage === page }">
                    <a class="page-link" href="#" @click.prevent="fetchMaquinas(page)">{{ page }}</a>
                </li>
                <li class="page-item" :class="{ disabled: currentPage === totalPages }">
                    <a class="page-link" href="#" @click.prevent="fetchMaquinas(currentPage + 1)">Siguiente</a>
                </li>
            </ul>
        </nav>
    </div>
</template>

<script>
import axios from 'axios';
import { ref } from 'vue';
import { API_BASE_URL } from '@/config.js';

export default {
    props: {
        machines: Array
    },
    emits: ['edit-machine'],
    setup(props, { emit }) {
        const maquinas = ref([]);
        const currentPage = ref(1);
        const totalPages = ref(1);

        const fetchMaquinas = async (page = 1) => {
            try {
                const token = sessionStorage.getItem('token');
                if (!token) {
                    throw new Error('No token found');
                }
                const response = await axios.get(`${API_BASE_URL}/maquinas?page=${page}`, {
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer ${token}`
                    }
                });
                maquinas.value = response.data.data;
                currentPage.value = response.data.current_page;
                totalPages.value = response.data.last_page;
            } catch (error) {
                console.error('Error al obtener las máquinas:', error);
            }
        };

        const editMachine = (machine) => {
            emit('edit-machine', machine);
        };

        const toggleMachineStatus = async (machine) => {
            try {
                const token = sessionStorage.getItem('token');
                if (!token) {
                    throw new Error('No token found');
                }
                const url = `${API_BASE_URL}/maquinas/${machine.id}/${machine.deshabilitado === 0 ? 'disable' : 'enable'}`;
                await axios.put(url, {}, {
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer ${token}`
                    }
                });
                machine.deshabilitado = machine.deshabilitado === 0 ? 1 : 0;
            } catch (error) {
                console.error('Error al cambiar el estado de la máquina:', error);
            }
        };

        fetchMaquinas();

        return {
            maquinas,
            currentPage,
            totalPages,
            fetchMaquinas,
            editMachine,
            toggleMachineStatus
        };
    }
};
</script>

<style scoped>
.icon-small {
    width: 35px;
    height: 35px;
}

.icon-small-2 {
    width: 22px;
    height: 22px;
}
</style>