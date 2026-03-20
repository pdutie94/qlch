<script setup lang="ts">
import { reportCards } from '../data/mock'
import SectionCard from '../components/SectionCard.vue'
</script>

<template>
  <div class="space-y-4">
    <SectionCard title="Report cache" subtitle="Prepare APCu or file-backed aggregate snapshots from the API.">
      <div class="space-y-3">
        <article v-for="card in reportCards" :key="card.title" class="rounded-3xl border border-slate-100 bg-slate-50 px-4 py-4">
          <div class="flex items-start justify-between gap-3">
            <div>
              <p class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-500">{{ card.title }}</p>
              <p class="app-title mt-3 text-3xl font-bold text-slate-900">{{ card.value }}</p>
            </div>
            <div class="rounded-2xl bg-white px-3 py-2 text-xs font-semibold text-teal-700">Cached</div>
          </div>
          <p class="mt-3 text-sm text-slate-500">{{ card.note }}</p>
        </article>
      </div>
    </SectionCard>
  </div>
</template>
