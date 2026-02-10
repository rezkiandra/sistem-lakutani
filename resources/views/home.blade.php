@extends('layouts.guest')
@section('title', 'Home')

@section('content')
  <div class="container mx-auto text-center pt-16 min-h-screen flex items-center justify-center">
    <div class="flex flex-col justify-center items-center w-full">
      <div class="pb-16">
        <h1 class="text-5xl font-extrabold text-green-950">Selamat Datang di Lakutani</h1>
        <hr class="my-8 border border-slate-800">
        <p class="text-3xl font-semibold text-green-950">Analisis Kelayakan Usaha Tani & Pencatatan Keuangan Pertanian</p>
      </div>

      <div class="flex flex-col gap-8 text-stone-200 w-full">
        <div class="flex flex-row justify-center gap-8 w-full text-stone-200">
          <div
            class="flex flex-row items-center justify-center gap-8 shadow-2xl rounded-lg p-4 w-full greenImage hover:scale-101 transition duration-300 ease-in-out transform cursor-pointer hover:shadow-3xl">
            <i class="ti ti-tractor text-9xl"></i>
            <div class="flex flex-col text-center gap-3">
              <span class="text-3xl font-bold">Analisis Kelayakan <br />Usaha Tani</span>
            </div>
          </div>
          <div
            class="flex flex-row items-center justify-center gap-8 shadow-2xl rounded-lg p-4 w-full woodImage hover:scale-101 transition duration-300 ease-in-out transform cursor-pointer hover:shadow-3xl">
            <i class="ti ti-plant text-9xl"></i>
            <div class="flex flex-col text-center gap-3">
              <span class="text-3xl font-bold">Pencatatan Keuangan <br />Pertanian</span>
            </div>
          </div>
        </div>

        <div class="py-16 flex items-center justify-center gap-8">
          <button class="btn woodImage border-yellow-800 text-2xl px-10 py-8 text-stone-200 hover:scale-101 transition duration-300 ease-in-out transform cursor-pointer hover:shadow-3xl">Mulai Analisis</button>
          <button class="btn greenImage border-green-800 text-2xl px-10 py-8 text-stone-200 hover:scale-101 transition duration-300 ease-in-out transform cursor-pointer hover:shadow-3xl">Catat Keuangan</button>
        </div>
      </div>
    </div>
  @endsection
