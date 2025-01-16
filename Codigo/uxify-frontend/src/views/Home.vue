<script setup>
import CuadrosDatos from '../components/CuadrosDatos.vue';
import UltimosTickets from '../components/UltimosTickets.vue';
import IncidenCatego from '../components/IncidenCatego.vue';
import SituacionTick from '../components/SituacionTick.vue';
import Graficos from "../components/Graficos.vue";

</script>

<template>
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">  <!-- CuadrosDatos ocupa todo el ancho -->
        <CuadrosDatos />
      </div>
    </div>
    <div class="row">
      <div class="col-md-8 p-2">
        <UltimosTickets />
      </div>
      <div class="col-md-4 p-0"> <!-- Ajustado a col-md-5 -->
        <SituacionTick />
      </div>
    </div>
    <div class="row">
      <div class="col-md-8">
        <IncidenCatego />
      </div>
      <div class="col-md-4">  <!-- Ajustado a col-md-5 -->
        <Graficos />
      </div>
    </div>
  </div>
</template>