<template>
  <div>
    <!-- Filtros -->
    <CuadrosDatos />

    <!-- Lista de Incidencias -->
    <IncidenciasList />
  </div>
</template>

<script>
import CuadrosDatos from '@/components/CuadrosDatos.vue';
import IncidenciasList from '@/components/IncidenciasList.vue';

export default {
  name: 'Home',
  components: {
    CuadrosDatos,
    IncidenciasList,
  },
};
</script>
