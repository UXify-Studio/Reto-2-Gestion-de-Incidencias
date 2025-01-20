<script>
import SelectCampus from '../components/SelectCampus.vue';
import CuadrosDatos from '../components/CuadrosDatos.vue';

export default {
  name: 'Home',
  components: {
    SelectCampus,
    CuadrosDatos,

  },
};
</script>

<template>
    <CuadrosDatos />
    <SelectCampus />
</template>