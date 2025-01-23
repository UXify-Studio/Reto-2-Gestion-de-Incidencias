<template>
    <div class="container py-4">
      <h1 class="mb-3 text-primary fs-3">Tabla de Datos</h1>
  
      <div class="card shadow-sm">
        <div class="card-body p-0">
          <table class="table table-hover mb-0 fs-6">
            <tbody>
              <tr>
                <th class="bg-dark text-white px-3 py-2" style="width: 200px;">ID</th>
                <td class="px-3 py-2">{{ mantenimiento.id }}</td>
              </tr>
              <tr>
                <th class="bg-dark text-white px-3 py-2">ID Máquina</th>
                <td class="px-3 py-2">{{ mantenimiento.id_maquina }}</td>
              </tr>
              <tr>
                <th class="bg-dark text-white px-3 py-2">Duración</th>
                <td class="px-3 py-2">{{ mantenimiento.duracion }}</td>
              </tr>
              <tr>
                <th class="bg-dark text-white px-3 py-2">Fecha de Inicio</th>
                <td class="px-3 py-2">{{ mantenimiento.fecha_inicio }}</td>
              </tr>
              <tr>
                <th class="bg-dark text-white px-3 py-2">Próxima Fecha</th>
                <td class="px-3 py-2">{{ mantenimiento.proxima_fecha }}</td>
              </tr>
              <tr>
                <th class="bg-dark text-white px-3 py-2">ID Usuario</th>
                <td class="px-3 py-2">{{ mantenimiento.id_usuario }}</td>
              </tr>
              <tr>
                <th class="bg-dark text-white px-3 py-2">Descripción</th>
                <td class="px-3 py-2">{{ mantenimiento.descripcion }}</td>
              </tr>
              <tr>
                <th class="bg-dark text-white px-3 py-2">Periodo</th>
                <td class="px-3 py-2">{{ mantenimiento.periodo }}</td>
              </tr>
              <tr>
                <th class="bg-dark text-white px-3 py-2">Resuelta</th>
                <td class="px-3 py-2">
                  <span
                    class="badge rounded-pill px-2 py-1"
                    :class="mantenimiento.resuelta ? 'bg-success' : 'bg-danger'"
                  >
                    {{ mantenimiento.resuelta ? 'Sí' : 'No' }}
                  </span>
                </td>
              </tr>
              <tr>
                <th class="bg-dark text-white px-3 py-2">Fecha de Creación</th>
                <td class="px-3 py-2">{{ mantenimiento.created_at }}</td>
              </tr>
            

              <tr>
              <th class="bg-dark text-white px-3 py-2">Comentario</th>
              <td class="px-3 py-2">
                <textarea
                  v-model="comentario"
                  class="form-control"
                  rows="3"
                  placeholder="Añadir un comentario..."
                  @input="autoExpand($event)"
                  style="overflow:hidden; resize: none; max-height: 500px;"
                ></textarea>
                <button class="btn btn-primary mt-2" @click="guardarComentario">Guardar Comentario</button>
              </td>
            </tr>
  
            </tbody>
          </table>
        </div>
      </div>
    </div>
</template>
<script>
import axios from 'axios';
import { API_BASE_URL } from '@/config.js';
import { useToast } from 'vue-toastification';

const toast = useToast();

export default {
    name: 'MantenimientoDetalles',
    props: {
        id: {
            type: Number,
            required: true
        }
    },
    data() {
        return {
            mantenimiento: {},
            estadoTexto: 'Desconocido',
            comentario: '',
        };
    },
    created() {
        this.fetchMantenimiento();
        this.fetchComentario();
    },
    methods:{
        async fetchMantenimiento() {
            try {
                const token = sessionStorage.getItem('token');
                if (!token) {
                throw new Error('No token found');
                }
                const response = await axios.get(`${API_BASE_URL}/mantenimientos/${this.mantenimiento.id}`, {
                headers: {
                    'Content-Type': 'application/json',
                    Authorization: `Bearer ${token}`,
                },
                });
                this.mantenimiento = response.data.data;
            } catch (error) {
                toast.error('Error al obtener la incidencia');
            }
        },
        async fetchComentario() {
            try {
                const token = sessionStorage.getItem('token');
                if (!token) {
                throw new Error('No token found');
                }
                const response = await axios.get(`${API_BASE_URL}/mantenimiento/${this.id}/comentario`, {
                headers: {
                    'Content-Type': 'application/json',
                    Authorization: `Bearer ${token}`,
                },
                });
                this.comentario = response.data.comentario || '';
            } catch (error) {
                console.error('Error al obtener el comentario:', error);
            }
        },
        async guardarComentario() {
            try {
                const token = sessionStorage.getItem('token');
                if (!token) {
                throw new Error('No token found');
                }
                await axios.put(
                `${API_BASE_URL}/mantenimientos/${this.id}/comentario`,
                { comentario: this.comentario },
                {
                    headers: {
                    'Content-Type': 'application/json',
                    Authorization: `Bearer ${token}`,
                    },
                }
                );
                toast.success('Comentario guardado correctamente');
            } catch (error) {
                toast.error('Error al guardar el comentario');
            }
            },
            autoExpand(event) {
            const textarea = event.target;
            textarea.style.height = 'auto'; // Restablece la altura para calcular correctamente
            textarea.style.height = `${textarea.scrollHeight}px`; // Ajusta al contenido
         },

    }
}
</script>