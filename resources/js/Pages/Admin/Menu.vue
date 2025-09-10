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

// --- State ---
const isModalOpen = ref(false);
const isEditing = ref(false);
const currentMenu = ref<Menu | null>(null);
const imagePreview = ref<string | null>(null);

// --- Form ---
const form = useForm({
    kode_menu: "",
    nama: "",
    deskripsi: "",
    harga: 0,
    kode_kategori: "",
    jumlah: 0,
    image: null as File | null,
});

// --- Computed Properties ---
const modalTitle = computed(() =>
    isEditing.value ? "Edit Menu" : "Add New Menu"
);

const currentImageUrl = computed(() => {
    if (isEditing.value && currentMenu.value?.path_img) {
        return `/storage/images/${currentMenu.value.path_img}`;
    }
    return null;
});

// [NEW] Computed properties for stat cards
const totalMenus = computed(() => props.menus.length);
const totalCategories = computed(() => props.categories.length);
const inStockCount = computed(
    () => props.menus.filter((menu) => menu.jumlah > 0).length
);
const outOfStockCount = computed(
    () => props.menus.filter((menu) => menu.jumlah === 0).length
);

const categoryFilter = computed(() => {
    const uniqueKategori = Array.from(
        new Set(
            props.menus
                .map((menu) => menu.kategori?.nama)
                .filter((nama): nama is string => Boolean(nama))
        )
    );

    return {
        key: "kategori.nama", // Fix: Make sure filter key matches nested object path
        label: "Kategori",
        options: uniqueKategori.map((nama) => ({
            value: nama,
            label: nama,
        })),
    };
});

const tableHeaders = [
    { key: "image", label: "Image" },
    { key: "nama", label: "Name" },
    { key: "kategori.nama", label: "Category" }, // Fix: Use nested path for sorting/display
    { key: "harga", label: "Price" },
    { key: "jumlah", label: "Stock" },
];

// --- Functions ---
const openCreateModal = () => {
    isEditing.value = false;
    form.reset();
    isModalOpen.value = true;
    imagePreview.value = null; // Ensure preview is cleared
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
        imagePreview.value = URL.createObjectURL(file);
    }
};

const removeImagePreview = () => {
    imagePreview.value = null;
    form.image = null;
    const fileInput = document.getElementById("image") as HTMLInputElement;
    if (fileInput) fileInput.value = "";
};

const formatCurrency = (value: number) =>
    new Intl.NumberFormat("id-ID", {
        style: "currency",
        currency: "IDR",
        minimumFractionDigits: 0,
    }).format(value);
</script>

