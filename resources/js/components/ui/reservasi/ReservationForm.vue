<template>
    <div class="mt-8 relative">
        <!-- Card container -->
        <div
            class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden"
        >
            <!-- Header Section -->
            <div
                class="bg-gradient-to-r from-slate-50 to-gray-50 px-8 py-6 border-b border-gray-100"
            >
                <h3 class="text-2xl font-bold text-gray-900 tracking-tight">
                    Detail Reservasi
                </h3>
                <p class="text-gray-600 mt-1 text-sm">
                    Lengkapi waktu dan detail reservasi Anda.
                </p>
            </div>

            <!-- Form Section -->
            <div class="px-8 py-8">
                <form @submit.prevent="$emit('submit')" class="space-y-6">
                    <!-- Input Nomor Meja (Read-only) -->
                    <div class="group">
                        <label
                            for="nomor_meja"
                            class="block text-sm font-semibold text-gray-800 mb-3"
                        >
                            Meja yang Dipilih
                        </label>
                        <div class="relative">
                            <input
                                type="text"
                                name="nomor_meja"
                                :value="
                                    form.nomor_meja || 'Pilih meja dari denah'
                                "
                                class="w-full bg-gradient-to-r from-gray-50 to-slate-50 rounded-xl border-2 border-gray-200 px-6 py-4 text-lg font-medium text-gray-700 shadow-sm transition-all duration-200"
                                readonly
                            />
                            <div
                                class="absolute right-4 top-1/2 transform -translate-y-1/2"
                            >
                                <svg
                                    class="w-5 h-5 text-gray-400"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M9 12l2 2 4-4"
                                    ></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Input Tanggal dan Jam -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="group">
                            <label
                                for="tanggal_reservasi"
                                class="block text-sm font-semibold text-gray-800 mb-3"
                            >
                                Tanggal Reservasi
                            </label>
                            <div class="relative">
                                <input
                                    type="date"
                                    v-model="form.tanggal_reservasi"
                                    required
                                    class="w-full rounded-xl border-2 border-gray-200 px-6 py-4 text-lg transition-all duration-200 focus:border-[#6f4e37] focus:ring-4 focus:ring-[#6f4e37]/10 focus:outline-none shadow-sm hover:border-gray-300"
                                />
                            </div>
                        </div>

                        <div class="group">
                            <label
                                for="jam_reservasi"
                                class="block text-sm font-semibold text-gray-800 mb-3"
                            >
                                Jam Reservasi
                            </label>
                            <div class="relative">
                                <input
                                    type="time"
                                    v-model="form.jam_reservasi"
                                    required
                                    class="w-full rounded-xl border-2 border-gray-200 px-6 py-4 text-lg transition-all duration-200 focus:border-[#6f4e37] focus:ring-4 focus:ring-[#6f4e37]/10 focus:outline-none shadow-sm hover:border-gray-300"
                                />
                            </div>
                        </div>
                    </div>

                    <!-- Input Catatan -->
                    <div class="group">
                        <label
                            for="catatan"
                            class="block text-sm font-semibold text-gray-800 mb-3"
                        >
                            Catatan Khusus
                            <span class="text-gray-500 font-normal"
                                >(Opsional)</span
                            >
                        </label>
                        <div class="relative">
                            <textarea
                                v-model="form.catatan"
                                rows="4"
                                class="w-full rounded-xl border-2 border-gray-200 px-6 py-4 text-lg placeholder-gray-400 transition-all duration-200 focus:border-[#6f4e37] focus:ring-4 focus:ring-[#6f4e37]/10 focus:outline-none shadow-sm hover:border-gray-300 resize-none"
                                placeholder="Tambahkan permintaan khusus..."
                            ></textarea>
                        </div>
                    </div>

                    <!-- Tombol Submit -->
                    <div class="pt-4">
                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="group relative w-full bg-[#6f4e37] text-white py-4 px-8 rounded-xl font-semibold text-lg shadow-lg transition-all duration-200 hover:bg-[#5d4130] hover:shadow-xl hover:-translate-y-0.5 focus:outline-none focus:ring-4 focus:ring-[#6f4e37]/20 disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:transform-none overflow-hidden"
                        >
                            <!-- Loading overlay -->
                            <div
                                v-if="form.processing"
                                class="absolute inset-0 bg-[#5d4130] flex items-center justify-center"
                            >
                                <svg
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
                                <span>Memproses...</span>
                            </div>

                            <!-- Normal state -->
                            <div
                                v-else
                                class="flex items-center justify-center"
                            >
                                <svg
                                    class="w-5 h-5 mr-2 group-hover:scale-110 transition-transform duration-200"
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
                                <span>Konfirmasi Reservasi</span>
                            </div>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ReservationForm } from "@/types/reservasi";
import { InertiaForm } from "@inertiajs/vue3";

defineProps<{
    form: InertiaForm<ReservationForm>;
}>();

defineEmits<{
    (e: "submit"): void;
}>();
</script>
