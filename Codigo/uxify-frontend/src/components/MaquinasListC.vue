<script>
import axios from 'axios';
import { ref } from 'vue';
import { API_BASE_URL } from '@/config.js';

export default {
    props: {
        maquinas: Array
    },
    setup() {
        const maquinas = ref([]);
        const currentPage = ref(1);
        const totalPages = ref(1);

        const fetchMaquinas = async (page = 1) => {
            try {
                const response = await axios.get(`${API_BASE_URL}/maquinas?page=${page}`);
                maquinas.value = response.data.data;
                currentPage.value = response.data.current_page;
                totalPages.value = response.data.last_page;
            } catch (error) {
                console.error('Error al obtener las máquinas:', error);
            }
        };

        fetchMaquinas();

        return {
            maquinas,
            currentPage,
            totalPages,
            fetchMaquinas
        };
    }
};
</script>

<template>
    <div>
        <table class="table table-striped table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th class="align-middle">Modelo</th>
                    <th class="align-middle">Nombre</th>
                    <th class="align-middle">Prioridad</th>
                    <th class="align-middle">Estado</th>
                    <th class="align-middle">Sección</th>
                    <th class="align-middle">Campus</th>
                    <th class="align-middle">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="maquina in maquinas" :key="maquina.id">
                    <td class="align-middle">{{ maquina.modelo }}</td>
                    <td class="align-middle">{{ maquina.nombre }}</td>
                    <td class="align-middle">
                        <span class="badge text-bg-warning" v-if="maquina.prioridad === 1">
                            {{ maquina.prioridad }}
                        </span>
                        <span class="badge text-bg-success" v-if="maquina.prioridad === 2">
                            {{ maquina.prioridad }}
                        </span>
                        <span class="badge text-bg-resueltos text-white" v-if="maquina.prioridad === 3">
                            {{ maquina.prioridad }}
                        </span>
                    </td>
                    <td class="align-middle">
                        <span class="badge text-bg-danger" v-if="maquina.estado === 0">
                            {{ maquina.estado }}
                        </span>
                        <span class="badge text-bg-success" v-if="maquina.estado === 1">
                            {{ maquina.estado }}
                        </span>
                    </td>
                    <td class="align-middle">{{ maquina.section.n_seccion }}</td>
                    <td class="align-middle">{{ maquina.section.campus.nombre }}</td>
                    <td class="align-middle">
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