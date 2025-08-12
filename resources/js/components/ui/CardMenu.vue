<script setup lang="ts">
import { defineProps, defineEmits } from "vue";
import { useMenuCard } from "@/composables/useMenuCard";
import { Menu } from "@/types/menu";
import { Link } from "@inertiajs/vue3";

const props = defineProps<{
    menu: Menu;
}>();

const emit = defineEmits<{
  (event: "add-to-cart", menu: Menu): void;
  (event: "click", menu: Menu): void;
}>();

const {
    imageLoading,
    isAdding,
    isFavorite,
    formatPrice,
    addToCart,
    toggleFavorite,
    handleClick,
    handleImageError,
} = useMenuCard(props, emit);
</script>

<template>
    <div
        class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-white to-gray-50 shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2"
    >
        <div
            class="absolute inset-0 bg-gradient-to-r from-purple-400/10 via-pink-400/10 to-orange-400/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500"
        ></div>

        <!-- Image Container -->
        <Link @click="handleClick" href="#" class="block">
            <div class="relative h-64 overflow-hidden px-1 pt-1">
                <!-- Loading Skeleton -->
                <div
                    v-if="imageLoading"
                    class="w-full h-full bg-gradient-to-br from-gray-200 to-gray-300 animate-pulse"
                ></div>
                

                <!-- Image -->
                <img
                    v-if="menu.path_img"
                    :src="`/images/${menu.path_img}`"
                    :alt="menu.nama"
                    class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700 ease-out rounded-t-xl"
                    @load="imageLoading = false"
                    @error="handleImageError"
                />
                <img
                    v-else
                    src="/images/coffe.png"
                    :alt="menu.nama"
                    class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700 ease-out"
                    @load="imageLoading = false"
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

                <button
                    @click.prevent="addToCart"
                    :disabled="isAdding"
                    class="group/btn relative overflow-hidden bg-coklat text-white font-semibold px-6 py-3 rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed"
                >
                    <div
                        class="absolute inset-0 bg-slate-950 transform scale-x-0 group-hover/btn:scale-x-100 transition-transform duration-300 origin-left"
                    ></div>

                    <!-- Button Content -->
                    <span class="relative flex items-center space-x-2 text-sm">
                        <span>{{
                            isAdding ? "Adding..." : "Add to Cart"
                        }}</span>
                    </span>
                </button>
            </div>
        </div>
    </div>
</template>
