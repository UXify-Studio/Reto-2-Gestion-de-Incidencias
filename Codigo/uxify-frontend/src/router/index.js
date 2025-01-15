import { createRouter, createWebHistory } from 'vue-router';
import axios from 'axios';

import { useToast } from 'vue-toastification';
const toast = useToast();

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
      component: () => import('../views/Register.vue'),
      meta: { requiresAdmin: true },
    },
    { 
      path: '/userList', 
      component: () => import('../views/UsuariosList.vue'),
    },
  ],
});

let userRoleCache = null;

const fetchUserRole = async () => {
  if (userRoleCache) return userRoleCache;

  const token = sessionStorage.getItem('token');
  if (!token) {
    userRoleCache = { isValid: false, isAdmin: false };
    return userRoleCache;
  }

  try {
    const response = await axios.get('http://127.0.0.1:8000/api/auth/me', {
      headers: { Authorization: `Bearer ${token}` },
    });
    userRoleCache = {
      isValid: true,
      isAdmin: response.data.id_rol === 1,
    };
  } catch (error) {
    console.error('Error al verificar el token o rol:', error);
    userRoleCache = { isValid: false, isAdmin: false };
  }

  return userRoleCache;
};

router.beforeEach(async (to, from, next) => {
  const publicPages = ['/login'];
  const authRequired = !publicPages.includes(to.path);
  const { isValid, isAdmin } = await fetchUserRole();

  
  if (authRequired && !isValid) {
    sessionStorage.removeItem('token');
    toast.error('Debe iniciar sesión para acceder a esta página.');
    return next('/login');
  }

  if (to.meta.requiresAdmin && !isAdmin) {
    toast.error('Necesita ser administrador para acceder a esta página.');
    return next('/home');
  }

  next();
});

router.afterEach(() => {
  // Limpiar la caché para evitar inconsistencias en futuros cambios de usuario
  userRoleCache = null;
});

export default router;
