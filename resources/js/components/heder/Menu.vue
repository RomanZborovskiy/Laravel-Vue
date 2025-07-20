<template>
  <n-layout-header bordered class="header">
    <div class="header-content">
      <div class="logo">
        <n-image
          width="120"
          src="/logo.png"
          alt="Логотип"
        />
      </div>

      <n-menu
        mode="horizontal"
        :options="menuOptions"
        class="menu"
      />

      <div class="auth-buttons">
        <n-button quaternary @click="handleLogout">
          Вийти
        </n-button>
        <n-button type="primary" @click="handleRegister">
          Регистрация
        </n-button>
      </div>
    </div>
  </n-layout-header>
</template>

<script setup>
import { NLayoutHeader, NMenu, NButton, NImage } from 'naive-ui';
import { reactive } from 'vue';
import { useAuth } from '../../store/auth';


        const { logout, errors } = useAuth();
        const form = reactive({
            email: '',
            password: '',
        });

        const handleLogout = async () => {
          try {
            await logout();
          } catch(error) {
            console.error('Login failed:', error);
          }
        };


const menuOptions = [
  {
    label: "Главная",
    key: "home",
  },
  {
    label: "О нас",
    key: "about",
  },
  {
    label: "Контакты",
    key: "contacts",
  },
];


const handleRegister = () => {
  console.log("Клик по кнопке Регистрация");
  
};
</script>

<style scoped>
.header {
  padding: 0 20px;
  height: 60px;
  display: flex;
  align-items: center;
}

.header-content {
  width: 100%;
  max-width: 1200px;
  margin: 0 auto;
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.logo {
  margin-right: 30px;
}

.menu {
  flex: 1;
}

.auth-buttons {
  display: flex;
  gap: 10px;
  margin-left: auto;
}
</style>