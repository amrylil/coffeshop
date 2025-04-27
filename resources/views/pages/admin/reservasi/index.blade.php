@extends('layouts.dashboard-layout')

@section('content')
    <!-- Dashboard Header -->
    <div class="rounded-xl pt-20 w-full">
        <div class="flex justify-between items-center mb-4 p-3 text-slate-950 rounded-t-xl bg-amber-50">
            <div>
                <h1 class="text-xl font-bold text-amber-900">Kelola Meja Reservasi</h1>
                <p class="text-sm text-amber-700">Atur dan kelola semua meja di kafe Anda</p>
            </div>
            <a href="#">
                <button
                    class="btn bg-amber-800 text-slate-950 hover:bg-amber-900 font-semibold px-3 py-1.5 rounded-lg shadow-md">
                    Tambah Meja Baru
                </button>
            </a>
        </div>
        <div class="bg-white rounded-b-xl shadow-md p-4">
            <!-- Input Pencarian dan Filter -->
            <div class="mb-4 flex gap-2">
                <input type="text" id="search" placeholder="Cari meja..."
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
                            <th class="py-2 px-3 text-left text-sm">Nomor Meja</th>
                            <th class="py-2 px-3 text-left text-sm">Kapasitas</th>
                            <th class="py-2 px-3 text-left text-sm">Lokasi</th>
                            <th class="py-2 px-3 text-center text-sm">Status</th>
                            <th class="py-2 px-3 text-center text-sm rounded-tr-lg">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="table-list" class="text-gray-700 text-sm">
                        <tr class="border-b border-amber-100 hover:bg-amber-50 transition duration-200">
                            <td class="py-2 px-3">1</td>
                            <td class="py-2 px-3 font-semibold text-amber-900">Meja 01</td>
                            <td class="py-2 px-3">2 orang</td>
                            <td class="py-2 px-3">Indoor - Window</td>
                            <td class="py-2 px-3 text-center">
                                <span
                                    class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs font-medium">Tersedia</span>
                            </td>
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
                            <td class="py-2 px-3 font-semibold text-amber-900">Meja 02</td>
                            <td class="py-2 px-3">4 orang</td>
                            <td class="py-2 px-3">Indoor - Center</td>
                            <td class="py-2 px-3 text-center">
                                <span
                                    class="bg-red-100 text-red-800 px-2 py-1 rounded-full text-xs font-medium">Terisi</span>
                            </td>
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
                            <td class="py-2 px-3 font-semibold text-amber-900">Meja 03</td>
                            <td class="py-2 px-3">6 orang</td>
                            <td class="py-2 px-3">Indoor - Corner</td>
                            <td class="py-2 px-3 text-center">
                                <span
                                    class="bg-orange-100 text-orange-800 px-2 py-1 rounded-full text-xs font-medium">Reserved</span>
                            </td>
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
                            <td class="py-2 px-3 font-semibold text-amber-900">Meja 04</td>
                            <td class="py-2 px-3">2 orang</td>
                            <td class="py-2 px-3">Outdoor - Garden</td>
                            <td class="py-2 px-3 text-center">
                                <span
                                    class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs font-medium">Tersedia</span>
                            </td>
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
                            <td class="py-2 px-3">5</td>
                            <td class="py-2 px-3 font-semibold text-amber-900">Meja 05</td>
                            <td class="py-2 px-3">8 orang</td>
                            <td class="py-2 px-3">Indoor - Private Room</td>
                            <td class="py-2 px-3 text-center">
                                <span
                                    class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs font-medium">Maintenance</span>
                            </td>
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
                    Showing 5 of 8 entries
                </div>
                <div class="flex space-x-1">
                    <button class="px-2 py-1 bg-amber-100 text-amber-800 rounded-md disabled opacity-50">Previous</button>
                    <button class="px-2 py-1 bg-amber-800 text-white rounded-md">1</button>
                    <button
                        class="px-2 py-1 bg-amber-100 text-amber-800 rounded-md hover:bg-amber-200 transition-colors">2</button>
                    <button
                        class="px-2 py-1 bg-amber-100 text-amber-800 rounded-md hover:bg-amber-200 transition-colors">Next</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Form for Add/Edit Table -->
    <div id="tableModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-amber-900" id="modalTitle">Tambah Meja Baru</h3>
                <button onclick="closeModal()" class="text-gray-500 hover:text-gray-700">
                    <span class="text-2xl">&times;</span>
                </button>
            </div>
            <form id="tableForm">
                <div class="mb-4">
                    <label for="tableNumber" class="block text-sm font-medium text-gray-700 mb-1">Nomor Meja</label>
                    <input type="text" id="tableNumber" name="tableNumber"
                        class="border-2 border-amber-200 p-2 rounded-lg w-full focus:border-amber-500 focus:ring-2 focus:ring-amber-200">
                </div>
                <div class="mb-4">
                    <label for="capacity" class="block text-sm font-medium text-gray-700 mb-1">Kapasitas</label>
                    <select id="capacity" name="capacity"
                        class="border-2 border-amber-200 p-2 rounded-lg w-full focus:border-amber-500 focus:ring-2 focus:ring-amber-200">
                        <option value="2">2 orang</option>
                        <option value="4">4 orang</option>
                        <option value="6">6 orang</option>
                        <option value="8">8 orang</option>
                        <option value="10">10 orang</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="location" class="block text-sm font-medium text-gray-700 mb-1">Lokasi</label>
                    <select id="location" name="location"
                        class="border-2 border-amber-200 p-2 rounded-lg w-full focus:border-amber-500 focus:ring-2 focus:ring-amber-200">
                        <option value="Indoor - Window">Indoor - Window</option>
                        <option value="Indoor - Center">Indoor - Center</option>
                        <option value="Indoor - Corner">Indoor - Corner</option>
                        <option value="Indoor - Private Room">Indoor - Private Room</option>
                        <option value="Outdoor - Garden">Outdoor - Garden</option>
                        <option value="Outdoor - Street View">Outdoor - Street View</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select id="status" name="status"
                        class="border-2 border-amber-200 p-2 rounded-lg w-full focus:border-amber-500 focus:ring-2 focus:ring-amber-200">
                        <option value="available">Tersedia</option>
                        <option value="occupied">Terisi</option>
                        <option value="reserved">Reserved</option>
                        <option value="maintenance">Maintenance</option>
                    </select>
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="closeModal()"
                        class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-lg transition duration-200">Batal</button>
                    <button type="submit"
                        class="bg-amber-800 hover:bg-amber-900 text-white px-4 py-2 rounded-lg transition duration-200">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Confirmation Dialog for Delete -->
    <script>
        function confirmDelete() {
            return confirm('Apakah Anda yakin ingin menghapus meja ini?');
        }

        // Fungsi untuk mencari meja
        function searchTables() {
            const input = document.getElementById('search');
            const filter = input.value.toLowerCase();
            const table = document.getElementById('table-list');
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

        // Modal functions
        function openModal(isEdit = false) {
            const modal = document.getElementById('tableModal');
            const modalTitle = document.getElementById('modalTitle');
            modal.classList.remove('hidden');
            modalTitle.textContent = isEdit ? 'Edit Meja' : 'Tambah Meja Baru';
        }

        function closeModal() {
            const modal = document.getElementById('tableModal');
            modal.classList.add('hidden');
        }

        // Add event listener for form submission
        document.getElementById('tableForm').addEventListener('submit', function(e) {
            e.preventDefault();
            // Handle form submission here
            closeModal();
        });
    </script>
@endsection
