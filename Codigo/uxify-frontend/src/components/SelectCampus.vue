<template>
  <div>
    <!-- Selector de Campus -->
    <select name="campuses" class="form-control" v-model="selectedCampus" @change="handleCampusChange($event)">
      <option disabled selected value="">Selecciona un campus</option>
      <option value="0">Todos</option>
      <option
        v-for="campus in campuses"
        :key="campus.id"
        :value="campus.id"
      >
        {{ campus.nombre }}
      </option>
    </select>

    <!-- Selector de Secciones -->
    <select name="sections" class="form-control" v-model="selectedSection" @change="handleSectionChange($event)">
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
  props: {
    selectedCampusId: {
      type: [String, Number],
      default: null
    },
    selectedSectionId: {
      type: [String, Number],
      default: null
    }
  },
  data() {
    return {
      campuses: [],
      selectedCampus: this.selectedCampusId,
      selectedSection: this.selectedSectionId
    };
  },
  watch: {
    selectedCampus(newVal) {
      this.$emit('update:selectedCampusId', newVal);
    },
    selectedSection(newVal) {
      this.$emit('update:selectedSectionId', newVal);
    }
  },
  methods: {
    handleCampusChange(event) {
      this.selectedCampus = event.target.value;
      // Fetch sections based on selected campus
      this.fetchSections(this.selectedCampus);
    },
    handleSectionChange(event) {
      this.selectedSection = event.target.value;
    },
  },

  created() {
    const token = sessionStorage.getItem('token');
    axios
      .get(`${API_BASE_URL}/campus`, {
        headers: {
          'Content-Type': 'application/json',
          'Authorization': `Bearer ${token}`,
        },
      })
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
