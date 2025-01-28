<template>
  <Modal :show="show" :title="modalTitle" @close="close">

    <div class="d-flex justify-content-center mt-2 mb-3 z-5">
      <button
        type="button"
        class="btn btn-outline-secondary mx-2"
        :class="{ active: creandoIncidencia }"
        @click="creandoIncidencia = true"
      >
        Incidencia
      </button>
      <button
        type="button"
        class="btn btn-outline-secondary mx-2"
        :class="{ active: !creandoIncidencia }"
        @click="creandoIncidencia = false"
      >
        Mantenimiento
      </button>
    </div>

    <!-- Formulario de Incidencia -->
    <form v-if="creandoIncidencia" @submit.prevent="submitIncidencia">
      <div class="mb-3">
        <label for="titulo" class="form-label text-primary">Título *</label>
        <input type="text" class="form-control" id="titulo" v-model="incidencia.titulo" required />
      </div>

      <div class="mb-3">
        <label for="descripcion" class="form-label text-primary">Descripción *</label>
        <textarea
          class="form-control"
          id="descripcion"
          rows="3"
          v-model="incidencia.descripcion"
          required
        ></textarea>
      </div>

      <div class="mb-3">
        <label for="categoria" class="form-label text-primary">Categoría *</label>
        <select class="form-select" id="categoria" v-model="incidencia.categoria" required>
          <option value="" disabled selected>Selecciona una categoría</option>
          <option v-for="categoria in categorias" :key="categoria.id" :value="categoria.id">
            {{ categoria.nombre }}
          </option>
        </select>
      </div>

      <div class="mb-3">
        <label for="maquina" class="form-label text-primary">Máquina *</label>
        <select class="form-select" id="maquina" v-model="incidencia.maquina" required @change="cargarEstados">
          <option value="" disabled selected>Selecciona una máquina</option>
          <option v-for="maquina in maquinas" :key="maquina.id" :value="maquina.id">
            {{ maquina.codigo }} - {{ maquina.nombre }}
          </option>
        </select>
      </div>

      <div class="mb-3" v-if="incidencia.maquina">
        <label for="estado" class="form-label text-primary">Estado</label>
        <select class="form-select" id="estado" v-model="incidencia.estado" required>
          <option :value="0">Parada</option>
          <option :value="1">En marcha</option>
          <option :value="2">Mantenimiento</option>
        </select>
      </div>

      <button type="submit" class="btn btn-primary w-100" style="background-color: #512888; border-color: #512888;">
        Publicar Incidencia
      </button>
    </form>

    <!-- Formulario de Mantenimiento -->
    <form v-else @submit.prevent="submitMantenimiento">
      <div class="mb-3">
        <label class="form-label text-primary">Máquinas *</label>
        <div class="d-flex flex-column scrollable-checkbox-list text-black">
          <div v-for="maquina in maquinas" :key="maquina.id" class="mx-2 my-1">
            <input
              type="checkbox"
              :id="`maquina-${maquina.id}`"
              :value="maquina.id"
              v-model="mantenimiento.maquinas"
              class="form-check-input"
            />
            <label class="form-check-label px-2" :for="`maquina-${maquina.id}`">
              {{ maquina.codigo }} - {{ maquina.nombre }}
            </label>
          </div>
        </div>
      </div>

      <div class="mb-3">
        <label for="duracion" class="form-label text-primary">Duración *</label>
        <input type="number" class="form-control" id="duracion" v-model="mantenimiento.duracion" required />
      </div>

      <div class="mb-3">
        <label for="fecha_inicio" class="form-label text-primary">Fecha de Inicio *</label>
        <input type="date" class="form-control" id="fecha_inicio" v-model="mantenimiento.fecha_inicio" required />
      </div>

      <div class="mb-3">
        <label for="proxima_fecha" class="form-label text-primary">Próxima Fecha *</label>
        <input type="date" class="form-control" id="proxima_fecha" v-model="mantenimiento.proxima_fecha" required />
      </div>

      <div class="mb-3">
        <label for="descripcionMantenimiento" class="form-label text-primary">Descripción *</label>
        <textarea
          class="form-control"
          id="descripcionMantenimiento"
          rows="3"
          v-model="mantenimiento.descripcion"
          required
        ></textarea>
      </div>

      <div class="mb-3">
        <label for="periodo" class="form-label text-primary">Período *</label>
          <select class="form-select" id="periodo" v-model="mantenimiento.periodo" required>
          <option value="" disabled selected>Selecciona un período</option>
          <option value="diario">Diario</option>
          <option value="semanal">Semanal</option>
          <option value="mensual">Mensual</option>
          <option value="anual">Anual</option>
        </select>
      </div>

      <button type="submit" class="btn btn-primary w-100" style="background-color: #512888; border-color: #512888;">Crear Mantenimientos</button>
    </form>
  </Modal>
</template>

<script>
import axios from 'axios';
import { API_BASE_URL } from '@/config.js';
import Modal from '@/components/Modal.vue';
import { useToast } from 'vue-toastification';

