import { createRouter, createWebHistory } from 'vue-router'
import { pinia } from '../app/pinia'
import AppShell from '../layouts/AppShell.vue'
import LoginPage from '../pages/LoginPage.vue'
import DashboardPage from '../pages/DashboardPage.vue'
import PosPage from '../pages/PosPage.vue'
import OrdersPage from '../pages/OrdersPage.vue'
import ProductsPage from '../pages/ProductsPage.vue'
import CustomersPage from '../pages/CustomersPage.vue'
import ReportsPage from '../pages/ReportsPage.vue'
import SettingsPage from '../pages/SettingsPage.vue'
import { useAuthStore } from '../stores/auth'

export const router = createRouter({
  history: createWebHistory(),
  routes: [
    {
      path: '/login',
      name: 'login',
      component: LoginPage,
      meta: { guestOnly: true },
    },
    {
      path: '/',
      component: AppShell,
      meta: { requiresAuth: true },
      children: [
        { path: '', name: 'dashboard', component: DashboardPage },
        { path: 'pos', name: 'pos', component: PosPage },
        { path: 'orders', name: 'orders', component: OrdersPage },
        { path: 'products', name: 'products', component: ProductsPage },
        { path: 'customers', name: 'customers', component: CustomersPage },
        { path: 'reports', name: 'reports', component: ReportsPage },
        { path: 'settings', name: 'settings', component: SettingsPage },
      ],
    },
  ],
  scrollBehavior() {
    return { top: 0 }
  },
})

router.beforeEach((to) => {
  const authStore = useAuthStore(pinia)

  if (to.meta.requiresAuth && !authStore.isAuthenticated) {
    return { name: 'login' }
  }

  if (to.meta.guestOnly && authStore.isAuthenticated) {
    return { name: 'dashboard' }
  }

  return true
})
