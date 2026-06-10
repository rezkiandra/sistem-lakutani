@extends('layouts.app')

@section('title', 'Data Usaha Tani')

@section('content')
  <div class="container mx-auto min-h-screen flex flex-col items-center justify-start px-4">
    <div class="w-full max-w-7xl mt-20 lg:mt-30 md:mt-20 mb-10">

      <div class="shadow-md bg-base-100 rounded-xl overflow-hidden">
        {{-- ===== HEADER UTAMA ===== --}}
        <div class="woodImage p-4 md:p-5">
          <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
              <h1 class="text-2xl lg:text-3xl md:text-3xl font-bold text-slate-100 mb-1">🌾 Data Usaha Tani</h1>
              <span class="text-xs md:text-sm text-slate-100 block">Riwayat produksi, pendapatan, dan laba/rugi</span>
            </div>
          </div>
        </div>

        <div class="p-4 md:p-5">

          {{-- ===== FLASH MESSAGE ===== --}}
          @if (session('success'))
            <div class="alert alert-success mb-4 flex items-start gap-2">
              <i class="ti ti-check text-lg shrink-0 mt-0.5"></i>
              <span class="text-sm">{{ session('success') }}</span>
            </div>
          @endif

          {{-- ===== KARTU STATISTIK ATAS ===== --}}
          <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 mb-6">

            <div class="shadow-sm border border-base-content/10 bg-base-100 rounded-xl">
              <div class="p-4">
                <div class="flex items-center gap-2 mb-1">
                  <i class="ti ti-cloud-fog text-lg text-warning"></i>
                  <span class="text-xs text-base-content/50">Total Record</span>
                </div>
                <p class="text-2xl font-bold text-warning">{{ $produksis->total() }}</p>
              </div>
            </div>

            <div class="shadow-sm border border-base-content/10 bg-base-100 rounded-xl">
              <div class="p-4">
                <div class="flex items-center gap-2 mb-1">
                  <i class="ti ti-growth text-lg text-info"></i>
                  <span class="text-xs text-base-content/50">Total Panen</span>
                </div>
                <p class="text-2xl font-bold text-info">
                  {{ number_format($totalPanen, 0, ',', '.') }} kg
                </p>
              </div>
            </div>

            <div class="shadow-sm border border-base-content/10 bg-base-100 rounded-xl">
              <div class="p-4">
                <div class="flex items-center gap-2 mb-1">
                  <i class="ti ti-currency-dollar text-lg text-success"></i>
                  <span class="text-xs text-base-content/50">Total Pendapatan</span>
                </div>
                <p class="text-2xl font-bold text-success">
                  Rp {{ number_format($totalPendapatan / 1000000, 1) }}Jt
                </p>
              </div>
            </div>

            <div class="shadow-sm border border-base-content/10 bg-base-100 rounded-xl">
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

          {{-- ===== TABEL DATA UTAMA ===== --}}
          <div class="shadow-sm border border-base-content/10 bg-base-100 rounded-xl overflow-hidden">
            <div class="p-0">
              <div class="flex items-center gap-2 border-b border-base-content/10 px-4 py-3">
                <i class="ti ti-tractor text-lg text-primary"></i>
                <h3 class="font-semibold">Daftar Produksi & Alur Kelayakan</h3>
              </div>

              <div class="overflow-x-auto w-full">
                <table class="table table-sm w-full">
                  <thead>
                    <tr class="bg-base-200/50">
                      <th class="py-3">#</th>
                      <th class="py-3">Musim / Tanggal</th>
                      @if (Auth::user()->isAdmin())
                        <th class="py-3">Petani</th>
                      @endif
                      <th class="text-end py-3">Hasil Panen</th>
                      <th class="text-end py-3">Padi Terjual</th>
                      <th class="text-end py-3">Laba / Rugi</th>
                      <th class="py-3">Status Kelengkapan</th>
                      <th class="text-center py-3">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse ($produksis as $index => $item)
                      @php
                        // Ambil relasi data transaksi tingkat lanjut
                        $pendapatan = $item->pendapatan;
                        $labaRugi = $pendapatan?->labaRugi;
                        $lr = $labaRugi?->total_laba_rugi ?? null;

                        // Mengunci penanda langkah pengisian data petani
                        $stepSelesai = 0;
                        if ($item->exists) {
                            $stepSelesai = 1; // Tahap Produksi Kelar
                        }
                        if ($pendapatan) {
                            $stepSelesai = 2; // Tahap Pendapatan Kelar
                        }
                        if ($labaRugi) {
                            $stepSelesai = 3; // Tahap Laba Rugi Kelar / Sempurna
                        }
                        $tglLabel = $item->created_at->isoFormat('D MMM Y');
                      @endphp

                      <tr class="hover:bg-base-200/40 border-b border-base-content/5">
                        {{-- Nomor Urut Row --}}
                        <td class="text-base-content/40 text-sm font-medium">
                          {{ ($produksis->currentPage() - 1) * $produksis->perPage() + $index + 1 }}
                        </td>

                        {{-- Tanggal Pembuatan --}}
                        <td class="whitespace-nowrap text-sm text-base-content/70">
                          {{ $tglLabel }}
                        </td>

                        {{-- Identitas Jika Akun Admin --}}
                        @if (Auth::user()->isAdmin())
                          <td class="whitespace-nowrap">
                            <div class="flex items-center gap-2">
                              <div
                                class="size-6 rounded-full bg-primary/20 text-primary flex items-center justify-center text-xs font-bold shrink-0">
                                {{ strtoupper(substr($item->user->name ?? '?', 0, 1)) }}
                              </div>
                              <span class="text-sm font-medium">{{ $item->user->name ?? '-' }}</span>
                            </div>
                          </td>
                        @endif

                        {{-- Data Hasil Berat Tanam (Step 1) --}}
                        <td class="text-end font-medium text-warning whitespace-nowrap">
                          {{ number_format($item->hasil_panen_padi_kg, 0, ',', '.') }} kg
                        </td>
                        <td class="text-end text-sm whitespace-nowrap">
                          {{ number_format($item->padi_terjual_kg, 0, ',', '.') }} kg
                        </td>

                        {{-- Data Hasil Penjualan Pasar (Step 2) --}}
                        <td class="text-end font-medium text-success whitespace-nowrap">
                          @if ($pendapatan)
                            Rp {{ number_format($pendapatan->total_pendapatan, 0, ',', '.') }}
                          @else
                            <span class="text-base-content/30 italic text-xs">Belum diinput</span>
                          @endif
                        </td>

                        {{-- Data Beban Biaya Modal Operasional (Step 3) --}}
                        <td class="text-end font-medium text-error whitespace-nowrap">
                          @if ($labaRugi)
                            Rp {{ number_format($labaRugi->total_pengeluaran_produksi, 0, ',', '.') }}
                          @else
                            <span class="text-base-content/30 italic text-xs">Belum diinput</span>
                          @endif
                        </td>

                        {{-- Kalkulasi Laba / Rugi Bersih Final --}}
                        <td class="text-end font-bold whitespace-nowrap">
                          @if ($lr !== null)
                            <span class="{{ $lr >= 0 ? 'text-success' : 'text-error' }}">
                              {{ $lr >= 0 ? '+' : '' }}Rp {{ number_format($lr, 0, ',', '.') }}
                            </span>
                          @else
                            <span class="text-base-content/30">—</span>
                          @endif
                        </td>

                        {{-- Kolom Badge Pemantau Tahapan Formulir --}}
                        <td class="whitespace-nowrap">
                          @if ($stepSelesai === 3)
                            <span
                              class="badge badge-success bg-success/10 text-success border-success/20 text-xs font-semibold px-2.5 py-1">
                              Lengkap
                            </span>
                          @elseif ($stepSelesai === 2)
                            <span
                              class="badge badge-warning bg-warning/10 text-warning border-warning/20 text-xs font-semibold px-2.5 py-1">
                              Step 2 (Kurang Laba/Rugi)
                            </span>
                          @elseif ($stepSelesai === 1)
                            <span
                              class="badge badge-error bg-error/10 text-error border-error/20 text-xs font-semibold px-2.5 py-1">
                              Step 1 (Baru Produksi)
                            </span>
                          @endif
                        </td>

                        {{-- Opsi Penanganan Aksi Transaksi --}}
                        <td>
                          <div class="flex items-center justify-center gap-1">

                            {{-- Mengarahkan Petani Berdasarkan Tangga Input Data --}}
                            @if ($stepSelesai === 1)
                              <a href="{{ route('petani.createPendapatan', $item->id) }}"
                                class="btn btn-xs btn-warning gap-1 font-semibold text-stone-800"
                                title="Input Pendapatan">
                                <i class="ti ti-arrow-forward text-sm"></i> Isi Step 2
                              </a>
                            @elseif ($stepSelesai === 2)
                              <a href="{{ route('petani.createLabaRugi', $pendapatan->id) }}"
                                class="btn btn-xs btn-warning gap-1 font-semibold text-stone-800" title="Input Laba/Rugi">
                                <i class="ti ti-arrow-forward text-sm"></i> Isi Step 3
                              </a>
                            @endif

                            {{-- Tombol Khusus Terbuka Jika Step 3 (Lengkap) Terpenuhi --}}
                            @if ($stepSelesai === 3)
                              <a href="{{ route('admin.hasilAnalisis', $item->id) }}"
                                class="btn btn-xs btn-ghost text-info p-1 hover:bg-info/10" title="Lihat Analisis">
                                <i class="ti ti-eye text-base"></i>
                              </a>
                              <a href="{{ route('admin.ujiKelayakan', $item->id) }}"
                                class="btn btn-xs btn-outline btn-success text-xs px-2 font-bold"
                                title="Uji Kelayakan Per Data">
                                <i class="ti ti-check text-base"></i>
                              </a>
                            @endif

                            {{-- Tombol Utama Penyuntingan & Penghapusan --}}
                            {{-- <a href="{{ route('petani.editProduksi', $item->id) }}"
                              class="btn btn-xs btn-ghost text-warning p-1 hover:bg-warning/10" title="Edit">
                              <i class="ti ti-pencil text-base"></i>
                            </a>

                            <form id="form-hapus-{{ $item->id }}"
                              action="{{ route('petani.destroyProduksi', $item->id) }}" method="POST"
                              class="inline-block">
                              @csrf
                              @method('DELETE')
                              <button type="button" class="btn btn-xs btn-ghost text-error p-1 hover:bg-error/10"
                                title="Hapus"
                                onclick="konfirmasiHapus('form-hapus-{{ $item->id }}', '{{ $tglLabel }}')">
                                <i class="ti ti-trash text-base"></i>
                              </button>
                            </form> --}}

                          </div>
                        </td>
                      </tr>
                    @empty
                      <tr>
                        <td colspan="{{ Auth::user()->isAdmin() ? 10 : 9 }}"
                          class="text-center text-base-content/40 py-12">
                          <div class="flex flex-col items-center justify-center gap-2">
                            <i class="ti ti-tractor text-3xl opacity-40"></i>
                            <p>Belum ada data produksi usaha tani.</p>
                            <a href="{{ route('petani.createProduksi') }}"
                              class="text-primary underline text-sm font-medium">
                              Input sekarang
                            </a>
                          </div>
                        </td>
                      </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>

              {{-- Paginator Halaman Bawah Tabel --}}
              @if ($produksis->hasPages())
                <div class="p-4 border-t border-base-content/10 bg-base-200/20">
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

@push('js')
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    function konfirmasiHapus(formId, tanggal) {
      Swal.fire({
        title: 'Hapus Data Produksi?',
        html: `Data produksi tanggal <strong>${tanggal}</strong> beserta <br>
               pendapatan dan laba/rugi terkait akan dihapus permanen.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: '🗑️ Ya, Hapus!',
        cancelButtonText: 'Batal',
        reverseButtons: true,
        focusCancel: true,
      }).then((result) => {
        if (result.isConfirmed) {
          document.getElementById(formId).submit();
        }
      });
    }
  </script>
@endpush
