<div class="navbar bg-wood shadow-sm"
  style="background: url('{{ asset('assets/img/wood.png') }}'); background-position: center; background-size: cover;">
  <div class="navbar-start">
    <div class="dropdown">
      <div tabindex="0" role="button" class="btn btn-ghost lg:hidden">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16" />
        </svg>
      </div>
      <ul tabindex="-1" class="menu menu-sm dropdown-content bg-base-100 rounded-box z-1 mt-3 w-52 p-2 shadow">
        <li><a>Home</a></li>
        <li>
          <a>Berita</a>
          <ul class="p-2">
            <li><a>Submenu 1</a></li>
            <li><a>Submenu 2</a></li>
          </ul>
        </li>
        <li><a>Alat</a></li>
      </ul>
    </div>
    <a class="btn btn-ghost text-xl hover:bg-transparent">
      <img src="{{ asset('assets/fonts/icons/icon.svg') }}" alt="" class="w-8">
      <span class="font-bold text-slate-200">Lakutani</span>
    </a>
  </div>

  <div class="navbar-end gap-4">
    <ul class="menu menu-horizontal px-8">
      <li class="font-bold text-slate-200"><a>Home</a></li>
      <li class="font-bold text-slate-200">
        <details>
          <summary>Berita</summary>
          <ul class="p-2 bg-base-100 w-40 z-1">
            <li class="font-bold text-slate-800"><a>Submenu 1</a></li>
            <li class="font-bold text-slate-800"><a>Submenu 2</a></li>
          </ul>
        </details>
      </li>
      <li class="font-bold text-slate-200"><a>Alat</a></li>
    </ul>

    <a class="btn bg-green-900 text-slate-200 border-green-950 border-2">Kelayakan</a>
    <a class="btn bg-yellow-600 border-yellow-700 border-2">Login</a>
  </div>
</div>
