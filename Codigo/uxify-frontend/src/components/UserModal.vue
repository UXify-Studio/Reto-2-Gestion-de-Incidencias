<template>
    <Modal :show="show" :title="modalTitle" @close="close">
        <form @submit.prevent="submit">
            <div class="mb-3">
                <label for="name" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="name" v-model="data.name" required>
            </div>
            <div class="mb-3">
                <label for="username" class="form-label">Nombre de Usuario</label>
                <input type="text" class="form-control" id="username" v-model="data.username" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Correo Electrónico</label>
                <input type="email" class="form-control" id="email" v-model="data.email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="password" v-model="data.password"
                    :required="isRegisterMode">
            </div>
            <div class="mb-3">
                <label for="role" class="form-label">Rol</label>
                <select v-model="data.id_rol" class="form-control" required>
                    <option disabled value="">Seleccione un rol</option>
                    <option v-for="role in roles" :key="role.id" :value="role.id">{{ role.nombre }}</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">{{ isRegisterMode ? 'Registrar' : 'Actualizar' }}</button>
        </form>
    </Modal>
</template>

<script>
import { ref, reactive, watch } from 'vue';
import { useToast } from 'vue-toastification';
import Modal from '@/components/Modal.vue';
import axios from 'axios';
import { API_BASE_URL } from '@/config.js';

export default {
    components: {
        Modal
    },
    props: {
        show: {
            type: Boolean,
            required: true
        },
        mode: {
            type: String,
            required: true
        },
        user: {
            type: Object,
            default: () => ({})
        }
    },
    setup(props, { emit }) {
        const isRegisterMode = ref(props.mode === 'register');
        const modalTitle = ref(isRegisterMode.value ? 'Registro de Nuevo Usuario' : 'Editar Usuario');
        const data = reactive({
            id: null,
            name: '',
            username: '',
            email: '',
            password: '',
            id_rol: ''
        });

        const toast = useToast();

        watch(() => props.user, (newUser) => {
            if (newUser) {
                data.id = newUser.id;
                data.name = newUser.name;
                data.username = newUser.username;
                data.email = newUser.email;
                data.id_rol = newUser.id_rol;
            }
        }, { immediate: true });

        watch(() => props.mode, (newMode) => {
            isRegisterMode.value = newMode === 'register';
            modalTitle.value = isRegisterMode.value ? 'Registro de Nuevo Usuario' : 'Editar Usuario';
        });

        const resetForm = () => {
            data.id = null;
            data.name = '';
            data.username = '';
            data.email = '';
            data.password = '';
            data.id_rol = '';
        };

        const close = () => {
            emit('close');
            resetForm();
        };

        const submit = async () => {
            try {
                const token = sessionStorage.getItem('token');
                if (!token) {
                    throw new Error('No token found');
                }
                if (isRegisterMode.value) {
                    await axios.post(`${API_BASE_URL}/auth/register`, {
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
                    toast.success('Registro exitoso');
                } else {
                    await axios.put(`${API_BASE_URL}/users/${data.id}`, {
                        name: data.name,
                        username: data.username,
                        email: data.email,
                        id_rol: data.id_rol
                    }, {
                        headers: {
                            'Content-Type': 'application/json',
                            'Authorization': `Bearer ${token}`
                        }
                    });
                    toast.success('Actualización exitosa');
                }
                emit('update-users');
                close();
            } catch (error) {
                if (error.response) {
                    console.error('Error data:', error.response.data);
                    toast.error('Error al registrar el usuario: ' + error.response.data.message);
                } else {
                    console.error('Error:', error.message);
                    toast.error('Error al registrar el usuario');
                }
            }
        };

        return {
            isRegisterMode,
            modalTitle,
            data,
            submit,
            close
        };
    },
    data() {
        return {
            roles: []
        };
    },
    created() {
        axios.get(`${API_BASE_URL}/roles`)
            .then(response => {
                this.roles = response.data;
            })
            .catch(error => {
                console.error(error);
            });
    }
};
</script>

<style scoped>
Modal {
    z-index: 999;
}
</style>