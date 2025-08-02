@extends('layouts.app')

@section('title', $menu->nama)

@section('content')
    <section class="min-h-screen py-8">
        <div class="max-w-7xl mx-auto px-4">
            <!-- Breadcrumb -->
            <nav class="mb-8" aria-label="Breadcrumb">
                <div class="flex items-center space-x-2 text-sm text-slate-50/80">
                    <a href="/" class="hover:text-[#e6dbd1]">Beranda</a>
                    <span>/</span>
                    <a href="{{ route('menu.index') }}" class="hover:text-[#e6dbd1]">Menu</a>
                    <span>/</span>
                    <a href="{{ route('menu.category', $menu->kode_kategori) }}"
                        class="hover:text-[#e6dbd1]">{{ $menu->kategori->nama }}</a>
                    <span>/</span>
                    <span class="text-[#e6dbd1] font-medium">{{ $menu->nama }}</span>
                </div>
            </nav>

            <!-- Product Detail Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12  items-stretch mb-16 ">
                <!-- Product Image -->
                <div class="space-y-4 p-5 bg-slate-50 rounded-2xl shadow-lg overflow-hidden">
                    <div class="relative rounded-2xl  bg-white shadow-lg overflow-hidden">
                        @if ($menu->path_img)
                            <img src="{{ asset('images/' . $menu->path_img) }}" alt="{{ $menu->nama }}"
                                class="w-full h-[450px] object-cover">
                        @else
                            <img src="{{ asset('images/coffe.png') }}" alt="{{ $menu->nama }}"
                                class="w-full h-80 object-cover">
                        @endif
                        <div class="absolute top-4 left-4">
                            <span class="bg-[#3e1f1f] text-white px-3 py-1 rounded-full text-sm font-medium">
                                {{ $menu->kategori->nama }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Product Info -->
                <div class="bg-white rounded-2xl p-8 shadow-lg  h-full">
                    <div class="space-y-6">
                        <!-- Title & Price -->
                        <div>
                            <h1 class="text-3xl font-serif font-bold text-[#3e1f1f] mb-3">{{ $menu->nama }}</h1>
                            <div class="text-2xl font-bold text-[#3e1f1f]">
                                Rp {{ number_format($menu->harga, 0, ',', '.') }}
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="text-gray-600 leading-relaxed">
                            {{ $menu->deskripsi ?? 'Minuman lezat yang dibuat dengan penuh keahlian oleh barista kami. Sempurna untuk dinikmati kapan saja, minuman ini menggabungkan bahan-bahan berkualitas untuk pengalaman rasa yang tak terlupakan.' }}
                        </div>

                        <!-- Availability -->
                        <div class="border-t border-gray-100 pt-6">
                            <div class="space-y-2">
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-700">Ketersediaan:</span>
                                    <span class="font-medium text-[#3e1f1f]">{{ $menu->jumlah }} porsi</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-700">Status:</span>
                                    @if ($menu->jumlah > 0)
                                        <span class="text-green-600 font-medium">✓ Tersedia</span>
                                    @else
                                        <span class="text-red-600 font-medium">✗ Habis</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Purchase Section -->
                        @if ($menu->jumlah > 0)
                            <div class="space-y-4 border-t border-gray-100 pt-6">
                                <!-- Quantity -->
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-700 font-medium">Jumlah:</span>
                                    <div class="flex items-center border border-gray-300 rounded-lg">
                                        <button id="decrement" class="px-3 py-2 text-gray-600 hover:bg-gray-50">−</button>
                                        <input type="number" id="quantity" value="1" min="1"
                                            max="{{ $menu->jumlah }}"
                                            class="w-12 text-center border-0 focus:ring-0 text-[#3e1f1f] font-medium">
                                        <button id="increment" class="px-3 py-2 text-gray-600 hover:bg-gray-50">+</button>
                                    </div>
                                </div>

                                <!-- Add to Cart Button -->
                                <button id="addToCartBtn"
                                    class="w-full bg-[#3e1f1f] hover:bg-[#5a2d2d] text-white py-3 px-6 rounded-lg font-medium"
                                    data-product-id="{{ $menu->kode_menu }}">
                                    <span class="btn-text">Tambahkan ke Keranjang</span>
                                </button>
                            </div>
                        @else
                            <div class="border-t border-gray-100 pt-6">
                                <button disabled
                                    class="w-full bg-gray-300 text-gray-500 py-3 px-6 rounded-lg font-medium cursor-not-allowed">
                                    Saat Ini Tidak Tersedia
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Description Section -->
            <div class="bg-white rounded-2xl p-8 shadow-lg mb-16">
                <h2 class="text-2xl font-serif font-bold text-[#3e1f1f] mb-6">Tentang {{ $menu->nama }}</h2>
                <div class="text-gray-600 leading-relaxed space-y-4">
                    <p>
                        {{ $menu->deskripsi ?? 'Biji kopi kami dipilih dengan hati-hati dari daerah penghasil kopi terbaik di seluruh dunia. Setiap biji dipanggang dengan ahli untuk mengeluarkan aroma dan rasa uniknya. Barista terampil kami kemudian menyeduh setiap cangkir dengan presisi dan perhatian, memastikan setiap tegukan memberikan pengalaman yang luar biasa.' }}
                    </p>
                    <p>
                        Keseimbangan sempurna antara kekayaan rasa dan tekstur yang halus menjadikan ini favorit di antara
                        pelanggan tetap kami. Nikmati panas atau dingin, dengan susu atau hitam - cukup serbaguna untuk
                        memuaskan preferensi apa pun.
                    </p>
                </div>
            </div>

            <!-- Related Products -->
            @if ($relatedMenus->count() > 0)
                <div class="space-y-8">
                    <div class="text-center">
                        <h2 class="text-3xl font-serif font-bold text-[#e6dbd1] mb-2">Menu Lainnya</h2>
                        <p class="text-slate-50/70">Produk yang mungkin Anda sukai</p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        @foreach ($relatedMenus as $relatedMenu)
                            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg">
                                <a href="{{ route('menu.show', $relatedMenu->kode_menu) }}">
                                    <img src="{{ asset('images/' . $relatedMenu->path_img) }}"
                                        alt="{{ $relatedMenu->nama }}" class="w-full h-48 object-cover">
                                </a>
                                <div class="p-4">
                                    <h3 class="font-medium text-[#3e1f1f] mb-2 text-sm">{{ $relatedMenu->nama }}</h3>
                                    <div class="flex justify-between items-center">
                                        <span class="text-[#3e1f1f] font-bold text-sm">
                                            Rp {{ number_format($relatedMenu->harga, 0, ',', '.') }}
                                        </span>
                                        <button
                                            class="bg-[#3e1f1f] hover:bg-[#5a2d2d] text-white text-xs px-3 py-1.5 rounded disabled:opacity-50 disabled:cursor-not-allowed add-to-cart-btn"
                                            data-product-id="{{ $relatedMenu->kode_menu }}"
                                            {{ $relatedMenu->jumlah <= 0 ? 'disabled' : '' }}>
                                            Tambah
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Loading Overlay -->
        <div id="loadingOverlay" class="fixed inset-0 bg-black/60 flex items-center justify-center z-50 hidden">
            <div class="bg-white rounded-xl p-6 flex items-center space-x-3 shadow-xl">
                <div class="w-5 h-5 border-2 border-[#3e1f1f] border-t-transparent rounded-full animate-spin"></div>
                <span class="text-[#3e1f1f]">Menambahkan ke keranjang...</span>
            </div>
        </div>

        <!-- Scroll to Top -->
        <button id="scrollToTopButton"
            class="fixed bottom-6 right-6 bg-[#3e1f1f] hover:bg-[#5a2d2d] text-white p-3 rounded-full shadow-lg opacity-0 pointer-events-none">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
            </svg>
        </button>
    </section>
@endsection

@section('scripts')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        body {
            font-family: 'Inter', system-ui, sans-serif;
        }

        .font-serif {
            font-family: 'Playfair Display', serif;
        }

        #scrollToTopButton.visible {
            opacity: 1;
            pointer-events: auto;
        }

        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type=number] {
            -moz-appearance: textfield;
        }

        .hover\:shadow-lg:hover {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        * {
            transition: all 0.2s ease;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            const quantityInput = document.getElementById('quantity');
            const incrementBtn = document.getElementById('increment');
            const decrementBtn = document.getElementById('decrement');
            const maxQuantity = {{ $menu->jumlah }};

            // Quantity controls
            incrementBtn?.addEventListener('click', () => {
                let currentValue = parseInt(quantityInput.value);
                if (currentValue < maxQuantity) {
                    quantityInput.value = currentValue + 1;
                }
            });

            decrementBtn?.addEventListener('click', () => {
                let currentValue = parseInt(quantityInput.value);
                if (currentValue > 1) {
                    quantityInput.value = currentValue - 1;
                }
            });

            quantityInput?.addEventListener('change', () => {
                let value = parseInt(quantityInput.value);
                if (isNaN(value) || value < 1) {
                    quantityInput.value = 1;
                } else if (value > maxQuantity) {
                    quantityInput.value = maxQuantity;
                }
            });

            // Loading functions
            function showLoading() {
                document.getElementById('loadingOverlay').classList.remove('hidden');
            }

            function hideLoading() {
                document.getElementById('loadingOverlay').classList.add('hidden');
            }

            // Toast notification
            function showToast(message, type = 'success') {
                const toast = document.createElement('div');
                const bgColor = type === 'success' ? 'bg-green-500' : 'bg-red-500';

                toast.className =
                    `fixed top-4 right-4 ${bgColor} text-white px-4 py-2 rounded-lg shadow-lg z-50 transform translate-x-full`;
                toast.textContent = message;
                document.body.appendChild(toast);

                setTimeout(() => toast.classList.remove('translate-x-full'), 100);
                setTimeout(() => {
                    toast.classList.add('translate-x-full');
                    setTimeout(() => document.body.removeChild(toast), 300);
                }, 3000);
            }

            // Add to cart function
            async function addToCart(productId, quantity = 1) {
                try {
                    showLoading();
                    const response = await fetch('{{ route('keranjang.add') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            kode_menu: productId,
                            quantity: quantity
                        })
                    });

                    const data = await response.json();
                    if (data.success) {
                        showToast(data.message || 'Item berhasil ditambahkan ke keranjang!');
                    } else {
                        showToast(data.message || 'Gagal menambahkan item ke keranjang', 'error');
                    }
                } catch (error) {
                    showToast('Terjadi kesalahan saat menambahkan item ke keranjang', 'error');
                } finally {
                    hideLoading();
                }
            }

            // Main add to cart button
            const addToCartBtn = document.getElementById('addToCartBtn');
            addToCartBtn?.addEventListener('click', async function() {
                const isLoggedIn = {{ auth()->check() ? 'true' : 'false' }};
                if (!isLoggedIn) {
                    window.location.href = "{{ route('login') }}";
                    return;
                }

                const productId = this.getAttribute('data-product-id');
                const quantity = parseInt(quantityInput?.value || 1);

                this.disabled = true;
                const originalText = this.querySelector('.btn-text').textContent;
                this.querySelector('.btn-text').textContent = 'Menambahkan...';

                await addToCart(productId, quantity);

                this.disabled = false;
                this.querySelector('.btn-text').textContent = originalText;
            });

            // Related products add to cart
            document.querySelectorAll('.add-to-cart-btn').forEach(btn => {
                btn.addEventListener('click', async function(e) {
                    e.preventDefault();
                    const isLoggedIn = {{ auth()->check() ? 'true' : 'false' }};
                    if (!isLoggedIn) {
                        window.location.href = "{{ route('login') }}";
                        return;
                    }

                    const productId = this.getAttribute('data-product-id');
                    this.disabled = true;
                    const originalText = this.textContent;
                    this.textContent = 'Menambah...';

                    await addToCart(productId, 1);

                    this.disabled = false;
                    this.textContent = originalText;
                });
            });

            // Scroll to top
            const scrollBtn = document.getElementById('scrollToTopButton');
            window.addEventListener('scroll', () => {
                if (window.scrollY > 300) {
                    scrollBtn.classList.add('visible');
                } else {
                    scrollBtn.classList.remove('visible');
                }
            });

            scrollBtn?.addEventListener('click', () => {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });
        });
    </script>
@endsection
