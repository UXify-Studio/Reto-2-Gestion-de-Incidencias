<script>
import axios from 'axios';
import { API_BASE_URL } from '@/config.js';
import { useRoute, useRouter, onBeforeRouteLeave } from 'vue-router';
import CommentModal from './CommentModal.vue';
import { useToast } from 'vue-toastification';
import { ref, onMounted, onUnmounted, computed } from 'vue';

const toast = useToast();

export default {
    components: {
        CommentModal,
    },
    setup() {
        const timer = ref(null);
        const time = ref(0);
        const totalTime = ref(0);
        const isRunning = ref(false);
        const startTime = ref(null);
        const endTime = ref(null);
        const idIncidencia = ref(null);
        const idTecnico = ref(null);
        const idIncidenciaTecnico = ref(null);
        const showModal = ref(false);
        const modalTitle = ref('');
        const isStop = ref(false);

        const route = useRoute();
        const router = useRouter();

        idIncidencia.value = route.query.id;

        const formattedTime = computed(() => {
            const minutes = Math.floor(time.value / 60);
            const seconds = time.value % 60;
            return `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
        });

        const formattedTotalTime = computed(() => {
            const hours = Math.floor(totalTime.value / 3600);
            const minutes = Math.floor((totalTime.value % 3600) / 60);
            const seconds = totalTime.value % 60;
            return `${hours}:${minutes < 10 ? '0' : ''}${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
        });

        const handleBeforeUnload = async (event) => {
            if (isRunning.value) {
                event.preventDefault();
                event.returnValue = '';

                try {
                    if (!idIncidenciaTecnico.value) {
                        console.warn('El ID de la incidencia técnico no está disponible. Intentando obtenerlo...');
                        await getLatestIncidenciaTecnico();
                    }

                    if (idIncidenciaTecnico.value) {
                        const data = {
                            fecha_fin: new Date().toISOString(),
                            comentario: 'Incidencia parada por cierre de ventana',
                        };

                        const token = sessionStorage.getItem('token');
                        const response = await fetch(`${API_BASE_URL}/timer/${idIncidenciaTecnico.value}`, {
                            method: 'PUT',
                            headers: {
                                'Content-Type': 'application/json',
                                'Authorization': `Bearer ${token}`,
                            },
                            body: JSON.stringify(data),
                            keepalive: true, // Permite que la solicitud continúe después de cerrar la ventana
                        });

                        if (!response.ok) {
                            console.error('Error al actualizar la incidencia:', response.statusText);
                        }
                    } else {
                        console.error('No se pudo obtener el ID de la incidencia técnico antes de cerrar la ventana.');
                    }
                } catch (error) {
                    console.error('Error durante el cierre de la ventana:', error);
                }
            }
        };

        onMounted(async () => {
            window.addEventListener('beforeunload', handleBeforeUnload);

            const token = sessionStorage.getItem('token');
            try {
                const response = await axios.get(`${API_BASE_URL}/auth/me`, {
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer ${token}`
                    }
                });
                idTecnico.value = response.data.id;
                await getTotalTime(token);
            } catch (error) {
                toast.error('Error al obtener el ID del técnico');
            }
        });

        onUnmounted(() => {
            window.removeEventListener('beforeunload', handleBeforeUnload);
        });

        const getTotalTime = async (token) => {
            try {
                const response = await axios.get(`${API_BASE_URL}/timer/${idIncidencia.value}/tiempototal`, {
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer ${token}`
                    }
                });
                const { horas, minutos, segundos } = response.data.data;
                totalTime.value = (horas * 3600) + (minutos * 60) + segundos;
                console.log('Tiempo total obtenido:', totalTime.value);
            } catch (error) {
                console.error('Error al obtener el tiempo total:', error);
                toast.error('Error al obtener el tiempo total');
            }
        };

        const startTimer = () => {
            if (!isRunning.value) {
                isRunning.value = true;
                startTime.value = new Date();
                timer.value = setInterval(() => {
                    const now = new Date();
                    time.value = Math.floor((now - startTime.value) / 1000);
                }, 1000);
                insertIncidencia();
            }
        };

        const pauseTimer = () => {
            if (isRunning.value) {
                isRunning.value = false;
                clearInterval(timer.value);
                const now = new Date();
                time.value = Math.floor((now - startTime.value) / 1000);
                endTime.value = now.toISOString();
                modalTitle.value = 'Motivo de la pausa';
                isStop.value = false;
                showModal.value = true;
            }
        };

        const stopTimer = async () => {
            if (isRunning.value) {
                toast.error('Debes pausar el contador antes de marcar la incidencia como resuelta.');
                return;
            }

            try {
                const token = sessionStorage.getItem('token');
                const response = await axios.put(`${API_BASE_URL}/incidencias/${idIncidencia.value}/resuelta`, null, {
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer ${token}`,
                    },
                });

                if (response.data.success) {
                    toast.success('Incidencia marcada como resuelta');
                    time.value = 0;
                    router.push({ name: 'home' });
                } else {
                    toast.error(response.data.message || 'Error al marcar la incidencia como resuelta');
                }
            } catch (error) {
                if (error.response && error.response.status === 400 && error.response.data.message) {
                    toast.error(error.response.data.message);
                } else {
                    toast.error('Error al marcar la incidencia como resuelta');
                    console.error('Error:', error);
                }
            }
        };

        const insertIncidencia = async () => {
            try {
                const data = {
                    id_incidencia: idIncidencia.value,
                    id_tecnico: idTecnico.value,
                    fecha_inicio: startTime.value,
                };
                const response = await axios.post(`${API_BASE_URL}/timer`, data);
                idIncidenciaTecnico.value = response.data.id;
                toast.success('Incidencia iniciada');
            } catch (error) {
                toast.error('Error al iniciar la incidencia');
            }
        };

        const getLatestIncidenciaTecnico = async () => {
            try {
                const response = await axios.get(`${API_BASE_URL}/timer/latest`, {
                    params: {
                        id_incidencia: idIncidencia.value,
                        id_tecnico: idTecnico.value,
                    }
                });
                if (response.data) {
                    idIncidenciaTecnico.value = response.data.id;
                } else {
                    toast.error('No se encontró la incidencia');
                }
            } catch (error) {
                toast.error('Error al obtener la incidencia');
            }
        };

        const updateIncidencia = async (isStopParam = false, comentarioParam = '') => {
            try {
                await getLatestIncidenciaTecnico();
                if (!idIncidenciaTecnico.value) {
                    toast.error('No se encontró la incidencia');
                    return false;
                }
                const data = {
                    fecha_fin: endTime.value,
                    comentario: isStopParam ? 'Incidencia cerrada' : comentarioParam,
                };
                const response = await axios.put(`${API_BASE_URL}/timer/${idIncidenciaTecnico.value}`, data);
                toast.success('Incidencia actualizada', response.data);
                return true;
            } catch (error) {
                toast.error('Error al actualizar la incidencia');
                return false;
            }
        };

        const handleModalSubmit = async (comment) => {
            const updateSuccess = await updateIncidencia(isStop.value, comment);
            if (updateSuccess) {
                router.go(0);
            }
        };

        onBeforeRouteLeave((to, from, next) => {
            if (isRunning.value) {
                const confirmNavigation = window.confirm("Tienes un contador activo. ¿Estás seguro que deseas salir de esta página y perder los datos del contador? Pausa el contador o finaliza la incidencia antes de salir.");
                if (confirmNavigation) {
                    next();
                } else {
                    next(false);
                }
            } else {
                next();
            }
        });

        return {
            timer,
            time,
            totalTime,
            isRunning,
            startTime,
            endTime,
            idIncidencia,
            idTecnico,
            idIncidenciaTecnico,
            showModal,
            modalTitle,
            isStop,
            formattedTime,
            formattedTotalTime,
            startTimer,
            pauseTimer,
            stopTimer,
            handleModalSubmit,
        };
    },
};
</script>

<template>
    <div class="container py-4">
        <h1 class="mb-3 text-primary fs-3">Gestión de Tiempo</h1>

        <div class="card shadow-sm">
            <div class="card-body p-0">
                <table class="table table-hover mb-0 fs-6">
                    <tbody>
                        <tr>
                            <th class="bg-dark text-white px-3 py-2" style="width: 200px;">Tiempo Actual</th>
                            <td class="px-3 py-2">{{ formattedTime }}</td>
                        </tr>
                        <tr>
                            <th class="bg-dark text-white px-3 py-2">Tiempo Total</th>
                            <td class="px-3 py-2">{{ formattedTotalTime }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-3">
            <button class="btn btn-primary me-2" @click="startTimer">Empezar</button>
            <button class="btn btn-warning me-2" @click="pauseTimer">Pausar</button>
            <button class="btn btn-success" @click="stopTimer">Incidencia Resuelta</button>
        </div>

        <CommentModal :visible="showModal" :title="modalTitle" @close="showModal = false" @submit="handleModalSubmit" />
    </div>
</template>

<style scoped></style>