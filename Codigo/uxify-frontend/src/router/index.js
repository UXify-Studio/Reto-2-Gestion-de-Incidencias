import { createRouter, createWebHistory } from 'vue-router'
import axios from 'axios';

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    { 
      path: '/', 
      component: () => import('../views/Login.vue') 
    },
    { 
      path: '/login', 
      component: () => import('../views/Login.vue') 
    },
    { 
      path: '/home',
      name: 'home',
      component: () => import('../views/Home.vue') 
    },
    { 
      path: '/register', 
      component: () => import('../views/Register.vue') ,
      meta: { requiresAdmin: true },
    },
  ],
})

const checkUserRole = async () => {
  const token = sessionStorage.getItem('token');
    if (!token) {
      return false;
    }
    try {
      const response = await axios.get('http://127.0.0.1:8000/api/auth/me', {
        headers: {
            'Authorization': `Bearer ${token}`
          }
      });
      console.log("rol de usuario:", response.data.id_rol);
      return response.data.id_rol === 1;
    } catch (error) {
        console.error('Error al obtener el rol del usuario:', error);
        return false;
    }
}

router.beforeEach(async (to, from, next) => {
  if (to.meta.requiresAdmin) {
    const isAdmin = await checkUserRole();

    if (isAdmin) {
      next();
    } else {
      next('/');
      alert("Necesita ser administrador para acceder a esta pagina");
    }
  } else {
    next();
  }
});

export default router
