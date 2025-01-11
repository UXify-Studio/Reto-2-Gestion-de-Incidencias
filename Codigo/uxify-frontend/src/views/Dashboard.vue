<template>
    <div>
        <h2>Dashboard</h2>
        <p v-if="user">Bienvenido: {{ user.name }}</p>
        <p v-if="loading">Cargando...</p>
        <button @click="logout">Logout</button>
    </div>
</template>

<script>
import authService from '@/services/auth';
export default {
    data() {
        return {
            user: null,
            loading: true,
        }
    },
    async mounted() {
        try {
            const response = await authService.getUserProfile();
            this.user = response.data;
        } catch (error) {
            console.log(error);
        } finally {
            this.loading = false;
        }
    },
    methods: {
        logout() {
            authService.logout();
            this.$router.push('/login');
        },
    },
}
</script>