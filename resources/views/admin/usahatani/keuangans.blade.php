@extends('layouts.app')
@section('title', 'Daftar Keuangan')

@section('content')
  <div class="container mx-auto min-h-screen flex flex-col items-center justify-start px-2 sm:px-4">
    <div class="w-full max-w-5xl mt-20 lg:mt-30 md:mt-30 mb-10">
      <div class="card bg-base-200 shadow-xl overflow-hidden">

        <div class="card-header woodImage p-4 md:p-5">
          <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
              <h1 class="text-xl lg:text-2xl md:text-3xl font-bold text-slate-100 mb-1">💰 Laporan Finansial Usaha Tani</h1>
              <span class="text-xs lg:text-xs md:text-sm text-slate-100 block">Pemantauan arus kas masuk (pendapatan) dan kalkulasi
                untung rugi bersih</span>
            </div>
          </div>
        </div>

        <div class="card-body p-0">
          <div class="w-full overflow-x-auto">
            <table class="table table-md w-full min-w-[750px]">
              <thead>
                <tr class="bg-base-100/80">
                  <th class="w-12 text-center">No</th>
                  <th>Petani</th>
                  <th>Tanggal Catat</th>
                  <th class="text-end">Total Pemasukan</th>
                  <th class="text-end">Total Pengeluaran</th>
                  <th class="text-end">Hasil Bersih</th>
                  {{-- <th class="w-28 text-center">Aksi</th> --}}
                </tr>
              </thead>
              <tbody>
                @forelse($keuangans as $index => $keuangan)
                  @php
                    // Logika menentukan apakah baris ini uang masuk atau uang keluar
                    // Sesuaikan string 'pemasukan'/'pengeluaran' dengan isi data di database kamu
                    $isMasuk = in_array(strtolower($keuangan->jenis), ['pemasukan', 'pendapatan', 'masuk']);

                    $pemasukan = $isMasuk ? $keuangan->jumlah : 0;
                    $pengeluaran = !$isMasuk ? $keuangan->jumlah : 0;

                    $namaPetani = $keuangan->user->name ?? 'Tidak Diketahui';
                  @endphp
                  <tr class="hover:bg-base-100/50 transition-all">
                    <td class="text-center font-medium text-xs sm:text-sm">{{ $keuangans->firstItem() + $index }}</td>

                    <td>
                      <div class="flex items-center gap-2">
                        <div class="avatar avatar-placeholder shrink-0">
                          <div class="bg-primary/20 text-primary rounded-full size-7 text-xs font-bold">
                            {{ strtoupper(substr($keuangan->user->name, 0, 2)) }}
                          </div>
                        </div>
                        <div>
                          <span class="font-semibold text-xs sm:text-sm block text-slate-800">{{ $namaPetani }}</span>
                          <span
                            class="text-[10px] text-slate-400 block -mt-0.5">{{ $keuangan->kategori ?? 'Umum' }}</span>
                        </div>
                      </div>
                    </td>

                    <td class="font-semibold text-xs sm:text-sm">
                      {{ \Carbon\Carbon::parse($keuangan->tanggal ?? $keuangan->created_at)->translatedFormat('d M Y') }}
                    </td>

                    <td class="text-end text-xs sm:text-sm text-emerald-600 font-semibold">
                      {{ $pemasukan > 0 ? 'Rp ' . number_format($pemasukan, 0, ',', '.') : '-' }}
                    </td>

                    <td class="text-end text-xs sm:text-sm text-rose-600 font-semibold">
                      {{ $pengeluaran > 0 ? 'Rp ' . number_format($pengeluaran, 0, ',', '.') : '-' }}
                    </td>

                    <td class="text-end text-xs sm:text-sm font-bold text-slate-700">
                      Rp {{ number_format($keuangan->saldo_berjalan ?? 0, 0, ',', '.') }}
                      <span class="text-[10px] block font-normal opacity-60">{{ $keuangan->keterangan ?? '-' }}</span>
                    </td>

                    {{-- <td class="text-center">
                      <div class="flex items-center justify-center gap-1">
                        <button type="button"
                          onclick="konfirmasiHapus(event, 'form-delete-keuangan-{{ $keuangan->id }}', 'Data Keuangan Tanggal {{ $keuangan->tanggal }}')"
                          class="btn btn-square btn-sm btn-ghost text-error" title="Hapus">
                          <i class="ti ti-trash text-lg"></i>
                        </button>

                        <form id="form-delete-keuangan-{{ $keuangan->id }}"
                          action="{{ route('petani.keuangan.destroy', $keuangan->id) }}" method="POST" class="hidden">
                          @csrf @method('DELETE')
                        </form>
                      </div>
                    </td> --}}
                  </tr>
                @empty
                  <tr>
                    <td colspan="7" class="text-center py-10 text-base-content/50 text-sm">Belum ada data keuangan.
                    </td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
          @if ($keuangans->hasPages())
            <div class="p-4 border-t border-base-content/10 flex justify-center bg-base-100/20">{{ $keuangans->links() }}
            </div>
          @endif
        </div>

      </div>
    </div>
  </div>
@endsection

@push('js')
  @include('partials.sweetalert-delete')
@endpush
