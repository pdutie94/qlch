<script setup lang="ts">
import SectionCard from '../components/SectionCard.vue'
import { customers } from '../data/mock'
</script>

<template>
  <div class="space-y-4">
    <SectionCard title="Customer debt ledger" subtitle="Track purchase history and debt settlement.">
      <div class="space-y-3">
        <article v-for="customer in customers" :key="customer.name" class="rounded-3xl border border-slate-100 px-4 py-4">
          <div class="flex items-start justify-between gap-3">
            <div>
              <p class="font-semibold text-slate-900">{{ customer.name }}</p>
              <p class="mt-1 text-sm text-slate-500">{{ customer.purchases }} orders</p>
            </div>
            <div class="text-right">
              <p class="text-sm text-slate-500">Debt</p>
              <p class="font-semibold text-slate-900">{{ customer.debt }}</p>
            </div>
          </div>
        </article>
      </div>
    </SectionCard>
  </div>
</template>
