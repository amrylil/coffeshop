@extends('layouts.dashboard-layout')

@section('content')
    <div class="bg-white min-h-screen py-8 px-4 sm:px-6 lg:px-8 pt-20">
        <div class="max-w-4xl mx-auto">
            <!-- Header Section -->
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-[#6F4E37]">Edit Meja</h1>
                <p class="mt-2 text-sm text-gray-500">Update the details of the meja</p>
            </div>

            <!-- Form Section -->
            <div class="bg-white shadow overflow-hidden rounded-lg">
                <form action="{{ route('admin.meja.update', $meja->nomor_meja_222297) }}" method="POST" class="p-6">
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
                        <!-- Nomor Meja (readonly) -->
                        <div class="col-span-1">
                            <label for="nomor_meja_222297" class="block text-sm font-medium text-[#6F4E37]">Nomor
                                Meja</label>
                            <input type="text" name="nomor_meja_222297" id="nomor_meja_222297" readonly
                                class="mt-1 p-2 bg-gray-100 cursor-not-allowed block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                value="{{ old('nomor_meja_222297', $meja->nomor_meja_222297) }}">
                        </div>

                        <!-- Kapasitas -->
                        <div class="col-span-1">
                            <label for="kapasitas_222297" class="block text-sm font-medium text-[#6F4E37]">Kapasitas</label>
                            <input type="number" name="kapasitas_222297" id="kapasitas_222297" min="1"
                                class="mt-1 p-2 focus:ring-[#6F4E37] focus:border-[#6F4E37] block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                value="{{ old('kapasitas_222297', $meja->kapasitas_222297) }}" required>
                        </div>

                        <!-- Status -->
                        <div class="col-span-1">
                            <label for="status_222297" class="block text-sm font-medium text-[#6F4E37]">Status</label>
                            <input type="text" name="status_222297" id="status_222297"
                                class="mt-1 p-2 focus:ring-[#6F4E37] focus:border-[#6F4E37] block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                value="{{ old('status_222297', $meja->status_222297) }}" required>
                        </div>
                    </div>

                    <!-- Submit & Cancel Buttons -->
                    <div class="flex justify-end space-x-3 mt-8">
                        <a href="{{ route('admin.meja.index') }}"
                            class="px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#6F4E37]">
                            Cancel
                        </a>
                        <button type="submit"
                            class="px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-black">
                            Update Meja
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
