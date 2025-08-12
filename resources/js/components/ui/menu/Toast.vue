<!-- components/Toast.vue -->
<template>
  <Transition
    name="toast"
    enter-active-class="transition-all duration-300"
    leave-active-class="transition-all duration-300"
    enter-from-class="transform -translate-x-1/2 -translate-y-full opacity-0"
    enter-to-class="transform -translate-x-1/2 translate-y-0 opacity-100"
    leave-from-class="transform -translate-x-1/2 translate-y-0 opacity-100"
    leave-to-class="transform -translate-x-1/2 -translate-y-full opacity-0"
  >
    <div
      v-if="isVisible"
      :class="[
        'fixed top-4 left-1/2 transform -translate-x-1/2 px-6 py-3 rounded-lg shadow-lg z-50',
        type === 'success' ? 'bg-green-500' : 'bg-red-500',
        'text-white'
      ]"
    >
      <div class="flex items-center">
        <svg 
          v-if="type === 'success'"
          class="w-5 h-5 mr-2" 
          fill="none" 
          stroke="currentColor" 
          viewBox="0 0 24 24"
        >
          <path 
            stroke-linecap="round" 
            stroke-linejoin="round" 
            stroke-width="2" 
            d="M5 13l4 4L19 7"
          ></path>
        </svg>
        <svg 
          v-else
          class="w-5 h-5 mr-2" 
          fill="none" 
          stroke="currentColor" 
          viewBox="0 0 24 24"
        >
          <path 
            stroke-linecap="round" 
            stroke-linejoin="round" 
            stroke-width="2" 
            d="M6 18L18 6M6 6l12 12"
          ></path>
        </svg>
        <span>{{ message }}</span>
      </div>
    </div>
  </Transition>
</template>

<script setup lang="ts">
import type { ToastType } from '@/types/menu';

interface Props {
  isVisible: boolean;
  message: string;
  type: ToastType;
}

defineProps<Props>();
</script>

<style scoped>
/* Toast Animation */
@keyframes slideInDown {
  from {
    transform: translate(-50%, -100%);
    opacity: 0;
  }
  to {
    transform: translate(-50%, 0);
    opacity: 1;
  }
}

.toast-enter-active {
  animation: slideInDown 0.3s ease-out;
}
</style>