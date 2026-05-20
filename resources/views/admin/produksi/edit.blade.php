@extends('layouts.app')
@section('title', 'Edit Input Produksi')

@section('content')
  <div class="container mx-auto min-h-screen flex flex-col items-start justify-start">

    <div class="w-full mt-32">
      <div class="card bg-base-200">
        <div class="card-header woodImage p-5">
          <h1 class="text-3xl font-bold text-slate-100 mb-1">Edit Input Data Produksi </h1>
          <span class="text-sm text-slate-100">Ubah data produksi yang ingin diperbarui (Kilogram)</span>
        </div>

        <div class="card-body">
          <form action="{{ route('produksi.update', $produksi) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
              <div class="rounded bg-base-200 py-4">
                <x-form-input type="numeric" name="hasil_panen" label="Hasil Panen" required=true :value="$produksi->hasil_panen" />
              </div>
              <div class="rounded bg-base-200 py-4">
                <x-form-input type="numeric" name="konsumsi_sendiri" label="Konsumsi Sendiri" required=true
                  :value="$produksi->konsumsi_sendiri" />
              </div>
              <div class="rounded bg-base-200 py-4">
                <x-form-input type="numeric" name="zakat" label="Zakat" :value="$produksi->zakat" />
              </div>
              <div class="rounded bg-base-200 py-4">
                <x-form-input type="numeric" name="sewa_lahan" label="Sewa Lahan" :value="$produksi->sewa_lahan" />
              </div>
              <div class="rounded bg-base-200 py-4">
                <x-form-input type="numeric" name="input_usaha_tani" label="Input Usaha Tani" :value="$produksi->input_usaha_tani" />
              </div>
              <div class="rounded bg-base-200 py-4">
                <x-form-input type="numeric" name="layanan_lain" label="Layanan Lain" :value="$produksi->layanan_lain" />
              </div>
              <div class="rounded bg-base-200 py-4">
                <x-form-input type="numeric" name="lain_lain" label="Lain-lain" :value="$produksi->lain_lain" />
              </div>
              <div class="rounded bg-base-200 py-4">
                <x-form-input type="numeric" name="padi_terjual" label="Padi Terjual" required=true :value="$produksi->padi_terjual" />
              </div>
              <div class="rounded bg-base-200 py-4">
                <x-form-input type="numeric" name="beras_terjual" label="Beras Terjual" :value="$produksi->beras_terjual" />
              </div>
            </div>

            <div class="flex items-end justify-end gap-4">
              <button type="reset" class="btn">Reset</button>
              <button type="submit" class="btn greenImage">Simpan</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
