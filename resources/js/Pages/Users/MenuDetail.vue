<template>
    <AppLayout title="Detail">
        <section class="min-h-screen py-8 pt-24">
            <div class="max-w-7xl mx-auto px-4">
                <!-- Classic Breadcrumb -->
                <nav class="mb-8" aria-label="Breadcrumb">
                    <div
                        class="bg-lunen border border-stone-200 px-8 py-4 shadow-sm"
                    >
                        <div
                            class="flex items-center space-x-3 text-sm text-stone-600"
                        >
                            <Link
                                href="/"
                                class="hover:text-coklat transition-colors duration-200 flex items-center"
                            >
                                <svg
                                    class="w-4 h-4 mr-2"
                                    fill="currentColor"
                                    viewBox="0 0 20 20"
                                >
                                    <path
                                        d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"
                                    />
                                </svg>
                                Home
                            </Link>
                            <span class="text-stone-400">/</span>
                            <Link
                                :href="route('menu.index')"
                                class="hover:text-coklat transition-colors duration-200"
                            >
                                Menu
                            </Link>
                            <span class="text-stone-400">/</span>
                            <Link
                                :href="
                                    route(
                                        'menu.category',
                                        menu.kategori.kode_kategori
                                    )
                                "
                                class="hover:text-coklat transition-colors duration-200"
                            >
                                {{ menu.kategori.nama }}
                            </Link>
                            <span class="text-stone-400">/</span>
                            <span class="text-coklat font-medium">{{
                                menu.nama
                            }}</span>
                        </div>
                    </div>
                </nav>

                <!-- Classic Product Layout -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 mb-20">
                    <!-- Product Image -->
                    <div class="space-y-6">
                        <div class="bg-lunen border border-stone-200 shadow-sm">
                            <div class="relative">
                                <img
                                    :src="
                                        menu.path_img
                                            ? `/${menu.path_img}`
                                            : '/images/coffe.png'
                                    "
                                    :alt="menu.nama"
                                    class="w-full h-[600px] object-cover"
                                />

                                <!-- Category Badge -->
                                <div class="absolute top-6 left-6">
                                    <div
                                        class="bg-coklat border border-stone-300 px-4 py-2 shadow-sm"
                                    >
                                        <span
                                            class="text-stone-700 font-medium text-sm flex items-center text-white"
                                        >
                                            <svg
                                                class="w-4 h-4 mr-2"
                                                fill="#d6d3d1"
                                                viewBox="0 0 20 20"
                                            >
                                                <path
                                                    d="M4 2a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H4zM2 16a1 1 0 0 1 1-1h12a1 1 0 1 1 0 2H3a1 1 0 0 1-1-1z"
                                                />
                                                <path
                                                    d="M15 6a1 1 0 0 1 1-1h1a2 2 0 0 1 2 2v2a2 2 0 0 1-2 2h-1a1 1 0 0 1-1-1V6z"
                                                />
                                            </svg>
                                            {{ menu.kategori.nama }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Product Information -->
                    <div class="bg-lunen border border-stone-200 shadow-sm">
                        <div class="p-8 space-y-8">
                            <!-- Title & Price -->
                            <div class="border-b border-stone-200 pb-6">
                                <h1
                                    class="text-4xl font-serif text-coklat mb-4 leading-tight"
                                >
                                    {{ menu.nama }}
                                </h1>
                                <div class="text-3xl font-bold text-coklat">
                                    Rp {{ formatPrice(menu.harga) }}
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="py-6 border-b border-stone-200">
                                <h3 class="text-lg font-serif text-coklat mb-4">
                                    Description
                                </h3>
                                <p
                                    class="text-stone-600 leading-relaxed text-base"
                                >
                                    {{
                                        menu.deskripsi ||
                                        "A carefully crafted beverage made with expertise by our skilled baristas. Perfect to enjoy at any time of day."
                                    }}
                                </p>
                            </div>

                            <!-- Purchase Section -->
                            <div class="space-y-6">
                                <!-- Quantity & Total -->
                                <div class="grid grid-cols-2 gap-6">
                                    <div>
                                        <label
                                            class="block text-sm font-medium text-stone-700 mb-3"
                                            >Quantity</label
                                        >
                                        <div
                                            class="flex items-center border w-min border-coklat"
                                        >
                                            <button
                                                @click="decrement"
                                                class="w-12 h-12 flex items-center justify-center text-stone-600 hover:bg-coklat 100 border-r border-coklat transition-colors duration-200"
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
                                            <input
                                                type="number"
                                                v-model="quantity"
                                                min="1"
                                                class="w-20 h-12 text-center border-0 focus:ring-0 text-coklat font-medium"
                                            />
                                            <button
                                                @click="increment"
                                                class="w-12 h-12 flex items-center justify-center text-stone-600 hover:bg-coklat 100 border-l border-coklat transition-colors duration-200"
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

                                    <div>
                                        <label
                                            class="block text-sm font-medium text-stone-700 mb-3"
                                            >Total Price</label
                                        >
                                        <div class="h-12 flex items-center">
                                            <span
                                                class="text-2xl font-bold text-coklat"
                                            >
                                                Rp
                                                {{
                                                    formatPrice(
                                                        menu.harga * quantity
                                                    )
                                                }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Add to Cart Button -->
                                <button
                                    @click="handleAddToCart"
                                    :disabled="loading"
                                    class="w-full bg-coklat text-white font-medium py-4 px-8 hover:bg-stone-900 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-stone-500 focus:ring-offset-2 disabled:bg-stone-400 disabled:cursor-not-allowed flex items-center justify-center space-x-3"
                                >
                                    <svg
                                        v-if="loading"
                                        class="animate-spin h-5 w-5 text-white"
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
                                    <svg
                                        v-else
                                        class="w-5 h-5"
                                        fill="currentColor"
                                        viewBox="0 0 20 20"
                                    >
                                        <path
                                            d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"
                                        />
                                    </svg>
                                    <span>{{
                                        loading ? "Adding..." : "Add to Cart"
                                    }}</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Related Products -->
                <div v-if="relatedMenus.length > 0" class="space-y-12">
                    <div class="text-center mb-8 space-y-3">
                        <h2 class="text-5xl font-serif italic text-lunen">
                            Menu Lainnya
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

                    <div
                        class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8"
                    >
                        <CardMenu
                            v-for="data in relatedMenus"
                            :key="data.kode_menu"
                            :menu="data"
                        />
                    </div>
                </div>
            </div>

            <div
                v-if="toast.show"
                class="fixed top-8 right-8 z-50 transform transition-all duration-300 ease-out"
                :class="{
                    'translate-x-0 opacity-100': toast.show,
                    'translate-x-full opacity-0': !toast.show,
                }"
            >
                <div
                    class="bg-white border shadow-lg p-6 max-w-sm"
                    :class="{
                        'border-green-200': toast.type === 'success',
                        'border-red-200': toast.type === 'error',
                    }"
                >
                    <div class="flex items-start">
                        <div class="flex-shrink-0 mr-4">
                            <div
                                class="w-8 h-8 rounded-full flex items-center justify-center"
                                :class="{
                                    'bg-green-100': toast.type === 'success',
                                    'bg-red-100': toast.type === 'error',
                                }"
                            >
                                <svg
                                    v-if="toast.type === 'success'"
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
                                <svg
                                    v-else
                                    class="w-5 h-5 text-red-600"
                                    fill="currentColor"
                                    viewBox="0 0 20 20"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1">
                            <h4
                                class="font-medium mb-1"
                                :class="{
                                    'text-green-900': toast.type === 'success',
                                    'text-red-900': toast.type === 'error',
                                }"
                            >
                                {{
                                    toast.type === "success"
                                        ? "Success"
                                        : "Error"
                                }}
                            </h4>
                            <p
                                class="text-sm"
                                :class="{
                                    'text-green-700': toast.type === 'success',
                                    'text-red-700': toast.type === 'error',
                                }"
                            >
                                {{ toast.message }}
                            </p>
                        </div>
                        <button
                            @click="toast.show = false"
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
        </section>
    </AppLayout>
