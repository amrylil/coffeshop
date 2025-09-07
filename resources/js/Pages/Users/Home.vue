<script setup lang="ts">
import { onMounted, onUnmounted } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link } from "@inertiajs/vue3";
import { Menu } from "@/types/menu";
import CardMenu from "@/components/ui/CardMenu.vue";

defineProps<{
    latestMenus: Menu[];
}>();

// Logika untuk Intersection Observer
let observer: IntersectionObserver;

onMounted(() => {
    // Inisialisasi observer
    observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                // Jika elemen masuk ke viewport, tambahkan kelas 'is-visible'
                if (entry.isIntersecting) {
                    entry.target.classList.add("is-visible");
                    // Opsional: berhenti mengamati setelah animasi berjalan sekali
                    observer.unobserve(entry.target);
                }
            });
        },
        {
            // Opsi: animasi akan terpicu saat elemen 10% terlihat
            threshold: 0.1,
        }
    );

    // Ambil semua elemen yang ingin dianimasikan
    const animatedElements = document.querySelectorAll(".animate-on-scroll");
    animatedElements.forEach((el) => observer.observe(el));
});

onUnmounted(() => {
    // Hentikan observer saat komponen dihancurkan untuk mencegah memory leak
    if (observer) {
        observer.disconnect();
    }
});
</script>

