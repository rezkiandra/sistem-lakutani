@extends('layouts.app')
@section('title', 'Daftar Pengguna')

@section('content')
  <div class="container mx-auto min-h-screen flex flex-col items-center justify-start px-2 sm:px-4">
    <div class="w-full max-w-5xl mt-20 lg:mt-30 md:mt-30 mb-10">
      <div class="card bg-base-200 shadow-xl overflow-hidden">

        <div class="card-header woodImage p-4 md:p-5">
          <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
              <h1 class="text-2xl md:text-3xl font-bold text-slate-100 mb-1">👥 Daftar Pengguna</h1>
              <span class="text-xs md:text-sm text-slate-100 block">Kelola data seluruh pengguna sistem dan hak akses
                akun</span>
            </div>

            <a href="{{ route('admin.createUser') }}"
              class="btn btn-sm greenImage text-slate-100 self-start sm:self-center border-none">
              <i class="ti ti-plus"></i> Tambah User
            </a>
          </div>
        </div>

        <div class="card-body p-0">
          <div class="w-full overflow-x-auto">
            <table class="table table-md w-full min-w-[600px]">
              <thead>
                <tr class="bg-base-100/80">
                  <th class="w-12 text-center">No</th>
                  <th>Nama Lengkap</th>
                  <th>Alamat Email</th>
                  <th>Tanggal Bergabung</th>
                  <th class="w-28 text-center">Aksi</th>
                </tr>
              </thead>
              <tbody>
                @forelse($users as $index => $user)
                  <tr class="hover:bg-base-100/50 transition-all">
                    <td class="text-center font-medium text-xs sm:text-sm">{{ $users->firstItem() + $index }}</td>
                    <td>
                      <div class="flex items-center gap-2">
                        <div class="avatar avatar-placeholder shrink-0">
                          <div class="bg-primary/20 text-primary rounded-full size-7 text-xs font-bold">
                            {{ strtoupper(substr($user->name, 0, 2)) }}
                          </div>
                        </div>
                        <span class="text-sm font-medium whitespace-nowrap">{{ $user->name }}</span>
                      </div>
                    </td>
                    <td class="text-xs sm:text-sm text-base-content/70">{{ $user->email }}</td>
                    <td class="text-xs sm:text-sm">{{ $user->created_at?->translatedFormat('d F Y') ?? '-' }}</td>
                    <td class="text-center">
                      <div class="flex items-center justify-center gap-1.5">
                        <a href="{{ route('admin.editUser', Crypt::encryptString($user->id)) }}"
                          class="btn btn-square btn-sm btn-ghost text-info" title="Edit">
                          <i class="ti ti-edit text-lg"></i>
                        </a>

                        <button type="button"
                          onclick="konfirmasiHapus(event, 'form-delete-user-{{ $user->id }}', 'Pengguna: {{ $user->name }}')"
                          class="btn btn-square btn-sm btn-ghost text-error" title="Hapus">
                          <i class="ti ti-trash text-lg"></i>
                        </button>
                        <form id="form-delete-user-{{ $user->id }}"
                          action="{{ route('admin.destroyUser', $user->id) }}" method="POST" class="hidden">
                          @csrf @method('DELETE')
                        </form>
                      </div>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="5" class="text-center py-10 text-base-content/50 text-sm">Belum ada data pengguna.
                    </td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
          @if ($users->hasPages())
            <div class="p-4 border-t border-base-content/10 flex justify-center bg-base-100/20">{{ $users->links() }}
            </div>
          @endif
        </div>

      </div>
    </div>
  </div>
@endsection

@push('js')
  @include('partials.sweetalert-delete')
@endpush
