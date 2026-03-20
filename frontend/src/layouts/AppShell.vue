<script setup lang="ts">
import { computed } from 'vue'
import { RouterLink, RouterView, useRoute } from 'vue-router'
import { BarChart3, Boxes, LayoutDashboard, ReceiptText, Settings2, ShoppingCart } from 'lucide-vue-next'
import { useAuthStore } from '../stores/auth'
import type { NavigationItem } from '../types/navigation'

const route = useRoute()
const authStore = useAuthStore()

const navigation = computed<NavigationItem[]>(() => [
  { label: 'Home', to: '/', icon: LayoutDashboard },
  { label: 'POS', to: '/pos', icon: ShoppingCart },
  { label: 'Orders', to: '/orders', icon: ReceiptText },
  { label: 'Products', to: '/products', icon: Boxes },
  { label: 'Reports', to: '/reports', icon: BarChart3 },
  { label: 'Settings', to: '/settings', icon: Settings2 },
])

const pageTitle = computed(() => {
  const titles: Record<string, string> = {
    dashboard: 'Store pulse',
    pos: 'Quick checkout',
    orders: 'Orders timeline',
    products: 'Stock watch',
    customers: 'Customer debt',
    reports: 'Revenue reports',
    settings: 'Workspace settings',
  }

  return titles[String(route.name)] ?? 'QLCH Admin'
})
</script>

<template>
  <div class="mx-auto min-h-screen max-w-md px-4 pb-28 pt-4 text-slate-800 sm:max-w-3xl sm:px-6">
    <header class="surface-panel mb-4 overflow-hidden p-5">
      <div class="mb-6 flex items-center justify-between gap-3">
        <div>
          <p class="text-xs font-semibold uppercase tracking-[0.32em] text-teal-700">QLCH admin</p>
          <h1 class="app-title mt-2 text-2xl font-bold text-slate-900">{{ pageTitle }}</h1>
        </div>
        <div class="rounded-2xl bg-slate-900 px-3 py-2 text-right text-white">
          <p class="text-xs uppercase tracking-[0.25em] text-slate-300">Role</p>
          <p class="mt-1 text-sm font-semibold">{{ authStore.session?.role ?? 'staff' }}</p>
        </div>
      </div>

      <div class="rounded-[1.75rem] bg-gradient-to-r from-slate-950 via-teal-900 to-cyan-800 p-5 text-white">
        <p class="text-sm text-slate-200">{{ authStore.session?.name }}</p>
        <p class="mt-2 max-w-xs text-lg font-semibold">Monitor sales, stock pressure, and debt without leaving the mobile flow.</p>
      </div>
    </header>

    <main>
      <RouterView v-slot="{ Component }">
        <Transition name="page-fade" mode="out-in">
          <component :is="Component" />
        </Transition>
      </RouterView>
    </main>

    <nav class="fixed bottom-3 left-1/2 z-40 w-[calc(100%-1.5rem)] max-w-md -translate-x-1/2 rounded-[2rem] border border-slate-100 bg-white/95 px-2 py-2 backdrop-blur sm:max-w-3xl">
      <ul class="grid grid-cols-6 gap-1">
        <li v-for="item in navigation" :key="item.to">
          <RouterLink
            :to="item.to"
            class="flex flex-col items-center justify-center rounded-2xl px-1 py-2 text-[11px] font-semibold transition"
            :class="route.path === item.to ? 'bg-slate-900 text-white' : 'text-slate-500'"
          >
            <component :is="item.icon" class="mb-1 h-5 w-5" />
            {{ item.label }}
          </RouterLink>
        </li>
      </ul>
    </nav>
  </div>
</template>
