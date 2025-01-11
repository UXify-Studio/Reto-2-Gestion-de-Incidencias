<template>
    <div>
        <h2>Login</h2>
        <input type="email" v-model="credentials.email" placeholder="Email" />
        <input type="password" v-model="credentials.password" placeholder="Password" />
        <button @click="login">Login</button>
        <p v-if="message">{{ message }}</p>
    </div>
</template>

<script>
import authService from '@/services/auth';

export default {
    data() {
        return {
            credentials: {
                email: '',
                password: '',
            },
            message: null,
        }
    },
    methods: {
        async login() {
            try {
                const response = await authService.login(this.credentials);
                authService.setToken(response.data.access_token);
                this.$router.push('/dashboard')
            } catch (error) {
                this.message = error.response.data.message || 'Credenciales invalidas';
            }

        },
    }
}
</script>