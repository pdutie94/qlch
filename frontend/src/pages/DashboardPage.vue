<script setup lang="ts">
import { ArrowRight, ChevronRight } from 'lucide-vue-next'
import { RouterLink } from 'vue-router'
import MetricCard from '../components/MetricCard.vue'
import SectionCard from '../components/SectionCard.vue'
import { dashboardMetrics, lowStockItems, quickActions } from '../data/mock'
</script>

<template>
  <div class="space-y-4">
    <section class="grid grid-cols-2 gap-3">
      <MetricCard
        v-for="metric in dashboardMetrics"
        :key="metric.label"
        :label="metric.label"
        :value="metric.value"
        :delta="metric.delta"
        :tone="metric.tone"
      />
    </section>

    <SectionCard title="Quick actions" subtitle="High-frequency paths for store operators.">
      <div class="grid grid-cols-2 gap-3">
        <RouterLink
          v-for="action in quickActions"
          :key="action.label"
          :to="action.to"
          class="rounded-3xl border border-slate-100 bg-slate-50 px-4 py-4 transition hover:border-teal-200 hover:bg-teal-50"
        >
          <div class="flex items-start justify-between gap-3">
            <div>
              <p class="font-semibold text-slate-900">{{ action.label }}</p>
              <p class="mt-1 text-sm text-slate-500">{{ action.hint }}</p>
            </div>
            <ArrowRight class="h-5 w-5 text-teal-700" />
          </div>
        </RouterLink>
      </div>
    </SectionCard>

    <SectionCard title="Low-stock alerts" subtitle="Prioritize inbound purchase or stock transfer.">
      <div class="space-y-3">
        <article v-for="item in lowStockItems" :key="item.sku" class="flex items-center justify-between rounded-3xl border border-slate-100 px-4 py-3">
          <div>
            <p class="font-semibold text-slate-900">{{ item.name }}</p>
            <p class="mt-1 text-sm text-slate-500">{{ item.sku }}</p>
          </div>
          <div class="text-right">
            <p class="text-sm font-semibold text-rose-600">{{ item.stock }} left</p>
            <RouterLink to="/products" class="mt-1 inline-flex items-center gap-1 text-sm font-semibold text-teal-700">
              Review
              <ChevronRight class="h-4 w-4" />
            </RouterLink>
          </div>
        </article>
      </div>
    </SectionCard>
  </div>
</template>
