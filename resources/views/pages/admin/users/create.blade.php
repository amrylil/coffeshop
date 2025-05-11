@extends('layouts.dashboard-layout')

@section('content')
    <div class="container mx-auto px-4 py-6 w-full pt-20">
        <div class=" mx-auto">
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="bg-white px-6 py-4 border-b flex justify-between items-center">
                    <h5 class="text-xl font-semibold text-gray-800">Tambah Pengguna Baru</h5>
                    <a href="{{ route('admin.users.index') }}" class="flex items-center text-gray-700 hover:text-gray-900">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
                                clip-rule="evenodd" />
                        </svg>
                        Kembali
                    </a>
                </div>

                <div class="p-6">
                    @if ($errors->any())
                        <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6">
                            <ul class="list-disc ml-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-5">
                            <label for="name_222297" class="block text-gray-700 text-sm font-medium mb-2">
                                Nama Lengkap <span class="text-red-600">*</span>
                            </label>
                            <input type="text"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('name_222297') border-red-500 @enderror"
                                id="name_222297" name="name_222297" value="{{ old('name_222297') }}" required>
                            @error('name_222297')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-5">
                            <label for="email_222297" class="block text-gray-700 text-sm font-medium mb-2">
                                Email <span class="text-red-600">*</span>
                            </label>
                            <input type="email"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('email_222297') border-red-500 @enderror"
                                id="email_222297" name="email_222297" value="{{ old('email_222297') }}" required>
                            @error('email_222297')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-5">
                            <label for="password_222297" class="block text-gray-700 text-sm font-medium mb-2">
                                Password <span class="text-red-600">*</span>
                            </label>
                            <input type="password"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('password_222297') border-red-500 @enderror"
                                id="password_222297" name="password_222297" required>
                            @error('password_222297')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-5">
                            <label class="block text-gray-700 text-sm font-medium mb-2">
                                Jenis Kelamin <span class="text-red-600">*</span>
                            </label>
                            <div class="flex mt-2">
                                <div class="flex items-center mr-6">
                                    <input id="genderL" name="gender_222297" type="radio" value="L"
                                        class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300"
                                        {{ old('gender_222297') == 'L' ? 'checked' : '' }} required>
                                    <label for="genderL" class="ml-2 block text-sm text-gray-700">
                                        Laki-laki
                                    </label>
                                </div>
                                <div class="flex items-center">
                                    <input id="genderP" name="gender_222297" type="radio" value="P"
                                        class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300"
                                        {{ old('gender_222297') == 'P' ? 'checked' : '' }}>
                                    <label for="genderP" class="ml-2 block text-sm text-gray-700">
                                        Perempuan
                                    </label>
                                </div>
                            </div>
                            @error('gender_222297')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-5">
                            <label for="role_222297" class="block text-gray-700 text-sm font-medium mb-2">
                                Role <span class="text-red-600">*</span>
                            </label>
                            <select
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('role_222297') border-red-500 @enderror"
                                id="role_222297" name="role_222297" required>
                                <option value="" selected disabled>Pilih Role</option>
                                <option value="admin" {{ old('role_222297') == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="user" {{ old('role_222297') == 'user' ? 'selected' : '' }}>User</option>
                                <option value="staff" {{ old('role_222297') == 'staff' ? 'selected' : '' }}>Staff</option>
                            </select>
                            @error('role_222297')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-5">
                            <label for="address_222297" class="block text-gray-700 text-sm font-medium mb-2">
                                Alamat
                            </label>
                            <textarea
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('address_222297') border-red-500 @enderror"
                                id="address_222297" name="address_222297" rows="3">{{ old('address_222297') }}</textarea>
                            @error('address_222297')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-5">
                            <label for="phone_222297" class="block text-gray-700 text-sm font-medium mb-2">
                                Nomor Telepon
                            </label>
                            <input type="text"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('phone_222297') border-red-500 @enderror"
                                id="phone_222297" name="phone_222297" value="{{ old('phone_222297') }}">
                            @error('phone_222297')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-5">
                            <label for="birth_date_222297" class="block text-gray-700 text-sm font-medium mb-2">
                                Tanggal Lahir
                            </label>
                            <input type="date"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('birth_date_222297') border-red-500 @enderror"
                                id="birth_date_222297" name="birth_date_222297" value="{{ old('birth_date_222297') }}">
                            @error('birth_date_222297')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-5">
                            <label for="profile_photo_222297" class="block text-gray-700 text-sm font-medium mb-2">
                                Foto Profil
                            </label>
                            <input type="file"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('profile_photo_222297') border-red-500 @enderror"
                                id="profile_photo_222297" name="profile_photo_222297">
                            <p class="text-gray-500 text-xs mt-1">Format: JPG, PNG, GIF. Maksimal 2MB.</p>
                            @error('profile_photo_222297')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mt-8">
                            <button type="submit"
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-md transition duration-200">
                                Simpan Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
