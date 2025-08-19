<template>
    <Teleport to="body">
        <div
            v-if="showSuccessToast"
            class="fixed top-8 right-8 z-50 transform transition-all duration-300 ease-out"
            :class="{
                'translate-x-0 opacity-100': showSuccessToast,
                'translate-x-full opacity-0': !showSuccessToast,
            }"
        >
            <div class="bg-white border border-coklat shadow-lg p-6 max-w-sm">
                <div class="flex items-start">
                    <div class="flex-shrink-0 mr-4">
                        <div
                            class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center"
                        >
                            <svg
                                class="w-5 h-5 text-green-600"
                                fill="currentColor"
                                viewBox="0 0 20 20"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1">
                        <h4 class="font-medium text-stone-800 mb-1">
                            {{ title }}
                        </h4>
                        <p class="text-sm text-stone-600">
                            {{ message }}
                        </p>
                    </div>
                    <button
                        @click="$emit('close')"
                        class="ml-4 text-stone-400 hover:text-stone-600 transition-colors duration-200"
                    >
                        <svg
                            class="w-4 h-4"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"
                            />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </Teleport>
</template>

<script setup lang="ts">
const props = defineProps<{
    title: string;
    message: string;
    showSuccessToast: boolean;
}>();

const emit = defineEmits(["close"]);
</script>
