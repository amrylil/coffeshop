@extends('layouts.dashboard-layout')

@section('content')
    <div class="bg-white min-h-screen py-8 px-4 sm:px-6 lg:px-8 pt-20">
        <div class="max-w-3xl mx-auto">
            <h1 class="text-3xl font-bold text-[#6F4E37] mb-6">Tambah Transaksi Baru</h1>

            <form action="{{ route('admin.transaksi.store') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label for="email_222297" class="block text-sm font-medium text-gray-700">Email User</label>
                    <select name="email_222297" id="email_222297"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#6F4E37] focus:ring focus:ring-[#6F4E37] focus:ring-opacity-50"
                        required>
                        <option value="">Pilih User</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->email_222297 }}"
                                {{ old('email_222297') == $user->email_222297 ? 'selected' : '' }}>
                                {{ $user->name }} ({{ $user->email_222297 }})
                            </option>
                        @endforeach
                    </select>
                    @error('email_222297')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="kode_menu_222297" class="block text-sm font-medium text-gray-700">Menu</label>
                    <select name="kode_menu_222297" id="kode_menu_222297"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#6F4E37] focus:ring focus:ring-[#6F4E37] focus:ring-opacity-50"
                        required>
                        <option value="">Pilih Menu</option>
                        @foreach ($menus as $menu)
                            <option value="{{ $menu->kode_menu_222297 }}"
                                {{ old('kode_menu_222297') == $menu->kode_menu_222297 ? 'selected' : '' }}>
                                {{ $menu->nama_menu_222297 }} - Rp {{ number_format($menu->harga_222297, 0, ',', '.') }}
                            </option>
                        @endforeach
                    </select>
                    @error('kode_menu_222297')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="jumlah_222297" class="block text-sm font-medium text-gray-700">Jumlah</label>
                    <input type="number" name="jumlah_222297" id="jumlah_222297" min="1"
                        value="{{ old('jumlah_222297', 1) }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#6F4E37] focus:ring focus:ring-[#6F4E37] focus:ring-opacity-50"
                        required>
                    @error('jumlah_222297')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="status_222297" class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="status_222297" id="status_222297"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#6F4E37] focus:ring focus:ring-[#6F4E37] focus:ring-opacity-50"
                        required>
                        <option value="pending" {{ old('status_222297') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="dikonfirmasi" {{ old('status_222297') == 'dikonfirmasi' ? 'selected' : '' }}>
                            Dikonfirmasi</option>
                        <option value="ditolak" {{ old('status_222297') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                        <option value="selesai" {{ old('status_222297') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>
                    @error('status_222297')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="tanggal_transaksi_222297" class="block text-sm font-medium text-gray-700">Tanggal
                        Transaksi</label>
                    <input type="date" name="tanggal_transaksi_222297" id="tanggal_transaksi_222297"
                        value="{{ old('tanggal_transaksi_222297', date('Y-m-d')) }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#6F4E37] focus:ring focus:ring-[#6F4E37] focus:ring-opacity-50"
                        required>
                    @error('tanggal_transaksi_222297')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end space-x-4">
                    <a href="{{ route('admin.transaksi.index') }}"
                        class="px-4 py-2 rounded-md bg-gray-300 hover:bg-gray-400 text-gray-700">Batal</a>
                    <button type="submit"
                        class="px-4 py-2 rounded-md bg-[#6F4E37] hover:bg-[#5a3e2e] text-white">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
