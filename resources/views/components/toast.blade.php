<div class="toast toast-end fixed bottom-5 right-5 z-50">

  {{-- Error --}}
  @if ($errors->any())
    <div class="alert alert-error" role="alert">
      <ul>
        @foreach ($errors->all() as $error)
          <li>
            <i class="ti ti-alert-circle"></i>
            {{ $error }}
          </li>
        @endforeach
      </ul>
    </div>
  @endif

  {{-- Success --}}
  @if (session('success'))
    <div class="alert alert-success flex items-center gap-4" role="alert">
      <span class="ti ti-check"></span>
      <p>
        <span class="text-lg font-semibold">
          {{ session('success') }}
        </span>
      </p>
    </div>
  @endif

</div>

<script>
  setTimeout(() => {
    document.querySelectorAll('.toast').forEach(el => el.remove());
  }, 5000);
</script>
