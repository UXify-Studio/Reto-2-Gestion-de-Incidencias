<script setup>
import Header from '../components/Header.vue';
import Sidebar from '../components/Sidebar.vue';
</script>

<template>
  <div class="container-fluid">
    <div class="row">
      <div class="col-12 p-0">
        <Header />
      </div>
    </div>
    <div class="row">
      <div class="col-auto p-0">
        <Sidebar />
      </div>
      <div class="col p-0">
        <!-- MAS CONTENIDO -->
      </div>
    </div>
  </div>
</template>