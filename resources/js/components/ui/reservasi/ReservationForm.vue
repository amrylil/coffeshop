<template>
    <div class="mt-8 relative">
        <!-- Header dengan subtle background -->
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
                    Lengkapi informasi reservasi Anda
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
                                :value="form.nomor_meja"
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

                    <!-- Input Nama Pelanggan -->
                    <div class="group">
                        <label
                            for="nama_pelanggan"
                            class="block text-sm font-semibold text-gray-800 mb-3"
                        >
                            Nama Pemesan
                        </label>
                        <div class="relative">
                            <input
                                type="text"
                                v-model="form.nama_pelanggan"
                                required
                                class="w-full rounded-xl border-2 border-gray-200 px-6 py-4 text-lg placeholder-gray-400 transition-all duration-200 focus:border-[#6f4e37] focus:ring-4 focus:ring-[#6f4e37]/10 focus:outline-none shadow-sm hover:border-gray-300"
                                placeholder="Masukkan nama lengkap"
                            />
                            <div
                                class="absolute right-4 top-1/2 transform -translate-y-1/2"
                            >
                                <svg
                                    class="w-5 h-5 text-gray-300"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                                    ></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Input No Telepon -->
                    <div class="group">
                        <label
                            for="no_telepon"
                            class="block text-sm font-semibold text-gray-800 mb-3"
                        >
                            Nomor Telepon
                        </label>
                        <div class="relative">
                            <input
                                type="tel"
                                v-model="form.no_telepon"
                                required
                                class="w-full rounded-xl border-2 border-gray-200 px-6 py-4 text-lg placeholder-gray-400 transition-all duration-200 focus:border-[#6f4e37] focus:ring-4 focus:ring-[#6f4e37]/10 focus:outline-none shadow-sm hover:border-gray-300"
                                placeholder="08xxxxxxxxxx"
                            />
                            <div
                                class="absolute right-4 top-1/2 transform -translate-y-1/2"
                            >
                                <svg
                                    class="w-5 h-5 text-gray-300"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"
                                    ></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Input Tanggal dan Jam -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="group">
                            <label
                                for="tanggal"
                                class="block text-sm font-semibold text-gray-800 mb-3"
                            >
                                Tanggal Reservasi
                            </label>
                            <div class="relative">
                                <input
                                    type="date"
                                    v-model="form.tanggal"
                                    required
                                    class="w-full rounded-xl border-2 border-gray-200 px-6 py-4 text-lg transition-all duration-200 focus:border-[#6f4e37] focus:ring-4 focus:ring-[#6f4e37]/10 focus:outline-none shadow-sm hover:border-gray-300"
                                />
                            </div>
                        </div>

                        <div class="group">
                            <label
                                for="jam"
                                class="block text-sm font-semibold text-gray-800 mb-3"
                            >
                                Jam Reservasi
                            </label>
                            <div class="relative">
                                <input
                                    type="time"
                                    v-model="form.jam"
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
                                placeholder="Tambahkan permintaan khusus atau catatan lainnya..."
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

                    <!-- Info tambahan -->
                    <div
                        class="bg-blue-50 border border-blue-200 rounded-xl p-4 mt-6"
                    >
                        <div class="flex items-start">
                            <svg
                                class="w-5 h-5 text-blue-500 mt-0.5 mr-3 flex-shrink-0"
                                fill="currentColor"
                                viewBox="0 0 20 20"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                    clip-rule="evenodd"
                                ></path>
                            </svg>
                            <div>
                                <h4 class="font-semibold text-blue-800 text-sm">
                                    Informasi Reservasi
                                </h4>
                                <p class="text-blue-700 text-sm mt-1">
                                    Konfirmasi reservasi akan dikirim melalui
                                    WhatsApp ke nomor yang Anda berikan.
                                </p>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { InertiaForm } from "@inertiajs/vue3";
import { ReservationForm } from "@/types/reservasi";

defineProps<{
    form: InertiaForm<ReservationForm>;
}>();

defineEmits<{
    (e: "submit"): void;
}>();
</script>
