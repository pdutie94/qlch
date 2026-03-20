<script setup lang="ts">
import SectionCard from '../components/SectionCard.vue'
import StatusChip from '../components/StatusChip.vue'
import { orders } from '../data/mock'
</script>

<template>
  <div class="space-y-4">
    <SectionCard title="Order queue" subtitle="Filterable list for status management and debt follow-up.">
      <div class="mb-4 flex gap-2 overflow-x-auto pb-1 text-sm font-semibold text-slate-600">
        <button class="rounded-full bg-slate-900 px-4 py-2 text-white">All</button>
        <button class="rounded-full border border-slate-200 px-4 py-2">Paid</button>
        <button class="rounded-full border border-slate-200 px-4 py-2">Debt</button>
        <button class="rounded-full border border-slate-200 px-4 py-2">Deleted</button>
      </div>

      <div class="space-y-3">
        <article v-for="order in orders" :key="order.id" class="rounded-3xl border border-slate-100 px-4 py-4">
          <div class="flex items-start justify-between gap-3">
            <div>
              <p class="font-semibold text-slate-900">{{ order.id }}</p>
              <p class="mt-1 text-sm text-slate-500">{{ order.customer }} • {{ order.time }}</p>
            </div>
            <StatusChip :label="order.status" />
          </div>
          <p class="mt-3 text-lg font-semibold text-slate-900">{{ order.total }}</p>
        </article>
      </div>
    </SectionCard>
  </div>
</template>
