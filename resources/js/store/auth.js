import { ref } from 'vue';
import api from '../api/api';
import { useRouter } from 'vue-router';

export function useAuth() {
    const user = ref(null);
    const isAuthenticated = ref(false);
    const router = useRouter();
    const errors = ref({});

    const init = async () => {
        const token = localStorage.getItem('auth_token');
        if (token) {
            try {
                const response = await api.get('/user');
                user.value = response.data;
                isAuthenticated.value = true;
            } catch (error) {
                logout();
            }
        }
    };
    
    const login = async (credentials) => {
        errors.value = {};
        try {
            const response = await api.post('/login', credentials);
            localStorage.setItem('auth_token', response.data.data.token);
            localStorage.setItem('user_data', JSON.stringify(response.data.data.user));
            user.value = response.data.data.user;
            isAuthenticated.value = true;
            await router.push({ path: '/' });
        } catch (error) {
            if (error.response && error.response.status === 422) {
                errors.value = error.response.data.errors;
            } else {
                console.error('Login error:', error);
            }
            throw error;
        }
    };

    const logout = async () => {
        try {
            await api.post('/logout');
        } catch (error) {
            console.error('Logout error:', error);
        } finally {
            localStorage.removeItem('auth_token');
            localStorage.removeItem('user_data');
            user.value = null;
            isAuthenticated.value = false;
            await router.push({ path: 'auth/login' });
        }
    };

    return {
        user,
        isAuthenticated,
        errors,
        init,
        login,
        logout,
    };
}