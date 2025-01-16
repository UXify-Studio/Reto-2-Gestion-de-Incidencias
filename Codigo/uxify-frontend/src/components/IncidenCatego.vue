<template>
    <div class="container mt-4">
      <h2 class="text-primary mb-1 fs-4">Incidencias por Categoría</h2>
      <table class="table table-bordered table-striped">
        <thead class="table-light"> 
          <tr>
            <th class="p-1 text-center align-middle">Categoría</th>
            <th class="p-1 text-center align-middle">Prioridad Baja</th>
            <th class="p-1 text-center align-middle">Prioridad Media</th>
            <th class="p-1 text-center align-middle">Prioridad Alta</th>
            <th class="p-1 text-center align-middle">Incumplidos</th>
            <th class="p-1 text-center align-middle">En proceso</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="categoria in categorias" :key="categoria.nombre">
            <td class="text-center align-middle">{{ categoria.nombre }}</td>
            <td class="text-center align-middle">{{ categoria.baja }}</td>
            <td class="text-center align-middle">{{ categoria.media }}</td>
            <td class="text-center align-middle">{{ categoria.alta }}</td>
            <td class="text-center align-middle">{{ categoria.incumplidos }}</td>
            <td class="text-center align-middle">{{ categoria.enProceso }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </template>
  
  <script>
  export default {
    name: 'IncidenciasPorCategoria',
    data() {
      return {
        categorias: [
          { nombre: 'Eléctrico', baja: 2, media: 0, alta: 0, incumplidos: 0, enProceso: 0 },
          { nombre: 'Mecánico', baja: 22, media: 1, alta: 0, incumplidos: 16, enProceso: 5 },
          { nombre: 'Categoría 3', baja: 1, media: 0, alta: 0, incumplidos: 2, enProceso: 0 },
          { nombre: 'Categoría 4', baja: 0, media: 0, alta: 0, incumplidos: 0, enProceso: 0 },
        ],
      };
    },
  };
  </script>
  
  <style scoped>
  
  </style>