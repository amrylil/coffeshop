<script setup lang="ts">
import { ref, computed } from "vue";
import { useForm, Link, Head } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import DataTable from "@/components/ui/DataTable.vue";
import Modal from "@/components/ui/ModalForm.vue";
import { route } from "ziggy-js";
import { User } from "@/types"; // Menggunakan tipe User dari global types

// --- Props ---
const props = defineProps<{
    users: User[];
}>();

// --- State ---
const isModalOpen = ref(false);
const isDetailModalOpen = ref(false);
const isEditing = ref(false);
const currentUser = ref<User | null>(null);
const imagePreview = ref<string | null>(null);

// --- Form ---
const form = useForm({
    _method: "POST",
    name: "",
    email: "",
    role: "user",
    password: "",
    password_confirmation: "",
    profile_photo: null as File | null,
});

// --- Computed Properties ---
const modalTitle = computed(() =>
    isEditing.value ? "Edit Pengguna" : "Tambah Pengguna Baru"
);

const currentImageUrl = computed(() => {
    // Pastikan currentUser ada dan memiliki URL foto profil
    if (currentUser.value?.profile_photo) {
        return currentUser.value?.profile_photo;
    }
    return null;
});

// [FIX] Safely handle users prop
const safeUsers = computed(() => props.users || []);

// --- Table Configuration ---
const tableHeaders = [
    { key: "profile_photo", label: "Foto" },
    { key: "name", label: "Nama" },
    { key: "email", label: "Email" },
    { key: "role", label: "Peran" },
];

const userFilters = [
    {
        key: "role",
        label: "Peran",
        options: [
            { value: "admin", label: "Admin" },
            { value: "cashier", label: "Kasir" },
            { value: "user", label: "User" },
        ],
    },
];

// --- Functions ---
const openCreateModal = () => {
    isEditing.value = false;
    form.reset();
    form._method = "POST";
    isModalOpen.value = true;
    imagePreview.value = null;
};

const openEditModal = (user: User) => {
    isEditing.value = true;
    currentUser.value = user;
    form.name = user.name;
    form.email = user.email;
    form.role = user.role;
    form.password = "";
    form.password_confirmation = "";
    form.profile_photo = null;
    form._method = "PUT";
    isModalOpen.value = true;
    imagePreview.value = null;
};

const openDetailModal = (user: User) => {
    currentUser.value = user;
    isDetailModalOpen.value = true;
};

const closeModal = () => {
    isModalOpen.value = false;
    form.reset();
    form.clearErrors();
};

const closeDetailModal = () => {
    isDetailModalOpen.value = false;
};

const submitForm = () => {
    const options = {
        onSuccess: () => closeModal(),
        preserveScroll: true,
    };
    if (isEditing.value) {
        form.post(route("admin.users.update", currentUser.value!.id), options);
    } else {
        form.post(route("admin.users.store"), options);
    }
};

const deleteUser = (user: User) => {
    if (confirm(`Apakah Anda yakin ingin menghapus pengguna "${user.name}"?`)) {
        useForm({}).delete(route("admin.users.destroy", user.id), {
            preserveScroll: true,
        });
    }
};

const handleImageUpload = (event: Event) => {
    const target = event.target as HTMLInputElement;
    if (target.files && target.files.length > 0) {
        const file = target.files[0];
        form.profile_photo = file;
        imagePreview.value = URL.createObjectURL(file);
    }
};

const removeImagePreview = () => {
    imagePreview.value = null;
    form.profile_photo = null;
    const fileInput = document.getElementById(
        "image-upload"
    ) as HTMLInputElement;
    if (fileInput) fileInput.value = "";
};
</script>

