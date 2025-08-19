<template>
    <div class="lg:col-span-1">
        <div class="bg-lunen shadow-sm border border-coklat sticky top-24">
            <div class="border-b border-coklat px-6 py-6">
                <h3 class="text-xl text-stone-800">Ringkasan Pesanan</h3>
            </div>

            <div class="px-6 py-6">
                <div class="space-y-4">
                    <div class="flex justify-between items-center py-2">
                        <span class="text-stone-600">Subtotal:</span>
                        <span class="font-medium text-stone-800">
                            {{ formatCurrency(subtotal) }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center py-2">
                        <span class="text-stone-600">Pajak (11%):</span>
                        <span class="font-medium text-stone-800">
                            {{ formatCurrency(tax) }}
                        </span>
                    </div>
                    <div class="border-t border-coklat pt-4">
                        <div class="flex justify-between items-center">
                            <span class="text-lg text-stone-800">Total:</span>
                            <span class="text-2xl text-stone-800">
                                {{ formatCurrency(grandTotal) }}
                            </span>
                        </div>
                    </div>
                </div>

                <div
                    v-if="checkoutError"
                    class="mt-6 p-4 border border-red-200 bg-red-50 text-red-700 text-sm"
                    role="alert"
                >
                    <p class="font-medium mb-1">Terjadi Kesalahan</p>
                    <p>{{ checkoutError }}</p>
                </div>

                <div class="mt-8 space-y-3">
                    <button
                        @click="$emit('show-modal-payment')"
                        :disabled="isCheckingOut"
                        class="w-full bg-coklat text-white font-medium py-4 px-6 hover:bg-stone-900 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-stone-500 focus:ring-offset-2 disabled:bg-stone-400 disabled:cursor-not-allowed text-center"
                    >
                        <span
                            v-if="isCheckingOut"
                            class="flex items-center justify-center"
                        >
                            <svg
                                class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                            >
                                <circle
                                    class="opacity-25"
                                    cx="12"
                                    cy="12"
                                    r="10"
                                    stroke="currentColor"
                                    stroke-width="4"
                                ></circle>
                                <path
                                    class="opacity-75"
                                    fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                                ></path>
                            </svg>
                            Memproses...
                        </span>
                        <span v-else>Lanjutkan ke Pembayaran</span>
                    </button>

                    <button
                        @click="$emit('clear-toast')"
                        :disabled="isProcessing || isCheckingOut"
                        class="w-full border border-stone-300 text-stone-600 font-medium py-3 px-6 hover:bg-stone-50 transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
                    >
                        Kosongkan Keranjang
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { useCurrency } from "@/composables/useCurrency";

const props = defineProps<{
    subtotal: number;
    isProcessing: boolean;
    isCheckingOut: boolean;
    checkoutError: string | null;
    tax: number;
    grandTotal: number;
}>();

const emit = defineEmits(["clear-toast", "show-modal-payment"]);

const { formatCurrency } = useCurrency();
</script>
