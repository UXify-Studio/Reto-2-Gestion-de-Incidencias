import axios from 'axios';
import router from '@/router';
import authService from '@/services/auth';

axios.interceptors.request.use(
    (config) => {
        const token = authService.getToken();
        if (token) {
            config.headers.Authorization = `Bearer ${token}`;
        }
        return config;
    },
    (error) => {
        return Promise.reject(error);
    }
);

axios.interceptors.response.use(
    (response) => {
        return response;
    },
    (error) => {
        if (error.response.status === 401) {
            authService.removeToken();
            router.push('/login')
        }
        return Promise.reject(error);
    }
);
export default axios;