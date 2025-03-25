@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
<section class="">

  <div class=" mx-auto py-12 font-jost">
    <h1 class="text-4xl font-bold text-center mb-12 uppercase">Daftar Kategori</h1>

    <div class="space-y-8">
        <!-- Kategori 1 -->
        <div class="flex flex-col justify-between md:flex-row h-60 items-center gap-8 border-linen px-5 rounded-md shadow-md">
            <div class="relative w-full md:w-1/2 ">
                <img src="{{ asset('images/kaos.png') }}" alt="Kaos" class="w-full object-cover object-top h-full">
            </div>
            <div class="w-full md:w-1/2 flex flex-col items-end">
                <h2 class="text-slate-950 font-bold">Pakaian Santai</h2>
                <h3 class="text-2xl font-bold text-gray-800">Kaos</h3>
                <p class="text-gray-600 my-2">Pakaian stylish dan nyaman untuk setiap kesempatan.</p>
                <a href="#" class="text-slate-950 border border-slate-950 hover:bg-linen  px-5 py-2  shadow-md inline-block">Belanja Sekarang →</a>
            </div>
        </div>

        <!-- Kategori 2 -->
        <div class="flex flex-col md:flex-row-reverse h-60 overflow-hidden items-center gap-8 border border-linen px-5 rounded-md shadow-md">
            <div class="relative w-full md:w-1/2 h-full ">
                <img src="https://img.freepik.com/free-vector/empty-mens-classic-black-shirt-with-short-sleeves_1441-2804.jpg?t=st=1742885418~exp=1742889018~hmac=8648dbc000cf1c9e10aca233d6b1d313ecf002adb87e1cb78af7d40ca829a2c1&w=1380" alt="Kemeja" class="w-full object-cover object-top h-full">
            </div>
            <div class="w-full md:w-1/2">
                <h2 class="text-slate-950 font-bold">Gaya Elegan</h2>
                <h3 class="text-2xl font-bold text-gray-800">Kemeja</h3>
                <p class="text-gray-600 my-2">Gaya elegan yang dirancang dengan sempurna.</p>
                <a href="#" class="text-slate-950 border border-slate-950 hover:bg-linen  px-5 py-2  shadow-md inline-block">Belanja Sekarang →</a>
            </div>
        </div>

        <!-- Kategori 3 -->
        <div class="flex flex-col justify-between md:flex-row h-60 items-center gap-8 border-linen px-5 rounded-md shadow-md">
          <div class="relative w-full md:w-1/2 h-full">
              <img src="{{ asset('images/long_pants.png') }}" alt="Celana" class="w-full object-cover object-top h-full transform scale-x-[-1]">
          </div>
          <div class="w-full md:w-1/2 flex flex-col items-end">
              <h2 class="text-slate-950 font-bold">Pakaian Santai</h2>
              <h3 class="text-2xl font-bold text-gray-800">Celana</h3>
              <p class="text-gray-600 my-2">Pakaian stylish dan nyaman untuk setiap kesempatan.</p>
              <a href="#" class="text-slate-950 border border-slate-950 hover:bg-linen  px-5 py-2  shadow-md inline-block">Belanja Sekarang →</a>
          </div>
        </div>

        <!-- Kategori 4 -->
        <div class="flex flex-col md:flex-row-reverse h-60 overflow-hidden items-center gap-8 border border-linen px-5 rounded-md shadow-md">
          <div class="relative w-full md:w-1/2 h-full ">
              <img src="{{ asset('images/hoddie.png') }}" alt="Jaket & Hoodie" class="w-full object-cover object-top h-full">
          </div>
          <div class="w-full md:w-1/2">
              <h2 class="text-slate-950 font-bold">Gaya Elegan</h2>
              <h3 class="text-2xl font-bold text-gray-800">Jaket & Hoodie</h3>
              <p class="text-gray-600 my-2">Gaya elegan yang dirancang dengan sempurna.</p>
              <a href="#" class="text-slate-950 border border-slate-950 hover:bg-linen  px-5 py-2  shadow-md inline-block">Belanja Sekarang →</a>
          </div>
      </div>
    </div>
</div>

</section>
@endsection
