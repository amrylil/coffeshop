<template>
    <div
        :key="item.kode_item"
        class="flex items-start py-6 border-b border-stone-100 last:border-b-0 hover:bg-stone-25 transition-colors duration-200"
    >
        <div class="flex-shrink-0 mr-6">
            <div class="relative">
                <img
                    v-if="item.menu.path_img"
                    :src="item.menu.path_img"
                    :alt="item.menu.nama"
                    class="w-24 h-24 object-cover border border-coklat shadow-sm"
                />
                <div
                    v-else
                    class="w-24 h-24 bg-stone-300 flex items-center justify-center border border-coklat"
                >
                    <svg
                        class="w-8 h-8 text-stone-500"
                        fill="currentColor"
                        viewBox="0 0 20 20"
                    >
                        <path
                            d="M4 2a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H4zM2 16a1 1 0 0 1 1-1h12a1 1 0 1 1 0 2H3a1 1 0 0 1-1-1z"
                        />
                        <path
                            d="M15 6a1 1 0 0 1 1-1h1a2 2 0 0 1 2 2v2a2 2 0 0 1-2 2h-1a1 1 0 0 1-1-1V6z"
                        />
                    </svg>
                </div>
            </div>
        </div>

        <div class="flex-1 mr-6">
            <h3 class="text-xl text-stone-800 mb-2 leading-tight">
                {{ item.menu.nama }}
            </h3>
            <p class="text-stone-600 text-sm mb-3 leading-relaxed max-w-lg">
                {{ item.menu.deskripsi }}
            </p>
            <div class="flex items-baseline">
                <span class="text-stone-800 font-medium text-lg">
                    {{ formatCurrency(item.menu.harga) }}
                </span>
                <span class="text-stone-500 text-sm ml-2">per item</span>
            </div>
        </div>

        <div class="flex items-center mr-6">
            <div class="flex items-center border border-stone-300 bg-coklat">
                <button
                    @click="$emit('decrement')"
                    :disabled="isProcessing || item.quantity <= 1"
                    class="w-10 h-10 flex items-center justify-center text-slate-50 disabled:opacity-50 disabled:cursor-not-allowed transition-colors duration-200"
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
                            d="M20 12H4"
                        />
                    </svg>
                </button>
                <div
                    class="w-12 h-10 flex items-center justify-center border-l border-r border-stone-300 font-medium text-slate-50"
                >
                    {{ item.quantity }}
                </div>
                <button
                    @click="$emit('increment')"
                    :disabled="isProcessing"
                    class="w-10 h-10 flex items-center justify-center text-slate-50 disabled:opacity-50 disabled:cursor-not-allowed transition-colors duration-200"
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
                            d="M12 4v16m8-8H4"
                        />
                    </svg>
                </button>
            </div>
        </div>

        <div class="text-right min-w-[120px]">
            <div class="text-xl text-stone-800 mb-3">
                {{ formatCurrency(item.price) }}
            </div>
            <button
                @click="$emit('delete')"
                :disabled="isProcessing"
                class="text-stone-500 hover:text-red-600 text-sm underline decoration-dotted underline-offset-2 disabled:opacity-50 disabled:cursor-not-allowed transition-colors duration-200"
            >
                Hapus
            </button>
        </div>
    </div>
</template>

<script setup lang="ts">
import { useCurrency } from "@/composables/useCurrency";
import { ItemKeranjang } from "@/types/keranjang";
import {} from "@/types/menu";

const props = defineProps<{ item: ItemKeranjang; isProcessing: boolean }>();
const emit = defineEmits(["increment", "delete", "decrement"]);
const { formatCurrency } = useCurrency();
</script>
