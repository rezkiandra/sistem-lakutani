@extends('layouts.auth')
@section('title', 'Login Akun')

@section('content')
  <div class="container mx-auto text-center pt-30 pb-12 px-4 min-h-screen flex items-center justify-center">
    
    <div class="card bg-base-100 w-full max-w-md shadow-2xl rounded-xl overflow-hidden">
      <div class="card-header cardImage h-48 w-full"></div>
      <div class="card-body woodCardImage p-6 sm:p-8">
        
        <h2 class="card-title justify-center">
          <img src="{{ asset('assets/img/hero.png') }}" alt="Hero Logo" class="w-36 sm:w-40 mx-auto my-2">
        </h2>

        <div class="flex flex-col gap-4 mt-2">
          <form action="{{ route('signIn') }}" method="POST" class="flex flex-col gap-4 w-full">
            @csrf
            
            <div class="flex flex-col gap-1.5 w-full items-stretch text-left">
              <label for="email" class="label text-[#f7e6bc] font-bold text-sm sm:text-md pl-1">Email</label>
              <input type="email" name="email" autocomplete="off" class="input bg-[#f7e6bc] w-full text-stone-900 px-4 py-2.5 rounded-lg" placeholder="Masukkan email Anda" id="email" value="{{ old('email') }}" />
            </div>
            
            <div class="flex flex-col gap-1.5 w-full items-stretch text-left">
              <label for="password" class="label text-[#f7e6bc] font-bold text-sm sm:text-md pl-1">Password</label>
              <input type="password" name="password" class="input bg-[#f7e6bc] w-full text-stone-900 px-4 py-2.5 rounded-lg" placeholder="******" id="password" />
            </div>

            <button type="submit" class="btn btnImage w-full mt-2 font-bold py-2.5 transition transform active:scale-95">
              Masuk
            </button>
          </form>

          <div class="flex flex-wrap items-center gap-2 justify-center mt-4 text-sm sm:text-base">
            <span class="text-[#f7e6bc]">Belum punya akun?</span>
            <a href="{{ route('register') }}" class="text-[#eaa743] font-bold hover:underline">Daftar</a>
          </div>
        </div>

      </div>
    </div>

  </div>
@endsection