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
    <select name="sections" @change="handleSectionChange($event)">
      <option disabled selected value="">Selecciona una sección</option>
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
import { API_BASE_URL } from '@/config.js';

export default {
  data() {
    return {
      campuses: [],
    };
  },
  created() {
    axios
      .get(`${API_BASE_URL}/campus`)
      .then((response) => {
        this.campuses = response.data;
      })
      .catch((error) => {
        console.error(error);
      });
  },
  setup(props, { emit }) {
    const sectionsStore = useSectionsStore();

    // Funciones para manejar el cambio de campus y sección
    const handleCampusChange = (event) => {
      const selectedCampus = event.target.value;
      sectionsStore.campus = selectedCampus;
      sectionsStore.fetchSectionsByCampus();
      emit('campus-selected', selectedCampus); // Emite el evento al componente padre
    };

    const handleSectionChange = (event) => {
      const selectedSection = event.target.value;
      emit('section-selected', selectedSection); // Emite el evento al componente padre
    };

    const sections = computed(() => sectionsStore.sections);

    return {
      sections,
      handleCampusChange,
      handleSectionChange,
    };
  },
};
</script>
