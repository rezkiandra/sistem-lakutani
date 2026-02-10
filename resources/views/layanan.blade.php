@extends('layouts.guest')
@section('title', 'Layanan')

@section('content')
  <div class="container mx-auto text-center pt-16 min-h-screen flex items-center justify-center">
    <div class="flex flex-col items-center justify-center">
      <div class="pb-16">
        <h1 class="text-5xl font-extrabold text-green-950">Koperasi Usaha Tani</h1>
				<hr class="my-8 border-slate-800">
        <p class="text-3xl font-semibold text-green-950">Solusi Terpadu untuk Meningkatkan Produktivitas Petani</p>
      </div>

      <div class="grid grid-cols-2 gap-8 text-stone-200">
        <div class="flex flex-row items-center justify-center gap-8 shadow-2xl rounded-lg p-6 greenImage hover:scale-101 transition duration-300 ease-in-out transform cursor-pointer hover:shadow-3xl">
          <i class="ti ti-tractor text-9xl"></i>
          <div class="flex flex-col text-start gap-3">
            <span class="text-3xl font-extrabold">Sewa Alat Pertanian</span>
            <span class="text-xl">Layanan penyewaan traktor dan alat pertanian untuk meningkatkan produktivitas
              petani</span>
          </div>
        </div>
        <div class="flex flex-row items-center justify-center gap-8 shadow-2xl rounded-lg p-6 woodImage hover:scale-101 transition duration-300 ease-in-out transform cursor-pointer hover:shadow-3xl">
          <i class="ti ti-plant text-9xl"></i>
          <div class="flex flex-col text-start gap-3">
            <span class="text-3xl font-extrabold">Pembelian Sarana <br/>Produksi Pertanian</span>
            <span class="text-xl">Layanan penyewaan traktor dan alat pertanian untuk meningkatkan produktivitas
              petani</span>
          </div>
        </div>
        <div class="flex flex-row items-center justify-center gap-8 shadow-2xl rounded-lg p-6 woodImage hover:scale-101 transition duration-300 ease-in-out transform cursor-pointer hover:shadow-3xl">
          <i class="ti ti-coin-euro text-9xl"></i>
          <div class="flex flex-col text-start gap-3">
            <span class="text-3xl font-extrabold">Pinjaman Modal Tani</span>
            <span class="text-xl">Layanan penyewaan traktor dan alat pertanian untuk meningkatkan produktivitas
              petani</span>
          </div>
        </div>
        <div class="flex flex-row items-center justify-center gap-8 shadow-2xl rounded-lg p-6 woodImage hover:scale-101 transition duration-300 ease-in-out transform cursor-pointer hover:shadow-3xl">
          <i class="ti ti-bubble-text text-9xl"></i>
          <div class="flex flex-col text-start gap-3">
            <span class="text-3xl font-extrabold">Konsultasi Tenaga Ahli</span>
            <span class="text-xl">Layanan penyewaan traktor dan alat pertanian untuk meningkatkan produktivitas
              petani</span>
          </div>
        </div>
      </div>

      <div class="pt-16">
        <button class="btn greenImage border-green-800 text-2xl px-10 py-8 text-stone-200 hover:scale-101 transition duration-300 ease-in-out transform cursor-pointer hover:shadow-3xl">Gabung Koperasi</button>
      </div>
    </div>
  </div>
@endsection
