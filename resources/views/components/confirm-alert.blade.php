<h3 class="text-uppercase">Hello World</h3>
<button onclick="document.getElementById('logoutModal').showModal()" class="btn btn-error border-2 border-red-800">
  Logout
</button>

<dialog id="logoutModal" class="modal">
  <div class="modal-box">
    <h3 class="font-bold text-lg">Konfirmasi</h3>
    <p class="py-4">Apakah Anda yakin ingin logout?</p>

    <div class="modal-action">
      <form method="dialog">	
        <button class="btn">Batal</button>
      </form>

      <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-error">
          Logout
        </button>
      </form>
    </div>

  </div>
</dialog>
