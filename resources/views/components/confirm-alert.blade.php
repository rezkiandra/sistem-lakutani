{{-- <h3 class="capitzlize text-slate-100">{{ Auth::user()->name }}</h3> --}}
@auth
  <div class="dropdown relative inline-flex">
    <button id="dropdown-menu-icon" type="button" class="dropdown-toggle btn btn-info" aria-haspopup="menu"
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
          <li><a class="dropdown-item" href="{{ route('admin.users') }}">
              <i class="ti ti-users text-lg"></i>
              Kelola Pengguna
            </a></li>
        @else
          <li><a class="dropdown-item" href="{{ route('petani.dashboard') }}">
              <i class="ti ti-layout-dashboard text-lg"></i>
              Dashboard
            </a></li>
          <li><a class="dropdown-item" href="{{ route('petani.produksi') }}">
              <i class="ti ti-tractor text-lg"></i>
              Produksi
            </a></li>
          <li><a class="dropdown-item" href="{{ route('petani.catatKeuangan') }}">
              <i class="ti ti-coin-euro text-lg"></i>
              Catat Keuangan
            </a></li>
        @endif
        <li class="divider"></li>
        <li><a class="dropdown-item" href="#">
            <i class="ti ti-settings text-lg"></i>
            Pengaturan
          </a></li>
      @endauth
    </ul>
  </div>
@endauth

<button type="button" class="btn btn-error" aria-haspopup="dialog" aria-expanded="false" aria-controls="basic-modal"
  data-overlay="#basic-modal">Logout</button>

<div id="basic-modal" class="overlay modal overlay-open:opacity-100 hidden overlay-open:duration-300" role="dialog"
  tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title">Sistem</h3>
        <button type="button" class="btn btn-text btn-circle btn-sm absolute end-3 top-3" aria-label="Close"
          data-overlay="#basic-modal">
          <i class="ti ti-x] text-lg"></i>
        </button>
      </div>
      <div class="modal-body">
        Apakah anda yakin ingin logout dari sistem?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-soft btn-success" data-overlay="#basic-modal">Batal</button>
        <form action="{{ route('logout') }}" method="POST">
          @csrf
          <button type="submit" class="btn btn-error">
            Yakin
          </button>
        </form>
      </div>
    </div>
  </div>
</div>
