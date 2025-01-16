<template>
    <div class="container my-1 p-0">
      <h2 class="text-primary mb-1 fs-4">Estadísticas de Tickets</h2>
      <hr>  
  
      <!-- Contenedor principal con gráfico y botones -->
      <div class="d-flex justify-content-center align-items-center">
        <!-- Gráfico -->
        <div class="chart-container me-3" style="max-width: 230px;">
          <canvas ref="chartCanvas"></canvas>
        </div>
  
        <!-- Botones para cambiar tipo de gráfico -->
        <div class="btn-group d-flex flex-column p-0" role="group" aria-label="Tipos de gráfico">
          <button 
            v-for="type in chartTypes" 
            :key="type" 
            @click="changeChartType(type)" 
            class="btn btn-primary mb-2"
          >
            {{ type }}
          </button>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import { Chart, registerables } from "chart.js";
  
  Chart.register(...registerables);
  
  export default {
    name: "StatisticsChart",
    data() {
      return {
        chart: null,
        chartType: "doughnut", // Tipo inicial
        chartTypes: ["Donut", "Barras", "Pie"], // Tipos de gráficos
        chartData: {
          labels: ["Prioridad 1", "Prioridad 2", "Prioridad 3", "Resueltos", "Mantenimientos"],
          datasets: [
            {
              label: "Tickets",
              data: [10, 20, 30, 15, 25], // Datos iniciales
              backgroundColor: ["#FF4D4D", "#FFD700", "#32CD32", "#00CED1", "#DA70D6"],
            },
          ],
        },
      };
    },
    mounted() {
      this.createChart();
    },
    methods: {
      createChart() {
        const ctx = this.$refs.chartCanvas.getContext("2d");
        if (this.chart) this.chart.destroy(); // Destruir el gráfico anterior si existe
  
        this.chart = new Chart(ctx, {
          type: this.chartType,
          data: this.chartData,
          options: {
            responsive: true,
            plugins: {
              legend: {
                display: false, // Oculta la leyenda (ya se muestra arriba)
              },
              title: {
                display: false,
              },
            },
          },
        });
      },
      changeChartType(type) {
        if (type === "Donut") this.chartType = "doughnut";
        else if (type === "Barras") this.chartType = "bar";
        else if (type === "Pie") this.chartType = "pie";
  
        this.createChart();
      },
    },
  };
  </script>