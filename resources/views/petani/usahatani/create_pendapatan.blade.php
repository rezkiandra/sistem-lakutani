{{-- resources/views/usahatani/pendapatan_create.blade.php --}}
@extends('layouts.app')

@section('title', 'Input Pendapatan')

@section('content')
  <div class="container mx-auto min-h-screen flex flex-col items-center justify-start px-2 sm:px-4">
    <div class="w-full max-w-6xl mt-20 lg:mt-10 md:mt-20 mb-10">
      <div class="card bg-base-200 shadow-xl overflow-hidden">
        
        <div class="card-header woodImage p-4 md:p-5">
          <h1 class="text-2xl md:text-3xl font-bold text-slate-100 mb-1">💰 Input Pendapatan</h1>
          <span class="text-xs md:text-sm text-slate-100 block">Langkah 2 dari 3 — isi data harga jual dan hasil samping</span>
        </div>

        {{-- Step Indicator --}}
        <div class="w-full overflow-x-auto border-b border-base-content/10">
          <ol class="mb-0 flex items-center gap-2 p-4 md:p-5 min-w-[400px]">
            <li class="flex items-center gap-2 shrink-0">
              <span class="btn flex size-7 items-center justify-center rounded-full bg-base-200 text-xs font-bold text-base-content/40">1</span>
              <span class="text-sm text-base-content/40">Produksi</span>
            </li>
            <li class="h-px flex-1 bg-base-content/20"></li>
            <li class="flex items-center gap-2 shrink-0">
              <span class="btn flex size-7 items-center justify-center rounded-full bg-dark text-xs font-bold text-dark-content">2</span>
              <span class="text-sm font-semibold text-dark">Pendapatan</span>
            </li>
            <li class="h-px flex-1 bg-base-content/20"></li>
            <li class="flex items-center gap-2 shrink-0">
              <span class="btn flex size-7 items-center justify-center rounded-full bg-base-200 text-xs font-bold text-base-content/40">3</span>
              <span class="text-sm text-base-content/40">Laba / Rugi</span>
            </li>
          </ol>
        </div>

        <div class="card-body p-4 md:p-6">
          @if ($errors->any())
            <div class="alert alert-error mb-4 text-sm">
              <ul class="list-disc list-inside">
                @foreach ($errors->all() as $e)
                  <li>{{ $e }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          <form action="{{ route('petani.storePendapatan', $produksi->id) }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">

              {{-- Kolom Kiri: Data Produksi Referensi --}}
              <div class="card bg-base-100 shadow-md h-fit">
                <div class="card-body p-0">
                  <div class="flex items-center gap-2 border-b border-base-content/10 px-4 py-3">
                    <span class="icon-[tabler--box] text-secondary size-5"></span>
                    <h3 class="font-semibold text-sm md:text-base">Data Produksi (Referensi)</h3>
                  </div>
                  <div class="w-full overflow-x-auto">
                    <table class="table table-sm w-full min-w-[280px]">
                      <thead>
                        <tr>
                          <th>Jenis</th>
                          <th class="text-end">Jumlah</th>
                          <th>Unit</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td class="text-xs sm:text-sm">Hasil Panen Padi</td>
                          <td class="text-end font-semibold text-xs sm:text-sm">
                            {{ number_format($produksi->hasil_panen_padi_kg, 0, ',', '.') }}</td>
                          <td class="text-xs sm:text-sm">kg</td>
                        </tr>
                        <tr>
                          <td colspan="3" class="bg-base-200/40 py-1">
                            <span class="text-[11px] font-bold uppercase tracking-wider text-base-content/50">Alokasi</span>
                          </td>
                        </tr>
                        @foreach ([
                          ['label' => 'Konsumsi Sendiri', 'value' => $produksi->konsumsi_sendiri_kg], 
                          ['label' => 'Zakat', 'value' => $produksi->zakat_kg], 
                          ['label' => 'Sewa Lahan', 'value' => $produksi->sewa_lahan_kg], 
                          ['label' => 'Input Usaha Tani', 'value' => $produksi->input_usaha_tani_kg], 
                          ['label' => 'Layanan Lain', 'value' => $produksi->layanan_lain_kg], 
                          ['label' => 'Lain-lain', 'value' => $produksi->lain_lain_kg]
                        ] as $row)
                          <tr>
                            <td class="ps-4 text-xs text-base-content/70">{{ $row['label'] }}</td>
                            <td class="text-end text-xs">{{ number_format($row['value'], 0, ',', '.') }}</td>
                            <td class="text-xs text-base-content/50">kg</td>
                          </tr>
                        @endforeach
                        <tr class="bg-warning/10 font-semibold">
                          <td class="text-xs sm:text-sm">Padi Terjual</td>
                          <td class="text-end text-warning font-bold text-xs sm:text-sm" id="ref_padi_terjual">
                            {{ number_format($produksi->padi_terjual_kg, 0, ',', '.') }}
                          </td>
                          <td class="text-xs sm:text-sm">kg</td>
                        </tr>
                        <tr>
                          <td class="text-xs sm:text-sm">Beras Terjual</td>
                          <td class="text-end text-xs sm:text-sm">{{ number_format($produksi->beras_terjual_kg, 0, ',', '.') }}</td>
                          <td class="text-xs sm:text-sm">kg</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>

              {{-- Kolom Kanan: Form Input Pendapatan --}}
              <div class="flex flex-col gap-4">

                {{-- Penjualan Padi --}}
                <div class="card bg-base-100 shadow-md">
                  <div class="card-body p-0">
                    <div class="flex items-center gap-2 border-b border-base-content/10 px-4 py-3">
                      <span class="icon-[tabler--wheat] text-warning size-5"></span>
                      <h3 class="font-semibold text-sm md:text-base">Penjualan Padi</h3>
                    </div>
                    
                    {{-- Di HP jadi form bertumpuk, di desktop jadi tabel --}}
                    <div class="p-4 lg:p-0 overflow-x-auto">
                      <table class="w-full block lg:table table-sm text-sm">
                        <thead class="hidden lg:table-header-group">
                          <tr class="border-b border-base-content/10">
                            <th class="py-2 px-3 text-left">Jenis</th>
                            <th class="py-2 px-3 text-center">Jumlah</th>
                            <th class="py-2 px-3 text-left">Harga / kg (Rp)</th>
                            <th class="py-2 px-3 text-left">Total</th>
                          </tr>
                        </thead>
                        <tbody class="block lg:table-row-group">
                          <tr class="flex flex-col lg:table-row gap-2 border-b border-base-content/5 pb-4 lg:pb-0">
                            <td class="lg:align-middle font-medium block lg:table-cell lg:ps-3">
                              <span class="lg:hidden text-xs text-base-content/50 block">Produk</span>
                              Padi
                            </td>
                            <td class="lg:align-middle font-bold block lg:table-cell lg:text-center">
                              <span class="lg:hidden text-xs text-base-content/50 block font-normal text-left">Jumlah yang dijual</span>
                              {{ number_format($produksi->padi_terjual_kg, 0, ',', '.') }} kg
                              <input type="hidden" id="padi_terjual_kg" value="{{ $produksi->padi_terjual_kg }}">
                            </td>
                            <td class="block lg:table-cell">
                              <span class="lg:hidden text-xs text-base-content/50 block mb-1">Harga per kg *</span>
                              <div class="input input-sm flex items-center w-full">
                                <input type="number" name="harga_padi_per_kg" id="harga_padi_per_kg" class="grow bg-transparent focus:outline-none"
                                  step="0.01" min="0" value="{{ old('harga_padi_per_kg') }}" placeholder="4500" required>
                              </div>
                              @error('harga_padi_per_kg')
                                <span class="helper-text text-error text-xs block mt-1">{{ $message }}</span>
                              @enderror
                            </td>
                            <td class="lg:align-middle font-bold text-success block lg:table-cell lg:pe-3">
                              <span class="lg:hidden text-xs text-base-content/50 block font-normal text-left">Total Penjualan</span>
                              <span id="total_penjualan_padi">Rp 0</span>
                            </td>
                          </tr>
                          <tr class="bg-base-200/50 font-semibold flex flex-row justify-between lg:table-row p-3 lg:p-0">
                            <td colspan="3" class="lg:text-end text-xs sm:text-sm lg:py-2 lg:px-3">Total Penjualan Padi</td>
                            <td class="font-bold text-success text-sm lg:py-2 lg:px-3" id="subtotal_padi">Rp 0</td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>

                {{-- Hasil Samping --}}
                <div class="card bg-base-100 shadow-md">
                  <div class="card-body p-0">
                    <div class="flex items-center gap-2 border-b border-base-content/10 px-4 py-3">
                      <span class="icon-[tabler--plant] text-success size-5"></span>
                      <h3 class="font-semibold text-sm md:text-base">Hasil Samping</h3>
                    </div>
                    
                    {{-- Di HP jadi form bertumpuk vertikal --}}
                    <div class="p-4 lg:p-0 overflow-x-auto">
                      <table class="w-full block lg:table table-sm text-sm">
                        <thead class="hidden lg:table-header-group">
                          <tr class="border-b border-base-content/10">
                            <th class="py-2 px-3 text-left">Keterangan</th>
                            <th class="py-2 px-3 text-left">Jumlah</th>
                            <th class="py-2 px-3 text-left">Harga Satuan</th>
                            <th class="py-2 px-3 text-left">Total</th>
                          </tr>
                        </thead>
                        <tbody class="block lg:table-row-group">
                          <tr class="flex flex-col lg:table-row gap-3 border-b border-base-content/5 pb-4 lg:pb-0">
                            <td class="block lg:table-cell lg:ps-2">
                              <label class="lg:hidden text-xs text-base-content/50 block mb-1">Keterangan Hasil Samping</label>
                              <input type="text" name="hasil_samping_keterangan" class="input input-sm w-full"
                                placeholder="Jerami, Dedak, dll." value="{{ old('hasil_samping_keterangan') }}" autocomplete="off">
                            </td>
                            <td class="block lg:table-cell">
                              <label class="lg:hidden text-xs text-base-content/50 block mb-1">Jumlah</label>
                              <input type="number" name="hasil_samping_jumlah" id="hasil_samping_jumlah"
                                class="input input-sm w-full" step="0.01" min="0" value="{{ old('hasil_samping_jumlah', 0) }}">
                            </td>
                            <td class="block lg:table-cell">
                              <label class="lg:hidden text-xs text-base-content/50 block mb-1">Harga Satuan (Rp)</label>
                              <input type="number" name="hasil_samping_harga" id="hasil_samping_harga"
                                class="input input-sm w-full" step="0.01" min="0" value="{{ old('hasil_samping_harga', 0) }}">
                            </td>
                            <td class="lg:align-middle font-bold text-success block lg:table-cell lg:pe-2">
                              <label class="lg:hidden text-xs text-base-content/50 block font-normal">Total</label>
                              <span id="total_hasil_samping">Rp 0</span>
                            </td>
                          </tr>
                          <tr class="bg-base-200/50 font-semibold flex flex-row justify-between lg:table-row p-3 lg:p-0">
                            <td colspan="3" class="lg:text-end text-xs sm:text-sm lg:py-2 lg:px-3">Total Hasil Samping</td>
                            <td class="font-bold text-success text-sm lg:py-2 lg:px-3" id="subtotal_samping">Rp 0</td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>

              </div>{{-- end kolom kanan --}}

              {{-- Ringkasan Pendapatan (full width) --}}
              <div class="card bg-base-100 shadow-md lg:col-span-2">
                <div class="card-body p-0">
                  <div class="flex items-center gap-2 border-b border-base-content/10 px-4 py-3">
                    <span class="icon-[tabler--chart-bar] text-info size-5"></span>
                    <h3 class="font-semibold text-sm md:text-base">Ringkasan Pendapatan</h3>
                  </div>
                  <div class="p-4">
                    <div class="rounded-lg bg-base-200/60 p-3 text-xs md:text-sm">
                      <div class="flex justify-between text-base-content/60">
                        <span>Total Penjualan Padi</span>
                        <span id="ring_padi" class="font-medium">Rp 0</span>
                      </div>
                      <div class="flex justify-between text-base-content/60 mt-1">
                        <span>Total Hasil Samping</span>
                        <span id="ring_samping" class="font-medium">Rp 0</span>
                      </div>
                      <div class="divider my-1.5"></div>
                      <div class="flex justify-between font-semibold text-sm md:text-base">
                        <span>Total Pendapatan</span>
                        <span id="ring_total" class="text-success">Rp 0</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

            </div>{{-- end grid --}}

            {{-- Tombol Navigasi Bawah --}}
            <div class="flex flex-col sm:flex-row items-center justify-between mt-6 gap-3">
              <a href="{{ route('petani.createProduksi') }}" class="btn w-full sm:w-1/2 order-2 sm:order-1">← Kembali</a>
              <button type="submit" class="btn w-full sm:w-1/2 greenImage order-1 sm:order-2">Simpan & Lanjutkan</button>
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

    function hitung() {
      const padiKg = parseFloat(document.getElementById('padi_terjual_kg').value) || 0;
      const hargaPadi = parseFloat(document.getElementById('harga_padi_per_kg').value) || 0;
      const sampingJml = parseFloat(document.getElementById('hasil_samping_jumlah').value) || 0;
      const sampingHrg = parseFloat(document.getElementById('hasil_samping_harga').value) || 0;

      const totalPadi = padiKg * hargaPadi;
      const totalSamping = sampingJml * sampingHrg;
      const grandTotal = totalPadi + totalSamping;

      document.getElementById('total_penjualan_padi').textContent = formatRp(totalPadi);
      document.getElementById('subtotal_padi').textContent = formatRp(totalPadi);
      document.getElementById('total_hasil_samping').textContent = formatRp(totalSamping);
      document.getElementById('subtotal_samping').textContent = formatRp(totalSamping);
      document.getElementById('ring_padi').textContent = formatRp(totalPadi);
      document.getElementById('ring_samping').textContent = formatRp(totalSamping);
      document.getElementById('ring_total').textContent = formatRp(grandTotal);
    }

    ['harga_padi_per_kg', 'hasil_samping_jumlah', 'hasil_samping_harga'].forEach(id => {
      document.getElementById(id)?.addEventListener('input', hitung);
    });

    hitung();
  </script>
@endpush