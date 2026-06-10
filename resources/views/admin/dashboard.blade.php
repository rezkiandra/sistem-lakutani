@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
  <div class="container mx-auto min-h-screen flex flex-col items-center justify-start px-4">
    {{-- Mengubah w-3/4 menjadi w-full max-w-6xl agar luas di desktop tapi fleksibel di HP --}}
    <div class="w-full max-w-7xl mt-6 lg:mt-20 mt-20 mb-10">

      {{-- ===== HEADER ===== --}}
      <div class="card bg-base-200 mb-4 shadow-sm rounded-xl overflow-hidden">
        <div class="card-header woodImage p-4 md:p-5">
          {{-- Flex berubah ke kolom pada mobile, row pada desktop --}}
          <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
              <h1 class="text-2xl md:text-3xl font-bold text-slate-100 mb-1">🏡 Dashboard Administrator</h1>
              <span class="text-xs md:text-sm text-slate-100 block">
                Selamat datang, {{ Auth::user()->name }} — {{ now()->isoFormat('dddd, D MMMM YYYY') }}
              </span>
            </div>
            <div class="flex gap-2 w-full sm:w-auto">
              <a href="{{ route('admin.laporan-keuangan') }}" class="btn btn-sm greenImage w-full sm:w-auto justify-center">
                <i class="ti ti-coin-euro"></i>
                Laporan Keuangan
              </a>
            </div>
          </div>
        </div>
      </div>

      {{-- ===== KARTU STATISTIK (STAT CARDS) ===== --}}
      {{-- HP = 1 Kolom, Tablet = 2 Kolom, Desktop = 4 Kolom --}}
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 mb-6">

        {{-- Total Pengguna --}}
        <div class="card bg-base-100 shadow-md border border-base-content/5 rounded-xl">
          <div class="card-body p-4">
            <div class="flex items-center justify-between mb-2">
              <span class="text-xs text-base-content/50">Total Pengguna</span>
              <span class="icon-[tabler--users] text-primary size-5"></span>
            </div>
            <p class="text-2xl font-bold text-primary">{{ number_format($totalPengguna) }}</p>
            <p class="text-xs text-base-content/40 mt-1">
              <span class="text-success">+{{ $penggunaBaru }}</span> bulan ini
            </p>
          </div>
        </div>

        {{-- Total Produksi --}}
        <div class="card bg-base-100 shadow-md border border-base-content/5 rounded-xl">
          <div class="card-body p-4">
            <div class="flex items-center justify-between mb-2">
              <span class="text-xs text-base-content/50">Total Produksi</span>
              <span class="icon-[tabler--wheat] text-warning size-5"></span>
            </div>
            <p class="text-2xl font-bold text-warning">{{ number_format($totalProduksi) }}</p>
            <p class="text-xs text-base-content/40 mt-1">Data usaha tani tercatat</p>
          </div>
        </div>

        {{-- Total Pendapatan --}}
        <div class="card bg-base-100 shadow-md border border-base-content/5 rounded-xl">
          <div class="card-body p-4">
            <div class="flex items-center justify-between mb-2">
              <span class="text-xs text-base-content/50">Total Pendapatan</span>
              <span class="icon-[tabler--cash] text-success size-5"></span>
            </div>
            <p class="text-2xl font-bold text-success">
              Rp {{ number_format($totalPendapatanSemua / 1000000, 1) }}Jt
            </p>
            <p class="text-xs text-base-content/40 mt-1">Akumulasi semua petani</p>
          </div>
        </div>

        {{-- Saldo Keuangan --}}
        <div class="card bg-base-100 shadow-md border border-base-content/5 rounded-xl">
          <div class="card-body p-4">
            <div class="flex items-center justify-between mb-2">
              <span class="text-xs text-base-content/50">Saldo Keuangan</span>
              <span class="icon-[tabler--wallet] text-info size-5"></span>
            </div>
            <p class="text-2xl font-bold {{ $saldoKeuangan >= 0 ? 'text-info' : 'text-error' }}">
              Rp {{ number_format($saldoKeuangan / 1000000, 1) }}Jt
            </p>
            <p class="text-xs text-base-content/40 mt-1">Saldo kas berjalan</p>
          </div>
        </div>

      </div>

      {{-- ===== GRID UTAMA KONTEN ===== --}}
      {{-- Mobile/Tablet = 1 Kolom, Desktop = 3 Kolom Layout --}}
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

        {{-- ===== GRAFIK KEUANGAN ===== --}}
        <div class="card bg-base-100 shadow-md lg:col-span-2 rounded-xl overflow-hidden">
          <div class="card-body p-0">
            <div
              class="flex flex-col sm:flex-row sm:items-center justify-between border-b border-base-content/10 px-4 py-3 gap-2">
              <div class="flex items-center gap-2">
                <span class="icon-[tabler--chart-bar] text-warning size-5"></span>
                <h3 class="font-semibold text-sm md:text-base">Grafik Keuangan Bulanan</h3>
              </div>
              <div class="flex items-center gap-3 text-xs text-base-content/50">
                <div class="flex items-center gap-1">
                  <span class="size-2.5 rounded-sm bg-success inline-block"></span> Pemasukan
                </div>
                <div class="flex items-center gap-1">
                  <span class="size-2.5 rounded-sm bg-error inline-block"></span> Pengeluaran
                </div>
              </div>
            </div>
            <div class="p-4 overflow-x-auto">
              {{-- Membungkus canvas agar Chart.js tidak merusak lebar layout di device kecil --}}
              <div class="min-w-[400px] lg:min-w-0">
                <canvas id="grafikBulanan" height="140"></canvas>
              </div>
            </div>
          </div>
        </div>

        {{-- ===== STATISTIK PENGGUNA (DONUT) ===== --}}
        <div class="card bg-base-100 shadow-md rounded-xl overflow-hidden">
          <div class="card-body p-0">
            <div class="flex items-center gap-2 border-b border-base-content/10 px-4 py-3">
              <span class="icon-[tabler--users] text-primary size-5"></span>
              <h3 class="font-semibold text-sm md:text-base">Statistik Pengguna</h3>
            </div>
            <div class="p-4 flex flex-col gap-3">
              <div class="max-w-[180px] mx-auto w-full">
                <canvas id="grafikPengguna" height="160"></canvas>
              </div>
              <div class="flex flex-col gap-2 text-sm mt-2">
                @foreach ($statistikPengguna as $stat)
                  <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                      <span class="size-2.5 rounded-full inline-block" style="background: {{ $stat['warna'] }}"></span>
                      <span class="text-base-content/60">{{ $stat['label'] }}</span>
                    </div>
                    <span class="font-semibold">{{ $stat['jumlah'] }}</span>
                  </div>
                @endforeach
              </div>
            </div>
          </div>
        </div>

        {{-- ===== TABEL PENGGUNA TERBARU ===== --}}
        <div class="card bg-base-100 shadow-md lg:col-span-2 rounded-xl overflow-hidden">
          <div class="card-body p-0">
            <div class="flex items-center justify-between border-b border-base-content/10 px-4 py-3">
              <div class="flex items-center gap-2">
                <span class="icon-[tabler--user-plus] text-primary size-5"></span>
                <h3 class="font-semibold text-sm md:text-base">Pengguna Terbaru</h3>
              </div>
              <a href="{{ route('admin.users') }}" class="text-xs text-primary hover:underline">
                Lihat semua →
              </a>
            </div>
            <div class="overflow-x-auto w-full">
              <table class="table table-sm w-full">
                <thead>
                  <tr class="bg-base-200/50">
                    <th class="py-3.5">Nama</th>
                    <th class="py-3.5">Email</th>
                    <th class="py-3.5">Role</th>
                    <th class="py-3.5">Bergabung</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse ($penggunaTerbaru as $user)
                    <tr class="border-b border-base-content/5 hover:bg-base-200/30">
                      <td>
                        <div class="flex items-center gap-2">
                          <div class="avatar avatar-placeholder shrink-0">
                            <div class="bg-primary/20 text-primary rounded-full size-7 text-xs font-bold">
                              {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                          </div>
                          <span class="text-sm font-medium whitespace-nowrap">{{ $user->name }}</span>
                        </div>
                      </td>
                      <td class="text-sm text-base-content/60">{{ $user->email }}</td>
                      <td>
                        <span
                          class="badge badge-soft {{ $user->role === 'admin' ? 'badge-primary' : 'badge-ghost' }} text-xs">
                          {{ ucfirst($user->role) }}
                        </span>
                      </td>
                      <td class="text-sm text-base-content/60 whitespace-nowrap">
                        {{ $user->created_at->format('d M Y') }}
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="4" class="text-center text-base-content/40 py-8">Belum ada pengguna.</td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>
        </div>

        {{-- ===== RINGKASAN USAHA TANI ===== --}}
        <div class="card bg-base-100 shadow-md rounded-xl overflow-hidden">
          <div class="card-body p-0">
            <div class="flex items-center gap-2 border-b border-base-content/10 px-4 py-3">
              <span class="icon-[tabler--plant-2] text-success size-5"></span>
              <h3 class="font-semibold text-sm md:text-base">Ringkasan Usaha Tani</h3>
            </div>
            <div class="p-4">
              <div class="rounded-lg bg-base-200/60 p-3 text-sm flex flex-col gap-2">
                @foreach ([['label' => 'Total Panen', 'value' => number_format($totalPanen, 0, ',', '.') . ' kg', 'color' => 'text-warning'], ['label' => 'Total Terjual', 'value' => number_format($totalTerjual, 0, ',', '.') . ' kg', 'color' => 'text-info'], ['label' => 'Total Pendapatan', 'value' => 'Rp ' . number_format($totalPendapatanSemua, 0, ',', '.'), 'color' => 'text-success'], ['label' => 'Total Pengeluaran', 'value' => 'Rp ' . number_format($totalPengeluaranSemua, 0, ',', '.'), 'color' => 'text-error']] as $row)
                  <div class="flex justify-between gap-4">
                    <span class="text-base-content/60 whitespace-nowrap">{{ $row['label'] }}</span>
                    <span class="font-semibold {{ $row['color'] }} text-right">{{ $row['value'] }}</span>
                  </div>
                @endforeach
                <div class="divider my-1"></div>
                <div class="flex justify-between font-bold">
                  <span>Rata-rata Laba</span>
                  <span class="{{ $rataLaba >= 0 ? 'text-success' : 'text-error' }} text-right">
                    Rp {{ number_format($rataLaba, 0, ',', '.') }}
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>

        {{-- ===== AKTIVITAS TERBARU ===== --}}
        <div class="card bg-base-100 shadow-md rounded-xl overflow-hidden lg:col-span-2">
          <div class="card-body p-0">
            <div class="flex items-center gap-2 border-b border-base-content/10 px-4 py-3">
              <span class="icon-[tabler--activity] text-secondary size-5"></span>
              <h3 class="font-semibold text-sm md:text-base">Aktivitas Terbaru</h3>
            </div>
            <div class="p-4 flex flex-col gap-3 max-h-[320px] overflow-y-auto">
              @forelse ($aktivitasTerbaru as $aktivitas)
                <div class="flex items-start gap-3">
                  <div
                    class="mt-0.5 size-7 rounded-full flex items-center justify-center shrink-0 {{ $aktivitas['tipe'] === 'produksi' ? 'bg-warning/20' : ($aktivitas['tipe'] === 'keuangan' ? 'bg-success/20' : 'bg-primary/20') }}">
                    <span
                      class="size-3.5 {{ $aktivitas['tipe'] === 'produksi' ? 'icon-[tabler--wheat] text-warning' : ($aktivitas['tipe'] === 'keuangan' ? 'icon-[tabler--cash] text-success' : 'icon-[tabler--user] text-primary') }}"></span>
                  </div>
                  <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium leading-tight text-base-content/90">{{ $aktivitas['pesan'] }}</p>
                    <p class="text-xs text-base-content/40 mt-0.5">{{ $aktivitas['waktu'] }}</p>
                  </div>
                </div>
              @empty
                <p class="text-sm text-base-content/40 text-center py-4">Belum ada aktivitas.</p>
              @endforelse
            </div>
          </div>
        </div>

        {{-- ===== RANKING PENGGUNA ===== --}}
        <div class="card bg-base-100 shadow-md rounded-xl overflow-hidden">
          <div class="card-body p-0">
            <div class="flex items-center gap-2 border-b border-base-content/10 px-4 py-3">
              <span class="icon-[tabler--users] text-primary size-5"></span>
              <h3 class="font-semibold text-sm md:text-base">Ranking Pengguna</h3>
            </div>
            <div class="p-4 flex flex-col gap-3">
              @forelse ($rankingPengguna as $ranking)
                <div class="flex items-center gap-3">
                  <div
                    class="mt-0.5 size-7 rounded-full flex items-center justify-center shrink-0 {{ $ranking['role'] === 'admin' ? 'bg-primary/20' : 'bg-secondary/20' }}">
                    <span
                      class="size-3.5 {{ $ranking['role'] === 'admin' ? 'icon-[tabler--user] text-primary' : 'icon-[tabler--users] text-secondary' }}"></span>
                  </div>
                  <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium leading-tight">
                      {{ $ranking['role'] === 'admin' ? 'Admin' : 'Petani' }}
                    </p>
                    <p class="text-xs text-base-content/40 mt-0.5">
                      {{ $ranking['jumlah'] }} pengguna
                    </p>
                  </div>
                </div>
              @empty
                <p class="text-sm text-base-content/40 text-center py-4">Belum ada pengguna.</p>
              @endforelse
            </div>
          </div>
        </div>

      </div> {{-- End Grid Utama Konten --}}
    </div>
  </div>
@endsection

@push('js')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
  <script>
    // Grafik Keuangan Bulanan
    new Chart(document.getElementById('grafikBulanan').getContext('2d'), {
      type: 'bar',
      data: {
        labels: @json($labelBulan),
        datasets: [{
            label: 'Pemasukan',
            data: @json($dataPemasukan),
            backgroundColor: 'rgba(34,197,94,0.7)',
            borderRadius: 4,
          },
          {
            label: 'Pengeluaran',
            data: @json($dataPengeluaran),
            backgroundColor: 'rgba(239,68,68,0.7)',
            borderRadius: 4,
          }
        ]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false, // Ditambahkan agar tinggi menyesuaikan wrapper pembungkusnya
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

    // Grafik Donut Pengguna
    new Chart(document.getElementById('grafikPengguna').getContext('2d'), {
      type: 'doughnut',
      data: {
        labels: @json($statistikPengguna->pluck('label')),
        datasets: [{
          data: @json($statistikPengguna->pluck('jumlah')),
          backgroundColor: @json($statistikPengguna->pluck('warna')),
          borderWidth: 0,
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: true,
        cutout: '65%',
        plugins: {
          legend: {
            display: false
          }
        }
      }
    });
  </script>
@endpush
