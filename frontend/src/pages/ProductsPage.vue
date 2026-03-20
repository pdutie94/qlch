<script setup lang="ts">
import SectionCard from '../components/SectionCard.vue'
import { products } from '../data/mock'
</script>

<template>
  <div class="space-y-4">
    <SectionCard title="Product catalog" subtitle="Categories, units, and inventory levels at a glance.">
      <div class="space-y-3">
        <article v-for="product in products" :key="product.name" class="rounded-3xl border border-slate-100 px-4 py-4">
          <div class="flex items-start justify-between gap-3">
            <div>
              <p class="font-semibold text-slate-900">{{ product.name }}</p>
              <p class="mt-1 text-sm text-slate-500">{{ product.category }} • {{ product.unit }}</p>
            </div>
            <div class="rounded-2xl px-3 py-2 text-sm font-semibold" :class="product.stock < 10 ? 'bg-rose-50 text-rose-700' : 'bg-slate-100 text-slate-700'">
              {{ product.stock }} in stock
            </div>
          </div>
        </article>
      </div>
    </SectionCard>
  </div>
</template>
