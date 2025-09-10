<script setup lang="ts">
import { Head, Link, usePage, useForm, router } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { computed, ref } from "vue";
import { Meja, MejaStats, PageProps } from "@/types/meja";
import { route } from "ziggy-js";
import ModalForm from "@/components/ui/ModalForm.vue";
import DataTable from "@/components/ui/DataTable.vue";

const props = defineProps<{
    mejas: Meja[];
    stats: MejaStats;
}>();

const page = usePage<PageProps>();
const successMessage = computed(() => page.props.flash?.success);
const errorMessage = computed(() => page.props.flash?.error);

// State untuk modal dan form (Tidak ada perubahan di sini)
const isModalOpen = ref(false);
const editingMeja = ref<Meja | null>(null);
const form = useForm({
    _method: "POST",
    nomor_meja: "",
    kapasitas: 1,
    status: "kosong" as Meja["status"],
});
const openCreateModal = () => {
    /* ... (fungsi tetap sama) */
};
const openEditModal = (meja: Meja) => {
    /* ... (fungsi tetap sama) */
};
const closeModal = () => {
    /* ... (fungsi tetap sama) */
};
const submitForm = () => {
    /* ... (fungsi tetap sama) */
};
const updateStatus = (meja: Meja, event: Event) => {
    /* ... (fungsi tetap sama) */
};
const statusClasses = (status: Meja["status"]) => {
    /* ... (fungsi tetap sama) */
};

// --- 2. TAMBAHKAN KONFIGURASI UNTUK DATATABLE ---
const tableHeaders = [
    { key: "nomor_meja", label: "Table Number" },
    { key: "kapasitas", label: "Capacity" },
    { key: "status", label: "Status" },
];

const searchKeys = ["nomor_meja", "status"];
</script>

<template>
    <Head title="Table Management" />
    <AdminLayout>
        <div class="py-8 px-4 sm:px-6 lg:px-8">
            <div class="max-w-7xl mx-auto">
                <header class="mb-8">
                    <div
                        class="flex flex-col sm:flex-row justify-between items-start gap-4 mb-4"
                    >
                        <div>
                            <h1 class="text-3xl font-bold text-[#6F4E37]">
                                Table Management
                            </h1>
                            <p class="text-gray-600">
                                Manage your restaurant tables efficiently.
                            </p>
                        </div>
                        <button
                            @click="openCreateModal"
                            class="px-5 py-2.5 bg-[#6F4E37] text-white rounded-lg hover:bg-[#5D4037] transition duration-200 shadow-md flex items-center gap-2"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                            <span>Add New Table</span>
                        </button>
                    </div>
                    <div
                        class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4"
                    ></div>
                </header>

                <div
                    v-if="successMessage"
                    class="mb-6 p-4 bg-green-100 border border-green-200 text-green-800 rounded-lg shadow-sm"
                >
                    {{ successMessage }}
                </div>
                <div
                    v-if="errorMessage"
                    class="mb-6 p-4 bg-red-100 border border-red-200 text-red-800 rounded-lg shadow-sm"
                >
                    {{ errorMessage }}
                </div>

                <DataTable
                    :headers="tableHeaders"
                    :items="mejas"
                    :search-keys="searchKeys"
                >
                    <template #cell(status)="{ item }">
                        <select
                            :value="item.status"
                            @change="updateStatus(item, $event)"
                            class="px-3 py-1 rounded-full text-sm font-medium border-0 focus:ring-2 focus:ring-[#6F4E37] cursor-pointer appearance-none"
                            :class="statusClasses(item.status)"
                        >
                            <option value="kosong">Kosong</option>
                            <option value="dipesan">Dipesan</option>
                            <option value="digunakan">Digunakan</option>
                        </select>
                    </template>

                    <template #actions="{ item }">
                        <button
                            @click="openEditModal(item)"
                            class="px-3 py-1.5 bg-orange-100 text-orange-700 rounded-md hover:bg-orange-200 text-sm font-medium flex items-center gap-1.5"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="16"
                                height="16"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >
                                <path
                                    d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"
                                />
                                <path d="m15 5 4 4" />
                            </svg>
                        </button>
                        <Link
                            :href="route('admin.meja.destroy', { meja: item })"
                            method="delete"
                            as="button"
                            class="px-3 py-1.5 bg-red-100 text-red-700 rounded-md hover:bg-red-200 text-sm font-medium flex items-center gap-1.5"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="16"
                                height="16"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >
                                <path d="M3 6h18" />
                                <path
                                    d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"
                                />
                                <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2" />
                            </svg>
                        </Link>
                    </template>
                </DataTable>
            </div>
        </div>
    </AdminLayout>

    <ModalForm
        :show="isModalOpen"
        :title="editingMeja ? 'Edit Table' : 'Add New Table'"
        @close="closeModal"
    >
        <form @submit.prevent="submitForm" class="p-6"></form>
    </ModalForm>
</template>
