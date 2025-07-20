import { createRouter, createWebHistory } from 'vue-router'
import UserLayout from './layouts/UserLayout.vue'
import AuthLayout from './layouts/AuthLayout.vue'

import Home from './pages/Home.vue'
import About from './pages/About.vue'
import Login from './components/auth/Login.vue'
import IntakeMeat from './pages/IntakeMeat.vue'
import MeatIntakeItem from './pages/MeatIntakeItem.vue'
import StoreMeatCutOutput from './pages/StoreMeatCutOutput.vue'
import EditMeatCutOutput from './pages/EditMeatCutOutput.vue'

export default [
  {
    path: '/',
    component: UserLayout,
    children: [
      { 
        path: '',
        component: Home,
        meta:{requiresAuth: true}
       },
      { 
        path: 'intake_meat',
        component: IntakeMeat,
        meta:{requiresAuth: true}
       },
       { 
        path: 'intake_meat/:id',
        component: MeatIntakeItem,
        meta:{requiresAuth: true}
       },
       { 
        path: 'meat_cut_output/:id/store',
        component: StoreMeatCutOutput,
        meta:{requiresAuth: true}
       },
       { 
        path: 'meat_cut_output/:id/edit',
        component: EditMeatCutOutput,
        meta:{requiresAuth: true}
       },
    ],
  },
  {
    path: '/about',
    component: AuthLayout,
    children: [
      { path: 'new', component: About },
    ],
  },
  {
    path: '/auth',
    component: AuthLayout,
    children: [
      { path: 'login', component: Login },
    ],
  },
  
]
