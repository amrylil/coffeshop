<template>
    <AppLayout title="Keranjang">
        <div class="min-h-screen">
            <div class="container mx-auto px-4 py-8 pt-24">
                <div class="text-center mb-5">
                    <h2 class="text-5xl font-serif italic mb-6 text-[#e6dbd1]">
                        Keranjang
                    </h2>
                    <div class="flex justify-center items-center">
                        <div class="h-px w-16 bg-[#e6dbd1]"></div>
                        <span class="mx-4">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="24"
                                height="24"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="#e6dbd1"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >
                                <path d="M17 8h1a4 4 0 1 1 0 8h-1"></path>
                                <path
                                    d="M3 8h14v9a4 4 0 0 1-4 4H7a4 4 0 0 1-4-4Z"
                                ></path>
                                <line x1="6" y1="2" x2="6" y2="4"></line>
                                <line x1="10" y1="2" x2="10" y2="4"></line>
                                <line x1="14" y1="2" x2="14" y2="4"></line>
                            </svg>
                        </span>
                        <div class="h-px w-16 bg-[#e6dbd1]"></div>
                    </div>
                </div>

                <div class="max-w-6xl mx-auto">
                    <div
                        v-if="items.length > 0"
                        class="grid grid-cols-1 lg:grid-cols-3 gap-8"
                    >
                        <div class="lg:col-span-2">
                            <div
                                class="bg-white rounded-2xl shadow-lg overflow-hidden"
                            >
                                <div class="bg-[#422424] text-white p-6">
                                    <h2
                                        class="text-2xl font-semibold flex items-center"
                                    >
                                        Item Pesanan ({{ itemCount }})
                                    </h2>
                                </div>
                                <div class="p-6 space-y-4">
                                    <div
                                        v-for="item in items"
                                        :key="item.kode_item"
                                        class="flex items-center space-x-4 p-4 bg-gradient-to-r from-amber-50 to-orange-50 rounded-xl border border-amber-200 hover:shadow-md transition-all duration-300"
                                    >
                                        <div class="flex-shrink-0">
                                            <img
                                                v-if="item.menu.path_img"
                                                :src="item.menu.path_img"
                                                :alt="item.menu.nama"
                                                class="w-20 h-20 rounded-lg object-cover shadow-sm"
                                            />
                                            <div
                                                v-else
                                                class="w-20 h-20 bg-gradient-to-r from-amber-700 to-orange-700 rounded-lg flex items-center justify-center"
                                            >
                                                <svg
                                                    class="w-8 h-8 text-white"
                                                    fill="currentColor"
                                                    viewBox="0 0 20 20"
                                                >
                                                    <path
                                                        d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4zM18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z"
                                                    />
                                                </svg>
                                            </div>
                                        </div>

                                        <div class="flex-1">
                                            <h3
                                                class="font-semibold text-amber-900 text-lg"
                                            >
                                                {{ item.menu.nama }}
                                            </h3>
                                            <p
                                                class="text-amber-600 text-sm hidden md:block"
                                            >
                                                {{ item.menu.deskripsi }}
                                            </p>
                                            <div class="flex items-center mt-2">
                                                <span
                                                    class="text-amber-800 font-medium"
                                                    >{{
                                                        formatCurrency(
                                                            item.menu.harga
                                                        )
                                                    }}</span
                                                >
                                                <span
                                                    class="text-amber-600 text-sm ml-2"
                                                    >per item</span
                                                >
                                            </div>
                                        </div>

                                        <div
                                            class="flex items-center space-x-3"
                                        >
                                            <button
                                                @click="
                                                    updateQuantity(
                                                        item.kode_item,
                                                        item.quantity - 1
                                                    )
                                                "
                                                :disabled="isProcessing"
                                                class="..."
                                            >
                                                -
                                            </button>
                                            <span
                                                class="w-12 text-center ..."
                                                >{{ item.quantity }}</span
                                            >
                                            <button
                                                @click="
                                                    updateQuantity(
                                                        item.kode_item,
                                                        item.quantity + 1
                                                    )
                                                "
                                                :disabled="isProcessing"
                                                class="..."
                                            >
                                                +
                                            </button>
                                        </div>

                                        <div class="text-right">
                                            <div
                                                class="font-bold text-amber-900 text-lg"
                                            >
                                                {{ formatCurrency(item.price) }}
                                            </div>
                                            <button
                                                @click="
                                                    removeItem(item.kode_item)
                                                "
                                                :disabled="isProcessing"
                                                class="text-red-500 ..."
                                            >
                                                Hapus
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="lg:col-span-1">
                            <div
                                class="bg-white rounded-2xl shadow-lg overflow-hidden sticky top-24"
                            >
                                <div class="bg-[#422424] text-white p-6">
                                    <h2
                                        class="text-xl font-semibold flex items-center"
                                    >
                                        Ringkasan Pesanan
                                    </h2>
                                </div>
                                <div class="p-6">
                                    <div class="space-y-4">
                                        <div
                                            class="flex justify-between items-center py-2 border-b border-amber-100"
                                        >
                                            <span class="text-amber-700"
                                                >Subtotal</span
                                            >
                                            <span
                                                class="font-semibold text-amber-900"
                                                >{{
                                                    formatCurrency(subtotal)
                                                }}</span
                                            >
                                        </div>
                                        <div
                                            class="flex justify-between items-center py-2 border-b border-amber-100"
                                        >
                                            <span class="text-amber-700"
                                                >Pajak (11%)</span
                                            >
                                            <span
                                                class="font-semibold text-amber-900"
                                                >{{ formatCurrency(tax) }}</span
                                            >
                                        </div>
                                        <div
                                            class="flex justify-between items-center py-3 border-t-2 border-amber-200"
                                        >
                                            <span
                                                class="text-lg font-bold text-amber-900"
                                                >Total</span
                                            >
                                            <span
                                                class="text-xl font-bold text-amber-900"
                                                >{{
                                                    formatCurrency(grandTotal)
                                                }}</span
                                            >
                                        </div>
                                    </div>
                                    <div class="p-6">
                                        <div
                                            v-if="checkoutError"
                                            class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4"
                                            role="alert"
                                        >
                                            <p class="font-bold">
                                                Terjadi Kesalahan
                                            </p>
                                            <p>{{ checkoutError }}</p>
                                        </div>

                                        <div class="mt-6 space-y-3">
                                            <button
                                                @click="handleCheckout"
                                                :disabled="isCheckingOut"
                                                class="w-full bg-amber-800 text-white font-bold py-3 px-4 rounded-lg hover:bg-amber-900 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-amber-500 disabled:bg-gray-400 disabled:cursor-not-allowed flex items-center justify-center"
                                            >
                                                <svg
                                                    v-if="isCheckingOut"
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
                                                <span>{{
                                                    isCheckingOut
                                                        ? "Memproses..."
                                                        : "Checkout Sekarang"
                                                }}</span>
                                            </button>
                                            <button
                                                @click="clearCart"
                                                :disabled="
                                                    isProcessing ||
                                                    isCheckingOut
                                                "
                                                class="w-full ..."
                                            >
                                                Kosongkan Keranjang
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div v-else class="max-w-md mx-auto text-center">
                        <div class="bg-white rounded-2xl shadow-lg p-12">
                            <h2 class="text-2xl font-bold text-amber-900 mb-4">
                                Keranjang Kosong
                            </h2>
                            <a href="/menu" class="inline-block ..."
                                >Jelajahi Menu Kopi</a
                            >
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from "@/Layouts/AppLayout.vue";
import type { CartDetails } from "@/types/keranjang";
import { computed } from "vue";
import { useCart } from "@/composables/useCart";
import { useCheckout } from "@/composables/useCheckout";

const props = defineProps<{
    cartDetails: CartDetails | null;
}>();

console.log("Data Keranjang dari Server:", props.cartDetails);

const items = computed(() => props.cartDetails?.items ?? []);
const itemCount = computed(() => props.cartDetails?.count ?? 0);
const subtotal = computed(() => props.cartDetails?.total ?? 0);
const tax = computed(() => subtotal.value * 0.11);
const grandTotal = computed(() => subtotal.value + tax.value);

const {
    isProcessing: isCheckingOut,
    error: checkoutError,
    processCheckout,
} = useCheckout();

const handleCheckout = async () => {
    if (!items.value || items.value.length === 0) {
        alert("Keranjang Anda kosong!");
        return;
    }

    const checkoutData = {
        items: items.value.map((item) => ({
            kode_menu: item.menu.kode_menu,
            jumlah: item.quantity,
            harga: item.menu.harga,
        })),
        total_harga: subtotal.value,
    };

    await processCheckout(checkoutData);
};

const formatCurrency = (value: number): string => {
    return new Intl.NumberFormat("id-ID", {
        style: "currency",
        currency: "IDR",
        minimumFractionDigits: 0,
    }).format(value);
};

const { isProcessing, updateQuantity, removeItem, clearCart } = useCart();
</script>
