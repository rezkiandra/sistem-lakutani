<div class="absolute w-full">
  <nav class="navbar shadow-base-300/20 shadow-sm navImage">
    <div class="navbar-start">
      <a class="flex items-center justify-center gap-4 link text-base-content link-neutral text-xl font-bold no-underline"
        href="{{ route('beranda') }}">
        <img src="{{ asset('assets/img/icon.png') }}" alt="icon" class="bg-transparent w-12">
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
    </div>
    <div class="navbar-end items-center gap-4">
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
