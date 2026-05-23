@extends('layouts.app')
@section('title', 'Input Produksi')

@section('content')
  <div class="container mx-auto min-h-screen flex flex-col items-center justify-start">

    <div class="w-1/2 mt-32">
      <div class="card bg-base-200">
        <div class="card-header woodImage p-5">
          <h1 class="text-3xl font-bold text-slate-100 mb-1">Input Data Produksi </h1>
          <span class="text-sm text-slate-100">Lengkapi data produksi yang ingin ditambahkan (Kilogram)</span>
        </div>

        <div class="card-body">
          <form action="{{ route('produksi.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
              <div class="rounded bg-base-200 py-3">
                <x-form-input type="number" name="hasil_panen" label="Hasil Panen" required=true />
              </div>
              <div class="rounded bg-base-200 py-3">
                <x-form-input type="number" name="konsumsi_sendiri" label="Konsumsi Sendiri" required=true />
              </div>
              <div class="rounded bg-base-200 py-3">
                <x-form-input type="number" name="zakat" label="Zakat (jika dibayar dengan padi)" />
              </div>
              <div class="rounded bg-base-200 py-3">
                <x-form-input type="number" name="sewa_lahan" label="Sewa Lahan (jika dibayar dengan padi)" />
              </div>
              <div class="rounded bg-base-200 py-3">
                <x-form-input type="number" name="input_usaha_tani" label="Input Usaha Tani (jika dibayar dengan padi)" />
              </div>
              <div class="rounded bg-base-200 py-3">
                <x-form-input type="number" name="layanan_lain" label="Layanan Lain (jika dibayar dengan padi)" />
              </div>
              <div class="rounded bg-base-200 py-3">
                <x-form-input type="number" name="lain_lain" label="Lain-lain (jika dibayar dengan padi)" />
              </div>
              <div class="rounded bg-base-200 py-3">
                <x-form-input type="number" name="padi_terjual" label="Padi Terjual" required=true />
              </div>
              <div class="rounded bg-base-200 py-3 md:col-span-2">
                <x-form-input type="number" name="beras_terjual" label="Beras Terjual (jika petani menjual beras)"/>
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
