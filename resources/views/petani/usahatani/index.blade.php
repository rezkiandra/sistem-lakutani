@extends('layouts.app')

@section('title', 'Data Usaha Tani')

@section('content')
  <div class="container mx-auto min-h-screen flex flex-col items-center justify-start">
    <div class="w-full px-6 mt-20 mb-10">

      <div class="shadow-md">
        <div class="woodImage p-5">
          <div class="flex items-center justify-between">
            <div>
              <h1 class="text-3xl font-bold text-slate-100 mb-1">🌾 Data Usaha Tani</h1>
              <span class="text-sm text-slate-100">Riwayat produksi, pendapatan, dan laba/rugi</span>
            </div>
            <a href="{{ route('petani.createProduksi') }}" class="btn btn-sm greenImage">
              <i class="ti ti-tractor text-lg"></i>
              Input Produksi Baru
            </a>
          </div>
        </div>

        <div class="">

          {{-- Flash Message --}}
          @if (session('success'))
            <div class="alert alert-success mb-4">
              <i class="ti ti-check text-lg"></i>
              {{ session('success') }}
            </div>
          @endif

          {{-- Stat s --}}
          <div class="grid grid-cols-2 gap-3 lg:grid-cols-4 mb-4">
            <div class="shadow-md bg-base-100 shadow-md">
              <div class="p-4">
                <div class="flex items-center gap-2 mb-1">
                  <i class="ti ti-cloud-fog text-lg"></i>
                  <span class="text-xs text-base-content/50">Total Produksi</span>
                </div>
                <p class="text-2xl font-bold text-warning">{{ $produksis->total() }}</p>
              </div>
            </div>
            <div class="shadow-md bg-base-100 shadow-md">
              <div class="p-4">
                <div class="flex items-center gap-2 mb-1">
                  <i class="ti ti-growth text-lg"></i>
                  <span class="text-xs text-base-content/50">Total Panen</span>
                </div>
                <p class="text-2xl font-bold text-info">
                  {{ number_format($totalPanen, 0, ',', '.') }} kg
                </p>
              </div>
            </div>
            <div class="shadow-md bg-base-100 shadow-md">
              <div class="p-4">
                <div class="flex items-center gap-2 mb-1">
                  <i class="ti ti-currency-dollar text-lg"></i>
                  <span class="text-xs text-base-content/50">Total Pendapatan</span>
                </div>
                <p class="text-2xl font-bold text-success">
                  Rp {{ number_format($totalPendapatan / 1000000, 1) }}Jt
                </p>
              </div>
            </div>
            <div class="shadow-md bg-base-100 shadow-md">
              <div class="p-4">
                <div class="flex items-center gap-2 mb-1">
                  <i
                    class="{{ $totalLabaRugi >= 0 ? 'ti ti-trending-up text-success' : 'ti ti-trending-down text-error' }} size-5"></i>
                  <span class="text-xs text-base-content/50">Total Laba/Rugi</span>
                </div>
                <p class="text-2xl font-bold {{ $totalLabaRugi >= 0 ? 'text-success' : 'text-error' }}">
                  {{ $totalLabaRugi >= 0 ? '+' : '' }}Rp {{ number_format($totalLabaRugi / 1000000, 1) }}Jt
                </p>
              </div>
            </div>
          </div>

          {{-- Tabel --}}
          <div class="shadow-md bg-base-100 shadow-md">
            <div class=" p-0">
              <div class="flex items-center gap-2 border-b border-base-content/10 px-4 py-3">
                <i class="ti ti-tractor text-lg"></i>
                <h3 class="font-semibold">Daftar Produksi</h3>
              </div>

              <div class="overflow-x-auto">
                <table class="table table-sm">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Musim / Tanggal</th>
                      @if (Auth::user()->isAdmin())
                        <th>Petani</th>
                      @endif
                      <th class="text-end">Hasil Panen</th>
                      <th class="text-end">Padi Terjual</th>
                      <th class="text-end">Pendapatan</th>
                      <th class="text-end">Pengeluaran</th>
                      <th class="text-end">Laba / Rugi</th>
                      <th>Status</th>
                      <th class="text-center">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse ($produksis as $index => $item)
                      @php
                        $pendapatan = $item->pendapatan;
                        $labaRugi = $pendapatan?->labaRugi;
                        $lr = $labaRugi?->total_laba_rugi ?? null;

                        // Status kelengkapan data
                        $stepSelesai = 0;
                        if ($item->exists) {
                            $stepSelesai = 1;
                        }
                        if ($pendapatan) {
                            $stepSelesai = 2;
                        }
                        if ($labaRugi) {
                            $stepSelesai = 3;
                        }
                      @endphp
                      <tr class="hover:bg-base-200/40">
                        <td class="text-base-content/40 text-sm">
                          {{ ($produksis->currentPage() - 1) * $produksis->perPage() + $index + 1 }}
                        </td>
                        <td class="whitespace-nowrap text-sm text-base-content/60">
                          {{ $item->created_at->isoFormat('D MMM Y') }}
                        </td>
                        @if (Auth::user()->isAdmin())
                          <td>
                            <div class="flex items-center gap-2">
                              <div
                                class="size-6 rounded-full bg-primary/20 text-primary flex items-center justify-center text-xs font-bold shrink-0">
                                {{ strtoupper(substr($item->user->name ?? '?', 0, 1)) }}
                              </div>
                              <span class="text-sm">{{ $item->user->name ?? '-' }}</span>
                            </div>
                          </td>
                        @endif
                        <td class="text-end font-medium text-warning">
                          {{ number_format($item->hasil_panen_padi_kg, 0, ',', '.') }} kg
                        </td>
                        <td class="text-end text-sm">
                          {{ number_format($item->padi_terjual_kg, 0, ',', '.') }} kg
                        </td>
                        <td class="text-end font-medium text-success">
                          @if ($pendapatan)
                            Rp {{ number_format($pendapatan->total_pendapatan, 0, ',', '.') }}
                          @else
                            <span class="text-base-content/30">—</span>
                          @endif
                        </td>
                        <td class="text-end font-medium text-error">
                          @if ($labaRugi)
                            Rp {{ number_format($labaRugi->total_pengeluaran_produksi, 0, ',', '.') }}
                          @else
                            <span class="text-base-content/30">—</span>
                          @endif
                        </td>
                        <td class="text-end font-bold">
                          @if ($lr !== null)
                            <span class="{{ $lr >= 0 ? 'text-success' : 'text-error' }}">
                              {{ $lr >= 0 ? '+' : '' }}Rp {{ number_format($lr, 0, ',', '.') }}
                            </span>
                          @else
                            <span class="text-base-content/30">—</span>
                          @endif
                        </td>

                        {{-- Status kelengkapan --}}
                        <td>
                          @if ($stepSelesai === 3)
                            <span class="badge badge-soft badge-success text-xs">Lengkap</span>
                          @elseif ($stepSelesai === 2)
                            <span class="badge badge-soft badge-warning text-xs">Step 3 kurang</span>
                          @elseif ($stepSelesai === 1)
                            <span class="badge badge-soft badge-error text-xs">Step 2 & 3 kurang</span>
                          @endif
                        </td>

                        {{-- Tombol Aksi --}}
                        <td>
                          <div class="flex items-center justify-center gap-1">

                            {{-- Lanjutkan step yang belum selesai --}}
                            @if ($stepSelesai === 1)
                              <a href="{{ route('petani.createPendapatan', $item->id) }}" class="btn btn-xs btn-warning"
                                title="Input Pendapatan">
                                <i class="ti ti-arrow-forward text-lg"></i>
                                Lanjut
                              </a>
                            @elseif ($stepSelesai === 2)
                              <a href="{{ route('petani.createLabaRugi', $pendapatan->id) }}"
                                class="btn btn-xs btn-warning" title="Input Laba/Rugi">
                                <i class="ti ti-arrow-forward text-lg"></i>
                                Lanjut
                              </a>
                            @endif

                            {{-- Lihat Hasil Analisis --}}
                            @if ($stepSelesai === 3)
                              <a href="{{ route('petani.hasilAnalisis', $item->id) }}"
                                class="btn btn-xs btn-ghost text-info" title="Lihat Analisis">
                                <i class="ti ti-eye text-lg"></i>
                              </a>

                              {{-- Uji Kelayakan --}}
                              <a href="{{ route('petani.ujiKelayakan', $item->id) }}"
                                class="btn btn-xs btn-ghost text-success" title="Uji Kelayakan">
                                <i class="ti ti-check text-lg"></i>
                              </a>
                            @endif

                            {{-- Edit Produksi --}}
                            <a href="{{ route('petani.editProduksi', $item->id) }}"
                              class="btn btn-xs btn-ghost text-warning" title="Edit">
                              <i class="ti ti-pencil text-lg"></i>
                            </a>

                            {{-- Hapus --}}
                            <form action="{{ route('petani.destroyProduksi', $item->id) }}" method="POST"
                              onsubmit="return confirm('Hapus data produksi ini beserta pendapatan dan laba/rugi terkait?')">
                              @csrf
                              @method('DELETE')
                              <button type="submit" class="btn btn-xs btn-ghost text-error" title="Hapus">
                                <i class="ti ti-trash text-lg"></i>
                              </button>
                            </form>

                          </div>
                        </td>
                      </tr>
                    @empty
                      <tr>
                        <td colspan="{{ Auth::user()->isAdmin() ? 10 : 9 }}"
                          class="text-center text-base-content/40 py-10">
                          <i class="ti ti-check text-lg"></i>
                          Belum ada data produksi.
                          <a href="{{ route('petani.createProduksi') }}" class="text-primary underline ms-1">
                            Input sekarang
                          </a>
                        </td>
                      </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>

              {{-- Pagination --}}
              @if ($produksis->hasPages())
                <div class="p-4 border-t border-base-content/10">
                  {{ $produksis->links() }}
                </div>
              @endif

            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
@endsection
