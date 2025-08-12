// resources/js/types/index.d.ts

export interface User {
    id: number;
    name: string;
    email: string;
    profile_photo: string | null;
    initials: string;
}

// Anda bisa menambahkan tipe lain di sini
export interface Product {
    id: number;
    name: string;
    price: number;
    image_url: string;
}
