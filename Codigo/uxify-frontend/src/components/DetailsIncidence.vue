<template>
    <div>
        <h1>Detalles de la Incidencia</h1>
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <th>ID Incidencia</th>
                    <td>{{ incidencia.id }}</td>
                </tr>
                <tr>
                    <th>Título</th>
                    <td>{{ incidencia.titulo }}</td>
                </tr>
                <tr>
                    <th>Fecha de Creación</th>
                    <td>{{ incidencia.fecha_creacion }}</td>
                </tr>
                <tr>
                    <th>Descripción</th>
                    <td>{{ incidencia.descripcion }}</td>
                </tr>
                <tr>
                    <th>Estado</th>
                    <td>{{ estadoTexto }}</td>
                </tr>
                <tr>
                    <th>Resuelta</th>
                    <td>{{ incidencia.resuelta ? 'Sí' : 'No' }}</td>
                </tr>
                <tr>
                    <th>ID Categoría</th>
                    <td>{{ incidencia.id_categoria }}</td>
                </tr>
                <tr>
                    <th>ID Máquina</th>
                    <td>{{ incidencia.id_maquina }}</td>
                </tr>
                <tr>
                    <th>Nombre Máquina</th>
                    <td>{{ maquina.nombre }}</td>
                </tr>
                <tr>
                    <th>ID Usuario</th>
                    <td>{{ incidencia.id_usuario }}</td>
                </tr>
                <tr>
                    <th>Nombre Usuario</th>
                    <td>{{ usuario.nombre }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

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
        console.log("this.id", this.id);
        this.fetchIncidencia();
    },
    methods: {
        async fetchIncidencia() {
            try {
                const token = sessionStorage.getItem('token');
                console.log('Token:', token);
                console.log("this.id before API call:", this.id)
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
                this.fetchMaquina(this.incidencia.id_maquina);
                this.fetchUsuario(this.incidencia.id_usuario);
            } catch (error) {
                console.error('Error al obtener la incidencia:', error);
            }
        },
        async fetchMaquina(id) {
            try {
                const token = sessionStorage.getItem('token');
                if (!token) {
                    throw new Error('No token found');
                }
                const response = await axios.get(`${API_BASE_URL}/maquinas/${id}`, {
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer ${token}`
                    }
                });
                this.maquina = response.data.data;
            } catch (error) {
                console.error('Error al obtener la máquina:', error);
            }
        },
        async fetchUsuario(id) {
            try {
                const token = sessionStorage.getItem('token');
                if (!token) {
                    throw new Error('No token found');
                }
                const response = await axios.get(`${API_BASE_URL}/usuarios/${id}`, {
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer ${token}`
                    }
                });
                this.usuario = response.data.data;
            } catch (error) {
                console.error('Error al obtener el usuario:', error);
            }
        }
    }
};
</script>