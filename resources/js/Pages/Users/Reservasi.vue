<template>
    <AppLayout title="Reservasi">
        <section class="py-12 pt-24">
            <!-- Classic Header -->
            <div class="text-center mb-8 space-y-3">
                <h2 class="text-5xl font-serif italic text-lunen">Reservasi</h2>
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
                <p class="text-xl font-light text-lunen max-w-3xl mx-auto">
                    Jadwalkan pengalaman kopi spesial Anda dengan reservasi meja
                    di
                    <span class="font-serif italic text-[#e6dbd1]"
                        >Coffee Shop</span
                    >
                </p>
            </div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                    <!-- Floor Plan Section -->
                    <div class="space-y-8">
                        <div class="bg-lunen border border-stone-200 shadow-sm">
                            <div class="border-b border-coklat px-8 py-6">
                                <h2
                                    class="text-2xl font-serif text-stone-800 flex items-center"
                                >
                                    <svg
                                        class="w-6 h-6 mr-3"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H9m11 0a1 1 0 01-1 1H4a1 1 0 01-1-1m15-5V9a2 2 0 00-2-2H7a2 2 0 00-2-2m3 8h1m4 0h1"
                                        />
                                    </svg>
                                    Floor Plan
                                </h2>
                            </div>
                            <div class="p-8">
                                <div
                                    class="bg-coklat border border-stone-300 p-6"
                                >
                                    <img
                                        src="/images/denah.jpg"
                                        alt="Restaurant Floor Plan"
                                        class="w-full border border-stone-200 shadow-sm"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Table Selection & Form Section -->
                    <div class="space-y-8">
                        <!-- Table Selection -->
                        <div class="bg-lunen border border-stone-200 shadow-sm">
                            <div class="border-b border-coklat px-8 py-6">
                                <h2
                                    class="text-2xl font-serif text-stone-800 flex items-center"
                                >
                                    <svg
                                        class="w-6 h-6 mr-3"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v6a2 2 0 002 2h2m0-8v8m0-8V3m0 16v-2m3-2V7a2 2 0 012-2h2a2 2 0 012 2v6a2 2 0 01-2 2h-2m-3 2V3"
                                        />
                                    </svg>
                                    Select Your Table
                                </h2>
                            </div>
                            <div class="p-8">
                                <TableSelectionGrid
                                    :mejas="mejas"
                                    :selected-meja-id="
                                        selectedMeja?.nomor_meja ?? null
                                    "
                                    @select="selectMeja"
                                />
                            </div>
                        </div>

                        <!-- Instruction Message -->
                        <div
                            v-if="!selectedMeja"
                            class="bg-stone-100 border border-stone-300 p-6"
                        >
                            <div class="flex items-center">
                                <svg
                                    class="w-5 h-5 text-stone-500 mr-3"
                                    fill="currentColor"
                                    viewBox="0 0 20 20"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                                <p class="text-stone-600 font-medium">
                                    Please select an available table from the
                                    grid above to proceed with your reservation.
                                </p>
                            </div>
                        </div>

                        <!-- Selected Table Info -->
                        <div
                            v-if="selectedMeja"
                            class="bg-lunen border border-stone-200 shadow-sm"
                        >
                            <div
                                class="border-b border-stone-200 px-8 py-4 bg-stone-50"
                            >
                                <h3 class="font-serif text-lg text-stone-800">
                                    Selected Table
                                </h3>
                            </div>
                            <div class="p-6">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h4 class="font-medium text-stone-800">
                                            Table {{ selectedMeja.nomor_meja }}
                                        </h4>
                                        <p class="text-stone-600 text-sm">
                                            Capacity: 4
                                        </p>
                                    </div>
                                    <div class="text-right">
                                        <span
                                            class="inline-block px-3 py-1 bg-green-100 text-green-800 text-sm font-medium border border-green-200"
                                        >
                                            Available
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Reservation Form -->
                        <div
                            v-if="selectedMeja"
                            class="bg-lunen border border-stone-200 shadow-sm"
                        >
                            <div class="border-b border-stone-200 px-8 py-6">
                                <h2
                                    class="text-2xl font-serif text-stone-800 flex items-center"
                                >
                                    <svg
                                        class="w-6 h-6 mr-3"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                                        />
                                    </svg>
                                    Reservation Details
                                </h2>
                            </div>
                            <div class="p-8">
                                <ReservationForm
                                    :form="form"
                                    @submit="submitReservation"
                                />
                            </div>
                        </div>
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

const { selectedMeja, form, selectMeja, submitReservation } = useReservation(
    props.mejas
);
</script>
