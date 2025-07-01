@extends('layouts.dashboard-layout')

@section('content')
    <div class="bg-gray-50 min-h-screen py-8 px-4 sm:px-6 lg:px-8 pt-20">
        <div class="max-w-7xl mx-auto">
            <!-- Header Section -->
            <div class="mb-8">
                <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-[#6F4E37]">
                    <div class="flex justify-between items-center">
                        <div>
                            <h1 class="text-3xl font-bold text-[#6F4E37] mb-2">Transaction Management</h1>
                            <p class="text-gray-600">Kelola semua transaksi pelanggan dengan mudah</p>
                        </div>
                        <div class="flex items-center space-x-4">
                            <div class="text-right">
                                <p class="text-sm text-gray-500">Total Transaksi</p>
                                <p class="text-2xl font-bold text-[#6F4E37]">{{ $transaksi->total() }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Flash Messages -->
            @if (session('success'))
                <div
                    class="mb-6 p-4 bg-gradient-to-r from-green-50 to-green-100 border border-green-200 rounded-lg shadow-sm">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 p-4 bg-gradient-to-r from-red-50 to-red-100 border border-red-200 rounded-lg shadow-sm">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-red-800">Terjadi kesalahan:</p>
                            <ul class="mt-1 text-sm text-red-700 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Status Filter -->
            <div class="mb-6">
                <div class="bg-white rounded-lg shadow-sm p-4">
                    <div class="flex flex-wrap gap-2">
                        <span class="text-sm font-medium text-gray-700 mr-4">Filter Status:</span>
                        <a href="{{ route('admin.transaksi.index') }}"
                            class="px-3 py-1 text-xs font-medium rounded-full {{ !request('status') ? 'bg-[#6F4E37] text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                            Semua
                        </a>
                        <a href="{{ route('admin.transaksi.index', ['status' => 'pending']) }}"
                            class="px-3 py-1 text-xs font-medium rounded-full {{ request('status') == 'pending' ? 'bg-yellow-500 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                            Pending
                        </a>
                        <a href="{{ route('admin.transaksi.index', ['status' => 'dikonfirmasi']) }}"
                            class="px-3 py-1 text-xs font-medium rounded-full {{ request('status') == 'dikonfirmasi' ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                            Dikonfirmasi
                        </a>
                        <a href="{{ route('admin.transaksi.index', ['status' => 'selesai']) }}"
                            class="px-3 py-1 text-xs font-medium rounded-full {{ request('status') == 'selesai' ? 'bg-green-500 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                            Selesai
                        </a>
                        <a href="{{ route('admin.transaksi.index', ['status' => 'ditolak']) }}"
                            class="px-3 py-1 text-xs font-medium rounded-full {{ request('status') == 'ditolak' ? 'bg-red-500 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                            Ditolak
                        </a>
                    </div>
                </div>
            </div>

            <div class="mb-6">
                <div class="bg-white rounded-lg shadow-sm p-4">
                    <div class="flex flex-wrap gap-2">
                        <span class="text-sm font-medium text-gray-700 mr-4">Filter Jenis Pesanan:</span>
                        <a href="{{ route('admin.transaksi.index', array_merge(request()->query(), ['jenis_pesanan' => ''])) }}"
                            class="px-3 py-1 text-xs font-medium rounded-full {{ !request('jenis_pesanan') ? 'bg-[#6F4E37] text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                            Semua
                        </a>
                        <a href="{{ route('admin.transaksi.index', array_merge(request()->query(), ['jenis_pesanan' => 'delivery'])) }}"
                            class="px-3 py-1 text-xs font-medium rounded-full {{ request('jenis_pesanan') == 'delivery' ? 'bg-green-500 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                            Delivery
                        </a>
                        <a href="{{ route('admin.transaksi.index', array_merge(request()->query(), ['jenis_pesanan' => 'di_lokasi'])) }}"
                            class="px-3 py-1 text-xs font-medium rounded-full {{ request('jenis_pesanan') == 'dilokasi' ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                            Di Lokasi
                        </a>
                    </div>
                </div>
            </div>

            <!-- Transaction Table -->
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gradient-to-r from-[#6F4E37] to-[#8B5A42]">
                            <tr>

                                <th scope="col"
                                    class="px-6 py-4 text-left text-xs font-bold textsl95 uppercase tracking-wider">

                                    Menu
                                </th>
                                <th scope="col"
                                    class="px-6 py-4 text-left text-xs font-bold textsl95 uppercase tracking-wider">

                                    Jumlah
                                </th>
                                <th scope="col"
                                    class="px-6 py-4 text-left text-xs font-bold textsl95 uppercase tracking-wider">

                                    Harga Total
                                </th>
                                <th scope="col"
                                    class="px-6 py-4 text-left text-xs font-bold textsl95 uppercase tracking-wider">

                                    Status
                                </th>
                                <th scope="col"
                                    class="px-6 py-4 text-left text-xs font-bold textsl95 uppercase tracking-wider">
                                    Jenis Pesanan
                                </th>
                                <th scope="col"
                                    class="px-6 py-4 text-left text-xs font-bold textsl95 uppercase tracking-wider">

                                    Tanggal Transaksi
                                </th>
                                <th scope="col"
                                    class="px-6 py-4 text-center text-xs font-bold textsl95 uppercase tracking-wider">

                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($transaksi as $trans)
                                <tr class="hover:bg-gray-50 transition-colors duration-200">

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900 font-medium">
                                            {{ $trans->menu->nama ?? 'N/A' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                {{ $trans->jumlah }} pcs
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-bold text-green-600">
                                            Rp {{ number_format($trans->harga_total, 0, ',', '.') }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $statusColors = [
                                                'pending' =>
                                                    'bg-yellow-100 text-yellow-800 border-yellow-200 hover:bg-yellow-200',
                                                'dikonfirmasi' =>
                                                    'bg-blue-100 text-blue-800 border-blue-200 hover:bg-blue-200',
                                                'dikirim' =>
                                                    'bg-purple-100 text-purple-800 border-purple-200 hover:bg-purple-200',
                                                'selesai' =>
                                                    'bg-green-100 text-green-800 border-green-200 hover:bg-green-200',
                                                'ditolak' => 'bg-red-100 text-red-800 border-red-200 hover:bg-red-200',
                                            ];
                                            $statusClass =
                                                $statusColors[$trans->status] ??
                                                'bg-gray-100 text-gray-800 border-gray-200 hover:bg-gray-200';
                                        @endphp
                                        <button
                                            onclick="openStatusModal('{{ $trans->kode_transaksi }}', '{{ $trans->status }}')"
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $statusClass }} cursor-pointer transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                </path>
                                            </svg>
                                            {{ ucfirst($trans->status) }}
                                        </button>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $jenisColors = [
                                                'delivery' => 'bg-green-100 text-green-800',
                                                'dilokasi' => 'bg-blue-100 text-blue-800',
                                            ];
                                            $jenisClass =
                                                $jenisColors[$trans->jenis_pesanan] ?? 'bg-gray-100 text-gray-800';
                                        @endphp
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $jenisClass }}">
                                            @if ($trans->jenis_pesanan == 'delivery')
                                                🚚 Delivery
                                            @else
                                                🏪 Di Lokasi
                                            @endif
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ \Carbon\Carbon::parse($trans->tanggal_transaksi)->format('d M Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <div class="flex items-center justify-center space-x-2">
                                            <!-- View Button -->
                                            <a href="{{ route('admin.transaksi.show', $trans->kode_transaksi) }}"
                                                class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                    </path>
                                                </svg>
                                                View
                                            </a>

                                            <!-- Edit Button -->
                                            <a href="{{ route('admin.transaksi.edit', $trans->kode_transaksi) }}"
                                                class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition-colors duration-200">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                    </path>
                                                </svg>
                                                Edit
                                            </a>


                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center">
                                            <svg class="w-12 h-12 text-gray-400 mb-4" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                </path>
                                            </svg>
                                            <p class="text-lg font-medium text-gray-900 mb-1">Tidak ada transaksi</p>
                                            <p class="text-sm text-gray-500">Belum ada transaksi yang tersedia untuk
                                                ditampilkan.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if ($transaksi->hasPages())
                    <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
                        <div class="flex-1 flex justify-between sm:hidden">
                            @if ($transaksi->onFirstPage())
                                <span
                                    class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-500 bg-white cursor-default">
                                    Previous
                                </span>
                            @else
                                <a href="{{ $transaksi->previousPageUrl() }}"
                                    class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                    Previous
                                </a>
                            @endif

                            @if ($transaksi->hasMorePages())
                                <a href="{{ $transaksi->nextPageUrl() }}"
                                    class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                    Next
                                </a>
                            @else
                                <span
                                    class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-500 bg-white cursor-default">
                                    Next
                                </span>
                            @endif
                        </div>
                        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                            <div>
                                <p class="text-sm text-gray-700">
                                    Showing
                                    <span class="font-medium">{{ $transaksi->firstItem() }}</span>
                                    to
                                    <span class="font-medium">{{ $transaksi->lastItem() }}</span>
                                    of
                                    <span class="font-medium">{{ $transaksi->total() }}</span>
                                    results
                                </p>
                            </div>
                            <div>
                                {{ $transaksi->links() }}
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Status Update Modal -->
    <div id="statusModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-blue-100">
                    <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-lg leading-6 font-medium text-gray-900 mt-2">Update Status Transaksi</h3>
                <div class="mt-4 px-7 py-3">
                    <form id="statusForm" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="mb-4">
                            <label for="status" class="block text-sm font-medium text-gray-700 text-left">Status
                                Baru</label>
                            <select id="status" name="status" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                <option value="">Pilih Status</option>
                                <option value="pending" class="text-yellow-600">🟡 Pending</option>
                                <option value="dikonfirmasi" class="text-blue-600">🔵 Dikonfirmasi</option>
                                <option value="dikirim" class="text-purple-600">🟣 Dikirim</option>
                                <option value="selesai" class="text-green-600">🟢 Selesai</option>
                                <option value="ditolak" class="text-red-600">🔴 Ditolak</option>
                            </select>
                        </div>

                        <!-- Rejection Reason Field (hidden by default) -->
                        <div id="rejectionReasonField" class="mb-4 hidden">
                            <label for="alasan_penolakan" class="block text-sm font-medium text-gray-700 text-left">Alasan
                                Penolakan</label>
                            <textarea id="alasan_penolakan" name="alasan_penolakan" rows="3"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 sm:text-sm"
                                placeholder="Masukkan alasan penolakan..."></textarea>
                        </div>

                        <!-- Status Information -->
                        <div class="mb-4 p-3 bg-gray-50 rounded-md">
                            <p class="text-xs text-gray-600 text-left">
                                <strong>Status Saat Ini:</strong> <span id="currentStatus" class="font-medium"></span>
                            </p>
                            <p class="text-xs text-gray-500 text-left mt-1">
                                Pilih status baru untuk mengupdate transaksi ini.
                            </p>
                        </div>

                        <div class="flex items-center justify-between">
                            <button type="button" onclick="closeStatusModal()"
                                class="px-4 py-2 bg-gray-300 text-gray-700 text-base font-medium rounded-md shadow-sm hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-300">
                                Batal
                            </button>
                            <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white text-base font-medium rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                Update Status
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Reject Modal (Keep existing for specific reject action) -->
    <div id="rejectModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                    <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z">
                        </path>
                    </svg>
                </div>
                <h3 class="text-lg leading-6 font-medium text-gray-900 mt-2">Tolak Transaksi</h3>
                <div class="mt-4 px-7 py-3">
                    <form id="rejectForm" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="mb-4">
                            <label for="alasan_penolakan" class="block text-sm font-medium text-gray-700 text-left">Alasan
                                Penolakan</label>
                            <textarea id="alasan_penolakan" name="alasan_penolakan" rows="3" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 sm:text-sm"
                                placeholder="Masukkan alasan penolakan..."></textarea>
                        </div>
                        <div class="flex items-center justify-between">
                            <button type="button" onclick="closeRejectModal()"
                                class="px-4 py-2 bg-gray-300 text-gray-700 text-base font-medium rounded-md shadow-sm hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-300">
                                Batal
                            </button>
                            <button type="submit"
                                class="px-4 py-2 bg-red-600 text-white text-base font-medium rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                                Tolak Transaksi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Status Modal Functions
        function openStatusModal(transactionId, currentStatus) {
            document.getElementById('statusModal').classList.remove('hidden');
            document.getElementById('statusForm').action = `/admin/transaksi/${transactionId}/update-status`;
            document.getElementById('currentStatus').textContent = currentStatus.charAt(0).toUpperCase() + currentStatus
                .slice(1);

            // Set current status as selected
            const statusSelect = document.getElementById('status');
            statusSelect.value = currentStatus;

            // Handle rejection reason field visibility
            toggleRejectionReason(currentStatus);
        }

        function closeStatusModal() {
            document.getElementById('statusModal').classList.add('hidden');
            document.getElementById('status').value = '';
            document.getElementById('alasan_penolakan').value = '';
            document.getElementById('rejectionReasonField').classList.add('hidden');
        }

        function toggleRejectionReason(status) {
            const rejectionField = document.getElementById('rejectionReasonField');
            const rejectionTextarea = document.getElementById('alasan_penolakan');

            if (status === 'ditolak') {
                rejectionField.classList.remove('hidden');
                rejectionTextarea.setAttribute('required', 'required');
            } else {
                rejectionField.classList.add('hidden');
                rejectionTextarea.removeAttribute('required');
                rejectionTextarea.value = '';
            }
        }

        // Event listener for status change
        document.getElementById('status').addEventListener('change', function() {
            toggleRejectionReason(this.value);
        });

        // Reject Modal Functions (keep existing)
        function openRejectModal(transactionId) {
            document.getElementById('rejectModal').classList.remove('hidden');
            document.getElementById('rejectForm').action = `/admin/transaksi/${transactionId}/reject`;
        }

        function closeRejectModal() {
            document.getElementById('rejectModal').classList.add('hidden');
            document.getElementById('alasan_penolakan').value = '';
        }

        // Close modals when clicking outside
        document.getElementById('statusModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeStatusModal();
            }
        });

        document.getElementById('rejectModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeRejectModal();
            }
        });

        // Close modals with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeStatusModal();
                closeRejectModal();
            }
        });
    </script>
@endsection
