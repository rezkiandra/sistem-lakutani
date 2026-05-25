{{-- resources/views/usahatani/pendapatan_create.blade.php --}}
@extends('layouts.app')

@section('title', 'Input Pendapatan')

@section('content')
  <div class="container mx-auto min-h-screen flex flex-col items-center justify-start">
    <div class="w-3/4 mt-20">
      <div class="card bg-base-200">
        <div class="card-header woodImage p-5">
          <h1 class="text-3xl font-bold text-slate-100 mb-1">💰 Input Pendapatan</h1>
          <span class="text-sm text-slate-100">Langkah 2 dari 3 — isi data harga jual dan hasil samping</span>
        </div>

        {{-- Step Indicator --}}
        <ol class="mb-0 flex items-center gap-2 p-5">
          <li class="flex items-center gap-2">
            <span
              class="btn flex size-7 items-center justify-center rounded-full bg-base-200 text-xs font-bold text-base-content/40">1</span>
            <span class="text-sm text-base-content/40">Produksi</span>
          </li>
          <li class="h-px flex-1 bg-base-content/20"></li>
          <li class="flex items-center gap-2">
            <span
              class="btn flex size-7 items-center justify-center rounded-full bg-dark text-xs font-bold text-dark-content">2</span>
            <span class="text-sm font-semibold text-dark">Pendapatan</span>
          </li>
          <li class="h-px flex-1 bg-base-content/20"></li>
          <li class="flex items-center gap-2">
            <span
              class="btn flex size-7 items-center justify-center rounded-full bg-base-200 text-xs font-bold text-base-content/40">3</span>
            <span class="text-sm text-base-content/40">Laba / Rugi</span>
          </li>
        </ol>

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

          <form action="{{ route('storePendapatan', $produksi->id) }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 gap-3 lg:grid-cols-2">

              {{-- Kolom Kiri: Data Produksi Referensi --}}
              <div class="card bg-base-100 shadow-md">
                <div class="card-body p-0">
                  <div class="flex items-center gap-2 border-b border-base-content/10 px-4 py-3">
                    <span class="icon-[tabler--box] text-secondary size-5"></span>
                    <h3 class="font-semibold">Data Produksi (Referensi)</h3>
                  </div>
                  <div class="overflow-x-auto">
                    <table class="table table-sm">
                      <thead>
                        <tr>
                          <th>Jenis</th>
                          <th class="text-end">Jumlah</th>
                          <th>Unit</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>Hasil Panen Padi</td>
                          <td class="text-end font-semibold">
                            {{ number_format($produksi->hasil_panen_padi_kg, 0, ',', '.') }}</td>
                          <td>kg</td>
                        </tr>
                        <tr>
                          <td colspan="3">
                            <span class="text-xs font-semibold text-base-content/50">Alokasi</span>
                          </td>
                        </tr>
                        @foreach ([['label' => 'Konsumsi Sendiri', 'value' => $produksi->konsumsi_sendiri_kg], ['label' => 'Zakat', 'value' => $produksi->zakat_kg], ['label' => 'Sewa Lahan', 'value' => $produksi->sewa_lahan_kg], ['label' => 'Input Usaha Tani', 'value' => $produksi->input_usaha_tani_kg], ['label' => 'Layanan Lain', 'value' => $produksi->layanan_lain_kg], ['label' => 'Lain-lain', 'value' => $produksi->lain_lain_kg]] as $row)
                          <tr>
                            <td class="ps-4 text-sm text-base-content/70">{{ $row['label'] }}</td>
                            <td class="text-end">{{ number_format($row['value'], 0, ',', '.') }}</td>
                            <td>kg</td>
                          </tr>
                        @endforeach
                        <tr class="bg-warning/10 font-semibold">
                          <td>Padi Terjual</td>
                          <td class="text-end text-warning font-bold" id="ref_padi_terjual">
                            {{ number_format($produksi->padi_terjual_kg, 0, ',', '.') }}
                          </td>
                          <td>kg</td>
                        </tr>
                        <tr>
                          <td>Beras Terjual</td>
                          <td class="text-end">{{ number_format($produksi->beras_terjual_kg, 0, ',', '.') }}</td>
                          <td>kg</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>

              {{-- Kolom Kanan: Form Input Pendapatan --}}
              <div class="flex flex-col gap-3">

                {{-- Penjualan Padi --}}
                <div class="card bg-base-100 shadow-md">
                  <div class="card-body p-0">
                    <div class="flex items-center gap-2 border-b border-base-content/10 px-4 py-3">
                      <span class="icon-[tabler--wheat] text-warning size-5"></span>
                      <h3 class="font-semibold">Penjualan Padi</h3>
                    </div>
                    <div class="overflow-x-auto">
                      <table class="table table-sm">
                        <thead>
                          <tr>
                            <th>Jenis</th>
                            <th>Jumlah (kg)</th>
                            <th>Harga / kg (Rp)</th>
                            <th>Total (Rp)</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td class="align-middle font-medium">Padi</td>
                            <td class="align-middle font-bold text-center">
                              {{ number_format($produksi->padi_terjual_kg, 0, ',', '.') }}
                              <input type="hidden" id="padi_terjual_kg" value="{{ $produksi->padi_terjual_kg }}">
                            </td>
                            <td>
                              <div class="input input-sm flex items-center">
                                <input type="number" name="harga_padi_per_kg" id="harga_padi_per_kg" class="grow"
                                  step="0.01" min="0" value="{{ old('harga_padi_per_kg') }}" placeholder="4500"
                                  required>
                              </div>
                              @error('harga_padi_per_kg')
                                <span class="helper-text text-error">{{ $message }}</span>
                              @enderror
                            </td>
                            <td class="align-middle font-bold text-success" id="total_penjualan_padi">Rp 0</td>
                          </tr>
                          <tr class="bg-base-200/50 font-semibold">
                            <td colspan="3" class="text-end text-sm">Total Penjualan Padi</td>
                            <td class="font-bold text-success" id="subtotal_padi">Rp 0</td>
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
                      <h3 class="font-semibold">Hasil Samping</h3>
                    </div>
                    <div class="overflow-x-auto">
                      <table class="table table-sm">
                        <thead>
                          <tr>
                            <th>Keterangan</th>
                            <th>Jumlah</th>
                            <th>Harga Satuan (Rp)</th>
                            <th>Total (Rp)</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>
                              <input type="text" name="hasil_samping_keterangan" class="input input-sm w-full"
                                placeholder="Misal: Jerami, Dedak, ..." value="{{ old('hasil_samping_keterangan') }}" autocomplete="off">
                            </td>
                            <td>
                              <input type="number" name="hasil_samping_jumlah" id="hasil_samping_jumlah"
                                class="input input-sm w-full" step="0.01" min="0"
                                value="{{ old('hasil_samping_jumlah', 0) }}">
                            </td>
                            <td>
                              <input type="number" name="hasil_samping_harga" id="hasil_samping_harga"
                                class="input input-sm w-full" step="0.01" min="0"
                                value="{{ old('hasil_samping_harga', 0) }}">
                            </td>
                            <td class="align-middle font-bold text-success" id="total_hasil_samping">Rp 0</td>
                          </tr>
                          <tr class="bg-base-200/50 font-semibold">
                            <td colspan="3" class="text-end text-sm">Total Hasil Samping</td>
                            <td class="font-bold text-success" id="subtotal_samping">Rp 0</td>
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
                    <h3 class="font-semibold">Ringkasan Pendapatan</h3>
                  </div>
                  <div class="p-4">
                    <div class="rounded-lg bg-base-200/60 p-3 text-sm">
                      <div class="flex justify-between text-base-content/60">
                        <span>Total Penjualan Padi</span>
                        <span id="ring_padi" class="font-medium">Rp 0</span>
                      </div>
                      <div class="flex justify-between text-base-content/60 mt-1">
                        <span>Total Hasil Samping</span>
                        <span id="ring_samping" class="font-medium">Rp 0</span>
                      </div>
                      <div class="divider my-1.5"></div>
                      <div class="flex justify-between font-semibold text-base">
                        <span>Total Pendapatan</span>
                        <span id="ring_total" class="text-success">Rp 0</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

            </div>{{-- end grid --}}

            <div class="flex items-center justify-between mt-3 gap-2">
              <a href="{{ route('createProduksi') }}" class="btn w-1/2">← Kembali</a>
              <button type="submit" class="btn w-1/2 greenImage">Simpan & Lanjutkan</button>
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
