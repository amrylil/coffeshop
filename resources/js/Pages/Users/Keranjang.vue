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
                                        <CartItem
                                            v-for="item in items"
                                            :key="item.kode_item"
                                            :item="item"
                                            @increment="
                                                updateQuantity(
                                                    item.kode_item,
                                                    item.quantity + 1
                                                )
                                            "
                                            @decrement="
                                                updateQuantity(
                                                    item.kode_item,
                                                    item.quantity - 1
                                                )
                                            "
                                            @delete="
                                                showDeleteConfirmation(
                                                    item.kode_item,
                                                    item.menu.nama
                                                )
                                            "
                                            :is-processing="isProcessing"
                                        >
                                        </CartItem>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="lg:col-span-1">
                            <CartSummary
                                :grand-total="grandTotal"
                                :checkout-error="checkoutError"
                                :is-checking-out="isCheckingOut"
                                :is-processing="isProcessing"
                                :subtotal="subtotal"
                                :tax="tax"
                                @clear-toast="showClearCartConfirmation"
                                @show-modal-payment="handleCheckout"
                            >
                            </CartSummary>
                        </div>
                    </div>

                    <div v-else class="max-w-lg mx-auto text-center">
                        <CartEmpty />
                    </div>
                </div>
            </div>
        </div>

        <DeleteToast
            :show="showDeleteToast"
            :title="itemToDelete.name"
            confirm-text="Hapus"
            :is-processing="isProcessing"
            @confirm="confirmDelete"
            @cancel="hideDeleteConfirmation"
        ></DeleteToast>

        <ConfirmClear
            :show="showClearToast"
            confirm-text="Musnahkan"
            :is-processing="isProcessing"
            :item-count="itemCount"
            message="Apakah anda yakin menghapus semua item di keranjang?"
            title="Hapus Semua Item"
            @confirm="confirmClearCart"
            @cancel="hideClearCartConfirmation"
        ></ConfirmClear>

        <SuccessToast
            :title="successMessage.title"
            :message="successMessage.message"
            :show-success-toast="showSuccessToast"
            @close="hideSuccessToast"
        />
    </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from "@/Layouts/AppLayout.vue";
import type { CartDetails } from "@/types/keranjang";
import { computed, ref } from "vue";
import { useCart } from "@/composables/useCart";
import { useCheckout } from "@/composables/useCheckout";
import CartItem from "@/components/keranjang/CartItem.vue";
import CartSummary from "@/components/keranjang/CartSummary.vue";
import ConfirmClear from "@/components/keranjang/ConfirmClear.vue";
import DeleteToast from "@/components/ui/DeleteToast.vue";
import CartEmpty from "@/components/keranjang/CartEmpty.vue";
import SuccessToast from "@/components/ui/SuccessToast.vue";

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

const showDeleteToast = ref(false);
const showClearToast = ref(false);
const showSuccessToast = ref(false);
const itemToDelete = ref({ id: 0, name: "" });
const successMessage = ref({ title: "", message: "" });

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
