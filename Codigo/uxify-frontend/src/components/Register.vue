<template>
    <div>
        <h2>Register</h2>
        <input type="text" v-model="user.name" placeholder="Name" />
        <input type="email" v-model="user.email" placeholder="Email" />
        <input type="password" v-model="user.password" placeholder="Password" />
        <button @click="register">Register</button>
        <p v-if="message">{{ message }}</p>
    </div>
</template>

<script>
import authService from '@/services/auth';

export default {
    data() {
        return {
            user: {
                name: '',
                email: '',
                password: '',
            },
            message: null,
        };
    },
    methods: {
        async register() {
            try {
                const response = await authService.register(this.user);
                this.message = response.data.message;
            } catch (error) {
                this.message = error.response.data.message;
            }

        },
    },
}
</script>