<script>
import axios from 'axios';
import { ref } from 'vue';

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
                const response = await axios.get(`http://127.0.0.1:8000/api/maquinas?page=${page}`);
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
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Modelo</th>
                    <th>Prioridad</th>
                    <th>Sección</th>
                    <th>Campus</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="maquina in maquinas" :key="maquina.id">
                    <td>{{ maquina.modelo }}</td>
                    <td>{{ maquina.nombre }}</td>
                    <td>
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
                    <td>{{ maquina.section.n_seccion }}</td>
                    <td>{{ maquina.section.campus.nombre }}</td>
                    <td>
                        <button class="btn btn-sm btn-outline-secondary me-2">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-danger">
                            <i class="bi bi-trash3"></i>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
        <nav aria-label="Page navigation">
            <ul class="pagination">
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
.table {
    width: 100%;
}

.pagination {
    justify-content: center;
}
</style>