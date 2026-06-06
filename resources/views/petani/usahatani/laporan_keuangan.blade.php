@extends('layouts.app')

@section('title', 'Laporan Keuangan Pertanian')

@section('content')
  <div class="container mx-auto min-h-screen flex flex-col items-center justify-start">
    <div class="w-3/4 mt-20 mb-10">

      <div class="card bg-base-200">
        <div class="card-header woodImage p-5">
          <div class="flex items-center justify-between">
            <div>
              <h1 class="text-3xl font-bold text-slate-100 mb-1">📊 Laporan Keuangan Pertanian</h1>
              <span class="text-sm text-slate-100">Ringkasan pemasukan, pengeluaran, dan saldo akhir</span>
            </div>
            <a href="{{ route('petani.catatKeuangan') }}" class="btn btn-sm btn-ghost text-slate-100">
              <i class="ti ti-arrow-left text-lg"></i>
              Kembali
            </a>
          </div>
        </div>

        <div class="card-body">
          <div class="grid grid-cols-1 gap-3 lg:grid-cols-2">

            {{-- ===== RINGKASAN ===== --}}
            <div class="card bg-base-100 shadow-md">
              <div class="card-body p-0">
                <div class="flex items-center gap-2 border-b border-base-content/10 px-4 py-3">
                  <span class="icon-[tabler--report-money] text-primary size-5"></span>
                  <h3 class="font-semibold">Ringkasan Keuangan</h3>
                </div>
                <div class="p-4">
                  <div class="rounded-lg bg-base-200/60 p-4 text-sm flex flex-col gap-3">

                    <div class="flex items-center justify-between">
                      <div class="flex items-center gap-2">
                        <span class="icon-[tabler--arrow-down-circle] text-success size-5"></span>
                        <span class="text-base-content/60">Total Pemasukan</span>
                      </div>
                      <span class="font-bold text-success text-base">
                        Rp {{ number_format($totalPemasukan, 0, ',', '.') }}
                      </span>
                    </div>

                    <div class="flex items-center justify-between">
                      <div class="flex items-center gap-2">
                        <span class="icon-[tabler--arrow-up-circle] text-error size-5"></span>
                        <span class="text-base-content/60">Total Pengeluaran</span>
                      </div>
                      <span class="font-bold text-error text-base">
                        Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}
                      </span>
                    </div>

                    <div class="divider my-0.5"></div>

                    <div class="flex items-center justify-between">
                      <div class="flex items-center gap-2">
                        <span
                          class="icon-[tabler--wallet] {{ $saldoAkhir >= 0 ? 'text-info' : 'text-error' }} size-5"></span>
                        <span class="font-semibold">Saldo Akhir</span>
                      </div>
                      <span class="font-bold text-lg {{ $saldoAkhir >= 0 ? 'text-info' : 'text-error' }}">
                        Rp {{ number_format($saldoAkhir, 0, ',', '.') }}
                      </span>
                    </div>

                  </div>

                  {{-- Unduh Laporan --}}
                  <div class="mt-4">
                    <a href="{{ route('keuangan.export') }}" class="btn w-full greenImage">
                      <span class="icon-[tabler--download] size-4"></span>
                      Unduh Laporan
                    </a>
                  </div>
                </div>
              </div>
            </div>

            {{-- ===== GRAFIK ===== --}}
            <div class="card bg-base-100 shadow-md">
              <div class="card-body p-0">
                <div class="flex items-center gap-2 border-b border-base-content/10 px-4 py-3">
                  <span class="icon-[tabler--chart-bar] text-warning size-5"></span>
                  <h3 class="font-semibold">Grafik Keuangan</h3>
                </div>
                <div class="p-4">
                  <canvas id="grafikKeuangan" height="200"></canvas>
                  <div class="flex items-center justify-center gap-4 mt-3 text-xs text-base-content/60">
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
            </div>

            {{-- ===== BREAKDOWN PER KATEGORI ===== --}}
            <div class="card bg-base-100 shadow-md lg:col-span-2">
              <div class="card-body p-0">
                <div class="flex items-center gap-2 border-b border-base-content/10 px-4 py-3">
                  <span class="icon-[tabler--list-details] text-secondary size-5"></span>
                  <h3 class="font-semibold">Breakdown per Kategori</h3>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 divide-y sm:divide-y-0 sm:divide-x divide-base-content/10">

                  {{-- Pemasukan per kategori --}}
                  <div class="p-4">
                    <p class="text-xs font-semibold text-base-content/50 uppercase tracking-wide mb-3">
                      Pemasukan
                    </p>
                    @forelse ($pemasukanPerKategori as $kat)
                      <div class="flex justify-between text-sm py-1.5 border-b border-base-content/5 last:border-0">
                        <span class="text-base-content/70">{{ $kat->kategori }}</span>
                        <span class="font-medium text-success">Rp {{ number_format($kat->total, 0, ',', '.') }}</span>
                      </div>
                    @empty
                      <p class="text-sm text-base-content/40">Belum ada data pemasukan.</p>
                    @endforelse
                  </div>

                  {{-- Pengeluaran per kategori --}}
                  <div class="p-4">
                    <p class="text-xs font-semibold text-base-content/50 uppercase tracking-wide mb-3">
                      Pengeluaran
                    </p>
                    @forelse ($pengeluaranPerKategori as $kat)
                      <div class="flex justify-between text-sm py-1.5 border-b border-base-content/5 last:border-0">
                        <span class="text-base-content/70">{{ $kat->kategori }}</span>
                        <span class="font-medium text-error">Rp {{ number_format($kat->total, 0, ',', '.') }}</span>
                      </div>
                    @empty
                      <p class="text-sm text-base-content/40">Belum ada data pengeluaran.</p>
                    @endforelse
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
            backgroundColor: 'rgba(34,197,94,0.7)',
            borderRadius: 4,
          },
          {
            label: 'Pengeluaran',
            data: keluar,
            backgroundColor: 'rgba(239,68,68,0.7)',
            borderRadius: 4,
          }
        ]
      },
      options: {
        responsive: true,
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
