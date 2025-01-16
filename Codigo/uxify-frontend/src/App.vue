<script setup>
import { RouterLink, RouterView } from "vue-router";

import Header from "./components/Header.vue";
import Sidebar from "./components/Sidebar.vue";
</script>

<template>
  <Header />
  <main>
    <div class="row">
      <div class="col-2 p-0">
        <Sidebar />
      </div>
      <div class="col-10 p-0">
        <RouterView />
      </div>
    </div>
  </main>
</template>

<style scoped></style>
