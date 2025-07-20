<template>
    <!-- <div class="login-container">
        <form @submit.prevent="handleLogin">
            <div>
                <label>Email</label>
                <input v-model="form.email" type="email">
                <span v-if="errors.email">{{ errors.email[0] }}</span>
            </div>
            <div>
                <label>Password</label>
                <input v-model="form.password" type="password">
                <span v-if="errors.password">{{ errors.password[0] }}</span>
            </div>
            <button type="submit">Login</button>
        </form>
    </div>
    //--------------- -->
     <div class="login-container">
    <div class="login-card">
      <h2 class="login-title">Вхід в систему</h2>
      
      <form @submit.prevent="handleLogin" class="login-form">
        <div class="form-group">
          <label for="email" class="form-label">Email</label>
          <input
            id="email"
            v-model="form.email"
            type="email"
            class="form-input"
            :class="{ 'input-error': errors.email }"
            placeholder="Введіть ваш email"
            required
          />
          <span v-if="errors.email" class="error-message">{{ errors.email[0] }}</span>
        </div>

        <div class="form-group">
          <label for="password" class="form-label">Пароль</label>
          <input
            id="password"
            v-model="form.password"
            type="password"
            class="form-input"
            :class="{ 'input-error': errors.password }"
            placeholder="Введіть ваш пароль"
            required
          />
          <span v-if="errors.password" class="error-message">{{ errors.password[0] }}</span>
        </div>

        <button type="submit" class="login-button" >Войти</button>
        <div v-if="errors.general" class="general-error">
          {{ errors.general[0] }}
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import { reactive } from 'vue';
import { useAuth } from '../../store/auth';

export default {
    setup() {
        const { login, errors} = useAuth();
        const form = reactive({
            email: '',
            password: '',
        });

        const handleLogin = async () => {
            try {
                await login(form);
            } catch (error) {
                console.error('Login failed:', error);
            }
        };

        return {
            form,
            errors,
            handleLogin,
        };
    },
};
</script>

<style scoped>
.login-container {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
  background-color: #f5f7fa;
  padding: 20px;
}

.login-card {
  background: white;
  border-radius: 12px;
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
  width: 100%;
  max-width: 420px;
  padding: 32px;
}

.login-title {
  color: #2c3e50;
  font-size: 24px;
  font-weight: 600;
  margin-bottom: 24px;
  text-align: center;
}

.login-form {
  display: flex;
  flex-direction: column;
  gap: 16px;
}

.form-group {
  display: flex;
  flex-direction: column;
  gap: 6px;
}

.form-label {
  font-size: 14px;
  color: #4a5568;
  font-weight: 500;
}

.form-input {
  padding: 12px 16px;
  border: 1px solid #e2e8f0;
  border-radius: 8px;
  font-size: 14px;
  transition: all 0.2s ease;
}

.form-input:focus {
  outline: none;
  border-color: #4299e1;
  box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.2);
}

.input-error {
  border-color: #fc8181;
}

.input-error:focus {
  border-color: #fc8181;
  box-shadow: 0 0 0 3px rgba(252, 129, 129, 0.2);
}

.error-message {
  color: #e53e3e;
  font-size: 12px;
  margin-top: 2px;
}

.form-options {
  display: flex;
  justify-content: space-between;
  align-items: center;
  font-size: 13px;
}

.remember-me {
  display: flex;
  align-items: center;
  gap: 6px;
  color: #4a5568;
  cursor: pointer;
}

.remember-me input {
  cursor: pointer;
}

.forgot-password {
  color: #4299e1;
  text-decoration: none;
  transition: color 0.2s;
}

.forgot-password:hover {
  color: #3182ce;
  text-decoration: underline;
}

.login-button {
  background-color: #4299e1;
  color: white;
  border: none;
  border-radius: 8px;
  padding: 12px;
  font-size: 15px;
  font-weight: 500;
  cursor: pointer;
  transition: background-color 0.2s;
  margin-top: 8px;
}

.login-button:hover {
  background-color: #3182ce;
}

.login-button:disabled {
  background-color: #bee3f8;
  cursor: not-allowed;
}

.loading {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
}

.loading::after {
  content: '';
  display: inline-block;
  width: 12px;
  height: 12px;
  border: 2px solid rgba(255, 255, 255, 0.3);
  border-radius: 50%;
  border-top-color: white;
  animation: spin 1s ease-in-out infinite;
}

@keyframes spin {
  to { transform: rotate(360deg); }
}

.general-error {
  color: #e53e3e;
  font-size: 13px;
  text-align: center;
  padding: 8px;
  background-color: #fff5f5;
  border-radius: 6px;
  margin-top: 8px;
}

.register-link {
  text-align: center;
  margin-top: 24px;
  font-size: 14px;
  color: #4a5568;
}

.register-link a {
  color: #4299e1;
  text-decoration: none;
}

.register-link a:hover {
  text-decoration: underline;
}
</style>