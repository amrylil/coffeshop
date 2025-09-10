import { User } from ".";

export interface Meja {
    id: number;
    nomor_meja: string;
    kapasitas: number;
    status: "kosong" | "dipesan" | "digunakan";
}

export interface MejaStats {
    total: number;
    kosong: number;
    dipesan: number;
    digunakan: number;
}

export type PageProps<
    T extends Record<string, unknown> = Record<string, unknown>
> = T & {
    auth: {
        user: User;
    };
    flash: {
        success: string | null;
        error: string | null;
    };
};
