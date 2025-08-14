<template>
    <AppLayout title="Reservasi">
        <section class="py-12 pt-24">
            <!-- Header Halaman -->
            <div class="text-center mb-16">
                <h2 class="text-5xl font-serif italic mb-6 text-slate-50">
                    Reservasi
                </h2>
                <div class="flex justify-center items-center">
                    <div class="h-px w-16 bg-[#e6dbd1]"></div>
                    <span class="mx-4">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="#e6dbd1"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        >
                            <path d="M17 8h1a4 4 0 1 1 0 8h-1"></path>
                            <path
                                d="M3 8h14v9a4 4 0 0 1-4 4H7a4 4 0 0 1-4-4Z"
                            ></path>
                            <line x1="6" y1="2" x2="6" y2="4"></line>
                            <line x1="10" y1="2" x2="10" y2="4"></line>
                            <line x1="14" y1="2" x2="14" y2="4"></line>
                        </svg>
                    </span>
                    <div class="h-px w-16 bg-[#e6dbd1]"></div>
                </div>
                <p
                    class="text-xl font-light text-slate-50 max-w-3xl mx-auto mt-8"
                >
                    Jadwalkan pengalaman kopi spesial Anda dengan reservasi meja
                    di
                    <span class="font-serif italic text-[#e6dbd1]"
                        >Coffee Shop</span
                    >
                </p>
            </div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col lg:flex-row gap-8">
                    <!-- Kolom Kiri: Denah Meja -->
                    <div class="w-full lg:w-1/2">
                        <div
                            class="bg-white p-6 rounded-xl shadow-sm border border-[#d7cdc3]"
                        >
                            <h3 class="text-2xl font-serif text-[#3a2a1d] mb-4">
                                Denah Meja
                            </h3>
                            <div
                                class="bg-[#f5f1ec] p-4 rounded-lg border border-dashed border-[#d7cdc3]"
                            >
                                <img
                                    src="/images/denah.jpg"
                                    alt="Denah Meja"
                                    class="w-full rounded-lg shadow-sm"
                                />
                            </div>
                        </div>
                    </div>

                    <!-- Kolom Kanan: Pemilihan & Form -->
                    <div class="w-full lg:w-1/2">
                        <TableSelectionGrid
                            :mejas="mejas"
                            :selected-meja-id="selectedMeja?.nomor_meja ?? null"
                            @select="selectMeja"
                        />

                        <!-- Tampilkan pesan jika belum ada meja yang dipilih -->
                        <div
                            v-if="!selectedMeja"
                            class="bg-[#f8f5f2] p-4 mt-6 rounded-lg ..."
                        >
                            <p class="text-sm text-gray-700">
                                Silakan pilih meja yang tersedia...
                            </p>
                        </div>

                        <ReservationForm
                            v-if="selectedMeja"
                            :form="form"
                            @submit="submitReservation"
                        />
                    </div>
                </div>
            </div>
        </section>
    </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from "@/Layouts/AppLayout.vue";
import TableSelectionGrid from "@/components/ui/reservasi/TableSelectionGrid.vue";
import ReservationForm from "@/components/ui/reservasi/ReservationForm.vue";
import { Meja } from "@/types/reservasi";
import { useReservation } from "@/composables/useReservasi";

const props = defineProps<{
    mejas: Meja[];
}>();

// Menggunakan composable untuk mendapatkan state dan fungsi
const { selectedMeja, form, selectMeja, submitReservation } = useReservation(
    props.mejas
);
</script>
