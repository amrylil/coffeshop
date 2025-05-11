@extends('layouts.dashboard-layout')

@section('content')
    <div class="container mx-auto px-4 py-6 pt-20">
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-white px-6 py-4 border-b flex justify-between items-center">
                <h5 class="text-xl font-semibold text-gray-800">Daftar Pengguna</h5>
                <a href="{{ route('admin.users.create') }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-md transition duration-200">
                    Tambah Pengguna
                </a>
            </div>

            <div class="p-6">
                @if (session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded" role="alert">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="w-full border-collapse">
                        <thead>
                            <tr>
                                <th class="px-4 py-3 bg-amber-800 text-white text-left text-sm uppercase font-semibold">
                                    ID
                                </th>
                                <th class="px-4 py-3 bg-amber-800 text-white text-left text-sm uppercase font-semibold">
                                    Nama
                                </th>
                                <th class="px-4 py-3 bg-amber-800 text-white text-left text-sm uppercase font-semibold">
                                    Email
                                </th>
                                <th class="px-4 py-3 bg-amber-800 text-white text-left text-sm uppercase font-semibold">
                                    Gender
                                </th>
                                <th class="px-4 py-3 bg-amber-800 text-white text-left text-sm uppercase font-semibold">
                                    Role
                                </th>
                                <th class="px-4 py-3 bg-amber-800 text-white text-left text-sm uppercase font-semibold">
                                    Telepon
                                </th>
                                <th class="px-4 py-3 bg-amber-800 text-white text-left text-sm uppercase font-semibold">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($users as $user)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 text-sm">{{ $user->user_id_222297 }}</td>
                                    <td class="px-4 py-3 text-sm">{{ $user->name_222297 }}</td>
                                    <td class="px-4 py-3 text-sm">{{ $user->email_222297 }}</td>
                                    <td class="px-4 py-3 text-sm">
                                        {{ $user->gender_222297 == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                                    <td class="px-4 py-3 text-sm">
                                        <span
                                            class="px-2 py-1 text-xs font-semibold rounded-full {{ $user->role_222297 == 'admin' ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                            {{ $user->role_222297 }}
                                        </span>
                                        <button type="button" class="ml-1 text-gray-500 hover:text-gray-700"
                                            onclick="document.getElementById('changeRoleModal{{ $user->user_id_222297 }}').classList.remove('hidden')">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                            </svg>
                                        </button>
                                    </td>
                                    <td class="px-4 py-3 text-sm">{{ $user->phone_222297 }}</td>
                                    <td class="px-4 py-3 text-sm">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('admin.users.show', $user->user_id_222297) }}"
                                                class="bg-blue-100 text-blue-700 hover:bg-blue-200 px-3 py-1 rounded-md text-sm">
                                                Detail
                                            </a>
                                            <a href="{{ route('admin.users.edit', $user->user_id_222297) }}"
                                                class="bg-yellow-100 text-yellow-700 hover:bg-yellow-200 px-3 py-1 rounded-md text-sm">
                                                Edit
                                            </a>
                                            <button type="button"
                                                class="bg-red-100 text-red-700 hover:bg-red-200 px-3 py-1 rounded-md text-sm"
                                                onclick="document.getElementById('deleteModal{{ $user->user_id_222297 }}').classList.remove('hidden')">
                                                Hapus
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Change Role Modal -->
                                <div id="changeRoleModal{{ $user->user_id_222297 }}"
                                    class="fixed inset-0 bg-black bg-opacity-50 z-40 flex items-center justify-center hidden">
                                    <div class="bg-white rounded-lg w-full max-w-md mx-auto overflow-hidden">
                                        <form action="{{ route('admin.users.change-role', $user->user_id_222297) }}"
                                            method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="border-b px-6 py-4">
                                                <div class="flex justify-between items-center">
                                                    <h5 class="text-lg font-medium">Ubah Role: {{ $user->name_222297 }}
                                                    </h5>
                                                    <button type="button" class="text-gray-400 hover:text-gray-600"
                                                        onclick="document.getElementById('changeRoleModal{{ $user->user_id_222297 }}').classList.add('hidden')">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="px-6 py-4">
                                                <div class="mb-4">
                                                    <label for="role_222297"
                                                        class="block text-gray-700 text-sm font-medium mb-2">Role</label>
                                                    <select
                                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                        id="role_222297" name="role_222297" required>
                                                        <option value="admin"
                                                            {{ $user->role_222297 == 'admin' ? 'selected' : '' }}>Admin
                                                        </option>
                                                        <option value="user"
                                                            {{ $user->role_222297 == 'user' ? 'selected' : '' }}>Customer
                                                        </option>
                                                        <option value="staff"
                                                            {{ $user->role_222297 == 'staff' ? 'selected' : '' }}>Staff
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="bg-gray-50 px-6 py-3 flex justify-end">
                                                <button type="button"
                                                    class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md mr-2"
                                                    onclick="document.getElementById('changeRoleModal{{ $user->user_id_222297 }}').classList.add('hidden')">
                                                    Batal
                                                </button>
                                                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md">
                                                    Simpan Perubahan
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <!-- Delete Modal -->
                                <div id="deleteModal{{ $user->user_id_222297 }}"
                                    class="fixed inset-0 bg-black bg-opacity-50 z-40 flex items-center justify-center hidden">
                                    <div class="bg-white rounded-lg w-full max-w-md mx-auto overflow-hidden">
                                        <div class="border-b px-6 py-4">
                                            <div class="flex justify-between items-center">
                                                <h5 class="text-lg font-medium">Konfirmasi Hapus</h5>
                                                <button type="button" class="text-gray-400 hover:text-gray-600"
                                                    onclick="document.getElementById('deleteModal{{ $user->user_id_222297 }}').classList.add('hidden')">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="px-6 py-4">
                                            <p>Apakah Anda yakin ingin menghapus pengguna
                                                <strong>{{ $user->name_222297 }}</strong>?
                                            </p>
                                        </div>
                                        <div class="bg-gray-50 px-6 py-3 flex justify-end">
                                            <button type="button"
                                                class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md mr-2"
                                                onclick="document.getElementById('deleteModal{{ $user->user_id_222297 }}').classList.add('hidden')">
                                                Batal
                                            </button>
                                            <form action="{{ route('admin.users.destroy', $user->user_id_222297) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-md">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-4 py-6 text-center text-gray-500">Tidak ada data pengguna
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
