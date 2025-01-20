<template>
    <div class="containet mt-2">
      <h class="text-primary mb-1 fs-4">Situación tickets</h>
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