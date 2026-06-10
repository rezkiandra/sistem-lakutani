@extends('layouts.app')
@section('title', 'Edit Transaksi')

@section('content')
  {{-- Menambahkan px-4 agar ada jarak aman di sisi kiri-kanan layar HP --}}
  <div class="container mx-auto min-h-screen flex flex-col items-center justify-start px-4">
    {{-- Mengubah w-3/4 menjadi w-full max-w-4xl agar proporsional di semua perangkat --}}
    <div class="w-full max-w-4xl mt-6 md:mt-20 mb-10">
      <div class="card bg-base-200 shadow-xl overflow-hidden border border-base-content/5">

        {{-- ===== HEADER CARD ===== --}}
        <div class="card-header woodImage p-4 md:p-5">
          {{-- Berubah menjadi flex-col di HP dan sm:flex-row di tablet ke atas --}}
          <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
              <h1 class="text-2xl md:text-3xl font-bold text-slate-100 mb-1">✏️ Edit Transaksi</h1>
              <span class="text-xs md:text-sm text-slate-100 block">Perbarui data transaksi keuangan</span>
            </div>
            {{-- Tombol kembali menyesuaikan lebar penuh di HP --}}
            <a href="{{ route('petani.catatKeuangan') }}"
              class="btn btn-sm btn-ghost text-slate-100 justify-center w-full sm:w-auto">
              <span class="ti ti-arrow-left size-4"></span>
              Kembali
            </a>
          </div>
        </div>

        {{-- ===== BODY FORM ===== --}}
        {{-- Mengurangi padding bawaan di HP (p-4) dan kembali normal di desktop (md:p-6) --}}
        <div class="card-body p-4 md:p-6">

          @if ($errors->any())
            <div class="alert alert-error mb-4 shadow-sm">
              <ul class="list-disc list-inside text-sm">
                @foreach ($errors->all() as $e)
                  <li>{{ $e }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          <form action="{{ route('petani.updateKeuangan', $keuangan->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Grid beralih otomatis dari 1 kolom di HP menjadi 2 kolom di layar komputer (lg:grid-cols-2) --}}
            <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">

              {{-- ----- SISI KIRI: Tanggal & Jenis ----- --}}
              <div class="card bg-base-100 shadow-sm border border-base-content/5">
                <div class="card-body p-0">
                  <div class="flex items-center gap-2 border-b border-base-content/10 px-4 py-3">
                    <span class="icon-[tabler--calendar] text-primary size-5"></span>
                    <h3 class="font-semibold text-sm md:text-base">Waktu & Jenis</h3>
                  </div>
                  <div class="p-4 flex flex-col gap-4">

                    {{-- Input Tanggal --}}
                    <div class="form-control w-full">
                      <label class="label-text mb-1.5 font-medium" for="tanggal">
                        Tanggal <span class="text-error">*</span>
                      </label>
                      <div
                        class="input flex items-center w-full border border-base-content/20 focus-within:border-primary">
                        <span class="icon-[tabler--calendar] text-base-content/40 size-4 shrink-0"></span>
                        <input type="date" name="tanggal" id="tanggal" class="grow bg-transparent px-2"
                          value="{{ old('tanggal', \Carbon\Carbon::parse($keuangan->tanggal)->format('Y-m-d')) }}"
                          required>
                      </div>
                      @error('tanggal')
                        <span class="helper-text text-error text-xs mt-1">{{ $message }}</span>
                      @enderror
                    </div>

                    {{-- Radio Pilihan Jenis Transaksi --}}
                    <div class="form-control w-full">
                      <label class="label-text mb-1.5 font-medium">
                        Jenis Transaksi <span class="text-error">*</span>
                      </label>
                      {{-- Jika di layar HP sangat kecil (xs), tumpuk pilihan tombol agar tidak berhimpitan --}}
                      <div class="grid grid-cols-1 xs:grid-cols-2 gap-2 mt-1">
                        <label class="cursor-pointer">
                          <input type="radio" name="jenis" value="pemasukan" class="peer sr-only"
                            {{ old('jenis', $keuangan->jenis) === 'pemasukan' ? 'checked' : '' }} required>
                          <div
                            class="flex items-center justify-center gap-2 rounded-lg border-2 border-base-content/10 p-3
                            peer-checked:border-success peer-checked:bg-success/10 transition active:scale-95">
                            <span class="icon-[tabler--arrow-down-circle] text-success size-5"></span>
                            <span class="font-semibold text-sm">Pemasukan</span>
                          </div>
                        </label>
                        <label class="cursor-pointer">
                          <input type="radio" name="jenis" value="pengeluaran" class="peer sr-only"
                            {{ old('jenis', $keuangan->jenis) === 'pengeluaran' ? 'checked' : '' }}>
                          <div
                            class="flex items-center justify-center gap-2 rounded-lg border-2 border-base-content/10 p-3
                            peer-checked:border-error peer-checked:bg-error/10 transition active:scale-95">
                            <span class="icon-[tabler--arrow-up-circle] text-error size-5"></span>
                            <span class="font-semibold text-sm">Pengeluaran</span>
                          </div>
                        </label>
                      </div>
                      @error('jenis')
                        <span class="helper-text text-error text-xs mt-1">{{ $message }}</span>
                      @enderror
                    </div>

                  </div>
                </div>
              </div>

              {{-- ----- SISI KANAN: Detail Transaksi ----- --}}
              <div class="card bg-base-100 shadow-sm border border-base-content/5">
                <div class="card-body p-0">
                  <div class="flex items-center gap-2 border-b border-base-content/10 px-4 py-3">
                    <span class="icon-[tabler--receipt] text-warning size-5"></span>
                    <h3 class="font-semibold text-sm md:text-base">Detail Transaksi</h3>
                  </div>
                  <div class="p-4 flex flex-col gap-4">

                    {{-- Input Kategori --}}
                    <div class="form-control w-full">
                      <label class="label-text mb-1.5 font-medium" for="kategori">
                        Kategori <span class="text-error">*</span>
                      </label>
                      <div class="input flex items-center w-full border border-base-content/20">
                        <span class="icon-[tabler--tag] text-base-content/40 size-4 shrink-0"></span>
                        <input type="text" name="kategori" id="kategori" class="grow bg-transparent px-2"
                          value="{{ old('kategori', $keuangan->kategori) }}"
                          placeholder="Contoh: Penjualan Padi, Pupuk, dll" autocomplete="off" required>
                      </div>
                      @error('kategori')
                        <span class="helper-text text-error text-xs mt-1">{{ $message }}</span>
                      @enderror
                    </div>

                    {{-- Input Jumlah Nominal --}}
                    <div class="form-control w-full">
                      <label class="label-text mb-1.5 font-medium" for="jumlah">
                        Jumlah <span class="text-error">*</span>
                      </label>
                      <div class="input flex items-center w-full border border-base-content/20">
                        <span class="text-base-content/50 text-sm font-semibold shrink-0 me-1">Rp</span>
                        <input type="number" name="jumlah" id="jumlah" class="grow bg-transparent" step="0.01"
                          min="0" value="{{ old('jumlah', $keuangan->jumlah) }}" placeholder="0" required>
                      </div>
                      @error('jumlah')
                        <span class="helper-text text-error text-xs mt-1">{{ $message }}</span>
                      @enderror
                    </div>

                    {{-- Input Keterangan Opsional --}}
                    <div class="form-control w-full">
                      <label class="label-text mb-1.5 font-medium" for="keterangan">
                        Keterangan <span class="badge badge-soft badge-ghost text-[10px] ms-1">Opsional</span>
                      </label>
                      <textarea name="keterangan" id="keterangan" class="textarea textarea-bordered w-full focus:border-primary"
                        rows="2" placeholder="Catatan tambahan...">{{ old('keterangan', $keuangan->keterangan) }}</textarea>
                    </div>

                  </div>
                </div>
              </div>

              {{-- ----- PREVIEW NOMINAL (Melebar penuh di grid terbawah) ----- --}}
              <div class="card bg-base-100 shadow-sm border border-base-content/5 lg:col-span-2">
                <div class="card-body p-0">
                  <div class="flex items-center gap-2 border-b border-base-content/10 px-4 py-3">
                    <span class="icon-[tabler--eye] text-info size-5"></span>
                    <h3 class="font-semibold text-sm">Pratinjau Nominal</h3>
                  </div>
                  <div class="p-4">
                    <div class="rounded-lg bg-base-200/60 p-3 text-sm">
                      <div class="flex justify-between items-center font-semibold gap-2">
                        <span id="preview_label" class="text-base-content/60 text-xs md:text-sm">Nominal
                          Transaksi</span>
                        <span id="preview_nominal"
                          class="text-base-content/40 text-sm md:text-base break-all text-end">Rp 0</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

            </div>{{-- end grid --}}

            {{-- ===== TOMBOL AKSI (FOOTER FORM) ===== --}}
            {{-- Menggunakan fleksibilitas kolom di HP agar tombol bertumpuk rapi dan tidak terlalu kecil saat dipencet --}}
            <div class="flex flex-col sm:flex-row items-center justify-between mt-6 gap-3">
              <a href="{{ route('petani.catatKeuangan') }}" class="btn w-full sm:w-1/2 order-2 sm:order-1">
                <span class="icon-[tabler--arrow-left] size-4"></span>
                Kembali
              </a>
              <button type="submit" class="btn w-full sm:w-1/2 greenImage text-white order-1 sm:order-2">
                <span class="icon-[tabler--device-floppy] size-4"></span>
                Simpan Perubahan
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
        'font-bold text-success text-sm md:text-base break-all text-end' :
        'font-bold text-error text-sm md:text-base break-all text-end';
    }

    document.getElementById('jumlah')?.addEventListener('input', updatePreview);
    document.querySelectorAll('input[name="jenis"]').forEach(el => el.addEventListener('change', updatePreview));

    // Jalankan kalkulasi pertama kali saat halaman selesai dimuat
    updatePreview();
  </script>
@endpush
