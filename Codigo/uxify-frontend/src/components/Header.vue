<template>
  <header class="bg-head-color text-white py-2">
    <div class="container-fluid">
      <div class="row align-items-center">
        <div class="col-md-6 d-flex align-items-center">
          <button class="btn btn-link text-white d-md-none" @click="toggleSidebar">
            <img src="../assets/list.svg" alt="Toggle Sidebar"></img>
          </button>
          <h1 class="ms-2 mb-0 fs-5">
            <router-link to="/home" class="navbar-brand text-white text-decoration-none">
              UXify Workshop Software
            </router-link>
          </h1>
        </div>
        <div class="col-md-6 d-flex justify-content-end">
          <div class="d-flex align-items-center">
            <a @click.prevent="logout" class="text-white" href="#">
              <i class="bi">
                <img src="../assets/Session.png" class="icon" alt="Logout">
              </i>
            </a>
          </div>
        </div>
      </div>
    </div>
  </header>
</template>

<script>
import { useRouter } from 'vue-router';
import { useToast } from 'vue-toastification';
import { defineComponent } from 'vue';

export default defineComponent({
  setup(_, { emit }) {
    const router = useRouter();
    const toast = useToast();

    const toggleSidebar = () => {
      emit('toggleSidebar');
    };

    const logout = () => {
      sessionStorage.removeItem('token');
      toast.success('Sesión cerrada correctamente');
      router.push('/login');
    };

    return {
      toggleSidebar,
      logout,
    };
  },
});
</script>

<style scoped>
.bg-head-color {
  background-color: #343a40;
}
.icon {
  width: 24px;
  height: 24px;
}
</style>