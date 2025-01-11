import axios from 'axios';

const API_URL = 'http://127.0.0.1:8000/api';

const authService = {
    register(user) {
        return axios.post(`${API_URL}/register`, user);
    },
    login(credentials) {
        return axios.post(`${API_URL}/login`, credentials);
    },
    logout() {
        return axios.post(`${API_URL}/logout`, {}, {
            headers: {
                Authorization: `Bearer ${localStorage.getItem('token')}`
            }
        });
    },
    getUserProfile() {
        return axios.get(`${API_URL}/profile`, {
            headers: {
                Authorization: `Bearer ${localStorage.getItem('token')}`
            }
        });
    },
    getToken() {
        return localStorage.getItem('token');
    },
    setToken(token) {
        localStorage.setItem('token', token);
    },
    removeToken() {
        localStorage.removeItem('token');
    },
};

export default authService;