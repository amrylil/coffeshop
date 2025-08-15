<script setup lang="ts">
import { ref, computed } from "vue";
import { useForm, usePage } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import DataTable from "@/components/ui/DataTable.vue";
import Modal from "@/components/ui/ModalForm.vue";
import { route } from "ziggy-js";

interface Kategori {
    kode_kategori: string;
    nama: string;
}
interface Menu {
    kode_menu: string;
    nama: string;
    deskripsi: string;
    harga: number;
    jumlah: number;
    path_img: string | null;
    kode_kategori: string;
    kategori?: Kategori;
}

// --- Props ---
const props = defineProps<{
    menus: Menu[];
    categories: Kategori[];
}>();

const isModalOpen = ref(false);
const isEditing = ref(false);
const currentMenu = ref<Menu | null>(null);
const imagePreview = ref<string | null>(null);

const form = useForm({
    kode_menu: "",
    nama: "",
    deskripsi: "",
    harga: 0,
    kode_kategori: "",
    jumlah: 0,
    image: null as File | null,
});

const categoryFilter = computed(() => {
    const uniqueKategori = Array.from(
        new Set(
            props.menus
                .map((menu) => menu.kategori?.nama)
                .filter((nama): nama is string => Boolean(nama))
        )
    );

    return {
        key: "kategori",
        label: "Kategori",
        options: uniqueKategori.map((nama) => ({
            value: nama,
            label: nama,
        })),
    };
});

const tableHeaders = [
    { key: "image", label: "Image" },
    { key: "kode_menu", label: "Code" },
    { key: "nama", label: "Name" },
    { key: "kategori", label: "Category" },
    { key: "harga", label: "Price" },
    { key: "jumlah", label: "Stock" },
];

// --- Computed Properties ---
const modalTitle = computed(() =>
    isEditing.value ? "Edit Menu" : "Add New Menu"
);
const flash = computed(
    () => usePage().props.flash as { success?: string; error?: string }
);

const currentImageUrl = computed(() => {
    if (isEditing.value && currentMenu.value?.path_img) {
        return `/images/${currentMenu.value.path_img}`;
    }
    return null;
});

// --- Functions ---
const openCreateModal = () => {
    isEditing.value = false;
    form.reset();
    isModalOpen.value = true;
    isModalOpen.value = true;
};

const openEditModal = (menu: Menu) => {
    isEditing.value = true;
    currentMenu.value = menu;
    form.kode_menu = menu.kode_menu;
    form.nama = menu.nama;
    form.deskripsi = menu.deskripsi;
    form.harga = menu.harga;
    form.kode_kategori = menu.kode_kategori;
    form.jumlah = menu.jumlah;
    form.image = null;
    isModalOpen.value = true;
    imagePreview.value = null;
};

const closeModal = () => {
    isModalOpen.value = false;
    form.reset();
    form.clearErrors();
    imagePreview.value = null;
};

const submitForm = () => {
    const options = {
        onSuccess: () => closeModal(),
    };
    if (isEditing.value) {
        form.post(
            route("admin.menu.update", currentMenu.value!.kode_menu),
            options
        );
    } else {
        form.post(route("admin.menu.store"), options);
    }
};

const deleteMenu = (menu: Menu) => {
    if (confirm("Are you sure you want to delete this menu?")) {
        useForm({}).delete(route("admin.menu.destroy", menu.kode_menu));
    }
};

const handleImageUpload = (event: Event) => {
    const target = event.target as HTMLInputElement;
    if (target.files && target.files.length > 0) {
        const file = target.files[0];
        form.image = file;
        imagePreview.value = URL.createObjectURL(file); // Create preview URL
    }
};

const removeImagePreview = () => {
    imagePreview.value = null;
    form.image = null;
    const fileInput = document.getElementById("image") as HTMLInputElement;
    if (fileInput) fileInput.value = ""; // Reset the file input
};

const formatCurrency = (value: number) =>
    new Intl.NumberFormat("id-ID", {
        style: "currency",
        currency: "IDR",
    }).format(value);
</script>

