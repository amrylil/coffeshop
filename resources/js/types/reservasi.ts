import { InertiaForm } from "@inertiajs/vue3";

export type TableStatus = "kosong" | "dipesan" | "perbaikan";

export interface Meja {
    nomor_meja: string;
    status: TableStatus;
}

export interface ReservationForm {
    [key: string]: any;
    nomor_meja: string | number | null;
    tanggal_reservasi: string;
    jam_reservasi: string;
    catatan: string;
}
