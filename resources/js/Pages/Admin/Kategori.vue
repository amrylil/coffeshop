<script setup lang="ts">
import { ref, computed } from "vue";
import { useForm, usePage, Link } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import DataTable from "@/components/ui/DataTable.vue";
import Modal from "@/components/ui/ModalForm.vue";
import { route } from "ziggy-js";

interface Kategori {
    kode_kategori: string;
    nama: string;
    deskripsi: string | null;
    path_img: string | null;
    menu_count?: number;
}

const props = defineProps<{
    categories: Kategori[];
}>();

// --- State ---
const isModalOpen = ref(false);
const isEditing = ref(false);
const currentCategory = ref<Kategori | null>(null);

const form = useForm({
    kode_kategori: "",
    nama: "",
    deskripsi: "",
    path_img: null as File | null,
});

// --- Table Configuration ---
const tableHeaders = [
    { key: "image", label: "Image" },
    { key: "kode_kategori", label: "Code" },
    { key: "nama", label: "Name" },
    { key: "deskripsi", label: "Description" },
    { key: "menu_count", label: "Menu Count" },
];

// --- Computed Properties ---
const modalTitle = computed(() =>
    isEditing.value ? "Edit Category" : "Add New Category"
);
const flash = computed(
    () => usePage().props.flash as { success?: string; error?: string }
);

// --- Functions ---
const openCreateModal = () => {
    isEditing.value = false;
    form.reset();
    isModalOpen.value = true;
};

const openEditModal = (category: Kategori) => {
    isEditing.value = true;
    currentCategory.value = category;
    form.kode_kategori = category.kode_kategori;
    form.nama = category.nama;
    form.deskripsi = category.deskripsi || "";
    form.path_img = null;
    isModalOpen.value = true;
};

const closeModal = () => {
    isModalOpen.value = false;
    form.reset();
    form.clearErrors();
};

const submitForm = () => {
    const options = {
        onSuccess: () => closeModal(),
        // Preserve state to keep the modal open on validation errors
        preserveState: true,
    };

    if (isEditing.value) {
        form.put(
            route(
                "admin.kategori.update",
                currentCategory.value!.kode_kategori
            ),
            {
                ...options,
                // transform: (data) => ({ ...data, _method: "PATCH" }),
            }
        );
    } else {
        form.post(route("admin.kategori.store"), options);
    }
};

const deleteCategory = (category: Kategori) => {
    if (confirm("Are you sure you want to delete this category?")) {
        useForm({}).delete(
            route("admin.kategori.destroy", category.kode_kategori)
        );
    }
};

const handleImageUpload = (event: Event) => {
    const target = event.target as HTMLInputElement;
    if (target.files && target.files.length > 0) {
        form.path_img = target.files[0];
    }
};
</script>

<template>
    <AdminLayout>
        <div class="py-8 px-4 sm:px-6 lg:px-8">
            <div class="max-w-7xl mx-auto">
                <!-- Header -->
                <div class="mb-6 flex justify-between items-center">
                    <h1 class="text-3xl font-bold text-[#6F4E37]">
                        Category Management
                    </h1>
                    <button
                        @click="openCreateModal"
                        class="px-4 py-2 bg-[#6F4E37] text-white rounded-md hover:bg-[#5D4037] transition"
                    >
                        Add New Category
                    </button>
                </div>

                <!-- Data Table -->
                <DataTable
                    :headers="tableHeaders"
                    :items="categories"
                    :searchKeys="['nama', 'kode_kategori']"
                >
                    <template #cell(image)="{ item }">
                        <img
                            v-if="item.path_img"
                            :src="`/storage/${item.path_img}`"
                            :alt="item.nama"
                            class="h-16 w-16 object-cover rounded"
                        />
                        <div
                            v-else
                            class="h-16 w-16 bg-gray-200 flex items-center justify-center rounded text-gray-400"
                        >
                            No Img
                        </div>
                    </template>
                    <template #cell(deskripsi)="{ item }">
                        <p class="max-w-xs truncate">
                            {{ item.deskripsi || "No description" }}
                        </p>
                    </template>
                    <template #actions="{ item }">
                        <button
                            @click="openEditModal(item)"
                            class="px-2 py-1 bg-[#F5E6DD] text-[#6F4E37] hover:text-[#5D4037] rounded-md text-xs"
                        >
                            Edit
                        </button>
                        <button
                            @click="deleteCategory(item)"
                            class="px-2 py-1 bg-red-100 text-red-600 hover:text-red-800 rounded-md text-xs"
                        >
                            Delete
                        </button>
                    </template>
                </DataTable>
            </div>
        </div>

        <!-- Create/Edit Modal -->
        <Modal :show="isModalOpen" :title="modalTitle" @close="closeModal">
            <form @submit.prevent="submitForm" class="space-y-4">
                <div>
                    <label
                        for="kode_kategori"
                        class="block text-sm font-medium text-gray-700"
                        >Category Code</label
                    >
                    <input
                        v-model="form.kode_kategori"
                        type="text"
                        id="kode_kategori"
                        :disabled="isEditing"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                        :class="{ 'bg-gray-100': isEditing }"
                    />
                    <div
                        v-if="form.errors.kode_kategori"
                        class="text-red-500 text-xs mt-1"
                    >
                        {{ form.errors.kode_kategori }}
                    </div>
                </div>
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
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
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
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                    ></textarea>
                    <div
                        v-if="form.errors.deskripsi"
                        class="text-red-500 text-xs mt-1"
                    >
                        {{ form.errors.deskripsi }}
                    </div>
                </div>
                <div>
                    <label
                        for="path_img"
                        class="block text-sm font-medium text-gray-700"
                        >Image</label
                    >
                    <input
                        @change="handleImageUpload"
                        type="file"
                        id="path_img"
                        class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:bg-amber-50 file:text-amber-800 hover:file:bg-amber-100"
                    />
                    <div
                        v-if="form.errors.path_img"
                        class="text-red-500 text-xs mt-1"
                    >
                        {{ form.errors.path_img }}
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
