<script lang="js">
import { reactive } from 'vue';
import axios from 'axios';

export default {
    name: 'Register',

    data() {
        return {
            roles: []
        };
    },

    created() {
        axios.get('http://127.0.0.1:8000/api/roles')
            .then(response => {
                this.roles = response.data;
            })
            .catch(error => {
                console.error(error);
            });
    },

    setup() {
        const data = reactive({
            name: '',
            username: '',
            email: '',
            password: '',
            id_rol: ''
        });

        const submit = async () => {
            try {
                console.log(data);
                const token = sessionStorage.getItem('token');
                if (!token) {
                    throw new Error('No token found');
                }
                await axios.post('http://127.0.0.1:8000/api/auth/register', {
                    name: data.name,
                    username: data.username,
                    email: data.email,
                    password: data.password,
                    id_rol: data.id_rol
                }, {
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer ${token}`
                    }
                });
                alert('Registration successful');
            } catch (error) {
                if (error.response) {
                    console.error('Error data:', error.response.data);
                    console.error('Error status:', error.response.status);
                    console.error('Error headers:', error.response.headers);
                } else {
                    console.error('Error message:', error.message);
                }
            }
        };

        return {
            data,
            submit
        };
    }
};
</script>

<template>
    <form @submit.prevent="submit">
        <h1 class="h3 mb-3 fw-normal">Please register</h1>

        <div class="form-floating">
            <input v-model="data.name" type="text" class="form-control" placeholder="Nombre">
        </div>
        <div class="form-floating">
            <input v-model="data.username" type="text" class="form-control" placeholder="Nombre de Usuario">
        </div>
        <div class="form-floating">
            <input v-model="data.email" type="email" class="form-control" placeholder="Email">
        </div>
        <div class="form-floating">
            <input v-model="data.password" type="password" class="form-control" placeholder="Contraseña">
        </div>
        <div class="form-floating">
            <select v-model="data.id_rol" class="form-control">
                <option disabled value="">Seleccione un rol</option>
                <option v-for="role in roles" :key="role.id" :value="role.id">{{ role.nombre }}</option>
            </select>
        </div>

        <button class="btn btn-primary w-100 py-2" type="submit">Register</button>
        <p class="mt-5 mb-3 text-body-secondary">&copy; 2017-2024</p>
    </form>
</template>

<style scoped>
.form-control {
    color: black; /* Cambia el color del texto a negro */
    background-color: white; /* Asegura que el fondo sea blanco */
}

.form-floating {
    margin-bottom: 1rem; /* Añade un margen inferior para separar los campos */
}

.form-control::placeholder {
    color: #6c757d; /* Cambia el color del placeholder a un gris oscuro */
}

select.form-control {
    color: black; /* Cambia el color del texto del select a negro */
    background-color: white; /* Asegura que el fondo del select sea blanco */
}

option {
    color: black; /* Cambia el color del texto de las opciones a negro */
    background-color: white; /* Asegura que el fondo de las opciones sea blanco */
}

.btn-primary {
    background-color: #007bff; /* Color de fondo del botón */
    border-color: #007bff; /* Color del borde del botón */
}

.btn-primary:hover {
    background-color: #0056b3; /* Color de fondo del botón al pasar el ratón */
    border-color: #0056b3; /* Color del borde del botón al pasar el ratón */
}
</style>