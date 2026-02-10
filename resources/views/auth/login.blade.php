@extends('layouts.guest')
@section('title', 'Login Akun')

@section('content')
  <div class="container mx-auto text-center pt-16 min-h-screen flex items-center justify-center">
    <div class="card bg-base-100 w-96 shadow-2xl rounded-xl">
      <div class="card-header cardImage h-50 w-full"></div>
      <div class="card-body woodCardImage">
        <h2 class="card-title">
          <img src="{{ asset('assets/img/hero.png') }}" alt="" class="w-40 mx-auto my-4">
        </h2>

        <label for="email" class="label text- text-base font-bold">Email</label>
        <input type="email" class="input" placeholder="Type here" id="email" />

        <div class="card-actions justify-end">
          <button class="btn btn-primary">Buy Now</button>
        </div>
      </div>
    </div>
  </div>
@endsection
