@extends('layouts.app')
@section('title', 'Input Transaksi')

@section('content')
  <div class="container mx-auto min-h-screen flex flex-col items-center justify-start">
    <div class="w-3/4 mt-20 mb-10">
      <div class="card bg-base-200">
        <div class="card-header woodImage p-5">
          <div class="flex items-center justify-between">
            <div>
              <h1 class="text-3xl font-bold text-slate-100 mb-1">➕ Tambah Transaksi</h1>
              <span class="text-sm text-slate-100">Catat pemasukan atau pengeluaran usaha tani</span>
            </div>
            <a href="{{ route('petani.catatKeuangan') }}" class="btn btn-sm btn-ghost text-slate-100">
              <span class="ti ti-arrow-left size-4"></span>
              Kembali
            </a>
          </div>
        </div>

        <div class="card-body">

          @if ($errors->any())
            <div class="alert alert-error mb-4">
              <ul class="list-disc list-inside">
                @foreach ($errors->all() as $e)
                  <li>{{ $e }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          <form action="{{ route('petani.storeKeuangan') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 gap-3 lg:grid-cols-2">

              {{-- Tanggal & Jenis --}}
              <div class="card bg-base-100 shadow-md">
                <div class="card-body p-0">
                  <div class="flex items-center gap-2 border-b border-base-content/10 px-4 py-3">
                    <span class="icon-[tabler--calendar] text-primary size-5"></span>
                    <h3 class="font-semibold">Waktu & Jenis</h3>
                  </div>
                  <div class="p-4 flex flex-col gap-4">

                    {{-- Tanggal --}}
                    <div>
                      <label class="label-text mb-1" for="tanggal">
                        Tanggal <span class="text-error">*</span>
                      </label>
                      <div class="input flex items-center">
                        <span class="icon-[tabler--calendar] text-base-content/40 size-4 shrink-0"></span>
                        <input type="date" name="tanggal" id="tanggal" class="grow"
                          value="{{ old('tanggal', date('Y-m-d')) }}" required>
                      </div>
                      @error('tanggal')
                        <span class="helper-text text-error">{{ $message }}</span>
                      @enderror
                    </div>

                    {{-- Jenis --}}
                    <div>
                      <label class="label-text mb-1">
                        Jenis Transaksi <span class="text-error">*</span>
                      </label>
                      <div class="grid grid-cols-2 gap-2 mt-1">
                        <label class="cursor-pointer">
                          <input type="radio" name="jenis" value="pemasukan" class="peer sr-only"
                            {{ old('jenis', 'pemasukan') === 'pemasukan' ? 'checked' : '' }} required>
                          <div
                            class="flex items-center justify-center gap-2 rounded-lg border-2 border-base-content/10 p-3
                            peer-checked:border-success peer-checked:bg-success/10 transition">
                            <span class="icon-[tabler--arrow-down-circle] text-success size-5"></span>
                            <span class="font-medium text-sm">Pemasukan</span>
                          </div>
                        </label>
                        <label class="cursor-pointer">
                          <input type="radio" name="jenis" value="pengeluaran" class="peer sr-only"
                            {{ old('jenis') === 'pengeluaran' ? 'checked' : '' }}>
                          <div
                            class="flex items-center justify-center gap-2 rounded-lg border-2 border-base-content/10 p-3
                            peer-checked:border-error peer-checked:bg-error/10 transition">
                            <span class="icon-[tabler--arrow-up-circle] text-error size-5"></span>
                            <span class="font-medium text-sm">Pengeluaran</span>
                          </div>
                        </label>
                      </div>
                      @error('jenis')
                        <span class="helper-text text-error">{{ $message }}</span>
                      @enderror
                    </div>

                  </div>
                </div>
              </div>

              {{-- Detail Transaksi --}}
              <div class="card bg-base-100 shadow-md">
                <div class="card-body p-0">
                  <div class="flex items-center gap-2 border-b border-base-content/10 px-4 py-3">
                    <span class="icon-[tabler--receipt] text-warning size-5"></span>
                    <h3 class="font-semibold">Detail Transaksi</h3>
                  </div>
                  <div class="p-4 flex flex-col gap-4">

                    {{-- Kategori --}}
                    <div>
                      <label class="label-text mb-1" for="kategori">
                        Kategori <span class="text-error">*</span>
                      </label>
                      <div class="input flex items-center">
                        <span class="icon-[tabler--tag] text-base-content/40 size-4 shrink-0"></span>
                        <input type="text" name="kategori" id="kategori" class="grow" value="{{ old('kategori') }}"
                          placeholder="Contoh: Penjualan Padi, Pupuk, Biaya Pekerja..." autocomplete="off" required>
                      </div>
                      @error('kategori')
                        <span class="helper-text text-error">{{ $message }}</span>
                      @enderror
                    </div>

                    {{-- Jumlah --}}
                    <div>
                      <label class="label-text mb-1" for="jumlah">
                        Jumlah <span class="text-error">*</span>
                      </label>
                      <div class="input flex items-center">
                        <span class="text-base-content/50 text-sm shrink-0 me-1">Rp</span>
                        <input type="number" name="jumlah" id="jumlah" class="grow" step="0.01" min="0"
                          value="{{ old('jumlah') }}" placeholder="0" required>
                      </div>
                      @error('jumlah')
                        <span class="helper-text text-error">{{ $message }}</span>
                      @enderror
                    </div>

                    {{-- Keterangan --}}
                    <div>
                      <label class="label-text mb-1" for="keterangan">
                        Keterangan
                        <span class="badge badge-soft badge-ghost text-xs ms-1">Opsional</span>
                      </label>
                      <textarea name="keterangan" id="keterangan" class="textarea w-full" rows="2" placeholder="Catatan tambahan...">{{ old('keterangan') }}</textarea>
                    </div>

                  </div>
                </div>
              </div>

              {{-- Preview Nominal --}}
              <div class="card bg-base-100 shadow-md lg:col-span-2">
                <div class="card-body p-0">
                  <div class="flex items-center gap-2 border-b border-base-content/10 px-4 py-3">
                    <span class="icon-[tabler--eye] text-info size-5"></span>
                    <h3 class="font-semibold">Preview</h3>
                  </div>
                  <div class="p-4">
                    <div class="rounded-lg bg-base-200/60 p-3 text-sm">
                      <div class="flex justify-between font-semibold">
                        <span id="preview_label" class="text-base-content/60">Nominal Transaksi</span>
                        <span id="preview_nominal" class="text-base-content/40 text-base">Rp 0</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

            </div>{{-- end grid --}}

            <div class="flex items-center justify-between mt-3 gap-2">
              <a href="{{ route('petani.catatKeuangan') }}" class="btn w-1/2">
                <span class="icon-[tabler--arrow-left] size-4"></span>
                Kembali
              </a>
              <button type="submit" class="btn w-1/2 greenImage">
                <span class="icon-[tabler--device-floppy] size-4"></span>
                Simpan Transaksi
              </button>
            </div>

          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('js')
  <script>
    function formatRp(angka) {
      return 'Rp ' + new Intl.NumberFormat('id-ID').format(Math.round(angka));
    }

    function updatePreview() {
      const jumlah = parseFloat(document.getElementById('jumlah').value) || 0;
      const jenis = document.querySelector('input[name="jenis"]:checked')?.value || 'pemasukan';
      const label = document.getElementById('preview_label');
      const nominal = document.getElementById('preview_nominal');

      label.textContent = jenis === 'pemasukan' ? '↓ Pemasukan' : '↑ Pengeluaran';
      nominal.textContent = formatRp(jumlah);
      nominal.className = jenis === 'pemasukan' ?
        'font-bold text-success text-base' :
        'font-bold text-error text-base';
    }

    document.getElementById('jumlah')?.addEventListener('input', updatePreview);
    document.querySelectorAll('input[name="jenis"]').forEach(el => el.addEventListener('change', updatePreview));

    updatePreview();
  </script>
@endpush
