<!-- TicketForm.vue -->
<template>
  <form @submit.prevent="submitTicket">
    <div class="mb-3">
      <label for="titulo" class="form-label text-primary">Título *</label>
      <input type="text" class="form-control" id="titulo" v-model="ticket.titulo" required>
    </div>

    <div class="mb-3">
      <label for="descripcion" class="form-label text-primary">Descripción *</label>
      <textarea class="form-control" id="descripcion" rows="3" v-model="ticket.descripcion" required></textarea>
    </div>

    <div class="mb-3">
      <label for="categoria" class="form-label text-primary">Categoría *</label>
      <select class="form-select" id="categoria" v-model="ticket.categoria" required>
        <option value="" disabled selected>Selecciona una categoría</option>
        <option v-for="categoria in categorias" :key="categoria" :value="categoria">{{ categoria }}</option>
      </select>
    </div>

    <div class="mb-3">
      <label for="centro" class="form-label text-primary">Centro *</label>
      <select class="form-select" id="centro" v-model="ticket.centro" required>
        <option value="" disabled selected>Selecciona un centro</option>
        <option v-for="centro in centros" :key="centro" :value="centro">{{ centro }}</option>
      </select>
    </div>

    <div class="mb-3">
      <label for="estado" class="form-label text-primary">Estado *</label>
      <select class="form-select" id="estado" v-model="ticket.estado" required>
        <option value="" disabled selected>Selecciona un estado</option>
        <option v-for="estado in estados" :key="estado" :value="estado">{{ estado }}</option>
      </select>
    </div>

    <div class="mb-3">
      <label class="form-label text-primary">Prioridad *</label><br>
      <div class="form-check form-check-inline">
        <input class="form-check-input text-primary" type="radio" id="alta" value="Alta" v-model="ticket.prioridad" required>
        <label class="form-check-label text-primary" for="alta">Alta</label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input text-primary" type="radio" id="media" value="Media" v-model="ticket.prioridad">
        <label class="form-check-label text-primary" for="media">Media</label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input text-primary" type="radio" id="baja" value="Baja" v-model="ticket.prioridad">
        <label class="form-check-label text-primary" for="baja">Baja</label>
      </div>
    </div>

    <button type="submit" class="btn btn-primary w-100" style="background-color: #512888; border-color: #512888;">Publicar Ticket</button>
  </form>
</template>

<script>
export default {
  data() {
    return {
      ticket: {
        titulo: '',
        descripcion: '',
        categoria: '',
        centro: '',
        estado: '',
        prioridad: ''
      },
      categorias: ['Hardware', 'Software', 'Red', 'Otro'],
      centros: ['Centro 1', 'Centro 2', 'Centro 3'],
      estados: ['Abierto', 'En proceso', 'Cerrado']
    };
  },
  methods: {
    submitTicket() {
      this.$emit('ticket-submitted', this.ticket);

      // Reset the form fields after submitting
      this.ticket = {
        titulo: '',
        descripcion: '',
        categoria: '',
        centro: '',
        estado: '',
        prioridad: ''
      };
    }
  }
};
</script>