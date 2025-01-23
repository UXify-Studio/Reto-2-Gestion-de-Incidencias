<template>
  <div class="container py-4">
    <h1 class="mb-3 text-primary fs-3">Detalles de la Incidencia</h1>

    <div class="card shadow-sm">
      <div class="card-body p-0">
        <table class="table table-hover mb-0 fs-6">
          <tbody>
            <!-- Campos existentes -->
            <tr>
              <th class="bg-dark text-white px-3 py-2" style="width: 200px;">ID Incidencia</th>
              <td class="px-3 py-2">{{ incidencia.id }}</td>
            </tr>
            <tr>
              <th class="bg-dark text-white px-3 py-2">Título</th>
              <td class="px-3 py-2">{{ incidencia.titulo }}</td>
            </tr>
            <tr>
              <th class="bg-dark text-white px-3 py-2">Fecha de Creación</th>
              <td class="px-3 py-2">{{ incidencia.fecha_creacion }}</td>
            </tr>
            <tr>
              <th class="bg-dark text-white px-3 py-2">Descripción</th>
              <td class="px-3 py-2">{{ incidencia.descripcion }}</td>
            </tr>
            <tr>
              <th class="bg-dark text-white px-3 py-2">Estado</th>
              <td class="px-3 py-2">
                <span
                  class="badge rounded-pill px-2 py-1"
                  :class="{
                    'bg-warning': estadoTexto === 'Pendiente',
                    'bg-success': estadoTexto === 'En proceso',
                    'bg-danger': estadoTexto === 'Parada'
                  }"
                >
                  {{ estadoTexto }}
                </span>
              </td>
            </tr>
            <tr>
              <th class="bg-dark text-white px-3 py-2">Resuelta</th>
              <td class="px-3 py-2">
                <span
                  class="badge rounded-pill px-2 py-1"
                  :class="incidencia.resuelta ? 'bg-success' : 'bg-danger'"
                >
                  {{ incidencia.resuelta ? 'Sí' : 'No' }}
                </span>
              </td>
            </tr>
            <tr>
              <th class="bg-dark text-white px-3 py-2">ID Categoría</th>
              <td class="px-3 py-2">{{ incidencia.id_categoria }}</td>
            </tr>
            <tr>
              <th class="bg-dark text-white px-3 py-2">Nombre Categoría</th>
              <td class="px-3 py-2">{{ incidencia.nombre_categoria }}</td>
            </tr>
            <tr>
              <th class="bg-dark text-white px-3 py-2">ID Máquina</th>
              <td class="px-3 py-2">{{ incidencia.id_maquina }}</td>
            </tr>
            <tr>
              <th class="bg-dark text-white px-3 py-2">Nombre Máquina</th>
              <td class="px-3 py-2">{{ incidencia.nombre_maquina }}</td>
            </tr>
            <tr>
              <th class="bg-dark text-white px-3 py-2">ID Usuario</th>
              <td class="px-3 py-2">{{ incidencia.id_usuario }}</td>
            </tr>
            <tr>
              <th class="bg-dark text-white px-3 py-2">Nombre Usuario</th>
              <td class="px-3 py-2">{{ incidencia.nombre_usuario }}</td>
            </tr>

            <!-- Nuevo campo Comentario -->
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
  name: 'IncidenciaDetalles',
  props: {
    id: {
      type: String,
      required: true,
    },
  },
  data() {
    return {
      incidencia: {},
      estadoTexto: 'Desconocido', // Estado inicial
      comentario: '', // Nuevo campo de comentario
    };
  },
  created() {
    this.fetchIncidencia();
    this.fetchEstado();
    this.fetchComentario(); // Obtener el comentario existente
  },
  methods: {
    async fetchIncidencia() {
      try {
        const token = sessionStorage.getItem('token');
        if (!token) {
          throw new Error('No token found');
        }
        const response = await axios.get(`${API_BASE_URL}/incidencias/${this.id}`, {
          headers: {
            'Content-Type': 'application/json',
            Authorization: `Bearer ${token}`,
          },
        });
        this.incidencia = response.data.data;
      } catch (error) {
        toast.error('Error al obtener la incidencia');
      }
    },
    async fetchEstado() {
      try {
        const token = sessionStorage.getItem('token');
        if (!token) {
          throw new Error('No token found');
        }
        const response = await axios.get(`${API_BASE_URL}/incidencias/${this.id}/estado`, {
          headers: {
            'Content-Type': 'application/json',
            Authorization: `Bearer ${token}`,
          },
        });
        const estado = response.data.estado;
        this.estadoTexto = this.getEstadoTexto(estado);
      } catch (error) {
        console.error('Error al obtener el estado:', error);
      }
    },
    async fetchComentario() {
      try {
        const token = sessionStorage.getItem('token');
        if (!token) {
          throw new Error('No token found');
        }
        const response = await axios.get(`${API_BASE_URL}/incidencias/${this.id}/comentario`, {
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
          `${API_BASE_URL}/incidencias/${this.id}/comentario`,
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
    getEstadoTexto(estado) {
      switch (estado) {
        case 0:
          return 'Pendiente';
        case 1:
          return 'En proceso';
        case 2:
          return 'Parada';
        default:
          return 'Desconocido';
      }
    },
  },
};
</script>
