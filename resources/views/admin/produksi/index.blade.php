@extends('layouts.app')
@section('title', 'Produksi')

@section('content')
  <div class="container mx-auto min-h-screen flex flex-col items-start justify-start">

    <div class="w-full mt-32">
      {{-- Header --}}
      <div class="card-header p-5 woodImage">
        <h1 class="text-3xl font-bold text-slate-100 mb-1">Produksi</h1>
        <span class="text-slate-200 font-medium">Data Produksi Petani</span>
      </div>

      {{-- Stat Cards --}}
      <div class="grid grid-cols-2 lg:grid-cols-4 gap-0 w-full mb-6">
        <div class="rounded bg-base-200 p-4">
          <p class="text-sm text-base-content/60 mb-1">
            <i class="ti ti-truck"></i>
            <span>Total Produksi</span>
          </p>
          <p class="text-2xl font-semibold">142 ton</p>
          <p class="text-xs text-base-content/40 mt-1">Periode ini</p>
        </div>

        <div class="rounded bg-base-200 p-4">
          <p class="text-sm text-base-content/60 mb-1">
            <i class="ti ti-users-group"></i>
            <span>Jumlah Petani</span>
          </p>
          <p class="text-2xl font-semibold">38</p>
          <p class="text-xs text-base-content/40 mt-1">Terdaftar aktif</p>
        </div>

        <div class="rounded bg-base-200 p-4">
          <p class="text-sm text-base-content/60 mb-1">
            <i class="ti ti-file-invoice"></i>
            <span>Rata-rata/Petani</span>
          </p>
          <p class="text-2xl font-semibold">3.7 ton</p>
          <p class="text-xs text-base-content/40 mt-1">Per periode</p>
        </div>

        <div class="rounded bg-base-200 p-4">
          <p class="text-sm text-base-content/60 mb-1">
            <i class="ti ti-clock-24"></i>
            <span>Terakhir Diperbarui</span>
          </p>
          <p class="text-lg font-semibold mt-1">{{ now()->format('d M Y') }}</p>
          <p class="text-xs text-base-content/40 mt-1">Hari ini</p>
        </div>
      </div>

      {{-- Tabel Card --}}
      <div class="card bg-base-100 border border-base-content/10 w-full">
        <div class="card-body">
          <div class="flex items-center justify-between mb-4">
            <h2 class="card-title text-base">Data Produksi Petani (Kilogram)</h2>

            <a href="{{ route('produksi.create') }}" class="btn btn-sm greenImage">
              <i class="ti ti-plus"></i>
              <span>Tambah Data</span>
            </a>
          </div>

          <div class="overflow-x-auto">
            <table class="table">
              <thead>
                <tr>
                  <th>No.</th>
                  <th>Hasil Panen</th>
                  <th>Konsumsi Sendiri</th>
                  <th>Padi Terjual</th>
                  <th>Beras Terjual</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($produksis as $item)
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->hasil_panen }}</td>
                    <td>{{ $item->konsumsi_sendiri }}</td>
                    <td>{{ $item->padi_terjual }}</td>
                    <td>{{ $item->beras_terjual }}</td>
                    <td>
                      <a href="{{ route('produksi.edit', $item->id) }}"
                        class="btn btn-ghost btn-xs btn-circle text-warning">
                        <i class="ti ti-edit"></i>
                      </a>

                      <a href="{{ route('produksi.show', $item->id) }}" class="btn btn-ghost btn-xs btn-circle">
                        <i class="ti ti-eye"></i>
                      </a>

                      <form id="form-delete-{{ $item->id }}" action="{{ route('produksi.destroy', $item->id) }}"
                        method="POST" class="inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="button" onclick="confirmDelete('form-delete-{{ $item->id }}')"
                          class="btn btn-ghost btn-xs btn-circle text-error">
                          <i class="ti ti-trash"></i>
                        </button>
                      </form>

                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="7" class="text-center text-base-content/40 py-8">
                      Belum ada data produksi.
                    </td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('js')
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    function confirmDelete(formId) {
      Swal.fire({
        title: 'Hapus Data?',
        text: 'Data yang dihapus tidak dapat dikembalikan!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#e3342f',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal',
      }).then((result) => {
        if (result.isConfirmed) {
          document.getElementById(formId).submit();
        }
      });
    }
  </script>
@endpush
