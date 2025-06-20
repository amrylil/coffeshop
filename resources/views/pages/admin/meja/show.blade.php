@extends('layouts.dashboard-layout')

@section('content')
    <div class="bg-white min-h-screen py-8 px-4 sm:px-6 lg:px-8 pt-20">
        <div class="max-w-4xl mx-auto">
            <!-- Header Section -->
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-[#6F4E37]">Meja Details</h1>
                <p class="mt-2 text-sm text-gray-500">Detailed information about the meja</p>
            </div>

            <!-- Details Section -->
            <div class="bg-white shadow overflow-hidden rounded-lg p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Nomor Meja</h3>
                        <p class="mt-1 text-lg font-semibold text-[#6F4E37]">{{ $meja->nomor_meja_222297 }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Kapasitas</h3>
                        <p class="mt-1 text-lg font-semibold text-[#6F4E37]">{{ $meja->kapasitas_222297 }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Status</h3>
                        <p class="mt-1 text-lg font-semibold text-[#6F4E37]">{{ $meja->status_222297 }}</p>
                    </div>
                </div>

                <!-- Back Button -->
                <div class="mt-8">
                    <a href="{{ route('admin.meja.index') }}"
                        class="px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#6F4E37]">
                        Back to Meja List
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
