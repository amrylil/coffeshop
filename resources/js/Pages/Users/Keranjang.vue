<template>
    <AppLayout title="Keranjang">
        <div class="min-h-screen">
            <div class="container mx-auto px-4 py-8 pt-24">
                <div class="text-center mb-8 space-y-3">
                    <h2 class="text-5xl font-serif italic text-lunen">
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

                <div class="max-w-7xl mx-auto">
                    <div
                        v-if="items.length > 0"
                        class="grid grid-cols-1 lg:grid-cols-4 gap-8"
                    >
                        <div class="lg:col-span-3">
                            <div
                                class="bg-lunen shadow-sm border border-coklat"
                            >
                                <div class="border-b border-coklat px-8 py-6">
                                    <h2
                                        class="text-2xl text-stone-800 flex items-center"
                                    >
                                        Pesanan Anda
                                        <span
                                            class="ml-4 text-sm font-sans text-white bg-coklat px-3 py-1 rounded-full"
                                        >
                                            {{ itemCount }}
                                            item
                                        </span>
                                    </h2>
                                </div>

                                <div class="px-8 py-6">
                                    <div class="space-y-6">
                                        <div
                                            v-for="item in items"
                                            :key="item.kode_item"
                                            class="flex items-start py-6 border-b border-stone-100 last:border-b-0 hover:bg-stone-25 transition-colors duration-200"
                                        >
                                            <div class="flex-shrink-0 mr-6">
                                                <div class="relative">
                                                    <img
                                                        v-if="
                                                            item.menu.path_img
                                                        "
                                                        :src="
                                                            item.menu.path_img
                                                        "
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
                                                <h3
                                                    class="text-xl text-stone-800 mb-2 leading-tight"
                                                >
                                                    {{ item.menu.nama }}
                                                </h3>
                                                <p
                                                    class="text-stone-600 text-sm mb-3 leading-relaxed max-w-lg"
                                                >
                                                    {{ item.menu.deskripsi }}
                                                </p>
                                                <div
                                                    class="flex items-baseline"
                                                >
                                                    <span
                                                        class="text-stone-800 font-medium text-lg"
                                                    >
                                                        {{
                                                            formatCurrency(
                                                                item.menu.harga
                                                            )
                                                        }}
                                                    </span>
                                                    <span
                                                        class="text-stone-500 text-sm ml-2"
                                                        >per item</span
                                                    >
                                                </div>
                                            </div>

                                            <div class="flex items-center mr-6">
                                                <div
                                                    class="flex items-center border border-stone-300 bg-coklat"
                                                >
                                                    <button
                                                        @click="
                                                            updateQuantity(
                                                                item.kode_item,
                                                                item.quantity -
                                                                    1
                                                            )
                                                        "
                                                        :disabled="
                                                            isProcessing ||
                                                            item.quantity <= 1
                                                        "
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
                                                        @click="
                                                            updateQuantity(
                                                                item.kode_item,
                                                                item.quantity +
                                                                    1
                                                            )
                                                        "
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

                                            <div
                                                class="text-right min-w-[120px]"
                                            >
                                                <div
                                                    class="text-xl text-stone-800 mb-3"
                                                >
                                                    {{
                                                        formatCurrency(
                                                            item.price
                                                        )
                                                    }}
                                                </div>
                                                <button
                                                    @click="
                                                        showDeleteConfirmation(
                                                            item.kode_item,
                                                            item.menu.nama
                                                        )
                                                    "
                                                    :disabled="isProcessing"
                                                    class="text-stone-500 hover:text-red-600 text-sm underline decoration-dotted underline-offset-2 disabled:opacity-50 disabled:cursor-not-allowed transition-colors duration-200"
                                                >
                                                    Hapus
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="lg:col-span-1">
                            <div
                                class="bg-lunen shadow-sm border border-coklat sticky top-24"
                            >
                                <div class="border-b border-coklat px-6 py-6">
                                    <h3 class="text-xl text-stone-800">
                                        Ringkasan Pesanan
                                    </h3>
                                </div>

                                <div class="px-6 py-6">
                                    <div class="space-y-4">
                                        <div
                                            class="flex justify-between items-center py-2"
                                        >
                                            <span class="text-stone-600"
                                                >Subtotal:</span
                                            >
                                            <span
                                                class="font-medium text-stone-800"
                                            >
                                                {{ formatCurrency(subtotal) }}
                                            </span>
                                        </div>
                                        <div
                                            class="flex justify-between items-center py-2"
                                        >
                                            <span class="text-stone-600"
                                                >Pajak (11%):</span
                                            >
                                            <span
                                                class="font-medium text-stone-800"
                                            >
                                                {{ formatCurrency(tax) }}
                                            </span>
                                        </div>
                                        <div
                                            class="border-t border-coklat pt-4"
                                        >
                                            <div
                                                class="flex justify-between items-center"
                                            >
                                                <span
                                                    class="text-lg text-stone-800"
                                                    >Total:</span
                                                >
                                                <span
                                                    class="text-2xl text-stone-800"
                                                >
                                                    {{
                                                        formatCurrency(
                                                            grandTotal
                                                        )
                                                    }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div
                                        v-if="checkoutError"
                                        class="mt-6 p-4 border border-red-200 bg-red-50 text-red-700 text-sm"
                                        role="alert"
                                    >
                                        <p class="font-medium mb-1">
                                            Terjadi Kesalahan
                                        </p>
                                        <p>{{ checkoutError }}</p>
                                    </div>

                                    <div class="mt-8 space-y-3">
                                        <button
                                            @click="handleCheckout"
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
                                            <span v-else
                                                >Lanjutkan ke Pembayaran</span
                                            >
                                        </button>

                                        <button
                                            @click="showClearCartConfirmation"
                                            :disabled="
                                                isProcessing || isCheckingOut
                                            "
                                            class="w-full border border-stone-300 text-stone-600 font-medium py-3 px-6 hover:bg-stone-50 transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
                                        >
                                            Kosongkan Keranjang
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div v-else class="max-w-lg mx-auto text-center">
                        <div
                            class="bg-white shadow-sm border border-coklat px-12 py-16"
                        >
                            <div class="mb-8">
                                <svg
                                    class="w-24 h-24 mx-auto text-stone-300"
                                    fill="currentColor"
                                    viewBox="0 0 20 20"
                                >
                                    <path
                                        d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"
                                    />
                                </svg>
                            </div>
                            <h2 class="text-2xl text-stone-800 mb-4">
                                Keranjang Anda Kosong
                            </h2>
                            <p class="text-stone-600 mb-8 leading-relaxed">
                                Temukan pilihan kopi premium dan camilan lezat
                                kami yang telah dikurasi dengan saksama.
                            </p>
                            <a
                                href="/menu"
                                class="inline-block bg-stone-800 text-white font-medium py-3 px-8 hover:bg-stone-900 transition-colors duration-200"
                            >
                                Lihat Menu
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <Teleport to="body">
            <div
                v-if="showDeleteToast"
                class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 p-4"
                @click="hideDeleteConfirmation"
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
                            Apakah Anda yakin ingin menghapus item ini dari
                            keranjang?
                        </p>
                    </div>

                    <div class="bg-stone-50 p-4 mb-6 border border-coklat">
                        <p class="font-medium text-stone-800 text-center">
                            {{ itemToDelete.name }}
                        </p>
                    </div>

                    <div class="flex space-x-4">
                        <button
                            @click="hideDeleteConfirmation"
                            class="flex-1 border border-stone-300 text-stone-600 py-3 px-4 hover:bg-stone-50 transition-colors duration-200 font-medium"
                        >
                            Batal
                        </button>
                        <button
                            @click="confirmDelete"
                            :disabled="isProcessing"
                            class="flex-1 bg-stone-800 text-white py-3 px-4 hover:bg-stone-900 transition-colors duration-200 font-medium disabled:opacity-50 disabled:cursor-not-allowed"
                        >
                            Hapus
                        </button>
                    </div>
                </div>
            </div>
        </Teleport>

        <Teleport to="body">
            <div
                v-if="showClearToast"
                class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 p-4"
                @click="hideClearCartConfirmation"
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
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"
                                />
                            </svg>
                        </div>
                        <h3 class="text-xl text-stone-800 mb-2">
                            Kosongkan Keranjang
                        </h3>
                        <p class="text-stone-600 mb-4">
                            Tindakan ini akan menghapus semua item dari
                            keranjang Anda. Apakah Anda yakin?
                        </p>
                    </div>

                    <div class="bg-stone-50 p-4 mb-6 border border-coklat">
                        <p class="font-medium text-stone-800 text-center">
                            {{ itemCount }}
                            item akan dihapus
                        </p>
                    </div>

                    <div class="flex space-x-4">
                        <button
                            @click="hideClearCartConfirmation"
                            class="flex-1 border border-stone-300 text-stone-600 py-3 px-4 hover:bg-stone-50 transition-colors duration-200 font-medium"
                        >
                            Batal
                        </button>
                        <button
                            @click="confirmClearCart"
                            :disabled="isProcessing"
                            class="flex-1 bg-stone-800 text-white py-3 px-4 hover:bg-stone-900 transition-colors duration-200 font-medium disabled:opacity-50 disabled:cursor-not-allowed"
                        >
                            Kosongkan Keranjang
                        </button>
                    </div>
                </div>
            </div>
        </Teleport>

        <Teleport to="body">
            <div
                v-if="showSuccessToast"
                class="fixed top-8 right-8 z-50 transform transition-all duration-300 ease-out"
                :class="{
                    'translate-x-0 opacity-100': showSuccessToast,
                    'translate-x-full opacity-0': !showSuccessToast,
                }"
            >
                <div
                    class="bg-white border border-coklat shadow-lg p-6 max-w-sm"
                >
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
                                {{ successMessage.title }}
                            </h4>
                            <p class="text-sm text-stone-600">
                                {{ successMessage.message }}
                            </p>
                        </div>
                        <button
                            @click="hideSuccessToast"
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
    </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from "@/Layouts/AppLayout.vue";
