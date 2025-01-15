<script>
import { ref, onMounted } from 'vue';
import axios from 'axios';

export default {
    data() {
        return {
            campuses: []
        };
    },
    created() {
        axios.get('http://127.0.0.1:8000/api/campus')
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
    <div class="container">
        <div class="row">
            <h3>Gestión de Campus</h3>
            <button>
                <i class="bi bi-person-plus"></i>
                Nuevo Campus
            </button>
        </div>
        <div class="row">
            <div class="col-12">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="campus in campuses" :key="campus.id">
                            <td>{{ campus.nombre }}</td>
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
