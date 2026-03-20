<script setup lang="ts">
withDefaults(
  defineProps<{
    title: string
    subtitle?: string
  }>(),
  {
    subtitle: undefined,
  },
)
</script>

<template>
  <section class="surface-card p-5">
    <div class="mb-4 flex items-start justify-between gap-3">
      <div>
        <h2 class="text-base font-semibold text-slate-900">{{ title }}</h2>
        <p v-if="subtitle" class="mt-1 text-sm text-slate-500">{{ subtitle }}</p>
      </div>
      <slot name="action" />
    </div>
    <slot />
  </section>
</template>
