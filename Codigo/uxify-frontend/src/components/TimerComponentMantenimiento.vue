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
        const idMantenimiento = ref(null);
        const idTecnico = ref(null);
        const idMantenimientoTecnico = ref(null);
        const showModal = ref(false);
        const modalTitle = ref('');
        const isStop = ref(false);
        const mantenimientoData = ref(null);

        const route = useRoute();
        const router = useRouter();

        idMantenimiento.value = route.query.id;

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

        const handleBeforeUnload = (event) => {
            if (isRunning.value) {
                event.preventDefault();
                event.returnValue = '';
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
                const response = await axios.get(`${API_BASE_URL}/mantenimiento/timer/${idMantenimiento.value}/tiempototal`, {
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
                insertMantenimiento();
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
        // Función para obtener los datos del mantenimiento actual
        const fetchMantenimientoData = async () => {
          try {
              const token = sessionStorage.getItem('token');
            const response = await axios.get(`${API_BASE_URL}/mantenimientos/${idMantenimiento.value}`, {
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`,
                },
            });
             if (response.data && response.data.data) {
                mantenimientoData.value = response.data.data;
            } else {
              toast.error("Error al obtener los datos del mantenimiento.");
            }

        } catch(error){
            toast.error('Error al obtener los datos del mantenimiento');
            }
        };

        // Función para crear un nuevo mantenimiento
        const createNewMantenimiento = async (data) => {
          try {
                const token = sessionStorage.getItem('token');
              const response = await axios.post(`${API_BASE_URL}/mantenimientosCreate`, data, {
                headers: {
                  'Content-Type': 'application/json',
                  'Authorization': `Bearer ${token}`,
                },
              });
              if (response.data.mantenimiento) {
                toast.success('Nuevo mantenimiento creado.');
              } else {
                  toast.error('Error al crear el nuevo mantenimiento');
              }
            } catch (error) {
              toast.error("Error al crear el nuevo mantenimiento.");
            }
          };
          const stopTimer = async () => {
            if (isRunning.value) {
                toast.error('Debes pausar el contador antes de marcar el mantenimiento como resuelto.');
                return;
            }
              await fetchMantenimientoData();// Primero obtenemos los datos del mantenimiento actual
            try {
                const token = sessionStorage.getItem('token');
                const response = await axios.put(`${API_BASE_URL}/mantenimientos/${idMantenimiento.value}/resuelto`, null, {
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer ${token}`,
                    },
                });

                if (response.data.success) {
                   const proximaFechaMantenimiento = new Date(mantenimientoData.value.proxima_fecha);
                    let proximaFecha;
                    switch (mantenimientoData.value.periodo) {
                        case 'diario':
                            proximaFecha = new Date(proximaFechaMantenimiento.getTime() + (24 * 60 * 60 * 1000));
                            break;
                        case 'semanal':
                            proximaFecha = new Date(proximaFechaMantenimiento.getTime() + (7 * 24 * 60 * 60 * 1000));
                            break;
                        case 'mensual':
                            proximaFecha = new Date(proximaFechaMantenimiento.getFullYear(), proximaFechaMantenimiento.getMonth() + 1, proximaFechaMantenimiento.getDate());
                             break;
                         case 'anual':
                            proximaFecha = new Date(proximaFechaMantenimiento.getFullYear() + 1, proximaFechaMantenimiento.getMonth(), proximaFechaMantenimiento.getDate());
                            break;
                        default:
                            proximaFecha = new Date();
                    }
                  const newMantenimientoData = {
                    duracion: Math.floor(mantenimientoData.value.duracion/60),
                     fecha_inicio: mantenimientoData.value.proxima_fecha, // usar proxima_fecha como fecha_inicio
                     proxima_fecha: proximaFecha.toISOString().slice(0, 10),
                    descripcion: mantenimientoData.value.descripcion,
                    periodo: mantenimientoData.value.periodo,
                    id_maquina: mantenimientoData.value.id_maquina,
                  };
                   console.log("Datos que se enviarán:", newMantenimientoData);
                    await createNewMantenimiento(newMantenimientoData);
                    toast.success('Mantenimiento marcado como resuelto');
                    time.value = 0;
                     router.push({ name: 'home' });
                } else {
                    toast.error(response.data.message || 'Error al marcar el mantenimiento como resuelto');
                }
            } catch (error) {
                if (error.response && error.response.status === 400 && error.response.data.message) {
                    toast.error(error.response.data.message);
                } else {
                    toast.error('Error al marcar el mantenimiento como resuelto');
                    console.error('Error:', error);
                }
            }
        };


        const insertMantenimiento = async () => {
            try {
                const data = {
                    id_mantenimiento: idMantenimiento.value,
                    id_tecnico: idTecnico.value,
                    fecha_inicio: startTime.value,
                };
                const response = await axios.post(`${API_BASE_URL}/mantenimiento/timer`, data);
                idMantenimientoTecnico.value = response.data.id;
                toast.success('Mantenimiento iniciado');
            } catch (error) {
                toast.error('Error al iniciar el mantenimiento');
            }
        };

        const getLatestMantenimientoTecnico = async () => {
            try {
                const response = await axios.get(`${API_BASE_URL}/mantenimiento/timer/latest`, {
                    params: {
                        id_mantenimiento: idMantenimiento.value,
                        id_tecnico: idTecnico.value,
                    }
                });
                if (response.data) {
                    idMantenimientoTecnico.value = response.data.id;
                } else {
                    toast.error('No se encontró el mantenimiento');
                }
            } catch (error) {
                toast.error('Error al obtener el mantenimiento');
            }
        };

        const updateMantenimiento = async (isStopParam = false, comentarioParam = '') => {
            try {
                await getLatestMantenimientoTecnico();
                if (!idMantenimientoTecnico.value) {
                    toast.error('No se encontró el mantenimiento');
                    return false;
                }
                const data = {
                    fecha_fin: endTime.value,
                    comentario: isStopParam ? 'Mantenimiento cerrado' : comentarioParam,
                };
                const response = await axios.put(`${API_BASE_URL}/mantenimiento/timer/${idMantenimientoTecnico.value}`, data);
                toast.success('Mantenimiento actualizado', response.data);
                return true;
            } catch (error) {
                toast.error('Error al actualizar el mantenimiento');
                return false;
            }
        };

        const handleModalSubmit = async (comment) => {
            const updateSuccess = await updateMantenimiento(isStop.value, comment);
            if (updateSuccess) {
                router.go(0);
            }
        };

        onBeforeRouteLeave((to, from, next) => {
            if (isRunning.value) {
                const confirmNavigation = window.confirm("Tienes un contador activo. ¿Estás seguro que deseas salir de esta página y perder los datos del contador? Pausa el contador o finaliza el mantenimiento antes de salir.");
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
            idMantenimiento,
            idTecnico,
            idMantenimientoTecnico,
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