<template>
    <div
        class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-white to-gray-50 shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2"
    >
        <div
            class="absolute inset-0 bg-gradient-to-r from-purple-400/10 via-pink-400/10 to-orange-400/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500"
        ></div>

        <Link :href="route('menu.show', menu.kode_menu)" class="block">
            <div class="relative h-64 overflow-hidden px-1 pt-1">
                <!-- Loading Skeleton -->
                <div
                    v-if="imageLoading"
                    class="w-full h-full bg-gradient-to-br from-gray-200 to-gray-300 animate-pulse rounded-t-xl"
                ></div>

                <!-- Actual Image -->
                <img
                    v-show="!imageLoading"
                    :src="
                        menu.path_img
                            ? `/images/${menu.path_img}`
                            : '/images/coffe.png'
                    "
                    :alt="menu.nama"
                    class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700 ease-out rounded-t-xl"
                    @load="imageLoading = false"
                    @error="handleImageError"
                />

                <!-- Overlay Gradient -->
                <div
                    class="absolute inset-0 bg-gradient-to-t from-black/20 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"
                ></div>
            </div>
        </Link>

        <!-- Content Container -->
        <div class="relative p-4 bg-gradient-to-br from-amber-50 to-orange-50">
            <h3
                class="font-bold text-lg text-gray-900 mb-1 leading-tight group-hover:text-transparent group-hover:bg-gradient-to-r group-hover:from-gray-900 group-hover:to-gray-600 group-hover:bg-clip-text transition-all duration-300 text-start"
            >
                {{ menu.nama }}
            </h3>

            <div class="flex items-center justify-between">
                <!-- Price -->
                <div class="flex flex-col">
                    <span
                        class="text-lg font-black text-slate-950 bg-clip-text"
                    >
                        Rp {{ formatPrice(menu.harga) }}
                    </span>
                    <span class="text-xs text-gray-500 font-medium"
                        >per item</span
                    >
                </div>

                <!-- Add to Cart Button -->
                <button
                    @click.prevent="handleAddToCart"
                    :disabled="loading"
                    class="group/btn relative overflow-hidden bg-coklat text-white font-semibold px-6 py-3 rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed"
                >
                    <div
                        class="absolute inset-0 bg-slate-950 transform scale-x-0 group-hover/btn:scale-x-100 transition-transform duration-300 origin-left"
                    ></div>

                    <!-- Button Content -->
                    <span class="relative flex items-center space-x-2 text-sm">
                        <!-- Shopping Cart Icon -->
                        <svg
                            v-if="!loading"
                            class="w-4 h-4 transition-transform duration-300 group-hover/btn:scale-110"
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

                        <span>{{ loading ? "Tambah" : "Tambah" }}</span>
                    </span>
                </button>
            </div>

            <!-- User Feedback Messages -->
            <p v-if="error" class="text-red-500 text-xs mt-2">{{ error }}</p>
        </div>
    </div>

    <!-- Toast Notification - Outside card container -->
    <Teleport to="body">
        <div
            v-if="showToast"
            class="fixed top-4 right-4 z-50 transform transition-all duration-500 ease-in-out"
            :class="{
                'translate-x-0 opacity-100 scale-100': showToast,
                'translate-x-full opacity-0 scale-95': !showToast,
            }"
        >
            <div
                class="bg-green-500 text-white px-6 py-4 rounded-lg shadow-2xl flex items-center space-x-3 min-w-[300px] backdrop-blur-sm border border-green-400/20"
            >
                <!-- Success Icon -->
                <div class="flex-shrink-0">
                    <svg
                        class="w-6 h-6 text-green-100"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M5 13l4 4L19 7"
                        />
                    </svg>
                </div>

                <!-- Toast Content -->
                <div class="flex-1">
                    <p class="font-medium text-sm">Berhasil ditambahkan!</p>
                    <p class="text-green-100 text-xs">
                        {{ menu.nama }} sudah masuk keranjang
                    </p>
                </div>

                <!-- Close Button -->
                <button
                    @click="closeToast"
                    class="flex-shrink-0 text-green-100 hover:text-white transition-colors duration-200"
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
    </Teleport>
</template>

<script setup lang="ts">
import { defineProps, ref } from "vue";
import { useMenuCard } from "@/composables/useMenuCard";
import type { Menu } from "@/types/menu"; // Assuming you have this type definition
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

        // Auto hide toast after 3 seconds
        setTimeout(() => {
            showToast.value = false;
        }, 3000);
    }
};

const closeToast = () => {
    showToast.value = false;
};
</script>

<style scoped>
/* Toast slide-in animation */
@keyframes slideInRight {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

@keyframes slideOutRight {
    from {
        transform: translateX(0);
        opacity: 1;
    }
    to {
        transform: translateX(100%);
        opacity: 0;
    }
}
</style>
