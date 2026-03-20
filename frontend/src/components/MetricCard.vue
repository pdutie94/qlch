<script setup lang="ts">
const props = defineProps<{
  label: string
  value: string
  delta: string
  tone: 'teal' | 'amber' | 'slate' | 'rose'
}>()

const toneClasses = {
  teal: 'bg-teal-50 text-teal-700',
  amber: 'bg-amber-50 text-amber-700',
  slate: 'bg-slate-100 text-slate-700',
  rose: 'bg-rose-50 text-rose-700',
}
</script>

<template>
  <article class="surface-card p-4">
    <div class="mb-5 flex items-center justify-between gap-3">
      <p class="text-sm font-medium text-slate-500">{{ props.label }}</p>
      <span class="rounded-full px-2.5 py-1 text-xs font-semibold" :class="toneClasses[props.tone]">
        {{ props.delta }}
      </span>
    </div>
    <p class="metric-value">{{ props.value }}</p>
  </article>
</template>
