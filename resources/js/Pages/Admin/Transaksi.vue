<script setup lang="ts">
import { ref, computed } from "vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import DataTable from "@/components/ui/DataTable.vue";
import Modal from "@/components/ui/ModalForm.vue";
import { route } from "ziggy-js";

// --- INTERFACES ---
interface Menu {
    kode_menu: string;
    nama: string;
    harga: number;
    path_img: string | null;
}

interface CartItem extends Menu {
    jumlah: number;
}

interface User {
    id: number;
    name: string;
}

interface Transaksi {
    kode_transaksi: string;
    total_harga: number;
    status: string;
    jenis_pembayaran: string;
    created_at: string;
    pengguna: User;
    items: { jumlah: number }[];
}

interface Props {
    transaksis: { data: Transaksi[] }; // Disesuaikan dengan struktur paginator
    menus: Menu[];
    flash?: { success?: string; error?: string };
}

// --- PROPS ---
const props = defineProps<Props>();

// --- STATE ---
const isPosModalOpen = ref(false);
const cart = ref<CartItem[]>([]);
const searchTerm = ref("");

const posForm = useForm({
    items: [] as { kode_menu: string; jumlah: number; harga: number }[],
    total_harga: 0,
    catatan: "",
});

// --- COMPUTED PROPERTIES ---
const filteredMenus = computed(() => {
    const menus = props.menus || []; // Fallback ke array kosong jika props.menus undefined
    if (!searchTerm.value) {
        return menus;
    }
    return menus.filter((menu) =>
        menu.nama.toLowerCase().includes(searchTerm.value.toLowerCase())
    );
});

const totalHarga = computed(() => {
    return cart.value.reduce(
        (total: number, item: CartItem) => total + item.harga * item.jumlah,
        0
    );
});

// --- DATA TABLE CONFIG ---
const tableHeaders = [
    { key: "kode_transaksi", label: "ID Transaksi" },
    { key: "pengguna.name", label: "Kasir" },
    { key: "items", label: "Total Item" },
    { key: "total_harga", label: "Total Harga" },
    { key: "jenis_pembayaran", label: "Pembayaran" },
    { key: "created_at", label: "Tanggal" },
];

// --- METHODS ---
const openPosModal = () => {
    cart.value = [];
    posForm.reset();
    isPosModalOpen.value = true;
};

const closePosModal = () => {
    isPosModalOpen.value = false;
};

const addToCart = (menu: Menu) => {
    const existingItem = cart.value.find(
        (item) => item.kode_menu === menu.kode_menu
    );
    if (existingItem) {
        existingItem.jumlah++;
    } else {
        cart.value.push({ ...menu, jumlah: 1 });
    }
};

const updateQuantity = (kode_menu: string, amount: number) => {
    const item = cart.value.find((i) => i.kode_menu === kode_menu);
    if (item) {
        item.jumlah += amount;
        if (item.jumlah <= 0) {
            cart.value = cart.value.filter((i) => i.kode_menu !== kode_menu);
        }
    }
};

const submitCashTransaction = () => {
    posForm.total_harga = totalHarga.value;
    posForm.items = cart.value.map((item) => ({
        kode_menu: item.kode_menu,
        jumlah: item.jumlah,
        harga: item.harga,
    }));

    posForm.post(route("admin.cashier.store"), {
        onSuccess: () => closePosModal(),
        preserveScroll: true,
    });
};

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
</script>

