<script setup lang="ts">
import { useRouter } from 'vue-router'
import SectionCard from '../components/SectionCard.vue'
import StatusChip from '../components/StatusChip.vue'
import { moduleStates } from '../data/mock'
import { useAuthStore } from '../stores/auth'

const router = useRouter()
const authStore = useAuthStore()

function signOut() {
  authStore.signOut()
  router.push('/login')
}
</script>

<template>
  <div class="space-y-4">
    <SectionCard title="Current rollout" subtitle="Foundations already seeded in this repo.">
      <div class="space-y-3">
        <article v-for="module in moduleStates" :key="module.key" class="flex items-center justify-between rounded-3xl border border-slate-100 px-4 py-3">
          <p class="font-semibold text-slate-900">{{ module.label }}</p>
          <StatusChip :label="module.status" />
        </article>
      </div>
    </SectionCard>

    <SectionCard title="Session" subtitle="Local persistence via Pinia and localStorage.">
      <div class="rounded-3xl bg-slate-50 p-4 text-sm text-slate-600">
        <p><span class="font-semibold text-slate-900">User:</span> {{ authStore.session?.name }}</p>
        <p class="mt-2"><span class="font-semibold text-slate-900">Role:</span> {{ authStore.session?.role }}</p>
      </div>
      <button class="mt-4 w-full rounded-2xl border border-slate-200 px-4 py-3 font-semibold text-slate-700" @click="signOut">
        Sign out
      </button>
    </SectionCard>
  </div>
</template>