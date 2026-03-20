<script setup lang="ts">
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore, type UserRole } from '../stores/auth'

const router = useRouter()
const authStore = useAuthStore()
const fullName = ref('Store Admin')
const role = ref<UserRole>('admin')

function submit() {
  authStore.signIn(fullName.value, role.value)
  router.push('/')
}
</script>

<template>
  <div class="mx-auto flex min-h-screen max-w-md items-center px-4 py-8">
    <section class="surface-panel w-full overflow-hidden p-6">
      <div class="rounded-[1.75rem] bg-gradient-to-br from-slate-950 via-teal-900 to-cyan-700 p-5 text-white">
        <p class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-300">Internal admin</p>
        <h1 class="app-title mt-3 text-3xl font-bold">QLCH</h1>
        <p class="mt-3 text-sm leading-6 text-slate-200">Mobile-first control panel for sales, stock, debt, and store operations.</p>
      </div>

      <form class="mt-6 space-y-4" @submit.prevent="submit">
        <label class="block">
          <span class="mb-2 block text-sm font-semibold text-slate-700">Display name</span>
          <input v-model="fullName" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 outline-none transition focus:border-teal-500" placeholder="Store Admin" />
        </label>

        <label class="block">
          <span class="mb-2 block text-sm font-semibold text-slate-700">Access role</span>
          <select v-model="role" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 outline-none transition focus:border-teal-500">
            <option value="admin">Admin</option>
            <option value="staff">Staff</option>
          </select>
        </label>

        <button class="w-full rounded-2xl bg-slate-900 px-4 py-3 font-semibold text-white transition hover:bg-slate-800" type="submit">
          Continue to workspace
        </button>
      </form>
    </section>
  </div>
</template>
