@extends('layouts.dashboard-layout')

@section('content')
    <div class="bg-white min-h-screen py-8 px-4 sm:px-6 lg:px-8 pt-20">
        <div class="max-w-3xl mx-auto">
            <h1 class="text-3xl font-bold text-[#6F4E37] mb-6">Tambah Transaksi Baru</h1>

            <form action="{{ route('admin.transaksi.store') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email User</label>
                    <select name="email" id="email"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#6F4E37] focus:ring focus:ring-[#6F4E37] focus:ring-opacity-50"
                        required>
                        <option value="">Pilih User</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->email }}" {{ old('email') == $user->email ? 'selected' : '' }}>
                                {{ $user->name }} ({{ $user->email }})
                            </option>
                        @endforeach
                    </select>
                    @error('email')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="kode_menu" class="block text-sm font-medium text-gray-700">Menu</label>
                    <select name="kode_menu" id="kode_menu"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#6F4E37] focus:ring focus:ring-[#6F4E37] focus:ring-opacity-50"
                        required>
                        <option value="">Pilih Menu</option>
                        @foreach ($menus as $menu)
                            <option value="{{ $menu->kode_menu }}"
                                {{ old('kode_menu') == $menu->kode_menu ? 'selected' : '' }}>
                                {{ $menu->nama_menu }} - Rp {{ number_format($menu->harga, 0, ',', '.') }}
                            </option>
                        @endforeach
                    </select>
                    @error('kode_menu')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="jumlah" class="block text-sm font-medium text-gray-700">Jumlah</label>
                    <input type="number" name="jumlah" id="jumlah" min="1" value="{{ old('jumlah', 1) }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#6F4E37] focus:ring focus:ring-[#6F4E37] focus:ring-opacity-50"
                        required>
                    @error('jumlah')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="status" id="status"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#6F4E37] focus:ring focus:ring-[#6F4E37] focus:ring-opacity-50"
                        required>
                        <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="dikonfirmasi" {{ old('status') == 'dikonfirmasi' ? 'selected' : '' }}>
                            Dikonfirmasi</option>
                        <option value="ditolak" {{ old('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                        <option value="selesai" {{ old('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>
                    @error('status')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="tanggal_transaksi" class="block text-sm font-medium text-gray-700">Tanggal
                        Transaksi</label>
                    <input type="date" name="tanggal_transaksi" id="tanggal_transaksi"
                        value="{{ old('tanggal_transaksi', date('Y-m-d')) }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#6F4E37] focus:ring focus:ring-[#6F4E37] focus:ring-opacity-50"
                        required>
                    @error('tanggal_transaksi')
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
