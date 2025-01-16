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
      <div class="col-12">
        <CuadrosDatos />
      </div>
    </div>
    <div class="row">
      <div class="col-md-8 p-2">
        <UltimosTickets />
      </div>
      <div class="col-md-4 p-0">
        <SituacionTick />
      </div>
    </div>
    <div class="row">
      <div class="col-md-8 p-0">
        <IncidenCatego />
      </div>
      <div class="col-md-4 p-0">
        <Graficos />
      </div>
    </div>
  </div>
</template>