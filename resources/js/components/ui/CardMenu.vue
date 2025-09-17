<template>
    <div
        class="bg-lunen border border-stone-200 shadow-sm hover:shadow-md transition-shadow duration-300 group"
    >
        <!-- Product Image -->
        <div class="relative overflow-hidden">
            <Link :href="route('menu.show', menu.kode_menu)" class="block">
                <!-- Loading Skeleton -->
                <div
                    v-if="imageLoading"
                    class="w-full h-56 bg-stone-200 animate-pulse"
                ></div>

                <!-- Actual Image -->
                <img
                    v-show="!imageLoading"
                    :src="`/images/${menu.path_img}`"
                    :alt="menu.nama"
                    class="w-full h-56 object-cover group-hover:scale-105 transition-transform duration-500 ease-out"
                    @load="imageLoading = false"
                    @error="handleImageError"
                />
            </Link>

            <!-- Category Badge -->
            <div class="absolute top-4 left-4">
                <span
                    class="bg-white border border-stone-300 px-3 py-1 text-xs font-medium text-stone-700 shadow-sm"
                >
                    {{ menu.kategori?.nama }}
                </span>
            </div>
        </div>

        <!-- Content -->
        <div class="p-4">
            <!-- Product Title -->
            <Link :href="route('menu.show', menu.kode_menu)">
                <h3
                    class="font-serif text-xl text-stone-800 mb-3 leading-tight hover:text-stone-600 transition-colors duration-200 text-start"
                >
                    {{ menu.nama }}
                </h3>
            </Link>

            <!-- Price and Action -->
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-2xl font-bold text-stone-800 mb-1">
                        Rp {{ formatPrice(menu.harga) }}
                    </div>
                </div>

                <!-- Add to Cart Button -->
                <button
                    v-if="menu.jumlah > 0"
                    @click.prevent="handleAddToCart"
                    :disabled="loading"
                    class="bg-coklat text-white font-medium px-4 py-2 hover:bg-stone-900 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-stone-500 focus:ring-offset-2 disabled:bg-stone-400 disabled:cursor-not-allowed flex items-center space-x-2"
                >
                    <!-- Loading Spinner -->
                    <svg
                        v-if="loading"
                        class="animate-spin w-4 h-4"
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

                    <!-- Shopping Cart Icon -->
                    <svg
                        v-else
                        class="w-4 h-4"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m4.5 0h3.5m-7 0a1 1 0 100 2 1 1 0 000-2zm7 0a1 1 0 100 2 1 1 0 000-2z"
                        />
                    </svg>

                    <span class="text-sm">{{
                        loading ? "Adding..." : "Tambah"
                    }}</span>
                </button>

                <!-- Out of Stock -->
                <div v-else class="text-stone-400 text-sm font-medium">
                    Out of Stock
                </div>
            </div>
        </div>
    </div>

    <!-- Classic Toast Notification -->
    <Teleport to="body">
        <div
            v-if="showToast"
            class="fixed top-8 right-8 z-50 transform transition-all duration-300 ease-out"
            :class="{
                'translate-x-0 opacity-100': showToast,
                'translate-x-full opacity-0': !showToast,
            }"
        >
            <div
                class="bg-white border border-stone-200 shadow-lg p-6 max-w-sm"
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
                            Added to Cart
                        </h4>
                        <p class="text-sm text-stone-600">
                            {{ menu.nama }} has been added to your cart.
                        </p>
                    </div>
                    <button
                        @click="closeToast"
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
import { defineProps, ref } from "vue";
import { useMenuCard } from "@/composables/useMenuCard";
import type { Menu } from "@/types/menu";
import { Link } from "@inertiajs/vue3";
import { useCart } from "@/composables/useCart";
import { route } from "ziggy-js";

const props = defineProps<{
    menu: Menu;
}>();

const { imageLoading, formatPrice, handleImageError } = useMenuCard(props);
const { loading, error, addToCart } = useCart();
const showToast = ref<boolean>(false);

const handleAddToCart = async () => {
    const success = await addToCart(props.menu.kode_menu, 1);

    if (success) {
        showToast.value = true;
        // Auto hide toast after 4 seconds
        setTimeout(() => {
            showToast.value = false;
        }, 4000);
    }
};

const closeToast = () => {
    showToast.value = false;
};
</script>

<style scoped>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
