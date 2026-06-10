@extends('layouts.auth')
@section('title', 'Register Akun')

@section('content')
  <div class="container mx-auto text-center pt-16 pb-12 px-4 min-h-screen flex flex-col items-center justify-center gap-6 sm:gap-8">
    
    <img src="{{ asset('assets/img/lakutani2.png') }}" alt="LakuTani Logo" class="bg-transparent w-48 sm:w-64 max-w-full object-contain">
    
    <div class="card bg-base-100 w-full max-w-md shadow-2xl rounded-xl overflow-hidden">
      <div class="card-body woodCardImage p-6 sm:p-8">
        
        <h2 class="text-[#f7e6bc] text-xl sm:text-2xl text-center font-bold tracking-wide mb-2">
          Daftar Akun Baru
        </h2>

        <div class="flex flex-col gap-4">
          <form action="{{ route('signUp') }}" method="POST" class="flex flex-col gap-4 w-full">
            @csrf
            
            <div class="flex flex-col gap-1.5 w-full items-stretch text-left">
              <label for="name" class="label text-[#f7e6bc] font-bold text-sm sm:text-md pl-1">Username</label>
              <input type="text" name="name" class="input bg-[#f7e6bc] w-full text-stone-900 px-4 py-2.5 rounded-lg" placeholder="Ketik nama pengguna" id="name" value="{{ old('name') }}" />
            </div>
            
            <div class="flex flex-col gap-1.5 w-full items-stretch text-left">
              <label for="email" class="label text-[#f7e6bc] font-bold text-sm sm:text-md pl-1">Email</label>
              <input type="email" name="email" class="input bg-[#f7e6bc] w-full text-stone-900 px-4 py-2.5 rounded-lg" placeholder="Masukkan email aktif" id="email" value="{{ old('email') }}" />
            </div>
            
            <div class="flex flex-col gap-1.5 w-full items-stretch text-left">
              <label for="password" class="label text-[#f7e6bc] font-bold text-sm sm:text-md pl-1">Password</label>
              <input type="password" name="password" class="input bg-[#f7e6bc] w-full text-stone-900 px-4 py-2.5 rounded-lg" placeholder="******" id="password" />
            </div>
            
            <div class="flex flex-col gap-1.5 w-full items-stretch text-left">
              <label for="password_confirmation" class="label text-[#f7e6bc] font-bold text-sm sm:text-md pl-1">Konfirmasi Password</label>
              <input type="password" name="password_confirmation" class="input bg-[#f7e6bc] w-full text-stone-900 px-4 py-2.5 rounded-lg" placeholder="******" id="password_confirmation" />
            </div>

            <button type="submit" class="btn btnImage w-full mt-2 font-bold py-2.5 transition transform active:scale-95">
              Daftar Sekarang
            </button>
          </form>

          <div class="flex flex-wrap items-center gap-2 justify-center mt-4 text-sm sm:text-base">
            <span class="text-[#f7e6bc]">Sudah punya akun?</span>
            <a href="{{ route('login') }}" class="text-[#eaa743] font-bold hover:underline">Masuk</a>
          </div>
        </div>

      </div>
    </div>

  </div>
@endsection