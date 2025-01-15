<script>
import { ref, onMounted } from 'vue';
import axios from 'axios';

export default {
    data() {
        return {
            users: []
        };
    },
    created() {
        axios.get('http://127.0.0.1:8000/api/users')
            .then(response => {
                this.users = response.data;
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
            <h3>Gestión de Usuarios</h3>
            <i class="bi bi-person-plus"></i>
        </div>
        <div class="row">
            <div class="col-12">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="user in users" :key="user.id">
                            <td>{{ user.name }}</td>
                            <td>{{ user.username }}</td>
                            <td>{{ user.email }}</td>
                            <td>{{ user.rol.nombre }}</td>
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
