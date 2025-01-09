<template>
    <div>
        <h1>Users</h1>
        <ul>
            <li v-for="user in users" :key="user.id">{{ user.name }} - {{ user.email }}</li>
        </ul>
    </div>
</template>

<script>
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