import { createApp } from 'vue'
import { createRouter, createWebHistory } from 'vue-router'
import App from './App.vue'

import routes from './routes'

const app = createApp(App)

const router = createRouter({
  history: createWebHistory(),
  routes,
})

router.beforeEach((to, from, next) => {
  const isAuthenticated = !!localStorage.getItem('auth_token') 

  if (to.meta.requiresAuth && !isAuthenticated) {
    next('auth/login') 
  } else {
    next() 
  }
})

app.use(router)
app.mount('#app')
