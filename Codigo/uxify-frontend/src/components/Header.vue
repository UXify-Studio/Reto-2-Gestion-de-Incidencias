<template>
  <header class="bg-head-color text-white py-2">
    <div class="container-fluid">
      <div class="row align-items-center">
        <div class="col-md-6 d-flex align-items-center">
          <h1 class="ms-2 mb-0 fs-5">
            <router-link to="/" class="navbar-brand text-white text-decoration-none">
              UXify Workshop Software
            </router-link>
          </h1>
        </div>
        <div class="col-md-6 d-flex justify-content-end">
          <div class="d-flex align-items-center">
            <i class="bi bi-bell me-3">
              <img src="../assets/Notifi.png" class="icon" alt="Notification">
            </i>
            <router-link to="/register" class="text-white me-3">
              <i class="bi bi-gear">
                <img src="../assets/Config.png" class="icon" alt="Settings">
              </i>
            </router-link>
            <a @click.prevent="logout" class="text-white" href="#">
              <i class="bi bi-power">
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

export default {
  setup() {
    const router = useRouter();
    const toast = useToast();

    const logout = () => {
      sessionStorage.removeItem('token');
      router.push('/login');
      toast.success('Logout Exitoso', {
        position: 'top-right',
      });
    };

    return {
      logout,
    };
  },
};
</script>