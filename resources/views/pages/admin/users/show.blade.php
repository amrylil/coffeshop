@extends('layouts.dashboard-layout')

@section('content')
    <div class="bg-white min-h-screen py-8 px-4 sm:px-6 lg:px-8 pt-20">
        <div class="max-w-4xl mx-auto">
            <!-- Header Section -->
            <div class="mb-6 flex justify-between items-center">
                <h1 class="text-3xl font-bold text-[#6F4E37]">User Details</h1>
                <div class="flex space-x-3">
                    <a href="{{ route('admin.users.edit', $user->email_222297) }}"
                        class="px-4 py-2 bg-black text-white transition">
                        Edit User
                    </a>
                    <a href="{{ route('admin.users.index') }}"
                        class="px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        Back to List
                    </a>
                </div>
            </div>

            @if (session('success'))
                <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-100" role="alert">
                    <span class="font-medium">Sukses!</span> {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-100" role="alert">
                    <span class="font-medium">Gagal!</span> {{ session('error') }}
                </div>
            @endif

            <!-- User Details -->
            <div class="bg-white shadow overflow-hidden rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- User Image -->
                        <div class="col-span-1 flex flex-col items-center">
                            @if ($user->profile_photo_222297)
                                <div class="w-full h-64 bg-gray-100 rounded-lg overflow-hidden">
                                    <img src="{{ asset('storage/' . $user->profile_photo_222297) }}"
                                        alt="{{ $user->name_222297 }}" class="w-full h-full object-cover">
                                </div>
                            @else
                                <div class="w-full h-64 bg-gray-200 flex items-center justify-center rounded-lg">
                                    <span class="text-gray-400">No Image Available</span>
                                </div>
                            @endif
                        </div>

                        <!-- User Info -->
                        <div class="col-span-2">
                            <div class="grid grid-cols-1 gap-4">
                                <div class="border-b border-gray-200 pb-3">
                                    <h3 class="text-2xl font-semibold text-[#6F4E37]">{{ $user->name_222297 }}</h3>
                                    <div class="flex items-center mt-2">
                                        <span class="px-2 py-1 bg-[#F5E6DD] text-[#6F4E37] text-xs rounded-full">
                                            {{ $user->role_222297 }}
                                        </span>
                                        <span class="ml-2 text-gray-500 text-sm">Email: {{ $user->email_222297 }}</span>
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-4 py-3 border-b border-gray-200">
                                    <div>
                                        <span class="text-sm text-gray-500">Gender</span>
                                        <p class="text-xl font-semibold text-[#6F4E37]">
                                            {{ $user->gender_222297 }}</p>
                                    </div>
                                    <div>
                                        <span class="text-sm text-gray-500">Phone</span>
                                        <p class="text-xl font-semibold text-[#6F4E37]">
                                            {{ $user->phone_222297 }}
                                        </p>
                                    </div>
                                </div>

                                <div class="py-3">
                                    <h4 class="text-sm font-medium text-gray-500 mb-2">Address</h4>
                                    <p class="text-gray-700">{{ $user->address_222297 }}</p>
                                </div>
                                <div class="py-3">
                                    <h4 class="text-sm font-medium text-gray-500 mb-2">Birth Date</h4>
                                    <p class="text-gray-700">{{ $user->birth_date_222297 }}</p>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>

                <!-- Delete Button -->
                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                    <form action="{{ route('admin.users.destroy', $user->email_222297) }}" method="POST" class="inline"
                        onsubmit="return confirm('Are you sure you want to delete this user?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="px-4 py-2 border border-red-300 shadow-sm text-sm font-medium rounded-md text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            Delete User
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
