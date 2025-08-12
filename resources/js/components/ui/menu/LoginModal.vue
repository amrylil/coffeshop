<!-- components/LoginModal.vue -->
<template>
  <Transition
    name="modal"
    enter-active-class="transition-opacity duration-300"
    leave-active-class="transition-opacity duration-300"
    enter-from-class="opacity-0"
    enter-to-class="opacity-100"
    leave-from-class="opacity-100"
    leave-to-class="opacity-0"
  >
    <div
      v-if="isVisible"
      class="fixed inset-0 bg-black bg-opacity-50 z-50"
      @click="handleBackdropClick"
    >
      <div class="flex items-center justify-center min-h-screen">
        <Transition
          name="modal-content"
          enter-active-class="transition-all duration-300"
          leave-active-class="transition-all duration-300"
          enter-from-class="transform scale-75 opacity-0"
          enter-to-class="transform scale-100 opacity-100"
          leave-from-class="transform scale-100 opacity-100"
          leave-to-class="transform scale-75 opacity-0"
        >
          <div
            v-if="isVisible"
            class="bg-white rounded-lg p-8 max-w-md w-full mx-4"
            @click.stop
          >
            <h3 class="text-xl font-semibold mb-4 text-[#3e1f1f]">Login Required</h3>
            <p class="text-gray-600 mb-6">You need to login to add items to your cart.</p>
            <div class="flex gap-4">
              <button
                @click="handleLogin"
                class="bg-[#3e1f1f] text-white px-4 py-2 rounded hover:bg-[#5a2d2d] transition"
              >
                Login
              </button>
              <button
                @click="handleCancel"
                class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400 transition"
              >
                Cancel
              </button>
            </div>
          </div>
        </Transition>
      </div>
    </div>
  </Transition>
</template>

<script setup lang="ts">
interface Props {
  isVisible: boolean;
}

interface Emits {
  (e: 'close'): void;
  (e: 'login'): void;
}

defineProps<Props>();
const emit = defineEmits<Emits>();

const handleBackdropClick = () => {
  emit('close');
};

const handleCancel = () => {
  emit('close');
};

const handleLogin = () => {
  emit('login');
};
</script>