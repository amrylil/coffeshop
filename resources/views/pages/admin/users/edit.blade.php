@extends('layouts.dashboard-layout')

@section('content')
    <div class="bg-white min-h-screen py-8 px-4 sm:px-6 lg:px-8 pt-20 w-full">
        <div class=" mx-auto">
            <!-- Header Section -->
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-[#6F4E37]">Edit User</h1>
                <p class="mt-2 text-sm text-gray-500">Update information for {{ $user->name }}</p>
            </div>

            <!-- Form Section -->
            <div class="bg-white shadow overflow-hidden rounded-lg">
                <form action="{{ route('admin.users.update', $user->email) }}" method="POST" enctype="multipart/form-data"
                    class="p-6">
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
                        <!-- Name -->
                        <div class="col-span-1">
                            <label for="name" class="block text-sm font-medium text-[#6F4E37]">Name</label>
                            <input type="text" name="name" id="name"
                                class="mt-1  p-2 border focus:ring-[#6F4E37] focus:border-[#6F4E37] block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                value="{{ old('name', $user->name) }}" required>
                        </div>

                        <!-- Email -->
                        <div class="col-span-1">
                            <label for="email" class="block text-sm font-medium text-[#6F4E37]">Email</label>
                            <input type="email" name="email" id="email"
                                class="mt-1  p-2 border focus:ring-[#6F4E37] focus:border-[#6F4E37] block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                value="{{ old('email', $user->email) }}" required>
                        </div>

                        <!-- Password -->
                        <div class="col-span-1">
                            <label for="password" class="block text-sm font-medium text-[#6F4E37]">Password</label>
                            <input type="password" name="password" id="password"
                                class="mt-1  p-2 border focus:ring-[#6F4E37] focus:border-[#6F4E37] block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            <p class="mt-1 text-xs text-gray-500">Leave blank to keep current password</p>
                        </div>

                        <!-- Role -->
                        <div class="col-span-1">
                            <label for="role" class="block text-sm font-medium text-[#6F4E37]">Role</label>
                            <select name="role" id="role"
                                class="mt-1  p-2 border focus:ring-[#6F4E37] focus:border-[#6F4E37] block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                required>
                                <option value="">Select Role</option>
                                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin
                                </option>
                                <option value="customer" {{ old('role', $user->role) == 'customer' ? 'selected' : '' }}>
                                    Customer
                                </option>
                            </select>
                        </div>

                        <!-- Gender -->
                        <div class="col-span-1">
                            <label for="gender" class="block text-sm font-medium text-[#6F4E37]">Gender</label>
                            <select name="gender" id="gender"
                                class="mt-1  p-2 border focus:ring-[#6F4E37] focus:border-[#6F4E37] block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                required>
                                <option value="">Select Gender</option>
                                <option value="male" {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>Male
                                </option>
                                <option value="female" {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>
                                    Female
                                </option>
                            </select>
                        </div>

                        <!-- Phone -->
                        <div class="col-span-1">
                            <label for="phone" class="block text-sm font-medium text-[#6F4E37]">Phone</label>
                            <input type="text" name="phone" id="phone"
                                class="mt-1  p-2 border focus:ring-[#6F4E37] focus:border-[#6F4E37] block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                value="{{ old('phone', $user->phone) }}">
                        </div>

                        <!-- Address -->
                        <div class="col-span-2">
                            <label for="address" class="block text-sm font-medium text-[#6F4E37]">Address</label>
                            <textarea name="address" id="address" rows="3"
                                class="mt-1  p-2 border focus:ring-[#6F4E37] focus:border-[#6F4E37] block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">{{ old('address', $user->address) }}</textarea>
                        </div>

                        <!-- Birth Date -->
                        <div class="col-span-1">
                            <label for="birth_date" class="block text-sm font-medium text-[#6F4E37]">Birth
                                Date</label>
                            <input type="date" name="birth_date" id="birth_date"
                                class="mt-1  p-2 border focus:ring-[#6F4E37] focus:border-[#6F4E37] block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                value="{{ old('birth_date', $user->birth_date) }}">
                        </div>

                        <!-- Profile Photo -->
                        <div class="col-span-1">
                            <label for="profile_photo" class="block text-sm font-medium text-[#6F4E37]">Profile
                                Photo</label>
                            <input type="file" name="profile_photo" id="profile_photo"
                                class="mt-1  p-2 border focus:ring-[#6F4E37] focus:border-[#6F4E37] block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            <p class="mt-1 text-xs text-gray-500">Supported formats: JPEG, PNG, JPG, GIF (max. 2MB)</p>

                            @if ($user->profile_photo)
                                <div class="mt-2">
                                    <p class="text-xs text-gray-500 mb-1">Current image:</p>
                                    <img src="{{ asset('storage/' . $user->profile_photo) }}" alt="{{ $user->name }}"
                                        class="h-24 w-24 object-cover rounded border border-gray-200">
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Submit & Cancel Buttons -->
                    <div class="flex justify-end space-x-3 mt-8">
                        <a href="{{ route('admin.users.index') }}"
                            class="px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#6F4E37]">
                            Cancel
                        </a>
                        <button type="submit"
                            class="px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-black">
                            Update User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
