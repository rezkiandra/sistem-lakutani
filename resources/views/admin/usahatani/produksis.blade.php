@extends('layouts.app')
@section('title', 'Daftar Produksi Usaha Tani')

@section('content')
  <div class="container mx-auto min-h-screen flex flex-col items-center justify-start px-2 sm:px-4">
    <div class="w-full max-w-6xl mt-20 lg:mt-30 md:mt-30 mb-10">
      <div class="card bg-base-200 shadow-xl overflow-hidden">

        <div class="card-header woodImage p-4 md:p-5">
          <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
              <h1 class="text-2xl md:text-3xl font-bold text-slate-100 mb-1">🌾 Daftar Produksi Usaha Tani</h1>
              <span class="text-xs md:text-sm text-slate-100 block">Riwayat rekapan hasil panen serta distribusi alokasi
                komoditas padi</span>
            </div>
            {{-- <a href="{{ route('petani.createProduksi') }}"
              class="btn btn-sm greenImage text-slate-100 self-start sm:self-center border-none">
              <i class="ti ti-plus"></i> Input Baru
            </a> --}}
          </div>
        </div>

        <div class="card-body p-0">
          <div class="w-full overflow-x-auto">
            <table class="table table-md w-full min-w-[750px]">
              <thead>
                <tr class="bg-base-100/80">
                  <th class="w-12 text-center">No</th>
                  <th>Tanggal Rekap</th>
                  <th>Petani</th>
                  <th class="text-end">Total Panen</th>
                  <th class="text-end">Padi Terjual</th>
                </tr>
              </thead>
              <tbody>
                @forelse($produksis as $index => $produksi)
                  @php
                    // Ambil string enkripsi sekali saja agar performa render lebih cepat
                    $encryptedId = Crypt::encryptString($produksi->id);
                  @endphp
                  <tr class="hover:bg-base-100/50 transition-all">
                    <td class="text-center font-medium text-xs sm:text-sm">{{ $produksis->firstItem() + $index }}</td>
                    <td class="font-semibold text-xs sm:text-sm">
                      {{ $produksi->created_at?->translatedFormat('d M Y') ?? '-' }}</td>
                    <td>
                      <div class="flex items-center gap-2">
                        <div class="avatar avatar-placeholder shrink-0">
                          <div class="bg-primary/20 text-primary rounded-full size-7 text-xs font-bold">
                            {{ strtoupper(substr($produksi->user->name, 0, 2)) }}
                          </div>
                        </div>
                        <span class="text-sm font-medium whitespace-nowrap">{{ $produksi->user->name }}</span>
                      </div>
                    </td>
                    <td class="text-end text-xs sm:text-sm text-orange-600 font-bold">
                      {{ number_format($produksi->hasil_panen_padi_kg ?? 0, 0, ',', '.') }} kg</td>
                    <td class="text-end text-xs sm:text-sm text-blue-600 font-bold">
                      {{ number_format($produksi->padi_terjual_kg ?? 0, 0, ',', '.') }} kg</td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="5" class="text-center py-10 text-base-content/50 text-sm">Belum ada riwayat data
                      produksi.</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
          @if ($produksis->hasPages())
            <div class="p-4 border-t border-base-content/10 flex justify-center bg-base-100/20">{{ $produksis->links() }}
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
