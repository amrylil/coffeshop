@extends('layouts.dashboard-layout')

@section('content')
    <div class="container mx-auto pt-20 px-4">
        <form class="bg-white p-6 rounded-lg shadow-md" action="#" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Header with decorative elements -->
            <div class="border-b border-amber-200 pb-4 mb-6">
                <div class="flex justify-between items-center">
                    <h1 class="text-2xl font-bold text-amber-900">Tambah Varian Kopi</h1>
                    <div class="flex items-center text-amber-600">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 mr-2">
                            <path
                                d="M12 .75a8.25 8.25 0 00-4.135 15.39c.686.398 1.115 1.008 1.134 1.623a.75.75 0 00.577.706c.352.083.71.148 1.074.195.323.041.6-.218.6-.544v-4.661a6.75 6.75 0 1113.5 0v4.661c0 .326.277.585.6.544.364-.047.722-.112 1.074-.195a.75.75 0 00.577-.706c.02-.615.448-1.225 1.134-1.623A8.25 8.25 0 0012 .75z" />
                            <path fill-rule="evenodd"
                                d="M9.151 6.559a.75.75 0 01.569-.31h4.56a.75.75 0 01.569.31l2.1 2.85a.75.75 0 01-.569 1.19h-8.76a.75.75 0 01-.569-1.19l2.1-2.85z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="text-sm font-medium">Form Varian Baru</span>
                    </div>
                </div>
            </div>

            <!-- Main form with 2-column grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5">
                <!-- Left Column -->
                <div class="space-y-5">
                    <!-- Kode Menu -->


                    <!-- Nama Kopi -->
                    <div>
                        <label for="nama_222297" class="block text-sm font-medium text-amber-800 mb-2">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="w-4 h-4 mr-1 text-amber-600">
                                    <path
                                        d="M11.25 4.533A9.707 9.707 0 006 3a9.735 9.735 0 00-3.25.555.75.75 0 00-.5.707v14.25a.75.75 0 001 .707A8.237 8.237 0 016 18.75c1.995 0 3.823.707 5.25 1.886V4.533zM12.75 20.636A8.214 8.214 0 0118 18.75c.966 0 1.89.166 2.75.47a.75.75 0 001-.708V4.262a.75.75 0 00-.5-.707A9.735 9.735 0 0018 3a9.707 9.707 0 00-5.25 1.533v16.103z" />
                                </svg>
                                Nama Kopi
                            </div>
                        </label>
                        <input type="text" name="nama_222297" id="nama_222297" placeholder="Masukkan nama kopi"
                            class="border border-amber-200 p-2.5 w-full rounded-md focus:outline-none focus:ring-2 focus:ring-amber-500 bg-amber-50">
                    </div>

                    <!-- Kategori Kopi -->
                    <div>
                        <label for="kode_kategori_222297" class="block text-sm font-medium text-amber-800 mb-2">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="w-4 h-4 mr-1 text-amber-600">
                                    <path fill-rule="evenodd"
                                        d="M5.25 2.25a3 3 0 00-3 3v4.318a3 3 0 00.879 2.121l9.58 9.581c.92.92 2.39.92 3.31 0l4.801-4.801a2.25 2.25 0 000-3.182L12.53 4.977a3 3 0 00-2.122-.879H5.25zM6.375 7.5a1.125 1.125 0 100-2.25 1.125 1.125 0 000 2.25z"
                                        clip-rule="evenodd" />
                                </svg>
                                Kategori Kopi
                            </div>
                        </label>
                        <select name="kode_kategori_222297" id="kode_kategori_222297"
                            class="border border-amber-200 p-2.5 w-full rounded-md focus:outline-none focus:ring-2 focus:ring-amber-500 bg-amber-50">
                            <option value="">Pilih Kategori</option>
                            <option value="KAT001">Espresso</option>
                            <option value="KAT002">Cappuccino</option>
                            <option value="KAT003">Manual Brew</option>
                            <option value="KAT004">Latte</option>
                            <option value="KAT005">Cold Brew</option>
                        </select>
                    </div>

                    <!-- Gambar Kopi -->
                    <div>
                        <label for="path_img_222297" class="block text-sm font-medium text-amber-800 mb-2">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="w-4 h-4 mr-1 text-amber-600">
                                    <path fill-rule="evenodd"
                                        d="M1.5 6a2.25 2.25 0 012.25-2.25h16.5A2.25 2.25 0 0122.5 6v12a2.25 2.25 0 01-2.25 2.25H3.75A2.25 2.25 0 011.5 18V6zM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0021 18v-1.94l-2.69-2.689a1.5 1.5 0 00-2.12 0l-.88.879.97.97a.75.75 0 11-1.06 1.06l-5.16-5.159a1.5 1.5 0 00-2.12 0L3 16.061zm10.125-7.81a1.125 1.125 0 112.25 0 1.125 1.125 0 01-2.25 0z"
                                        clip-rule="evenodd" />
                                </svg>
                                Gambar Kopi
                            </div>
                        </label>
                        <div class="flex items-center justify-center w-full">
                            <label for="path_img_222297"
                                class="flex flex-col items-center justify-center w-full h-40 border-2 border-amber-200 border-dashed rounded-lg cursor-pointer bg-amber-50 hover:bg-amber-100">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                        class="w-8 h-8 mb-3 text-amber-400">
                                        <path d="M12 9a3.75 3.75 0 100 7.5A3.75 3.75 0 0012 9z" />
                                        <path fill-rule="evenodd"
                                            d="M9.344 3.071a49.52 49.52 0 015.312 0c.967.052 1.83.585 2.332 1.39l.821 1.317c.24.383.645.643 1.11.71.386.054.77.113 1.152.177 1.432.239 2.429 1.493 2.429 2.909V18a3 3 0 01-3 3h-15a3 3 0 01-3-3V9.574c0-1.416.997-2.67 2.429-2.909.382-.064.766-.123 1.151-.178a1.56 1.56 0 001.11-.71l.822-1.315a2.942 2.942 0 012.332-1.39zM6.75 12.75a5.25 5.25 0 1110.5 0 5.25 5.25 0 01-10.5 0zm12-1.5a.75.75 0 100-1.5.75.75 0 000 1.5z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <p class="mb-2 text-sm text-amber-700"><span class="font-medium">Klik untuk
                                            upload</span> atau drag and drop</p>
                                    <p class="text-xs text-amber-600">Format: JPG, PNG (Max. 2MB)</p>
                                </div>
                                <input id="path_img_222297" name="path_img_222297" type="file" class="hidden" />
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="space-y-5">
                    <!-- Deskripsi -->
                    <div>
                        <label for="deskripsi_222297" class="block text-sm font-medium text-amber-800 mb-2">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="w-4 h-4 mr-1 text-amber-600">
                                    <path fill-rule="evenodd"
                                        d="M4.125 3C3.089 3 2.25 3.84 2.25 4.875V18a3 3 0 003 3h15a3 3 0 01-3-3V4.875C17.25 3.839 16.41 3 15.375 3H4.125zM12 9.75a.75.75 0 000 1.5h1.5a.75.75 0 000-1.5H12zm-.75-2.25a.75.75 0 01.75-.75h1.5a.75.75 0 010 1.5H12a.75.75 0 01-.75-.75zM6 12.75a.75.75 0 000 1.5h7.5a.75.75 0 000-1.5H6zm-.75 3.75a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5H6a.75.75 0 01-.75-.75zM6 6.75a.75.75 0 00-.75.75v3c0 .414.336.75.75.75h3a.75.75 0 00.75-.75v-3A.75.75 0 009 6.75H6z"
                                        clip-rule="evenodd" />
                                    <path d="M18.75 6.75h1.875c.621 0 1.125.504 1.125 1.125V18a1.5 1.5 0 01-3 0V6.75z" />
                                </svg>
                                Deskripsi
                            </div>
                        </label>
                        <textarea name="deskripsi_222297" id="deskripsi_222297" placeholder="Deskripsikan kopi ini (rasa, aroma, karakteristik)"
                            class="border border-amber-200 p-2.5 w-full rounded-md focus:outline-none focus:ring-2 focus:ring-amber-500 bg-amber-50"
                            rows="5"></textarea>
                    </div>

                    <!-- Harga -->
                    <div>
                        <label for="harga_222297" class="block text-sm font-medium text-amber-800 mb-2">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="w-4 h-4 mr-1 text-amber-600">
                                    <path
                                        d="M10.464 8.746c.227-.18.497-.311.786-.394v2.795a2.252 2.252 0 01-.786-.393c-.394-.313-.546-.681-.546-1.004 0-.323.152-.691.546-1.004zM12.75 15.662v-2.824c.347.085.664.228.921.421.427.32.579.686.579.991 0 .305-.152.671-.579.991a2.534 2.534 0 01-.921.42z" />
                                    <path fill-rule="evenodd"
                                        d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM12.75 6a.75.75 0 00-1.5 0v.816a3.836 3.836 0 00-1.72.756c-.712.566-1.112 1.35-1.112 2.178 0 .829.4 1.612 1.113 2.178.502.4 1.102.647 1.719.756v2.978a2.536 2.536 0 01-.921-.421l-.879-.66a.75.75 0 00-.9 1.2l.879.66c.533.4 1.169.645 1.821.75V18a.75.75 0 001.5 0v-.81a4.124 4.124 0 001.821-.749c.745-.559 1.179-1.344 1.179-2.191 0-.847-.434-1.632-1.179-2.191a4.122 4.122 0 00-1.821-.75V8.354c.29.082.559.213.786.393l.415.33a.75.75 0 00.933-1.175l-.415-.33a3.836 3.836 0 00-1.719-.755V6z"
                                        clip-rule="evenodd" />
                                </svg>
                                Harga
                            </div>
                        </label>
                        <div class="flex items-center">
                            <span
                                class="inline-flex items-center px-3 py-3 h-full  text-sm text-amber-800 bg-amber-100 border border-r-0 border-amber-200 rounded-l-md">
                                Rp
                            </span>
                            <input type="number" name="harga_222297" id="harga_222297" placeholder="25000"
                                class="border border-amber-200 p-2.5 w-full rounded-r-md focus:outline-none focus:ring-2 focus:ring-amber-500 bg-amber-50">
                        </div>
                    </div>

                    <!-- Stok -->
                    <div>
                        <label for="jumlah_222297" class="block text-sm font-medium text-amber-800 mb-2">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="w-4 h-4 mr-1 text-amber-600">
                                    <path
                                        d="M2.25 2.25a.75.75 0 000 1.5h1.386c.17 0 .318.114.362.278l2.558 9.592a3.752 3.752 0 00-2.806 3.63c0 .414.336.75.75.75h15.75a.75.75 0 000-1.5H5.378A2.25 2.25 0 017.5 15h11.218a.75.75 0 00.674-.421 60.358 60.358 0 002.96-7.228.75.75 0 00-.525-.965A60.864 60.864 0 005.68 4.509l-.232-.867A1.875 1.875 0 003.636 2.25H2.25zM3.75 20.25a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0zM16.5 20.25a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0z" />
                                </svg>
                                Stok
                            </div>
                        </label>
                        <input type="number" name="jumlah_222297" id="jumlah_222297" placeholder="Jumlah tersedia"
                            class="border border-amber-200 p-2.5 w-full rounded-md focus:outline-none focus:ring-2 focus:ring-amber-500 bg-amber-50">
                    </div>


                </div>
            </div>

            <!-- Action Buttons -->
            <div class="mt-8 border-t border-amber-200 pt-6">
                <div class="flex gap-3 justify-end">
                    <a href="/admin/produk"
                        class="bg-white border border-amber-800 text-amber-800 py-2.5 px-5 rounded-md hover:bg-amber-50 focus:outline-none focus:ring-2 focus:ring-amber-500 transition duration-300 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            class="w-4 h-4 mr-1">
                            <path fill-rule="evenodd"
                                d="M5.47 5.47a.75.75 0 011.06 0L12 10.94l5.47-5.47a.75.75 0 111.06 1.06L13.06 12l5.47 5.47a.75.75 0 11-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 01-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 010-1.06z"
                                clip-rule="evenodd" />
                        </svg>
                        Batal
                    </a>
                    <button type="submit"
                        class="bg-amber-800 text-amber-50 py-2.5 px-8 rounded-md hover:bg-amber-900 focus:outline-none focus:ring-2 focus:ring-amber-500 transition duration-300 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            class="w-4 h-4 mr-1">
                            <path fill-rule="evenodd"
                                d="M19.916 4.626a.75.75 0 01.208 1.04l-9 13.5a.75.75 0 01-1.154.114l-6-6a.75.75 0 011.06-1.06l5.353 5.353 8.493-12.739a.75.75 0 011.04-.208z"
                                clip-rule="evenodd" />
                        </svg>
                        Simpan
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
