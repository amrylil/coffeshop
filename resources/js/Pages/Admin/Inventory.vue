<script setup lang="ts">
import { ref, computed } from "vue";
import { useForm, Link } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import DataTable from "@/components/ui/DataTable.vue";
import Modal from "@/components/ui/ModalForm.vue";
import { route } from "ziggy-js";

// --- Interface ---
interface Inventory {
    kode_bahan: string;
    nama_bahan: string;
    satuan: string;
    stok: number;
}

// --- Props ---
const props = defineProps<{
    inventories: Inventory[];
}>();

// --- State ---
const isModalOpen = ref(false);
const isDetailModalOpen = ref(false); // State for detail modal
const isEditing = ref(false);
const currentInventory = ref<Inventory | null>(null);

// --- Form ---
const form = useForm({
    kode_bahan: "",
    nama_bahan: "",
    satuan: "",
    stok: 0,
});

// --- Computed Properties ---
const modalTitle = computed(() =>
    isEditing.value ? "Edit Bahan" : "Tambah Bahan Baru"
);

// Computed properties for stat cards
const totalItems = computed(() => props.inventories.length);
const lowStockCount = computed(
    () =>
        props.inventories.filter((item) => item.stok > 0 && item.stok <= 10)
            .length
);
const outOfStockCount = computed(
    () => props.inventories.filter((item) => item.stok === 0).length
);
const inStockCount = computed(
    () => props.inventories.filter((item) => item.stok > 10).length
);

// DataTable headers
const tableHeaders = [
    { key: "kode_bahan", label: "Kode" },
    { key: "nama_bahan", label: "Nama Bahan" },
    { key: "satuan", label: "Satuan" },
    { key: "stok", label: "Stok" },
];

// --- Functions ---
const openCreateModal = () => {
    isEditing.value = false;
    form.reset();
    isModalOpen.value = true;
};

const openEditModal = (inventory: Inventory) => {
    isEditing.value = true;
    currentInventory.value = inventory;
    form.kode_bahan = inventory.kode_bahan;
    form.nama_bahan = inventory.nama_bahan;
    form.satuan = inventory.satuan;
    form.stok = inventory.stok;
    isModalOpen.value = true;
};

const openDetailModal = (inventory: Inventory) => {
    currentInventory.value = inventory;
    isDetailModalOpen.value = true;
};

const closeModal = () => {
    isModalOpen.value = false;
    form.reset();
    form.clearErrors();
};

const closeDetailModal = () => {
    isDetailModalOpen.value = false;
    currentInventory.value = null;
};

const submitForm = () => {
    const options = {
        onSuccess: () => closeModal(),
        preserveScroll: true,
    };
    if (isEditing.value) {
        form.put(
            route("admin.inventory.update", currentInventory.value!.kode_bahan),
            options
        );
    } else {
        form.post(route("admin.inventory.store"), options);
    }
};

const deleteInventory = (inventory: Inventory) => {
    if (
        confirm(`Apakah Anda yakin ingin menghapus "${inventory.nama_bahan}"?`)
    ) {
        useForm({}).delete(
            route("admin.inventory.destroy", inventory.kode_bahan),
            {
                preserveScroll: true,
            }
        );
    }
};
</script>

