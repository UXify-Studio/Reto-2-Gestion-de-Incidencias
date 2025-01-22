<script>
import axios from 'axios';
import { API_BASE_URL } from '@/config.js';
import { useRoute } from 'vue-router';
import CommentModal from './CommentModal.vue';
import { useToast } from 'vue-toastification';

const toast = useToast();

export default {
    components: {
        CommentModal,
    },
    data() {
        return {
            timer: null,
            time: 0,
            totalTime: 0, // Tiempo total que lleva el usuario reparando la incidencia en segundos
            isRunning: false,
            startTime: null,
            endTime: null,
            idIncidencia: null,
            idTecnico: null,
            idIncidenciaTecnico: null,
            showModal: false,
            modalTitle: '',
            isStop: false,
        };
    },
    async beforeMount() {
        const route = useRoute();
        this.idIncidencia = route.query.id;

        const token = sessionStorage.getItem('token');

        try {
            const response = await axios.get(`${API_BASE_URL}/auth/me`, {
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`
                }
            });
            this.idTecnico = response.data.id;

            // Obtener el tiempo total que lleva el usuario reparando la incidencia
            await this.getTotalTime(token);
        } catch (error) {
            toast.error('Error al obtener el ID del técnico');
        }
    },
    computed: {
        formattedTime() {
            const minutes = Math.floor(this.time / 60);
            const seconds = this.time % 60;
            return `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
        },
        formattedTotalTime() {
            const hours = Math.floor(this.totalTime / 3600);
            const minutes = Math.floor((this.totalTime % 3600) / 60);
            const seconds = this.totalTime % 60;
            return `${hours}:${minutes < 10 ? '0' : ''}${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
        },
    },
    methods: {
        async getTotalTime(token) {
            try {
                const response = await axios.get(`${API_BASE_URL}/timer/${this.idIncidencia}/tiempototal`, {
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer ${token}`
                    }
                });
                const { horas, minutos, segundos } = response.data.data;
                this.totalTime = (horas * 3600) + (minutos * 60) + segundos;
                console.log('Tiempo total obtenido:', this.totalTime);
            } catch (error) {
                console.error('Error al obtener el tiempo total:', error);
                toast.error('Error al obtener el tiempo total');
            }
        },
        startTimer() {
            if (!this.isRunning) {
                this.isRunning = true;
                this.startTime = new Date().toISOString();
                this.timer = setInterval(() => {
                    this.time++;
                }, 1000);
                this.insertIncidencia();
            }
        },
        pauseTimer() {
            if (this.isRunning) {
                this.isRunning = false;
                clearInterval(this.timer);
                this.endTime = new Date().toISOString();
                this.modalTitle = 'Motivo de la pausa';
                this.isStop = false;
                this.showModal = true;
            }
        },
        stopTimer() {
            if (this.isRunning) {
                this.isRunning = false;
                clearInterval(this.timer);
                this.endTime = new Date().toISOString();
                this.modalTitle = 'Motivo de la parada';
                this.isStop = true;
                this.showModal = true;
                this.time = 0;
            }
        },
        async insertIncidencia() {
            try {
                const data = {
                    id_incidencia: this.idIncidencia,
                    id_tecnico: this.idTecnico,
                    fecha_inicio: this.startTime,
                };
                const response = await axios.post(`${API_BASE_URL}/timer`, data);

                this.idIncidenciaTecnico = response.data.id;
                toast.success('Incidencia iniciada');
            } catch (error) {
                toast.error('Error al iniciar la incidencia');
            }
        },
        async getLatestIncidenciaTecnico() {
            try {
                const response = await axios.get(`${API_BASE_URL}/timer/latest`, {
                    params: {
                        id_incidencia: this.idIncidencia,
                        id_tecnico: this.idTecnico,
                    }
                });
                if (response.data) {
                    this.idIncidenciaTecnico = response.data.id;
                } else {
                    toast.error('No se encontró la incidencia');
                }
            } catch (error) {
                toast.error('Error al obtener la incidencia');
            }
        },
        async updateIncidencia(isStop = false, comentario = '') {
            try {
                await this.getLatestIncidenciaTecnico();
                if (!this.idIncidenciaTecnico) {
                    toast.error('No se encontró la incidencia');
                    return;
                }
                const data = {
                    fecha_fin: this.endTime,
                    comentario: isStop ? 'Incidencia cerrada' : comentario,
                };
                const response = await axios.put(`${API_BASE_URL}/timer/${this.idIncidenciaTecnico}`, data);
                toast.success('Incidencia actualizada', response.data);
            } catch (error) {
                toast.error('Error al actualizar la incidencia');
            }
        },
        handleModalSubmit(comment) {
            this.updateIncidencia(this.isStop, comment);
        },
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