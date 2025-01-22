<script>
import axios from 'axios';
import { API_BASE_URL } from '@/config.js';

export default {
    data() {
        return {
            timer: null,
            time: 0,
            isRunning: false,
            startTime: null,
            endTime: null,
            idIncidencia: 42, // Ejemplo de id_incidencia
            idTecnico: 1, // Ejemplo de id_tecnico
            idIncidenciaTecnico: null, // ID de la fila de incidencia_tecnicos
        };
    },
    computed: {
        formattedTime() {
            const minutes = Math.floor(this.time / 60);
            const seconds = this.time % 60;
            return `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
        },
    },
    methods: {
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
        async pauseTimer() {
            if (this.isRunning) {
                this.isRunning = false;
                clearInterval(this.timer);
                this.endTime = new Date().toISOString();
                await this.updateIncidencia();
            }
        },
        stopTimer() {
            if (this.isRunning) {
                this.isRunning = false;
                clearInterval(this.timer);
                this.endTime = new Date().toISOString();
                this.updateIncidencia(true);
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
                console.log('Datos enviados (insertIncidencia):', data);
                const response = await axios.post(`${API_BASE_URL}/timer`, data);
                console.log('Respuesta del servidor (insertIncidencia):', response);
                // Almacenar el ID de la fila de incidencia_tecnicos directamente desde la respuesta
                this.idIncidenciaTecnico = response.data.id;
                console.log('ID de incidencia_tecnicos almacenado:', this.idIncidenciaTecnico);
            } catch (error) {
                console.error('Error al insertar incidencia:', error);
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
                    console.log('ID de incidencia_tecnicos obtenido:', this.idIncidenciaTecnico);
                } else {
                    console.error('No se encontró el ID de incidencia_tecnicos');
                }
            } catch (error) {
                console.error('Error al obtener el ID de incidencia_tecnicos:', error);
            }
        },
        async updateIncidencia(isStop = false) {
            try {
                await this.getLatestIncidenciaTecnico();
                if (!this.idIncidenciaTecnico) {
                    console.error('ID de incidencia_tecnicos no definido');
                    return;
                }
                const data = {
                    fecha_fin: this.endTime,
                    comentario: isStop ? 'Incidencia cerrada' : 'Incidencia pausada',
                };
                console.log('Datos enviados (updateIncidencia):', data);
                const response = await axios.put(`${API_BASE_URL}/timer/${this.idIncidenciaTecnico}`, data);
                console.log('Respuesta del servidor (updateIncidencia):', response);
            } catch (error) {
                console.error('Error al actualizar incidencia:', error);
            }
        },
    },
};
</script>

<template>
  <div>
    <div>{{ formattedTime }}</div>
    <button @click="startTimer">Start</button>
    <button @click="pauseTimer">Pause</button>
    <button @click="stopTimer">Stop</button>
  </div>
</template>

<style scoped>
/* Añade estilos según sea necesario */
</style>