<script setup lang="ts">
import { ref, computed } from "vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import DataTable from "@/components/ui/DataTable.vue"; // Assuming this is the path to your DataTable

// --- TYPE DEFINITIONS for Dummy Data ---
type TransaksiStatus =
    | "pending"
    | "dikonfirmasi"
    | "dikirim"
    | "selesai"
    | "ditolak";

interface User {
    name: string;
    email: string;
    transaksi_count?: number;
}

interface MenuTerlaris {
    nama: string;
    jumlah_terjual: number;
}

interface Transaksi {
    kode_transaksi: string;
    email: string;
    menu: { nama: string };
    jumlah: number;
    harga_total: number;
    status: TransaksiStatus;
    tanggal_transaksi: string;
}

interface PaginatedResponse<T> {
    data: T[];
    links: { url: string | null; label: string; active: boolean }[];
    first_item: number;
    last_item: number;
    total: number;
}

// Props structure expected from the controller
interface Props {
    transaksi: PaginatedResponse<Transaksi>;
    userTerbanyakTransaksi: User | null;
    menuTerlaris: MenuTerlaris[];
    filters: {
        status: string | null;
        tanggal_mulai: string | null;
        tanggal_akhir: string | null;
    };
}

// --- PROPS with DUMMY DATA ---
// Using `withDefaults` to make the component runnable with dummy data
const props = withDefaults(defineProps<Props>(), {
    transaksi: () => ({
        data: [
            {
                kode_transaksi: "TRX20250917A",
                email: "johndoe@example.com",
                menu: { nama: "Espresso" },
                jumlah: 2,
                harga_total: 50000,
                status: "selesai",
                tanggal_transaksi: "2025-09-17T10:00:00Z",
            },
            {
                kode_transaksi: "TRX20250917B",
                email: "jane.smith@example.com",
                menu: { nama: "Cappuccino" },
                jumlah: 1,
                harga_total: 35000,
                status: "pending",
                tanggal_transaksi: "2025-09-17T09:30:00Z",
            },
            {
                kode_transaksi: "TRX20250916C",
                email: "johndoe@example.com",
                menu: { nama: "Latte" },
                jumlah: 3,
                harga_total: 105000,
                status: "dikonfirmasi",
                tanggal_transaksi: "2025-09-16T15:00:00Z",
            },
        ],
        links: [
            { url: null, label: "&laquo; Previous", active: false },
            { url: "/?page=1", label: "1", active: true },
            { url: null, label: "Next &raquo;", active: false },
        ],
        first_item: 1,
        last_item: 3,
        total: 3,
    }),
    userTerbanyakTransaksi: () => ({
        name: "John Doe",
        email: "johndoe@example.com",
        transaksi_count: 2,
    }),
    menuTerlaris: () => [
        { nama: "Latte", jumlah_terjual: 3 },
        { nama: "Espresso", jumlah_terjual: 2 },
        { nama: "Cappuccino", jumlah_terjual: 1 },
    ],
    filters: () => ({ status: null, tanggal_mulai: null, tanggal_akhir: null }),
});

// --- FILTER & EXPORT FORM ---
const filterForm = useForm({
    status: props.filters.status || "",
    tanggal_mulai: props.filters.tanggal_mulai || "",
    tanggal_akhir: props.filters.tanggal_akhir || "",
});

const submitFilter = () => {
    // In a real app, this sends a GET request to the current URL with filter params
    filterForm.get("/admin/transaksi/report", {
        preserveState: true,
        preserveScroll: true,
    });
};

// Computed property to build the export URL dynamically
const exportUrl = computed(() => {
    const params = new URLSearchParams({
        status: filterForm.status,
        tanggal_mulai: filterForm.tanggal_mulai,
        tanggal_akhir: filterForm.tanggal_akhir,
    }).toString();
    return `/admin/transaksi/export?${params}`;
});

// --- DATA TABLE CONFIG ---
const tableHeaders = ref([
    { key: "kode_transaksi", label: "Kode Transaksi" },
    { key: "email", label: "Email User" },
    { key: "menu", label: "Menu" },
    { key: "jumlah", label: "Jumlah" },
    { key: "harga_total", label: "Harga Total" },
    { key: "status", label: "Status" },
    { key: "tanggal", label: "Tanggal" },
]);

// --- HELPERS ---
const formatCurrency = (value: number) =>
    new Intl.NumberFormat("id-ID", {
        style: "currency",
        currency: "IDR",
        minimumFractionDigits: 0,
    }).format(value);
const formatDate = (dateString: string) =>
    new Date(dateString).toLocaleDateString("id-ID", {
        day: "numeric",
        month: "short",
        year: "numeric",
        hour: "2-digit",
        minute: "2-digit",
    });

