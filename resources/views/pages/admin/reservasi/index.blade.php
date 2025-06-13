@extends('layouts.dashboard-layout')

@section('content')
    <div class="bg-white min-h-screen py-8 px-4 sm:px-6 lg:px-8 pt-20">
        <div class="max-w-7xl mx-auto">


            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 border border-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode
                                Reservasi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama
                                Pelanggan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tanggal Reservasi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jam
                                Reservasi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nomor
                                Meja</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($reservasis as $reservasi)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $reservasi->kode_reservasi_222297 }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $reservasi->nama_pelanggan_222297 }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $reservasi->tanggal_reservasi_222297 }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $reservasi->jam_reservasi_222297 }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $reservasi->nomor_meja_222297 }}</td>
                                <td class="px-6 py-4 whitespace-nowrap space-x-2">
                                    <a href="{{ route('admin.reservasi.show', $reservasi->kode_reservasi_222297) }}"
                                        class="text-blue-600 hover:text-blue-900">Show</a>
                                    <a href="{{ route('admin.reservasi.edit', $reservasi->kode_reservasi_222297) }}"
                                        class="text-yellow-600 hover:text-yellow-900">Edit</a>
                                    <form action="{{ route('admin.reservasi.destroy', $reservasi->kode_reservasi_222297) }}"
                                        method="POST" class="inline"
                                        onsubmit="return confirm('Yakin ingin menghapus reservasi ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $reservasis->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
