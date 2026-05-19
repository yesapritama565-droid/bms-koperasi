import { createRouter, createWebHistory } from 'vue-router'

import LoginView from '../pages/Login.vue'
import Register from '../pages/Register.vue'
import AdminDashboard from "../pages/Dashboard-Admin.vue"
import UserDashboard from "../pages/Dashboard-user.vue"

const routes = [
  {
    path: '/',
    name: 'login',
    component: LoginView,
  },
  {
    path: '/login',
    name: 'login-alt',
    component: LoginView,
  },
  {
    path: '/register',
    name: 'register',
    component: Register,
  },
  {
    path: '/Dashboard-Admin',
    name: 'admin-dashboard',
    component: AdminDashboard,
  },
  {
    path: '/Dashboard-User',
    name: 'user-dashboard',
    component: UserDashboard,
  },
]

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes,
})

export default router