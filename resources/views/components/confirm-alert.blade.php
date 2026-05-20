<h3 class="capitzlize text-slate-100">{{ Auth::user()->name }}</h3>
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
          <span class="icon-[tabler--x] size-4"></span>
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
</div>
