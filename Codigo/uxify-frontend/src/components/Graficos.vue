<template>
    <div class="container my-1">
      <h2 class=" text-primary mb-1 fs-4">Estadísticas de Tickets</h2>
      <hr>
      <!-- Leyenda -->
      
  
      <!-- Gráfico -->
      <div class="d-flex justify-content-center">
        <div class="chart-container" style="max-width: 200px;">
          <canvas ref="chartCanvas"></canvas>
        </div>
      </div>
  
      <!-- Botones para cambiar tipo de gráfico -->
      <div class="d-flex justify-content-center mt-4">
        <button 
          v-for="type in chartTypes" 
          :key="type" 
          @click="changeChartType(type)" 
          class="btn btn-primary mx-2"
        >
          {{ type }}
        </button>
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
                display: true,
                text: "Estadísticas de Tickets",
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
  
      