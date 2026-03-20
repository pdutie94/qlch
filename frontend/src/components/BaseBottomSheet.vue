<script setup lang="ts">
const props = withDefaults(
  defineProps<{
    modelValue: boolean
    title: string
    description?: string
  }>(),
  {
    description: undefined,
  },
)

const emit = defineEmits<{
  'update:modelValue': [value: boolean]
}>()

function close() {
  emit('update:modelValue', false)
}
</script>

<template>
  <Transition name="page-fade">
    <div v-if="props.modelValue" class="fixed inset-0 z-50 flex items-end bg-slate-900/30" @click.self="close">
      <div class="w-full rounded-t-[2rem] border border-slate-100 bg-white px-5 pb-[max(1.5rem,env(safe-area-inset-bottom))] pt-4">
        <div class="mx-auto mb-4 h-1.5 w-14 rounded-full bg-slate-200"></div>
        <div class="mb-4 flex items-start justify-between gap-3">
          <div>
            <h3 class="text-lg font-semibold text-slate-900">{{ props.title }}</h3>
            <p v-if="props.description" class="mt-1 text-sm text-slate-500">{{ props.description }}</p>
          </div>
          <button class="rounded-full border border-slate-200 px-3 py-2 text-sm font-semibold text-slate-600" @click="close">
            Close
          </button>
        </div>
        <slot />
      </div>
    </div>
  </Transition>
</template>
