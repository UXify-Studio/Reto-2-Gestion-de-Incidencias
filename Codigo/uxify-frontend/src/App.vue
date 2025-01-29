<script setup>
import { RouterLink, RouterView, useRoute, useRouter } from "vue-router";
import { ref, watch, onMounted, onUnmounted } from "vue";

import Header from "./components/Header.vue";
import Sidebar from "./components/Sidebar.vue";

const route = useRoute();
const router = useRouter();
const showHeaderAndSidebar = ref(route.path !== '/login' && route.path !== '/');
const isSidebarVisible = ref(false);

const checkScreenSize = () => {
  if (window.innerWidth < 768) {
    isSidebarVisible.value = false;
  } else {
    isSidebarVisible.value = true;
  }
};

onMounted(() => {
  checkScreenSize();
  window.addEventListener('resize', checkScreenSize);
});

onUnmounted(() => {
  window.removeEventListener('resize', checkScreenSize);
});

const toggleSidebar = () => {
  isSidebarVisible.value = !isSidebarVisible.value;
};

watch(route, (newRoute) => {
  showHeaderAndSidebar.value = newRoute.path !== '/login' && newRoute.path !== '/';
});
</script>

<template>
  <div class="container-fluid p-0">
    <Header v-if="showHeaderAndSidebar" @toggle-sidebar="toggleSidebar" />
    <main class="d-flex">
      <div class="row w-100 m-0">
        <div class="col-2 p-0 bg-light border-end" v-if="showHeaderAndSidebar && isSidebarVisible">
          <Sidebar />
        </div>
        <div :class="showHeaderAndSidebar && isSidebarVisible ? 'col-10 p-0' : 'col-12 p-0'">
          <RouterView />
        </div>
      </div>
    </main>
  </div>
</template>

<style scoped>
.container-fluid {
  max-width: 100%;
}
.col-10, .col-12 {
  padding-right: 0;
}
</style>