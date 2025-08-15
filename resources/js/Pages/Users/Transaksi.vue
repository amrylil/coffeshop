<script setup lang="ts">
import { Link, usePage } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue"; // Adjust the path to your layout
import { route } from "ziggy-js";
import { Menu } from "@/types/menu";

// Defines the structure for a single transaction item
interface Transaksi {
    kode_transaksi: string;
    menu: Menu | null; // Assuming backend prepares a primary menu item for display
    tanggal_transaksi: string; // Assuming this is passed from the controller (e.g., from created_at)
    status: string;
    total_harga: number;
}

// Defines the structure for a pagination link
interface PaginationLink {
    url: string | null;
    label: string;
    active: boolean;
}

// Defines the props structure, including the paginated transactions
const props = defineProps<{
    transaksis: {
        data: Transaksi[];
        links: PaginationLink[];
    };
}>();

// --- Helper Functions ---

// Helper function to format currency to Indonesian Rupiah
const formatCurrency = (value: number) => {
    return new Intl.NumberFormat("id-ID", {
        style: "currency",
        currency: "IDR",
        minimumFractionDigits: 0,
    }).format(value);
};

// Helper function to format date and time
const formatDateTime = (dateString: string) => {
    const options: Intl.DateTimeFormatOptions = {
        weekday: "long",
        day: "numeric",
        month: "long",
        year: "numeric",
        hour: "2-digit",
        minute: "2-digit",
    };
    return new Date(dateString).toLocaleDateString("id-ID", options);
};
</script>

<template>
    <AppLayout title="Transaksi Saya">
        <div class="min-h-screen bg-gradient-to-br from-amber-50 to-orange-100">
            <div class="container mx-auto px-4 py-8 pt-20">
                <div class="text-center mb-8">
                    <h1 class="text-4xl font-bold text-amber-900 mb-2">
                        Transaksi Saya
                    </h1>
                    <p class="text-amber-700">
                        Riwayat transaksi pembelian kopi
                    </p>
                    <div
                        class="w-24 h-1 bg-amber-600 mx-auto mt-4 rounded-full"
                    ></div>
                </div>

                <div class="max-w-6xl mx-auto">
                    <!-- Transaction List -->
                    <div v-if="transaksis.data.length > 0">
                        <div class="space-y-6">
                            <div
                                v-for="item in transaksis.data"
                                :key="item.kode_transaksi"
                                class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300"
                            >
                                <div class="flex items-center p-6">
                                    <div class="flex-shrink-0 mr-6">
                                        <div
                                            class="w-20 h-20 bg-gradient-to-br from-amber-600 to-orange-500 rounded-2xl flex items-center justify-center shadow-inner"
                                        >
                                            <svg
                                                class="w-10 h-10 text-white"
                                                fill="currentColor"
                                                viewBox="0 0 20 20"
                                            >
                                                <path
                                                    d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4zM18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z"
                                                />
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="flex-grow">
                                        <div
                                            class="flex justify-between items-start"
                                        >
                                            <div class="flex-grow">
                                                <h3
                                                    class="font-bold text-amber-900 text-xl mb-2"
                                                >
                                                    {{
                                                        item.menu?.nama ??
                                                        "Menu Tidak Ditemukan"
                                                    }}
                                                </h3>
                                                <p
                                                    class="text-gray-600 text-sm mb-3"
                                                >
                                                    {{
                                                        formatDateTime(
                                                            item.tanggal_transaksi
                                                        )
                                                    }}
                                                </p>
                                            </div>
                                            <div
                                                class="text-right flex-shrink-0 ml-6"
                                            >
                                                <div
                                                    :class="[
                                                        'px-4 py-2 rounded-xl font-bold text-sm mb-3 capitalize',

                                                        item.status,
                                                    ]"
                                                >
                                                    {{ item.status }}
                                                </div>
                                                <div
                                                    class="text-amber-800 font-bold text-xl mb-3"
                                                >
                                                    {{
                                                        formatCurrency(
                                                            item.total_harga
                                                        )
                                                    }}
                                                </div>
                                                <Link
                                                    :href="
                                                        route(
                                                            'transaksi.show',
                                                            item.kode_transaksi
                                                        )
                                                    "
                                                    class="inline-flex items-center px-4 py-2 bg-amber-600 text-white font-semibold text-sm rounded-lg hover:bg-amber-700"
                                                >
                                                    <svg
                                                        class="w-4 h-4 mr-2"
                                                        fill="none"
                                                        stroke="currentColor"
                                                        viewBox="0 0 24 24"
                                                    >
                                                        <path
                                                            stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                                                        ></path>
                                                        <path
                                                            stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                                                        ></path>
                                                    </svg>
                                                    Lihat Detail
                                                </Link>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pagination -->
                        <div
                            v-if="transaksis.links.length > 3"
                            class="mt-8 flex justify-center"
                        >
                            <div class="flex rounded-lg shadow-sm">
                                <template
                                    v-for="(link, key) in transaksis.links"
                                    :key="key"
                                >
                                    <div
                                        v-if="link.url === null"
                                        class="px-4 py-3 bg-white border text-sm font-medium text-gray-400 cursor-default"
                                        v-html="link.label"
                                    />
                                    <Link
                                        v-else
                                        :href="link.url"
                                        class="px-4 py-3 bg-white border text-sm font-medium"
                                        :class="{
                                            'bg-amber-600 text-white border-amber-600':
                                                link.active,
                                            'text-gray-700 hover:bg-gray-50':
                                                !link.active,
                                        }"
                                        v-html="link.label"
                                    />
                                </template>
                            </div>
                        </div>
                    </div>

                    <!-- Empty State -->
                    <div v-else class="max-w-md mx-auto text-center">
                        <div class="bg-white rounded-2xl shadow-lg p-12">
                            <div
                                class="w-24 h-24 bg-amber-600 rounded-full flex items-center justify-center mx-auto mb-6"
                            >
                                <svg
                                    class="w-12 h-12 text-white"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                                    ></path>
                                </svg>
                            </div>
                            <h2 class="text-2xl font-bold text-amber-900 mb-4">
                                Tidak Ada Transaksi
                            </h2>
                            <p class="text-amber-700 mb-8">
                                Anda belum pernah melakukan transaksi.
                            </p>
                            <Link
                                :href="route('menu.index')"
                                class="inline-flex items-center px-8 py-4 bg-amber-600 hover:bg-amber-700 text-white font-bold rounded-xl shadow-lg"
                            >
                                <svg
                                    class="w-5 h-5 mr-2"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                                    ></path>
                                </svg>
                                Jelajahi Menu Kopi
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
