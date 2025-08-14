// types/menu.ts

export interface Category {
    kode_kategori: string;
    nama: string;
    deskripsi?: string;
    path_img?: string;
}

export interface Menu {
    kode_menu: string;
    nama: string;
    deskripsi?: string;
    harga: number;
    path_img?: string;
    jumlah: number;
    created_at?: string;
    kategori: Category;
}

export interface PaginationLink {
    url?: string | null;
    label: string;
    active: boolean;
}

export interface PaginatedMenus {
    current_page: number;
    data: Menu[];
    first_page_url: string;
    from: number | null;
    last_page: number;
    last_page_url: string;
    links: PaginationLink[];
    next_page_url: string | null;
    path: string;
    per_page: number;
    prev_page_url: string | null;
    to: number | null;
    total: number;
}

// DIUBAH: Menerima object 'filters' yang dikirim dari controller
export interface MenuPageProps {
    menu: PaginatedMenus;
    categories: Category[];
    auth: {
        user?: {
            id: number;
            name: string;
            email: string;
        };
    };
    filters: {
        search?: string;
        category?: string;
        sort_by?: string;
        sort_direction?: string;
    };
}

export interface CartItem {
    kode_menu: string;
    quantity: number;
}

export interface ApiResponse<T = any> {
    success: boolean;
    message?: string;
    data?: T;
    count?: number;
}

export type ToastType = "success" | "error";
