<script setup lang="ts">
defineProps<{
  label: string
}>()

function chipClass(label: string) {
  if (label === 'Paid' || label === 'foundation ready') {
    return 'bg-teal-50 text-teal-700'
  }

  if (label === 'Debt' || label === 'next' || label === 'ui seeded') {
    return 'bg-amber-50 text-amber-700'
  }

  if (label === 'Packing' || label === 'planned') {
    return 'bg-slate-100 text-slate-700'
  }

  return 'bg-rose-50 text-rose-700'
}
</script>

<template>
  <span class="rounded-full px-2.5 py-1 text-xs font-semibold" :class="chipClass(label)">
    {{ label }}
  </span>
</template>
