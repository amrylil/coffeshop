@extends('layouts.dashboard-layout')

@section('content')
    <div class="bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen py-8 px-4 sm:px-6 lg:px-8 pt-20">
        <div class="max-w-7xl mx-auto">
            <!-- Header Section -->
            <div class="mb-8">
                <div class="flex justify-between items-center mb-4">
                    <div>
                        <h1 class="text-4xl font-bold text-[#6F4E37] mb-2">Meja Management</h1>
                        <p class="text-gray-600">Manage your restaurant tables efficiently</p>
                    </div>
                    <a href="{{ route('admin.meja.create') }}"
                        class="px-6 py-3 bg-gradient-to-r from-[#6F4E37] to-[#8B5A3C] text-slate-950 rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 font-semibold">
                        <i class="fas fa-plus mr-2"></i>Add New Meja
                    </a>
                </div>

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                    <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-blue-500">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-blue-100 mr-4">
                                <i class="fas fa-chair text-blue-600 text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-600">Total Meja</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $mejas->count() }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-green-500">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-green-100 mr-4">
                                <i class="fas fa-check-circle text-green-600 text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-600">Kosong</p>
                                <p class="text-2xl font-bold text-gray-900">
                                    {{ $mejas->where('status', 'kosong')->count() }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-yellow-500">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-yellow-100 mr-4">
                                <i class="fas fa-clock text-yellow-600 text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-600">Dipesan</p>
                                <p class="text-2xl font-bold text-gray-900">
                                    {{ $mejas->where('status', 'dipesan')->count() }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-red-500">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-red-100 mr-4">
                                <i class="fas fa-utensils text-red-600 text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-600">Digunakan</p>
                                <p class="text-2xl font-bold text-gray-900">
                                    {{ $mejas->where('status', 'digunakan')->count() }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Flash Messages -->
            @if (session('success'))
                <div
                    class="mb-6 p-4 bg-gradient-to-r from-green-100 to-green-50 border border-green-200 text-green-700 rounded-xl shadow-sm">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle mr-3 text-green-600"></i>
                        <p class="font-medium">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div
                    class="mb-6 p-4 bg-gradient-to-r from-red-100 to-red-50 border border-red-200 text-red-700 rounded-xl shadow-sm">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle mr-3 text-red-600"></i>
                        <p class="font-medium">{{ session('error') }}</p>
                    </div>
                </div>
            @endif

            <!-- Meja Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($mejas as $meja)
                    <div class="bg-white rounded-xl shadow-lg hover:shadow-xl border border-gray-100 overflow-hidden">
                        <!-- Card Header -->
                        <div class="p-6 bg-gradient-to-r from-[#6F4E37] to-[#8B5A3C] text-white">
                            <div class="flex justify-between items-center">
                                <div>
                                    <h3 class="text-xl font-bold">Meja {{ $meja->nomor_meja }}</h3>
                                    <p class="text-slate-900 text-sm">Table Number</p>
                                </div>
                                <div class="text-right">
                                    <i class="fas fa-chair text-3xl text-slate-900"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Card Body -->
                        <div class="p-6">
                            <div class="space-y-4">
                                <!-- Capacity -->
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <i class="fas fa-users text-gray-600 mr-3"></i>
                                        <span class="text-gray-600">Capacity</span>
                                    </div>
                                    <span class="text-xl font-bold text-gray-900">{{ $meja->kapasitas }}</span>
                                </div>

                                <!-- Status -->
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <i class="fas fa-info-circle text-gray-600 mr-3"></i>
                                        <span class="text-gray-600">Status</span>
                                    </div>
                                    <form action="{{ route('admin.meja.updateStatus', $meja->nomor_meja) }}" method="POST"
                                        class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" onchange="this.form.submit()"
                                            class="px-3 py-1 rounded-full text-sm font-medium border-0 focus:ring-2 focus:ring-[#6F4E37] 
                                                       @if ($meja->status === 'kosong') bg-green-100 text-green-800
                                                       @elseif($meja->status === 'dipesan') bg-yellow-100 text-yellow-800
                                                       @elseif($meja->status === 'digunakan') bg-red-100 text-red-800
                                                       @else bg-gray-100 text-gray-800 @endif">
                                            <option value="kosong" {{ $meja->status === 'kosong' ? 'selected' : '' }}>
                                                Kosong</option>
                                            <option value="dipesan" {{ $meja->status === 'dipesan' ? 'selected' : '' }}>
                                                Dipesan</option>
                                            <option value="digunakan"
                                                {{ $meja->status === 'digunakan' ? 'selected' : '' }}>Digunakan
                                            </option>
                                        </select>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Card Footer -->
                        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                            <div class="flex justify-between items-center">
                                <div class="flex space-x-2">
                                    <a href="{{ route('admin.meja.show', $meja->nomor_meja) }}"
                                        class="px-3 py-2 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 text-sm font-medium">
                                        <i class="fas fa-eye mr-1"></i>View
                                    </a>
                                    <a href="{{ route('admin.meja.edit', $meja->nomor_meja) }}"
                                        class="px-3 py-2 bg-[#F5E6DD] text-[#6F4E37] rounded-lg hover:bg-[#E8D5C6] text-sm font-medium">
                                        <i class="fas fa-edit mr-1"></i>Edit
                                    </a>
                                </div>
                                <form action="{{ route('admin.meja.destroy', $meja->nomor_meja) }}" method="POST"
                                    class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        onclick="return confirm('Are you sure you want to delete this meja?')"
                                        class="px-3 py-2 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 text-sm font-medium">
                                        <i class="fas fa-trash mr-1"></i>Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full">
                        <div class="bg-white rounded-xl shadow-lg p-12 text-center">
                            <div class="mb-4">
                                <i class="fas fa-chair text-6xl text-gray-300"></i>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-2">No Tables Found</h3>
                            <p class="text-gray-600 mb-6">Get started by adding your first table to the system.</p>
                            <a href="{{ route('admin.meja.create') }}"
                                class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-[#6F4E37] to-[#8B5A3C] text-white rounded-xl shadow-lg hover:shadow-xl font-semibold">
                                <i class="fas fa-plus mr-2"></i>Add First Meja
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- FontAwesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endsection
