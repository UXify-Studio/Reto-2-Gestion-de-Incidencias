<script setup>
import CuadrosDatos from '../components/CuadrosDatos.vue';
import UltimosTickets from '../components/UltimosTickets.vue';
import IncidenCatego from '../components/IncidenCatego.vue';
import SituacionTick from '../components/SituacionTick.vue';
</script>

<template>
  <div class="container-fluid">
    <div class="row">
      <div class="row-auto">
        <CuadrosDatos />
      </div>
      <div class="row">
        <div class="col-md-7">
          <UltimosTickets />
        </div>
        <div class="col-md-3 p-4">
          <SituacionTick />
        </div>
      </div>
      <div class="row">
        <div class="col-md-7">
          <IncidenCatego />
        </div>
        <div class="col-md-3 p-4">
          <SituacionTick />
        </div>
      </div>
    </div>
  </div>
</template>
