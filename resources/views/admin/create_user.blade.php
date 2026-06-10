@extends('layouts.app')

@section('title', 'Tambah Pengguna Baru')

@section('content')
  <div class="container mx-auto text-center pt-24 pb-12 px-4 min-h-screen flex items-center justify-center">
    <div class="flex flex-col items-center justify-center w-full max-w-6xl">

      <div class="mb-8 text-center">
        <h2 class="text-2xl font-bold text-slate-800 flex items-center justify-center gap-2">
          <i class="ti ti-user-plus text-3xl text-slate-600"></i>
          Tambah Pengguna Baru
        </h2>
        <p class="text-sm text-slate-800 mt-1">Dafrarkan akun pengguna baru ke dalam sistem aplikasi.</p>
      </div>

      <div class="bg-white border border-slate-200 rounded-xl p-6 md:p-8 shadow-sm w-full max-w-2xl text-left">
        <form action="{{ route('admin.storeUser') }}" method="POST">
          @csrf

          <div class="grid grid-cols-1 gap-5">

            <div class="flex flex-col gap-1.5">
              <label for="name" class="text-sm font-semibold text-slate-700">Nama Lengkap</label>
              <input type="text" name="name" id="name"
                class="input border border-slate-300 rounded-lg p-2.5 text-sm focus:outline-none focus:border-slate-500 @error('name') border-red-500 @enderror"
                value="{{ old('name') }}" placeholder="Masukkan nama lengkap" required>
              @error('name')
                <span class="text-xs text-red-500 mt-0.5">{{ $message }}</span>
              @enderror
            </div>

            <div class="flex flex-col gap-1.5">
              <label for="email" class="text-sm font-semibold text-slate-700">Alamat Email</label>
              <input type="email" name="email" id="email"
                class="input border border-slate-300 rounded-lg p-2.5 text-sm focus:outline-none focus:border-slate-500 @error('email') border-red-500 @enderror"
                value="{{ old('email') }}" placeholder="contoh@gmail.com" required>
              @error('email')
                <span class="text-xs text-red-500 mt-0.5">{{ $message }}</span>
              @enderror
            </div>

            <div class="border-t border-slate-100 my-2"></div>

            <div>
              <h3 class="text-sm font-bold text-slate-800 flex items-center gap-1.5">
                <i class="ti ti-key text-base text-slate-500"></i>
                Kata Sandi Akun
              </h3>
              <p class="text-xs text-slate-400 mt-0.5">Tentukan kata sandi awal untuk pengguna baru ini.</p>
            </div>

            <div class="flex flex-col gap-1.5">
              <label for="password" class="text-sm font-semibold text-slate-700">Kata Sandi</label>
              <input type="password" name="password" id="password"
                class="input border border-slate-300 rounded-lg p-2.5 text-sm focus:outline-none focus:border-slate-500 @error('password') border-red-500 @enderror"
                placeholder="Minimal 8 karakter" required>
              @error('password')
                <span class="text-xs text-red-500 mt-0.5">{{ $message }}</span>
              @enderror
            </div>

            <div class="flex flex-col gap-1.5">
              <label for="password_confirmation" class="text-sm font-semibold text-slate-700">Konfirmasi Kata
                Sandi</label>
              <input type="password" name="password_confirmation" id="password_confirmation"
                class="input border border-slate-300 rounded-lg p-2.5 text-sm focus:outline-none focus:border-slate-500"
                placeholder="Ulangi kata sandi" required>
            </div>

          </div>

          <div class="flex justify-end gap-3 mt-8 pt-4 border-t border-slate-100">
            <a href="{{ route('admin.users') }}" class="btn btn-secondary btn-md flex items-center justify-center gap-2">
              Batal
            </a>
            <button type="submit" class="btn btn-success btn-md flex items-center justify-center gap-2 px-6">
              <i class="ti ti-device-floppy text-base"></i>
              Simpan Pengguna
            </button>
          </div>

        </form>
      </div>

    </div>
  </div>

  {{-- Script SweetAlert2 --}}
  @if (session('success'))
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
      Swal.fire({
        title: 'Berhasil!',
        text: "{{ session('success') }}",
        icon: 'success',
        confirmButtonColor: '#16a34a',
        timer: 3000,
        timerProgressBar: true
      });
    </script>
  @endif
@endsection
