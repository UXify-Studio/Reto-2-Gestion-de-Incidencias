<script>
import { ref, onMounted } from 'vue';
import axios from 'axios';

export default {
    data() {
        return {
            maquinas: []
        };
    },
    created() {
        axios.get('http://127.0.0.1:8000/api/maquinas')
            .then(response => {
                this.maquinas = response.data;
            })
            .catch(error => {
                console.error(error);
            });
    }
};
</script>

<template>
    <div class="container">
        <div class="row">
            <h3>Gestión de Maquinas</h3>
            <button>
                <i class="bi bi-person-plus"></i>
                Nueva Maquina
            </button>
        </div>
        <div class="row">
            <div class="col-12">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Codigo</th>
                            <th>Nombre</th>
                            <th>Prioridad</th>
                            <th>Seccion</th>
                            <th>Campus</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="maquina in maquinas" :key="maquina.id">
                            <td>{{ maquina.modelo }}</td>
                            <td>{{ maquina.nombre }}</td>
                            <td>{{ maquina.prioridad }}</td>
                            <td>{{ maquina.section.n_seccion }}</td>
                            <td>{{ maquina.section.campus.nombre }}</td>
                            <td>
                                <i class="bi bi-pencil"></i>
                                <i class="bi bi-trash3"></i>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
</template>
