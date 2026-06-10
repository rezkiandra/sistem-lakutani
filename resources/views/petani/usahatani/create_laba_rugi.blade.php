@extends('layouts.app')

@section('title', 'Input Laba / Rugi')

@section('content')
  <div class="container mx-auto min-h-screen flex flex-col items-center justify-start px-2 sm:px-4">

    <div class="w-full max-w-6xl mt-20 lg:mt-10 md:mt-20 mb-10">
      <div class="card bg-base-200">
        <div class="card-header woodImage p-4 sm:p-5 rounded-t-xl">
          <h1 class="text-2xl sm:text-3xl font-bold text-slate-100 mb-1">📊 Input Laba / Rugi</h1>
          <span class="text-xs sm:text-sm text-slate-100">Langkah 3 dari 3 — isi data pengeluaran produksi</span>
        </div>

        {{-- Step Indicator (Di HP akan membungkus rapi, di desktop sejajar) --}}
        <ol
          class="mb-0 flex flex-wrap sm:flex-nowrap items-center gap-2 p-4 sm:p-5 bg-base-300/30 rounded-b-xl sm:rounded-none">
          <li class="flex items-center gap-2">
            <span
              class="btn flex size-7 items-center justify-center rounded-full bg-base-200 text-xs font-bold text-base-content/40">1</span>
            <span class="text-xs sm:text-sm text-base-content/40">Produksi</span>
          </li>
          <li class="h-px flex-1 bg-base-content/20 min-w-[20px]"></li>
          <li class="flex items-center gap-2">
            <span
              class="btn flex size-7 items-center justify-center rounded-full bg-base-200 text-xs font-bold text-base-content/40">2</span>
            <span class="text-xs sm:text-sm text-base-content/40">Pendapatan</span>
          </li>
          <li class="h-px flex-1 bg-base-content/20 min-w-[20px]"></li>
          <li class="flex items-center gap-2">
            <span
              class="btn flex size-7 items-center justify-center rounded-full bg-dark text-xs font-bold text-dark-content">3</span>
            <span class="text-xs sm:text-sm font-semibold text-dark">Laba / Rugi</span>
          </li>
        </ol>

        <div class="card-body p-4 sm:p-8">
          @if ($errors->any())
            <div class="alert alert-error mb-4 text-xs sm:text-sm">
              <ul class="list-disc list-inside">
                @foreach ($errors->all() as $e)
                  <li>{{ $e }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          <form action="{{ route('petani.storeLabaRugi', $pendapatan->id) }}" method="POST">
            @csrf
            <input type="hidden" name="pendapatan_id" value="{{ $pendapatan->id }}">

            <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">

              {{-- ===================== KOLOM KIRI ===================== --}}
              <div class="flex flex-col gap-4">

                {{-- Input Usaha Tani --}}
                <div class="card bg-base-100 shadow-md w-full">
                  <div class="card-body p-0">
                    <div class="flex items-center gap-2 border-b border-base-content/10 px-4 py-3">
                      <span class="icon-[tabler--tractor] text-warning size-5"></span>
                      <h3 class="font-semibold text-sm sm:text-base">Input Usaha Tani</h3>
                    </div>
                    <div class="p-4 flex flex-col gap-3">

                      @foreach ([['name' => 'benih', 'label' => 'Benih'], ['name' => 'urea', 'label' => 'Urea'], ['name' => 'tsp_sp36', 'label' => 'TSP / SP36'], ['name' => 'pupuk_lainnya', 'label' => 'Pupuk Lainnya'], ['name' => 'bahan_kimia', 'label' => 'Bahan Kimia']] as $item)
                        <div>
                          <label class="label-text mb-1 block text-xs sm:text-sm"
                            for="{{ $item['name'] }}">{{ $item['label'] }}</label>
                          <div class="input flex items-center">
                            <input type="number" name="{{ $item['name'] }}" id="{{ $item['name'] }}"
                              class="grow biaya-input text-sm" step="0.01" min="0"
                              value="{{ old($item['name'], 0) }}" placeholder="0">
                            <span class="text-base-content/50 text-xs sm:text-sm">Rp</span>
                          </div>
                          @error($item['name'])
                            <span class="helper-text text-error text-xs">{{ $message }}</span>
                          @enderror
                        </div>
                      @endforeach

                      <div class="rounded-lg bg-base-200/60 p-3 text-xs sm:text-sm">
                        <div class="flex justify-between font-semibold">
                          <span>Subtotal Input Usaha Tani</span>
                          <span id="subtotal_input_usaha_tani" class="text-warning">Rp 0</span>
                        </div>
                      </div>
                      <input type="hidden" name="subtotal_input_usaha_tani" id="hidden_subtotal_input_usaha_tani">
                    </div>
                  </div>
                </div>

                {{-- Pengeluaran Lain Produksi --}}
                <div class="card bg-base-100 shadow-md w-full">
                  <div class="card-body p-0">
                    <div class="flex items-center gap-2 border-b border-base-content/10 px-4 py-3">
                      <span class="icon-[tabler--tool] text-secondary size-5"></span>
                      <h3 class="font-semibold text-sm sm:text-base">Pengeluaran Lain Produksi</h3>
                    </div>
                    <div class="p-4 flex flex-col gap-3">

                      @foreach ([['name' => 'biaya_pekerja', 'label' => 'Biaya Pekerja'], ['name' => 'pembajakan', 'label' => 'Pembajakan'], ['name' => 'perataan_lahan', 'label' => 'Perataan Lahan'], ['name' => 'pemeliharaan_alat', 'label' => 'Pemeliharaan Alat'], ['name' => 'pengeluaran_lain_produksi', 'label' => 'Pengeluaran Lain']] as $item)
                        <div>
                          <label class="label-text mb-1 block text-xs sm:text-sm"
                            for="{{ $item['name'] }}">{{ $item['label'] }}</label>
                          <div class="input flex items-center">
                            <input type="number" name="{{ $item['name'] }}" id="{{ $item['name'] }}"
                              class="grow biaya-input text-sm" step="0.01" min="0"
                              value="{{ old($item['name'], 0) }}" placeholder="0">
                            <span class="text-base-content/50 text-xs sm:text-sm">Rp</span>
                          </div>
                          @error($item['name'])
                            <span class="helper-text text-error text-xs">{{ $message }}</span>
                          @enderror
                        </div>
                      @endforeach

                      <div class="rounded-lg bg-base-200/60 p-3 text-xs sm:text-sm">
                        <div class="flex justify-between font-semibold">
                          <span>Subtotal Pengeluaran Lain</span>
                          <span id="subtotal_pengeluaran_lain" class="text-secondary">Rp 0</span>
                        </div>
                      </div>
                      <input type="hidden" name="subtotal_pengeluaran_lain" id="hidden_subtotal_pengeluaran_lain">
                    </div>
                  </div>
                </div>

              </div>{{-- end kolom kiri --}}

              {{-- ===================== KOLOM KANAN ===================== --}}
              <div class="flex flex-col gap-4">

                {{-- Biaya Panen --}}
                <div class="card bg-base-100 shadow-md w-full">
                  <div class="card-body p-0">
                    <div class="flex items-center gap-2 border-b border-base-content/10 px-4 py-3">
                      <span class="icon-[tabler--wheat] text-success size-5"></span>
                      <h3 class="font-semibold text-sm sm:text-base">Biaya Panen</h3>
                    </div>
                    <div class="p-4 flex flex-col gap-3">

                      @foreach ([['name' => 'panen', 'label' => 'Panen'], ['name' => 'pengeringan', 'label' => 'Pengeringan'], ['name' => 'transpor', 'label' => 'Transpor'], ['name' => 'perontonkan', 'label' => 'Perontonkan'], ['name' => 'zakat_uang', 'label' => 'Zakat (Uang)'], ['name' => 'penggilingan', 'label' => 'Penggilingan']] as $item)
                        <div>
                          <label class="label-text mb-1 block text-xs sm:text-sm"
                            for="{{ $item['name'] }}">{{ $item['label'] }}</label>
                          <div class="input flex items-center">
                            <input type="number" name="{{ $item['name'] }}" id="{{ $item['name'] }}"
                              class="grow biaya-input text-sm" step="0.01" min="0"
                              value="{{ old($item['name'], 0) }}" placeholder="0">
                            <span class="text-base-content/50 text-xs sm:text-sm">Rp</span>
                          </div>
                          @error($item['name'])
                            <span class="helper-text text-error text-xs">{{ $message }}</span>
                          @enderror
                        </div>
                      @endforeach

                      <div class="rounded-lg bg-base-200/60 p-3 text-xs sm:text-sm">
                        <div class="flex justify-between font-semibold">
                          <span>Subtotal Biaya Panen</span>
                          <span id="subtotal_biaya_panen" class="text-success">Rp 0</span>
                        </div>
                      </div>
                      <input type="hidden" name="subtotal_biaya_panen" id="hidden_subtotal_biaya_panen">
                    </div>
                  </div>
                </div>

                {{-- Biaya Lainnya --}}
                <div class="card bg-base-100 shadow-md w-full">
                  <div class="card-body p-0">
                    <div class="flex items-center gap-2 border-b border-base-content/10 px-4 py-3">
                      <span class="icon-[tabler--receipt] text-info size-5"></span>
                      <h3 class="font-semibold text-sm sm:text-base">Biaya Lainnya</h3>
                    </div>
                    <div class="p-4 flex flex-col gap-3">

                      @foreach ([['name' => 'sewa_lahan', 'label' => 'Sewa Lahan'], ['name' => 'asuransi', 'label' => 'Asuransi']] as $item)
                        <div>
                          <label class="label-text mb-1 block text-xs sm:text-sm"
                            for="{{ $item['name'] }}">{{ $item['label'] }}</label>
                          <div class="input flex items-center">
                            <input type="number" name="{{ $item['name'] }}" id="{{ $item['name'] }}"
                              class="grow biaya-input text-sm" step="0.01" min="0"
                              value="{{ old($item['name'], 0) }}" placeholder="0">
                            <span class="text-base-content/50 text-xs sm:text-sm">Rp</span>
                          </div>
                          @error($item['name'])
                            <span class="helper-text text-error text-xs">{{ $message }}</span>
                          @enderror
                        </div>
                      @endforeach

                    </div>
                  </div>
                </div>

              </div>{{-- end kolom kanan --}}

              {{-- ===================== RINGKASAN FULL WIDTH ===================== --}}
              <div class="card bg-base-100 shadow-md lg:col-span-2 w-full">
                <div class="card-body p-0">
                  <div class="flex items-center gap-2 border-b border-base-content/10 px-4 py-3">
                    <span class="icon-[tabler--calculator] text-primary size-5"></span>
                    <h3 class="font-semibold text-sm sm:text-base">Ringkasan Laba / Rugi</h3>
                  </div>
                  <div class="p-4">
                    <div class="rounded-lg bg-base-200/60 p-3 text-xs sm:text-sm flex flex-col gap-1">

                      {{-- Total Pendapatan (dari step sebelumnya) --}}
                      <div class="flex justify-between text-base-content/60">
                        <span>Total Pendapatan</span>
                        <span id="disp_total_pendapatan" class="font-medium text-success">
                          Rp {{ number_format($pendapatan->total_pendapatan ?? 0, 0, ',', '.') }}
                        </span>
                      </div>
                      <input type="hidden" name="total_pendapatan" value="{{ $pendapatan->total_pendapatan ?? 0 }}">

                      <div class="divider my-1.5"></div>

                      <div class="flex justify-between text-base-content/60 mt-1">
                        <span>Subtotal Input Usaha Tani</span>
                        <span id="disp_sub_input" class="font-medium">Rp 0</span>
                      </div>
                      <div class="flex justify-between text-base-content/60 mt-1">
                        <span>Subtotal Pengeluaran Lain</span>
                        <span id="disp_sub_lain" class="font-medium">Rp 0</span>
                      </div>
                      <div class="flex justify-between text-base-content/60 mt-1">
                        <span>Subtotal Biaya Panen</span>
                        <span id="disp_sub_panen" class="font-medium">Rp 0</span>
                      </div>
                      <div class="flex justify-between text-base-content/60 mt-1">
                        <span>Sewa Lahan + Asuransi</span>
                        <span id="disp_lainnya" class="font-medium">Rp 0</span>
                      </div>

                      <div class="divider my-1.5"></div>

                      <div class="flex justify-between text-base-content/70 font-semibold">
                        <span>Total Pengeluaran Produksi</span>
                        <span id="disp_total_pengeluaran" class="text-error">Rp 0</span>
                      </div>
                      <input type="hidden" name="total_pengeluaran_produksi" id="hidden_total_pengeluaran">

                      <div class="divider my-1.5"></div>

                      <div class="flex justify-between font-semibold text-sm sm:text-base">
                        <span>Total Laba / Rugi</span>
                        <span id="disp_laba_rugi" class="text-success font-bold">Rp 0</span>
                      </div>
                      <input type="hidden" name="total_laba_rugi" id="hidden_laba_rugi">

                    </div>
                  </div>
                </div>
              </div>

            </div>{{-- end grid --}}

            <div class="flex flex-col sm:flex-row items-center justify-between mt-5 gap-3">
              <a href="{{ route('petani.createPendapatan', $pendapatan->produksi->id) }}"
                class="btn w-full sm:w-1/2 order-2 sm:order-1">← Kembali</a>
              <button type="submit" class="btn w-full sm:w-1/2 greenImage text-white order-1 sm:order-2">Simpan &
                Selesai</button>
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

    const totalPendapatan = parseFloat('{{ $pendapatan->total_pendapatan ?? 0 }}') || 0;

    const grupInputUsahaTani = ['benih', 'urea', 'tsp_sp36', 'pupuk_lainnya', 'bahan_kimia'];
    const grupPengeluaranLain = ['biaya_pekerja', 'pembajakan', 'perataan_lahan', 'pemeliharaan_alat',
      'pengeluaran_lain_produksi'
    ];
    const grupBiayaPanen = ['panen', 'pengeringan', 'transpor', 'perontonkan', 'zakat_uang', 'penggilingan'];
    const grupLainnya = ['sewa_lahan', 'asuransi'];

    function sumGroup(names) {
      return names.reduce((total, name) => {
        return total + (parseFloat(document.getElementById(name)?.value) || 0);
      }, 0);
    }

    function hitung() {
      const subInput = sumGroup(grupInputUsahaTani);
      const subLain = sumGroup(grupPengeluaranLain);
      const subPanen = sumGroup(grupBiayaPanen);
      const subLainnya = sumGroup(grupLainnya);

      const totalPengeluaran = subInput + subLain + subPanen + subLainnya;
      const labaRugi = totalPendapatan - totalPengeluaran;

      // Update subtotal cards
      document.getElementById('subtotal_input_usaha_tani').textContent = formatRp(subInput);
      document.getElementById('subtotal_pengeluaran_lain').textContent = formatRp(subLain);
      document.getElementById('subtotal_biaya_panen').textContent = formatRp(subPanen);

      // Update ringkasan
      document.getElementById('disp_sub_input').textContent = formatRp(subInput);
      document.getElementById('disp_sub_lain').textContent = formatRp(subLain);
      document.getElementById('disp_sub_panen').textContent = formatRp(subPanen);
      document.getElementById('disp_lainnya').textContent = formatRp(subLainnya);
      document.getElementById('disp_total_pengeluaran').textContent = formatRp(totalPengeluaran);

      const elLabaRugi = document.getElementById('disp_laba_rugi');
      elLabaRugi.textContent = formatRp(labaRugi);
      elLabaRugi.className = labaRugi >= 0 ? 'text-success font-bold' : 'text-error font-bold';

      // Update hidden inputs untuk disimpan ke DB
      document.getElementById('hidden_subtotal_input_usaha_tani').value = subInput;
      document.getElementById('hidden_subtotal_pengeluaran_lain').value = subLain;
      document.getElementById('hidden_subtotal_biaya_panen').value = subPanen;
      document.getElementById('hidden_total_pengeluaran').value = totalPengeluaran;
      document.getElementById('hidden_laba_rugi').value = labaRugi;
    }

    document.querySelectorAll('.biaya-input').forEach(el => el.addEventListener('input', hitung));

    hitung();
  </script>
@endpush
