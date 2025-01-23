<template>
    <div>
        <!-- Selector de Campus -->
        <select name="campuses" class="form-control" @change="handleCampusChange" v-model="selectedCampus">
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
        <select name="sections" class="form-control" @change="handleSectionChange" v-model="selectedSection">
            <option disabled value="">Selecciona una seccion</option>
            <option v-for="section in sections" :key="section.id" :value="section.id">
                {{ section.nombre }}
            </option>
        </select>
    </div>
</template>

<script>
import { ref, computed } from 'vue';
import { useSectionsStore } from '../stores/sectionsPorCampus';
import axios from 'axios';
import { API_BASE_URL } from '@/config.js';

export default {
    props: {
        resetFilters: {
            type: Boolean,
            default: false,
        },
    },
    watch: {
        resetFilters(newVal) {
            if (newVal) {
                this.resetSelections();
            }
        },
    },
    setup(_, { emit }) {
        const campuses = ref([]);
        const selectedCampus = ref("");
        const selectedSection = ref("");

        const sectionsStore = useSectionsStore();
        const sections = computed(() => sectionsStore.sections);

        const handleCampusChange = (event) => {
            const campusId = event.target.value;
            sectionsStore.campus = campusId;
            sectionsStore.fetchSectionsByCampus();
            selectedSection.value = ""; // Restablecer selección de sección
            emit("updateSelections", { campusId, sectionId: null });
        };

        const handleSectionChange = (event) => {
            const sectionId = event.target.value;
            emit("updateSelections", {
                campusId: selectedCampus.value,
                sectionId,
            });
        };

        const resetSelections = () => {
            selectedCampus.value = "";
            selectedSection.value = "";
            emit("updateSelections", { campusId: null, sectionId: null });
        };

        axios.get(`${API_BASE_URL}/campus`)
            .then(response => {
                campuses.value = response.data;
            })
            .catch(error => console.error(error));

        return {
            campuses,
            sections,
            selectedCampus,
            selectedSection,
            handleCampusChange,
            handleSectionChange,
            resetSelections,
        };
    },
};
</script>
