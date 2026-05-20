<div class="absolute w-full">
  <nav class="navbar shadow-base-300/20 shadow-sm navImage">
    <div class="navbar-start">
      <a class="flex items-center justify-center gap-4 link text-base-content link-neutral text-xl font-bold no-underline"
        href="{{ route('beranda') }}">
        {{-- <img src="{{ asset('assets/img/icon.png') }}" alt="icon" class="bg-transparent w-12"> --}}
        <img src="{{ asset('assets/img/hero.png') }}" alt="banner" class="bg-transparent w-40">
      </a>
    </div>
    <div class="navbar-center">
      @guest
        <ul class="menu menu-horizontal gap-2 p-0 text-base hover:text-red-500">
          <li class="text-slate-100"><a href="{{ route('beranda') }}">Beranda</a></li>
          <li class="text-slate-100"><a href="{{ route('informasi') }}">Informasi</a></li>
          <li class="text-slate-100"><a href="{{ route('layanan') }}">Layanan</a></li>
        </ul>
      @endguest

      @auth
        <div class="dropdown relative inline-flex">
          <button id="dropdown-default" type="button" class="flex self-center items-center gap-1 dropdown-toggle text-base text-slate-100" aria-haspopup="menu"
            aria-expanded="false" aria-label="Dropdown">
            Keuangan
            <i class="ti ti-chevron-down"></i>
            <span class="icon-[tabler--chevron-down] dropdown-open:rotate-180 size-4"></span>
          </button>
          <ul class="dropdown-menu dropdown-open:opacity-100 hidden min-w-60" role="menu" aria-orientation="vertical"
            aria-labelledby="dropdown-default">
            <li><a class="dropdown-item" href="{{ route('produksi.index') }}">Produksi</a></li>
            <li><a class="dropdown-item" href="{{ route('pendapatan.index') }}">Pendapatan</a></li>
            <li><a class="dropdown-item" href="{{ route('laba.index') }}">Laba</a></li>
            <li><a class="dropdown-item" href="{{ route('rugi.index') }}">Rugi</a></li>
          </ul>
        </div>

        <ul class="menu menu-horizontal gap-2 p-0 text-base hover:text-red-500">
          <li class="text-slate-100"><a href="{{ route('layanan') }}">Analisis</a></li>
        </ul>
      @endauth
    </div>
    <div class="navbar-end items-center gap-4">
      <div class="dropdown relative inline-flex [--placement:bottom]">
        <button id="dropdown-default" type="button" class="dropdown-toggle btn btn-text btn-secondary btn-square"
          aria-haspopup="menu" aria-expanded="false" aria-label="Dropdown">
          <span class="icon-[tabler--menu-2] dropdown-open:hidden size-5"></span>
          <span class="icon-[tabler--x] dropdown-open:block hidden size-5"></span>
        </button>
        <ul class="dropdown-menu dropdown-open:opacity-100 hidden min-w-60" role="menu" aria-orientation="vertical"
          aria-labelledby="dropdown-default">
          <li class="dropdown relative [--auto-close:inside] [--offset:9] [--placement:bottom]">
            <button id="dropdown-end-2"
              class="dropdown-toggle dropdown-item dropdown-open:bg-base-content/10 dropdown-open:text-base-content justify-between"
              aria-haspopup="menu" aria-expanded="false" aria-label="Dropdown">
              Products
              <span class="icon-[tabler--chevron-right] size-4 rtl:rotate-180"></span>
            </button>
            <ul class="dropdown-menu dropdown-open:opacity-100 hidden w-48" role="menu" aria-orientation="vertical"
              aria-labelledby="nested-dropdown">
              <li><a class="dropdown-item" href="#">Templates</a></li>
              <li><a class="dropdown-item" href="#">UI kits</a></li>
              <li
                class="dropdown relative [--auto-close:inside] [--offset:10] md:[--placement:right-start] [--placement:bottom]">
                <button id="nested-dropdown-2"
                  class="dropdown-toggle dropdown-item dropdown-open:bg-base-content/10 dropdown-open:text-base-content justify-between"
                  aria-haspopup="menu" aria-expanded="false" aria-label="Dropdown">
                  Components
                  <span class="icon-[tabler--chevron-right] size-4 rtl:rotate-180"></span>
                </button>
                <ul class="dropdown-menu dropdown-open:opacity-100 hidden w-48" role="menu"
                  aria-orientation="vertical" aria-labelledby="nested-dropdown-2">
                  <li><a class="dropdown-item" href="#">Basic</a></li>
                  <li>
                    <a class="dropdown-item" href="#">
                      Advanced
                      <span class="badge badge-sm badge-soft badge-primary rounded-full">Pro</span>
                    </a>
                  </li>
                  <li
                    class="dropdown relative [--auto-close:inside] [--offset:10] md:[--placement:right-start] [--placement:bottom]">
                    <button id="nested-dropdown-2"
                      class="dropdown-toggle dropdown-item dropdown-open:bg-base-content/10 dropdown-open:text-base-content justify-between"
                      aria-haspopup="menu" aria-expanded="false" aria-label="Dropdown">
                      Vendor
                      <span class="icon-[tabler--chevron-right] size-4 rtl:rotate-180"></span>
                    </button>
                    <ul class="dropdown-menu dropdown-open:opacity-100 hidden w-48" role="menu"
                      aria-orientation="vertical" aria-labelledby="nested-dropdown-2">
                      <li>
                        <a class="dropdown-item" href="#">
                          Data tables
                          <span class="badge badge-sm badge-soft badge-primary rounded-full">Pro</span>
                        </a>
                      </li>
                      <li>
                        <a class="dropdown-item" href="#">
                          Apex charts
                          <span class="badge badge-sm badge-soft badge-primary rounded-full">Pro</span>
                        </a>
                      </li>
                      <li><a class="dropdown-item" href="#">Clipboard</a></li>
                    </ul>
                  </li>
                </ul>
              </li>
            </ul>
          </li>
        </ul>
      </div>
      @if (Auth::check())
        @include('components.confirm-alert')
      @else
        <a class="btn btnImage" href="{{ route('login') }}">
          Login
        </a>
      @endif
    </div>
  </nav>
</div>
