<template>
    <div class="container-fluid p-4">
        <div class="row mb-4">
            <CuadrosDatosUsuarios />
        </div>
        <div class="row mb-3">
            <div class="col d-flex justify-content-between align-items-center">
                <h3 class="mb-0">Gestión de Usuarios</h3>
                <button class="btn btn-dark" @click="openModal('register')">
                    <i class="bi bi-person-plus me-2"></i> Nuevo Usuario
                </button>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <UserList :users="users" :pagination="pagination" @edit-user="openModal('edit', $event)"
                    @toggle-user-status="toggleUserStatus($event)" @update:users="users = $event"
                    @update:pagination="pagination = $event" />
            </div>
        </div>

        <!-- Modal -->
        <UserModal :show="showModal" :mode="modalMode" :user="selectedUser" @close="closeModal"
            @update-users="fetchUsers" />
    </div>
</template>

<script>
import { ref, reactive } from 'vue';
import CuadrosDatosUsuarios from '@/components/CuadrosDatosUsuarios.vue';
import UserList from '@/components/UserList.vue';
import UserModal from '@/components/UserModal.vue';
import axios from 'axios';

export default {
    components: {
        CuadrosDatosUsuarios,
        UserList,
        UserModal
    },
    setup() {
        const showModal = ref(false);
        const modalMode = ref('register');
        const selectedUser = ref(null);
        const users = ref([]);
        const pagination = reactive({
            current_page: 1,
            last_page: 1,
            per_page: 10
        });

        const openModal = (mode, user = null) => {
            modalMode.value = mode;
            selectedUser.value = user;
            showModal.value = true;
        };

        const closeModal = () => {
            showModal.value = false;
            selectedUser.value = null;
        };

        const fetchUsers = async (page = 1) => {
            try {
                const response = await axios.get(`${API_BASE_URL}/users?page=${page}`);
                users.value = response.data.data;
                pagination.current_page = response.data.current_page;
                pagination.last_page = response.data.last_page;
                pagination.per_page = response.data.per_page;
            } catch (error) {
                console.error(error);
            }
        };

        const toggleUserStatus = async (user) => {
            try {
                const token = sessionStorage.getItem('token');
                if (!token) {
                    throw new Error('No token found');
                }
                const url = user.deshabilitado === 0
                    ? `${API_BASE_URL}/users/${user.id}/disable`
                    : `${API_BASE_URL}/users/${user.id}/enable`;
                await axios.put(url, {}, {
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer ${token}`
                    }
                });
                fetchUsers();
            } catch (error) {
                console.error(error);
            }
        };

        return {
            showModal,
            modalMode,
            selectedUser,
            users,
            pagination,
            openModal,
            closeModal,
            fetchUsers,
            toggleUserStatus
        };
    },
    created() {
        this.fetchUsers();
    }
};
</script>

<style scoped>
.container-fluid {
    max-width: 100%;
}
</style>