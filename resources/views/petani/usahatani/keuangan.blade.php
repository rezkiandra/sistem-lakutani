@extends('layouts.app')

@section('title', 'Catatan Keuangan Pertanian')

@section('content')
  {{-- 1. Mengubah susunan pembungkus utama agar tidak memaksa elemen melebar kaku --}}
  <div class="w-full min-h-screen bg-base-200/30 px-3 sm:px-6 py-20 lg:py-8">
    <div class="max-w-7xl mx-auto">

      <div class="shadow-md rounded-xl overflow-hidden border border-base-content/5 bg-base-100 w-full">

        {{-- ===== HEADER ===== --}}
        <div class="woodImage p-4 sm:p-5">
          <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div>
              <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-slate-100 mb-1 flex items-center gap-2">
                <span>📒</span> Catatan Keuangan Pertanian
              </h1>
              <span class="text-xs md:text-sm text-slate-200/90 block">Riwayat pemasukan dan pengeluaran usaha tani</span>
            </div>

            {{-- Tombol aksi adaptif: di HP/Tablet bertumpuk rapi, di desktop sejajar --}}
            <div class="flex flex-col sm:flex-row gap-2 w-full lg:w-auto">
              <a href="{{ route('petani.createKeuangan') }}" class="btn btn-sm btn-warning w-full sm:w-auto justify-center">
                <i class="ti ti-coin-euro text-lg"></i>
                Tambah Transaksi
              </a>
              <a href="{{ route('petani.laporanKeuangan') }}"
                class="btn btn-sm greenImage w-full sm:w-auto justify-center text-stone-200 border-none">
                <i class="ti ti-printer text-lg"></i>
                Lihat Laporan
              </a>
            </div>
          </div>
        </div>

        {{-- ===== BODY ===== --}}
        <div class="p-3 sm:p-5 md:p-6">

          {{-- ===== STAT CARDS (RESPONSIVE FIX) ===== --}}
          {{-- HP: 1 Kolom | Tablet Portrait (md): 2 Kolom | Desktop/Tablet Landscape (lg): 3 Kolom --}}
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4 mb-6">

            {{-- Pemasukan --}}
            <div
              class="bg-base-200/60 shadow-sm rounded-xl border border-base-content/5 p-4 flex flex-col justify-center">
              <div class="flex items-center gap-2 mb-1">
                <i class="ti ti-trending-up text-success text-lg"></i>
                <span class="text-xs text-base-content/60 font-medium">Total Pemasukan</span>
              </div>
              <p class="text-lg sm:text-xl md:text-2xl font-bold text-success truncate">
                Rp {{ number_format($totalPemasukan, 0, ',', '.') }}
              </p>
            </div>

            {{-- Pengeluaran --}}
            <div
              class="bg-base-200/60 shadow-sm rounded-xl border border-base-content/5 p-4 flex flex-col justify-center">
              <div class="flex items-center gap-2 mb-1">
                <i class="ti ti-trending-down text-error text-lg"></i>
                <span class="text-xs text-base-content/60 font-medium">Total Pengeluaran</span>
              </div>
              <p class="text-lg sm:text-xl md:text-2xl font-bold text-error truncate">
                Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}
              </p>
            </div>

            {{-- Saldo Akhir --}}
            <div
              class="bg-base-200/60 shadow-sm rounded-xl border border-base-content/5 p-4 flex flex-col justify-center md:col-span-2 lg:col-span-1">
              <div class="flex items-center gap-2 mb-1">
                <i class="ti ti-wallet text-lg {{ $saldoAkhir >= 0 ? 'text-info' : 'text-error' }}"></i>
                <span class="text-xs text-base-content/60 font-medium">Saldo Akhir</span>
              </div>
              <p
                class="text-lg sm:text-xl md:text-2xl font-bold {{ $saldoAkhir >= 0 ? 'text-info' : 'text-error' }} truncate">
                Rp {{ number_format($saldoAkhir, 0, ',', '.') }}
              </p>
            </div>

          </div>

          {{-- ===== TABEL RIWAYAT TRANSAKSI ===== --}}
          <div class="bg-base-100 border border-base-content/10 rounded-xl overflow-hidden shadow-sm w-full">
            <div class="flex items-center gap-2 border-b border-base-content/10 px-4 py-3">
              <span class="ti ti-history text-primary text-lg"></span>
              <h3 class="font-semibold text-sm md:text-base">Riwayat Transaksi</h3>
            </div>

            {{-- Kontrol scrollbar horizontal agar tidak merusak layout container utama di tablet --}}
            <div class="overflow-x-auto w-full block alignment-baseline-fix">
              <table class="table table-sm md:table-md w-full min-w-[700px] md:min-w-0">
                <thead>
                  <tr class="bg-base-200/50 text-base-content/80 border-b border-base-content/10">
                    <th class="py-3 px-4">Tanggal</th>
                    <th class="py-3">Keterangan</th>
                    <th class="text-end py-3">Pemasukan</th>
                    <th class="text-end py-3">Pengeluaran</th>
                    <th class="text-end py-3">Saldo</th>
                    <th class="py-3 px-4 text-center">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse ($transaksi as $item)
                    @php
                      $tglLabel = \Carbon\Carbon::parse($item->tanggal)->format('d M Y');
                    @endphp
                    <tr class="border-b border-base-content/5 hover:bg-base-200/20 transition-colors">
                      <td class="text-sm text-base-content/70 whitespace-nowrap px-4">
                        {{ $tglLabel }}
                      </td>
                      <td>
                        <div class="flex items-center gap-2">
                          <span
                            class="badge {{ $item->jenis === 'pemasukan' ? 'badge-success text-success-content' : 'badge-error text-error-content' }} text-xs shrink-0 font-semibold px-2 py-0.5">
                            {{ $item->jenis === 'pemasukan' ? '↓ Masuk' : '↑ Keluar' }}
                          </span>
                          <span class="text-sm font-medium text-base-content/80 max-w-[120px] sm:max-w-[200px] truncate"
                            title="{{ $item->kategori }}">
                            {{ $item->kategori }}
                          </span>
                        </div>
                      </td>
                      <td class="text-end font-semibold text-success whitespace-nowrap">
                        {{ $item->jenis === 'pemasukan' ? 'Rp ' . number_format($item->jumlah, 0, ',', '.') : '—' }}
                      </td>
                      <td class="text-end font-semibold text-error whitespace-nowrap">
                        {{ $item->jenis === 'pengeluaran' ? 'Rp ' . number_format($item->jumlah, 0, ',', '.') : '—' }}
                      </td>
                      <td
                        class="text-end font-bold {{ $item->saldo_berjalan >= 0 ? 'text-info' : 'text-error' }} whitespace-nowrap">
                        Rp {{ number_format($item->saldo_berjalan, 0, ',', '.') }}
                      </td>
                      <td class="px-4 text-center">
                        <div class="flex gap-1 justify-center items-center">
                          <a href="{{ route('petani.editKeuangan', $item->id) }}"
                            class="btn btn-xs btn-ghost text-warning btn-circle" title="Edit">
                            <span class="ti ti-pencil text-sm"></span>
                          </a>
                          <form id="form-hapus-trx-{{ $item->id }}"
                            action="{{ route('petani.destroyKeuangan', $item->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-xs btn-ghost text-error btn-circle" title="Hapus"
                              onclick="konfirmasiHapusTrx(
                                'form-hapus-trx-{{ $item->id }}',
                                '{{ $item->kategori }}',
                                '{{ $tglLabel }}',
                                '{{ $item->jenis }}'
                              )">
                              <span class="ti ti-trash text-sm"></span>
                            </button>
                          </form>
                        </div>
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="6" class="text-center text-base-content/40 py-12">
                        <span class="icon-[tabler--inbox] size-10 mx-auto block mb-2 opacity-50"></span>
                        <p class="text-sm font-medium">Belum ada catatan keuangan terdaftar.</p>
                        <a href="{{ route('petani.createKeuangan') }}"
                          class="text-primary text-xs underline mt-1 inline-block font-semibold">
                          Tambah Transaksi Baru
                        </a>
                      </td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>

            @if ($transaksi->hasPages())
              <div class="p-4 border-t border-base-content/5 flex justify-center sm:justify-end">
                {{ $transaksi->links() }}
              </div>
            @endif

          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
