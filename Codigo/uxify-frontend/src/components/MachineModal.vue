<template>
    <Modal :show="show" :title="modalTitle" @close="close" class="z-3">
        <form @submit.prevent="submit">
            <div class="mb-3">
                <label for="campus" class="form-label">Campus</label>
                <SelectCampus :selectedCampus="campusId" :selectedSection="sectionId"
                    @campus-selected="handleCampusSelected" @section-selected="handleSectionSelected" />
            </div>
            <div class="mb-3">
                <label for="codigo_maquina" class="form-label">Código de la Máquina</label>
                <input type="text" class="form-control" id="codigo_maquina" v-model="codigoMaquinaInput"
                    placeholder="Ej. 1-001-000" />
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Nombre de la Máquina</label>
                <input type="text" class="form-control" id="name" v-model="data.nombre" required>
            </div>
            <div class="mb-3">
                <label for="prioridad" class="form-label">Prioridad</label>
                <select v-model="data.prioridad" class="form-control" required>
                    <option disabled value="">Seleccione una prioridad</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="estado" class="form-label">Estado</label>
                <select v-model="data.estado" class="form-control" required>
                    <option disabled value="">Seleccione un estado</option>
                    <option value="1">Operativa</option>
                    <option value="2" v-if="!isRegisterMode">En Mantenimiento</option>
                    <option value="3" v-if="!isRegisterMode">Fuera de Servicio</option>
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
import SelectCampus from '@/components/SelectCampus.vue';
import axios from 'axios';
import { API_BASE_URL } from '@/config.js';

export default {
    components: {
        Modal,
        SelectCampus
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
            nombre: '',
            codigo: '',
            prioridad: '',
            estado: '',
            id_section: '',
            deshabilitado: false
        });

        const campusId = ref('');
        const sectionId = ref('');
        const codigoMaquinaInput = ref('');
        const initialLoad = ref(true);


        const toast = useToast();

        watch(
            () => props.machine,
            (newMachine) => {
                if (newMachine) {
                    data.id = newMachine.id;
                    data.nombre = newMachine.nombre;
                    data.codigo = newMachine.codigo;
                    data.prioridad = newMachine.prioridad;
                    data.estado = newMachine.estado;
                    data.id_section = newMachine.id_section;
                    data.deshabilitado = newMachine.deshabilitado;

                    codigoMaquinaInput.value = newMachine.codigo || ''; // Asigna el valor inicial del código
                    const [campus, section] = (newMachine.codigo || '').split('-');
                    campusId.value = campus || '';
                    sectionId.value = section || '';
                }
            },
            { immediate: true }
        );


        watch(() => props.mode, (newMode) => {
            isRegisterMode.value = newMode === 'register';
            modalTitle.value = isRegisterMode.value ? 'Registro de Nueva Máquina' : 'Editar Máquina';
            initialLoad.value = true;
            if (props.machine && props.machine.codigo) {
                const [campus, section,] = props.machine.codigo.split('-');
                campusId.value = campus;
                sectionId.value = section;
            }

        });

        const resetForm = () => {
            data.id = null;
            data.nombre = '';
            data.codigo = '';
            data.prioridad = '';
            data.estado = '';
            data.id_section = '';
            data.deshabilitado = false;
            campusId.value = '';
            sectionId.value = '';
            codigoMaquinaInput.value = ''; // Limpia el valor del input
            initialLoad.value = true;
        };


        const close = () => {
            emit('close');
            resetForm();
        };

        const handleCampusSelected = (id) => {
            campusId.value = id;
        };

        const handleSectionSelected = (id) => {
            sectionId.value = id;
            data.id_section = id;
        };


        const validateCodigoMaquina = () => {
            // Allow only numbers, hyphen, and enforce the 1-3-3 format using regex
            codigoMaquinaInput.value = codigoMaquinaInput.value.replace(/[^0-9-]/g, '');
            const parts = codigoMaquinaInput.value.split('-');
            if (parts.length > 3) {
                codigoMaquinaInput.value = parts.slice(0, 3).join('-');
            }
            if (parts.length > 0) {
                parts[0] = parts[0].slice(0, 1);
            }
            if (parts.length > 1) {
                parts[1] = parts[1].slice(0, 3);
            }
            if (parts.length > 2) {
                parts[2] = parts[2].slice(0, 3);
            }
            codigoMaquinaInput.value = parts.join('-');
        };

        const submit = async () => {
            try {
                const token = sessionStorage.getItem('token');
                if (!token) {
                    throw new Error('No se encontró el token.');
                }
                data.codigo = codigoMaquinaInput.value;
                console.log('Datos enviados:', {
                    nombre: data.nombre,
                    codigo: data.codigo,
                    prioridad: data.prioridad,
                    estado: data.estado,
                    id_section: data.id_section,
                    deshabilitado: data.deshabilitado
                });
                if (isRegisterMode.value) {
                    await axios.post(`${API_BASE_URL}/maquinas`, {
                        nombre: data.nombre,
                        codigo: data.codigo,
                        prioridad: data.prioridad,
                        estado: data.estado,
                        id_section: data.id_section,
                        deshabilitado: data.deshabilitado
                    }, {
                        headers: {
                            'Content-Type': 'application/json',
                            'Authorization': `Bearer ${token}`
                        }
                    });
                    toast.success('Registro exitoso');
                } else {
                    await axios.put(`${API_BASE_URL}/maquinas/${data.id}`, {
                        nombre: data.nombre,
                        codigo: data.codigo,
                        prioridad: data.prioridad,
                        estado: data.estado,
                        id_section: data.id_section,
                        deshabilitado: data.deshabilitado
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
                } else if (error.message === 'No se encontró el token.') {
                    toast.error('No has iniciado sesión. Por favor, inicia sesión para registrar una máquina.');
                    // ... redirige al login si es necesario ...
                } else {
                    console.error('Error:', error.message);
                    toast.error('Error al registrar la máquina.');
                }
            }
        };


        return {
            isRegisterMode,
            modalTitle,
            data,
            submit,
            close,
            handleCampusSelected,
            handleSectionSelected,
            codigoMaquinaInput,
            validateCodigoMaquina,
            campusId,
            sectionId
        };
    }
};
</script>

<style scoped>
/* Your existing styles here */
</style>