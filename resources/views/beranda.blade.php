@extends('layouts.guest')
@section('title', 'Beranda')

@section('content')
  <div class="container mx-auto text-center pt-28 pb-12 px-6 min-h-screen flex items-center justify-center">
    <div class="flex flex-col justify-center items-center w-full max-w-5xl">

      {{-- Judul Utama --}}
      <div class="pb-8 md:pb-12 w-full">
        <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-green-950 leading-tight">
          Selamat Datang di Lakutani
        </h1>
        <hr class="my-5 md:my-6 border-t border-slate-400 max-w-xl mx-auto">
        <p class="text-lg sm:text-xl md:text-2xl font-semibold text-green-950 px-2 max-w-4xl mx-auto">
          Analisis Kelayakan Usaha Tani & Pencatatan Keuangan Pertanian
        </p>
      </div>

      <div class="flex flex-col gap-6 text-stone-200 w-full">

        {{-- CARD SEKSI: Di tablet (md) tetap flex-col / stacked agar ruang teks & ikon lega, baru horizontal di desktop (lg) --}}
        <div class="flex flex-col lg:flex-row justify-center gap-6 w-full max-w-2xl lg:max-w-none mx-auto text-stone-200">

          {{-- Card 1 --}}
          <div
            class="flex flex-col sm:flex-row items-center justify-center gap-4 sm:gap-6 lg:gap-8 shadow-2xl rounded-lg p-6 w-full greenImage hover:scale-[1.01] transition duration-300 ease-in-out transform hover:shadow-3xl">
            <i class="ti ti-tractor text-7xl sm:text-8xl lg:text-9xl"></i>
            <div class="flex flex-col text-center sm:text-left gap-1">
              <span class="text-xl sm:text-2xl font-bold leading-snug">
                Analisis Kelayakan <br class="hidden sm:inline" />Usaha Tani
              </span>
            </div>
          </div>

          {{-- Card 2 --}}
          <div
            class="flex flex-col sm:flex-row items-center justify-center gap-4 sm:gap-6 lg:gap-8 shadow-2xl rounded-lg p-6 w-full woodImage hover:scale-[1.01] transition duration-300 ease-in-out transform hover:shadow-3xl">
            <i class="ti ti-plant text-7xl sm:text-8xl lg:text-9xl"></i>
            <div class="flex flex-col text-center sm:text-left gap-1">
              <span class="text-xl sm:text-2xl font-bold leading-snug">
                Pencatatan Keuangan <br class="hidden sm:inline" />Pertanian
              </span>
            </div>
          </div>

        </div>

        {{-- TOMBOL AKSI: Disesuaikan ukurannya agar tidak terlalu masif di tablet --}}
        <div
          class="py-8 md:py-12 flex flex-col sm:flex-row items-center justify-center gap-4 w-full max-w-sm sm:max-w-none mx-auto px-4">
          @auth
            @if (Auth::user()->role === 'petani')
              <a href="{{ route('petani.createProduksi') }}"
                class="btn woodImage border-yellow-800 text-lg md:text-xl w-full sm:w-auto px-8 py-3 md:py-4 text-stone-200 hover:scale-[1.01] transition duration-300 ease-in-out transform cursor-pointer hover:shadow-3xl flex items-center justify-center">
                Mulai Analisis
              </a>
              <a href="{{ route('petani.createKeuangan') }}"
                class="btn greenImage border-green-800 text-lg md:text-xl w-full sm:w-auto px-8 py-3 md:py-4 text-stone-200 hover:scale-[1.01] transition duration-300 ease-in-out transform cursor-pointer hover:shadow-3xl flex items-center justify-center">
                Catat Keuangan
              </a>
            @endif
          @endauth

          @guest
            <a href="{{ route('login') }}"
              class="btn woodImage border-yellow-800 text-lg md:text-xl w-full sm:w-auto px-8 py-3 md:py-4 text-stone-200 hover:scale-[1.01] transition duration-300 ease-in-out transform cursor-pointer hover:shadow-3xl flex items-center justify-center">
              Mulai Analisis
            </a>
            <a href="{{ route('login') }}"
              class="btn greenImage border-green-800 text-lg md:text-xl w-full sm:w-auto px-8 py-3 md:py-4 text-stone-200 hover:scale-[1.01] transition duration-300 ease-in-out transform cursor-pointer hover:shadow-3xl flex items-center justify-center">
              Catat Keuangan
            </a>
          @endguest
        </div>

      </div>
    </div>
  </div>
@endsection
