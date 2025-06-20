@extends('layouts.dashboard-layout')

@section('content')
    <div class="bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen py-8 px-4 sm:px-6 lg:px-8 pt-20">
        <div class="max-w-4xl mx-auto">
            <!-- Header Section -->
            <div class="mb-8">
                <div class="flex items-center mb-4">
                    <a href="{{ route('admin.meja.index') }}" class="mr-4 p-2 text-[#6F4E37] hover:bg-[#F5E6DD] rounded-lg">
                        <i class="fas fa-arrow-left text-xl"></i>
                    </a>
                    <div>
                        <h1 class="text-4xl font-bold text-[#6F4E37]">Add New Meja</h1>
                        <p class="mt-2 text-gray-600">Create a new table for your restaurant</p>
                    </div>
                </div>
            </div>

            <!-- Form Section -->
            <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100">
                <div class="bg-gradient-to-r from-[#6F4E37] to-[#8B5A3C] px-6 py-4">
                    <h2 class="text-xl font-semibold text-white flex items-center">
                        <i class="fas fa-plus-circle mr-3"></i>
                        Table Information
                    </h2>
                </div>

                <form action="{{ route('admin.meja.store') }}" method="POST" class="p-8">
                    @csrf

                    @if ($errors->any())
                        <div
                            class="mb-6 p-4 bg-gradient-to-r from-red-100 to-red-50 border border-red-200 text-red-700 rounded-xl">
                            <div class="flex items-center mb-2">
                                <i class="fas fa-exclamation-triangle mr-2 text-red-600"></i>
                                <p class="font-semibold">Please correct the following errors:</p>
                            </div>
                            <ul class="mt-2 list-disc list-inside space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li class="text-sm">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Nomor Meja -->
                        <div class="space-y-2">
                            <label for="nomor_meja_222297"
                                class="block text-sm font-semibold text-[#6F4E37] flex items-center">
                                <i class="fas fa-hashtag mr-2 text-gray-500"></i>
                                Nomor Meja
                            </label>
                            <input type="text" name="nomor_meja_222297" id="nomor_meja_222297"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#6F4E37] focus:border-[#6F4E37] transition duration-200"
                                value="{{ old('nomor_meja_222297') }}" placeholder="e.g., A1, B2, 01">
                            <p class="text-xs text-gray-500 flex items-center">
                                <i class="fas fa-info-circle mr-1"></i>
                                Leave empty to auto-generate
                            </p>
                        </div>

                        <!-- Status -->
                        <div class="space-y-2">
                            <label for="status_222297" class="block text-sm font-semibold text-[#6F4E37] flex items-center">
                                <i class="fas fa-toggle-on mr-2 text-gray-500"></i>
                                Status
                            </label>
                            <select name="status_222297" id="status_222297"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#6F4E37] focus:border-[#6F4E37] transition duration-200"
                                required>
                                <option value="">Pilih Status</option>
                                <option value="kosong" {{ old('status_222297') === 'kosong' ? 'selected' : '' }}>
                                    🟢 Kosong
                                </option>
                                <option value="dipesan" {{ old('status_222297') === 'dipesan' ? 'selected' : '' }}>
                                    🟡 Dipesan
                                </option>
                                <option value="digunakan" {{ old('status_222297') === 'digunakan' ? 'selected' : '' }}>
                                    🔴 Digunakan
                                </option>
                            </select>
                        </div>

                        <!-- Kapasitas -->
                        <div class="space-y-2 lg:col-span-2">
                            <label for="kapasitas_222297"
                                class="block text-sm font-semibold text-[#6F4E37] flex items-center">
                                <i class="fas fa-users mr-2 text-gray-500"></i>
                                Kapasitas
                            </label>
                            <div class="relative">
                                <input type="number" name="kapasitas_222297" id="kapasitas_222297" min="1"
                                    max="20"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#6F4E37] focus:border-[#6F4E37] transition duration-200 pr-16"
                                    value="{{ old('kapasitas_222297') }}" placeholder="Maximum guests" required>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-4">
                                    <span class="text-gray-500 text-sm">orang</span>
                                </div>
                            </div>
                            <p class="text-xs text-gray-500 flex items-center">
                                <i class="fas fa-lightbulb mr-1"></i>
                                Enter the maximum number of people this table can accommodate
                            </p>
                        </div>
                    </div>

                    <!-- Preview Card -->
                    <div class="mt-8 p-6 bg-gradient-to-r from-gray-50 to-gray-100 rounded-xl border border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-eye mr-2 text-[#6F4E37]"></i>
                            Preview
                        </h3>
                        <div class="bg-white rounded-lg p-4 shadow-sm border">
                            <div class="flex justify-between items-center">
                                <div>
                                    <h4 class="font-bold text-[#6F4E37]" id="preview-number">Meja -</h4>
                                    <p class="text-sm text-gray-600">
                                        <i class="fas fa-users mr-1"></i>
                                        <span id="preview-capacity">- orang</span>
                                    </p>
                                </div>
                                <div>
                                    <span id="preview-status"
                                        class="px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                        Status belum dipilih
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit & Cancel Buttons -->
                    <div
                        class="flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-4 mt-8 pt-6 border-t border-gray-200">
                        <a href="{{ route('admin.meja.index') }}"
                            class="px-6 py-3 border border-gray-300 shadow-sm text-sm font-semibold rounded-xl text-gray-700 bg-white hover:bg-gray-50 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition duration-200 text-center">
                            <i class="fas fa-times mr-2"></i>Cancel
                        </a>
                        <button type="submit"
                            class="px-6 py-3 border border-transparent shadow-sm text-sm font-semibold rounded-xl text-slate-950 hover:shadow-lg transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#6F4E37] transition duration-200">
                            <i class="fas fa-save mr-2"></i>Add Meja
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- FontAwesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Live Preview Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const nomorInput = document.getElementById('nomor_meja_222297');
            const kapasitasInput = document.getElementById('kapasitas_222297');
            const statusSelect = document.getElementById('status_222297');

            const previewNumber = document.getElementById('preview-number');
            const previewCapacity = document.getElementById('preview-capacity');
            const previewStatus = document.getElementById('preview-status');

            function updatePreview() {
                // Update number
                const nomor = nomorInput.value || 'Auto-generated';
                previewNumber.textContent = `Meja ${nomor}`;

                // Update capacity
                const kapasitas = kapasitasInput.value || '-';
                previewCapacity.textContent = `${kapasitas} orang`;

                // Update status
                const status = statusSelect.value;
                if (status) {
                    const statusMap = {
                        'kosong': {
                            text: 'Kosong',
                            class: 'bg-green-100 text-green-800'
                        },
                        'dipesan': {
                            text: 'Dipesan',
                            class: 'bg-yellow-100 text-yellow-800'
                        },
                        'digunakan': {
                            text: 'Digunakan',
                            class: 'bg-red-100 text-red-800'
                        }
                    };

                    previewStatus.textContent = statusMap[status].text;
                    previewStatus.className =
                        `px-3 py-1 rounded-full text-sm font-medium ${statusMap[status].class}`;
                } else {
                    previewStatus.textContent = 'Status belum dipilih';
                    previewStatus.className =
                        'px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800';
                }
            }

            // Add event listeners
            nomorInput.addEventListener('input', updatePreview);
            kapasitasInput.addEventListener('input', updatePreview);
            statusSelect.addEventListener('change', updatePreview);

            // Initial preview update
            updatePreview();
        });
    </script>
@endsection
