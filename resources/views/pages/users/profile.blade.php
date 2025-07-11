@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 py-8">
        <div class="max-w-2xl mx-auto px-4">

            @if (session('success'))
                <div class="mb-6 p-4 text-green-700 bg-green-50 border-l-4 border-green-400 rounded-r-lg">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <!-- Header -->
                <div class="bg-gradient-to-r from-amber-900 to-yellow-900 px-6 py-8 text-center">
                    <img id="profileImage"
                        class="w-32 h-32 rounded-full mx-auto border-4 border-white shadow-lg object-cover mb-4"
                        src="{{ $user->profile_photo ? asset('storage/' . $user->profile_photo) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&color=ffffff&background=92400e' }}"
                        alt="{{ $user->name }}">
                    <h1 class="text-2xl font-bold text-white">{{ $user->name }}</h1>
                    <p class="text-amber-100">{{ $user->email }}</p>
                </div>

                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="p-6">
                    @csrf
                    @method('PATCH')

                    @if ($errors->any())
                        <div class="mb-4 p-4 bg-red-100 text-red-700 border-l-4 border-red-500 rounded-r-lg">
                            <strong>Whoops! Ada yang salah.</strong>
                            <ul class="mt-2 list-disc list-inside text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <!-- Profile Photo Upload -->
                    <div class="mb-6 text-center">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Change Photo</label>
                        <input type="file" name="profile_photo" id="profilePhotoInput" accept="image/*"
                            class="block mx-auto text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:bg-amber-50 file:text-amber-800 hover:file:bg-amber-100">
                        @error('profile_photo')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Form Fields -->
                    <div class="space-y-4">
                        <!-- Name -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Name</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                class="w-full p-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent @error('name') border-red-400 @enderror">
                            @error('name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email (readonly) -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
                            <input type="email" value="{{ $user->email }}" readonly
                                class="w-full p-3 bg-gray-50 border border-gray-200 rounded-lg cursor-not-allowed">
                            <p class="text-xs text-gray-500 mt-1">Email cannot be changed</p>
                        </div>

                        <!-- Gender & Phone -->
                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Gender</label>
                                <select name="gender"
                                    class="w-full p-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-amber-500 @error('gender') border-red-400 @enderror">
                                    <option value="">Select Gender</option>
                                    <option value="male" @selected(old('gender', $user->gender) == 'male')>Male</option>
                                    <option value="female" @selected(old('gender', $user->gender) == 'female')>Female</option>
                                </select>
                                @error('gender')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Phone</label>
                                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                                    class="w-full p-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-amber-500 @error('phone') border-red-400 @enderror">
                                @error('phone')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Birth Date -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Birth Date</label>
                            <input type="date" name="birth_date"
                                value="{{ old('birth_date', $user->birth_date?->format('Y-m-d')) }}"
                                class="w-full p-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-amber-500 @error('birth_date') border-red-400 @enderror">
                            @error('birth_date')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Address -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Address</label>
                            <textarea name="address" rows="3"
                                class="w-full p-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-amber-500 @error('address') border-red-400 @enderror">{{ old('address', $user->address) }}</textarea>
                            @error('address')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password Section -->
                        <div class="border-t pt-6 mt-6">
                            <h3 class="text-lg font-bold text-gray-800 mb-4">Change Password</h3>
                            <div class="grid md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">New Password</label>
                                    <input type="password" name="password"
                                        class="w-full p-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-amber-500 @error('password') border-red-400 @enderror">
                                    @error('password')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Confirm Password</label>
                                    <input type="password" name="password_confirmation"
                                        class="w-full p-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-amber-500">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="mt-8 pt-6 border-t">
                        <button type="submit"
                            class="w-full bg-gradient-to-r from-amber-900 to-yellow-900 text-white font-semibold py-3 px-6 rounded-lg hover:from-amber-800 hover:to-yellow-800 focus:ring-4 focus:ring-amber-300">
                            Update Profile
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('profilePhotoInput').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('profileImage').src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
@endsection
