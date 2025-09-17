<script setup lang="ts">
import { computed, ref } from "vue";
import { Head } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";

// 1. Import Chart.js dan komponen vue-chartjs
import { Line as LineChart, Doughnut as DoughnutChart } from "vue-chartjs";
import {
    Chart as ChartJS,
    Title,
    Tooltip,
    Legend,
    LineElement,
    PointElement,
    CategoryScale,
    LinearScale,
    ArcElement,
    Filler,
} from "chart.js";

// 2. Daftarkan modul Chart.js yang akan digunakan
ChartJS.register(
    Title,
    Tooltip,
    Legend,
    LineElement,
    PointElement,
    CategoryScale,
    LinearScale,
    ArcElement,
    Filler
);

// --- TYPE DEFINITIONS ---
interface KpiStats {
    pendapatanHariIni: number;
    transaksiHariIni: number;
    rataRataTransaksi: number;
    menuTerlarisHariIni: { nama: string; terjual: number };
}

interface ChartData {
    labels: string[];
    data: number[];
}

interface StokItem {
    nama: string;
    sisa: number;
    unit: string;
    ambangBatas: number;
}

interface PesananTerbaru {
    id: string;
    pelanggan: string;
    total: number;
    waktu: string;
    items: string[];
}

interface MenuTerlaris {
    nama: string;
    terjual: number;
}

interface Props {
    kpi: KpiStats;
    penjualanPerJam: ChartData;
    tipePesanan: ChartData;
    stokKritis: StokItem[];
    pesananTerbaru: PesananTerbaru[];
    menuTerlarisBulanan: MenuTerlaris[];
}

// --- PROPS DENGAN DUMMY DATA ---
const props = withDefaults(defineProps<Props>(), {
    kpi: () => ({
        pendapatanHariIni: 1850000,
        transaksiHariIni: 42,
        rataRataTransaksi: 44047,
        menuTerlarisHariIni: { nama: "Kopi Susu Gula Aren", terjual: 15 },
    }),
    penjualanPerJam: () => ({
        labels: [
            "08",
            "09",
            "10",
            "11",
            "12",
            "13",
            "14",
            "15",
            "16",
            "17",
            "18",
            "19",
            "20",
            "21",
        ],
        data: [
            150, 250, 180, 120, 200, 300, 280, 400, 350, 220, 180, 150, 100, 80,
        ], // in thousands (Rp)
    }),
    tipePesanan: () => ({
        labels: ["Dine-In", "Takeaway", "Online"],
        data: [70, 110, 45],
    }),
    stokKritis: () => [
        { nama: "Biji Kopi Arabika", sisa: 0.8, unit: "kg", ambangBatas: 1 },
        { nama: "Susu Oat", sisa: 2, unit: "liter", ambangBatas: 3 },
        { nama: "Sirup Karamel", sisa: 1, unit: "botol", ambangBatas: 1 },
    ],
    pesananTerbaru: () => [
        {
            id: "TRX001",
            pelanggan: "Budi Santoso",
            total: 55000,
            waktu: "2 menit lalu",
            items: ["Latte", "Croissant"],
        },
        {
            id: "TRX002",
            pelanggan: "Online #G123",
            total: 40000,
            waktu: "5 menit lalu",
            items: ["Americano", "Americano"],
        },
        {
            id: "TRX003",
            pelanggan: "Citra Lestari",
            total: 28000,
            waktu: "8 menit lalu",
            items: ["Kopi Susu Gula Aren"],
        },
    ],
    menuTerlarisBulanan: () => [
        { nama: "Kopi Susu Gula Aren", terjual: 450 },
        { nama: "Americano", terjual: 310 },
        { nama: "Caffe Latte", terjual: 280 },
        { nama: "V60", terjual: 150 },
        { nama: "Matcha Latte", terjual: 120 },
    ],
});

// --- KONFIGURASI BAGAN ---

const hourlySalesChartData = computed(() => ({
    labels: props.penjualanPerJam.labels.map((l) => `${l}:00`),
    datasets: [
        {
            label: "Pendapatan",
            data: props.penjualanPerJam.data.map((d) => d * 1000), // Convert back from thousands
            borderColor: "#8B5A42",
            backgroundColor: "rgba(139, 90, 66, 0.2)",
            tension: 0.4,
            fill: true,
        },
    ],
}));

const hourlySalesChartOptions = ref({
    responsive: true,
    maintainAspectRatio: false,
    plugins: { legend: { display: false } },
    scales: {
        y: { ticks: { callback: (value: number) => `Rp ${value / 1000}k` } },
        x: { grid: { display: false } },
    },
});

const orderTypeChartData = computed(() => ({
    labels: props.tipePesanan.labels,
    datasets: [
        {
            data: props.tipePesanan.data,
            backgroundColor: ["#A16207", "#CA8A04", "#FACC15"],
            borderColor: "#FFFFFF",
            borderWidth: 2,
        },
    ],
}));

