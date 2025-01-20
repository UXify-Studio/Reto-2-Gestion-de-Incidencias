<template>
    <Modal :show="show" :title="modalTitle" @close="close">
        <form @submit.prevent="submit">
            <div class="mb-3">
                <label for="name" class="form-label">Nombre de la Máquina</label>
                <input type="text" class="form-control" id="name" v-model="data.name" required>
            </div>
            <div class="mb-3">
                <label for="type" class="form-label">Tipo</label>
                <input type="text" class="form-control" id="type" v-model="data.type" required>
            </div>
            <div class="mb-3">
                <label for="location" class="form-label">Ubicación</label>
                <input type="text" class="form-control" id="location" v-model="data.location" required>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Estado</label>
                <select v-model="data.status" class="form-control" required>
                    <option disabled value="">Seleccione un estado</option>
                    <option value="Operativa">Operativa</option>
                    <option value="En Mantenimiento">En Mantenimiento</option>
                    <option value="Fuera de Servicio">Fuera de Servicio</option>
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
        machine: {
            type: Object,
            default: () => ({})
        }
    },
    setup(props, { emit }) {
        const isRegisterMode = ref(props.mode === 'register');
        const modalTitle = ref(isRegisterMode.value ? 'Registro de Nueva Máquina' : 'Editar Máquina');
        const data = reactive({
            id: null,
            name: '',
            type: '',
            location: '',
            status: ''
        });

        const toast = useToast();

        watch(() => props.machine, (newMachine) => {
            if (newMachine) {
                data.id = newMachine.id;
                data.name = newMachine.name;
                data.type = newMachine.type;
                data.location = newMachine.location;
                data.status = newMachine.status;
            }
        }, { immediate: true });

        watch(() => props.mode, (newMode) => {
            isRegisterMode.value = newMode === 'register';
            modalTitle.value = isRegisterMode.value ? 'Registro de Nueva Máquina' : 'Editar Máquina';
        });

        const resetForm = () => {
            data.id = null;
            data.name = '';
            data.type = '';
            data.location = '';
            data.status = '';
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
                    await axios.post(`${API_BASE_URL}/machines`, {
                        name: data.name,
                        type: data.type,
                        location: data.location,
                        status: data.status
                    }, {
                        headers: {
                            'Content-Type': 'application/json',
                            'Authorization': `Bearer ${token}`
                        }
                    });
                    toast.success('Registro exitoso');
                } else {
                    await axios.put(`${API_BASE_URL}/machines/${data.id}`, {
                        name: data.name,
                        type: data.type,
                        location: data.location,
                        status: data.status
                    }, {
                        headers: {
                            'Content-Type': 'application/json',
                            'Authorization': `Bearer ${token}`
                        }
                    });
                    toast.success('Actualización exitosa');
                }
                emit('update-machines');
                close();
            } catch (error) {
                if (error.response) {
                    console.error('Error data:', error.response.data);
                    toast.error('Error al registrar la máquina: ' + error.response.data.message);
                } else {
                    console.error('Error:', error.message);
                    toast.error('Error al registrar la máquina');
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
    }
};
</script>

<style scoped>
/* Estilos del componente */
</style>