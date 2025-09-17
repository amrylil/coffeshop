<script setup lang="ts">
import { ref, computed } from "vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import DataTable from "@/components/ui/DataTable.vue";
type TransaksiStatus =
    | "pending"
    | "dikonfirmasi"
    | "dikirim"
    | "selesai"
    | "ditolak"
    | "paid"
    | "failed"
    | "cancelled";

interface User {
    id: number;
    name: string;
    email: string;
}

interface ItemTransaksi {
    id: number;
    transaksi_id: string;
}

interface Transaksi {
    kode_transaksi: string;
    user_id: number;
    order_id_midtrans: string | null;
    total_harga: number;
    status: TransaksiStatus;
    catatan: string | null;
    created_at: string;
    pengguna: User;
    items: ItemTransaksi[];
    alasan_penolakan?: string | null;
}

interface Props {
    transaksis: Transaksi[];
    flash?: {
        success?: string;
    };
    errors?: Record<string, string>;
}

// --- PROPS ---
const props = defineProps<Props>();

// --- DATA TABLE CONFIGURATION ---
// Define headers for the DataTable component
const tableHeaders = ref([
    { key: "customer", label: "Customer" },
    { key: "items", label: "Total Items" },
    { key: "total_harga", label: "Harga Total" },
    { key: "status", label: "Status" },
    { key: "created_at", label: "Tanggal" },
]);

// Define which keys the DataTable's search bar should look at
const searchKeys = ref(["kode_transaksi", "status"]);

// --- STATE MANAGEMENT (Unchanged) ---
const isStatusModalOpen = ref(false);
const selectedTransaction = ref<Transaksi | null>(null);

const form = useForm({
    status: "" as TransaksiStatus | "",
    alasan_penolakan: "",
});

// --- COMPUTED PROPERTIES (Unchanged) ---
const statusColors = computed(() => ({
    pending:
        "bg-yellow-100 text-yellow-800 border-yellow-200 hover:bg-yellow-200",
    dikonfirmasi: "bg-blue-100 text-blue-800 border-blue-200 hover:bg-blue-200",
    dikirim:
        "bg-purple-100 text-purple-800 border-purple-200 hover:bg-purple-200",
    selesai: "bg-green-100 text-green-800 border-green-200 hover:bg-green-200",
    ditolak: "bg-red-100 text-red-800 border-red-200 hover:bg-red-200",
    paid: "bg-green-100 text-green-800 border-green-200 hover:bg-green-200",
    failed: "bg-red-100 text-red-800 border-red-200 hover:bg-red-200",
    cancelled: "bg-gray-100 text-gray-800 border-gray-200 hover:bg-gray-200",
}));

// --- METHODS (Unchanged) ---
const openStatusModal = (transaksi: Transaksi) => {
    selectedTransaction.value = transaksi;
    form.status = transaksi.status;
    form.alasan_penolakan = transaksi.alasan_penolakan || "";
    isStatusModalOpen.value = true;
};

const closeStatusModal = () => {
    isStatusModalOpen.value = false;
    selectedTransaction.value = null;
    form.reset();
    form.clearErrors();
};

const updateStatus = () => {
    if (!selectedTransaction.value) return;
    form.patch(
        `/admin/transaksi/${selectedTransaction.value.kode_transaksi}/update-status`,
        {
            preserveScroll: true,
            onSuccess: () => closeStatusModal(),
        }
    );
};

const formatCurrency = (value: number) => {
    return new Intl.NumberFormat("id-ID", {
        style: "currency",
        currency: "IDR",
        minimumFractionDigits: 0,
    }).format(value);
};

const formatDate = (dateString: string) => {
    const options: Intl.DateTimeFormatOptions = {
        day: "numeric",
        month: "short",
        year: "numeric",
    };
    return new Date(dateString).toLocaleDateString("id-ID", options);
};
</script>

<template>
    <Head title="Transaction Management" />

    <AdminLayout>
        <div class="bg-gray-50 min-h-screen py-8 px-4 sm:px-6 lg:px-8 pt-20">
            <div class="max-w-7xl mx-auto">
                <div class="mb-8">
                    <div
                        class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-[#6F4E37]"
                    >
                        <div class="flex justify-between items-center">
                            <div>
                                <h1
                                    class="text-3xl font-bold text-[#6F4E37] mb-2"
                                >
                                    Transaction Management
                                </h1>
                                <p class="text-gray-600">
                                    Kelola semua transaksi pelanggan dengan
                                    mudah
                                </p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm text-gray-500">
                                    Total Transaksi
                                </p>
                                <p class="text-2xl font-bold text-[#6F4E37]">
                                    {{ transaksis.length }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div
                    v-if="flash?.success"
                    class="mb-6 p-4 bg-gradient-to-r from-green-50 to-green-100 border border-green-200 rounded-lg shadow-sm"
                ></div>
                <div
                    v-if="errors && Object.keys(errors).length > 0"
                    class="mb-6 p-4 bg-gradient-to-r from-red-50 to-red-100 border border-red-200 rounded-lg shadow-sm"
                ></div>

                <DataTable
                    :headers="tableHeaders"
                    :items="transaksis"
                    :search-keys="searchKeys"
                >
                    <template #cell(customer)="{ item }">
                        <span class="font-medium text-gray-900">{{
                            item.pengguna?.name ?? "N/A"
                        }}</span>
                    </template>

                    <template #cell(items)="{ item }">
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800"
                        >
                            {{ item.items.length }} item(s)
                        </span>
                    </template>

                    <template #cell(total_harga)="{ item }">
                        <span class="font-bold text-green-600">{{
                            formatCurrency(item.total_harga)
                        }}</span>
                    </template>

                    <template #cell(status)="{ item }">
                        <button
                            @click="openStatusModal(item)"
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border cursor-pointer transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        >
                            <svg
                                class="w-3 h-3 mr-1"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                                ></path>
                            </svg>
                            <span class="capitalize">{{ item.status }}</span>
                        </button>
                    </template>

                    <template #cell(created_at)="{ item }">
                        <span class="text-gray-600">{{
                            formatDate(item.created_at)
                        }}</span>
                    </template>

                    <template #actions="{ item }">
                        <Link
                            :href="`/admin/transaksi/${item.kode_transaksi}`"
                            class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        >
                            <svg
                                class="w-3 h-3 mr-1"
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
                            View
                        </Link>
                        <Link
                            :href="`/admin/transaksi/${item.kode_transaksi}/edit`"
                            class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500"
                        >
                            <svg
                                class="w-3 h-3 mr-1"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                                ></path>
                            </svg>
                            Edit
                        </Link>
                    </template>
                </DataTable>
            </div>
        </div>

        <div
            v-if="isStatusModalOpen"
            class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 flex items-center justify-center"
            @click.self="closeStatusModal"
        ></div>
    </AdminLayout>
</template>