const orderTypeChartOptions = ref({
    responsive: true,
    maintainAspectRatio: false,
    plugins: { legend: { position: "bottom" as const } },
    cutout: "60%",
});

// --- HELPERS ---
const formatCurrency = (value: number) =>
    new Intl.NumberFormat("id-ID", {
        style: "currency",
        currency: "IDR",
        minimumFractionDigits: 0,
    }).format(value);
</script>

<template>
    <Head title="Dashboard" />
    <AdminLayout>
        <div class="p-4 sm:p-6 lg:p-8">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">
                    Ringkasan Kedai Kopi Anda ☕
                </h1>
                <p class="text-gray-600 mt-1">
                    Data penjualan dan operasional terkini.
                </p>
            </div>

            <div
                class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8"
            >
                <div
                    v-for="(item, index) in [
                        {
                            title: 'Pendapatan Hari Ini',
                            value: formatCurrency(kpi.pendapatanHariIni),
                        },
                        {
                            title: 'Transaksi Hari Ini',
                            value: kpi.transaksiHariIni,
                        },
                        {
                            title: 'Rata-rata Transaksi',
                            value: formatCurrency(kpi.rataRataTransaksi),
                        },
                        {
                            title: 'Menu Terlaris Hari Ini',
                            value: kpi.menuTerlarisHariIni.nama,
                        },
                    ]"
                    :key="index"
                    class="bg-white p-6 rounded-xl shadow-md border border-gray-100 flex flex-col justify-between"
                >
                    <div>
                        <p class="text-sm font-medium text-gray-500">
                            {{ item.title }}
                        </p>
                        <p
                            class="text-2xl lg:text-3xl font-bold text-gray-900 mt-1 truncate"
                        >
                            {{ item.value }}
                        </p>
                        <p
                            v-if="item.title === 'Menu Terlaris Hari Ini'"
                            class="text-xs text-gray-500"
                        >
                            {{ kpi.menuTerlarisHariIni.terjual }} terjual
                        </p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                <div class="lg:col-span-2 space-y-6">
                    <div
                        class="bg-white p-6 rounded-xl shadow-md border border-gray-100"
                    >
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">
                            Grafik Penjualan per Jam
                        </h3>
                        <div class="h-80">
                            <LineChart :data="hourlySalesChartData" />
                        </div>
                    </div>
                    <div
                        class="bg-white rounded-xl shadow-md border border-gray-100"
                    >
                        <h3 class="text-lg font-semibold text-gray-800 p-6">
                            Pesanan Terbaru
                        </h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full">
                                <tbody class="divide-y divide-gray-200">
                                    <tr
                                        v-for="order in pesananTerbaru"
                                        :key="order.id"
                                    >
                                        <td class="px-6 py-4">
                                            <p
                                                class="font-medium text-gray-900"
                                            >
                                                {{ order.pelanggan }}
                                            </p>
                                            <p class="text-xs text-gray-500">
                                                {{ order.items.join(", ") }}
                                            </p>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <p
                                                class="font-semibold text-gray-800"
                                            >
                                                {{
                                                    formatCurrency(order.total)
                                                }}
                                            </p>
                                            <p class="text-xs text-gray-500">
                                                {{ order.waktu }}
                                            </p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <div
                        class="bg-white p-6 rounded-xl shadow-md border border-gray-100"
                    >
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">
                            Tipe Pesanan
                        </h3>
                        <div class="h-48 flex items-center justify-center">
                            <DoughnutChart
                                :data="orderTypeChartData"
                                :options="orderTypeChartOptions"
                            />
                        </div>
                    </div>
                    <div
                        class="bg-white p-6 rounded-xl shadow-md border border-gray-100"
                    >
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">
                            ⚠️ Stok Kritis
                        </h3>
                        <ul class="space-y-3">
                            <li
                                v-for="item in stokKritis"
                                :key="item.nama"
                                class="flex justify-between items-center text-sm"
                            >
                                <span class="text-gray-700">{{
                                    item.nama
                                }}</span>
                                <span class="font-bold text-red-600"
                                    >{{ item.sisa }} {{ item.unit }}</span
                                >
                            </li>
                        </ul>
                    </div>
                    <div
                        class="bg-white p-6 rounded-xl shadow-md border border-gray-100"
                    >
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">
                            🏆 Menu Terlaris (Bulan Ini)
                        </h3>
                        <ul class="space-y-3">
                            <li
                                v-for="(menu, index) in menuTerlarisBulanan"
                                :key="menu.nama"
                                class="flex justify-between items-center text-sm"
                            >
                                <span class="text-gray-700"
                                    >{{ index + 1 }}. {{ menu.nama }}</span
                                >
                                <span class="font-semibold text-gray-800">{{
                                    menu.terjual
                                }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
