<template>
  <div class="containet">
    <h class="text-primary mb-1 fs-4">Situación General</h>
    <hr>
    <p><span class="font-weight-bold">{{ incidenciasActivas }}</span> Incidencias Activas</p>
    <p><span class="font-weight-bold">{{ incidenciasPendiente }}</span> Incidencias Pendientes</p>
    <p><span class="font-weight-bold">{{ MantenimientoHechos }}</span> Mantenimientos Resueltos</p>
    <p><span class="font-weight-bold">{{ MantenimientoProximos }}</span> Próximos mantenimientos</p>
  </div>
</template>

<script>
import { useMantenimientosCountStore } from '@/stores/mantenimientoResuelta.js';
import { useIncidenciasCountStore } from '@/stores/incidenciasActivas.js';
import { storeToRefs } from 'pinia';
import { onMounted } from 'vue';

export default {
  name: 'SituacionTickets',
  setup() {
    const mantenimientosStore = useMantenimientosCountStore();
    const incidenciasStore = useIncidenciasCountStore();

    const { MantenimientoHechos, MantenimientoProximos } = storeToRefs(mantenimientosStore);
    const { incidenciasPendiente, incidenciasActivas } = storeToRefs(incidenciasStore);

    onMounted(async () => {
      await Promise.all([
        mantenimientosStore.fetchMantenimientosCount(),
        incidenciasStore.fetchIncidenciasCount(),
      ]);
    });

    return {
      MantenimientoHechos,
      MantenimientoProximos,
      incidenciasPendiente,
      incidenciasActivas
    };
  },
};
</script>