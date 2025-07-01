@extends('layouts.dashboard-layout')

@section('content')
    <div class="bg-white min-h-screen py-8 px-4 sm:px-6 lg:px-8 pt-20">
        <div class="max-w-7xl mx-auto">
            <!-- Header Section -->
            <div class="mb-6 flex justify-between items-center">
                <h1 class="text-3xl font-bold text-[#6F4E37]">Category Management</h1>
                <a href="{{ route('admin.kategori.create') }}"
                    class="px-4 py-2 bg-[#6F4E37] text-white rounded-md hover:bg-[#5D4037] transition">
                    Add New Category
                </a>
            </div>

            <!-- Flash Messages -->
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded">
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 rounded">
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            <!-- Categories Table -->
            <div class="bg-white shadow overflow-hidden rounded-lg">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-[#6F4E37] text-white">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                                    Image
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                                    Code
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                                    Name
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                                    Description
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                                    Menu Count
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($categories as $category)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($category->path_img)
                                            <img src="{{ asset('storage/' . $category->path_img) }}"
                                                alt="{{ $category->nama }}" class="h-16 w-16 object-cover rounded">
                                        @else
                                            <div class="h-16 w-16 bg-gray-200 flex items-center justify-center rounded">
                                                <span class="text-gray-400">No Image</span>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $category->kode_kategori }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-[#6F4E37]">
                                        {{ $category->nama }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500 max-w-xs truncate">
                                        {{ $category->deskripsi ?? 'No description' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $category->menu->count() }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                                        <div class="flex items-center justify-center space-x-2">
                                            <a href="{{ route('admin.kategori.show', $category->kode_kategori) }}"
                                                class="text-blue-600 hover:text-blue-800">
                                                <span class="px-2 py-1 bg-blue-100 rounded-md">View</span>
                                            </a>
                                            <a href="{{ route('admin.kategori.edit', $category->kode_kategori) }}"
                                                class="text-[#6F4E37] hover:text-[#5D4037]">
                                                <span class="px-2 py-1 bg-[#F5E6DD] rounded-md">Edit</span>
                                            </a>
                                            <form action="{{ route('admin.kategori.destroy', $category->kode_kategori) }}"
                                                method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this category?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-800">
                                                    <span class="px-2 py-1 bg-red-100 rounded-md">Delete</span>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                        No categories found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
