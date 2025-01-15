<script setup>
import Header from '../components/Header.vue';
import Sidebar from '../components/Sidebar.vue';
import CuadrosDatos from '../components/CuadrosDatos.vue';
</script>

<template>
  <div class="container-fluid">
    <div class="row">
        <Header />
    </div>
    <div class="row">
      <div class="col-2 p-0">
        <Sidebar />
      </div>
      <div class="col-10 p-0">
        <div class="row-auto">
          <CuadrosDatos />
        </div>
      </div>
    </div>
  </div>
</template>

