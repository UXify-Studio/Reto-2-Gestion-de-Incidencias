<template>
    <div>
        <CuadrosDatos />
        <div class="container mt-2z">
            <div class="row mb-3">
                <div class="col d-flex align-items-center">
                    <FiltroCampus
                    :resetFilters="resetFilters"
                    @updateSelections="handleSelections"
                    />
                    <button class="btn btn-dark" @click="aplicarFiltro">Aplicar Filtro</button>
                    <button class="btn btn-dark" @click="borrarFiltros">Borrar Filtros</button>
                </div>
            </div>
            <h2 class="text-primary mb-1 fs-4">Mantenimientos</h2>
            <hr>
            <MantenimientosList />

            <h2 class="text-primary mb-1 fs-4">Mantenimientos Hechos</h2>
            <hr>
            <MantenimientosHechosList />
        </div>
    </div>
    
</template>

<script>

import CuadrosDatos from '@/components/CuadrosDatos.vue';
import IncidenciasList from '@/components/IncidenciasList.vue';
import FiltroCampus from '@/components/FiltroCampus.vue';
import MantenimientosList from '@/components/MantenimientosList.vue';
import MantenimientosHechosList from '@/components/MantenimientosHechosList.vue';

export default {
  name: 'MantenimientosView',
  components: {
    CuadrosDatos,
    IncidenciasList,
    FiltroCampus,
    MantenimientosList,
    MantenimientosHechosList,
  },

  data() {
    return {
      //mantenimientos: [],
    };
  },
  methods:{
    aplicarFiltro() {
        console.log("Campus ID:", this.selectedCampusId);
        console.log("Section ID:", this.selectedSectionId);
    },

    borrarFiltros() {
        this.selectedCampusId = null;
        this.selectedSectionId = null;
        this.resetFilters = true; // Activa el reset en el hijo
        setTimeout(() => {
            this.resetFilters = false; // Desactiva el reset después de un ciclo
        }, 0);
        this.$router.push('/home');
    },
    handleSelections({ campusId, sectionId }) {
        this.selectedCampusId = campusId;
        this.selectedSectionId = sectionId;
    },
  },

  

};
</script>