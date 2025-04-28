import axios from 'axios';

const apiClient = axios.create({
    baseURL: '/api/v1',
    headers: {
        'Content-Type': 'application/json',
    },
});

apiClient.interceptors.request.use((config) => {
    const token = localStorage.getItem('auth_token');
    if (token && !['/auth/login', '/auth/register'].includes(config.url)) {
        config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
});

export default apiClient;
