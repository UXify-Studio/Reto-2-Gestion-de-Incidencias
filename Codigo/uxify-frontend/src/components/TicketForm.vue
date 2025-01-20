<!-- IncidenciaForm.vue -->
<template>
  <form @submit.prevent="submitIncidencia">
    <div class="mb-3">
      <label for="titulo" class="form-label text-primary">Título *</label>
      <input type="text" class="form-control" id="titulo" v-model="incidencia.titulo" required>
    </div>

    <div class="mb-3">
      <label for="descripcion" class="form-label text-primary">Descripción *</label>
      <textarea class="form-control" id="descripcion" rows="3" v-model="incidencia.descripcion" required></textarea>
    </div>

    <div class="mb-3">
      <label for="categoria" class="form-label text-primary">categoria *</label>
      <select class="form-select" id="categoria" v-model="incidencia.categoria" required>
        <option value="" disabled selected>Selecciona una categoría</option>
        <option v-for="categoria in categorias" :key="categoria.id" :value="categoria.id">{{ categoria.nombre }}</option>
      </select>
    </div>


    <div class="mb-3">
      <label for="maquina" class="form-label text-primary">Maquina *</label>
      <select class="form-select" id="maquina" v-model="incidencia.maquina" required @change="cargarEstados">
        <option value="" disabled selected>Selecciona una Maquina</option>
        <option v-for="maquina in maquinas" :key="maquina.id" :value="maquina.id">{{ maquina.codigo }} - {{ maquina.nombre }}</option>
      </select>
    </div>

    <div class="mb-3" v-if="incidencia.maquina">
        <label for="estado" class="form-label text-primary">Selecciona un estado</label>
        <select class="form-select" id="estado" v-model="incidencia.estado" required>
            <option :value="0">Parada</option>
            <option :value="1">En marcha</option>
            <option :value="2">Mantenimiento</option>
        </select>
    </div>

    
    <button type="submit" class="btn btn-primary w-100" style="background-color: #512888; border-color: #512888;">Publicar Incidencia</button>
  </form>
</template>

<script>
import axios from 'axios';
export default {
  data() {
    return {
      incidencia: {
        titulo: '',
        descripcion: '',
        categoria: '',
        maquina: '',
        estado: ''
      },
      categorias: [],
      maquinas: [],
      estadosNumeros: {
          0: 'Parada',
          1: 'En marcha',
          2: 'Mantenimiento'
      },
      estadoActualNombre: null
    };
  },
  created() {
    Promise.all([
      axios.get(`${API_BASE_URL}/categorias`),
      axios.get(`${API_BASE_URL}/maquinasTD`)
    ])
    .then(responses => {
      this.categorias = responses[0].data;
      this.maquinas = responses[1].data;
    })
    .catch(error => {
      console.error("Error al cargar datos iniciales:", error);
    });
  },
  methods: {
    cargarEstados() {
        if (this.incidencia.maquina) {
            axios.get(`${API_BASE_URL}/maquinas/${this.incidencia.maquina}/estados`)
                .then(response => {
                    const maquina = response.data;
                    this.incidencia.estado = maquina.estado;
                    this.estadoActualNombre = this.nombreEstado(this.incidencia.estado);
                })
                .catch(error => {
                    console.error("Error al cargar el estado:", error);
                    this.incidencia.estado = null;
                    this.estadoActualNombre = 'Desconocido';
                });
        } else {
            this.incidencia.estado = null;
            this.estadoActualNombre = 'Desconocido';
        }
    },
    nombreEstado(estadoNumero) {
        return this.estadosNumeros[estadoNumero] || 'Desconocido';
    },
    async submitIncidencia() {
      try {
          const token = sessionStorage.getItem('token');
          if (!token) {
              throw new Error('No se encontró el token.');
          }

          const response = await axios.post(`${API_BASE_URL}/incidencias`, this.incidencia, {
              headers: {
                  'Content-Type': 'application/json',
                  'Authorization': `Bearer ${token}`
              }
          });

          console.log("Incidencia creada:", response.data);
          this.$emit('incidencia-submitted', response.data); // Emitir la respuesta completa

          // Reiniciar formulario y mostrar mensaje de éxito
          this.incidencia = {
              titulo: '',
              descripcion: '',
              categoria: '',
              maquina: '',
              estado: '',
          };
          alert('Incidencia creada correctamente.');

          // ... código para actualizar la lista de incidencias si es necesario ...

      } catch (error) {
          if (error.response) {
              console.error('Error data:', error.response.data);
              alert('Error al crear la incidencia: ' + error.response.data.message);
          } else if (error.message === 'No se encontró el token.') {
              alert('No has iniciado sesión. Por favor, inicia sesión para crear una incidencia.');
              // ... redirige al login si es necesario ...
          } else {
              console.error('Error:', error.message);
              alert('Error al crear la incidencia.');
          }
      }
    }
  }
};
</script>