@extends('layouts.app')

@section('title', 'Laporan Keuangan Pertanian')

@section('content')
  {{-- Mengganti flex items-center kaku dengan padding container standar --}}
  <div class="w-full min-h-screen bg-base-200/30 px-3 sm:px-6 py-24 lg:py-8">
    {{-- Mengubah w-3/4 menjadi max-w-7xl mx-auto agar responsif penuh --}}
    <div class="w-full max-w-7xl mx-auto">

      <div class="card bg-base-100 shadow-sm border border-base-content/5 overflow-hidden">

        {{-- ===== HEADER ===== --}}
        <div class="card-header woodImage p-4 sm:p-5">
          {{-- md:flex-row & md:items-center mengamankan posisi judul dan tombol di tablet portrait --}}
          <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
              <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-slate-100 mb-1 flex items-center gap-2">
                <span>📊</span> Laporan Keuangan Pertanian
              </h1>
              <span class="text-xs md:text-sm text-slate-200/90 block">Ringkasan pemasukan, pengeluaran, dan saldo
                akhir</span>
            </div>
            <div class="w-full md:w-auto flex justify-start md:justify-end">
              <a href="{{ route('petani.catatKeuangan') }}"
                class="btn btn-sm btn-ghost text-slate-100 w-full md:w-auto justify-center">
                <i class="ti ti-arrow-left text-lg"></i>
                Kembali
              </a>
            </div>
          </div>
        </div>

        {{-- ===== BODY ===== --}}
        <div class="card-body p-3 sm:p-5 md:p-6">
          <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 md:gap-6">

            {{-- ===== RINGKASAN ===== --}}
            <div class="card bg-base-200/40 border border-base-content/5 shadow-sm">
              <div class="card-body p-0">
                <div class="flex items-center gap-2 border-b border-base-content/10 px-4 py-3 bg-base-100">
                  <span class="icon-[tabler--report-money] text-primary size-5"></span>
                  <h3 class="font-semibold text-sm md:text-base">Ringkasan Keuangan</h3>
                </div>
                <div class="p-4 flex flex-col justify-between h-full gap-4">
                  <div
                    class="rounded-xl bg-base-100 p-4 text-sm flex flex-col gap-3 border border-base-content/5 shadow-inner">

                    <div class="flex items-center justify-between gap-2">
                      <div class="flex items-center gap-2">
                        <span class="icon-[tabler--arrow-down-circle] text-success size-5 shrink-0"></span>
                        <span class="text-base-content/60 text-xs sm:text-sm">Total Pemasukan</span>
                      </div>
                      <span class="font-bold text-success text-sm sm:text-base whitespace-nowrap">
                        Rp {{ number_format($totalPemasukan, 0, ',', '.') }}
                      </span>
                    </div>

                    <div class="flex items-center justify-between gap-2">
                      <div class="flex items-center gap-2">
                        <span class="icon-[tabler--arrow-up-circle] text-error size-5 shrink-0"></span>
                        <span class="text-base-content/60 text-xs sm:text-sm">Total Pengeluaran</span>
                      </div>
                      <span class="font-bold text-error text-sm sm:text-base whitespace-nowrap">
                        Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}
                      </span>
                    </div>

                    <div class="divider my-0.5"></div>

                    <div class="flex items-center justify-between gap-2">
                      <div class="flex items-center gap-2">
                        <span
                          class="icon-[tabler--wallet] {{ $saldoAkhir >= 0 ? 'text-info' : 'text-error' }} size-5 shrink-0"></span>
                        <span class="font-semibold text-xs sm:text-sm">Saldo Akhir</span>
                      </div>
                      <span
                        class="font-bold text-base sm:text-lg {{ $saldoAkhir >= 0 ? 'text-info' : 'text-error' }} whitespace-nowrap">
                        Rp {{ number_format($saldoAkhir, 0, ',', '.') }}
                      </span>
                    </div>

                  </div>

                  {{-- Unduh Laporan --}}
                  <div>
                    <a href="{{ route('petani.exportKeuangan') }}"
                      class="btn btn-md w-full greenImage text-stone-200 border-none">
                      <span class="icon-[tabler--download] size-4"></span>
                      Unduh Laporan (Excel)
                    </a>
                  </div>
                </div>
              </div>
            </div>

            {{-- ===== GRAFIK ===== --}}
            <div class="card bg-base-100 border border-base-content/5 shadow-sm">
              <div class="card-body p-0">
                <div class="flex items-center gap-2 border-b border-base-content/10 px-4 py-3">
                  <span class="icon-[tabler--chart-bar] text-warning size-5"></span>
                  <h3 class="font-semibold text-sm md:text-base">Grafik Keuangan</h3>
                </div>
                {{-- Penjagaan khusus aspek rasio kanvas grafik di mobile/tablet --}}
                <div class="p-4 relative w-full h-[240px] sm:h-[260px] lg:h-full lg:min-h-[220px]">
                  <canvas id="grafikKeuangan"></canvas>
                </div>
                <div class="flex items-center justify-center gap-4 pb-4 pt-1 text-xs text-base-content/60">
                  <div class="flex items-center gap-1">
                    <span class="size-3 rounded-sm bg-success inline-block"></span>
                    Pemasukan
                  </div>
                  <div class="flex items-center gap-1">
                    <span class="size-3 rounded-sm bg-error inline-block"></span>
                    Pengeluaran
                  </div>
                </div>
              </div>
            </div>

            {{-- ===== BREAKDOWN PER KATEGORI ===== --}}
            <div class="card bg-base-100 border border-base-content/5 shadow-sm lg:col-span-2">
              <div class="card-body p-0">
                <div class="flex items-center gap-2 border-b border-base-content/10 px-4 py-3">
                  <span class="icon-[tabler--list-details] text-secondary size-5"></span>
                  <h3 class="font-semibold text-sm md:text-base">Breakdown per Kategori</h3>
                </div>
                {{-- Mengubah grid pembagian kelompok: tumpuk di HP (grid-cols-1), sejajar di Tablet (sm:grid-cols-2) --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 divide-y sm:divide-y-0 sm:divide-x divide-base-content/10">

                  {{-- Pemasukan per kategori --}}
                  <div class="p-4 sm:p-5">
                    <p
                      class="text-xs font-bold text-success uppercase tracking-wider mb-3 bg-success/10 px-2 py-1 rounded inline-block">
                      📥 Pemasukan
                    </p>
                    <div class="space-y-1">
                      @forelse ($pemasukanPerKategori as $kat)
                        <div
                          class="flex justify-between items-center text-sm py-2 border-b border-base-content/5 last:border-0 gap-2">
                          <span class="text-base-content/70 truncate"
                            title="{{ $kat->kategori }}">{{ $kat->kategori }}</span>
                          <span class="font-semibold text-success whitespace-nowrap">Rp
                            {{ number_format($kat->total, 0, ',', '.') }}</span>
                        </div>
                      @empty
                        <p class="text-sm text-base-content/40 py-2 italic">Belum ada data pemasukan.</p>
                      @endforelse
                    </div>
                  </div>

                  {{-- Pengeluaran per kategori --}}
                  <div class="p-4 sm:p-5">
                    <p
                      class="text-xs font-bold text-error uppercase tracking-wider mb-3 bg-error/10 px-2 py-1 rounded inline-block">
                      📤 Pengeluaran
                    </p>
                    <div class="space-y-1">
                      @forelse ($pengeluaranPerKategori as $kat)
                        <div
                          class="flex justify-between items-center text-sm py-2 border-b border-base-content/5 last:border-0 gap-2">
                          <span class="text-base-content/70 truncate"
                            title="{{ $kat->kategori }}">{{ $kat->kategori }}</span>
                          <span class="font-semibold text-error whitespace-nowrap">Rp
                            {{ number_format($kat->total, 0, ',', '.') }}</span>
                        </div>
                      @empty
                        <p class="text-sm text-base-content/40 py-2 italic">Belum ada data pengeluaran.</p>
                      @endforelse
                    </div>
                  </div>

                </div>
              </div>
            </div>

          </div>{{-- end grid --}}
        </div>
      </div>
    </div>
  </div>
@endsection

@push('js')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
  <script>
    const ctx = document.getElementById('grafikKeuangan').getContext('2d');

    const labels = @json($labelBulan);
    const masuk = @json($dataPemasukan);
    const keluar = @json($dataPengeluaran);

    new Chart(ctx, {
      type: 'bar',
      data: {
        labels,
        datasets: [{
            label: 'Pemasukan',
            data: masuk,
            backgroundColor: 'rgba(34,197,94,0.8)',
            borderRadius: 4,
          },
          {
            label: 'Pengeluaran',
            data: keluar,
            backgroundColor: 'rgba(239,68,68,0.8)',
            borderRadius: 4,
          }
        ]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false, // KRUSIAL: Membiarkan grafik mengikuti tinggi kontainer responsif CSS
        plugins: {
          legend: {
            display: false
          }
        },
        scales: {
          y: {
            ticks: {
              callback: val => 'Rp ' + new Intl.NumberFormat('id-ID').format(val)
            }
          }
        }
      }
    });
  </script>
@endpush
