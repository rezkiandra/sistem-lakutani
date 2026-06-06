@extends('layouts.app')

@section('title', 'Hasil Analisis Usaha Tani')

@section('content')
  <div class="container mx-auto min-h-screen flex flex-col items-center justify-start">
    <div class="w-3/4 mt-20 mb-10">

      {{-- Header Card --}}
      <div class="card bg-base-200 mb-4">
        <div class="card-header woodImage p-5">
          <div class="flex items-center justify-between">
            <div>
              <h1 class="text-3xl font-bold text-slate-100 mb-1">📋 Hasil Analisis Usaha Tani</h1>
              <span class="text-sm text-slate-100">Ringkasan lengkap produksi, pendapatan, dan laba/rugi</span>
            </div>
          </div>
        </div>

        {{-- Status Banner --}}
        @if ($labaRugi)
          @php
            $labaRugiNominal = $labaRugi->total_laba_rugi;
            $isLaba = $labaRugiNominal >= 0;
          @endphp
          <div class="px-5 pb-5 pt-2">
            <div
              class="rounded-xl p-4 flex items-center justify-between
              {{ $isLaba ? 'bg-success/10 border border-success/30' : 'bg-error/10 border border-error/30' }}">
              <div class="flex items-center gap-3">
                <span
                  class="{{ $isLaba ? 'ti ti-chart-bar text-success' : 'ti ti-chart-bar text-error' }} text-3xl"></span>
                <div>
                  <p class="text-sm font-medium {{ $isLaba ? 'text-success' : 'text-error' }}">
                    {{ $isLaba ? 'Usaha Tani Menguntungkan' : 'Usaha Tani Merugi' }}
                  </p>
                  <p class="text-xs text-base-content/50">Berdasarkan data yang diinput</p>
                </div>
              </div>
              <div class="text-end">
                <p class="text-2xl font-bold {{ $isLaba ? 'text-success' : 'text-error' }}">
                  {{ $isLaba ? '+' : '' }}Rp {{ number_format($labaRugiNominal, 0, ',', '.') }}
                </p>
                <p class="text-xs text-base-content/50">Total {{ $isLaba ? 'Laba' : 'Rugi' }}</p>
              </div>
            </div>
          </div>
        @else
          <div class="px-5 pb-5 pt-2">
            <div class="alert alert-warning">
              <span class="icon-[tabler--alert-triangle] size-5"></span>
              Data laba/rugi belum diinput.
            </div>
          </div>
        @endif
      </div>

      {{-- Stat Cards --}}
      <div class="grid grid-cols-2 gap-3 lg:grid-cols-4 mb-4">
        <div class="card bg-base-100 shadow-md">
          <div class="card-body p-4">
            <div class="flex items-center gap-2 mb-2">
              <span class="icon-[tabler--wheat] text-warning size-5 text-lg">🌾</span>
              <span class="text-xs text-base-content/50">Total Panen</span>
            </div>
            <p class="text-xl font-bold text-warning">
              {{ number_format($produksi->hasil_panen_padi_kg, 0, ',', '.') }} kg
            </p>
          </div>
        </div>
        <div class="card bg-base-100 shadow-md">
          <div class="card-body p-4">
            <div class="flex items-center gap-2 mb-2">
              <span class="icon-[tabler--shopping-cart] text-info size-5 text-lg">🌾</span>
              <span class="text-xs text-base-content/50">Padi Terjual</span>
            </div>
            <p class="text-xl font-bold text-info">
              {{ number_format($produksi->padi_terjual_kg, 0, ',', '.') }} kg
            </p>
          </div>
        </div>
        <div class="card bg-base-100 shadow-md">
          <div class="card-body p-4">
            <div class="flex items-center gap-2 mb-2">
              <span class="icon-[tabler--cash] text-success size-5 text-lg">📈</span>
              <span class="text-xs text-base-content/50">Total Pendapatan</span>
            </div>
            <p class="text-xl font-bold text-success">
              Rp {{ $pendapatan ? number_format($pendapatan->total_pendapatan, 0, ',', '.') : '0' }}
            </p>
          </div>
        </div>
        <div class="card bg-base-100 shadow-md">
          <div class="card-body p-4">
            <div class="flex items-center gap-2 mb-2">
              <span class="icon-[tabler--receipt] text-error size-5 text-lg">📉</span>
              <span class="text-xs text-base-content/50">Total Pengeluaran</span>
            </div>
            <p class="text-xl font-bold text-error">
              Rp {{ $labaRugi ? number_format($labaRugi->total_pengeluaran_produksi, 0, ',', '.') : '0' }}
            </p>
          </div>
        </div>
      </div>

      <div class="grid grid-cols-1 gap-3 lg:grid-cols-2">

        {{-- ===== DATA PRODUKSI ===== --}}
        <div class="card bg-base-100 shadow-md">
          <div class="card-body p-0">
            <div class="flex items-center gap-2 border-b border-base-content/10 px-4 py-3">
              <span class="icon-[tabler--plant-2] text-success text-lg">🪴</span>
              <h3 class="font-semibold">Data Produksi</h3>
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
                  <tr class="font-semibold">
                    <td>Hasil Panen Padi</td>
                    <td class="text-end">{{ number_format($produksi->hasil_panen_padi_kg, 0, ',', '.') }}</td>
                    <td>kg</td>
                  </tr>
                  <tr>
                    <td colspan="3">
                      <span class="text-xs font-semibold text-base-content/40">Alokasi</span>
                    </td>
                  </tr>
                  @foreach ([['label' => 'Konsumsi Sendiri', 'value' => $produksi->konsumsi_sendiri_kg], ['label' => 'Zakat', 'value' => $produksi->zakat_kg], ['label' => 'Sewa Lahan', 'value' => $produksi->sewa_lahan_kg], ['label' => 'Input Usaha Tani', 'value' => $produksi->input_usaha_tani_kg], ['label' => 'Layanan Lain', 'value' => $produksi->layanan_lain_kg], ['label' => 'Lain-lain', 'value' => $produksi->lain_lain_kg]] as $row)
                    <tr>
                      <td class="ps-4 text-sm text-base-content/70">{{ $row['label'] }}</td>
                      <td class="text-end text-error">- {{ number_format($row['value'], 0, ',', '.') }}</td>
                      <td>kg</td>
                    </tr>
                  @endforeach
                  <tr class="bg-warning/10 font-semibold">
                    <td>Padi Terjual</td>
                    <td class="text-end text-warning">{{ number_format($produksi->padi_terjual_kg, 0, ',', '.') }}</td>
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

        {{-- ===== DATA PENDAPATAN ===== --}}
        <div class="card bg-base-100 shadow-md">
          <div class="card-body p-0">
            <div class="flex items-center gap-2 border-b border-base-content/10 px-4 py-3">
              <span class="icon-[tabler--cash] text-success size-5 textl-lg">👛</span>
              <h3 class="font-semibold">Data Pendapatan</h3>
            </div>
            @if ($pendapatan)
              <div class="overflow-x-auto">
                <table class="table table-sm">
                  <thead>
                    <tr>
                      <th>Jenis</th>
                      <th class="text-end">Nilai</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>
                        <div class="flex flex-col">
                          <span>Penjualan Padi</span>
                          <span class="text-xs text-base-content/50">
                            {{ number_format($produksi->padi_terjual_kg, 0, ',', '.') }} kg
                            × Rp {{ number_format($pendapatan->harga_padi_per_kg, 0, ',', '.') }}
                          </span>
                        </div>
                      </td>
                      <td class="text-end font-semibold text-success">
                        Rp {{ number_format($produksi->padi_terjual_kg * $pendapatan->harga_padi_per_kg, 0, ',', '.') }}
                      </td>
                    </tr>
                    @if ($pendapatan->hasil_samping_jumlah > 0)
                      <tr>
                        <td>
                          <div class="flex flex-col">
                            <span>Hasil Samping</span>
                            <span class="text-xs text-base-content/50">
                              {{ $pendapatan->hasil_samping_keterangan }}
                              — {{ number_format($pendapatan->hasil_samping_jumlah, 0, ',', '.') }}
                              × Rp {{ number_format($pendapatan->hasil_samping_harga, 0, ',', '.') }}
                            </span>
                          </div>
                        </td>
                        <td class="text-end font-semibold text-success">
                          Rp
                          {{ number_format($pendapatan->hasil_samping_jumlah * $pendapatan->hasil_samping_harga, 0, ',', '.') }}
                        </td>
                      </tr>
                    @endif
                    <tr class="bg-success/10 font-bold">
                      <td>Total Pendapatan</td>
                      <td class="text-end text-success">
                        Rp {{ number_format($pendapatan->total_pendapatan, 0, ',', '.') }}
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            @else
              <div class="p-4">
                <div class="alert alert-warning text-sm">Data pendapatan belum diinput.</div>
              </div>
            @endif
          </div>
        </div>

        {{-- ===== RINCIAN PENGELUARAN ===== --}}
        @if ($labaRugi)
          <div class="card bg-base-100 shadow-md lg:col-span-2">
            <div class="card-body p-0">
              <div class="flex items-center gap-2 border-b border-base-content/10 px-4 py-3">
                <span class="ti ti-pipeline text-error text-xl"></span>
                <h3 class="font-semibold">Rincian Pengeluaran Produksi</h3>
              </div>
              <div
                class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 divide-y sm:divide-y-0 sm:divide-x divide-base-content/10">

                {{-- Input Usaha Tani --}}
                <div class="p-4">
                  <div class="flex items-center gap-2 mb-3">
                    <span class="ti ti-input-search text-warning size-4"></span>
                    <span class="text-xs font-semibold text-base-content/60 uppercase tracking-wide">Input Usaha
                      Tani</span>
                  </div>
                  <div class="flex flex-col gap-1.5">
                    @foreach ([['label' => 'Benih', 'value' => $labaRugi->benih], ['label' => 'Urea', 'value' => $labaRugi->urea], ['label' => 'TSP / SP36', 'value' => $labaRugi->tsp_sp36], ['label' => 'Pupuk Lainnya', 'value' => $labaRugi->pupuk_lainnya], ['label' => 'Bahan Kimia', 'value' => $labaRugi->bahan_kimia]] as $item)
                      <div class="flex justify-between text-sm">
                        <span class="text-base-content/60">{{ $item['label'] }}</span>
                        <span>Rp {{ number_format($item['value'], 0, ',', '.') }}</span>
                      </div>
                    @endforeach
                  </div>
                  <div class="mt-3 pt-2 border-t border-base-content/10 flex justify-between font-semibold text-sm">
                    <span>Subtotal</span>
                    <span class="text-warning">Rp
                      {{ number_format($labaRugi->subtotal_input_usaha_tani, 0, ',', '.') }}</span>
                  </div>
                </div>

                {{-- Pengeluaran Lain --}}
                <div class="p-4">
                  <div class="flex items-center gap-2 mb-3">
                    <span class="ti ti-external-link text-secondary size-4"></span>
                    <span class="text-xs font-semibold text-base-content/60 uppercase tracking-wide">Pengeluaran
                      Lain</span>
                  </div>
                  <div class="flex flex-col gap-1.5">
                    @foreach ([['label' => 'Biaya Pekerja', 'value' => $labaRugi->biaya_pekerja], ['label' => 'Pembajakan', 'value' => $labaRugi->pembajakan], ['label' => 'Perataan Lahan', 'value' => $labaRugi->perataan_lahan], ['label' => 'Pemeliharaan Alat', 'value' => $labaRugi->pemeliharaan_alat], ['label' => 'Lain-lain', 'value' => $labaRugi->pengeluaran_lain_produksi]] as $item)
                      <div class="flex justify-between text-sm">
                        <span class="text-base-content/60">{{ $item['label'] }}</span>
                        <span>Rp {{ number_format($item['value'], 0, ',', '.') }}</span>
                      </div>
                    @endforeach
                  </div>
                  <div class="mt-3 pt-2 border-t border-base-content/10 flex justify-between font-semibold text-sm">
                    <span>Subtotal</span>
                    <span class="text-secondary">Rp
                      {{ number_format($labaRugi->subtotal_pengeluaran_lain, 0, ',', '.') }}</span>
                  </div>
                </div>

                {{-- Biaya Panen --}}
                <div class="p-4">
                  <div class="flex items-center gap-2 mb-3">
                    <span class="ti ti-components text-success size-4"></span>
                    <span class="text-xs font-semibold text-base-content/60 uppercase tracking-wide">Biaya Panen</span>
                  </div>
                  <div class="flex flex-col gap-1.5">
                    @foreach ([['label' => 'Panen', 'value' => $labaRugi->panen], ['label' => 'Pengeringan', 'value' => $labaRugi->pengeringan], ['label' => 'Transpor', 'value' => $labaRugi->transpor], ['label' => 'Perontonkan', 'value' => $labaRugi->perontonkan], ['label' => 'Zakat (Uang)', 'value' => $labaRugi->zakat_uang], ['label' => 'Penggilingan', 'value' => $labaRugi->penggilingan]] as $item)
                      <div class="flex justify-between text-sm">
                        <span class="text-base-content/60">{{ $item['label'] }}</span>
                        <span>Rp {{ number_format($item['value'], 0, ',', '.') }}</span>
                      </div>
                    @endforeach
                  </div>
                  <div class="mt-3 pt-2 border-t border-base-content/10 flex justify-between font-semibold text-sm">
                    <span>Subtotal</span>
                    <span class="text-success">Rp
                      {{ number_format($labaRugi->subtotal_biaya_panen, 0, ',', '.') }}</span>
                  </div>
                </div>

                {{-- Biaya Lainnya --}}
                <div class="p-4">
                  <div class="flex items-center gap-2 mb-3">
                    <span class="ti ti-select-all text-info size-4"></span>
                    <span class="text-xs font-semibold text-base-content/60 uppercase tracking-wide">Biaya Lainnya</span>
                  </div>
                  <div class="flex flex-col gap-1.5">
                    @foreach ([['label' => 'Sewa Lahan', 'value' => $labaRugi->sewa_lahan], ['label' => 'Asuransi', 'value' => $labaRugi->asuransi]] as $item)
                      <div class="flex justify-between text-sm">
                        <span class="text-base-content/60">{{ $item['label'] }}</span>
                        <span>Rp {{ number_format($item['value'], 0, ',', '.') }}</span>
                      </div>
                    @endforeach
                  </div>
                  <div class="mt-3 pt-2 border-t border-base-content/10 flex justify-between font-semibold text-sm">
                    <span>Subtotal</span>
                    <span class="text-info">
                      Rp {{ number_format($labaRugi->sewa_lahan + $labaRugi->asuransi, 0, ',', '.') }}
                    </span>
                  </div>
                  <div class="mt-3 rounded-lg bg-error/10 p-3">
                    <div class="flex justify-between font-bold text-sm">
                      <span class="text-error">Total Pengeluaran</span>
                      <span class="text-error">Rp
                        {{ number_format($labaRugi->total_pengeluaran_produksi, 0, ',', '.') }}</span>
                    </div>
                  </div>
                </div>

              </div>
            </div>
          </div>

          {{-- ===== RINGKASAN AKHIR ===== --}}
          <div class="card bg-base-100 shadow-md lg:col-span-2">
            <div class="card-body p-0">
              <div class="flex items-center gap-2 border-b border-base-content/10 px-4 py-3">
                <span class="ti ti-calculator text-primary text-xl"></span>
                <h3 class="font-semibold">Ringkasan Akhir Laba / Rugi</h3>
              </div>
              <div class="p-4">
                <div class="rounded-lg bg-base-200/60 p-4 text-sm flex flex-col gap-2">
                  <div class="flex justify-between text-base-content/60">
                    <span>Total Pendapatan</span>
                    <span class="font-semibold text-success">
                      Rp {{ number_format($pendapatan->total_pendapatan, 0, ',', '.') }}
                    </span>
                  </div>
                  <div class="flex justify-between text-base-content/60">
                    <span>Subtotal Input Usaha Tani</span>
                    <span class="font-medium">- Rp
                      {{ number_format($labaRugi->subtotal_input_usaha_tani, 0, ',', '.') }}</span>
                  </div>
                  <div class="flex justify-between text-base-content/60">
                    <span>Subtotal Pengeluaran Lain</span>
                    <span class="font-medium">- Rp
                      {{ number_format($labaRugi->subtotal_pengeluaran_lain, 0, ',', '.') }}</span>
                  </div>
                  <div class="flex justify-between text-base-content/60">
                    <span>Subtotal Biaya Panen</span>
                    <span class="font-medium">- Rp
                      {{ number_format($labaRugi->subtotal_biaya_panen, 0, ',', '.') }}</span>
                  </div>
                  <div class="flex justify-between text-base-content/60">
                    <span>Sewa Lahan + Asuransi</span>
                    <span class="font-medium">
                      - Rp {{ number_format($labaRugi->sewa_lahan + $labaRugi->asuransi, 0, ',', '.') }}
                    </span>
                  </div>
                  <div class="divider my-0.5"></div>
                  <div class="flex justify-between text-base-content/70 font-semibold">
                    <span>Total Pengeluaran</span>
                    <span class="text-error">- Rp
                      {{ number_format($labaRugi->total_pengeluaran_produksi, 0, ',', '.') }}</span>
                  </div>
                  <div class="divider my-0.5"></div>
                  <div class="flex justify-between font-bold text-lg">
                    <span>{{ $isLaba ? '✅ Total Laba' : '❌ Total Rugi' }}</span>
                    <span class="{{ $isLaba ? 'text-success' : 'text-error' }}">
                      {{ $isLaba ? '+' : '' }}Rp {{ number_format($labaRugi->total_laba_rugi, 0, ',', '.') }}
                    </span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        @endif

        <div class="flex items-center justify-between w-full mt-4 gap-4">
          <a href="{{ url()->previous() }}" class="btn">
            <i class="ti ti-arrow-left"></i>
            Kembali
          </a>

          @if ($labaRugi)
            <a href="{{ route('petani.createLabaRugi', $labaRugi->pendapatan->id) }}"
              class="btn btn-warning">
              <i class="ti ti-pencil"></i>
              Edit Data
            </a>

            <a href="{{ route('petani.ujiKelayakan', $produksi->id) }}" class="btn btn-info">
              <i class="ti ti-check"></i>
              Uji Kelayakan
            </a>
          @endif

          <button onclick="window.print()" class="btn greenImage">
            <i class="ti ti-printer"></i>
            Cetak / Export
          </button>
        </div>
      </div>{{-- end grid --}}

    </div>
  </div>
@endsection
