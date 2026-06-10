@extends('layouts.guest')
@section('title', 'Informasi')

@section('content')
  <div class="container mx-auto pt-24 pb-12 px-4 min-h-screen flex flex-col items-center justify-center">

    <div class="w-full mx-auto grid grid-cols-1 lg:grid-cols-3 gap-6 mt-2">

      <div
        class="lg:col-span-2 bg-amber-50/90 border-2 border-stone-300 rounded-xl shadow-2xl p-4 sm:p-6 relative overflow-hidden flex flex-col justify-between">

        <div>
          <div
            class="woodImage -mx-4 sm:-mx-6 -mt-4 sm:-mt-6 p-4 px-6 border-b-2 border-stone-400 flex justify-between items-center text-stone-100">
            <h2 class="text-xl sm:text-2xl font-bold tracking-wide">Detail Traktor</h2>
          </div>

          <div class="flex flex-col md:grid md:grid-cols-5 gap-6 mt-6">

            <div class="md:col-span-2 flex flex-col gap-4">
              <div
                class="w-full aspect-[4/3] bg-emerald-900/10 rounded-lg border-2 border-amber-900/20 overflow-hidden shadow-inner flex items-center justify-center relative group">
                <i
                  class="ti ti-tractor text-6xl sm:text-7xl text-emerald-800/40 group-hover:scale-110 transition duration-300"></i>
                <div class="absolute bottom-2 left-2 bg-black/50 text-white text-xs px-2 py-1 rounded">Foto Alat</div>
              </div>

              <ul
                class="space-y-2 text-stone-700 font-medium text-sm bg-stone-200/50 p-3 rounded-lg border border-stone-300">
                <li class="flex items-center gap-2"><i class="ti ti-coin text-emerald-700"></i> Harga: Rp 150.000 / jam
                </li>
                <li class="flex items-center gap-2"><i class="ti ti-clock text-amber-700"></i> Operasional: 08:00 - 13:00
                  WIB</li>
                <li class="flex items-center gap-2"><i class="ti ti-user text-blue-700"></i> Pemilik: Petani Sejahtera
                </li>
                <li class="flex items-center gap-2"><i class="ti ti-settings text-stone-700"></i> Kondisi: Sangat Baik
                </li>
                <li class="flex items-center gap-2"><i class="ti ti-shield text-red-700"></i> Asuransi: Tersedia</li>
              </ul>
            </div>

            <div class="md:col-span-3 flex flex-col justify-between text-left">
              <div>
                <h3 class="text-xl sm:text-2xl font-black text-stone-800 leading-tight">Traktor Massey Ferguson MF385</h3>
                <p class="text-stone-600 mt-2 text-sm leading-relaxed">
                  Traktor roda 4 yang tangguh dan handal untuk berbagai jenis medan pertanian dan pembajakan sawah.
                </p>

                <hr class="my-4 border-stone-300">

                <div class="space-y-2 text-stone-700 text-sm">
                  <span class="font-bold text-stone-900 block text-base mb-1">Informasi Pemilik:</span>
                  <div class="flex items-start gap-3">
                    <i class="ti ti-user-check text-emerald-800 text-lg mt-0.5"></i>
                    <span>Salah Purnama (Ketua Kelompok)</span>
                  </div>
                  <div class="flex items-start gap-3">
                    <i class="ti ti-phone text-emerald-800 text-lg mt-0.5"></i>
                    <span class="break-all">0821-3434-3885-3732</span>
                  </div>
                  <div class="flex items-start gap-3">
                    <i class="ti ti-map-pin text-emerald-800 text-lg mt-0.5"></i>
                    <span>Ketatan Desa Kasi-8, Kendal, Jawa Tengah</span>
                  </div>
                </div>

                <hr class="my-4 border-stone-300">

                <div class="text-sm text-stone-700">
                  <span class="font-bold text-stone-900 block text-base mb-1 flex items-center gap-1">
                    <i class="ti ti-eye"></i> Catatan Ketentuan:
                  </span>
                  <ul class="list-disc list-inside space-y-1 text-stone-600 pl-1 text-left">
                    <li>Unit harus dipesan minimal H-2 sebelum penggunaan.</li>
                    <li>Harga sewa sudah termasuk bahan bakar awal (Full).</li>
                    <li>Kerusakan akibat kelalaian ditanggung penyewa.</li>
                    <li>Maksimal keterlambatan pengembalian unit 1 jam.</li>
                  </ul>
                </div>
              </div>
            </div>

          </div>
        </div>

        <div class="flex flex-col sm:flex-row gap-3 mt-8 pt-4 border-t border-stone-300">
          <button
            class="w-full sm:w-1/2 greenImage hover:opacity-90 border-2 border-emerald-900 text-stone-100 font-extrabold py-3.5 px-4 rounded-lg text-lg flex items-center justify-center gap-2 shadow-md transition transform active:scale-95">
            <i class="ti ti-message-2 text-xl"></i> Hubungi
          </button>
          <button
            class="w-full sm:w-1/2 bg-gradient-to-b from-emerald-600 to-emerald-800 hover:from-emerald-500 hover:to-emerald-700 border-2 border-emerald-900 text-stone-100 font-extrabold py-3.5 px-4 rounded-lg text-lg flex items-center justify-center gap-2 shadow-md transition transform active:scale-95">
            <i class="ti ti-calendar-check text-xl"></i> Pesan Sekarang
          </button>
        </div>

      </div>

      <div
        class="bg-amber-50/90 border-2 border-stone-300 rounded-xl shadow-2xl p-4 sm:p-6 flex flex-col justify-between text-left">
        <div>
          <h3
            class="text-lg sm:text-xl font-bold text-stone-800 border-b-2 border-stone-300 pb-2 mb-4 flex items-center gap-2">
            <i class="ti ti-history text-emerald-800"></i> Penyewaan Terakhir
          </h3>

          <div class="bg-stone-200/60 p-4 rounded-lg border border-stone-300 flex items-center justify-between mb-6">
            <div class="flex items-center gap-2 text-stone-700">
              <i class="ti ti-calendar-stats text-2xl sm:text-3xl text-amber-800"></i>
              <span class="font-semibold text-sm sm:text-base">Total Digunakan</span>
            </div>
            <span class="text-2xl sm:text-3xl font-black text-emerald-900">36 Kali</span>
          </div>

          <h4 class="font-bold text-stone-800 mb-2 text-sm">Riwayat Penggunaan:</h4>
          <div class="space-y-3">
            <div class="bg-white/80 p-3 rounded border border-stone-200 shadow-sm flex items-start gap-3">
              <i class="ti ti-square-check text-emerald-600 text-xl mt-0.5"></i>
              <div class="text-xs text-stone-600">
                <p class="font-bold text-stone-800 text-sm">Blok Sawah Utara - Selesai</p>
                <p>Oleh: Bpk. Mulyono (24 Mei 2026)</p>
              </div>
            </div>
            <div class="bg-white/80 p-3 rounded border border-stone-200 shadow-sm flex items-start gap-3">
              <i class="ti ti-square-check text-emerald-600 text-xl mt-0.5"></i>
              <div class="text-xs text-stone-600">
                <p class="font-bold text-stone-800 text-sm">Lahan Jagung Selatan - Selesai</p>
                <p>Oleh: Bpk. Sukardi (18 Mei 2026)</p>
              </div>
            </div>
          </div>
        </div>

        <div class="mt-8 bg-emerald-900/10 border-2 border-emerald-900/20 rounded-lg p-4 text-center">
          <span class="text-xs font-bold text-emerald-900/70 tracking-widest uppercase block mb-1">Status Alat</span>
          <span
            class="inline-block bg-emerald-600 text-white text-xs font-black px-3 py-1 rounded-full uppercase tracking-wider animate-pulse">
            Tersedia / Siap Kerja
          </span>
        </div>
      </div>

    </div>
  </div>
@endsection
