<script lang="js">
import { reactive } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';

export default {
    name: 'Login',

    setup() {
        const data = reactive({
            email: '',
            password: ''
        });

        const router = useRouter();

        const submit = async () => {
            try {
                const response = await axios.post('http://127.0.0.1:8000/api/auth/login', {
                    email: data.email,
                    password: data.password
                });
                const token = response.data.access_token;
                const expiresIn = 3600; 

                sessionStorage.setItem('token', token);
                sessionStorage.setItem('token_expiration', Date.now() + expiresIn * 1000);

                setTimeout(() => {
                    sessionStorage.removeItem('token');
                    sessionStorage.removeItem('token_expiration');
                    alert('Your session has expired. Please log in again.');
                    router.push({ path: '/' });
                }, expiresIn * 1000);

                alert('Login successful');
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
        <h1 class="h3 mb-3 fw-normal">Please sign in</h1>

        <div class="form-floating">
            <input v-model="data.email" type="email" class="form-control" placeholder="Email">
        </div>
        <div class="form-floating">
            <input v-model="data.password" type="password" class="form-control" placeholder="Password">
        </div>

        <button class="btn btn-primary w-100 py-2" type="submit">Sign in</button>
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

.btn-primary {
    background-color: #007bff; /* Color de fondo del botón */
    border-color: #007bff; /* Color del borde del botón */
}

.btn-primary:hover {
    background-color: #0056b3; /* Color de fondo del botón al pasar el ratón */
    border-color: #0056b3; /* Color del borde del botón al pasar el ratón */
}
</style>