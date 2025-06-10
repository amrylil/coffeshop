@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-amber-50 to-orange-100">
        <div class="container mx-auto px-4 py-8 pt-20">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold text-amber-900 mb-2">Keranjang Saya</h1>
                <p class="text-amber-700">Nikmati racikan kopi terbaik kami</p>
                <div class="w-24 h-1 bg-amber-600 mx-auto mt-4 rounded-full"></div>
            </div>

            <div class="max-w-6xl mx-auto">
                @if ($items->count() > 0)
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        <!-- Cart Items -->
                        <div class="lg:col-span-2">
                            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                                <div class="bg-[#422424] text-white p-6">
                                    <h2 class="text-2xl font-semibold flex items-center">
                                        <svg class="w-6 h-6 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" />
                                        </svg>
                                        Item Pesanan ({{ $items->count() }})
                                    </h2>
                                </div>

                                <div class="p-6 space-y-4">
                                    @foreach ($items as $item)
                                        <div
                                            class="flex items-center space-x-4 p-4 bg-gradient-to-r from-amber-50 to-orange-50 rounded-xl border border-amber-200 hover:shadow-md transition-all duration-300">
                                            <!-- Coffee Icon -->
                                            <div class="flex-shrink-0">
                                                <div
                                                    class="w-16 h-16 bg-gradient-to-r from-amber-700 to-orange-700 rounded-xl flex items-center justify-center">
                                                    <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                        <path
                                                            d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4zM18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" />
                                                    </svg>
                                                </div>
                                            </div>

                                            <!-- Item Details -->
                                            <div class="flex-1">
                                                <h3 class="font-semibold text-amber-900 text-lg">
                                                    {{ $item->menu->nama_222297 ?? 'Menu Item' }}</h3>
                                                <p class="text-amber-600 text-sm">
                                                    {{ $item->menu->deskripsi_222297 ?? 'Deskripsi menu' }}</p>
                                                <div class="flex items-center mt-2">
                                                    <span class="text-amber-800 font-medium">Rp
                                                        {{ number_format($item->menu->harga_222297, 0, ',', '.') }}</span>
                                                    <span class="text-amber-600 text-sm ml-2">per item</span>
                                                </div>
                                            </div>

                                            <!-- Quantity Controls -->
                                            <div class="flex items-center space-x-3">
                                                <button onclick="decrementQuantity('{{ $item->kode_item_222297 }}')"
                                                    class="w-8 h-8 bg-amber-600 hover:bg-amber-700 text-white rounded-full flex items-center justify-center transition-colors duration-200">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M20 12H4" />
                                                    </svg>
                                                </button>

                                                <span
                                                    class="w-12 text-center font-semibold text-amber-900 bg-white px-3 py-1 rounded-lg border border-amber-200">
                                                    {{ $item->quantity_222297 }}
                                                </span>

                                                <button onclick="incrementQuantity('{{ $item->kode_item_222297 }}')"
                                                    class="w-8 h-8 bg-amber-600 hover:bg-amber-700 text-white rounded-full flex items-center justify-center transition-colors duration-200">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                                    </svg>
                                                </button>
                                            </div>

                                            <!-- Item Total -->
                                            <div class="text-right">
                                                <div class="font-bold text-amber-900 text-lg">
                                                    Rp
                                                    {{ number_format($item->quantity_222297 * $item->menu->harga_222297, 0, ',', '.') }}
                                                </div>
                                                <button onclick="removeItem('{{ $item->kode_item_222297 }}')"
                                                    class="text-red-500 hover:text-red-700 text-sm mt-1 transition-colors duration-200">
                                                    Hapus
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Order Summary -->
                        <div class="lg:col-span-1">
                            <div class="bg-white rounded-2xl shadow-lg overflow-hidden sticky top-8">
                                <div class="bg-[#422424] text-white p-6">
                                    <h2 class="text-xl font-semibold flex items-center">
                                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Ringkasan Pesanan
                                    </h2>
                                </div>

                                <div class="p-6">
                                    <div class="space-y-4">
                                        <div class="flex justify-between items-center py-2 border-b border-amber-100">
                                            <span class="text-amber-700">Subtotal</span>
                                            <span class="font-semibold text-amber-900">Rp
                                                {{ number_format($total, 0, ',', '.') }}</span>
                                        </div>

                                        <div class="flex justify-between items-center py-2 border-b border-amber-100">
                                            <span class="text-amber-700">Pajak (10%)</span>
                                            <span class="font-semibold text-amber-900">Rp
                                                {{ number_format($total * 0.1, 0, ',', '.') }}</span>
                                        </div>

                                        <div class="flex justify-between items-center py-3 border-t-2 border-amber-200">
                                            <span class="text-lg font-bold text-amber-900">Total</span>
                                            <span class="text-xl font-bold text-amber-900">Rp
                                                {{ number_format($total * 1.1, 0, ',', '.') }}</span>
                                        </div>
                                    </div>

                                    <div class="mt-6 space-y-3">
                                        <button onclick="openCheckoutModal()"
                                            class="w-full bg-[#422424] hover:bg-amber-700 text-white font-semibold py-4 px-6 rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg">
                                            Checkout Sekarang
                                        </button>

                                        <button onclick="clearCart()"
                                            class="w-full bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-3 px-6 rounded-xl transition-colors duration-200">
                                            Kosongkan Keranjang
                                        </button>
                                    </div>

                                    <div
                                        class="mt-6 p-4 bg-gradient-to-r from-amber-50 to-orange-50 rounded-xl border border-amber-200">
                                        <div class="flex items-center text-amber-700 text-sm">
                                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            Gratis ongkir untuk pembelian di atas Rp 100.000
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Empty Cart -->
                    <div class="max-w-md mx-auto text-center">
                        <div class="bg-white rounded-2xl shadow-lg p-12">
                            <div class="w-24 h-24 bg-[#422424] rounded-full flex items-center justify-center mx-auto mb-6">
                                <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6.5-5v5a2 2 0 01-2 2H9a2 2 0 01-2-2v-5m6.5-5H15a2 2 0 012 2v3" />
                                </svg>
                            </div>

                            <h2 class="text-2xl font-bold text-amber-900 mb-4">Keranjang Kosong</h2>
                            <p class="text-amber-600 mb-8">Sepertinya Anda belum menambahkan menu kopi apapun ke keranjang
                            </p>

                            <a href="{{ route('menu.index') }}"
                                class="inline-block bg-[#422424] hover:bg-amber-700 text-white font-semibold py-4 px-8 rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg">
                                Jelajahi Menu Kopi
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Checkout Modal -->
    <div id="checkoutModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-4xl w-full max-h-[90vh] overflow-y-auto">
            <!-- Modal Header -->
            <div class="bg-[#422424] text-white p-6 rounded-t-2xl">
                <div class="flex justify-between items-center">
                    <h2 class="text-2xl font-bold flex items-center">
                        <svg class="w-6 h-6 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M4 4a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2H4zm2 6a2 2 0 114 0 2 2 0 01-4 0zm8 0a2 2 0 114 0 2 2 0 01-4 0z" />
                        </svg>
                        Checkout Pesanan
                    </h2>
                    <button onclick="closeCheckoutModal()" class="text-white hover:text-gray-200 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            <form id="checkoutForm" enctype="multipart/form-data">
                @csrf
                <div class="p-6">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Order Summary -->
                        <div>
                            <h3 class="text-xl font-bold text-amber-900 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Detail Pesanan
                            </h3>

                            <div
                                class="bg-gradient-to-r from-amber-50 to-orange-50 rounded-xl border border-amber-200 p-4 mb-6">
                                <div class="space-y-3">
                                    @foreach ($items as $item)
                                        <div
                                            class="flex justify-between items-center py-2 border-b border-amber-100 last:border-0">
                                            <div class="flex-1">
                                                <h4 class="font-medium text-amber-900">{{ $item->menu->nama_222297 }}</h4>
                                                <p class="text-sm text-amber-600">{{ $item->quantity_222297 }} x Rp
                                                    {{ number_format($item->menu->harga_222297, 0, ',', '.') }}</p>
                                            </div>
                                            <div class="font-semibold text-amber-900">
                                                Rp
                                                {{ number_format($item->quantity_222297 * $item->menu->harga_222297, 0, ',', '.') }}
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Total Summary -->
                            <div class="bg-white border border-amber-200 rounded-xl p-4">
                                <div class="space-y-3">
                                    <div class="flex justify-between items-center">
                                        <span class="text-amber-700">Subtotal</span>
                                        <span class="font-medium text-amber-900">Rp
                                            {{ number_format($total, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-amber-700">Pajak (10%)</span>
                                        <span class="font-medium text-amber-900">Rp
                                            {{ number_format($total * 0.1, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="border-t border-amber-200 pt-3">
                                        <div class="flex justify-between items-center">
                                            <span class="text-lg font-bold text-amber-900">Total Pembayaran</span>
                                            <span class="text-xl font-bold text-amber-900">Rp
                                                {{ number_format($total * 1.1, 0, ',', '.') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Method -->
                        <div>
                            <h3 class="text-xl font-bold text-amber-900 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M4 4a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2H4zm2 6a2 2 0 114 0 2 2 0 01-4 0zm8 0a2 2 0 114 0 2 2 0 01-4 0z" />
                                </svg>
                                Metode Pembayaran
                            </h3>

                            <!-- E-Wallet Options -->
                            <div class="space-y-3 mb-6">
                                <label
                                    class="flex items-center p-4 bg-gradient-to-r from-blue-50 to-blue-100 rounded-xl border border-blue-200 cursor-pointer hover:shadow-md transition-all duration-200">
                                    <input type="radio" name="payment_method" value="dana"
                                        class="mr-4 text-blue-600" required>
                                    <div class="flex items-center flex-1">
                                        <div
                                            class="w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center mr-4">
                                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                                <path
                                                    d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <h4 class="font-semibold text-blue-900">DANA</h4>
                                            <p class="text-sm text-blue-600">Pembayaran via DANA e-wallet</p>
                                        </div>
                                    </div>
                                </label>

                                <label
                                    class="flex items-center p-4 bg-gradient-to-r from-orange-50 to-red-100 rounded-xl border border-orange-200 cursor-pointer hover:shadow-md transition-all duration-200">
                                    <input type="radio" name="payment_method" value="shopee_pay"
                                        class="mr-4 text-orange-600" required>
                                    <div class="flex items-center flex-1">
                                        <div
                                            class="w-12 h-12 bg-orange-600 rounded-lg flex items-center justify-center mr-4">
                                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                                <path
                                                    d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <h4 class="font-semibold text-orange-900">ShopeePay</h4>
                                            <p class="text-sm text-orange-600">Pembayaran via ShopeePay e-wallet</p>
                                        </div>
                                    </div>
                                </label>
                            </div>

                            <!-- Upload Bukti Transfer -->
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-amber-900 mb-2">
                                    Upload Bukti Transfer *
                                </label>
                                <div class="relative">
                                    <input type="file" name="bukti_tf_222297" id="bukti_tf"
                                        accept="image/jpeg,image/png,image/jpg"
                                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-3 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100 border border-amber-300 rounded-lg p-3"
                                        required>
                                </div>
                                <p class="text-xs text-amber-600 mt-1">Format: JPG, PNG, JPEG. Maksimal 2MB</p>
                            </div>

                            <!-- Catatan -->
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-amber-900 mb-2">
                                    Catatan Tambahan (Opsional)
                                </label>
                                <textarea name="catatan_222297" rows="3"
                                    class="w-full px-4 py-3 border border-amber-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent resize-none"
                                    placeholder="Tambahkan catatan khusus untuk pesanan Anda..."></textarea>
                            </div>

                            <!-- Payment Instructions -->
                            <div id="paymentInstructions"
                                class="bg-yellow-50 border border-yellow-200 rounded-xl p-4 mb-6" style="display: none;">
                                <h4 class="font-semibold text-yellow-800 mb-2">Instruksi Pembayaran:</h4>
                                <div id="instructionContent" class="text-sm text-yellow-700">
                                    <!-- Dynamic content based on selected payment method -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="bg-gray-50 px-6 py-4 rounded-b-2xl flex justify-between items-center">
                    <button type="button" onclick="closeCheckoutModal()"
                        class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors duration-200">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-8 py-3 bg-[#422424] text-white rounded-lg hover:bg-amber-700 transition-colors duration-200 font-semibold flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Proses Pembayaran
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Get CSRF token function
        function getCSRFToken() {
            const metaTag = document.querySelector('meta[name="csrf-token"]');
            if (metaTag) {
                return metaTag.getAttribute('content');
            }

            const token = document.querySelector('input[name="_token"]');
            if (token) {
                return token.value;
            }

            if (typeof window.Laravel !== 'undefined' && window.Laravel.csrfToken) {
                return window.Laravel.csrfToken;
            }

            console.error('CSRF token not found');
            return null;
        }

        function incrementQuantity(kodeItem) {
            const csrfToken = getCSRFToken();
            if (!csrfToken) {
                alert('CSRF token tidak ditemukan. Silakan refresh halaman.');
                return;
            }

            fetch(`/keranjang/increment/${kodeItem}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert(data.message || 'Terjadi kesalahan saat menambah quantity');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat menambah quantity');
                });
        }

        function decrementQuantity(kodeItem) {
            const csrfToken = getCSRFToken();
            if (!csrfToken) {
                alert('CSRF token tidak ditemukan. Silakan refresh halaman.');
                return;
            }

            fetch(`/keranjang/decrement/${kodeItem}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert(data.message || 'Terjadi kesalahan saat mengurangi quantity');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat mengurangi quantity');
                });
        }

        function removeItem(kodeItem) {
            if (confirm('Apakah Anda yakin ingin menghapus item ini dari keranjang?')) {
                const csrfToken = getCSRFToken();
                if (!csrfToken) {
                    alert('CSRF token tidak ditemukan. Silakan refresh halaman.');
                    return;
                }

                fetch(`/keranjang/remove/${kodeItem}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                        },
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.reload();
                        } else {
                            alert(data.message || 'Terjadi kesalahan saat menghapus item');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan saat menghapus item');
                    });
            }
        }

        function clearCart() {
            if (confirm('Apakah Anda yakin ingin mengosongkan keranjang?')) {
                const csrfToken = getCSRFToken();
                if (!csrfToken) {
                    alert('CSRF token tidak ditemukan. Silakan refresh halaman.');
                    return;
                }

                fetch('/keranjang/clear', {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                        },
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.reload();
                        } else {
                            alert(data.message || 'Terjadi kesalahan saat mengosongkan keranjang');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan saat mengosongkan keranjang');
                    });
            }
        }

        // Modal Functions
        function openCheckoutModal() {
            document.getElementById('checkoutModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeCheckoutModal() {
            document.getElementById('checkoutModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Payment method selection
        document.addEventListener('DOMContentLoaded', function() {
            const paymentRadios = document.querySelectorAll('input[name="payment_method"]');
            const instructionsDiv = document.getElementById('paymentInstructions');
            const instructionContent = document.getElementById('instructionContent');

            paymentRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    instructionsDiv.style.display = 'block';

                    if (this.value === 'dana') {
                        instructionContent.innerHTML = `
                                <ol class="list-decimal list-inside space-y-1">
                                    <li>Buka aplikasi DANA di ponsel Anda</li>
                                    <li>Pilih menu "Transfer" atau "Kirim Uang"</li>
                                    <li>Masukkan nomor DANA: <strong>081234567890</strong></li>
                                    <li>Masukkan nominal: <strong>Rp {{ number_format($total * 1.1, 0, ',', '.') }}</strong></li>
                                    <li>Konfirmasi dan selesaikan pembayaran</li>
                                    <li>Screenshot bukti transfer dan upload di form ini</li>
                                </ol>
                            `;
                    } else if (this.value === 'shopee_pay') {
                        instructionContent.innerHTML = `
                                <ol class="list-decimal list-inside space-y-1">
                                    <li>Buka aplikasi Shopee di ponsel Anda</li>
                                    <li>Pilih menu "ShopeePay" lalu "Kirim"</li>
                                    <li>Masukkan nomor HP: <strong>081234567890</strong></li>
                                    <li>Masukkan nominal: <strong>Rp {{ number_format($total * 1.1, 0, ',', '.') }}</strong></li>
                                    <li>Konfirmasi dan selesaikan pembayaran</li>
                                    <li>Screenshot bukti transfer dan upload di form ini</li>
                                </ol>
                            `;
                    }
                });
            });
        });

        // Form submission
        document.getElementById('checkoutForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const csrfToken = getCSRFToken();

            if (!csrfToken) {
                alert('CSRF token tidak ditemukan. Silakan refresh halaman.');
                return;
            }

            // Validate form
            const paymentMethod = formData.get('payment_method');
            const buktiTf = formData.get('bukti_tf_222297');

            if (!paymentMethod) {
                alert('Silakan pilih metode pembayaran');
                return;
            }

            if (!buktiTf || buktiTf.size === 0) {
                alert('Silakan upload bukti transfer');
                return;
            }

            // Show loading state
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = `
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Memproses...
                `;
            submitBtn.disabled = true;

            // Submit to checkout endpoint
            fetch('{{ route('user.transaksi.store') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(err => Promise.reject(err));
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success || data.message) {
                        alert(data.message || 'Checkout berhasil! Transaksi Anda sedang diproses.');
                        window.location.href = '{{ route('user.transaksi.index') }}';
                    } else {
                        throw new Error('Response tidak valid');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);

                    let errorMessage = 'Terjadi kesalahan saat memproses checkout';

                    if (error.errors) {
                        // Laravel validation errors
                        const errors = Object.values(error.errors).flat();
                        errorMessage = errors.join('\n');
                    } else if (error.message) {
                        errorMessage = error.message;
                    }

                    alert(errorMessage);
                })
                .finally(() => {
                    // Restore button state
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                });
        });

        // Close modal when clicking outside
        document.getElementById('checkoutModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeCheckoutModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeCheckoutModal();
            }
        });
    </script>
