<div class="absolute w-full z-50">
  <nav class="navbar shadow-base-300/20 shadow-sm navImage justify-between items-center px-4">

    <div class="navbar-start">
      <a class="flex items-center gap-2 sm:gap-4 link text-base-content link-neutral text-xl font-bold no-underline"
        href="{{ route('beranda') }}">
        <img src="{{ asset('assets/img/icon.png') }}" alt="icon" class="bg-transparent w-10 sm:w-12">
        <img src="{{ asset('assets/img/hero.png') }}" alt="banner" class="bg-transparent w-32 sm:w-40">
      </a>
    </div>

    {{-- ===== DESKTOP ===== --}}
    <div class="hidden lg:flex items-center gap-4 navbar-end">
      {{-- Menu Utama selalu tampil di desktop --}}
      <ul class="menu menu-horizontal gap-4 p-0 text-base">
        {{-- <li class="text-slate-100"><a href="{{ route('beranda') }}">Beranda</a></li> --}}
        <li class="text-slate-100"><a href="{{ route('informasi') }}">Informasi</a></li>
        <li class="text-slate-100"><a href="{{ route('layanan') }}">Layanan</a></li>
        <li class="text-slate-100"><a href="{{ route('cuaca') }}">iCare</a></li>
      </ul>

      <div class="flex items-center gap-2">
        @if (Auth::check())
          @include('components.confirm-alert')
        @else
          <a class="btn btn-sm greenImage" href="{{ route('login') }}">Kelayakan</a>
          <a class="btn btn-sm btnImage" href="{{ route('login') }}">Login</a>
        @endif
      </div>
    </div>

    {{-- ===== MOBILE ===== --}}
    <div class="flex lg:hidden items-center navbar-end">
      <div class="dropdown relative inline-flex [--placement:bottom-end]">
        <button id="hamburger-menu-mobile" type="button" class="dropdown-toggle btn btn-text btn-circle text-slate-100"
          aria-haspopup="menu" aria-expanded="false" aria-label="Toggle Navigation">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 dropdown-open:hidden" fill="none"
            viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
          </svg>
        </button>

        <ul
          class="dropdown-menu dropdown-open:opacity-100 hidden menu bg-base-100 rounded-box z-[1] mt-3 w-56 p-2 shadow-xl gap-1 text-base-content"
          role="menu" aria-orientation="vertical" aria-labelledby="hamburger-menu-mobile">

          {{-- Menu Publik Mobile (Selalu Tampil) --}}
          {{-- <li><a href="{{ route('beranda') }}"><i class="ti ti-home text-lg"></i> Beranda</a></li> --}}
          <li><a href="{{ route('informasi') }}"><i class="ti ti-info-circle text-lg"></i> Informasi</a></li>
          <li><a href="{{ route('layanan') }}"><i class="ti ti-server text-lg"></i> Layanan</a></li>
          <li><a href="{{ route('cuaca') }}"><i class="ti ti-temperature-sun text-lg"></i> iCare</a></li>
          <hr class="border-base-content/10 my-1">

          {{-- Tampilan Mobile Jika BELUM Login --}}
          @guest
            <div class="p-1 flex flex-col gap-1">
              <a class="btn btn-sm greenImage w-full justify-center text-white" href="{{ route('login') }}">Kelayakan</a>
              <a class="btn btn-sm btnImage w-full justify-center text-white" href="{{ route('login') }}">Login</a>
            </div>
          @endguest

          {{-- Tampilan Mobile Jika SUDAH Login --}}
          @auth
            <li class="menu-title text-xs font-bold text-slate-400 px-3 py-1 border-b border-base-content/10 mb-1">
              Halo, {{ Auth::user()->name }}
            </li>

            @if (Auth::user()->role === 'admin')
              <li><a href="{{ route('admin.dashboard') }}"><i class="ti ti-layout-dashboard text-lg"></i> Dashboard</a>
              </li>
              <li><a href="{{ route('admin.produksis') }}"><i class="ti ti-database text-lg"></i> Data Produksi</a></li>
              <li><a href="{{ route('admin.keuangans') }}"><i class="ti ti-coin text-lg"></i> Data Keuangan</a></li>
              <li><a href="{{ route('admin.users') }}"><i class="ti ti-users text-lg"></i> Kelola Pengguna</a></li>
              <li><a href="{{ route('admin.kelayakans') }}"><i class="ti ti-shield text-lg"></i> Uji Kelayakan</a></li>
            @else
              <li><a href="{{ route('petani.dashboard') }}"><i class="ti ti-layout-dashboard text-lg"></i> Dashboard</a>
              </li>
              <li><a href="{{ route('petani.produksi') }}"><i class="ti ti-tractor text-lg"></i> Usaha Tani</a></li>
              <li><a href="{{ route('petani.catatKeuangan') }}"><i class="ti ti-coin-euro text-lg"></i> Catat
                  Keuangan</a></li>
            @endif

            <li><a href="{{ route('profile.edit') }}"><i class="ti ti-settings text-lg"></i> Pengaturan</a></li>
            <hr class="border-base-content/10 my-1">

            {{-- Form logout — dipanggil via SweetAlert --}}
            <form id="form-logout" action="{{ route('logout') }}" method="POST" class="hidden">
              @csrf
            </form>

            <div class="p-1">
              <button type="button" class="btn btn-sm btn-error w-full justify-center text-white"
                onclick="konfirmasiLogout()">
                <i class="ti ti-logout text-base"></i>
                Logout
              </button>
            </div>
          @endauth

        </ul>
      </div>
    </div>

  </nav>
</div>

{{-- ===== SWEETALERT LOGOUT ===== --}}
@auth
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    function konfirmasiLogout() {
      Swal.fire({
        title: 'Keluar dari Aplikasi?',
        html: `
          <div class="flex flex-col items-center gap-1 mt-1">
            <p class="text-sm text-gray-500">Halo, <strong>{{ Auth::user()->name }}</strong></p>
            <p class="text-sm text-gray-400">Yakin ingin logout sekarang?</p>
          </div>
        `,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: '<i class="ti ti-logout"></i> Ya, Logout',
        cancelButtonText: 'Batal',
        reverseButtons: true,
        focusCancel: true,
      }).then((result) => {
        if (result.isConfirmed) {
          document.getElementById('form-logout').submit();
        }
      });
    }
  </script>
@endauth
