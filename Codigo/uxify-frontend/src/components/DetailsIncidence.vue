<template>
    <div class="container py-4">
      <h1 class="mb-3 text-primary fs-3">Detalles de la Incidencia</h1>
      
      <div class="card shadow-sm">
        <div class="card-body p-0">
          <table class="table table-hover mb-0 fs-6">
            <tbody>
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
                  <span class="badge rounded-pill px-2 py-1" 
                        :class="{
                          'bg-warning': estadoTexto === 'Pendiente',
                          'bg-danger': estadoTexto === 'Parada',
                          'bg-info': estadoTexto === 'En curso',
                          'bg-secondary': estadoTexto === 'Desconocido'
                        }">
                    {{ estadoTexto }}
                  </span>
                </td>
              </tr>
              <tr>
                <th class="bg-dark text-white px-3 py-2">Resuelta</th>
                <td class="px-3 py-2">
                  <span class="badge rounded-pill px-2 py-1" 
                        :class="incidencia.resuelta ? 'bg-success' : 'bg-danger'">
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
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </template>
  
  <style scoped>
  .table {
    border-collapse: separate;
    border-spacing: 0;
  }
  
  .table tr:last-child td,
  .table tr:last-child th {
    border-bottom: none;
  }
  
  .table td, 
  .table th {
    border: none;
    border-bottom: 1px solid #dee2e6;
    vertical-align: middle;
    padding-top: 0.5rem;
    padding-bottom: 0.5rem;
  }
  
  .badge {
    font-weight: 500;
    font-size: 0.75rem;
  }
  
  .card {
    border-radius: 8px;
    overflow: hidden;
    border: 1px solid #dee2e6;
  }
  
  h1 {
    font-size: 1.75rem;
    font-weight: 600;
  }
  </style>  
  
  <script>
  import axios from 'axios';
  import { API_BASE_URL } from '@/config.js';
  
  export default {
    name: 'IncidenciaDetalles',
    props: {
      id: {
        type: String,
        required: true
      }
    },
    data() {
      return {
        incidencia: {},
        maquina: {},
        usuario: {}
      };
    },
    computed: {
      estadoTexto() {
        switch (this.incidencia.estado) {
          case 0:
            return 'Pendiente';
          case 1:
            return 'Parada';
          case 2:
            return 'En curso';
          default:
            return 'Desconocido';
        }
      }
    },
    created() {
      this.fetchIncidencia();
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
              'Authorization': `Bearer ${token}`
            }
          });
          this.incidencia = response.data.data;
        } catch (error) {
          console.error('Error al obtener la incidencia:', error);
        }
      },
    }
  };
  </script>