<template>
    <AppLayout title="Home">
        <section class="flex flex-col md:flex-row text-center">
            <div
                class="bg-[#523433] w-full md:w-1/2 p-10 md:pl-24 md:pt-40 md:px-10 flex flex-col justify-center items-center"
            >
                <h1
                    class="font text-[#e6dbd1] font-playfair text-5xl md:text-7xl font-bold mb-8 animate-on-scroll"
                >
                    Saatnya Menikmati Kopi
                </h1>
                <p
                    class="text-[#e6dbd1] text-lg mb-12 max-w-2xl mx-auto animate-on-scroll"
                >
                    Jika Anda minum kopi secara teratur, Anda akan tahu
                    perbedaan antara kopi segar dan kopi lama. Tujuan kami
                    adalah menyediakan dua buku kopi yang relevan setiap
                    harinya.
                </p>
                <div
                    class="flex flex-col sm:flex-row justify-center gap-6 mb-10 md:mb-20 animate-on-scroll"
                >
                    <Link
                        href="/menu"
                        class="bg-lunen text-coklat border border-black px-8 py-4 hover:brightness-90 transition"
                    >
                        Jelajahi Toko
                    </Link>
                    <button
                        class="border-2 border-lunen text-lunen px-8 py-4 hover:bg-amber-600/10 transition"
                    >
                        Cari Kopi
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

        <section class="bg-[#422424] p-10 md:p-24 animate-on-scroll">
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
                    class="p-6 bg-[#523433] flex justify-center items-center flex-col gap-4 text-center animate-on-scroll"
                    style="transition-delay: 100ms"
                >
                    <img
                        src="/svg/sangrai.svg"
                        alt="Kopi Biji"
                        class="w-16 h-16"
                    />
                    <h4 class="text-xl font-bold mb-4">Sangrai Tangan</h4>
                </div>
                <div
                    class="p-6 bg-[#523433] flex justify-center items-center flex-col gap-4 text-center animate-on-scroll"
                    style="transition-delay: 200ms"
                >
                    <img
                        src="/svg/kopi.svg"
                        alt="Kopi Biji"
                        class="w-16 h-16"
                    />
                    <h4 class="text-xl font-bold mb-4">Kopi Organik</h4>
                </div>
                <div
                    class="p-6 bg-[#523433] flex justify-center items-center flex-col gap-4 text-center animate-on-scroll"
                    style="transition-delay: 300ms"
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
            class="bg-[#523433] py-16 px-6 sm:px-12 md:px-24 text-[#e6dbd1] text-center animate-on-scroll"
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
                    v-for="(menu, index) in latestMenus"
                    :key="menu.kode_menu"
                    :menu="menu"
                    class="animate-on-scroll"
                    :style="{ 'transition-delay': `${index * 100}ms` }"
                />
            </div>
        </section>

        <section
            class="bg-[#e6dbd1] py-16 px-6 sm:px-12 md:px-24 animate-on-scroll"
        >
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
                        class="inline-block bg-coklat text-white px-6 py-3 font-medium hover:brightness-90 transition"
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
                        class="max-w-sm md:max-w-md w-full border-2 border-coklat shadow-lg object-cover"
                    />
                </div>
            </div>
        </section>

        <section
            class="bg-[#422424] py-16 px-6 sm:px-12 md:px-24 animate-on-scroll"
        >
            <div class="max-w-7xl mx-auto text-center">
                <h2
                    class="text-4xl md:text-5xl font-playfair font-bold text-[#e6dbd1] mb-4"
                >
                    Kata Mereka Tentang Kami
                </h2>
                <p class="max-w-2xl mx-auto mb-12 text-gray-300">
                    Kami bangga dapat menyajikan pengalaman terbaik bagi setiap
                    pelanggan. Lihat apa kata mereka.
                </p>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div
                        class="bg-[#523433] p-8 rounded-lg animate-on-scroll"
                        style="transition-delay: 100ms"
                    >
                        <img
                            src="https://i.pravatar.cc/100?u=a"
                            alt="Pelanggan 1"
                            class="w-20 h-20 rounded-full mx-auto mb-4 border-2 border-[#e6dbd1]"
                        />
                        <p class="text-[#e6dbd1] italic mb-6">
                            "Kopi terbaik yang pernah saya coba di kota ini.
                            Suasananya juga sangat nyaman untuk bekerja. Pasti
                            akan kembali lagi!"
                        </p>
                        <h4 class="font-bold text-white text-lg">
                            Andi Pratama
                        </h4>
                        <p class="text-gray-400">Pekerja Lepas</p>
                    </div>
                    <div
                        class="bg-[#523433] p-8 rounded-lg animate-on-scroll"
                        style="transition-delay: 200ms"
                    >
                        <img
                            src="https://i.pravatar.cc/100?u=b"
                            alt="Pelanggan 2"
                            class="w-20 h-20 rounded-full mx-auto mb-4 border-2 border-[#e6dbd1]"
                        />
                        <p class="text-[#e6dbd1] italic mb-6">
                            "Pilihan biji kopinya sangat beragam dan baristanya
                            ramah. Saya sangat merekomendasikan V60 mereka,
                            rasanya luar biasa."
                        </p>
                        <h4 class="font-bold text-white text-lg">
                            Siti Nurhaliza
                        </h4>
                        <p class="text-gray-400">Pecinta Kopi</p>
                    </div>
                    <div
                        class="bg-[#523433] p-8 rounded-lg animate-on-scroll"
                        style="transition-delay: 300ms"
                    >
                        <img
                            src="https://i.pravatar.cc/100?u=c"
                            alt="Pelanggan 3"
                            class="w-20 h-20 rounded-full mx-auto mb-4 border-2 border-[#e6dbd1]"
                        />
                        <p class="text-[#e6dbd1] italic mb-6">
                            "Tempat yang sempurna untuk bersantai di akhir
                            pekan. Makanan ringannya juga enak, cocok dipadukan
                            dengan latte."
                        </p>
                        <h4 class="font-bold text-white text-lg">
                            Budi Santoso
                        </h4>
                        <p class="text-gray-400">Mahasiswa</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="bg-[#e6dbd1] py-16 px-6 sm:px-12 md:px-24">
            <div
                class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-12 items-center"
            >
                <div class="animate-on-scroll text-center lg:text-left">
                    <h2
                        class="text-4xl md:text-5xl font-playfair font-bold text-[#3C1E1E] mb-6"
                    >
                        Kunjungi Kedai Kami
                    </h2>
                    <p class="text-gray-700 text-lg mb-8">
                        Kami tidak sabar untuk menyambut Anda. Nikmati secangkir
                        kopi hangat di tempat kami yang nyaman.
                    </p>

                    <div class="space-y-4">
                        <div
                            class="flex items-center justify-center lg:justify-start gap-4"
                        >
                            <svg
                                class="w-6 h-6 text-coklat"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"
                                ></path>
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"
                                ></path>
                            </svg>
                            <span class="text-gray-800"
                                >Jl. Kopi Nikmat No. 123, Kendari, Sulawesi
                                Tenggara</span
                            >
                        </div>
                        <div
                            class="flex items-center justify-center lg:justify-start gap-4"
                        >
                            <svg
                                class="w-6 h-6 text-coklat"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                                ></path>
                            </svg>
                            <div>
                                <p class="text-gray-800 font-bold">
                                    Senin - Jumat:
                                    <span class="font-normal"
                                        >08:00 - 22:00</span
                                    >
                                </p>
                                <p class="text-gray-800 font-bold">
                                    Sabtu - Minggu:
                                    <span class="font-normal"
                                        >09:00 - 23:00</span
                                    >
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div
                    class="w-full h-80 animate-on-scroll"
                    style="transition-delay: 200ms"
                >
                    <img
                        src="/images/map-dummy.png"
                        alt="Peta Lokasi"
                        class="w-full h-full object-cover rounded-lg shadow-xl border-4 border-white"
                    />
                </div>
            </div>
        </section>
    </AppLayout>
</template>

<style>
/* CSS untuk Scroll Animation */
.animate-on-scroll {
    opacity: 0;
    transform: translateY(20px);
    transition: opacity 0.6s ease-out, transform 0.6s ease-out;
}

/* State ketika elemen terlihat */
.animate-on-scroll.is-visible {
    opacity: 1;
    transform: translateY(0);
}
</style>
