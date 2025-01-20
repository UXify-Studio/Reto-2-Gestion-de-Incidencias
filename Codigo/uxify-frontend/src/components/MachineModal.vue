<template>
    <Modal :show="show" :title="modalTitle" @close="close">
        <form @submit.prevent="submit">
            <div class="mb-3">
                <label for="campus" class="form-label">Campus</label>
                <SelectCampus @campus-selected="handleCampusSelected" @section-selected="handleSectionSelected"
                    :selected-campus="campusId" :selected-section="sectionId" />
            </div>
            <div class="mb-3">
                <label for="codigo_maquina" class="form-label">Código de la Máquina</label>
                <div class="codigo-maquina-wrapper">
                    <span class="codigo-maquina-prefix">
                        {{ campusId || "0" }}-{{ sectionId.padStart(3, '0') || "000" }}-
                    </span>
                    <input type="text" class="form-control codigo-maquina-input" id="codigo_maquina"
                        v-model="customCodigo" placeholder="000" maxlength="3" @input="validateCustomCodigo" />
                </div>

            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Nombre de la Máquina</label>
                <input type="text" class="form-control" id="name" v-model="data.name" required />
            </div>
            <div class="mb-3">
                <label for="prioridad" class="form-label">Prioridad</label>
                <select v-model="data.prioridad" class="form-control" required>
                    <option disabled value="">Seleccione una prioridad</option>
                    <option value="Alta">Alta</option>
                    <option value="Media">Media</option>
                    <option value="Baja">Baja</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="estado" class="form-label">Estado</label>
                <select v-model="data.estado" class="form-control" required>
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
import { ref, reactive, computed, watch } from 'vue';
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
        show: Boolean,
        mode: String,
        machine: Object
    },
    setup(props, { emit }) {
        const isRegisterMode = ref(props.mode === 'register');
        const modalTitle = computed(() =>
            isRegisterMode.value ? 'Registro de Nueva Máquina' : 'Editar Máquina'
        );

        const data = reactive({
            id: null,
            name: '',
            prioridad: '',
            estado: '',
            id_section: ''
        });

        const campusId = ref('');
        const sectionId = ref('');
        const customCodigo = ref('');

        const toast = useToast();

        watch(
            () => props.machine,
            (newMachine) => {
                if (newMachine) {
                    const [campus, section, custom] = newMachine.codigo_maquina.split('-');
                    campusId.value = campus || 'X';
                    sectionId.value = section || 'XXX';
                    customCodigo.value = custom || '';
                    data.name = newMachine.name || '';
                    data.prioridad = newMachine.prioridad || '';
                    data.estado = newMachine.estado || '';
                    data.id_section = newMachine.id_section || '';
                }
            },
            { immediate: true }
        );

        const handleCampusSelected = (id) => {
            campusId.value = id;
        };

        const handleSectionSelected = (id) => {
            sectionId.value = id;
            data.id_section = id;
        };

        const validateCustomCodigo = () => {
            // Solo números y máximo de 3 caracteres
            customCodigo.value = customCodigo.value.replace(/\D/g, '').slice(0, 3);
        };


        const submit = async () => {
            try {
                const token = sessionStorage.getItem('token');
                data.codigo_maquina = `${campusId.value || 'X'}-${sectionId.value.padStart(3, '0')}-${customCodigo.value || '000'}`;
                if (isRegisterMode.value) {
                    await axios.post(`${API_BASE_URL}/machines`, { ...data }, {
                        headers: { Authorization: `Bearer ${token}` }
                    });
                    toast.success('Máquina registrada correctamente');
                } else {
                    await axios.put(`${API_BASE_URL}/machines/${data.id}`, { ...data }, {
                        headers: { Authorization: `Bearer ${token}` }
                    });
                    toast.success('Máquina actualizada correctamente');
                }
                emit('update-machines');
                emit('close');
            } catch (error) {
                toast.error('Error al guardar la máquina');
            }
        };

        return {
            modalTitle,
            isRegisterMode,
            data,
            campusId,
            sectionId,
            customCodigo,
            handleCampusSelected,
            handleSectionSelected,
            validateCustomCodigo,
            submit
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