</template>

<script setup lang="ts">
import { ref, reactive } from "vue";
import { Link, router } from "@inertiajs/vue3";
import { useCart } from "@/composables/useCart";
import { route } from "ziggy-js";
import { Category, Menu } from "@/types/menu";
import AppLayout from "@/Layouts/AppLayout.vue";
import CardMenu from "@/components/ui/CardMenu.vue";

const props = defineProps<{
    menu: Menu & { kategori: Category };
    relatedMenus: Menu[];
    auth: { user: any };
}>();

const { loading, error, addToCart } = useCart();

const quantity = ref(1);
const toast = reactive({
    show: false,
    message: "",
    type: "success" as "success" | "error",
});

// Methods
const formatPrice = (value: number) => {
    return new Intl.NumberFormat("id-ID").format(value);
};

const showToast = (message: string, type: "success" | "error" = "success") => {
    toast.message = message;
    toast.type = type;
    toast.show = true;
    setTimeout(() => {
        toast.show = false;
    }, 4000);
};

const increment = () => {
    if (quantity.value < 99) {
        quantity.value++;
    }
};

const decrement = () => {
    if (quantity.value > 1) {
        quantity.value--;
    }
};

const handleAddToCart = async () => {
    if (!props.auth.user) {
        router.get(route("login"));
        return;
    }
    const success = await addToCart(props.menu.kode_menu, quantity.value);
    if (success) {
        showToast(`"${props.menu.nama}" added to cart successfully!`);
    } else {
        showToast(error.value || "Failed to add item to cart.", "error");
    }
};

const handleRelatedAddToCart = async (kodeMenu: string) => {
    if (!props.auth.user) {
        router.get(route("login"));
        return;
    }
    const success = await addToCart(kodeMenu, 1);
    if (success) {
        showToast("Item added to cart successfully!");
    } else {
        showToast(error.value || "Failed to add item to cart.", "error");
    }
};
</script>