export default {
  data() {
    return {
      incidencia: {
        titulo: '',
        descripcion: '',
        categoria: '',
        maquina: '',
        estado: 0,
      },
      mantenimiento: {
        duracion: null,
        fecha_inicio: '',
        proxima_fecha: '',
        descripcion: '',
        periodo: '',
          maquinas: [],
      },
      categorias: [],
      maquinas: [],
      estadosNumeros: {
        0: 'Parada',
        1: 'En marcha',
        2: 'Mantenimiento',
      },
      estadoActualNombre: null,
      creandoIncidencia: true,
    };
  },
    setup() {
        const toast = useToast();
        return { toast };
    },
  created() {
    const token = sessionStorage.getItem('token');
    if (!token) {
      console.error('No se encontró token. No se pueden obtener datos');
      return;
    }

    Promise.all([
      axios.get(`${API_BASE_URL}/categorias`, {
        headers: {
          Authorization: `Bearer ${token}`,
        },
      }),
      axios.get(`${API_BASE_URL}/maquinasTD`, {
        headers: {
          Authorization: `Bearer ${token}`,
        },
      }),
    ])
      .then((responses) => {
        this.categorias = responses[0].data;
        this.maquinas = responses[1].data;  
      })
      .catch((error) => {
        console.error('Error al cargar datos iniciales:', error);
      });
  },
  methods: {
      cargarEstados() {
          const token = sessionStorage.getItem('token');
          if (!token) {
              console.error('No se encontró token. No se pueden obtener estados');
              return;
          }

          if (this.incidencia.maquina) {
              axios.get(`${API_BASE_URL}/maquinas/${this.incidencia.maquina}/estados`, {
                  headers: {
                      'Authorization': `Bearer ${token}`
                  }
              })
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

        const response = await axios.post(
          `${API_BASE_URL}/incidencias`,
          {
            titulo: this.incidencia.titulo,
            descripcion: this.incidencia.descripcion,
            id_categoria: this.incidencia.categoria,
            id_maquina: this.incidencia.maquina,
            estado: this.incidencia.estado,
          },
          {
            headers: {
              'Content-Type': 'application/json',
              Authorization: `Bearer ${token}`,
            },
          }
        );
        this.incidencia = {
          titulo: '',
          descripcion: '',
          categoria: '',
          maquina: '',
          estado: '',
        };
        this.toast.success('Incidencia creada correctamente.', {
          position: 'top-right',
          timeout: 3000,
        });
      } catch (error) {
        if (error.response) {
          console.error('Error data:', error.response.data);
          this.toast.error('Error al crear la incidencia: ' + error.response.data.message, {
            position: 'top-right',
            timeout: 3000,
          });
        } else if (error.message === 'No se encontró el token.') {
          this.toast.error('No has iniciado sesión. Por favor, inicia sesión para crear una incidencia.', {
            position: 'top-right',
            timeout: 3000,
          });
        } else {
          console.error('Error:', error.message);
          this.toast.error('Error al crear la incidencia.', {
            position: 'top-right',
            timeout: 3000,
          });
        }
      }
    },
      async submitMantenimiento() {
          try {
              const token = sessionStorage.getItem('token');
              if (!token) {
                  throw new Error('No se encontró el token.');
              }

              // Formatear las fechas antes de enviarlas
              const formattedFechaInicio = this.formatDate(this.mantenimiento.fecha_inicio);
              const formattedProximaFecha = this.formatDate(this.mantenimiento.proxima_fecha);
              console.log(this.mantenimiento.maquinas);
              // Crear un array de promesas para cada mantenimiento
              const mantenimientoPromises = this.mantenimiento.maquinas.map(async (maquinaId) => {
                console.log('Datos a Enviar:',{
                    duracion: this.mantenimiento.duracion,
                    fecha_inicio: formattedFechaInicio, // Usar la fecha formateada
                    proxima_fecha: formattedProximaFecha, // Usar la fecha formateada
                    descripcion: this.mantenimiento.descripcion,
                    periodo: this.mantenimiento.periodo,
                    id_maquina: maquinaId
                  });
                  return axios.post(`${API_BASE_URL}/mantenimientosCreate`, {
                    duracion: this.mantenimiento.duracion,
                    fecha_inicio: formattedFechaInicio,
                    proxima_fecha: formattedProximaFecha,
                    descripcion: this.mantenimiento.descripcion,
                    periodo: this.mantenimiento.periodo,
                    id_maquina: maquinaId
                    }, {
                      headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer ${token}` // Incluir el token en la cabecera Authorization
                      }
                });
              });

              // Esperar a que todas las promesas se resuelvan
              await Promise.all(mantenimientoPromises);

               this.mantenimiento = {
                  duracion: null,
                  fecha_inicio: '',
                  proxima_fecha: '',
                  descripcion: '',
                  periodo: '',
                  maquinas: []
              };

              this.toast.success('Mantenimientos creados correctamente.', {
                  position: 'top-right',
                  timeout: 3000,
              });
          } catch (error) {
              if (error.response) {
                console.error('Error data:', error.response.data);
                  this.toast.error('Error al crear el mantenimiento: ' + error.response.data.message, {
                      position: 'top-right',
                      timeout: 3000,
                  });
              } else if (error.message === 'No se encontró el token.') {
                  this.toast.error('No has iniciado sesión. Por favor, inicia sesión para crear un mantenimiento.', {
                      position: 'top-right',
                      timeout: 3000,
                  });
              } else {
                  console.error('Error:', error.message);
                  this.toast.error('Error al crear el mantenimiento.', {
                      position: 'top-right',
                      timeout: 3000,
                  });
              }
          }
      },
    formatDate(date) {
      if (!date) return '';

      const d = new Date(date);
      const year = d.getFullYear();
      const month = String(d.getMonth() + 1).padStart(2, '0');
      const day = String(d.getDate()).padStart(2, '0');
      return `${year}-${month}-${day}`;
    },
  },
};
</script>

<style scoped>
.scrollable-checkbox-list {
  max-height: 200px;
  overflow-y: auto;
  border: 1px solid #ced4da;
  padding: 5px;
}

.modal {
  z-index: 1000;
}
</style>