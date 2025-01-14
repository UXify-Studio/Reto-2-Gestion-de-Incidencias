<script setup>
import { RouterLink, RouterView } from 'vue-router'

import Login from './views/Login.vue'

import UserList from './components/UserList.vue';
</script>

<template>
  <!-- <UserList /> -->

  <main class="form-signin">
    <RouterView />
  </main>
</template>

<style scoped>

</style>
