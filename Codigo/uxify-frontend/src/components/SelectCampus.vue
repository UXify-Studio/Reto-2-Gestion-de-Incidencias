
<template>
  <div>
    <!-- Selector de Campus -->
    <select name="campuses" @change="handleCampusChange($event)">
      <option disabled selected value="">Selecciona un campus</option>
      <option
        v-for="campus in campuses"
        :key="campus.id"
        :value="campus.id"
      >
        {{ campus.nombre }}
      </option>
    </select>

    <!-- Selector de Secciones -->
    <select name="sections">
      <option v-for="section in sections" :key="section.id" :value="section.id">
        {{ section.nombre }}
      </option>
    </select>
  </div>
</template>

<script>
import { computed, onMounted } from 'vue';
import { useSectionsStore } from '../stores/sectionsPorCampus';
import axios from 'axios';

export default{
  data() {
      return {
          campuses: [],
      };
  },
  created() {
      axios.get('http://127.0.0.1:8000/api/campus')
          .then(response => {
              this.campuses = response.data;
              console.log('Campuses:', response.data);
          })
          .catch(error => {
              console.error(error);
          });
  },
  // Usamos setup() para trabajar con Pinia
  setup() {
    // Vinculamos el store
    const sectionsStore = useSectionsStore();

    // Función para manejar el cambio de campus
    //onMounted(() => {});
    const handleCampusChange = (event) => {
      const selectedCampus = event.target.value; // ID del campus seleccionado
      sectionsStore.campus = selectedCampus; // Actualizamos el estado en el store
      sectionsStore.fetchSectionsByCampus(); // Llamamos la acción para obtener secciones
    };

    const sections = computed(() => sectionsStore.sections);

    return {
      sections, // Obtenemos las secciones del store
      handleCampusChange,
    };
  },
};

</script>