<template>
    <AdminLayout>
        <div class="p-4 sm:p-6 lg:p-8">
            <div class="max-w-7xl mx-auto">
                <nav class="text-sm mb-4" aria-label="Breadcrumb">
                    <ol class="list-none p-0 inline-flex space-x-2">
                        <li class="flex items-center">
                            <a
                                href="#"
                                class="text-gray-500 hover:text-gray-700"
                                >Admin</a
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
                                >Menu</span
                            >
                        </li>
                    </ol>
                </nav>

                <div
                    class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8"
                >
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">
                            Menu Management
                        </h1>
                        <p class="mt-1 text-sm text-gray-600">
                            Manage your restaurant menu items and categories.
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
                        Add New Menu
                    </button>
                </div>

                <div
                    class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8"
                >
                    <div
                        class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 flex items-center gap-4"
                    >
                        <div class="bg-amber-100 p-3 rounded-full">
                            <svg
                                class="w-6 h-6 text-amber-700"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h7"
                                ></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Total Menus</p>
                            <p class="text-2xl font-bold text-gray-900">
                                {{ totalMenus }}
                            </p>
                        </div>
                    </div>
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
                            <p class="text-sm text-gray-500">Categories</p>
                            <p class="text-2xl font-bold text-gray-900">
                                {{ totalCategories }}
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
                            <p class="text-sm text-gray-500">In Stock</p>
                            <p class="text-2xl font-bold text-gray-900">
                                {{ inStockCount }}
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
                            <p class="text-sm text-gray-500">Out of Stock</p>
                            <p class="text-2xl font-bold text-gray-900">
                                {{ outOfStockCount }}
                            </p>
                        </div>
                    </div>
                </div>

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
                            <div class="flex items-center justify-center p-2">
                                <img
                                    :src="`/storage/images/${item.path_img}`"
                                    :alt="item.nama"
                                    class="h-14 w-14 object-cover rounded-xl ring-1 ring-gray-200"
                                />
                            </div>
                        </template>
                        <template #cell(kategori.nama)="{ item }">
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800"
                            >
                                {{ item.kategori?.nama || "N/A" }}
                            </span>
                        </template>
                        <template #cell(harga)="{ item }">
                            <span class="font-semibold text-gray-800 text-sm">
                                {{ formatCurrency(item.harga) }}
                            </span>
                        </template>
                        <template #cell(jumlah)="{ item }">
                            <span
                                class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold"
                                :class="{
                                    'bg-green-100 text-green-800':
                                        item.jumlah > 10,
                                    'bg-yellow-100 text-yellow-800':
                                        item.jumlah > 0 && item.jumlah <= 10,
                                    'bg-red-100 text-red-800':
                                        item.jumlah === 0,
                                }"
                            >
                                {{
                                    item.jumlah > 0
                                        ? `${item.jumlah} in stock`
                                        : "Out of stock"
                                }}
                            </span>
                        </template>
                        <template #actions="{ item }">
                            <div class="flex items-center gap-2">
                                <button
                                    @click="openEditModal(item)"
                                    class="inline-flex items-center p-2 bg-gray-100 text-gray-700 hover:bg-gray-200 rounded-lg text-xs font-medium transition-colors duration-150"
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
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                                        ></path>
                                    </svg>
                                </button>
                                <button
                                    @click="deleteMenu(item)"
                                    class="inline-flex items-center p-2 bg-red-50 text-red-600 hover:bg-red-100 rounded-lg text-xs font-medium transition-colors duration-150"
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

        <Modal :show="isModalOpen" :title="modalTitle" @close="closeModal">
            <form @submit.prevent="submitForm" class="p-4 space-y-4">
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
                        class="mt-1 p-2 block w-full border-gray-300 rounded-md shadow-sm focus:ring-amber-500 focus:border-amber-500"
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
                        class="mt-1 p-2 block w-full border-gray-300 rounded-md shadow-sm focus:ring-amber-500 focus:border-amber-500"
                    ></textarea>
                    <div
                        v-if="form.errors.deskripsi"
                        class="text-red-500 text-xs mt-1"
                    >
                        {{ form.errors.deskripsi }}
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
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
                            class="mt-1 p-2 block w-full border-gray-300 rounded-md shadow-sm focus:ring-amber-500 focus:border-amber-500"
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
                            class="mt-1 p-2 block w-full border-gray-300 rounded-md shadow-sm focus:ring-amber-500 focus:border-amber-500"
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
                        class="mt-1 p-2 block w-full border-gray-300 rounded-md shadow-sm focus:ring-amber-500 focus:border-amber-500"
                    >
                        <option disabled value="">Select a category</option>
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
                        class="block text-sm font-medium text-gray-700 mb-2"
                        >Image</label
                    >
                    <div class="flex items-center gap-4">
                        <img
                            v-if="imagePreview"
                            :src="imagePreview"
                            alt="Preview"
                            class="w-20 h-20 object-cover rounded-lg border"
                        />
                        <img
                            v-else-if="currentImageUrl"
                            :src="currentImageUrl"
                            alt="Current"
                            class="w-20 h-20 object-cover rounded-lg border"
                        />
                        <div
                            v-else
                            class="w-20 h-20 bg-gray-100 flex items-center justify-center rounded-lg border"
                        >
                            <svg
                                class="w-8 h-8 text-gray-400"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.5"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"
                                ></path>
                            </svg>
                        </div>
                        <div class="flex-grow">
                            <input
                                @change="handleImageUpload"
                                type="file"
                                id="image"
                                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100"
                            />
                            <button
                                v-if="
                                    imagePreview ||
                                    (isEditing && currentImageUrl)
                                "
                                type="button"
                                @click="removeImagePreview"
                                class="text-xs text-red-500 hover:underline mt-2"
                            >
                                Remove Image
                            </button>
                        </div>
                    </div>
                    <div
                        v-if="form.errors.image"
                        class="text-red-500 text-xs mt-1"
                    >
                        {{ form.errors.image }}
                    </div>
                </div>

                <div class="pt-4 flex justify-end space-x-3">
                    <button
                        type="button"
                        @click="closeModal"
                        class="px-4 py-2 bg-gray-100 text-gray-800 rounded-lg hover:bg-gray-200 transition-colors"
                    >
                        Cancel
                    </button>
                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="px-4 py-2 bg-[#6F4E37] text-white rounded-lg hover:bg-[#5D4037] disabled:opacity-50 transition-colors"
                    >
                        {{ form.processing ? "Saving..." : "Save Changes" }}
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
