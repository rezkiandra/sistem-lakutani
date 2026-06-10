{{-- <h3 class="capitzlize text-slate-100">{{ Auth::user()->name }}</h3> --}}
@auth
  <div class="dropdown relative inline-flex">
    <button id="dropdown-menu-icon" type="button" class="dropdown-toggle btn btn-sm btn-info" aria-haspopup="menu"
      aria-expanded="false" aria-label="Dropdown">
      <i class="ti ti-user"></i>
      <span>{{ Auth::user()->name }}</span>
    </button>
    <ul class="dropdown-menu dropdown-open:opacity-100 hidden min-w-60" role="menu" aria-orientation="vertical"
      aria-labelledby="dropdown-menu-icon">
      @auth
        @if (Auth::user()->role === 'admin')
          <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">
              <i class="ti ti-layout-dashboard text-lg"></i>
              Dashboard
            </a></li>
          <li><a class="dropdown-item" href="{{ route('admin.produksis') }}">
              <i class="ti ti-database text-lg"></i>
              Data Produksi
            </a></li>
          <li><a class="dropdown-item" href="{{ route('admin.keuangans') }}">
              <i class="ti ti-coin text-lg"></i>
              Data Keuangan
            </a></li>
          <li><a class="dropdown-item" href="{{ route('admin.users') }}">
              <i class="ti ti-users text-lg"></i>
              Kelola Pengguna
            </a></li>
          <li><a class="dropdown-item" href="{{ route('admin.kelayakans') }}">
              <i class="ti ti-shield text-lg"></i>
              Uji Kelayakan
            </a></li>
        @else
          <li><a class="dropdown-item" href="{{ route('petani.dashboard') }}">
              <i class="ti ti-layout-dashboard text-lg"></i>
              Dashboard
            </a></li>
          <li><a class="dropdown-item" href="{{ route('petani.produksi') }}">
              <i class="ti ti-tractor text-lg"></i>
              Usaha Tani
            </a></li>
          <li><a class="dropdown-item" href="{{ route('petani.catatKeuangan') }}">
              <i class="ti ti-coin-euro text-lg"></i>
              Catat Keuangan
            </a></li>
        @endif
        <li class="divider"></li>
        <li><a href="{{ route('profile.edit') }}" class="dropdown-item" href="#">
            <i class="ti ti-settings text-lg"></i>
            Pengaturan
          </a></li>
      @endauth
    </ul>
  </div>
@endauth

<button type="button" class="btn btn-sm btn-error w-full sm:w-auto justify-center text-white"
  onclick="konfirmasiLogout()">
  <i class="ti ti-logout"></i>
  Logout
</button>

@push('js')
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    function konfirmasiLogout() {
      Swal.fire({
        title: 'Konfirmasi Keluar',
        text: 'Apakah anda yakin ingin logout dari sistem?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#ef4444', // Warna Merah (btn-error)
        cancelButtonColor: '#6b7280', // Warna Abu-abu
        confirmButtonText: 'Yakin, Keluar',
        cancelButtonText: 'Batal',
        reverseButtons: true, // Tombol 'Batal' di kiri, 'Yakin' di kanan
        focusCancel: true // Otomatis fokus ke tombol Batal demi keamanan
      }).then((result) => {
        /* Jika user mengklik tombol 'Yakin, Keluar' */
        if (result.isConfirmed) {
          document.getElementById('form-logout').submit();
        }
      });
    }
  </script>
@endpush
