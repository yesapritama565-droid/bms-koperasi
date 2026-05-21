import { createRouter, createWebHistory } from 'vue-router'

import LoginView from '../pages/Login.vue'
import Register from '../pages/Register.vue'
import AdminDashboard from "../pages/Dashboard-Admin.vue"
import UserDashboard from "../pages/Dashboard-User.vue"
import KanbanBoard from "../pages/KanbanBoard.vue"
import DailyActivity from "../pages/DailyActivity.vue";

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
  {
    path: "/tasks/:id",
    name: "task-detail",
    component: () => import("../pages/TaskDetail.vue"),
  },
  {
    path: "/kanban",
    name: "kanban",
    component: KanbanBoard,
  },
  {
    path: "/daily-activity",
    name: "daily-activity",
    component: () => import("../pages/DailyActivity.vue"),
  },
]

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes,
})

export default router