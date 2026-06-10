@extends('layouts.app')

@section('title', 'Pengaturan Akun')

@section('content')
  <div class="container mx-auto text-center pt-24 pb-12 px-4 min-h-screen flex items-center justify-center">

    <div class="flex flex-col items-center justify-center w-full max-w-6xl">

      <div class="mb-8 text-center">
        <h2 class="text-2xl font-bold text-slate-800 flex items-center justify-center gap-2">
          <i class="ti ti-settings text-3xl text-slate-600"></i>
          Pengaturan Akun
        </h2>
        <p class="text-sm text-slate-800 mt-1">Perbarui data diri dan kata sandi akun Anda secara berkala.</p>
      </div>

      <div class="bg-white border border-slate-200 rounded-xl p-6 md:p-8 shadow-sm w-full max-w-2xl text-left">

        <form action="{{ route('profile.update') }}" method="POST">
          @csrf
          @method('PUT')

          <div class="grid grid-cols-1 gap-5">

            <div class="flex flex-col gap-1.5">
              <label for="name" class="text-sm font-semibold text-slate-700">Nama Lengkap</label>
              <input type="text" name="name" id="name"
                class="input border border-slate-300 rounded-lg p-2.5 text-sm focus:outline-none focus:border-slate-500 @error('name') border-red-500 @enderror"
                value="{{ old('name', $user->name) }}" required>
              @error('name')
                <span class="text-xs text-red-500 mt-0.5">{{ $message }}</span>
              @enderror
            </div>

            <div class="flex flex-col gap-1.5">
              <label for="email" class="text-sm font-semibold text-slate-700">Alamat Email</label>
              <input type="email" name="email" id="email"
                class="input border border-slate-300 rounded-lg p-2.5 text-sm focus:outline-none focus:border-slate-500 @error('email') border-red-500 @enderror"
                value="{{ old('email', $user->email) }}" required>
              @error('email')
                <span class="text-xs text-red-500 mt-0.5">{{ $message }}</span>
              @enderror
            </div>

            <div class="border-t border-slate-100 my-2"></div>

            <div>
              <h3 class="text-sm font-bold text-slate-800 flex items-center gap-1.5">
                <i class="ti ti-lock text-base text-slate-500"></i>
                Ubah Kata Sandi
              </h3>
              <p class="text-xs text-slate-400 mt-0.5">Kosongkan kolom di bawah ini jika Anda tidak ingin mengganti kata
                sandi.</p>
            </div>

            <div class="flex flex-col gap-1.5">
              <label for="password" class="text-sm font-semibold text-slate-700">Kata Sandi Baru</label>
              <input type="password" name="password" id="password"
                class="input border border-slate-300 rounded-lg p-2.5 text-sm focus:outline-none focus:border-slate-500 @error('password') border-red-500 @enderror"
                placeholder="Minimal 8 karakter">
              @error('password')
                <span class="text-xs text-red-500 mt-0.5">{{ $message }}</span>
              @enderror
            </div>

            <div class="flex flex-col gap-1.5">
              <label for="password_confirmation" class="text-sm font-semibold text-slate-700">Konfirmasi Kata Sandi
                Baru</label>
              <input type="password" name="password_confirmation" id="password_confirmation"
                class="input border border-slate-300 rounded-lg p-2.5 text-sm focus:outline-none focus:border-slate-500"
                placeholder="Ulangi kata sandi baru">
            </div>

          </div>

          <div class="flex justify-end gap-3 mt-8 pt-4 border-t border-slate-100">
            <a href="{{ url()->previous() }}" class="btn btn-secondary btn-md flex items-center justify-center gap-2">
              Batal
            </a>
            <button type="submit" class="btn btn-success btn-md flex items-center justify-center gap-2 px-6">
              <i class="ti ti-device-floppy text-base"></i>
              Simpan Perubahan
            </button>
          </div>

        </form>
      </div>

    </div>
  </div>

  {{-- Script SweetAlert2 untuk Trigger Alert Berhasil --}}
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
