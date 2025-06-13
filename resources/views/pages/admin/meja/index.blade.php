@extends('layouts.dashboard-layout')

@section('content')
    <div class="bg-white min-h-screen py-8 px-4 sm:px-6 lg:px-8 pt-20">
        <div class="max-w-7xl mx-auto">
            <!-- Header Section -->
            <div class="mb-6 flex justify-between items-center">
                <h1 class="text-3xl font-bold text-[#6F4E37]">Meja Management</h1>
                <a href="{{ route('admin.meja.create') }}"
                    class="px-4 py-2 bg-[#6F4E37] text-white rounded-md hover:bg-[#5D4037] transition">
                    Add New Meja
                </a>
            </div>

            <!-- Flash Messages -->
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded">
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            <!-- Meja Table -->
            <div class="bg-white shadow overflow-hidden rounded-lg">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-[#6F4E37] text-white">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                                    Nomor Meja
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                                    Kapasitas
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                                    Status
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($mejas as $meja)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $meja->nomor_meja_222297 }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $meja->kapasitas_222297 }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $meja->status_222297 }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                                        <div class="flex items-center justify-center space-x-2">
                                            <a href="{{ route('admin.meja.show', $meja->nomor_meja_222297) }}"
                                                class="text-blue-600 hover:text-blue-800">
                                                <span class="px-2 py-1 bg-blue-100 rounded-md">View</span>
                                            </a>
                                            <a href="{{ route('admin.meja.edit', $meja->nomor_meja_222297) }}"
                                                class="text-[#6F4E37] hover:text-[#5D4037]">
                                                <span class="px-2 py-1 bg-[#F5E6DD] rounded-md">Edit</span>
                                            </a>
                                            <form action="{{ route('admin.meja.destroy', $meja->nomor_meja_222297) }}"
                                                method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this meja?');">
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
                                    <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                        No meja found.
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