<template>
    <Head title="Manajemen Pengguna" />
    <AdminLayout>
        <div class="p-4 sm:p-6 lg:p-8">
            <div class="max-w-7xl mx-auto">
                <!-- Breadcrumbs & Header -->
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
                                >Pengguna</span
                            >
                        </li>
                    </ol>
                </nav>

                <div
                    class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8"
                >
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">
                            Manajemen Pengguna
                        </h1>
                        <p class="mt-1 text-sm text-gray-600">
                            Kelola semua akun pengguna sistem di sini.
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
                        Tambah Pengguna
                    </button>
                </div>

                <!-- DataTable -->
                <div
                    class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden"
                >
                    <DataTable
                        :headers="tableHeaders"
                        :items="safeUsers"
                        :searchKeys="['name', 'email']"
                        :filters="userFilters"
                        enable-filter
                        class="border-0"
                    >
                        <template #cell(profile_photo)="{ item }">
                            <div class="p-2">
                                <img
                                    v-if="item.profile_photo"
                                    :src="item.profile_photo"
                                    :alt="item.name"
                                    class="h-14 w-14 object-cover rounded-full ring-1 ring-gray-200"
                                />
                                <div
                                    v-else
                                    class="h-14 w-14 bg-gray-100 rounded-full ring-1 ring-gray-200 flex items-center justify-center"
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
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                                        ></path>
                                    </svg>
                                </div>
                            </div>
                        </template>
                        <template #cell(role)="{ item }">
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium capitalize"
                                :class="{
                                    'bg-blue-100 text-blue-800':
                                        item.role === 'admin',
                                    'bg-green-100 text-green-800':
                                        item.role === 'cashier',
                                    'bg-gray-100 text-gray-800':
                                        item.role === 'user',
                                }"
                            >
                                {{ item.role }}
                            </span>
                        </template>
                        <template #actions="{ item }">
                            <div class="flex items-center gap-2">
                                <button
                                    @click="openDetailModal(item)"
                                    class="p-2 text-gray-500 hover:text-gray-800 hover:bg-gray-100 rounded-lg transition-colors"
                                    title="Lihat Detail"
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
                                    title="Edit"
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
                                    @click="deleteUser(item)"
                                    class="p-2 text-red-500 hover:text-red-800 hover:bg-red-50 rounded-lg transition-colors"
                                    title="Hapus"
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

        <!-- Create/Edit Modal -->
        <Modal :show="isModalOpen" :title="modalTitle" @close="closeModal">
            <form @submit.prevent="submitForm" class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="md:col-span-1 space-y-2">
                        <label class="block text-sm font-medium text-gray-700"
                            >Foto Profil</label
                        >
                        <div
                            class="aspect-square w-full bg-gray-100 rounded-full flex items-center justify-center overflow-hidden border-2 border-dashed"
                        >
                            <img
                                v-if="imagePreview || currentImageUrl"
                                :src="imagePreview! || currentImageUrl!"
                                alt="Preview"
                                class="w-full h-full object-cover"
                            />
                            <div v-else class="text-center text-gray-500 p-4">
                                <svg
                                    class="w-10 h-10 mx-auto"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="1.5"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                                    ></path>
                                </svg>
                            </div>
                        </div>
                        <input
                            @change="handleImageUpload"
                            type="file"
                            id="image-upload"
                            accept="image/*"
                            class="hidden"
                        />
                        <div class="flex items-center justify-center gap-2">
                            <label
                                for="image-upload"
                                class="cursor-pointer text-sm font-semibold text-amber-600 hover:text-amber-800"
                                >Unggah</label
                            >
                            <button
                                v-if="
                                    imagePreview ||
                                    (isEditing && currentUser?.profile_photo)
                                "
                                type="button"
                                @click="removeImagePreview"
                                class="text-sm text-red-500 hover:text-red-700"
                            >
                                Hapus
                            </button>
                        </div>
                        <div
                            v-if="form.errors.profile_photo"
                            class="text-red-500 text-xs text-center"
                        >
                            {{ form.errors.profile_photo }}
                        </div>
                    </div>

                    <div class="md:col-span-2 space-y-4">
                        <div>
                            <label
                                for="name"
                                class="block text-sm font-medium text-gray-700"
                                >Nama</label
                            >
                            <input
                                v-model="form.name"
                                type="text"
                                id="name"
                                class="mt-1 p-2 block w-full border-gray-300 rounded-md shadow-sm focus:ring-amber-500 focus:border-amber-500"
                            />
                            <div
                                v-if="form.errors.name"
                                class="text-red-500 text-xs mt-1"
                            >
                                {{ form.errors.name }}
                            </div>
                        </div>
                        <div>
                            <label
                                for="email"
                                class="block text-sm font-medium text-gray-700"
                                >Email</label
                            >
                            <input
                                v-model="form.email"
                                type="email"
                                id="email"
                                class="mt-1 p-2 block w-full border-gray-300 rounded-md shadow-sm focus:ring-amber-500 focus:border-amber-500"
                            />
                            <div
                                v-if="form.errors.email"
                                class="text-red-500 text-xs mt-1"
                            >
                                {{ form.errors.email }}
                            </div>
                        </div>
                        <div>
                            <label
                                for="role"
                                class="block text-sm font-medium text-gray-700"
                                >Peran</label
                            >
                            <select
                                v-model="form.role"
                                id="role"
                                class="mt-1 p-2 block w-full border-gray-300 rounded-md shadow-sm focus:ring-amber-500 focus:border-amber-500"
                            >
                                <option value="user">User</option>
                                <option value="admin">Admin</option>
                                <option value="cashier">Kasir</option>
                            </select>
                            <div
                                v-if="form.errors.role"
                                class="text-red-500 text-xs mt-1"
                            >
                                {{ form.errors.role }}
                            </div>
                        </div>
                        <div>
                            <label
                                for="password"
                                class="block text-sm font-medium text-gray-700"
                                >Password</label
                            >
                            <input
                                v-model="form.password"
                                type="password"
                                id="password"
                                class="mt-1 p-2 block w-full border-gray-300 rounded-md shadow-sm focus:ring-amber-500 focus:border-amber-500"
                                :placeholder="
                                    isEditing
                                        ? 'Kosongkan jika tidak ingin mengubah'
                                        : ''
                                "
                            />
                            <div
                                v-if="form.errors.password"
                                class="text-red-500 text-xs mt-1"
                            >
                                {{ form.errors.password }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pt-6 flex justify-end space-x-3">
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
            title="Detail Pengguna"
            @close="closeDetailModal"
        >
            <div v-if="currentUser" class="p-6 text-center">
                <img
                    :src="
                        currentImageUrl ||
                        `https://ui-avatars.com/api/?name=${currentUser.name}&background=E9E3D9&color=6F4E37`
                    "
                    :alt="currentUser.name"
                    class="w-32 h-32 rounded-full mx-auto mb-4 ring-4 ring-amber-100"
                />
                <h3 class="text-2xl font-bold text-gray-900">
                    {{ currentUser.name }}
                </h3>
                <p class="text-sm text-gray-500 mb-4">
                    {{ currentUser.email }}
                </p>
                <span
                    class="inline-flex items-center px-4 py-1.5 rounded-full text-sm font-semibold capitalize"
                    :class="{
                        'bg-blue-100 text-blue-800':
                            currentUser.role === 'admin',
                        'bg-green-100 text-green-800':
                            currentUser.role === 'cashier',
                        'bg-gray-100 text-gray-800':
                            currentUser.role === 'user',
                    }"
                >
                    {{ currentUser.role }}
                </span>
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
