import { createRouter, createWebHistory } from 'vue-router';
import axios from 'axios';

import { API_BASE_URL } from '@/config.js';

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
      path: '/estadisticas',
      name: 'estadisticas',
      component: () => import('../views/Estadisticas.vue') 
    },
    { 
      path: '/register', 
      component: () => import('../views/Register.vue'),
      meta: { requiresAdmin: true },
    },
    {
      path: '/incidencia/detalles',
      name: 'IncidenciaDetalles',
      component: () => import('../views/DetailsIncidenceView.vue'),
      props: route => ({ id: route.query.id })
    },
    { 
      path: '/gestion/users', 
      component: () => import('../views/admin/UsuariosListView.vue') ,
      //meta: { requiresAdmin: true },
    },
    { 
      path: '/gestion/maquinas', 
      component: () => import('../views/admin/MaquinasListView.vue') ,
      //meta: { requiresAdmin: true },
    },
    { 
      path: '/gestion/categorias', 
      component: () => import('../views/admin/CategoriasList.vue') ,
      //meta: { requiresAdmin: true },
    },
    {
      path: '/gestion/campus', 
      component: () => import('../views/admin/CampusList.vue') ,
      //meta: { requiresAdmin: true },
    },
    { 
      path: '/gestion/secciones', 
      component: () => import('../views/admin/SeccionesList.vue') ,
      //meta: { requiresAdmin: true },
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
    const response = await axios.get(`${API_BASE_URL}/auth/me`, {
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
