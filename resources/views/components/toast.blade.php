<div class="toast toast-end">

  {{-- Error --}}
  @if ($errors->any())
    @foreach ($errors->all() as $error)
      <div class="alert bg-red-400">
				<i class="ti ti-alert-circle"></i>
        <span>{{ $error }}</span>
      </div>
    @endforeach
  @endif

  {{-- Success --}}
  @if (session('success'))
    <div class="alert alert-success">
      <span>{{ session('success') }}</span>
    </div>
  @endif

</div>


<script>
  setTimeout(() => {
    document.querySelectorAll('.toast').forEach(el => el.remove());
  }, 5000);
</script>
