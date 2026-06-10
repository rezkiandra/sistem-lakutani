@extends('layouts.app')
@section('title', 'Analisis Kelayakan Usaha Tani')

@section('content')
  <div class="container mx-auto min-h-screen flex flex-col items-center justify-start">

    <div class="w-3/4 mt-20">
      <div class="card bg-base-200">
        <div class="card-header woodImage p-5">
          <h1 class="text-3xl font-bold text-slate-100 mb-1">🌾 Input Produksi</h1>
          <span class="text-sm text-slate-100">Langkah 1 dari 3 — isi data hasil panen dan alokasi padi</span>
        </div>

        <div class="card-body">
          <form action="{{ route('petani.storeProduksi') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 gap-3 lg:grid-cols-2">
              {{-- Hasil Panen --}}
              <div class="card bg-base-100 shadow-md">
                <div class="card-body p-0">
                  <div class="flex items-center gap-2 border-b border-base-content/10 px-4 py-3">
                    <span class="icon-[tabler--wheat] text-warning size-5"></span>
                    <h3 class="font-semibold">Hasil Panen</h3>
                  </div>
                  <div class="p-4">
                    <div>
                      <label class="label-text mb-1" for="hasil_panen_padi_kg">
                        Total Hasil Panen Padi <span class="text-error">*</span>
                      </label>
                      <div class="input flex items-center">
                        <input type="number" name="hasil_panen_padi_kg" id="hasil_panen_padi_kg" class="grow"
                          step="0.01" min="0" value="{{ old('hasil_panen_padi_kg') }}" placeholder="Contoh: 500"
                          required>
                        <span class="text-base-content/50 text-sm">kg</span>
                      </div>
                      @error('hasil_panen_padi_kg')
                        <span class="helper-text text-error">{{ $message }}</span>
                      @enderror
                    </div>

                    {{-- Info sisa padi --}}
                    <div class="mt-4 rounded-lg bg-base-200/60 p-3 text-sm">
                      <div class="flex justify-between text-base-content/60">
                        <span>Total Panen</span>
                        <span id="info_total_panen" class="font-medium">0 kg</span>
                      </div>
                      <div class="flex justify-between text-base-content/60 mt-1">
                        <span>Total Alokasi</span>
                        <span id="info_total_alokasi" class="font-medium text-error">- 0 kg</span>
                      </div>
                      <div class="divider my-1.5"></div>
                      <div class="flex justify-between font-semibold">
                        <span>Sisa (dapat dijual)</span>
                        <span id="info_sisa" class="text-success">0 kg</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              {{-- Alokasi Padi --}}
              <div class="card bg-base-100 shadow-md">
                <div class="card-body p-0">
                  <div class="flex items-center gap-2 border-b border-base-content/10 px-4 py-3">
                    <span class="icon-[tabler--arrows-split] text-secondary size-5"></span>
                    <h3 class="font-semibold">Alokasi Padi yang Dipanen</h3>
                    <span class="badge badge-soft badge-ghost ms-auto text-xs">Jika dibayar dengan padi</span>
                  </div>
                  <div class="overflow-x-auto">
                    <table class="table table-sm">
                      <thead>
                        <tr>
                          <th>Jenis</th>
                          <th class="w-36">Jumlah (kg)</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ([['name' => 'konsumsi_sendiri_kg', 'label' => 'Konsumsi Sendiri', 'icon' => 'icon-[tabler--home]'], ['name' => 'zakat_kg', 'label' => 'Zakat', 'icon' => 'icon-[tabler--heart]'], ['name' => 'sewa_lahan_kg', 'label' => 'Sewa Lahan', 'icon' => 'icon-[tabler--map]'], ['name' => 'input_usaha_tani_kg', 'label' => 'Input Usaha Tani', 'icon' => 'icon-[tabler--tractor]'], ['name' => 'layanan_lain_kg', 'label' => 'Layanan Lain', 'icon' => 'icon-[tabler--tool]'], ['name' => 'lain_lain_kg', 'label' => 'Lain-lain', 'icon' => 'icon-[tabler--dots]']] as $item)
                          <tr>
                            <td>
                              <div class="flex items-center gap-2">
                                <span class="{{ $item['icon'] }} text-base-content/40 size-4 shrink-0"></span>
                                <span class="text-sm">{{ $item['label'] }}</span>
                              </div>
                            </td>
                            <td>
                              <input type="number" name="{{ $item['name'] }}" class="input input-sm w-full alokasi"
                                step="0.01" min="0" value="{{ old($item['name'], 0) }}" placeholder="0">
                            </td>
                          </tr>
                        @endforeach
                        <tr class="bg-base-200/50 font-semibold">
                          <td class="text-end text-sm">Total Alokasi</td>
                          <td class="text-error font-bold" id="total_alokasi_tabel">0 kg</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>

              <div class="card bg-base-100 shadow-md lg:col-span-2">
                <div class="card-body p-0">
                  <div class="flex items-center gap-2 border-b border-base-content/10 px-4 py-3">
                    <span class="icon-[tabler--shopping-cart] text-success size-5"></span>
                    <h3 class="font-semibold">Hasil Produksi yang Terjual</h3>
                  </div>
                  <div class="grid grid-cols-1 gap-4 p-4 sm:grid-cols-2">
                    <div>
                      <label class="label-text mb-1" for="padi_terjual_kg">
                        Padi Terjual <span class="text-error">*</span>
                      </label>
                      <div class="input flex items-center">
                        <span class="icon-[tabler--wheat] text-base-content/40 size-4 shrink-0"></span>
                        <input type="number" name="padi_terjual_kg" id="padi_terjual_kg" class="grow" step="0.01"
                          min="0" value="{{ old('padi_terjual_kg') }}" placeholder="0" required>
                        <span class="text-base-content/50 text-sm">kg</span>
                      </div>
                      @error('padi_terjual_kg')
                        <span class="helper-text text-error">{{ $message }}</span>
                      @enderror
                    </div>
                    <div>
                      <label class="label-text mb-1" for="beras_terjual_kg">
                        Beras Terjual
                        <span class="badge badge-soft badge-ghost text-xs ms-1">Jika petani menjual beras</span>
                      </label>
                      <div class="input flex items-center">
                        <span class="icon-[tabler--bowl-rice] text-base-content/40 size-4 shrink-0"></span>
                        <input type="number" name="beras_terjual_kg" id="beras_terjual_kg" class="grow"
                          step="0.01" min="0" value="{{ old('beras_terjual_kg') }}" placeholder="0">
                        <span class="text-base-content/50 text-sm">kg</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

            </div>{{-- end grid --}}
            <div class="flex items-center justify-between mt-3 gap-2">
              <button type="reset" class="btn w-1/2">Reset</button>
              <button type="submit" class="btn w-1/2 greenImage">Simpan & Lanjutkan</button>
            </div>

          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
