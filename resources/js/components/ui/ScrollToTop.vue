<!-- components/ScrollToTop.vue -->
<template>
  <Transition
    name="scroll-button"
    enter-active-class="transition-all duration-300"
    leave-active-class="transition-all duration-300"
    enter-from-class="opacity-0 transform translate-y-5"
    enter-to-class="opacity-100 transform translate-y-0"
    leave-from-class="opacity-100 transform translate-y-0"
    leave-to-class="opacity-0 transform translate-y-5"
  >
    <button
      v-if="isVisible"
      @click="scrollToTop"
      class="fixed bottom-6 right-6 bg-[#3e1f1f] text-white p-3 rounded-full shadow-lg hover:bg-[#5a2d2d] transition-colors duration-300"
    >
      <svg 
        xmlns="http://www.w3.org/2000/svg" 
        class="h-6 w-6" 
        fill="none" 
        viewBox="0 0 24 24"
        stroke="currentColor"
      >
        <path 
          stroke-linecap="round" 
          stroke-linejoin="round" 
          stroke-width="2" 
          d="M5 15l7-7 7 7" 
        />
      </svg>
    </button>
  </Transition>
</template>

<script setup lang="ts">
interface Props {
  isVisible: boolean;
}

interface Emits {
  (e: 'scroll-to-top'): void;
}

defineProps<Props>();
const emit = defineEmits<Emits>();

const scrollToTop = () => {
  emit('scroll-to-top');
};
</script>

<style scoped>
/* Scroll to Top Button Animation */
.scroll-button-enter-active,
.scroll-button-leave-active {
  transition: all 0.3s ease;
}

.scroll-button-enter-from {
  opacity: 0;
  transform: translateY(20px);
}

.scroll-button-leave-to {
  opacity: 0;
  transform: translateY(20px);
}
</style>