const statusConfig: Record<TransaksiStatus, { bg: string; text: string }> = {
    pending: { bg: "bg-yellow-100", text: "text-yellow-800" },
    dikonfirmasi: { bg: "bg-blue-100", text: "text-blue-800" },
    selesai: { bg: "bg-green-100", text: "text-green-800" },
    dikirim: { bg: "bg-purple-100", text: "text-purple-800" },
    ditolak: { bg: "bg-red-100", text: "text-red-800" },
};
</script>

<template>
    <Head title="Laporan Transaksi" />

    <AdminLayout>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 pt-20">
            <div
                class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8"
            >
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">
                        Laporan Transaksi
                    </h1>
                    <p class="text-gray-600">
                        Kelola dan pantau semua transaksi sistem
                    </p>
                </div>
                <div class="mt-4 sm:mt-0">
                    <span
                        class="inline-flex items-center px-4 py-2 bg-blue-100 text-blue-800 text-sm font-medium rounded-full"
                    >
                        <svg
                            class="w-4 h-4 mr-2"
                            fill="currentColor"
                            viewBox="0 0 20 20"
                        >
                            <path
                                d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"
                            />
                        </svg>
                        Total: {{ transaksi.total ?? 0 }} transaksi
                    </span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div
                    class="bg-white rounded-xl shadow-lg border border-gray-200 p-6"
                >
                    <div class="flex items-center mb-4">
                        <div class="p-3 rounded-full bg-orange-100">
                            <svg
                                class="w-6 h-6 text-orange-600"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                                ></path>
                            </svg>
                        </div>
                        <h3 class="ml-4 text-lg font-semibold text-gray-800">
                            Pelanggan Paling Aktif
                        </h3>
                    </div>
                    <div v-if="userTerbanyakTransaksi">
                        <p class="text-2xl font-bold text-gray-900">
                            {{ userTerbanyakTransaksi.name }}
                        </p>
                        <p class="text-sm text-gray-500">
                            {{ userTerbanyakTransaksi.email }}
                        </p>
                        <div class="mt-2 text-base text-gray-700">
                            <span class="font-bold text-orange-600">{{
                                userTerbanyakTransaksi.transaksi_count
                            }}</span>
                            transaksi
                        </div>
                    </div>
                    <p v-else class="text-gray-500">Tidak ada data pengguna.</p>
                </div>

                <div
                    class="bg-white rounded-xl shadow-lg border border-gray-200 p-6 md:col-span-2"
                >
                    <div class="flex items-center mb-4">
                        <div class="p-3 rounded-full bg-teal-100">
                            <svg
                                class="w-6 h-6 text-teal-600"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"
                                ></path>
                            </svg>
                        </div>
                        <h3 class="ml-4 text-lg font-semibold text-gray-800">
                            Top 3 Menu Terlaris
                        </h3>
                    </div>
                    <ul v-if="menuTerlaris.length > 0" class="space-y-3">
                        <li
                            v-for="(menu, index) in menuTerlaris"
                            :key="menu.nama"
                            class="flex items-center justify-between"
                        >
                            <span class="font-medium text-gray-800"
                                >{{ index + 1 }}. {{ menu.nama }}</span
                            >
                            <span
                                class="text-sm font-semibold text-teal-800 bg-teal-100 px-3 py-1 rounded-full"
                                >{{ menu.jumlah_terjual ?? 0 }} terjual</span
                            >
                        </li>
                    </ul>
                    <p v-else class="text-gray-500">
                        Tidak ada data menu terlaris.
                    </p>
                </div>
            </div>

            <div
                class="bg-white rounded-xl shadow-lg border border-gray-200 mb-8"
            >
                <div class="bg-[#6F4E37] text-white px-6 py-4 rounded-t-xl">
                    <div class="flex items-center">
                        <svg
                            class="w-5 h-5 mr-2"
                            fill="currentColor"
                            viewBox="0 0 20 20"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z"
                                clip-rule="evenodd"
                            />
                        </svg>
                        <h3 class="text-lg font-semibold">
                            Filter & Export Data
                        </h3>
                    </div>
                </div>
                <div class="p-6">
                    <form @submit.prevent="submitFilter">
                        <div
                            class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6"
                        >
                            <div>
                                <label
                                    for="status"
                                    class="block text-sm font-medium text-gray-700 mb-2"
                                    >Status Transaksi</label
                                >
                                <select
                                    v-model="filterForm.status"
                                    id="status"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                >
                                    <option value="">🔍 Semua Status</option>
                                    <option value="pending">⏳ Pending</option>
                                    <option value="dikonfirmasi">
                                        ✅ Dikonfirmasi
                                    </option>
                                    <option value="selesai">🎉 Selesai</option>
                                    <option value="dikirim">🚚 Dikirim</option>
                                    <option value="ditolak">❌ Ditolak</option>
                                </select>
                            </div>
                            <div>
                                <label
                                    for="tanggal_mulai"
                                    class="block text-sm font-medium text-gray-700 mb-2"
                                    >Tanggal Mulai</label
                                >
                                <input
                                    v-model="filterForm.tanggal_mulai"
                                    type="date"
                                    id="tanggal_mulai"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                />
                            </div>
                            <div>
                                <label
                                    for="tanggal_akhir"
                                    class="block text-sm font-medium text-gray-700 mb-2"
                                    >Tanggal Akhir</label
                                >
                                <input
                                    v-model="filterForm.tanggal_akhir"
                                    type="date"
                                    id="tanggal_akhir"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                />
                            </div>
                            <div class="flex flex-col gap-3">
                                <label
                                    class="block text-sm font-medium text-gray-700 mb-2"
                                    >Aksi</label
                                >
                                <button
                                    type="submit"
                                    class="flex items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200"
                                >
                                    <svg
                                        class="w-4 h-4 mr-2"
                                        fill="currentColor"
                                        viewBox="0 0 20 20"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                            clip-rule="evenodd"
                                        />
                                    </svg>
                                    Filter Data
                                </button>
                                <a
                                    :href="exportUrl"
                                    class="flex items-center justify-center px-6 py-3 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200"
                                >
                                    <svg
                                        class="w-4 h-4 mr-2"
                                        fill="currentColor"
                                        viewBox="0 0 20 20"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                            clip-rule="evenodd"
                                        />
                                    </svg>
                                    Export CSV
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <DataTable
                :headers="tableHeaders"
                :items="transaksi.data"
                :search-keys="['kode_transaksi', 'email']"
            >
                <template #cell(kode_transaksi)="{ item }">
                    <span
                        class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800 font-mono"
                        >{{ item.kode_transaksi }}</span
                    >
                </template>

                <template #cell(menu)="{ item }">
                    <span class="font-medium text-gray-800">{{
                        item.menu.nama
                    }}</span>
                </template>

                <template #cell(jumlah)="{ item }">
                    <span
                        class="inline-flex items-center justify-center w-8 h-8 rounded-full font-medium bg-blue-100 text-blue-800"
                        >{{ item.jumlah }}x</span
                    >
                </template>

                <template #cell(harga_total)="{ item }">
                    <span class="font-bold text-green-600 text-right block">{{
                        formatCurrency(item.harga_total)
                    }}</span>
                </template>

                <template #cell(status)="{ item }">
                    <span
                        class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium"
                    >
                        {{
                            item.status.charAt(0).toUpperCase() +
                            item.status.slice(1)
                        }}
                    </span>
                </template>

                <template #cell(tanggal)="{ item }">
                    <span class="text-gray-600">{{
                        formatDate(item.tanggal_transaksi)
                    }}</span>
                </template>

                <template #actions>
                    <span>-</span>
                </template>
            </DataTable>

            <div v-if="transaksi.links.length > 3" class="mt-6">
                <div
                    class="flex flex-col sm:flex-row justify-between items-center"
                >
                    <div class="text-sm text-gray-700 mb-4 sm:mb-0">
                        Menampilkan
                        <span class="font-medium">{{
                            transaksi.first_item ?? 0
                        }}</span>
                        sampai
                        <span class="font-medium">{{
                            transaksi.last_item ?? 0
                        }}</span>
                        dari
                        <span class="font-medium">{{ transaksi.total }}</span>
                        data
                    </div>
                    <nav
                        class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px"
                    >
                        <template
                            v-for="(link, index) in transaksi.links"
                            :key="index"
                        >
                            <span
                                v-if="!link.url"
                                class="relative inline-flex items-center px-4 py-2 border text-sm font-medium bg-white border-gray-300 text-gray-400 cursor-default"
                                :class="{
                                    'rounded-l-md': index === 0,
                                    'rounded-r-md':
                                        index === transaksi.links.length - 1,
                                }"
                                v-html="link.label"
                            />
                            <Link
                                v-else
                                :href="link.url"
                                class="relative inline-flex items-center px-4 py-2 border text-sm font-medium"
                                :class="{
                                    'z-10 bg-indigo-50 border-indigo-500 text-indigo-600':
                                        link.active,
                                    'bg-white border-gray-300 text-gray-500 hover:bg-gray-50':
                                        !link.active,
                                    'rounded-l-md': index === 0,
                                    'rounded-r-md':
                                        index === transaksi.links.length - 1,
                                }"
                                v-html="link.label"
                            />
                        </template>
                    </nav>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
