<script>
import { ref, onMounted } from 'vue';
import axios from 'axios';

export default {
    data() {
        return {
            categorias: []
        };
    },
    created() {
        axios.get('http://127.0.0.1:8000/api/categorias')
            .then(response => {
                this.categorias = response.data;
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
            <h3>Gestión de Categorías</h3>
            <button>
                <i class="bi bi-person-plus"></i>
                Nueva Categoría
            </button>
        </div>
        <div class="row">
            <div class="col-12">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="categoria in categorias" :key="categoria.id">
                            <td>{{ categoria.nombre }}</td>
                            <td>{{ categoria.descripcion }}</td>
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
