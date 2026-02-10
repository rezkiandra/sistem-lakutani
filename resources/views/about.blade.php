@extends('layouts.guest')
@section('title', 'Home')

@section('content')
  <div class="container mx-auto text-center pt-16 min-h-screen">
    <div class="pb-24">
      <h1 class="text-5xl font-extrabold text-green-950 mb-10">Koperasi Usaha Tani</h1>
      <p class="text-3xl font-semibold text-green-950">Solusi Terpadu untuk Meningkatkan Produktivitas Petani</p>
    </div>

    <div class="grid grid-cols-2 gap-8 text-stone-200">
      <div class="flex flex-row items-center justify-center gap-8 shadow-2xl rounded-lg p-8 greenImage">
        <i class="ti ti-tractor text-8xl"></i>
        <div class="flex flex-col text-start gap-3">
          <span class="text-2xl font-bold">Sewa Alat Pertanian</span>
          <span class="text-base">Layanan penyewaan traktor dan alat pertanian untuk meningkatkan produktivitas
            petani</span>
        </div>
      </div>
      <div class="flex flex-row items-center justify-center gap-8 shadow-2xl rounded-lg p-8 woodImage">
        <i class="ti ti-plant text-8xl"></i>
        <div class="flex flex-col text-start gap-3">
          <span class="text-2xl font-bold">Pembelian Sarana Produksi Pertanian</span>
          <span class="text-base">Layanan penyewaan traktor dan alat pertanian untuk meningkatkan produktivitas
            petani</span>
        </div>
      </div>
      <div class="flex flex-row items-center justify-center gap-8 shadow-2xl rounded-lg p-8 woodImage">
        <i class="ti ti-coin-euro text-8xl"></i>
        <div class="flex flex-col text-start gap-3">
          <span class="text-2xl font-bold">Pinjaman Modal Tani</span>
          <span class="text-base">Layanan penyewaan traktor dan alat pertanian untuk meningkatkan produktivitas
            petani</span>
        </div>
      </div>
      <div class="flex flex-row items-center justify-center gap-8 shadow-2xl rounded-lg p-8 woodImage">
        <i class="ti ti-bubble-text text-8xl"></i>
        <div class="flex flex-col text-start gap-3">
          <span class="text-2xl font-bold">Konsultasi Tenaga Ahli</span>
          <span class="text-base">Layanan penyewaan traktor dan alat pertanian untuk meningkatkan produktivitas
            petani</span>
        </div>
      </div>
    </div>

    <div class="py-16">
      <button class="btn greenImage border-green-800 text-2xl px-10 py-8 text-stone-200">Gabung Koperasi</button>
    </div>
  </div>
@endsection
