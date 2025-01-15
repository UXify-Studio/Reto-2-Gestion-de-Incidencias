<script lang="js">
import { reactive } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';
import { useToast } from 'vue-toastification';

export default {
    name: 'Login',

    setup() {
        const data = reactive({
            email: '',
            password: ''
        });

        const router = useRouter();
        const toast = useToast();

        const submit = async () => {
            try {
                const response = await axios.post('http://127.0.0.1:8000/api/auth/login', {
                    email: data.email,
                    password: data.password
                });
                const token = response.data.access_token;
                const expiresIn = 3600;

                if (token != null) {
                    sessionStorage.setItem('token', token);
                    router.push('/home');
                    toast.success('Login Exitoso', {
                        position: 'top-right',
                    });
                }

                setTimeout(() => {
                    sessionStorage.removeItem('token');
                    sessionStorage.removeItem('token_expiration');
                    router.push({ path: '/' });
                }, expiresIn * 1000);

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
    <div class="d-flex justify-content-center align-items-center vh-100 login-bg">
        <div class="container" style="max-width: 350px">
            <div class="row justify-content-center">
                <div class="col-12 rounded p-4 shadow form-container">
                    <form @submit.prevent="submit">
                        <div class="text-center mb-3">
                            <div class="rounded-circle profile-image-container d-flex justify-content-center align-items-center">
                                <img src="/src/assets/Login PFP.svg" alt="Profile" class="rounded-circle profile-image">
                            </div>
                        </div>
                        <div class="mb-3">
                            <input v-model="data.email" type="email" class="form-control input-opaque"
                                placeholder="Email">
                        </div>
                        <div class="mb-3">
                            <input v-model="data.password" type="password" class="form-control input-opaque"
                                placeholder="Contraseña">
                        </div>
                        <div class="col-12">
                            <button class="btn btn-purple-button w-100 py-2" type="submit">Iniciar Sesión</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.login-bg {
    background: linear-gradient(to bottom, #A855F7 0%, #6B21A8 100%);
}

.form-container {
    background-color: rgba(255, 255, 255, 0.1);
}

.profile-image-container {
    width: 70px;
    height: 70px;
    background-color: rgba(255, 255, 255, 0.2);
    margin: auto;
}

.profile-image {
    width: 40px;
    height: 40px;
    object-fit: cover;
}

.input-opaque {
    background-color: rgba(255, 255, 255, 0.2);
    border: none;
    color: white;
}
</style>