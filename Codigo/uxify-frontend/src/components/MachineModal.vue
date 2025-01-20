<template>
    <Modal :show="show" :title="modalTitle" @close="close">
        <form @submit.prevent="submit">
            <div class="mb-3">
                <label for="campus" class="form-label">Campus</label>
                <SelectCampus @campus-selected="handleCampusSelected" @section-selected="handleSectionSelected" />
            </div>
            <div class="mb-3">
                <label for="codigo_maquina" class="form-label">Código de la Máquina</label>
                <div class="codigo-maquina-wrapper">
                    <span class="codigo-maquina-prefix">
                        {{ campusId || "0" }}-{{ sectionId ? sectionId.padStart(3, '0') : "000" }}-
                    </span>
                    <input type="text" class="form-control codigo-maquina-input" id="codigo_maquina"
                        v-model="customCodigo" placeholder="000" maxlength="3" @input="validateCustomCodigo" />
                </div>
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Nombre de la Máquina</label>
                <input type="text" class="form-control" id="name" v-model="data.nombre" required>
            </div>
            <div class="mb-3">
                <label for="prioridad" class="form-label">Prioridad</label>
                <select v-model="data.prioridad" class="form-control" required>
                    <option disabled value="">Seleccione una prioridad</option>
                    <option value="1">Alta</option>
                    <option value="2">Media</option>
                    <option value="3">Baja</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="estado" class="form-label">Estado</label>
                <select v-model="data.estado" class="form-control" required>
                    <option disabled value="">Seleccione un estado</option>
                    <option value="1">Operativa</option>
                    <option value="2">En Mantenimiento</option>
                    <option value="3">Fuera de Servicio</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">{{ isRegisterMode ? 'Registrar' : 'Actualizar' }}</button>
        </form>
    </Modal>
</template>

<script>
import { ref, reactive, watch, computed } from 'vue';
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
        const customCodigo = ref('');

        const codigoMaquina = computed(() => {
            return `${campusId.value}-${sectionId.value ? sectionId.value.padStart(3, '0') : "000"}-${customCodigo.value}`;
        });

        const toast = useToast();

        watch(() => props.machine, (newMachine) => {
            if (newMachine) {
                data.id = newMachine.id;
                data.nombre = newMachine.nombre;
                data.codigo = newMachine.codigo;
                data.prioridad = newMachine.prioridad;
                data.estado = newMachine.estado;
                data.id_section = newMachine.id_section;
                data.deshabilitado = newMachine.deshabilitado;

                const [campus, section, custom] = newMachine.codigo.split('-');
                campusId.value = campus;
                sectionId.value = section;
                customCodigo.value = custom;
            }
        }, { immediate: true });

        watch(() => props.mode, (newMode) => {
            isRegisterMode.value = newMode === 'register';
            modalTitle.value = isRegisterMode.value ? 'Registro de Nueva Máquina' : 'Editar Máquina';
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
            customCodigo.value = '';
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

        const validateCustomCodigo = () => {
            customCodigo.value = customCodigo.value.replace(/[^0-9]/g, '').slice(0, 3);
        };

        const submit = async () => {
            try {
                const token = sessionStorage.getItem('token');
                if (!token) {
                    throw new Error('No se encontró el token.');
                }
                data.codigo = codigoMaquina.value;

                // Verificar los datos antes de enviar
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
                    alert('Error al registrar la máquina: ' + error.response.data.message);
                } else if (error.message === 'No se encontró el token.') {
                    alert('No has iniciado sesión. Por favor, inicia sesión para registrar una máquina.');
                    // ... redirige al login si es necesario ...
                } else {
                    console.error('Error:', error.message);
                    alert('Error al registrar la máquina.');
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
            codigoMaquina,
            customCodigo,
            validateCustomCodigo
        };
    }
};
</script>

<style scoped>
.codigo-maquina-wrapper {
    display: flex;
    align-items: center;
}

.codigo-maquina-prefix {
    background-color: #f8f9fa;
    border: 1px solid #ced4da;
    border-right: none;
    padding: 0.375rem 0.75rem;
    border-radius: 0.375rem 0 0 0.375rem;
    font-size: 1rem;
}

.codigo-maquina-input {
    flex: 1;
    border-radius: 0 0.375rem 0.375rem 0;
}
</style>
