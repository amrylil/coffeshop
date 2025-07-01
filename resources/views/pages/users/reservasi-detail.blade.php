@extends('layouts.app')

@section('title', 'Detail Reservasi')

@section('content')
    <section class="py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="text-center mb-12">
                <h2 class="text-5xl font-serif italic mb-6 text-[#e6dbd1]">Riwayat Reservasi</h2>
                <p class="text-xl font-light text-slate-50">
                    Terima kasih telah melakukan reservasi di <span class="font-serif italic text-[#e6dbd1]">Coffee
                        Shop</span>.
                </p>
            </div>

            {{-- Notifikasi Sukses --}}
            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg mb-6" role="alert">
                    <p class="font-bold">Sukses!</p>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-white rounded-xl shadow-lg border border-[#d7cdc3] overflow-hidden">
                <div class="bg-[#6f4e37] p-6">
                    <h3 class="text-2xl font-serif text-white">Detail Reservasi Anda</h3>
                    <p class="text-sm text-[#e6dbd1]">Kode Reservasi: <span
                            class="font-mono">{{ $reservasi->kode_reservasi }}</span></p>
                </div>

                <div class="p-8 space-y-6">
                    @php
                        $waktuReservasi = \Carbon\Carbon::parse(
                            $reservasi->tanggal_reservasi->toDateString() .
                                ' ' .
                                $reservasi->jam_reservasi->toTimeString(),
                        );
                        $sekarang = \Carbon\Carbon::now();
                        $batasWaktu = $waktuReservasi->copy()->addMinutes(15);
                        $isBatal = $sekarang->gt($batasWaktu);
                        $statusReservasi = $isBatal ? 'Batal' : 'Aktif';
                        $statusClass = $isBatal ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700';
                    @endphp

                    <!-- Detail Utama -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-gray-800">
                        <div>
                            <span class="font-semibold text-gray-500 block">Nama Pemesan</span>
                            <p class="text-lg">{{ $reservasi->nama_pelanggan }}</p>
                        </div>
                        <div>
                            <span class="font-semibold text-gray-500 block">Nomor Telepon</span>
                            <p class="text-lg">{{ $reservasi->no_telepon }}</p>
                        </div>
                        <div>
                            <span class="font-semibold text-gray-500 block">Nomor Meja</span>
                            <p class="text-lg font-mono">{{ $reservasi->meja->nomor_meja }} (Kapasitas:
                                {{ $reservasi->meja->kapasitas }} orang)</p>
                        </div>
                        <div>
                            <span class="font-semibold text-gray-500 block">Waktu Reservasi</span>
                            <p class="text-lg">{{ $reservasi->tanggal_reservasi->isoFormat('dddd, D MMMM YYYY') }} -
                                {{ $reservasi->jam_reservasi->format('H:i') }}</p>
                        </div>
                        <div>
                            <span class="font-semibold text-gray-500 block">Status</span>
                            <p class="text-lg px-3 py-1 text-sm font-bold inline-block rounded-full {{ $statusClass }}">
                                {{ $statusReservasi }}
                            </p>
                        </div>
                        @if ($reservasi->catatan)
                            <div class="md:col-span-2">
                                <span class="font-semibold text-gray-500 block">Catatan Tambahan</span>
                                <p class="text-lg italic bg-gray-50 p-3 rounded-md">"{{ $reservasi->catatan }}"</p>
                            </div>
                        @endif
                    </div>

                    <!-- Catatan Penting -->
                    <div class="border-t border-dashed border-[#d7cdc3] pt-6 mt-6">
                        <h4 class="text-xl font-serif text-[#3a2a1d] mb-3">Catatan Penting</h4>
                        <div class="bg-yellow-50 border-l-4 border-yellow-400 text-yellow-800 p-4 rounded-r-lg">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <svg class="h-6 w-6 text-yellow-500" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M8.257 3.099c.636-1.026 2.252-1.026 2.888 0l6.22 10.003c.636 1.026-.18 2.398-1.444 2.398H3.48c-1.264 0-2.08-1.372-1.444-2.398l6.22-10.003zM10 12a1 1 0 110-2 1 1 0 010 2zm-1-3a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium">Reservasi akan otomatis <strong>dibatalkan</strong> jika
                                        Anda tidak hadir lebih dari <strong>15 menit</strong> dari waktu yang telah
                                        dijadwalkan.</p>
                                    <p class="text-sm mt-1">Batas waktu kedatangan Anda adalah pukul: <strong
                                            class="font-mono">{{ $batasWaktu->format('H:i') }}</strong></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 text-center flex flex-col sm:flex-row justify-center gap-4">
                        <a href="{{ route('reservasi.history') }}"
                            class="inline-block bg-gray-500 text-white py-3 px-8 rounded-lg font-medium hover:bg-gray-600 transition duration-300">
                            Kembali ke Riwayat
                        </a>
                        <a href="{{ route('reservasi.index') }}"
                            class="inline-block bg-[#6f4e37] text-white py-3 px-8 rounded-lg font-medium hover:bg-[#5d4130] transition duration-300">
                            Buat Reservasi Baru
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
