<template>
  <div class="container mt-2">
    <h2 class="text-primary mb-1 fs-4">Últimos tickets</h2>
    <hr>
    <table class="table table-bordered table-striped">
      <thead class="table-light">
        <tr>
          <th class="p-1 text-center align-middle">ID Ticket</th>
          <th class="p-1 text-center align-middle">Título</th>
          <th class="p-1 text-center align-middle">Prioridad</th>
          <th class="p-1 text-center align-middle">Estado</th>
          <th class="p-1 text-center align-middle">Asignado</th>
          <th class="p-1 text-center align-middle">Fec. creación</th>
          <th class="p-1 text-center align-middle">Categoría</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="ticket in tickets" :key="ticket.id">
          <td class="fs-6 p-1 text-center align-middle">{{ ticket.id }}</td>
          <td class="fs-6 p-1 text-center align-middle">{{ ticket.titulo }}</td>
          <td class="fs-6 p-1 text-center align-middle">{{ ticket.prioridad }}</td>
          <td class="fs-6 p-1 text-center align-middle">{{ ticket.estado }}</td>
          <td class="fs-6 p-1 text-center align-middle">{{ ticket.asignado }}</td>
          <td class="fs-6 p-1 text-center align-middle">{{ ticket.fechaCreacion }}</td>
          <td class="fs-6 p-1 text-center align-middle">{{ ticket.categoria }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
export default {
  name: 'UltimosTickets',
  data() {
    return {
      tickets: [
        {
          id: 54921,
          titulo: 'VPN caída',
          prioridad: 'Alta',
          estado: 'Abierta',
          asignado: 'Pablo Gómez',
          fechaCreacion: '20/06/2019',
          categoria: 'Electromecanica'
        },
        {
          id: 15002,
          titulo: 'Impresora departamento atascada',
          prioridad: 'Normal',
          estado: 'Abierta',
          asignado: 'Pablo Gómez',
          fechaCreacion: '22/07/2019',
          categoria: 'Eléctrico'
        },
        {
          id: 15004,
          titulo: 'Error en fichero de resumen',
          prioridad: 'Baja',
          estado: 'Petición',
          asignado: 'Pablo Gómez',
          fechaCreacion: '22/07/2019',
          categoria: 'Otra categoría'
        },
         // Agrega más tickets aquí
      ]
    };
  }
};
</script>
<style scoped>

</style>
  