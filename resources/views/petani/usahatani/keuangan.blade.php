@extends('layouts.app')

@section('title', 'Catatan Keuangan Pertanian')

@section('content')
  <div class="container mx-auto min-h-screen flex flex-col items-center justify-start">
    <div class="w-3/4 mt-20 mb-10">

      <div class="shadow-md">
        <div class="woodImage p-5">
          <div class="flex items-center justify-between">
            <div>
              <h1 class="text-3xl font-bold text-slate-100 mb-1">📒 Catatan Keuangan Pertanian</h1>
              <span class="text-sm text-slate-100">Riwayat pemasukan dan pengeluaran usaha tani</span>
            </div>
            <div class="flex gap-2">
              <a href="{{ route('petani.catatKeuangan') }}" class="btn btn-sm btn-warning">
                <i class="ti ti-coin-euro text-lg"></i>
                Tambah Transaksi
              </a>
              <a href="{{ route('petani.laporanKeuangan') }}" class="btn btn-sm greenImage">
                <i class="ti ti-printer text-lg"></i>
                Lihat Laporan
              </a>
            </div>
          </div>
        </div>

        <div class="rounded-xl">

          {{-- Ringkasan Cepat --}}
          <div class="grid grid-cols-3 gap-3 mb-4">
            <div class="bg-base-100 shadow-md">
              <div class="rounded-xl p-4">
                <div class="flex items-center gap-2 mb-1">
                  <i class="ti ti-trending-up text-success text-lg"></i>
                  <span class="text-xs text-base-content/50">Total Pemasukan</span>
                </div>
                <p class="text-xl font-bold text-success">
                  Rp {{ number_format($totalPemasukan, 0, ',', '.') }}
                </p>
              </div>
            </div>
            <div class="bg-base-100 shadow-md">
              <div class="rounded-xl p-4">
                <div class="flex items-center gap-2 mb-1">
                  <i class="ti ti-trending-down text-error text-lg"></i>
                  <span class="text-xs text-base-content/50">Total Pengeluaran</span>
                </div>
                <p class="text-xl font-bold text-error">
                  Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}
                </p>
              </div>
            </div>
            <div class="bg-base-100 shadow-md">
              <div class="rounded-xl p-4">
                <div class="flex items-center gap-2 mb-1">
                  <span class="ti ti-wallet text-lg {{ $saldoAkhir >= 0 ? 'text-info' : 'text-error' }}"></span>
                  <span class="text-xs text-base-content/50">Saldo Akhir</span>
                </div>
                <p class="text-xl font-bold {{ $saldoAkhir >= 0 ? 'text-info' : 'text-error' }}">
                  Rp {{ number_format($saldoAkhir, 0, ',', '.') }}
                </p>
              </div>
            </div>
          </div>

          {{-- Tabel Transaksi --}}
          <div class="bg-base-100 shadow-md">
            <div class="rounded-xl p-0">
              <div class="flex items-center gap-2 border-b border-base-content/10 px-4 py-3">
                <span class="ti ti-history text-primary text-lg"></span>
                <h3 class="font-semibold">Riwayat Transaksi</h3>
              </div>
              <div class="overflow-x-auto">
                <table class="table table-sm">
                  <thead>
                    <tr>
                      <th>Tanggal</th>
                      <th>Keterangan</th>
                      <th class="text-end">Pemasukan</th>
                      <th class="text-end">Pengeluaran</th>
                      <th class="text-end">Saldo</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse ($transaksi as $item)
                      <tr>
                        <td class="text-sm text-base-content/60 whitespace-nowrap">
                          {{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}
                        </td>
                        <td>
                          <div class="flex items-center gap-2">
                            <span
                              class="badge badge-soft {{ $item->jenis === 'pemasukan' ? 'badge-success' : 'badge-error' }} text-xs">
                              {{ $item->jenis === 'pemasukan' ? '↓ Masuk' : '↑ Keluar' }}
                            </span>
                            <span class="text-sm">{{ $item->kategori }}</span>
                          </div>
                        </td>
                        <td class="text-end font-medium text-success">
                          {{ $item->jenis === 'pemasukan' ? 'Rp ' . number_format($item->jumlah, 0, ',', '.') : '—' }}
                        </td>
                        <td class="text-end font-medium text-error">
                          {{ $item->jenis === 'pengeluaran' ? 'Rp ' . number_format($item->jumlah, 0, ',', '.') : '—' }}
                        </td>
                        <td class="text-end font-semibold {{ $item->saldo_berjalan >= 0 ? 'text-info' : 'text-error' }}">
                          Rp {{ number_format($item->saldo_berjalan, 0, ',', '.') }}
                        </td>
                        <td>
                          <div class="flex gap-1 justify-end">
                            <a href="{{ route('petani.editKeuangan', $item->id) }}" class="btn btn-xs btn-ghost text-warning">
                              <span class="icon-[tabler--edit] size-3.5"></span>
                            </a>
                            <form action="{{ route('petani.destroyKeuangan', $item->id) }}" method="POST"
                              onsubmit="return confirm('Hapus transaksi ini?')">
                              @csrf @method('DELETE')
                              <button type="submit" class="btn btn-xs btn-ghost text-error">
                                <span class="icon-[tabler--trash] size-3.5"></span>
                              </button>
                            </form>
                          </div>
                        </td>
                      </tr>
                    @empty
                      <tr>
                        <td colspan="6" class="text-center text-base-content/40 py-8">
                          <span class="icon-[tabler--inbox] size-8 mx-auto block mb-2"></span>
                          Belum ada transaksi. <a href="{{ route('petani.createKeuangan') }}"
                            class="text-primary underline">Tambah sekarang</a>
                        </td>
                      </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>
              @if ($transaksi->hasPages())
                <div class="p-4">
                  {{ $transaksi->links() }}
                </div>
              @endif
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
@endsection
