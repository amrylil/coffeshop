<template>
    <div class="bg-white p-6 rounded-xl shadow-sm border border-[#d7cdc3]">
        <h3 class="text-2xl font-serif text-[#3a2a1d] mb-6">Pilih Meja</h3>
        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 mb-6">
            <div
                v-for="meja in mejas"
                :key="meja.nomor_meja"
                class="relative p-4 rounded-lg text-center transition transform duration-200 border"
                :class="getTableClasses(meja)"
                @click="$emit('select', meja)"
            >
                <!-- Ikon Meja -->
                <div class="flex justify-center mb-2">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="32"
                        height="32"
                        viewBox="0 0 24 24"
                        fill="none"
                        :stroke="getIconColor(meja.status)"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <rect x="4" y="8" width="16" height="12" rx="2"></rect>
                        <path d="M6 4h12"></path>
                        <path d="M8 4v4"></path>
                        <path d="M16 4v4"></path>
                    </svg>
                </div>
                <!-- Nomor Meja -->
                <div class="font-medium" :class="getTextColor(meja.status)">
                    {{ meja.nomor_meja }}
                </div>
                <!-- Status Meja -->
                <div
                    class="text-sm mt-1 capitalize"
                    :class="getTextColor(meja.status)"
                >
                    {{ meja.status }}
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { Meja, TableStatus } from "@/types/reservasi";

const props = defineProps<{
    mejas: Meja[];
    selectedMejaId: string | null;
}>();

defineEmits<{
    (e: "select", meja: Meja): void;
}>();

const getTableClasses = (meja: Meja) => {
    const isSelected = props.selectedMejaId === meja.nomor_meja;
    const baseClasses = isSelected ? "ring-2 ring-[#6f4e37] ring-offset-2" : "";

    switch (meja.status) {
        case "kosong":
            return `bg-green-50 border-green-200 hover:shadow-md hover:scale-105 cursor-pointer ${baseClasses}`;
        case "dipesan":
            return `bg-yellow-50 border-yellow-200 opacity-75 cursor-not-allowed ${baseClasses}`;
        case "perbaikan":
            return `bg-red-50 border-red-200 opacity-75 cursor-not-allowed ${baseClasses}`;
        default:
            return "";
    }
};

const getIconColor = (status: TableStatus) =>
    ({ kosong: "#16a34a", dipesan: "#ca8a04", perbaikan: "#dc2626" }[status]);
const getTextColor = (status: TableStatus) =>
    ({
        kosong: "text-green-700",
        dipesan: "text-yellow-700",
        perbaikan: "text-red-700",
    }[status]);
</script>
