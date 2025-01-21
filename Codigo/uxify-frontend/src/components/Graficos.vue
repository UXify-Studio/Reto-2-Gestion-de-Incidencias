<template>
  <div class="container my-1 p-0">
    <h2 class="text-primary mb-1 fs-4">Estadísticas de Tickets</h2>
    <hr>

    <div class="d-flex justify-content-center align-items-center">
      <div class="chart-container me-3" style="max-width: 230px;">
        <canvas ref="canvasRef"></canvas>
      </div>

      <div class="d-flex flex-column p-0" role="group" aria-label="Tipos de gráfico">
        <button
          v-for="type in chartTypes"
          :key="type"
          @click="changeChartType(type)"
          class="btn btn-primary mb-2"
        >
          {{ type.charAt(0).toUpperCase() + type.slice(1) }}  <!-- Capitaliza la primera letra -->
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';
import { Chart, registerables } from 'chart.js';
import { useIncidenciasStore } from '@/stores/incidencias'; // Ajusta la ruta

Chart.register(...registerables);

const chart = ref(null);
const chartType = ref('doughnut');
const chartTypes = ref(['doughnut', 'bar', 'pie']);
const canvasRef = ref(null);

const incidenciasStore = useIncidenciasStore();

onMounted(async () => {
  await incidenciasStore.fetchIncidenciasTotal();
  createChart();
});

const incidenciasAlta = computed(() => incidenciasStore.incidenciasAlta);
const incidenciasMedia = computed(() => incidenciasStore.incidenciasMedia);
const incidenciasBaja = computed(() => incidenciasStore.incidenciasBaja);
const incidenciasResueltas = computed(() => incidenciasStore.incidenciasResueltas);
const mantenimientos = computed(() => incidenciasStore.mantenimientos);

const chartData = computed(() => ({
  labels: ['Prioridad 1', 'Prioridad 2', 'Prioridad 3', 'Resueltos', 'Mantenimientos'],
  datasets: [
    {
      label: 'Tickets',
      data: [incidenciasAlta.value, incidenciasMedia.value, incidenciasBaja.value, incidenciasResueltas.value, mantenimientos.value],
      backgroundColor: ['#FF4D4D', '#FFD700', '#32CD32', '#00CED1', '#DA70D6'],
    },
  ],
}));

const createChart = () => {
  const ctx = canvasRef.value.getContext('2d');
  if (chart.value) chart.value.destroy();

  chart.value = new Chart(ctx, {
    type: chartType.value,
    data: chartData.value,
    options: {
      responsive: true,
      plugins: {
        legend: {
          display: false,
        },
        title: {
          display: false,
        },
      },
    },
  });
};

const changeChartType = (type) => {
  chartType.value = type;
  createChart();
};
</script>