<template>
    <AdminLayout>
        <div class="p-4 sm:p-6 lg:p-8">
            <div class="max-w-7xl mx-auto">
                <!-- Breadcrumbs and Header -->
                <nav class="text-sm mb-4" aria-label="Breadcrumb">
                    <ol class="list-none p-0 inline-flex space-x-2">
                        <li class="flex items-center">
                            <Link
                                :href="route('admin.dashboard.index')"
                                class="text-gray-500 hover:text-gray-700"
                                >Admin</Link
                            >
                        </li>
                        <li class="flex items-center">
                            <svg
                                class="h-5 w-5 text-gray-400"
                                fill="currentColor"
                                viewBox="0 0 20 20"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                            <span class="text-gray-800 font-semibold"
                                >Inventaris</span
                            >
                        </li>
                    </ol>
                </nav>

                <div
                    class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8"
                >
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">
                            Manajemen Inventaris
                        </h1>
                        <p class="mt-1 text-sm text-gray-600">
                            Kelola semua bahan dan stok persediaan di sini.
                        </p>
                    </div>
                    <button
                        @click="openCreateModal"
                        class="mt-4 sm:mt-0 inline-flex items-center px-5 py-2.5 bg-[#6F4E37] text-white text-sm font-medium rounded-lg hover:bg-[#5D4037] transition-all duration-200 shadow-sm hover:shadow-md transform hover:-translate-y-0.5"
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
                                d="M12 4v16m8-8H4"
                            ></path>
                        </svg>
                        Tambah Bahan
                    </button>
                </div>

                <!-- Stat Cards -->
                <div
                    class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8"
                >
                    <div
                        class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 flex items-center gap-4"
                    >
                        <div class="bg-sky-100 p-3 rounded-full">
                            <svg
                                class="w-6 h-6 text-sky-700"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2H5a2 2 0 00-2 2v2m14 0h-2M5 11H3"
                                ></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Total Bahan</p>
                            <p class="text-2xl font-bold text-gray-900">
                                {{ totalItems }}
                            </p>
                        </div>
                    </div>
                    <div
                        class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 flex items-center gap-4"
                    >
                        <div class="bg-green-100 p-3 rounded-full">
                            <svg
                                class="w-6 h-6 text-green-700"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M5 13l4 4L19 7"
                                ></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Stok Aman</p>
                            <p class="text-2xl font-bold text-gray-900">
                                {{ inStockCount }}
                            </p>
                        </div>
                    </div>
                    <div
                        class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 flex items-center gap-4"
                    >
                        <div class="bg-yellow-100 p-3 rounded-full">
                            <svg
                                class="w-6 h-6 text-yellow-700"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"
                                ></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Stok Menipis</p>
                            <p class="text-2xl font-bold text-gray-900">
                                {{ lowStockCount }}
                            </p>
                        </div>
                    </div>
                    <div
                        class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 flex items-center gap-4"
                    >
                        <div class="bg-red-100 p-3 rounded-full">
                            <svg
                                class="w-6 h-6 text-red-700"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"
                                ></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Stok Habis</p>
                            <p class="text-2xl font-bold text-gray-900">
                                {{ outOfStockCount }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- DataTable -->
                <div
                    class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden"
                >
                    <DataTable
                        :headers="tableHeaders"
                        :items="inventories"
                        class="border-0"
                    >
                        <template #cell(stok)="{ item }">
                            <span
                                class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold"
                                :class="{
                                    'bg-green-100 text-green-800':
                                        item.stok > 10,
                                    'bg-yellow-100 text-yellow-800':
                                        item.stok > 0 && item.stok <= 10,
                                    'bg-red-100 text-red-800': item.stok === 0,
                                }"
                            >
                                {{
                                    item.stok > 0
                                        ? `${item.stok} ${item.satuan}`
                                        : "Habis"
                                }}
                            </span>
                        </template>

                        <template #actions="{ item }">
                            <div class="flex items-center gap-2">
                                <button
                                    @click="openDetailModal(item)"
                                    class="p-2 text-gray-500 hover:text-gray-800 hover:bg-gray-100 rounded-lg transition-colors"
                                >
                                    <svg
                                        class="w-5 h-5"
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
                                </button>
                                <button
                                    @click="openEditModal(item)"
                                    class="p-2 text-blue-500 hover:text-blue-800 hover:bg-blue-50 rounded-lg transition-colors"
                                >
                                    <svg
                                        class="w-5 h-5"
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
                                </button>
                                <button
                                    @click="deleteInventory(item)"
                                    class="p-2 text-red-500 hover:text-red-800 hover:bg-red-50 rounded-lg transition-colors"
                                >
                                    <svg
                                        class="w-5 h-5"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                                        ></path>
                                    </svg>
                                </button>
                            </div>
                        </template>
                    </DataTable>
                </div>
            </div>
        </div>

        <!-- Create/Edit Modal Form -->
        <Modal :show="isModalOpen" :title="modalTitle" @close="closeModal">
            <form @submit.prevent="submitForm" class="p-6 space-y-4">
                <div>
                    <label
                        for="kode_bahan"
                        class="block text-sm font-medium text-gray-700"
                        >Kode Bahan</label
                    >
                    <input
                        v-model="form.kode_bahan"
                        :disabled="isEditing"
                        type="text"
                        id="kode_bahan"
                        class="mt-1 p-2 block w-full border-gray-300 rounded-md shadow-sm focus:ring-amber-500 focus:border-amber-500 disabled:bg-gray-100"
                    />
                    <div
                        v-if="form.errors.kode_bahan"
                        class="text-red-500 text-xs mt-1"
                    >
                        {{ form.errors.kode_bahan }}
                    </div>
                </div>
                <div>
                    <label
                        for="nama_bahan"
                        class="block text-sm font-medium text-gray-700"
                        >Nama Bahan</label
                    >
                    <input
                        v-model="form.nama_bahan"
                        type="text"
                        id="nama_bahan"
                        class="mt-1 p-2 block w-full border-gray-300 rounded-md shadow-sm focus:ring-amber-500 focus:border-amber-500"
                    />
                    <div
                        v-if="form.errors.nama_bahan"
                        class="text-red-500 text-xs mt-1"
                    >
                        {{ form.errors.nama_bahan }}
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label
                            for="stok"
                            class="block text-sm font-medium text-gray-700"
                            >Stok</label
                        >
                        <input
                            v-model="form.stok"
                            type="number"
                            id="stok"
                            class="mt-1 p-2 block w-full border-gray-300 rounded-md shadow-sm focus:ring-amber-500 focus:border-amber-500"
                        />
                        <div
                            v-if="form.errors.stok"
                            class="text-red-500 text-xs mt-1"
                        >
                            {{ form.errors.stok }}
                        </div>
                    </div>
                    <div>
                        <label
                            for="satuan"
                            class="block text-sm font-medium text-gray-700"
                            >Satuan</label
                        >
                        <input
                            v-model="form.satuan"
                            type="text"
                            id="satuan"
                            placeholder="e.g., kg, gr, pcs, liter"
                            class="mt-1 p-2 block w-full border-gray-300 rounded-md shadow-sm focus:ring-amber-500 focus:border-amber-500"
                        />
                        <div
                            v-if="form.errors.satuan"
                            class="text-red-500 text-xs mt-1"
                        >
                            {{ form.errors.satuan }}
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="pt-4 flex justify-end space-x-3">
                    <button
                        type="button"
                        @click="closeModal"
                        class="px-4 py-2 bg-gray-100 text-gray-800 rounded-lg hover:bg-gray-200 transition-colors"
                    >
                        Batal
                    </button>
                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="px-4 py-2 bg-[#6F4E37] text-white rounded-lg hover:bg-[#5D4037] disabled:opacity-50 transition-colors flex items-center"
                    >
                        <svg
                            v-if="form.processing"
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
                        {{ form.processing ? "Menyimpan..." : "Simpan" }}
                    </button>
                </div>
            </form>
        </Modal>

        <!-- Detail Modal -->
        <Modal
            :show="isDetailModalOpen"
            title="Detail Bahan"
            @close="closeDetailModal"
        >
            <div v-if="currentInventory" class="p-6 space-y-4">
                <div>
                    <h3 class="text-lg font-bold text-gray-900">
                        {{ currentInventory.nama_bahan }}
                    </h3>
                    <p class="text-sm text-gray-500">
                        {{ currentInventory.kode_bahan }}
                    </p>
                </div>
                <div class="border-t border-gray-200"></div>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div class="text-gray-500">Stok Saat Ini</div>
                    <div class="font-semibold text-gray-800 flex items-center">
                        <span
                            class="inline-flex items-center px-2.5 py-1 rounded-full font-semibold"
                            :class="{
                                'bg-green-100 text-green-800':
                                    currentInventory.stok > 10,
                                'bg-yellow-100 text-yellow-800':
                                    currentInventory.stok > 0 &&
                                    currentInventory.stok <= 10,
                                'bg-red-100 text-red-800':
                                    currentInventory.stok === 0,
                            }"
                        >
                            {{
                                currentInventory.stok > 0
                                    ? `${currentInventory.stok} ${currentInventory.satuan}`
                                    : "Habis"
                            }}
                        </span>
                    </div>
                    <div class="text-gray-500">Satuan</div>
                    <div class="font-semibold text-gray-800">
                        {{ currentInventory.satuan }}
                    </div>
                </div>

                <div class="pt-6 flex justify-end">
                    <button
                        type="button"
                        @click="closeDetailModal"
                        class="px-4 py-2 bg-gray-100 text-gray-800 rounded-lg hover:bg-gray-200 transition-colors"
                    >
                        Tutup
                    </button>
                </div>
            </div>
        </Modal>
    </AdminLayout>
</template>
