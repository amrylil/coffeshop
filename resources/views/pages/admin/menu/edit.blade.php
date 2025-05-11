@extends('layouts.dashboard-layout')

@section('content')
    <div class="bg-white min-h-screen py-8 px-4 sm:px-6 lg:px-8 pt-20">
        <div class="max-w-4xl mx-auto">
            <!-- Header Section -->
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-[#6F4E37]">Edit Menu Item</h1>
                <p class="mt-2 text-sm text-gray-500">Update information for {{ $menu->nama_222297 }}</p>
            </div>

            <!-- Form Section -->
            <div class="bg-white shadow overflow-hidden rounded-lg">
                <form action="{{ route('admin.menu.update', $menu->kode_menu_222297) }}" method="POST"
                    enctype="multipart/form-data" class="p-6">
                    @csrf
                    @method('PUT')

                    @if ($errors->any())
                        <div class="mb-4 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 rounded">
                            <p class="font-bold">Please correct the following errors:</p>
                            <ul class="mt-2 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Menu Code (readonly) -->
                        <div class="col-span-1">
                            <label for="kode_menu_222297" class="block text-sm font-medium text-[#6F4E37]">Menu Code</label>
                            <input type="text" id="kode_menu_222297"
                                class="mt-1  p-2 border bg-gray-100 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md cursor-not-allowed"
                                value="{{ $menu->kode_menu_222297 }}" readonly disabled>
                        </div>

                        <!-- Menu Name -->
                        <div class="col-span-1">
                            <label for="nama_222297" class="block text-sm font-medium text-[#6F4E37]">Menu Name</label>
                            <input type="text" name="nama_222297" id="nama_222297"
                                class="mt-1  p-2 border focus:ring-[#6F4E37] focus:border-[#6F4E37] block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                value="{{ old('nama_222297', $menu->nama_222297) }}" required>
                        </div>

                        <!-- Category -->
                        <div class="col-span-1">
                            <label for="kode_kategori_222297"
                                class="block text-sm font-medium text-[#6F4E37]">Category</label>
                            <select name="kode_kategori_222297" id="kode_kategori_222297"
                                class="mt-1  p-2 border focus:ring-[#6F4E37] focus:border-[#6F4E37] block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                required>
                                <option value="">Select Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->kode_kategori_222297 }}"
                                        {{ old('kode_kategori_222297', $menu->kode_kategori_222297) == $category->kode_kategori_222297 ? 'selected' : '' }}>
                                        {{ $category->nama_222297 }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Price -->
                        <div class="col-span-1">
                            <label for="harga_222297" class="block text-sm font-medium text-[#6F4E37]">Price (Rp)</label>
                            <input type="number" name="harga_222297" id="harga_222297"
                                class="mt-1  p-2 border focus:ring-[#6F4E37] focus:border-[#6F4E37] block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                value="{{ old('harga_222297', $menu->harga_222297) }}" min="0" step="100"
                                required>
                        </div>

                        <!-- Stock -->
                        <div class="col-span-1">
                            <label for="jumlah_222297" class="block text-sm font-medium text-[#6F4E37]">Stock</label>
                            <input type="number" name="jumlah_222297" id="jumlah_222297"
                                class="mt-1  p-2 border focus:ring-[#6F4E37] focus:border-[#6F4E37] block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                value="{{ old('jumlah_222297', $menu->jumlah_222297) }}" min="0" required>
                        </div>

                        <!-- Image -->
                        <div class="col-span-1">
                            <label for="image" class="block text-sm font-medium text-[#6F4E37]">Menu Image</label>
                            <input type="file" name="image" id="image"
                                class="mt-1  p-2 border focus:ring-[#6F4E37] focus:border-[#6F4E37] block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            <p class="mt-1 text-xs text-gray-500">Supported formats: JPEG, PNG, JPG, GIF (max. 2MB)</p>

                            @if ($menu->path_img_222297)
                                <div class="mt-2">
                                    <p class="text-xs text-gray-500 mb-1">Current image:</p>
                                    <img src="{{ asset('storage/' . $menu->path_img_222297) }}"
                                        alt="{{ $menu->nama_222297 }}"
                                        class="h-24 w-24 object-cover rounded border border-gray-200">
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="mt-6">
                        <label for="deskripsi_222297" class="block text-sm font-medium text-[#6F4E37]">Description</label>
                        <textarea name="deskripsi_222297" id="deskripsi_222297" rows="4"
                            class="mt-1  p-2 border focus:ring-[#6F4E37] focus:border-[#6F4E37] block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                            required>{{ old('deskripsi_222297', $menu->deskripsi_222297) }}</textarea>
                    </div>

                    <!-- Submit & Cancel Buttons -->
                    <div class="flex justify-end space-x-3 mt-8">
                        <a href="{{ route('admin.menu.index') }}"
                            class="px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#6F4E37]">
                            Cancel
                        </a>
                        <button type="submit"
                            class="px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-[#6F4E37] hover:bg-[#5D4037] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#6F4E37]">
                            Update Menu Item
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