<template>
    <AdminLayout>
        <div class="min-h-screen bg-gradient-to-br from-slate-50 to-gray-100">
            <div class="py-8 px-4 sm:px-6 lg:px-8">
                <div class="max-w-7xl mx-auto">
                    <!-- Header with modern design -->
                    <div
                        class="mb-8 bg-white rounded-2xl shadow-sm border border-gray-100 p-6"
                    >
                        <div
                            class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4"
                        >
                            <div>
                                <h1
                                    class="text-2xl font-bold text-gray-900 mb-2"
                                >
                                    Menu Management
                                </h1>
                                <p class="text-gray-600 text-sm">
                                    Manage your restaurant menu items and
                                    categories
                                </p>
                            </div>
                            <button
                                @click="openCreateModal"
                                class="inline-flex items-center px-6 py-3 bg-gray-900 text-white text-sm font-medium rounded-xl hover:bg-gray-800 transition-all duration-200 shadow-sm hover:shadow-md transform hover:-translate-y-0.5"
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
                                Add New Menu
                            </button>
                        </div>
                    </div>

                    <!-- Data Table with enhanced styling -->
                    <div
                        class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden"
                    >
                        <DataTable
                            :headers="tableHeaders"
                            :items="menus"
                            :filters="[categoryFilter]"
                            enableFilter
                            class="border-0"
                        >
                            <template #cell(image)="{ item }">
                                <div class="flex justify-center">
                                    <div class="relative">
                                        <img
                                            v-if="item.path_img"
                                            :src="`/images/${item.path_img}`"
                                            :alt="item.nama"
                                            class="h-14 w-14 object-cover rounded-xl ring-2 ring-gray-100"
                                        />
                                        <div
                                            v-else
                                            class="h-14 w-14 bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center rounded-xl ring-2 ring-gray-100"
                                        >
                                            <svg
                                                class="w-6 h-6 text-gray-400"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"
                                                ></path>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </template>
                            <template #cell(kategori)="{ item }">
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-700"
                                >
                                    {{ item.kategori.nama || "N/A" }}
                                </span>
                            </template>
                            <template #cell(harga)="{ item }">
                                <span class="font-semibold text-gray-900">
                                    {{ formatCurrency(item.harga) }}
                                </span>
                            </template>
                            <template #cell(jumlah)="{ item }">
                                <span
                                    class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium"
                                    :class="
                                        item.jumlah > 10
                                            ? 'bg-green-100 text-green-700'
                                            : item.jumlah > 0
                                            ? 'bg-yellow-100 text-yellow-700'
                                            : 'bg-red-100 text-red-700'
                                    "
                                >
                                    {{ item.jumlah }}
                                </span>
                            </template>
                            <template #actions="{ item }">
                                <div class="flex items-center gap-2">
                                    <button
                                        @click="openEditModal(item)"
                                        class="inline-flex items-center px-3 py-1.5 bg-gray-100 text-gray-700 hover:bg-gray-200 rounded-lg text-xs font-medium transition-colors duration-150"
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
                                    </button>
                                    <button
                                        @click="deleteMenu(item)"
                                        class="inline-flex items-center px-3 py-1.5 bg-red-50 text-red-600 hover:bg-red-100 rounded-lg text-xs font-medium transition-colors duration-150"
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
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                                            ></path>
                                        </svg>
                                        Delete
                                    </button>
                                </div>
                            </template>
                        </DataTable>
                    </div>
                </div>
            </div>
        </div>

        <Modal :show="isModalOpen" :title="modalTitle" @close="closeModal">
            <form @submit.prevent="submitForm" class="p-2 space-y-2">
                <div>
                    <label
                        for="nama"
                        class="block text-sm font-medium text-gray-700"
                        >Name</label
                    >
                    <input
                        v-model="form.nama"
                        type="text"
                        id="nama"
                        class="mt-1 p-2 block w-full border-gray-300 rounded-md shadow-sm"
                    />
                    <div
                        v-if="form.errors.nama"
                        class="text-red-500 text-xs mt-1"
                    >
                        {{ form.errors.nama }}
                    </div>
                </div>
                <div>
                    <label
                        for="deskripsi"
                        class="block text-sm font-medium text-gray-700"
                        >Description</label
                    >
                    <textarea
                        v-model="form.deskripsi"
                        id="deskripsi"
                        rows="3"
                        class="mt-1 p-2 block w-full border-gray-300 rounded-md shadow-sm"
                    ></textarea>
                    <div
                        v-if="form.errors.deskripsi"
                        class="text-red-500 text-xs mt-1"
                    >
                        {{ form.errors.deskripsi }}
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label
                            for="harga"
                            class="block text-sm font-medium text-gray-700"
                            >Price</label
                        >
                        <input
                            v-model="form.harga"
                            type="number"
                            id="harga"
                            class="mt-1 p-2 block w-full border-gray-300 rounded-md shadow-sm"
                        />
                        <div
                            v-if="form.errors.harga"
                            class="text-red-500 text-xs mt-1"
                        >
                            {{ form.errors.harga }}
                        </div>
                    </div>
                    <div>
                        <label
                            for="jumlah"
                            class="block text-sm font-medium text-gray-700"
                            >Stock</label
                        >
                        <input
                            v-model="form.jumlah"
                            type="number"
                            id="jumlah"
                            class="mt-1 p-2 block w-full border-gray-300 rounded-md shadow-sm"
                        />
                        <div
                            v-if="form.errors.jumlah"
                            class="text-red-500 text-xs mt-1"
                        >
                            {{ form.errors.jumlah }}
                        </div>
                    </div>
                </div>
                <div>
                    <label
                        for="kode_kategori"
                        class="block text-sm font-medium text-gray-700"
                        >Category</label
                    >
                    <select
                        v-model="form.kode_kategori"
                        id="kode_kategori"
                        class="mt-1 p-2 block w-full border-gray-300 rounded-md shadow-sm"
                    >
                        <option value="">Select a category</option>
                        <option
                            v-for="cat in categories"
                            :key="cat.kode_kategori"
                            :value="cat.kode_kategori"
                        >
                            {{ cat.nama }}
                        </option>
                    </select>
                    <div
                        v-if="form.errors.kode_kategori"
                        class="text-red-500 text-xs mt-1"
                    >
                        {{ form.errors.kode_kategori }}
                    </div>
                </div>
                <div>
                    <label
                        for="image"
                        class="block text-sm font-medium text-gray-700"
                        >Image</label
                    >
                    <div v-if="currentImageUrl && !imagePreview" class="mt-2">
                        <img
                            :src="currentImageUrl"
                            alt="Current"
                            class="w-20 h-20 object-cover rounded-lg border"
                        />
                    </div>
                    <div v-if="imagePreview" class="mt-2 relative w-20 h-20">
                        <img
                            :src="imagePreview"
                            alt="Preview"
                            class="w-20 h-20 object-cover rounded-lg border"
                        />
                        <button
                            type="button"
                            @click="removeImagePreview"
                            class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 text-white rounded-full text-xs hover:bg-red-600"
                        >
                            &times;
                        </button>
                    </div>
                    <input
                        @change="handleImageUpload"
                        type="file"
                        id="image"
                        class="mt-2 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:bg-amber-50 file:text-amber-800 hover:file:bg-amber-100"
                    />
                    <div
                        v-if="form.errors.image"
                        class="text-red-500 text-xs mt-1"
                    >
                        {{ form.errors.image }}
                    </div>
                </div>
                <div class="pt-4 flex justify-end space-x-2">
                    <button
                        type="button"
                        @click="closeModal"
                        class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300"
                    >
                        Cancel
                    </button>
                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="px-4 py-2 bg-[#6F4E37] text-white rounded-md hover:bg-[#5D4037] disabled:opacity-50"
                    >
                        {{ form.processing ? "Saving..." : "Save" }}
                    </button>
                </div>
            </form>
        </Modal>
    </AdminLayout>
</template>

<style scoped>
/* Custom scrollbar for better aesthetics */
::-webkit-scrollbar {
    width: 6px;
}

::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 3px;
}

::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 3px;
}

::-webkit-scrollbar-thumb:hover {
    background: #a1a1a1;
}
</style>
