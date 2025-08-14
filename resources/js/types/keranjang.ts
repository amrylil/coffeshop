import { Menu } from "./menu";

export interface ItemKeranjang {
    kode_item: number;
    kode_keranjang: string;
    kode_menu: string;
    quantity: number;
    price: number;
    menu: Menu;
}

export interface CartDetails {
    keranjang: Keranjang;
    items: ItemKeranjang[];
    total: number;
    count: number;
}

interface Keranjang {
    kode_keranjang: string;
    user_id: string;
}
