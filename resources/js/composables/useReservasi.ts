import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import { route } from "ziggy-js";
import { Meja, ReservationForm } from "@/types/reservasi";

export function useReservation(mejas: Meja[]) {
    const selectedMeja = ref<Meja | null>(null);

    const form = useForm<ReservationForm>({
        nomor_meja: null,
        tanggal_reservasi: "",
        jam_reservasi: "",
        catatan: "",
    });

    const selectMeja = (meja: Meja) => {
        if (meja.status === "kosong") {
            if (selectedMeja.value?.nomor_meja === meja.nomor_meja) {
                selectedMeja.value = null;
                form.nomor_meja = null;
            } else {
                selectedMeja.value = meja;
                form.nomor_meja = meja.nomor_meja;
            }
        } else {
            console.warn(
                `Meja ${meja.nomor_meja} tidak tersedia (status: ${meja.status}).`
            );
        }
    };

    const submitReservation = () => {
        // Pastikan meja sudah dipilih sebelum submit
        if (!form.nomor_meja) {
            alert("Silakan pilih meja terlebih dahulu.");
            return;
        }

        form.post(route("reservasi.store"), {
            preserveScroll: true,
            onSuccess: () => {
                form.reset();
                selectedMeja.value = null;
            },
            onError: (errors) => {
                console.error("Gagal membuat reservasi:", errors);
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
