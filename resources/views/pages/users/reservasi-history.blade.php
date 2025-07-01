@extends('layouts.app')

@section('title', 'Riwayat Reservasi')

@section('content')
    <section class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="text-center mb-12">
                <h2 class="text-5xl font-serif italic mb-6 text-[#e6dbd1]">Riwayat Reservasi</h2>
                <p class="text-xl font-light text-slate-50">
                    Berikut adalah daftar semua reservasi yang telah Anda buat.
                </p>
            </div>

            <div class="bg-white rounded-xl shadow-lg border border-[#d7cdc3] overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Kode Reservasi
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Nama Pemesan
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Tanggal & Waktu
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Meja
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th scope="col" class="relative px-6 py-3">
                                    <span class="sr-only">Aksi</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($reservasi as $item)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-gray-900">
                                        {{ $item->kode_reservasi }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                        {{ $item->nama_pelanggan }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                        {{ $item->tanggal_reservasi->isoFormat('D MMM YYYY') }} -
                                        {{ $item->jam_reservasi->format('H:i') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                        {{ $item->meja->nomor_meja }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $batasWaktu = \Carbon\Carbon::parse(
                                                $item->tanggal_reservasi->toDateString() .
                                                    ' ' .
                                                    $item->jam_reservasi->toTimeString(),
                                            )->addMinutes(15);
                                            $isBatal = \Carbon\Carbon::now()->gt($batasWaktu);
                                            $statusClass = $isBatal
                                                ? 'bg-red-100 text-red-700'
                                                : 'bg-green-100 text-green-700';
                                        @endphp
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                                            {{ $isBatal ? 'Batal' : 'Aktif' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('reservasi.detail', ['kode_reservasi' => $item->kode_reservasi]) }}"
                                            class="text-[#6f4e37] hover:text-[#5d4130]">Lihat Detail</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-sm text-gray-500">
                                        Anda belum memiliki riwayat reservasi.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($reservasi->hasPages())
                    <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                        {{ $reservasi->links() }}
                    </div>
                @endif
            </div>

            <div class="mt-8 text-center">
                <a href="{{ route('reservasi.index') }}"
                    class="inline-block bg-[#6f4e37] text-white py-3 px-8 rounded-lg font-medium hover:bg-[#5d4130] transition duration-300">
                    Buat Reservasi Baru
                </a>
            </div>
        </div>
    </section>
@endsection
