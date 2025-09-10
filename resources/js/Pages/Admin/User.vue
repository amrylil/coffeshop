<script setup lang="ts">
import { Head, Link, usePage, useForm } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { User } from "@/types";
import { computed, ref } from "vue";
import DataTable from "@/components/ui/DataTable.vue";
import Modal from "@/components/ui/ModalForm.vue";
import { route } from "ziggy-js";

// Tipe untuk PageProps
export type PageProps<
    T extends Record<string, unknown> = Record<string, unknown>
> = T & {
    auth: {
        user: User;
    };
    flash: {
        success: string | null;
        error: string | null;
    };
};

// Props dari controller
const props = defineProps<{
    users: User[];
}>();

const page = usePage<PageProps>();
const successMessage = computed(() => page.props.flash.success);
const errorMessage = computed(() => page.props.flash.error);

// State untuk modal
const isModalOpen = ref(false);
const editingUser = ref<User | null>(null);

// Inisialisasi form dengan useForm dari Inertia
const form = useForm({
    _method: "POST",
    name: "",
    email: "",
    role: "user",
    password: "",
    profile_photo: null as File | null,
});

// Fungsi untuk membuka modal create
const openCreateModal = () => {
    editingUser.value = null;
    form.reset();
    form._method = "POST";
    isModalOpen.value = true;
};

// Fungsi untuk membuka modal edit
const openEditModal = (user: User) => {
    editingUser.value = user;
    form.name = user.name;
    form.email = user.email;
    form.role = user.role;
    form.password = "";
    form.profile_photo = null;
    form._method = "PUT";
    isModalOpen.value = true;
};

// Fungsi untuk menutup modal
const closeModal = () => {
    isModalOpen.value = false;
    editingUser.value = null;
    form.reset();
};

// Fungsi untuk submit form (create atau update)
const submit = () => {
    const options = {
        onSuccess: () => closeModal(),
        preserveScroll: true,
    };

    if (editingUser.value) {
        form.post(route("admin.users.update", editingUser.value.id), options);
    } else {
        // Mode Create: POST ke route store
        form.post(route("admin.users.store"), options);
    }
};

// Konfigurasi untuk DataTable
const tableHeaders = [
    { key: "profile_photo_url", label: "Image" },
    { key: "name", label: "Name" },
    { key: "email", label: "Email" },
    { key: "role", label: "Role" },
];

const searchKeys = ["name", "email", "role"];

const userFilters = [
    {
        key: "role",
        label: "Role",
        options: [
            { value: "admin", label: "Admin" },
            { value: "cashier", label: "Cashier" },
            { value: "user", label: "User" },
        ],
    },
];
</script>

<template>
    <Head title="User Management" />

    <AdminLayout>
        <div class="py-8 px-4 sm:px-6 lg:px-8">
            <header>
                <div
                    class="flex flex-col sm:flex-row justify-between items-start gap-4"
                >
                    <div>
                        <h1 class="text-3xl font-bold text-gray-800">
                            User Management
                        </h1>
                        <p class="mt-1 text-sm text-gray-500">
                            Kelola semua pengguna sistem dari admin hingga kasir
                            di sini.
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
                        <span>Add New User</span>
                    </button>
                </div>
            </header>

            <DataTable
                :headers="tableHeaders"
                :items="users"
                :search-keys="searchKeys"
                :filters="userFilters"
                enable-filter
            >
                <template #cell(profile_photo_url)="{ item }">
                    <img
                        v-if="item.profile_photo_url"
                        :src="item.profile_photo_url"
                        :alt="item.name"
                        class="h-16 w-16 object-cover rounded"
                    />
                    <div
                        v-else
                        class="h-16 w-16 bg-gray-200 flex items-center justify-center rounded"
                    >
                        <span class="text-gray-400 text-xs">No Image</span>
                    </div>
                </template>

                <template #cell(role)="{ item }">
                    <span class="capitalize">{{ item.role }}</span>
                </template>

                <template #actions="{ item }">
                    <Link
                        :href="route('admin.users.show', item.id)"
                        class="text-blue-600 hover:text-blue-800"
                    >
                        <span class="px-2 py-1 bg-blue-100 rounded-md"
                            >View</span
                        >
                    </Link>
                    <button
                        @click="openEditModal(item)"
                        class="text-[#6F4E37] hover:text-[#5D4037]"
                    >
                        <span class="px-2 py-1 bg-[#F5E6DD] rounded-md"
                            >Edit</span
                        >
                    </button>
                    <Link
                        :href="route('admin.users.destroy', item.id)"
                        method="delete"
                        as="button"
                        class="text-red-600 hover:text-red-800"
                        preserve-scroll
                    >
                        <span class="px-2 py-1 bg-red-100 rounded-md"
                            >Delete</span
                        >
                    </Link>
                </template>
            </DataTable>
        </div>
    </AdminLayout>

    <Modal
        :show="isModalOpen"
        :title="editingUser ? 'Edit User' : 'Create New User'"
        @close="closeModal"
    >
        <form @submit.prevent="submit" class="p-6">
            <div class="space-y-4">
                <div>
                    <label
                        for="name"
                        class="block text-sm font-medium text-gray-700"
                        >Name</label
                    >
                    <input
                        type="text"
                        id="name"
                        v-model="form.name"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                        required
                    />
                    <div
                        v-if="form.errors.name"
                        class="text-sm text-red-600 mt-1"
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
                        type="email"
                        id="email"
                        v-model="form.email"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                        :disabled="!!editingUser"
                        required
                    />
                    <div
                        v-if="form.errors.email"
                        class="text-sm text-red-600 mt-1"
                    >
                        {{ form.errors.email }}
                    </div>
                </div>

                <div>
                    <label
                        for="role"
                        class="block text-sm font-medium text-gray-700"
                        >Role</label
                    >
                    <select
                        id="role"
                        v-model="form.role"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                    >
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                        <option value="cashier">Cashier</option>
                    </select>
                    <div
                        v-if="form.errors.role"
                        class="text-sm text-red-600 mt-1"
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
                        type="password"
                        id="password"
                        v-model="form.password"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                        :placeholder="
                            editingUser
                                ? 'Leave blank to keep current password'
                                : ''
                        "
                        :required="!editingUser"
                    />
                    <div
                        v-if="form.errors.password"
                        class="text-sm text-red-600 mt-1"
                    >
                        {{ form.errors.password }}
                    </div>
                </div>

                <div>
                    <label
                        for="profile_photo"
                        class="block text-sm font-medium text-gray-700"
                        >Profile Photo</label
                    >
                    <input
                        type="file"
                        class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                    />
                    <progress
                        v-if="form.progress"
                        :value="form.progress.percentage"
                        max="100"
                        class="w-full mt-2"
                    >
                        {{ form.progress.percentage }}%
                    </progress>
                    <div
                        v-if="form.errors.profile_photo"
                        class="text-sm text-red-600 mt-1"
                    >
                        {{ form.errors.profile_photo }}
                    </div>
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-4">
                <button
                    type="button"
                    @click="closeModal"
                    class="rounded-md border border-gray-300 bg-white py-2 px-4 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50"
                >
                    Cancel
                </button>
                <button
                    type="submit"
                    :disabled="form.processing"
                    class="inline-flex justify-center rounded-md border border-transparent bg-[#6F4E37] py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-[#5D4037] disabled:opacity-50"
                >
                    {{
                        form.processing
                            ? "Saving..."
                            : editingUser
                            ? "Update User"
                            : "Create User"
                    }}
                </button>
            </div>
        </form>
    </Modal>
</template>
