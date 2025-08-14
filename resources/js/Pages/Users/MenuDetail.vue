<template>
    <AppLayout title="Detail">
        <section class="min-h-screen py-8 text-gray-800 pt-24">
            <div class="max-w-7xl mx-auto px-4">
                <!-- Coffee Shop Style Breadcrumb -->
                <nav class="mb-8" aria-label="Breadcrumb">
                    <div
                        class="flex items-center space-x-3 text-sm bg-white rounded-xl px-6 py-4 shadow-sm border border-stone-200"
                    >
                        <Link
                            href="/"
                            class="flex items-center hover:text-amber-800 transition-colors duration-200 font-medium text-stone-700"
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
                            Beranda
                        </Link>
                        <svg
                            class="w-4 h-4 text-stone-400"
                            fill="currentColor"
                            viewBox="0 0 20 20"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                clip-rule="evenodd"
                            />
                        </svg>
                        <Link
                            :href="route('menu.index')"
                            class="hover:text-amber-800 transition-colors duration-200 font-medium text-stone-700"
                            >Menu</Link
                        >
                        <svg
                            class="w-4 h-4 text-stone-400"
                            fill="currentColor"
                            viewBox="0 0 20 20"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                clip-rule="evenodd"
                            />
                        </svg>
                        <Link
                            :href="
                                route(
                                    'menu.category',
                                    menu.kategori.kode_kategori
                                )
                            "
                            class="hover:text-amber-800 transition-colors duration-200 font-medium text-stone-700"
                        >
                            {{ menu.kategori.nama }}
                        </Link>
                        <svg
                            class="w-4 h-4 text-stone-400"
                            fill="currentColor"
                            viewBox="0 0 20 20"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                clip-rule="evenodd"
                            />
                        </svg>
                        <span class="text-amber-900 font-semibold">{{
                            menu.nama
                        }}</span>
                    </div>
                </nav>

                <!-- Coffee Shop Product Detail Grid -->
                <div
                    class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start mb-16"
                >
                    <!-- Coffee Shop Style Product Image -->
                    <div class="space-y-6">
                        <div
                            class="relative bg-white rounded-2xl shadow-lg overflow-hidden border border-stone-200 transform hover:scale-[1.02] transition-transform duration-500 sticky top-8"
                        >
                            <div class="relative group">
                                <img
                                    :src="
                                        menu.path_img
                                            ? `/${menu.path_img}`
                                            : '/images/coffe.png'
                                    "
                                    :alt="menu.nama"
                                    class="w-full h-[500px] object-cover group-hover:scale-105 transition-transform duration-700 relative z-10"
                                />

                                <!-- Coffee Category Badge -->
                                <div class="absolute top-6 left-6 z-20">
                                    <span
                                        class="bg-coklat text-amber-50 px-4 py-2 rounded-full text-sm font-semibold shadow-md flex items-center space-x-2"
                                    >
                                        <svg
                                            class="w-4 h-4"
                                            fill="currentColor"
                                            viewBox="0 0 20 20"
                                        >
                                            <path
                                                d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"
                                            />
                                        </svg>
                                        <span>{{ menu.kategori.nama }}</span>
                                    </span>
                                </div>

                                <!-- Coffee Steam Effect -->
                                <div class="absolute bottom-4 right-4 z-20">
                                    <div class="flex space-x-1">
                                        <div
                                            class="w-1 h-8 bg-stone-300 rounded-full opacity-60 animate-pulse"
                                            style="animation-delay: 0s"
                                        ></div>
                                        <div
                                            class="w-1 h-6 bg-stone-400 rounded-full opacity-70 animate-pulse"
                                            style="animation-delay: 0.2s"
                                        ></div>
                                        <div
                                            class="w-1 h-10 bg-stone-300 rounded-full opacity-60 animate-pulse"
                                            style="animation-delay: 0.4s"
                                        ></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Coffee Shop Style Product Info -->
                    <div
                        class="bg-white rounded-2xl p-6 px-6 shadow-lg border border-stone-200 h-full relative overflow-hidden"
                    >
                        <div class="space-y-8 relative">
                            <!-- Coffee Shop Title & Price -->
                            <div
                                class="space-y-4 border-b border-stone-100 pb-6"
                            >
                                <h1
                                    class="text-4xl font-bold text-coklat mb-2 leading-tight"
                                >
                                    {{ menu.nama }}
                                </h1>
                                <div class="flex items-center justify-between">
                                    <div
                                        class="text-3xl font-bold text-stone-800"
                                    >
                                        Rp {{ formatPrice(menu.harga) }}
                                    </div>
                                </div>
                            </div>

                            <!-- Coffee Description with Cup Icon -->
                            <div
                                class="bg-amber-50 rounded-xl p-4 border border-amber-200 relative"
                            >
                                <p
                                    class="text-stone-700 leading-relaxed text-base"
                                >
                                    {{
                                        menu.deskripsi ||
                                        "Minuman lezat yang dibuat dengan penuh keahlian oleh barista kami. Sempurna untuk dinikmati kapan saja."
                                    }}
                                </p>
                            </div>

                            <!-- Coffee Shop Purchase Section -->
                            <div
                                v-if="menu.jumlah > 0"
                                class="space-y-4 bg-stone-50 rounded-xl p-6 border border-stone-200"
                            >
                                <!-- Total Price Display -->
                                <div
                                    class="bg-white rounded-lg p-4 shadow-sm border border-stone-200"
                                >
                                    <div
                                        class="flex items-center justify-between"
                                    >
                                        <div>
                                            <span
                                                class="text-sm text-stone-600 font-medium block"
                                                >Total Harga</span
                                            >
                                            <span
                                                class="text-2xl font-bold text-amber-900"
                                            >
                                                Rp
                                                {{
                                                    formatPrice(
                                                        menu.harga * quantity
                                                    )
                                                }}
                                            </span>
                                        </div>
                                        <div
                                            class="flex items-center bg-white rounded-lg shadow-sm border border-stone-300 overflow-hidden"
                                        >
                                            <button
                                                @click="decrement"
                                                class="px-4 py-3 text-stone-600 hover:bg-amber-800 hover:text-white transition-all duration-200 font-bold text-lg border-r border-stone-300"
                                            >
                                                −
                                            </button>
                                            <input
                                                type="number"
                                                v-model="quantity"
                                                min="1"
                                                :max="menu.jumlah"
                                                class="w-16 text-center border-0 focus:ring-0 text-amber-900 font-bold text-lg py-3 bg-stone-50"
                                            />
                                            <button
                                                @click="increment"
                                                class="px-4 py-3 text-stone-600 hover:bg-amber-800 hover:text-white transition-all duration-200 font-bold text-lg border-l border-stone-300"
                                            >
                                                +
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <button
                                    @click="handleAddToCart"
                                    :disabled="loading"
                                    class="w-full hovertext-white py-4 px-8 rounded-lg font-semibold text-lg transition-all duration-300 shadow-md hover:shadow-lg transform hover:scale-[1.02] disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none flex items-center justify-center space-x-3 group bg-coklat text-slate-50"
                                >
                                    <svg
                                        class="w-6 h-6 group-hover:animate-bounce"
                                        fill="currentColor"
                                        viewBox="0 0 20 20"
                                    >
                                        <path
                                            d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"
                                        />
                                    </svg>
                                    <span
                                        v-if="loading"
                                        class="flex items-center"
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
                                        Menambahkan...
                                    </span>
                                    <span v-else>TAMBAHKAN KE KERANJANG</span>
                                </button>
                            </div>
                            <div
                                v-else
                                class="bg-stone-100 rounded-xl p-6 border border-stone-300"
                            >
                                <button
                                    disabled
                                    class="w-full bg-stone-400 text-stone-600 py-4 px-8 rounded-lg font-semibold text-lg cursor-not-allowed flex items-center justify-center space-x-2 border-2 border-stone-500"
                                >
                                    <svg
                                        class="w-6 h-6"
                                        fill="currentColor"
                                        viewBox="0 0 20 20"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            d="M13.477 14.89A6 6 0 015.11 6.524l8.367 8.368zm1.414-1.414L6.524 5.11a6 6 0 018.367 8.367zM18 10a8 8 0 11-16 0 8 8 0 0116 0z"
                                            clip-rule="evenodd"
                                        />
                                    </svg>
                                    <span>SAAT INI TIDAK TERSEDIA</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Coffee Shop Related Products -->
                <div v-if="relatedMenus.length > 0" class="space-y-10">
                    <div class="text-center relative">
                        <!-- Coffee Bean Decorative Line -->
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
                        <h2 class="text-4xl italic text-slate-50 my-3">
                            Menu Pilihan Lainnya
                        </h2>
                        <p class="text-slate-100 text-lg max-w-2xl mx-auto">
                            Eksplorasi rasa istimewa lainnya dari koleksi kopi
                            premium kami
                        </p>
                    </div>

                    <div
                        class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8"
                    >
                        <CardMenu
                            v-for="menu in relatedMenus"
                            :key="menu.kode_menu"
                            :menu="menu"
                        />
                    </div>
                </div>
            </div>

            <!-- Coffee Shop Toast Notification -->
            <div
                v-if="toast.show"
                :class="
                    toast.type === 'success'
                        ? 'bg-emerald-800 border-emerald-600'
                        : 'bg-red-800 border-red-600'
                "
                class="fixed top-6 right-6 text-white px-6 py-4 rounded-xl shadow-lg z-50 transition-all duration-500 transform border-2"
                :style="{
                    transform: toast.show
                        ? 'translateX(0) translateY(0)'
                        : 'translateX(120%) translateY(-20px)',
                    opacity: toast.show ? 1 : 0,
                }"
            >
                <div class="flex items-center space-x-3">
                    <svg
                        v-if="toast.type === 'success'"
                        class="w-5 h-5"
                        fill="currentColor"
                        viewBox="0 0 20 20"
                    >
                        <path
                            fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd"
                        />
                    </svg>
                    <svg
                        v-else
                        class="w-5 h-5"
                        fill="currentColor"
                        viewBox="0 0 20 20"
                    >
                        <path
                            fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                            clip-rule="evenodd"
                        />
                    </svg>
                    <span class="font-semibold">{{ toast.message }}</span>
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

// --- METHODS ---
const formatPrice = (value: number) => {
    return new Intl.NumberFormat("id-ID").format(value);
};

const showToast = (message: string, type: "success" | "error" = "success") => {
    toast.message = message;
    toast.type = type;
    toast.show = true;
    setTimeout(() => {
        toast.show = false;
    }, 3000);
};

const increment = () => {
    if (quantity.value < props.menu.jumlah) {
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
        showToast(`"${props.menu.nama}" ditambahkan ke keranjang!`);
    } else {
        showToast(error.value || "Gagal menambahkan item.", "error");
    }
};

const handleRelatedAddToCart = async (kodeMenu: string) => {
    if (!props.auth.user) {
        router.get(route("login"));
        return;
    }
    const success = await addToCart(kodeMenu, 1);
    if (success) {
        showToast("Item ditambahkan ke keranjang!");
    } else {
        showToast(error.value || "Gagal menambahkan item.", "error");
    }
};
</script>
