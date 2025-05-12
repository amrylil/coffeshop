@extends('layouts.app')

@section('title', $menu->nama_222297)

@section('content')
    <section class="min-h-screen py-12">
        <div class="max-w-7xl mx-auto px-4">
            <!-- Navigasi Breadcrumb -->
            <nav class="flex mb-8 text-sm" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="/" class="text-slate-50 hover:text-[#e6dbd1]">
                            Beranda
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-50" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                            <a href="{{ route('menu.index') }}"
                                class="ml-1 text-slate-50 hover:text-[#e6dbd1] md:ml-2">Menu</a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-50" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                            <a href="{{ route('menu.category', $menu->kode_kategori_222297) }}"
                                class="ml-1 text-slate-50 hover:text-[#e6dbd1] md:ml-2">{{ $menu->kategori->nama_222297 }}</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-50" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span class="ml-1 text-[#e6dbd1] font-medium md:ml-2">{{ $menu->nama_222297 }}</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <!-- Bagian Detail Produk -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <div class="flex flex-col lg:flex-row">
                    <!-- Gambar Produk -->
                    <div class="lg:w-1/2 h-96 lg:h-auto">
                        @if ($menu->path_img_222297)
                            <img src="{{ asset($menu->path_img_222297) }}" alt="{{ $menu->nama_222297 }}"
                                class="w-full h-full object-cover">
                        @else
                            <img src="{{ asset('images/coffe.png') }}" alt="{{ $menu->nama_222297 }}"
                                class="w-full h-full object-cover">
                        @endif
                    </div>

                    <!-- Informasi Produk -->
                    <div class="lg:w-1/2 p-8 bg-[#eee3d2] text-[#3e1f1f]">
                        <span class="inline-block bg-[#5e3c3c] text-white px-3 py-1 text-xs rounded mb-4">
                            {{ $menu->kategori->nama_222297 }}
                        </span>

                        <h1 class="text-3xl font-serif font-bold mb-4">{{ $menu->nama_222297 }}</h1>

                        <div class="text-lg font-bold text-[#3e1f1f] mb-4">
                            Rp {{ number_format($menu->harga_222297, 0, ',', '.') }}
                        </div>

                        <div class="prose mb-8 text-gray-700">
                            <p>{{ $menu->deskripsi_222297 ?? 'Minuman lezat yang dibuat dengan penuh keahlian oleh barista kami. Sempurna untuk dinikmati kapan saja, minuman ini menggabungkan bahan-bahan berkualitas untuk pengalaman rasa yang tak terlupakan.' }}
                            </p>
                        </div>

                        <div class="mb-8">
                            <div class="flex items-center mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600 mr-2"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span>Tersedia: {{ $menu->jumlah_222297 }} porsi</span>
                            </div>

                            @if ($menu->jumlah_222297 > 0)
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600 mr-2"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <span>Siap disajikan</span>
                                </div>
                            @else
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600 mr-2"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <span>Saat ini tidak tersedia</span>
                                </div>
                            @endif
                        </div>

                        <div class="flex flex-col gap-4 sm:flex-row">
                            <div class="flex items-center border border-[#3e1f1f] rounded-lg">
                                <button id="decrement" class="px-4 py-2 text-[#3e1f1f] hover:bg-[#d4c7b6] rounded-l-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd" d="M3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                                <input type="number" id="quantity" value="1" min="1"
                                    max="{{ $menu->jumlah_222297 }}"
                                    class="w-12 text-center border-0 focus:ring-0 text-[#3e1f1f] bg-transparent"
                                    {{ $menu->jumlah_222297 <= 0 ? 'disabled' : '' }}>
                                <button id="increment" class="px-4 py-2 text-[#3e1f1f] hover:bg-[#d4c7b6] rounded-r-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>

                            <button id="addToCartBtn"
                                class="flex-1 bg-[#3e1f1f] hover:bg-[#5a2d2d] text-white py-3 px-6 rounded-lg flex items-center justify-center gap-2 transition transform hover:scale-105"
                                {{ $menu->jumlah_222297 <= 0 ? 'disabled' : '' }}
                                data-product-id="{{ $menu->kode_menu_222297 }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                Tambahkan ke Keranjang
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Deskripsi Produk -->
            <div class="mt-12 bg-white rounded-2xl shadow-xl overflow-hidden p-8">
                <div class="prose max-w-none">
                    <h3 class="font-serif text-2xl mb-4 text-[#3e1f1f]">Tentang {{ $menu->nama_222297 }}</h3>
                    <p class="text-gray-700">
                        {{ $menu->deskripsi_222297 ?? 'Biji kopi kami dipilih dengan hati-hati dari daerah penghasil kopi terbaik di seluruh dunia. Setiap biji dipanggang dengan ahli untuk mengeluarkan aroma dan rasa uniknya. Barista terampil kami kemudian menyeduh setiap cangkir dengan presisi dan perhatian, memastikan setiap tegukan memberikan pengalaman yang luar biasa. Baik Anda penikmat kopi atau hanya mencari minuman menyegarkan, hidangan kami menjanjikan kepuasan.' }}
                    </p>

                    <p class="text-gray-700 mt-4">
                        Keseimbangan sempurna antara kekayaan rasa dan tekstur yang halus menjadikan ini favorit di antara
                        pelanggan tetap kami. Nikmati panas atau dingin, dengan susu atau hitam - cukup serbaguna untuk
                        memuaskan preferensi apa pun.
                    </p>
                </div>
            </div>

            <!-- Produk Terkait -->
            @if ($relatedMenus->count() > 0)
                <div class="mt-16">
                    <h2 class="text-3xl font-serif text-center text-[#e6dbd1] mb-8">Anda Mungkin Juga Suka</h2>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        @foreach ($relatedMenus as $relatedMenu)
                            <div
                                class="bg-white rounded-xl shadow-md overflow-hidden transition transform hover:scale-105">
                                <a href="{{ route('menu.show', $relatedMenu->kode_menu_222297) }}">
                                    <div class="h-48 w-full overflow-hidden">
                                        @if ($relatedMenu->path_img_222297)
                                            <img src="{{ asset($relatedMenu->path_img_222297) }}"
                                                alt="{{ $relatedMenu->nama_222297 }}"
                                                class="w-full h-full object-cover transform hover:scale-110 transition duration-500">
                                        @else
                                            <img src="{{ asset('images/coffe.png') }}"
                                                alt="{{ $relatedMenu->nama_222297 }}"
                                                class="w-full h-full object-cover transform hover:scale-110 transition duration-500">
                                        @endif
                                    </div>
                                </a>
                                <div class="p-4">
                                    <h3 class="font-medium text-[#3e1f1f] mb-2">{{ $relatedMenu->nama_222297 }}</h3>
                                    <div class="flex justify-between items-center">
                                        <span class="text-[#3e1f1f] font-bold">
                                            Rp {{ number_format($relatedMenu->harga_222297, 0, ',', '.') }}
                                        </span>
                                        <button
                                            class="bg-[#3e1f1f] hover:bg-[#5a2d2d] text-white text-xs px-3 py-1 rounded transition add-to-cart-btn"
                                            data-product-id="{{ $relatedMenu->kode_menu_222297 }}">
                                            TAMBAH
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Tombol kembali ke atas -->
        <button id="scrollToTopButton"
            class="fixed bottom-6 right-6 bg-[#3e1f1f] text-white p-3 rounded-full shadow-lg opacity-0 transition-all duration-300 hover:bg-[#5a2d2d]">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
            </svg>
        </button>
    </section>
@endsection

@section('scripts')
    <style>
        /* Gaya Dasar */
        body {
            font-family: 'Nunito', sans-serif;
        }

        .font-serif {
            font-family: 'Playfair Display', serif;
        }

        /* Animasi Konten */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Tombol Kembali ke Atas */
        #scrollToTopButton {
            opacity: 0;
            transform: translateY(20px);
            pointer-events: none;
        }

        #scrollToTopButton.visible {
            opacity: 1;
            transform: translateY(0);
            pointer-events: auto;
        }

        /* Gaya Input Jumlah */
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type=number] {
            -moz-appearance: textfield;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Tombol Tambah/Kurang Kuantitas
            const quantityInput = document.getElementById('quantity');
            const incrementBtn = document.getElementById('increment');
            const decrementBtn = document.getElementById('decrement');
            const maxQuantity = {{ $menu->jumlah_222297 }};

            incrementBtn.addEventListener('click', () => {
                let currentValue = parseInt(quantityInput.value);
                if (currentValue < maxQuantity) {
                    quantityInput.value = currentValue + 1;
                }
            });

            decrementBtn.addEventListener('click', () => {
                let currentValue = parseInt(quantityInput.value);
                if (currentValue > 1) {
                    quantityInput.value = currentValue - 1;
                }
            });

            // Mencegah input manual melebihi batas
            quantityInput.addEventListener('change', () => {
                let value = parseInt(quantityInput.value);
                if (isNaN(value) || value < 1) {
                    quantityInput.value = 1;
                } else if (value > maxQuantity) {
                    quantityInput.value = maxQuantity;
                }
            });

            // Tombol Tambah ke Keranjang
            const addToCartBtn = document.getElementById('addToCartBtn');
            if (addToCartBtn) {
                addToCartBtn.addEventListener('click', function() {
                    const isLoggedIn = {{ auth()->check() ? 'true' : 'false' }};

                    if (!isLoggedIn) {
                        window.location.href = "{{ route('login') }}";
                        return;
                    }

                    const productId = this.getAttribute('data-product-id');
                    const quantity = document.getElementById('quantity').value;

                    // Tambahkan efek animasi
                    this.classList.add('scale-95');
                    setTimeout(() => {
                        this.classList.remove('scale-95');
                    }, 150);

                    // Di sini biasanya membuat panggilan AJAX untuk menambahkan ke keranjang
                    console.log(`Menambahkan produk ${productId} ke keranjang dengan jumlah ${quantity}`);

                    // Tampilkan pesan sukses
                    const toast = document.createElement('div');
                    toast.className =
                        'fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg';
                    toast.style.zIndex = '9999';
                    toast.innerHTML = `
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <span>Berhasil ditambahkan ke keranjang!</span>
                        </div>
                    `;
                    document.body.appendChild(toast);

                    // Hapus toast setelah 3 detik
                    setTimeout(() => {
                        toast.style.opacity = '0';
                        toast.style.transition = 'opacity 0.5s ease';
                        setTimeout(() => {
                            document.body.removeChild(toast);
                        }, 500);
                    }, 3000);
                });
            }

            // Tombol Kembali ke Atas
            const scrollToTopButton = document.getElementById('scrollToTopButton');

            window.addEventListener('scroll', () => {
                if (window.scrollY > 300) {
                    scrollToTopButton.classList.add('visible');
                } else {
                    scrollToTopButton.classList.remove('visible');
                }
            });

            scrollToTopButton.addEventListener('click', () => {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });

            // Tambahkan ke keranjang untuk produk terkait
            const addToCartBtns = document.querySelectorAll('.add-to-cart-btn');
            addToCartBtns.forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const isLoggedIn = {{ auth()->check() ? 'true' : 'false' }};

                    if (!isLoggedIn) {
                        window.location.href = "{{ route('login') }}";
                        return;
                    }

                    const productId = this.getAttribute('data-product-id');

                    // Tambahkan efek animasi
                    this.classList.add('scale-95');
                    setTimeout(() => {
                        this.classList.remove('scale-95');
                    }, 150);

                    // Tampilkan pesan sukses
                    const toast = document.createElement('div');
                    toast.className =
                        'fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg';
                    toast.style.zIndex = '9999';
                    toast.innerHTML = `
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <span>Berhasil ditambahkan ke keranjang!</span>
                        </div>
                    `;
                    document.body.appendChild(toast);

                    // Hapus toast setelah 3 detik
                    setTimeout(() => {
                        toast.style.opacity = '0';
                        toast.style.transition = 'opacity 0.5s ease';
                        setTimeout(() => {
                            document.body.removeChild(toast);
                        }, 500);
                    }, 3000);
                });
            });
        });
    </script>
@endsection
