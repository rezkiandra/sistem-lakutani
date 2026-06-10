@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
  <div class="container mx-auto min-h-screen flex flex-col items-center justify-start pt-20 pb-10 px-4">
    
    <div class="w-full max-w-8xl mb-10">

      {{-- Header --}}
      <div class="card bg-base-200 mb-4 overflow-hidden">
        <div class="card-header woodImage p-4 sm:p-5">
          <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="text-left">
              <h1 class="text-2xl sm:text-3xl md:text-2xl font-bold text-slate-100 mb-1">🌾 Dashboard Usaha Tani</h1>
              <span class="text-xs sm:text-sm text-slate-100 block">Selamat datang, {{ Auth::user()->name }} —
                {{ now()->isoFormat('dddd, D MMMM Y') }}</span>
            </div>
            <div class="flex flex-col sm:flex-row gap-2 w-full md:w-auto">
              <a href="{{ route('petani.createProduksi') }}" class="btn btn-sm btnImage w-full sm:w-auto flex items-center justify-center gap-1">
                <i class="ti ti-tractor"></i>
                Input Produksi
              </a>
              <a href="{{ route('petani.catatKeuangan') }}" class="btn btn-sm greenImage w-full sm:w-auto flex items-center justify-center gap-1">
                <i class="ti ti-coin-euro"></i>
                Tambah Transaksi
              </a>
            </div>
          </div>
        </div>
      </div>

      {{-- ===== STAT CARDS ===== --}}
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 mb-4">

        <div class="card bg-base-100 shadow-md">
          <div class="card-body p-4 text-left">
            <div class="flex items-center justify-between mb-2">
              <span class="text-xs text-base-content/50">Total Panen</span>
              <span class="icon-[tabler--wheat] text-warning size-5"></span>
            </div>
            <p class="text-2xl font-bold text-warning">
              {{ number_format($totalPanen, 0, ',', '.') }} kg
            </p>
            <p class="text-xs text-base-content/40 mt-1">Akumulasi semua musim</p>
          </div>
        </div>

        <div class="card bg-base-100 shadow-md">
          <div class="card-body p-4 text-left">
            <div class="flex items-center justify-between mb-2">
              <span class="text-xs text-base-content/50">Total Pendapatan</span>
              <span class="icon-[tabler--cash] text-success size-5"></span>
            </div>
            <p class="text-2xl font-bold text-success">
              Rp {{ number_format($totalPendapatan / 1000000, 1) }}Jt
            </p>
            <p class="text-xs text-base-content/40 mt-1">Dari penjualan hasil tani</p>
          </div>
        </div>

        <div class="card bg-base-100 shadow-md">
          <div class="card-body p-4 text-left">
            <div class="flex items-center justify-between mb-2">
              <span class="text-xs text-base-content/50">Total Pengeluaran</span>
              <span class="icon-[tabler--receipt] text-error size-5"></span>
            </div>
            <p class="text-2xl font-bold text-error">
              Rp {{ number_format($totalPengeluaran / 1000000, 1) }}Jt
            </p>
            <p class="text-xs text-base-content/40 mt-1">Biaya produksi total</p>
          </div>
        </div>

        <div class="card bg-base-100 shadow-md">
          <div class="card-body p-4 text-left">
            <div class="flex items-center justify-between mb-2">
              <span class="text-xs text-base-content/50">Total Laba / Rugi</span>
              <span
                class="icon-[tabler--trending-up] {{ $totalLabaRugi >= 0 ? 'text-success' : 'text-error' }} size-5"></span>
            </div>
            <p class="text-2xl font-bold {{ $totalLabaRugi >= 0 ? 'text-success' : 'text-error' }}">
              {{ $totalLabaRugi >= 0 ? '+' : '' }}Rp {{ number_format($totalLabaRugi / 1000000, 1) }}Jt
            </p>
            <p class="text-xs text-base-content/40 mt-1">
              {{ $totalLabaRugi >= 0 ? 'Keuntungan bersih' : 'Kerugian bersih' }}</p>
          </div>
        </div>

      </div>

      <div class="grid grid-cols-1 gap-4 lg:grid-cols-3">

        {{-- ===== GRAFIK LABA/RUGI PER MUSIM ===== --}}
        <div class="card bg-base-100 shadow-md lg:col-span-2">
          <div class="card-body p-0">
            <div class="flex flex-wrap items-center justify-between gap-2 border-b border-base-content/10 px-4 py-3 text-left">
              <div class="flex items-center gap-2">
                <span class="icon-[tabler--chart-line] text-success size-5"></span>
                <h3 class="font-semibold text-sm sm:text-base">Pendapatan vs Pengeluaran per Musim</h3>
              </div>
              <div class="flex items-center gap-3 text-xs text-base-content/50">
                <div class="flex items-center gap-1">
                  <span class="size-2.5 rounded-sm bg-success inline-block"></span> Pendapatan
                </div>
                <div class="flex items-center gap-1">
                  <span class="size-2.5 rounded-sm bg-error inline-block"></span> Pengeluaran
                </div>
              </div>
            </div>
            <div class="p-4 relative w-full overflow-hidden">
              <canvas id="grafikMusim" height="140"></canvas>
            </div>
          </div>
        </div>

        {{-- ===== KEUANGAN KAS ===== --}}
        <div class="card bg-base-100 shadow-md">
          <div class="card-body p-0 text-left">
            <div class="flex items-center gap-2 border-b border-base-content/10 px-4 py-3">
              <span class="icon-[tabler--wallet] text-info size-5"></span>
              <h3 class="font-semibold">Keuangan Kas</h3>
            </div>
            <div class="p-4 flex flex-col gap-3">
              <div class="rounded-lg bg-base-200/60 p-3 text-xs sm:text-sm flex flex-col gap-2">
                <div class="flex justify-between text-base-content/60 gap-2">
                  <span>Total Pemasukan</span>
                  <span class="font-semibold text-success text-right">
                    Rp {{ number_format($totalPemasukan, 0, ',', '.') }}
                  </span>
                </div>
                <div class="flex justify-between text-base-content/60 gap-2">
                  <span>Total Pengeluaran</span>
                  <span class="font-semibold text-error text-right">
                    Rp {{ number_format($totalPengeluaranKas, 0, ',', '.') }}
                  </span>
                </div>
                <div class="divider my-0.5"></div>
                <div class="flex justify-between font-bold text-sm sm:text-base gap-2">
                  <span>Saldo Akhir</span>
                  <span class="{{ $saldoAkhir >= 0 ? 'text-info' : 'text-error' }} text-right">
                    Rp {{ number_format($saldoAkhir, 0, ',', '.') }}
                  </span>
                </div>
              </div>
              <a href="{{ route('petani.laporanKeuangan') }}" class="btn btn-sm greenImage w-full flex items-center justify-center gap-1">
                <span class="icon-[tabler--report-money] size-4"></span>
                Lihat Laporan Lengkap
              </a>
            </div>
          </div>
        </div>

        {{-- ===== RIWAYAT USAHA TANI ===== --}}
        <div class="card bg-base-100 shadow-md lg:col-span-2">
          <div class="card-body p-0 text-left">
            <div class="flex items-center justify-between border-b border-base-content/10 px-4 py-3">
              <div class="flex items-center gap-2">
                <span class="icon-[tabler--plant-2] text-warning size-5"></span>
                <h3 class="font-semibold">Riwayat Usaha Tani</h3>
              </div>
              <a href="{{ route('petani.laporanKeuangan') }}" class="text-xs text-primary hover:underline">
                Lihat semua →
              </a>
            </div>
            <div class="overflow-x-auto w-full">
              <table class="table table-sm w-full">
                <thead>
                  <tr>
                    <th class="whitespace-nowrap">Musim</th>
                    <th class="text-end whitespace-nowrap">Panen (kg)</th>
                    <th class="text-end whitespace-nowrap">Pendapatan</th>
                    <th class="text-end whitespace-nowrap">Pengeluaran</th>
                    <th class="text-end whitespace-nowrap">Laba / Rugi</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  @forelse ($riwayatProduksi as $item)
                    <tr>
                      <td class="text-sm text-base-content/60 whitespace-nowrap">
                        {{ \Carbon\Carbon::parse($item->created_at)->format('M Y') }}
                      </td>
                      <td class="text-end font-medium text-warning whitespace-nowrap">
                        {{ number_format($item->hasil_panen_padi_kg, 0, ',', '.') }}
                      </td>
                      <td class="text-end font-medium text-success whitespace-nowrap">
                        Rp {{ number_format($item->pendapatan?->total_pendapatan ?? 0, 0, ',', '.') }}
                      </td>
                      <td class="text-end font-medium text-error whitespace-nowrap">
                        Rp {{ number_format($item->pendapatan?->labaRugi?->total_pengeluaran_produksi ?? 0, 0, ',', '.') }}
                      </td>
                      <td class="text-end font-bold whitespace-nowrap">
                        @php $lr = $item->pendapatan?->labaRugi?->total_laba_rugi ?? 0; @endphp
                        <span class="{{ $lr >= 0 ? 'text-success' : 'text-error' }}">
                          {{ $lr >= 0 ? '+' : '' }}Rp {{ number_format($lr, 0, ',', '.') }}
                        </span>
                      </td>
                      <td>
                        <a href="{{ route('petani.hasilAnalisis', $item->id) }}" class="btn btn-xs btn-ghost text-white">
                          <i class="ti ti-eye text-lg"></i>
                        </a>
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="6" class="text-center text-base-content/40 py-6">
                        <i class="ti ti-dots mx-auto block mb-2"></i>
                        Belum ada data.
                        <a href="{{ route('petani.createProduksi') }}" class="text-primary underline">Input sekarang</a>
                      </td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>
        </div>

        {{-- ===== TRANSAKSI KAS TERBARU ===== --}}
        <div class="card bg-base-100 shadow-md">
          <div class="card-body p-0 text-left">
            <div class="flex items-center justify-between border-b border-base-content/10 px-4 py-3">
              <div class="flex items-center gap-2">
                <span class="icon-[tabler--list] text-info size-5"></span>
                <h3 class="font-semibold">Transaksi Terbaru</h3>
              </div>
              <a href="{{ route('petani.catatKeuangan') }}" class="text-xs text-primary hover:underline">
                Lihat semua →
              </a>
            </div>
            <div class="p-4 flex flex-col gap-2">
              @forelse ($transaksiTerbaru as $trx)
                <div class="flex items-center justify-between py-1.5 border-b border-base-content/5 last:border-0 gap-2">
                  <div class="flex items-center gap-2 min-w-0">
                    <span class="size-7 rounded-full flex items-center justify-center shrink-0 {{ $trx->jenis === 'pemasukan' ? 'bg-success/20' : 'bg-error/20' }}">
                      <span class="size-3.5 {{ $trx->jenis === 'pemasukan' ? 'icon-[tabler--arrow-down] text-success' : 'icon-[tabler--arrow-up] text-error' }}"></span>
                    </span>
                    <div class="truncate">
                      <p class="text-sm font-medium leading-tight truncate">{{ $trx->kategori }}</p>
                      <p class="text-xs text-base-content/40">
                        {{ \Carbon\Carbon::parse($trx->tanggal)->format('d M Y') }}
                      </p>
                    </div>
                  </div>
                  <span class="font-semibold text-sm shrink-0 {{ $trx->jenis === 'pemasukan' ? 'text-success' : 'text-error' }}">
                    {{ $trx->jenis === 'pemasukan' ? '+' : '-' }}Rp {{ number_format($trx->jumlah, 0, ',', '.') }}
                  </span>
                </div>
              @empty
                <p class="text-sm text-base-content/40 text-center py-4">Belum ada transaksi.</p>
              @endforelse
            </div>
          </div>
        </div>

      </div>{{-- end grid --}}
    </div>
  </div>
@endsection

@push('js')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
  <script>
    new Chart(document.getElementById('grafikMusim').getContext('2d'), {
      type: 'bar',
      data: {
        labels: @json($labelMusim),
        datasets: [{
            label: 'Pendapatan',
            data: @json($dataGrafikPendapatan),
            backgroundColor: 'rgba(34,197,94,0.7)',
            borderRadius: 4,
          },
          {
            label: 'Pengeluaran',
            data: @json($dataGrafikPengeluaran),
            backgroundColor: 'rgba(239,68,68,0.7)',
            borderRadius: 4,
          }
        ]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false, // Ditambahkan agar tinggi grafik fleksibel mengikuti pembungkus CSS
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