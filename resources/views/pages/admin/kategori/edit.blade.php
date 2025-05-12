@extends('layouts.dashboard-layout')

@section('content')
    <div class="bg-white min-h-screen py-8 px-4 sm:px-6 lg:px-8 pt-20 w-full">
        <div class=" mx-auto">
            <!-- Header Section -->
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-[#6F4E37]">Edit Category</h1>
                <p class="mt-2 text-gray-600">Update category details for: {{ $category->nama_222297 }}</p>
            </div>

            <!-- Form Container -->
            <div class="bg-white shadow overflow-hidden rounded-lg">
                <form action="{{ route('admin.kategori.update', $category->kode_kategori_222297) }}" method="POST"
                    enctype="multipart/form-data" class="p-6">
                    @csrf
                    @method('PUT')

                    <!-- Error Messages -->
                    @if ($errors->any())
                        <div class="mb-4 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 rounded">
                            <ul class="list-disc pl-4">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Category Code (Read Only) -->
                    <div class="mb-4">
                        <label for="kode" class="block text-sm font-medium text-gray-700 mb-1">Category Code</label>
                        <input type="text" value="{{ $category->kode_kategori_222297 }}"
                            class="form-input p-2 w-full rounded-md border-gray-300 bg-gray-100 text-gray-700" readonly>
                    </div>

                    <!-- Category Name -->
                    <div class="mb-4">
                        <label for="nama_222297" class="block text-sm font-medium text-gray-700 mb-1">Category Name</label>
                        <input type="text" name="nama_222297" id="nama_222297"
                            value="{{ old('nama_222297', $category->nama_222297) }}"
                            class="form-input p-2 w-full rounded-md border-gray-300 shadow-sm focus:border-[#6F4E37] focus:ring focus:ring-[#F5E6DD]"
                            required>
                    </div>

                    <!-- Category Description -->
                    <div class="mb-4">
                        <label for="deskripsi_222297"
                            class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                        <textarea name="deskripsi_222297" id="deskripsi_222297" rows="4"
                            class="form-textarea p-2 w-full rounded-md border-gray-300 shadow-sm focus:border-[#6F4E37] focus:ring focus:ring-[#F5E6DD]">{{ old('deskripsi_222297', $category->deskripsi_222297) }}</textarea>
                    </div>

                    <!-- Category Image -->
                    <div class="mb-6">
                        <label for="path_img_222297" class="block text-sm font-medium text-gray-700 mb-1">Category
                            Image</label>
                        <div class="mt-1 flex items-center">
                            <div
                                class="preview-container h-32 w-32 bg-gray-100 rounded flex items-center justify-center mb-2">
                                @if ($category->path_img_222297)
                                    <img id="image-preview" src="{{ asset('storage/' . $category->path_img_222297) }}"
                                        alt="{{ $category->nama_222297 }}" class="h-full w-full object-cover rounded">
                                @else
                                    <img id="image-preview" src="#" alt="Preview"
                                        class="h-full w-full object-cover rounded hidden">
                                    <span id="no-image" class="text-gray-400 text-sm">No image uploaded</span>
                                @endif
                            </div>
                        </div>
                        <input type="file" name="path_img_222297" id="path_img_222297" accept="image/*"
                            class="form-input w-full mt-1 p-1 border border-gray-300 rounded-md text-sm"
                            onchange="previewImage(this)">
                        <p class="mt-1 text-sm text-gray-500">
                            Leave empty to keep the current image. Recommended size: 300x300 pixels. Max size: 2MB.
                        </p>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-200">
                        <a href="{{ route('admin.kategori.index') }}"
                            class="px-4 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 transition">
                            Cancel
                        </a>
                        <button type="submit" class="px-4 py-2 bg-black text-white transition">
                            Update Category
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function previewImage(input) {
            const preview = document.getElementById('image-preview');
            const noImage = document.getElementById('no-image');

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    if (noImage) noImage.classList.add('hidden');
                }

                reader.readAsDataURL(input.files[0]);
            } else {
                if ('{{ $category->path_img_222297 }}') {
                    preview.src = '{{ asset('storage/' . $category->path_img_222297) }}';
                } else {
                    preview.src = '#';
                    preview.classList.add('hidden');
                    if (noImage) noImage.classList.remove('hidden');
                }
            }
        }
    </script>
@endsection
