// composables/useReservation.ts

import { ref, computed } from "vue";
import { useForm } from "@inertiajs/vue3";
import { route } from "ziggy-js";
import { Meja, ReservationForm } from "@/types/reservasi";

/**
 * Composable untuk mengelola state dan logika halaman reservasi.
 * @param mejas - Daftar meja yang tersedia dari props.
 */
export function useReservation(mejas: Meja[]) {
    const selectedMeja = ref<Meja | null>(null);

    const form = useForm<ReservationForm>({
        nomor_meja: null,
        nama_pelanggan: "",
        no_telepon: "",
        tanggal_reservasi: "",
        jam_reservasi: "",
        catatan: "",
    });

    const selectMeja = (meja: Meja) => {
        console.log("Meja yang diklik:", meja);

        console.log("Status meja:", `'${meja.status}'`);

        // 3. Cek hasil perbandingannya
        console.log('Apakah statusnya "kosong"?', meja.status === "kosong");
        if (meja.status === "kosong") {
            console.log("Kondisi terpenuhi! Memilih meja...");
            if (selectedMeja.value?.nomor_meja === meja.nomor_meja) {
                selectedMeja.value = null;
                form.nomor_meja = null;
            } else {
                selectedMeja.value = meja;
                form.nomor_meja = meja.nomor_meja;
            }
        } else {
            console.log("Meja tidak kosong, tidak bisa dipilih.");
            // Tampilkan pesan atau lakukan tindakan lain jika meja tidak kosong
        }
    };

    const submitReservation = () => {
        form.post(route("reservasi.store"), {
            preserveScroll: true,
            onSuccess: () => {
                form.reset();
                selectedMeja.value = null;
            },
        });
    };

    return {
        selectedMeja,
        form,
        selectMeja,
        submitReservation,
    };
}
