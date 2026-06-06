@extends('layouts.app')

@section('title', 'Analisis Kelayakan Usaha Tani')

@section('content')
  <div class="container mx-auto min-h-screen flex flex-col items-center justify-start">
    <div class="w-3/4 mt-20 mb-10">

      {{-- Header --}}
      <div class="card bg-base-200 mb-4">
        <div class="card-header woodImage p-5">
          <div class="flex items-center justify-between">
            <div>
              <h1 class="text-3xl font-bold text-slate-100 mb-1">📈 Analisis Kelayakan Usaha Tani</h1>
              <span class="text-sm text-slate-100">ROI · R/C Ratio · BEP Harga · BEP Volume</span>
            </div>
            <a href="{{ url()->previous() }}" class="btn btn-sm btn-ghost text-slate-100">
              <span class="icon-[tabler--arrow-left] size-4"></span>
              Kembali
            </a>
          </div>
        </div>

        {{-- Kesimpulan Kelayakan --}}
        @php
          $totalPendapatan = $pendapatan->total_pendapatan;
          $totalPengeluaran = $labaRugi->total_pengeluaran_produksi;
          $keuntungan = $labaRugi->total_laba_rugi;
          $volProduksi = $produksi->padi_terjual_kg;
          $hargaJual = $pendapatan->harga_padi_per_kg;

          $roi = $totalPengeluaran > 0 ? ($keuntungan / $totalPengeluaran) * 100 : 0;
          $rcRatio = $totalPengeluaran > 0 ? $totalPendapatan / $totalPengeluaran : 0;
          $bepHarga = $volProduksi > 0 ? $totalPengeluaran / $volProduksi : 0;
          $bepVol = $hargaJual > 0 ? $totalPengeluaran / $hargaJual : 0;

          $layak = $rcRatio >= 1;

          if ($roi >= 50) {
              $roiLabel = 'Sangat Menguntungkan';
              $roiColor = 'success';
          } elseif ($roi >= 20) {
              $roiLabel = 'Layak';
              $roiColor = 'info';
          } elseif ($roi >= 0) {
              $roiLabel = 'Tipis';
              $roiColor = 'warning';
          } else {
              $roiLabel = 'Merugi';
              $roiColor = 'error';
          }
        @endphp

        <div class="px-5 pb-5 pt-2">
          <div
            class="rounded-xl p-4 flex items-center justify-between
            {{ $layak ? 'bg-success/10 border border-success/30' : 'bg-error/10 border border-error/30' }}">
            <div class="flex items-center gap-3">
              <span
                class="{{ $layak ? 'ti ti-check text-success' : 'ti ti-close text-error' }} text-3xl"></span>
              <div>
                <p class="text-sm font-medium {{ $layak ? 'text-success' : 'text-error' }}">
                  Usaha tani ini {{ $layak ? 'Layak' : 'Tidak Layak' }} dijalankan
                </p>
                <p class="text-xs text-base-content/50">
                  Berdasarkan R/C Ratio {{ $layak ? '≥ 1 (menguntungkan)' : '< 1 (tidak menguntungkan)' }}
                </p>
              </div>
            </div>
            <div class="text-end">
              <p class="text-2xl font-bold {{ $layak ? 'text-success' : 'text-error' }}">
                {{ number_format($rcRatio, 2) }}
              </p>
              <p class="text-xs text-base-content/50">R/C Ratio</p>
            </div>
          </div>
        </div>
      </div>

      {{-- ===== 4 METRIK UTAMA ===== --}}
      <div class="grid grid-cols-2 gap-3 lg:grid-cols-4 mb-4">

        {{-- ROI --}}
        <div class="card bg-base-100 shadow-md">
          <div class="card-body p-4">
            <div class="flex items-center gap-2 mb-2">
              <span class="ti ti-percentage text-{{ $roiColor }} text-3xl"></span>
              <span class="text-xs text-base-content/50">ROI</span>
            </div>
            <p class="text-2xl font-bold text-{{ $roiColor }}">{{ number_format($roi, 1) }}%</p>
            <span class="badge badge-soft badge-{{ $roiColor }} text-xs mt-1">{{ $roiLabel }}</span>
            <p class="text-xs text-base-content/40 mt-2">Return on Investment</p>
          </div>
        </div>

        {{-- R/C Ratio --}}
        <div class="card bg-base-100 shadow-md">
          <div class="card-body p-4">
            <div class="flex items-center gap-2 mb-2">
              <span class="ti ti-scale text-info text-3xl"></span>
              <span class="text-xs text-base-content/50">R/C Ratio</span>
            </div>
            <p class="text-2xl font-bold text-info">{{ number_format($rcRatio, 2) }}</p>
            <span class="badge badge-soft {{ $rcRatio >= 1 ? 'badge-success' : 'badge-error' }} text-xs mt-1">
              {{ $rcRatio >= 1 ? 'Layak (≥ 1)' : 'Tidak Layak (< 1)' }}
            </span>
            <p class="text-xs text-base-content/40 mt-2">Revenue / Cost Ratio</p>
          </div>
        </div>

        {{-- BEP Harga --}}
        <div class="card bg-base-100 shadow-md">
          <div class="card-body p-4">
            <div class="flex items-center gap-2 mb-2">
              <span class="ti ti-currency-dollar text-warning text-3xl"></span>
              <span class="text-xs text-base-content/50">BEP Harga</span>
            </div>
            <p class="text-2xl font-bold text-warning">
              Rp {{ number_format($bepHarga, 0, ',', '.') }}
            </p>
            <span class="badge badge-soft {{ $hargaJual >= $bepHarga ? 'badge-success' : 'badge-error' }} text-xs mt-1">
              {{ $hargaJual >= $bepHarga ? 'Harga jual aman' : 'Harga jual di bawah BEP' }}
            </span>
            <p class="text-xs text-base-content/40 mt-2">Harga minimum per kg</p>
          </div>
        </div>

        {{-- BEP Volume --}}
        <div class="card bg-base-100 shadow-md">
          <div class="card-body p-4">
            <div class="flex items-center gap-2 mb-2">
              <span class="ti ti-package text-secondary text-3xl"></span>
              <span class="text-xs text-base-content/50">BEP Volume</span>
            </div>
            <p class="text-2xl font-bold text-secondary">
              {{ number_format($bepVol, 0, ',', '.') }} kg
            </p>
            <span class="badge badge-soft {{ $volProduksi >= $bepVol ? 'badge-success' : 'badge-error' }} text-xs mt-1">
              {{ $volProduksi >= $bepVol ? 'Volume terjual aman' : 'Volume di bawah BEP' }}
            </span>
            <p class="text-xs text-base-content/40 mt-2">Volume minimum terjual</p>
          </div>
        </div>

      </div>

      <div class="grid grid-cols-1 gap-3 lg:grid-cols-2">

        {{-- ===== DETAIL PERHITUNGAN ===== --}}
        <div class="card bg-base-100 shadow-md">
          <div class="card-body p-0">
            <div class="flex items-center gap-2 border-b border-base-content/10 px-4 py-3">
              <span class="ti ti-calculator text-primary text-3xl"></span>
              <h3 class="font-semibold">Detail Perhitungan</h3>
            </div>
            <div class="p-4 flex flex-col gap-4">

              {{-- ROI --}}
              <div>
                <div class="flex items-center gap-2 mb-2">
                  <span class="badge badge-soft badge-{{ $roiColor }} text-xs">ROI</span>
                  <span class="text-sm font-semibold">Return on Investment</span>
                </div>
                <div class="rounded-lg bg-base-200/60 p-3 text-sm flex flex-col gap-1">
                  <div class="flex justify-between text-base-content/60">
                    <span>Keuntungan (Laba)</span>
                    <span class="{{ $keuntungan >= 0 ? 'text-success' : 'text-error' }} font-medium">
                      Rp {{ number_format($keuntungan, 0, ',', '.') }}
                    </span>
                  </div>
                  <div class="flex justify-between text-base-content/60">
                    <span>Total Biaya</span>
                    <span class="font-medium">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</span>
                  </div>
                  <div class="divider my-0.5"></div>
                  <div class="flex justify-between font-semibold">
                    <span>ROI = (Laba / Biaya) × 100%</span>
                    <span class="text-{{ $roiColor }}">{{ number_format($roi, 1) }}%</span>
                  </div>
                </div>
              </div>

              {{-- R/C Ratio --}}
              <div>
                <div class="flex items-center gap-2 mb-2">
                  <span class="badge badge-soft badge-info text-xs">R/C</span>
                  <span class="text-sm font-semibold">Revenue / Cost Ratio</span>
                </div>
                <div class="rounded-lg bg-base-200/60 p-3 text-sm flex flex-col gap-1">
                  <div class="flex justify-between text-base-content/60">
                    <span>Total Pendapatan</span>
                    <span class="text-success font-medium">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</span>
                  </div>
                  <div class="flex justify-between text-base-content/60">
                    <span>Total Biaya</span>
                    <span class="font-medium">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</span>
                  </div>
                  <div class="divider my-0.5"></div>
                  <div class="flex justify-between font-semibold">
                    <span>R/C = Pendapatan / Biaya</span>
                    <span class="{{ $rcRatio >= 1 ? 'text-success' : 'text-error' }}">
                      {{ number_format($rcRatio, 2) }}
                    </span>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>

        {{-- ===== DETAIL BEP ===== --}}
        <div class="card bg-base-100 shadow-md">
          <div class="card-body p-0">
            <div class="flex items-center gap-2 border-b border-base-content/10 px-4 py-3">
              <span class="ti ti-currency-dollar text-warning text-3xl"></span>
              <h3 class="font-semibold">Break Even Point (BEP)</h3>
            </div>
            <div class="p-4 flex flex-col gap-4">

              {{-- BEP Harga --}}
              <div>
                <div class="flex items-center gap-2 mb-2">
                  <span class="badge badge-soft badge-warning text-xs">BEP Harga</span>
                  <span class="text-sm font-semibold">Harga Jual Minimum</span>
                </div>
                <div class="rounded-lg bg-base-200/60 p-3 text-sm flex flex-col gap-1">
                  <div class="flex justify-between text-base-content/60">
                    <span>Total Biaya</span>
                    <span class="font-medium">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</span>
                  </div>
                  <div class="flex justify-between text-base-content/60">
                    <span>Volume Terjual</span>
                    <span class="font-medium">{{ number_format($volProduksi, 0, ',', '.') }} kg</span>
                  </div>
                  <div class="divider my-0.5"></div>
                  <div class="flex justify-between font-semibold">
                    <span>BEP = Biaya / Volume</span>
                    <span class="text-warning">Rp {{ number_format($bepHarga, 0, ',', '.') }} / kg</span>
                  </div>
                  <div
                    class="mt-2 flex justify-between text-xs {{ $hargaJual >= $bepHarga ? 'text-success' : 'text-error' }}">
                    <span>Harga jual aktual</span>
                    <span class="font-semibold">
                      Rp {{ number_format($hargaJual, 0, ',', '.') }} / kg
                      ({{ $hargaJual >= $bepHarga ? '▲ di atas BEP ✅' : '▼ di bawah BEP ❌' }})
                    </span>
                  </div>
                </div>
              </div>

              {{-- BEP Volume --}}
              <div>
                <div class="flex items-center gap-2 mb-2">
                  <span class="badge badge-soft badge-secondary text-xs">BEP Volume</span>
                  <span class="text-sm font-semibold">Volume Penjualan Minimum</span>
                </div>
                <div class="rounded-lg bg-base-200/60 p-3 text-sm flex flex-col gap-1">
                  <div class="flex justify-between text-base-content/60">
                    <span>Total Biaya</span>
                    <span class="font-medium">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</span>
                  </div>
                  <div class="flex justify-between text-base-content/60">
                    <span>Harga Jual per kg</span>
                    <span class="font-medium">Rp {{ number_format($hargaJual, 0, ',', '.') }}</span>
                  </div>
                  <div class="divider my-0.5"></div>
                  <div class="flex justify-between font-semibold">
                    <span>BEP = Biaya / Harga Jual</span>
                    <span class="text-secondary">{{ number_format($bepVol, 0, ',', '.') }} kg</span>
                  </div>
                  <div
                    class="mt-2 flex justify-between text-xs {{ $volProduksi >= $bepVol ? 'text-success' : 'text-error' }}">
                    <span>Volume terjual aktual</span>
                    <span class="font-semibold">
                      {{ number_format($volProduksi, 0, ',', '.') }} kg
                      ({{ $volProduksi >= $bepVol ? '▲ di atas BEP ✅' : '▼ di bawah BEP ❌' }})
                    </span>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>

        {{-- ===== TABEL ACUAN INTERPRETASI ===== --}}
        <div class="card bg-base-100 shadow-md lg:col-span-2">
          <div class="card-body p-0">
            <div class="flex items-center gap-2 border-b border-base-content/10 px-4 py-3">
              <span class="ti ti-help text-info text-3xl"></span>
              <h3 class="font-semibold">Panduan Interpretasi</h3>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-3 divide-y sm:divide-y-0 sm:divide-x divide-base-content/10">

              {{-- ROI --}}
              <div class="p-4">
                <p class="text-xs font-semibold text-base-content/50 uppercase tracking-wide mb-3">ROI</p>
                <div class="flex flex-col gap-2 text-sm">
                  <div class="flex items-center gap-2">
                    <span class="badge badge-soft badge-success text-xs w-24 justify-center">&gt; 50%</span>
                    <span class="text-base-content/70">Sangat menguntungkan</span>
                  </div>
                  <div class="flex items-center gap-2">
                    <span class="badge badge-soft badge-info text-xs w-24 justify-center">20% – 50%</span>
                    <span class="text-base-content/70">Layak dijalankan</span>
                  </div>
                  <div class="flex items-center gap-2">
                    <span class="badge badge-soft badge-warning text-xs w-24 justify-center">0% – 20%</span>
                    <span class="text-base-content/70">Tipis, perlu evaluasi</span>
                  </div>
                  <div class="flex items-center gap-2">
                    <span class="badge badge-soft badge-error text-xs w-24 justify-center">&lt; 0%</span>
                    <span class="text-base-content/70">Merugi</span>
                  </div>
                  <div class="mt-2 rounded-lg bg-base-200/60 p-2 flex justify-between font-semibold text-sm">
                    <span>Hasil kamu</span>
                    <span class="text-{{ $roiColor }}">{{ number_format($roi, 1) }}% — {{ $roiLabel }}</span>
                  </div>
                </div>
              </div>

              {{-- R/C Ratio --}}
              <div class="p-4">
                <p class="text-xs font-semibold text-base-content/50 uppercase tracking-wide mb-3">R/C Ratio</p>
                <div class="flex flex-col gap-2 text-sm">
                  <div class="flex items-center gap-2">
                    <span class="badge badge-soft badge-success text-xs w-24 justify-center">&gt; 1</span>
                    <span class="text-base-content/70">Layak, menguntungkan</span>
                  </div>
                  <div class="flex items-center gap-2">
                    <span class="badge badge-soft badge-warning text-xs w-24 justify-center">= 1</span>
                    <span class="text-base-content/70">Impas (Break Even)</span>
                  </div>
                  <div class="flex items-center gap-2">
                    <span class="badge badge-soft badge-error text-xs w-24 justify-center">&lt; 1</span>
                    <span class="text-base-content/70">Tidak layak, merugi</span>
                  </div>
                  <div class="mt-2 rounded-lg bg-base-200/60 p-2 flex justify-between font-semibold text-sm">
                    <span>Hasil kamu</span>
                    <span class="{{ $rcRatio >= 1 ? 'text-success' : 'text-error' }}">
                      {{ number_format($rcRatio, 2) }} — {{ $rcRatio >= 1 ? 'Layak ✅' : 'Tidak Layak ❌' }}
                    </span>
                  </div>
                </div>
              </div>

              {{-- BEP --}}
              <div class="p-4">
                <p class="text-xs font-semibold text-base-content/50 uppercase tracking-wide mb-3">BEP</p>
                <div class="flex flex-col gap-2 text-sm">
                  <div class="flex items-center gap-2">
                    <span class="badge badge-soft badge-success text-xs w-28 justify-center">Harga &gt; BEP</span>
                    <span class="text-base-content/70">Harga jual aman</span>
                  </div>
                  <div class="flex items-center gap-2">
                    <span class="badge badge-soft badge-error text-xs w-28 justify-center">Harga &lt; BEP</span>
                    <span class="text-base-content/70">Jual di bawah modal</span>
                  </div>
                  <div class="flex items-center gap-2">
                    <span class="badge badge-soft badge-success text-xs w-28 justify-center">Vol &gt; BEP</span>
                    <span class="text-base-content/70">Produksi mencukupi</span>
                  </div>
                  <div class="flex items-center gap-2">
                    <span class="badge badge-soft badge-error text-xs w-28 justify-center">Vol &lt; BEP</span>
                    <span class="text-base-content/70">Produksi kurang</span>
                  </div>
                  <div class="mt-2 rounded-lg bg-base-200/60 p-2 flex flex-col gap-1 text-xs font-semibold">
                    <div class="flex justify-between">
                      <span>BEP Harga</span>
                      <span class="{{ $hargaJual >= $bepHarga ? 'text-success' : 'text-error' }}">
                        Rp {{ number_format($bepHarga, 0, ',', '.') }} {{ $hargaJual >= $bepHarga ? '✅' : '❌' }}
                      </span>
                    </div>
                    <div class="flex justify-between">
                      <span>BEP Volume</span>
                      <span class="{{ $volProduksi >= $bepVol ? 'text-success' : 'text-error' }}">
                        {{ number_format($bepVol, 0, ',', '.') }} kg {{ $volProduksi >= $bepVol ? '✅' : '❌' }}
                      </span>
                    </div>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>

      </div>{{-- end grid --}}

      {{-- Tombol Aksi --}}
      <div class="flex items-center justify-between mt-4 gap-2">
        <a href="{{ url()->previous() }}" class="btn w-1/2">
          <span class="icon-[tabler--arrow-left] size-4"></span>
          Kembali
        </a>
        <button onclick="window.print()" class="btn w-1/2 greenImage">
          <span class="icon-[tabler--printer] size-4"></span>
          Cetak / Export
        </button>
      </div>

    </div>
  </div>
@endsection
