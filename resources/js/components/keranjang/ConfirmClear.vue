<template>
    <Teleport to="body">
        <div
            v-if="show"
            class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50 p-4"
            @click="$emit('cancel')"
        >
            <div
                class="bg-white shadow-xl border border-coklat max-w-md w-full p-8"
                @click.stop
            >
                <!-- Icon -->
                <div class="text-center mb-6">
                    <div
                        class="w-16 h-16 mx-auto mb-4 bg-stone-100 rounded-full flex items-center justify-center"
                    >
                        <slot name="icon">
                            <!-- default icon -->
                            <svg
                                class="w-8 h-8 text-stone-600"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"
                                />
                            </svg>
                        </slot>
                    </div>
                    <h3 class="text-xl text-stone-800 mb-2">
                        {{ title }}
                    </h3>
                    <p class="text-stone-600 mb-4">
                        {{ message }}
                    </p>
                </div>

                <div
                    v-if="itemCount"
                    class="bg-stone-50 p-4 mb-6 border border-coklat"
                >
                    <p class="font-medium text-stone-800 text-center">
                        {{ itemCount }} item akan dihapus
                    </p>
                </div>

                <div class="flex space-x-4">
                    <button
                        @click="$emit('cancel')"
                        class="flex-1 border border-stone-300 text-stone-600 py-3 px-4 hover:bg-stone-50 transition-colors duration-200 font-medium"
                    >
                        Batal
                    </button>
                    <button
                        @click="$emit('confirm')"
                        :disabled="isProcessing"
                        class="flex-1 bg-stone-800 text-white py-3 px-4 hover:bg-stone-900 transition-colors duration-200 font-medium disabled:opacity-50 disabled:cursor-not-allowed"
                    >
                        {{ confirmText }}
                    </button>
                </div>
            </div>
        </div>
    </Teleport>
</template>

<script setup lang="ts">
const props = defineProps<{
    show: boolean;
    title: string;
    message?: string;
    itemCount?: number;
    confirmText?: string;
    isProcessing?: boolean;
}>();

const emit = defineEmits(["confirm", "cancel"]);
</script>
