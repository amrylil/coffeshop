<script setup lang="ts">
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link } from "@inertiajs/vue3";
import { Menu } from "@/types/menu";
import CardMenu from "@/components/ui/CardMenu.vue";
defineProps<{
    latestMenus: Menu[];
}>();
</script>

<template>
    <AppLayout title="Home">
        <section class="flex flex-col md:flex-row text-center">
            <div
                class="bg-[#523433] w-full md:w-1/2 p-10 md:pl-24 md:pt-40 md:px-10 flex flex-col justify-center items-center"
            >
                <h1
                    class="font text-[#e6dbd1] font-playfair text-5xl md:text-7xl font-bold mb-8"
                >
                    Saatnya Menikmati Kopi
                </h1>
                <p class="text-[#e6dbd1] text-lg mb-12 max-w-2xl mx-auto">
                    Jika Anda minum kopi secara teratur, Anda akan tahu
                    perbedaan antara kopi segar dan kopi lama. Tujuan kami
                    adalah menyediakan dua buku kopi yang relevan setiap
                    harinya.
                </p>
                <div
                    class="flex flex-col sm:flex-row justify-center gap-6 mb-10 md:mb-20"
                >
                    <Link
                        href="/menu"
                        class="bg-amber-600 text-[#e6dbd1] px-8 py-4 rounded-full hover:bg-amber-700 transition"
                    >
                        Jelajahi Toko
                    </Link>
                    <button
                        class="border-2 border-amber-600 text-amber-600 px-8 py-4 rounded-full hover:bg-amber-600/10 transition"
                    >
                        Buat Sendiri
                    </button>
                </div>
            </div>
            <div class="w-full md:w-1/2 h-64 md:h-screen">
                <img
                    class="w-full h-full object-cover"
                    src="/images/bannercoffe.jpg"
                    alt="Banner Kopi"
                />
            </div>
        </section>

        <section class="bg-[#422424] p-10 md:p-24">
            <div
                class="flex flex-col md:flex-row justify-between items-center mb-12 md:mb-20 text-center md:text-left"
            >
                <h3
                    class="text-4xl md:text-5xl text-[#e6dbd1] font-playfair font-bold mb-6 md:mb-0"
                >
                    Sajian Terbaik <br />
                    Dari Proses Berkualitas
                </h3>
                <p class="w-full md:w-96 text-[#e6dbd1]">
                    Kami menyajikan kopi dengan standar kualitas tertinggi.
                    Setiap proses pembuatan kopi kami dilakukan dengan penuh
                    ketelitian untuk menghasilkan cita rasa yang sempurna.
                </p>
            </div>
            <div
                class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8 text-[#e6dbd1]"
            >
                <div
                    class="p-6 bg-[#523433] rounded-lg flex justify-center items-center flex-col gap-4 text-center"
                >
                    <img
                        src="/svg/sangrai.svg"
                        alt="Kopi Biji"
                        class="w-16 h-16"
                    />

                    <h4 class="text-xl font-bold mb-4">Sangrai Tangan</h4>
                </div>
                <div
                    class="p-6 bg-[#523433] rounded-lg flex justify-center items-center flex-col gap-4 text-center"
                >
                    <img
                        src="/svg/kopi.svg"
                        alt="Kopi Biji"
                        class="w-16 h-16"
                    />
                    <h4 class="text-xl font-bold mb-4">Kopi Organik</h4>
                </div>
                <div
                    class="p-6 bg-[#523433] rounded-lg flex justify-center items-center flex-col gap-4 text-center"
                >
                    <img
                        src="/svg/mesin.svg"
                        alt="Kopi Biji"
                        class="w-16 h-16"
                    />

                    <h4 class="text-xl font-bold mb-4">Kopi Langsung</h4>
                </div>
            </div>
        </section>

        <section
            class="bg-[#523433] py-16 px-6 sm:px-12 md:px-24 text-[#e6dbd1] text-center"
        >
            <h2
                class="text-4xl md:text-5xl font-extrabold mb-4 drop-shadow font-jost"
            >
                Produk Terbaru Kami
            </h2>
            <p class="max-w-xl mx-auto mb-12 text-gray-300">
                Kami selalu berusaha menghadirkan kopi single origin dari
                berbagai daerah dengan rasa yang khas. Ditujukan untuk para
                penikmat kopi sejati.
            </p>

            <div
                class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 max-w-7xl mx-auto"
            >
                <CardMenu
                    v-for="menu in latestMenus"
                    :key="menu.kode_menu"
                    :menu="menu"
                />
            </div>
        </section>

        <section class="bg-[#e6dbd1] py-16 px-6 sm:px-12 md:px-24">
            <div
                class="flex flex-col lg:flex-row justify-between items-center text-center lg:text-left"
            >
                <div class="space-y-6 lg:w-1/2">
                    <h2 class="text-4xl font-bold text-[#3C1E1E] leading-tight">
                        Reservasi Meja Lebih Mudah
                    </h2>
                    <p class="text-gray-700 text-lg lg:pr-20">
                        Hindari antrian dan pastikan kenyamananmu. Reservasi
                        meja secara online hanya dengan beberapa klik. Waktu
                        berharga kamu tak akan terbuang sia-sia.
                    </p>
                    <a
                        href="#"
                        class="inline-block bg-[#3C1E1E] text-white px-6 py-3 rounded-full font-medium hover:bg-[#2a1616] transition"
                    >
                        Reservasi Sekarang
                    </a>
                </div>
                <div
                    class="mt-10 lg:mt-0 lg:w-1/2 flex justify-center lg:justify-end"
                >
                    <img
                        src="images/reservasi.jpg"
                        alt="Reservasi Meja"
                        class="max-w-sm md:max-w-md w-full rounded-xl shadow-lg object-cover"
                    />
                </div>
            </div>
        </section>
    </AppLayout>
</template>

<style>
/* 6. Memindahkan CSS dari @section('scripts') ke dalam tag <style> */
/* Animasi Fade-in untuk Kartu Produk */
.Menu-card {
    opacity: 0;
    transform: translateY(20px);
    animation: fadeInUp 0.5s ease-out forwards;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>
