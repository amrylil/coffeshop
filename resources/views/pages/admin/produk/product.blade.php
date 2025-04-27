@extends('layouts.dashboard-layout')

@section('content')
    <!-- Coffee Menu Header -->
    <div class="rounded-xl pt-20 w-full  mx-auto font-jost">
        <div
            class="flex justify-between items-center mb-4 p-3 text-amber-900 rounded-t-lg bg-amber-50 border-b-2 border-amber-200">
            <h1 class="text-2xl font-bold">Kelola Menu Kopi</h1>
            <a href="/admin/produk/create">
                <button
                    class="bg-amber-800 text-amber-50 hover:bg-amber-900 font-medium text-sm px-3 py-1.5 rounded-md shadow-sm transition duration-300">
                    <span class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="w-4 h-4 mr-1">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        Tambah Varian
                    </span>
                </button>
            </a>
        </div>
        <div class="bg-white rounded-b-lg shadow-md px-3 py-4">
            <!-- Search Input -->
            <div class="mb-4 flex gap-2">
                <input type="text" id="search" placeholder="Cari kopi..."
                    class="border border-amber-200 p-2 text-sm rounded-md w-full bg-amber-50 focus:border-amber-500 focus:outline-none"
                    onkeyup="searchCoffee()">
                <div class="flex items-center justify-center bg-amber-100 p-2 rounded-md">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        class="h-4 w-4 text-amber-800">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>

            <!-- Coffee Table (Compact) -->
            <div class="overflow-x-auto">
                <table class="table-auto w-full border-collapse rounded-lg overflow-hidden text-sm">
                    <thead class="bg-amber-800 text-amber-50">
                        <tr>
                            <th class="py-2 px-3 text-left">No</th>
                            <th class="py-2 px-3 text-left">Kode Menu</th>
                            <th class="py-2 px-3 text-left">Nama</th>
                            <th class="py-2 px-3 text-left">Deskripsi</th>
                            <th class="py-2 px-3 text-left">Kategori</th>
                            <th class="py-2 px-3 text-left">Harga</th>
                            <th class="py-2 px-3 text-left">Jumlah</th>
                            <th class="py-2 px-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="coffee-table" class="text-amber-900">
                        <tr class="odd:bg-amber-50 even:bg-white hover:bg-amber-100 transition duration-200">
                            <td class="py-2 px-3">1</td>
                            <td class="py-2 px-3">ESP001</td>
                            <td class="py-2 px-3 font-medium">Espresso Single Origin</td>
                            <td class="py-2 px-3 text-xs max-w-xs truncate">Kopi pekat dengan aroma kuat dari biji pilihan
                                Sumatra...</td>
                            <td class="py-2 px-3">Espresso</td>
                            <td class="py-2 px-3">Rp 25.000</td>
                            <td class="py-2 px-3">50</td>
                            <td class="py-2 px-3 text-center">
                                <div class="flex justify-center space-x-1">
                                    <a href="#"
                                        class="bg-amber-500 text-white px-2 py-1 text-xs rounded hover:bg-amber-600 transition">Edit</a>
                                    <button onclick="confirmDelete()"
                                        class="bg-red-500 text-white px-2 py-1 text-xs rounded hover:bg-red-600 transition">Hapus</button>
                                </div>
                            </td>
                        </tr>
                        <tr class="odd:bg-amber-50 even:bg-white hover:bg-amber-100 transition duration-200">
                            <td class="py-2 px-3">2</td>
                            <td class="py-2 px-3">CAP002</td>
                            <td class="py-2 px-3 font-medium">Cappuccino Vanilla</td>
                            <td class="py-2 px-3 text-xs max-w-xs truncate">Perpaduan espresso, susu, dan foam dengan
                                sentuhan vanilla...</td>
                            <td class="py-2 px-3">Cappuccino</td>
                            <td class="py-2 px-3">Rp 35.000</td>
                            <td class="py-2 px-3">35</td>
                            <td class="py-2 px-3 text-center">
                                <div class="flex justify-center space-x-1">
                                    <a href="#"
                                        class="bg-amber-500 text-white px-2 py-1 text-xs rounded hover:bg-amber-600 transition">Edit</a>
                                    <button onclick="confirmDelete()"
                                        class="bg-red-500 text-white px-2 py-1 text-xs rounded hover:bg-red-600 transition">Hapus</button>
                                </div>
                            </td>
                        </tr>
                        <tr class="odd:bg-amber-50 even:bg-white hover:bg-amber-100 transition duration-200">
                            <td class="py-2 px-3">3</td>
                            <td class="py-2 px-3">V60003</td>
                            <td class="py-2 px-3 font-medium">V60 Toraja</td>
                            <td class="py-2 px-3 text-xs max-w-xs truncate">Kopi seduh manual dengan karakter fruity dan
                                nutty khas Toraja...</td>
                            <td class="py-2 px-3">Manual Brew</td>
                            <td class="py-2 px-3">Rp 40.000</td>
                            <td class="py-2 px-3">20</td>
                            <td class="py-2 px-3 text-center">
                                <div class="flex justify-center space-x-1">
                                    <a href="#"
                                        class="bg-amber-500 text-white px-2 py-1 text-xs rounded hover:bg-amber-600 transition">Edit</a>
                                    <button onclick="confirmDelete()"
                                        class="bg-red-500 text-white px-2 py-1 text-xs rounded hover:bg-red-600 transition">Hapus</button>
                                </div>
                            </td>
                        </tr>
                        <tr class="odd:bg-amber-50 even:bg-white hover:bg-amber-100 transition duration-200">
                            <td class="py-2 px-3">4</td>
                            <td class="py-2 px-3">CAR004</td>
                            <td class="py-2 px-3 font-medium">Caramel Macchiato</td>
                            <td class="py-2 px-3 text-xs max-w-xs truncate">Espresso dengan lapisan susu dan caramel yang
                                manis...</td>
                            <td class="py-2 px-3">Latte</td>
                            <td class="py-2 px-3">Rp 38.000</td>
                            <td class="py-2 px-3">30</td>
                            <td class="py-2 px-3 text-center">
                                <div class="flex justify-center space-x-1">
                                    <a href="#"
                                        class="bg-amber-500 text-white px-2 py-1 text-xs rounded hover:bg-amber-600 transition">Edit</a>
                                    <button onclick="confirmDelete()"
                                        class="bg-red-500 text-white px-2 py-1 text-xs rounded hover:bg-red-600 transition">Hapus</button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Coffee Bean Decoration -->
            <div class="flex justify-center items-center mt-4 gap-1 text-amber-800 opacity-70">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    viewBox="0 0 16 16">
                    <path
                        d="M13.354 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6 10.293l6.646-6.647a.5.5 0 0 1 .708 0z" />
                </svg>
                <span class="text-xs">Menampilkan 4 dari 24 kopi</span>
            </div>
        </div>
    </div>

    <!-- Confirmation Dialog for Delete -->
    <script>
        function confirmDelete() {
            return confirm('Apakah Anda yakin ingin menghapus kopi ini dari menu?');
        }

        // Fungsi untuk mencari kopi
        function searchCoffee() {
            const input = document.getElementById('search');
            const filter = input.value.toLowerCase();
            const table = document.getElementById('coffee-table');
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
