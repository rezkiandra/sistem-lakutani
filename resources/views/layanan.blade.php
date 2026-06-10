@extends('layouts.guest')
@section('title', 'Layanan')

@section('content')
  <div class="container mx-auto text-center pt-28 pb-12 px-6 min-h-screen flex items-center justify-center">
    <div class="flex flex-col items-center justify-center w-full max-w-6xl">

      {{-- Judul Utama --}}
      <div class="pb-8 md:pb-12 w-full">
        <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-green-950 leading-tight">Koperasi Usaha Tani</h1>
        <hr class="my-5 md:my-6 border-t border-slate-400 max-w-xl mx-auto">
        <p class="text-lg sm:text-xl md:text-2xl font-semibold text-green-950 px-2 max-w-3xl mx-auto">
          Solusi Terpadu untuk Meningkatkan Produktivitas Petani
        </p>
      </div>

      {{-- GRID LAYOUT: 
           - Mobile & Tablet Portrait: 1 Kolom, susunan internal ikon & teks menggunakan sm:flex-row agar lega.
           - Desktop (lg): Berubah menjadi 2 Kolom grid berdampingan. --}}
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 text-stone-200 w-full max-w-2xl lg:max-w-none mx-auto">

        {{-- Layanan 1 --}}
        <div
          class="flex flex-col sm:flex-row items-center justify-center sm:justify-start gap-4 sm:gap-6 shadow-2xl rounded-lg p-6 sm:p-8 greenImage hover:scale-[1.01] transition duration-300 ease-in-out transform cursor-pointer hover:shadow-3xl">
          <i class="ti ti-tractor text-7xl sm:text-8xl lg:text-9xl flex-shrink-0"></i>
          <div class="flex flex-col text-center sm:text-left gap-1.5">
            <span class="text-xl sm:text-2xl font-bold leading-snug">Sewa Alat Pertanian</span>
            <span class="text-sm sm:text-base text-stone-200/90">Layanan penyewaan traktor, mesin pemanen, dan alat modern
              untuk menunjang produktivitas.</span>
          </div>
        </div>

        {{-- Layanan 2 --}}
        <div
          class="flex flex-col sm:flex-row items-center justify-center sm:justify-start gap-4 sm:gap-6 shadow-2xl rounded-lg p-6 sm:p-8 woodImage hover:scale-[1.01] transition duration-300 ease-in-out transform cursor-pointer hover:shadow-3xl">
          <i class="ti ti-plant text-7xl sm:text-8xl lg:text-9xl flex-shrink-0"></i>
          <div class="flex flex-col text-center sm:text-left gap-1.5">
            <span class="text-xl sm:text-2xl font-bold leading-snug">Pembelian Sarana Produksi</span>
            <span class="text-sm sm:text-base text-stone-200/90">Penyediaan pupuk bersubsidi, bibit unggul bersertifikat,
              dan obat-obatan pertanian berkualitas.</span>
          </div>
        </div>

        {{-- Layanan 3 --}}
        <div
          class="flex flex-col sm:flex-row items-center justify-center sm:justify-start gap-4 sm:gap-6 shadow-2xl rounded-lg p-6 sm:p-8 woodImage hover:scale-[1.01] transition duration-300 ease-in-out transform cursor-pointer hover:shadow-3xl">
          <i class="ti ti-coin-euro text-7xl sm:text-8xl lg:text-9xl flex-shrink-0"></i>
          <div class="flex flex-col text-center sm:text-left gap-1.5">
            <span class="text-xl sm:text-2xl font-bold leading-snug">Pinjaman Modal Tani</span>
            <span class="text-sm sm:text-base text-stone-200/90">Fasilitas pembiayaan dan kredit lunak modal kerja dengan
              bunga ringan khusus bagi anggota koperasi.</span>
          </div>
        </div>

        {{-- Layanan 4 --}}
        <div
          class="flex flex-col sm:flex-row items-center justify-center sm:justify-start gap-4 sm:gap-6 shadow-2xl rounded-lg p-6 sm:p-8 woodImage hover:scale-[1.01] transition duration-300 ease-in-out transform cursor-pointer hover:shadow-3xl">
          <i class="ti ti-bubble-text text-7xl sm:text-8xl lg:text-9xl flex-shrink-0"></i>
          <div class="flex flex-col text-center sm:text-left gap-1.5">
            <span class="text-xl sm:text-2xl font-bold leading-snug">Konsultasi Tenaga Ahli</span>
            <span class="text-sm sm:text-base text-stone-200/90">Bimbingan teknis bersama penyuluh pertanian untuk
              penanggulangan hama dan optimalisasi hasil panen.</span>
          </div>
        </div>

      </div>

      {{-- Tombol Aksi --}}
      <div class="pt-10 md:pt-14 w-full max-w-xs sm:max-w-none px-4 mx-auto">
        <button
          class="btn greenImage border-green-800 text-lg md:text-xl w-full sm:w-auto px-10 py-3 md:py-4 text-stone-200 hover:scale-[1.01] transition duration-300 ease-in-out transform cursor-pointer hover:shadow-3xl flex items-center justify-center mx-auto">
          Gabung Koperasi
        </button>
      </div>

    </div>
  </div>
@endsection
