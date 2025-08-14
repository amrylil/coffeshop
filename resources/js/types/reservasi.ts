export type TableStatus = "kosong" | "dipesan" | "perbaikan";

export interface Meja {
    nomor_meja: string;
    status: TableStatus;
}

export interface ReservationForm {
    [key: string]: any;
    nomor_meja: string | null;
    nama_pelanggan: string;
    no_telepon: string;
    tanggal_reservasi: string;
    jam_reservasi: string;
    catatan: string | null;
}
