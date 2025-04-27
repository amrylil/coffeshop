@extends('layouts.dashboard-layout')

@section('content')
    <!-- Dashboard Header -->
    <div class="rounded-xl pt-20 w-full">
        <div class="flex justify-between items-center mb-4 p-3 text-slate-950 rounded-t-xl bg-amber-50">
            <div>
                <h1 class="text-xl font-bold text-amber-900">Kelola Kategori Menu Kopi</h1>
                <p class="text-sm text-amber-700">Atur semua kategori untuk menu kopi Anda</p>
            </div>
            <a href="#">
                <button
                    class="btn bg-amber-800 text-slate-950 hover:bg-amber-900 font-semibold px-3 py-1.5 rounded-lg shadow-md">
                    Tambah Kategori
                </button>
            </a>
        </div>
        <div class="bg-white rounded-b-xl shadow-md p-4">
            <!-- Input Pencarian dan Filter -->
            <div class="mb-4 flex gap-2">
                <input type="text" id="search" placeholder="Cari kategori kopi..."
                    class="border-2 border-amber-200 p-2 rounded-lg w-full focus:border-amber-500 focus:ring-2 focus:ring-amber-200 transition duration-200"
                    onkeyup="searchProducts()">
                <div class="flex items-center justify-center bg-amber-100 p-2 rounded-md">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        class="h-4 w-4 text-amber-800">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="table-auto w-full border-collapse rounded-xl overflow-hidden">
                    <thead class="bg-amber-800 text-white">
                        <tr>
                            <th class="py-2 px-3 text-left text-sm rounded-tl-lg">No</th>
                            <th class="py-2 px-3 text-left text-sm">Kategori</th>
                            <th class="py-2 px-3 text-left text-sm">Deskripsi</th>
                            <th class="py-2 px-3 text-center text-sm">Jumlah</th>
                            <th class="py-2 px-3 text-center text-sm rounded-tr-lg">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="product-table" class="text-gray-700 text-sm">
                        <tr class="border-b border-amber-100 hover:bg-amber-50 transition duration-200">
                            <td class="py-2 px-3">1</td>
                            <td class="py-2 px-3 font-semibold text-amber-900">Espresso Based</td>
                            <td class="py-2 px-3">Minuman kopi berbasis espresso shot, termasuk cappuccino, latte, dan
                                americano</td>
                            <td class="py-2 px-3 text-center">12</td>
                            <td class="py-2 px-3">
                                <div class="flex justify-center space-x-1">
                                    <a href="#"
                                        class="bg-amber-500 hover:bg-amber-600 text-white px-2 py-1 rounded-lg transition duration-200">Edit</a>
                                    <button onclick="confirmDelete()"
                                        class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded-lg transition duration-200">Hapus</button>
                                </div>
                            </td>
                        </tr>
                        <tr class="border-b border-amber-100 hover:bg-amber-50 transition duration-200">
                            <td class="py-2 px-3">2</td>
                            <td class="py-2 px-3 font-semibold text-amber-900">Manual Brew</td>
                            <td class="py-2 px-3">Kopi yang diseduh secara manual seperti V60, Chemex, French Press, dan
                                Aeropress</td>
                            <td class="py-2 px-3 text-center">8</td>
                            <td class="py-2 px-3">
                                <div class="flex justify-center space-x-1">
                                    <a href="#"
                                        class="bg-amber-500 hover:bg-amber-600 text-white px-2 py-1 rounded-lg transition duration-200">Edit</a>
                                    <button onclick="confirmDelete()"
                                        class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded-lg transition duration-200">Hapus</button>
                                </div>
                            </td>
                        </tr>
                        <tr class="border-b border-amber-100 hover:bg-amber-50 transition duration-200">
                            <td class="py-2 px-3">3</td>
                            <td class="py-2 px-3 font-semibold text-amber-900">Coffee Blend</td>
                            <td class="py-2 px-3">Biji kopi campuran dengan komposisi yang berbeda untuk menciptakan profil
                                rasa unik</td>
                            <td class="py-2 px-3 text-center">6</td>
                            <td class="py-2 px-3">
                                <div class="flex justify-center space-x-1">
                                    <a href="#"
                                        class="bg-amber-500 hover:bg-amber-600 text-white px-2 py-1 rounded-lg transition duration-200">Edit</a>
                                    <button onclick="confirmDelete()"
                                        class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded-lg transition duration-200">Hapus</button>
                                </div>
                            </td>
                        </tr>
                        <tr class="border-b border-amber-100 hover:bg-amber-50 transition duration-200">
                            <td class="py-2 px-3">4</td>
                            <td class="py-2 px-3 font-semibold text-amber-900">Non-Coffee</td>
                            <td class="py-2 px-3">Minuman non-kopi seperti teh, coklat, dan minuman berbasis susu</td>
                            <td class="py-2 px-3 text-center">10</td>
                            <td class="py-2 px-3">
                                <div class="flex justify-center space-x-1">
                                    <a href="#"
                                        class="bg-amber-500 hover:bg-amber-600 text-white px-2 py-1 rounded-lg transition duration-200">Edit</a>
                                    <button onclick="confirmDelete()"
                                        class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded-lg transition duration-200">Hapus</button>
                                </div>
                            </td>
                        </tr>
                        <tr class="hover:bg-amber-50 transition duration-200">
                            <td class="py-2 px-3">5</td>
                            <td class="py-2 px-3 font-semibold text-amber-900">Food & Snacks</td>
                            <td class="py-2 px-3">Makanan ringan dan camilan yang cocok untuk menemani kopi</td>
                            <td class="py-2 px-3 text-center">15</td>
                            <td class="py-2 px-3">
                                <div class="flex justify-center space-x-1">
                                    <a href="#"
                                        class="bg-amber-500 hover:bg-amber-600 text-white px-2 py-1 rounded-lg transition duration-200">Edit</a>
                                    <button onclick="confirmDelete()"
                                        class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded-lg transition duration-200">Hapus</button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-4 flex justify-between items-center text-sm">
                <div class="text-gray-600">
                    Showing 5 of 5 entries
                </div>
                <div class="flex space-x-1">
                    <button class="px-2 py-1 bg-amber-100 text-amber-800 rounded-md disabled opacity-50">Previous</button>
                    <button class="px-2 py-1 bg-amber-800 text-white rounded-md">1</button>
                    <button class="px-2 py-1 bg-amber-100 text-amber-800 rounded-md disabled opacity-50">Next</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Confirmation Dialog for Delete -->
    <script>
        function confirmDelete() {
            return confirm('Apakah Anda yakin ingin menghapus kategori ini?');
        }

        // Fungsi untuk mencari produk
        function searchProducts() {
            const input = document.getElementById('search');
            const filter = input.value.toLowerCase();
            const table = document.getElementById('product-table');
            const rows = table.getElementsByTagName('tr');

            for (let i = 0; i < rows.length; i++) {
                const cells = rows[i].getElementsByTagName('td');
                let match = false;

                for (let j = 0; j < cells.length; j++) {
                    if (cells[j]) {
                        const cellValue = cells[j].textContent || cells[j].innerText;
                        if (cellValue.toLowerCase().indexOf(filter) > -1) {
                            match = true;
                            break;
                        }
                    }
                }

                rows[i].style.display = match ? '' : 'none';
            }
        }
    </script>
@endsection
