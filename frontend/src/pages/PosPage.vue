<script setup lang="ts">
import { computed, ref } from 'vue'
import BaseBottomSheet from '../components/BaseBottomSheet.vue'
import SectionCard from '../components/SectionCard.vue'
import { cartItems } from '../data/mock'

const isCheckoutOpen = ref(false)
const paymentMethod = ref('cash')
const cashReceived = ref('200000')

const total = computed(() => cartItems.reduce((sum, item) => sum + item.qty * item.price, 0))
const cashChange = computed(() => Math.max(Number(cashReceived.value || 0) - total.value, 0))

function formatCurrency(value: number) {
  return new Intl.NumberFormat('en-US').format(value)
}
</script>

<template>
  <div class="space-y-4">
    <SectionCard title="Current cart" subtitle="Designed for one-hand checkout on mobile.">
      <div class="space-y-3">
        <article v-for="item in cartItems" :key="item.id" class="flex items-center justify-between rounded-3xl bg-slate-50 px-4 py-3">
          <div>
            <p class="font-semibold text-slate-900">{{ item.name }}</p>
            <p class="mt-1 text-sm text-slate-500">{{ item.qty }} x {{ formatCurrency(item.price) }}</p>
          </div>
          <p class="font-semibold text-slate-900">{{ formatCurrency(item.qty * item.price) }}</p>
        </article>
      </div>
      <div class="mt-4 rounded-3xl bg-slate-900 px-4 py-4 text-white">
        <div class="flex items-center justify-between text-sm text-slate-300">
          <span>Customer</span>
          <span>Walk-in / Retail</span>
        </div>
        <div class="mt-2 flex items-center justify-between">
          <span class="text-sm font-medium text-slate-300">Grand total</span>
          <span class="app-title text-2xl font-bold">{{ formatCurrency(total) }}</span>
        </div>
      </div>
      <button class="mt-4 w-full rounded-2xl bg-teal-700 px-4 py-3 font-semibold text-white" @click="isCheckoutOpen = true">
        Quick checkout
      </button>
    </SectionCard>

    <SectionCard title="Payment lanes" subtitle="Fast switch between payment methods and debt record.">
      <div class="grid grid-cols-3 gap-3 text-sm font-semibold">
        <button class="rounded-2xl border border-slate-200 px-3 py-3 text-slate-700">Cash</button>
        <button class="rounded-2xl border border-slate-200 px-3 py-3 text-slate-700">Bank QR</button>
        <button class="rounded-2xl border border-slate-200 px-3 py-3 text-slate-700">Debt note</button>
      </div>
    </SectionCard>

    <BaseBottomSheet v-model="isCheckoutOpen" title="Checkout summary" description="Use bottom sheet for one-step payment confirmation.">
      <div class="space-y-4">
        <div class="grid grid-cols-3 gap-2">
          <button
            v-for="method in ['cash', 'bank', 'debt']"
            :key="method"
            class="rounded-2xl border px-3 py-3 text-sm font-semibold capitalize"
            :class="paymentMethod === method ? 'border-teal-700 bg-teal-50 text-teal-700' : 'border-slate-200 text-slate-600'"
            @click="paymentMethod = method"
          >
            {{ method }}
          </button>
        </div>

        <label class="block">
          <span class="mb-2 block text-sm font-semibold text-slate-700">Cash received</span>
          <input
            v-model="cashReceived"
            inputmode="decimal"
            class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 outline-none focus:border-teal-500"
            placeholder="200000"
          />
        </label>

        <div class="rounded-3xl bg-slate-50 p-4 text-sm text-slate-600">
          <div class="flex items-center justify-between">
            <span>Total due</span>
            <span class="font-semibold text-slate-900">{{ formatCurrency(total) }}</span>
          </div>
          <div class="mt-2 flex items-center justify-between">
            <span>Change</span>
            <span class="font-semibold text-slate-900">{{ formatCurrency(cashChange) }}</span>
          </div>
        </div>

        <button class="w-full rounded-2xl bg-slate-900 px-4 py-3 font-semibold text-white" @click="isCheckoutOpen = false">
          Confirm payment
        </button>
      </div>
    </BaseBottomSheet>
  </div>
</template>
