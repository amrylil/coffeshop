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
                <div class="text-center mb-6">
                    <div
                        class="w-16 h-16 mx-auto mb-4 bg-stone-100 rounded-full flex items-center justify-center"
                    >
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
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1-1H8a1 1 0 00-1 1v3M4 7h16"
                            />
                        </svg>
                    </div>
                    <h3 class="text-xl text-stone-800 mb-2">Hapus Item</h3>
                    <p class="text-stone-600 mb-4">
                        Apakah Anda yakin ingin menghapus {{ title }} ?
                    </p>
                </div>

                <div class="bg-stone-50 p-4 mb-6 border border-coklat">
                    <p class="font-medium text-stone-800 text-center">
                        {{ title }}
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
    confirmText?: string;
    isProcessing?: boolean;
}>();

const emit = defineEmits(["confirm", "cancel"]);
</script>
