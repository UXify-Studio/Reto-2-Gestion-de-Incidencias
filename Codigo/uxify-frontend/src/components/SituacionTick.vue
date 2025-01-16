<template>
    <div>
      <h3>Situación tickets</h3>
      <hr>
      <p><span class="font-weight-bold">{{ tickets.activas }}</span> Incidencias Activas</p>
      <p><span class="font-weight-bold">{{ tickets.pendientes }}</span> Incidencias Pendientes</p>
      <p><span class="font-weight-bold">{{ tickets.sinAsignar }}</span> Incidencias sin asignar</p>
      <p><span class="font-weight-bold">{{ tickets.mantenimientos }}</span> Próximos mantenimientos</p>
  
    </div>
  </template>
  
  <script>
  export default {
    name: 'SituacionTickets',
    data() {
      return {
        tickets: {
          activas: 50,
          pendientes: 17,
          sinAsignar: 23,
          mantenimientos: 1
        }
      };
    }
  };
  </script>