<template>
    <Head title="Point of Sale" />
    <AdminLayout>
        <div class="p-4 sm:p-6 lg:p-8">
            <div class="max-w-7xl mx-auto">
                <!-- Header -->
                <div
                    class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8"
                >
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">
                            Point of Sale (Kasir)
                        </h1>
                        <p class="mt-1 text-sm text-gray-600">
                            Buat transaksi tunai baru dan lihat riwayat.
                        </p>
                    </div>
                    <button
                        @click="openPosModal"
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
                        Buat Transaksi Baru
                    </button>
                </div>

                <!-- Riwayat Transaksi -->
                <div
                    class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden"
                >
                    <DataTable
                        :headers="tableHeaders"
                        :items="transaksis?.data || []"
                        :search-keys="['kode_transaksi', 'pengguna.name']"
                    >
                        <template #cell(items)="{ item }">
                            {{
                                item.items.reduce(
                                    (acc: number, curr: { jumlah: number }) =>
                                        acc + curr.jumlah,
                                    0
                                )
                            }}
                            item(s)
                        </template>
                        <template #cell(total_harga)="{ item }">
                            <span class="font-semibold text-green-700">{{
                                formatCurrency(item.total_harga)
                            }}</span>
                        </template>
                        <template #cell(jenis_pembayaran)="{ item }">
                            <span
                                class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800 capitalize"
                            >
                                {{ item.jenis_pembayaran || "N/A" }}
                            </span>
                        </template>
                        <template #cell(created_at)="{ item }">
                            {{ formatDate(item.created_at) }}
                        </template>
                        <template #actions="{ item }">
                            <Link
                                :href="
                                    route(
                                        'admin.transaksi.show',
                                        item.kode_transaksi
                                    )
                                "
                                class="text-indigo-600 hover:text-indigo-900 font-medium"
                            >
                                Lihat
                            </Link>
                        </template>
                    </DataTable>
                </div>
            </div>
        </div>

        <!-- POS Modal -->
        <Modal
            :show="isPosModalOpen"
            @close="closePosModal"
            max-width="4xl"
            title="Buat Transaksi Tunai"
        >
            <form @submit.prevent="submitCashTransaction" class="p-2 sm:p-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Menu Selection -->
                    <div
                        class="bg-gray-50 p-4 rounded-lg border h-[60vh] flex flex-col"
                    >
                        <input
                            type="text"
                            v-model="searchTerm"
                            placeholder="Cari menu..."
                            class="w-full p-2 border rounded-md mb-4 focus:ring-amber-500 focus:border-amber-500"
                        />
                        <div class="overflow-y-auto flex-grow">
                            <!-- Pesan jika tidak ada menu -->
                            <div
                                v-if="filteredMenus.length === 0"
                                class="flex items-center justify-center h-full text-gray-500"
                            >
                                Tidak ada menu yang tersedia.
                            </div>
                            <!-- Tampilkan grid menu jika ada -->
                            <div
                                v-else
                                class="grid grid-cols-2 sm:grid-cols-3 gap-3"
                            >
                                <div
                                    v-for="menu in filteredMenus"
                                    :key="menu.kode_menu"
                                    @click="addToCart(menu)"
                                    class="cursor-pointer group bg-white border rounded-lg p-2 text-center hover:shadow-md hover:border-amber-500 transition-all"
                                >
                                    <img
                                        :src="`${menu.path_img}`"
                                        :alt="menu.nama"
                                        class="w-full h-20 object-cover rounded-md mx-auto mb-2"
                                        v-if="menu.path_img"
                                    />
                                    <div
                                        v-else
                                        class="w-full h-20 bg-gray-200 rounded-md mx-auto mb-2 flex items-center justify-center text-gray-400"
                                    >
                                        ?
                                    </div>
                                    <p
                                        class="text-sm font-semibold text-gray-800 group-hover:text-amber-700 truncate"
                                    >
                                        {{ menu.nama }}
                                    </p>
                                    <p class="text-xs text-gray-500">
                                        {{ formatCurrency(menu.harga) }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Cart -->
                    <div
                        class="bg-white p-4 rounded-lg border h-[60vh] flex flex-col"
                    >
                        <h3 class="text-lg font-bold border-b pb-2 mb-3">
                            Pesanan
                        </h3>
                        <div
                            v-if="cart.length === 0"
                            class="flex-grow flex items-center justify-center text-gray-500"
                        >
                            Keranjang masih kosong
                        </div>
                        <div
                            v-else
                            class="flex-grow overflow-y-auto space-y-3 pr-2"
                        >
                            <div
                                v-for="item in cart"
                                :key="item.kode_menu"
                                class="flex justify-between items-center"
                            >
                                <div>
                                    <p class="font-semibold">{{ item.nama }}</p>
                                    <p class="text-sm text-gray-600">
                                        {{ formatCurrency(item.harga) }}
                                    </p>
                                </div>
                                <div class="flex items-center gap-2">
                                    <button
                                        @click.prevent="
                                            updateQuantity(item.kode_menu, -1)
                                        "
                                        class="w-6 h-6 bg-gray-200 rounded-full text-lg font-bold flex items-center justify-center hover:bg-gray-300"
                                    >
                                        -
                                    </button>
                                    <span class="w-8 text-center font-medium">{{
                                        item.jumlah
                                    }}</span>
                                    <button
                                        @click.prevent="
                                            updateQuantity(item.kode_menu, 1)
                                        "
                                        class="w-6 h-6 bg-gray-200 rounded-full text-lg font-bold flex items-center justify-center hover:bg-gray-300"
                                    >
                                        +
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 border-t pt-4 space-y-3">
                            <textarea
                                v-model="posForm.catatan"
                                placeholder="Catatan pesanan..."
                                rows="2"
                                class="w-full p-2 border rounded-md focus:ring-amber-500 focus:border-amber-500"
                            ></textarea>
                            <div
                                class="flex justify-between items-center text-xl font-bold"
                            >
                                <span>Total:</span>
                                <span>{{ formatCurrency(totalHarga) }}</span>
                            </div>
                            <button
                                type="submit"
                                :disabled="
                                    cart.length === 0 || posForm.processing
                                "
                                class="w-full py-3 bg-green-600 text-white rounded-lg font-bold text-lg hover:bg-green-700 disabled:bg-gray-400"
                            >
                                {{
                                    posForm.processing
                                        ? "Menyimpan..."
                                        : "Simpan Transaksi"
                                }}
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </Modal>
    </AdminLayout>
</template>
