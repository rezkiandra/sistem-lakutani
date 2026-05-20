@extends('layouts.auth')
@section('title', 'Login Akun')

@section('content')
  <div class="container mx-auto text-center pt-16 min-h-screen flex items-center justify-center">
    <div class="card bg-base-100 w-96 shadow-2xl rounded-xl">
      <div class="card-header cardImage h-50 w-full"></div>
      <div class="card-body woodCardImage">
        <h2 class="card-title">
          <img src="{{ asset('assets/img/hero.png') }}" alt="" class="w-40 mx-auto my-4">
        </h2>

        <div class="flex flex-col gap-4">
          <form action="{{ route('signIn') }}" method="POST" class="flex flex-col gap-3">
            @csrf
            <div class="flex flex-col justify-center items-center gap-2">
              <label for="email" class="label text-[#f7e6bc] shadow-lg font-bold text-md self-start pl-2">Email</label>
              <input type="email" name="email" autocomplete="off" class="input bg-[#f7e6bc] w-80" placeholder="Type here" id="email" value="{{ old('email') }}" />
            </div>
            <div class="flex flex-col justify-center items-center gap-2">
              <label for="password"
                class="label text-[#f7e6bc] shadow-lg font-bold text-md self-start pl-2">Password</label>
              <input type="password" name="password" class="input bg-[#f7e6bc] w-80" placeholder="******" id="password" />
            </div>

            <button class="btn btnImage mx-2 w-80">
              Masuk
            </button>
          </form>

          <div class="flex items-center gap-2 justify-center mt-5">
            <span class="text-[#f7e6bc]">Belum punya akun?</span>
            <a href="{{ route('register') }}" class="text-[#eaa743] font-bold">Daftar</a>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