import type { CartDetails } from "@/types/keranjang";
import { computed, ref } from "vue";
import { useCart } from "@/composables/useCart";
import { useCheckout } from "@/composables/useCheckout";

const props = defineProps<{
    cartDetails: CartDetails | null;
}>();

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
const { isProcessing, updateQuantity, removeItem, clearCart } = useCart();

// Toast states
const showDeleteToast = ref(false);
const showClearToast = ref(false);
const showSuccessToast = ref(false);
const itemToDelete = ref({ id: 0, name: "" });
const successMessage = ref({ title: "", message: "" });

// Delete confirmation methods
const showDeleteConfirmation = (id: number, name: string) => {
    itemToDelete.value = { id, name };
    showDeleteToast.value = true;
};

const hideDeleteConfirmation = () => {
    showDeleteToast.value = false;
    itemToDelete.value = { id: 0, name: "" };
};

const confirmDelete = async () => {
    const result = await removeItem(itemToDelete.value.id);
    hideDeleteConfirmation();

    if (result.success) {
        successMessage.value = {
            title: "Item Dihapus",
            message: `${itemToDelete.value.name} telah dihapus dari keranjang Anda.`,
        };
        showSuccessToast.value = true;
        setTimeout(hideSuccessToast, 4000);
    }
};

// Clear cart confirmation methods
const showClearCartConfirmation = () => {
    showClearToast.value = true;
};

const hideClearCartConfirmation = () => {
    showClearToast.value = false;
};

const confirmClearCart = async () => {
    const success = await clearCart();
    hideClearCartConfirmation();

    if (success) {
        successMessage.value = {
            title: "Keranjang Dikosongkan",
            message: "Semua item telah dihapus dari keranjang Anda.",
        };
        showSuccessToast.value = true;
        setTimeout(hideSuccessToast, 4000);
    }
};

const hideSuccessToast = () => {
    showSuccessToast.value = false;
};

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
</script>
