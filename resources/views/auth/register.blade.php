@extends('layouts.auth')
@section('title', 'Register Akun')

@section('content')
  <div class="container mx-auto text-center pt-16 min-h-screen flex flex-col items-center justify-center gap-8">
    <img src="{{ asset('assets/img/lakutani2.png') }}" alt="" class="bg-transparent w-64">
    <div class="card bg-base-100 w-96 shadow-2xl rounded-xl">
      {{-- <div class="card-header cardImage h-50 w-full"></div> --}}
      <div class="card-body woodCardImage">
        <h2 class="text-base-100 text-2xl text-center font-bold">
          Login
        </h2>

        <div class="flex flex-col gap-4">
          <form action="{{ route('signUp') }}" method="POST" class="flex flex-col gap-3">
            @csrf
            <div class="flex flex-col justify-center items-center gap-2">
              <label for="name" class="label text-[#f7e6bc] shadow-lg font-bold text-md self-start pl-2">Username</label>
              <input type="text" name="name" class="input bg-[#f7e6bc] w-80" placeholder="Type here" id="name" value="{{ old('name') }}" />
            </div>
            <div class="flex flex-col justify-center items-center gap-2">
              <label for="email" class="label text-[#f7e6bc] shadow-lg font-bold text-md self-start pl-2">Email</label>
              <input type="email" name="email" class="input bg-[#f7e6bc] w-80" placeholder="Type here" id="email" value="{{ old('email') }}" />
            </div>
            <div class="flex flex-col justify-center items-center gap-2">
              <label for="password"
                class="label text-[#f7e6bc] shadow-lg font-bold text-md self-start pl-2">Password</label>
              <input type="password" name="password" class="input bg-[#f7e6bc] w-80" placeholder="******" id="password" />
            </div>
						<div class="flex flex-col justify-center items-center gap-2">
							<label for="password_confirmation"
								class="label text-[#f7e6bc] shadow-lg font-bold text-md self-start pl-2">Konfirmasi Password</label>
							<input type="password" name="password_confirmation" class="input bg-[#f7e6bc] w-80" placeholder="******" id="password_confirmation" />
						</div>

            <button type="submit" class="btn btnImage mx-2 w-80">
              Masuk
            </button>
          </form>

          <div class="flex items-center gap-2 justify-center mt-5">
            <span class="text-[#f7e6bc]">Sudah punya akun?</span>
            <a href="{{ route('login') }}" class="text-[#eaa743] font-bold">Masuk</a>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
