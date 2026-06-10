@extends('layouts.guest')
@section('title', 'iCare')

@section('content')
  <div class="w-full min-h-screen bg-base-200/40 px-3 sm:px-4 py-4 lg:py-6">
    <div
      class="w-full max-w-[1700px] mx-auto grid grid-cols-1 lg:grid-cols-[1.2fr_1fr_340px] gap-5 lg:items-stretch mt-20 lg:mt-40">

      {{-- ==================== KOLOM KIRI (CUACA + PRAKIRAAN) ==================== --}}
      <div class="flex flex-col h-full space-y-4">

        {{-- KARTU CUACA HARI INI --}}
        <div class="card bg-base-100 shadow-sm border border-emerald-800/10 rounded-2xl p-6">
          {{-- Header Cuaca --}}
          <div class="flex items-center justify-between pb-4 mb-4 border-b border-base-content/10 gap-4">
            <div class="flex items-center gap-4">
              <img src="https://openweathermap.org/img/wn/{{ $dataCuaca['weather'][0]['icon'] ?? '01d' }}@2x.png"
                alt="Icon Cuaca" class="w-20 h-20 bg-emerald-50 rounded-full shrink-0">
              <div>
                <h2 class="text-xs md:text-xl lg:text-xl font-bold text-green-950">{{ $labelKota }}</h2>
                <p class="text-5xl font-black text-emerald-600 leading-none my-1">
                  {{ round($dataCuaca['main']['temp'] ?? 31) }}°C
                </p>
              </div>
            </div>

            <div class="flex flex-col items-end justify-end gap-2 text-right self-end h-full pt-4">
              <span class="badge badge-neutral font-semibold text-[10px] lg:text-xs md:text-md px-2.5 py-1">
                Temperatur
              </span>
              <span class="badge badge-success badge-sm font-bold capitalize text-[10px] lg:text-sm md:text-md px-3 py-2.5">
                ☁️ {{ $dataCuaca['weather'][0]['description'] ?? 'Cerah' }}
              </span>
            </div>
          </div>

          {{-- Grid Detail dengan Badge --}}
          <div class="grid grid-cols-2 gap-3">
            <div class="bg-base-200/60 rounded-xl p-4 flex flex-col justify-between gap-2">
              <span class="badge badge-info badge-sm font-semibold text-[10px] lg:text-xs px-2 py-2">💧 Kelembaban Udara</span>
              <p class="text-lg font-black text-slate-800 px-1">{{ $dataCuaca['main']['humidity'] ?? 0 }}%</p>
            </div>
            <div class="bg-base-200/60 rounded-xl p-4 flex flex-col justify-between gap-2">
              <span class="badge badge-warning badge-sm font-semibold text-[10px] lg:text-xs px-2 py-2">💨 Laju Angin</span>
              <p class="text-lg font-black text-slate-800 px-1">{{ $dataCuaca['wind']['speed'] ?? 0 }} m/s</p>
            </div>
            <div class="bg-base-200/60 rounded-xl p-4 flex flex-col justify-between gap-2">
              <span class="badge badge-error badge-sm font-semibold text-[10px] lg:text-xs px-2 py-2 text-white">⚠️ Risiko
                Penyakit</span>
              <p class="text-lg font-black text-{{ $rekomendasiTani['risiko_penyakit']['warna'] }}-700 px-1">
                {{ $rekomendasiTani['risiko_penyakit']['tingkat'] }}
              </p>
            </div>
            <div class="bg-base-200/60 rounded-xl p-4 flex flex-col justify-between gap-2">
              <span class="badge badge-ghost badge-sm font-semibold text-[10px] lg:text-xs px-2 py-2 border border-base-content/10">🌀
                Tekanan Udara</span>
              <p class="text-lg font-black text-slate-800 px-1">{{ $dataCuaca['main']['pressure'] ?? 1012 }} hPa</p>
            </div>
          </div>
        </div>

        {{-- PRAKIRAAN 5 HARI --}}
        <div
          class="card bg-base-100 shadow-sm border border-emerald-800/10 rounded-2xl p-6 flex-1 flex flex-col justify-between">
          <div>
            <h3 class="text-lg font-bold text-green-950 flex items-center gap-2 mb-4">
              <i class="ti ti-calendar-time text-emerald-600 text-xl"></i>
              Prakiraan 5 Hari Ke Depan
            </h3>
          </div>
          <div class="grid grid-cols-5 gap-3 flex-1 items-stretch">
            @foreach ($prakiraanCuaca as $hari)
              <div
                class="bg-base-200/40 rounded-xl p-3 flex flex-col items-center justify-between text-center gap-2 border border-base-content/5">
                <span class="text-sm font-bold text-slate-700">
                  {{ \Carbon\Carbon::parse($hari['tanggal'])->locale('id')->isoFormat('ddd') }}
                </span>
                <span class="text-xs text-base-content/60 font-medium">
                  {{ \Carbon\Carbon::parse($hari['tanggal'])->locale('id')->isoFormat('D MMM') }}
                </span>
                <img src="https://openweathermap.org/img/wn/{{ $hari['icon'] }}@2x.png" alt="Icon"
                  class="w-10 h-10 bg-white rounded-full shadow-sm my-0.5">
                <div class="text-sm font-bold">
                  <span class="text-emerald-700 font-extrabold">{{ round($hari['temp_max']) }}°</span>
                  <span class="text-base-content/30 mx-px">/</span>
                  <span class="text-slate-400">{{ round($hari['temp_min']) }}°</span>
                </div>
                <span class="text-xs text-slate-600 capitalize font-medium truncate w-full"
                  title="{{ $hari['deskripsi'] }}">
                  {{ $hari['deskripsi'] }}
                </span>
              </div>
            @endforeach
          </div>
        </div>
      </div>

      {{-- ==================== KOLOM TENGAH (REKOMENDASI AGRONOMI) ==================== --}}
      <div
        class="card bg-base-100 shadow-sm border border-emerald-800/10 rounded-2xl p-6 h-full flex flex-col justify-between">
        <div>
          <div class="mb-4">
            <h3 class="text-lg font-bold text-green-950 flex items-center gap-2">
              <span>💡</span> Rekomendasi Agronomi iCare
            </h3>
            <p class="text-sm text-base-content/60 mt-0.5">Kalkulasi berbasis data cuaca real-time</p>
          </div>

          <div class="space-y-4">
            {{-- Pemupukan --}}
            <div
              class="p-4 rounded-xl bg-base-200/30 border border-base-content/5 flex items-start justify-between gap-3">
              <div class="flex items-start gap-3">
                <div class="p-2.5 bg-emerald-500/10 text-emerald-600 rounded-lg shrink-0">
                  <i class="ti ti-plant-2 text-xl"></i>
                </div>
                <div>
                  <h4 class="font-bold text-base text-green-950">Jadwal Pemupukan Tanah</h4>
                  <p class="text-sm text-base-content/70 mt-1 leading-relaxed">
                    {{ $rekomendasiTani['pemupukan']['pesan'] }}
                  </p>
                </div>
              </div>
              <span
                class="badge badge-{{ $rekomendasiTani['pemupukan']['warna'] }} badge-md font-bold text-xs shrink-0 px-2.5 py-2">
                {{ $rekomendasiTani['pemupukan']['status'] }}
              </span>
            </div>

            {{-- Penyemprotan --}}
            <div
              class="p-4 rounded-xl bg-base-200/30 border border-base-content/5 flex items-start justify-between gap-3">
              <div class="flex items-start gap-3">
                <div class="p-2.5 bg-teal-500/10 text-teal-600 rounded-lg shrink-0">
                  <i class="ti ti-mist text-xl"></i>
                </div>
                <div>
                  <h4 class="font-bold text-base text-green-950">Aplikasi Pestisida / Fungisida</h4>
                  <p class="text-sm text-base-content/70 mt-1 leading-relaxed">
                    {{ $rekomendasiTani['penyemprotan']['pesan'] }}
                  </p>
                </div>
              </div>
              <span
                class="badge badge-{{ $rekomendasiTani['penyemprotan']['warna'] }} badge-md font-bold text-xs shrink-0 px-2.5 py-2">
                {{ $rekomendasiTani['penyemprotan']['status'] }}
              </span>
            </div>

            {{-- Irigasi --}}
            <div
              class="p-4 rounded-xl bg-base-200/30 border border-base-content/5 flex items-start justify-between gap-3">
              <div class="flex items-start gap-3">
                <div class="p-2.5 bg-blue-500/10 text-blue-600 rounded-lg shrink-0">
                  <i class="ti ti-droplet text-xl"></i>
                </div>
                <div>
                  <h4 class="font-bold text-base text-green-950">Manajemen Irigasi Lahan</h4>
                  <p class="text-sm text-base-content/70 mt-1 leading-relaxed">
                    {{ $rekomendasiTani['irigasi']['pesan'] ?? 'Kelembaban tanah masih memadai. Tunda irigasi tambahan hingga 2 hari ke depan.' }}
                  </p>
                </div>
              </div>
              <span
                class="badge badge-{{ $rekomendasiTani['irigasi']['warna'] ?? 'warning' }} badge-md font-bold text-xs shrink-0 px-2.5 py-2">
                {{ $rekomendasiTani['irigasi']['status'] ?? 'Tunda' }}
              </span>
            </div>

            {{-- Aktivitas Panen --}}
            <div
              class="p-4 rounded-xl bg-base-200/30 border border-base-content/5 flex items-start justify-between gap-3">
              <div class="flex items-start gap-3">
                <div class="p-2.5 bg-amber-500/10 text-amber-600 rounded-lg shrink-0">
                  <i class="ti ti-sun text-xl"></i>
                </div>
                <div>
                  <h4 class="font-bold text-base text-green-950">Aktivitas Panen</h4>
                  <p class="text-sm text-base-content/70 mt-1 leading-relaxed">
                    {{ $rekomendasiTani['panen']['pesan'] ?? 'Prakiraan hujan 2 hari ke depan. Percepat panen jika padi telah mencapai masak penuh.' }}
                  </p>
                </div>
              </div>
              <span
                class="badge badge-{{ $rekomendasiTani['panen']['warna'] ?? 'warning' }} badge-md font-bold text-xs shrink-0 px-2.5 py-2">
                {{ $rekomendasiTani['panen']['status'] ?? 'Perhatian' }}
              </span>
            </div>
          </div>
        </div>

        <div class="mt-4">
          <div
            class="p-4 rounded-xl bg-{{ $rekomendasiTani['risiko_penyakit']['warna'] }}/5 border border-{{ $rekomendasiTani['risiko_penyakit']['warna'] }}/20 flex items-start gap-3">
            <span class="text-lg shrink-0 mt-0.5">⚠️</span>
            <div>
              <h4 class="font-bold text-sm text-{{ $rekomendasiTani['risiko_penyakit']['warna'] }}-900">
                Analisis Ancaman Biofisik — Risiko {{ $rekomendasiTani['risiko_penyakit']['tingkat'] }}
              </h4>
              <p class="text-sm text-base-content/80 mt-1 leading-relaxed">
                {{ $rekomendasiTani['risiko_penyakit']['pesan'] }}
              </p>
            </div>
          </div>
        </div>
      </div>

      {{-- ==================== KOLOM KANAN (HAMA & PENYAKIT) ==================== --}}
      <div
        class="card bg-base-100 shadow-sm border border-emerald-800/10 rounded-2xl overflow-hidden h-full flex flex-col">
        <div class="px-5 py-4 border-b border-base-content/10">
          <h2 class="text-xl font-extrabold text-green-950 flex items-center gap-2">
            <span>🛡️</span> Perlindungan
          </h2>
          <p class="text-sm font-semibold text-green-800 mt-0.5">Waspada Hama & Penyakit</p>
        </div>

        <div class="divide-y divide-base-content/5 flex-1 flex flex-col justify-between">

          {{-- 2. Blast Padi --}}
          <div class="p-4 flex items-start gap-3 flex-1">
            <div class="w-12 h-12 rounded-xl shrink-0 bg-yellow-50 flex items-center justify-center">
              <i class="ti ti-leaf text-2xl text-yellow-600"></i>
            </div>
            <div class="flex-1 min-w-0">
              <div class="flex items-center justify-between gap-1 mb-1">
                <h4 class="font-bold text-green-950 text-base truncate">Blast Padi</h4>
                <span class="badge badge-warning badge-sm text-xs font-semibold shrink-0 px-2.5 py-2">Risiko Sedang</span>
              </div>
              <p class="text-sm text-base-content/70 leading-relaxed mb-3">
                Jamur <em>Pyricularia oryzae</em> aktif saat lembab. Pantau bercak kelabu berbentuk berlian pada daun.
              </p>
              <button type="button" class="btn btn-sm btn-success btn-soft font-bold text-green-800 px-4 btn-detail-hama"
                data-nama="Blast Padi"
                data-deskripsi="Penyakit yang disebabkan oleh jamur berbau klinis <em>Pyricularia oryzae</em>. Menyerang bagian daun hingga leher malai padi pada kondisi lingkungan lembab dan tinggi nitrogen."
                data-pencegahan="Gunakan varietas tahan, hindari pemupukan Urea (Nitrogen) berlebih saat mendung, dan aplikasikan fungisida sistemik berbahan aktif trisiklazol sesuai anjuran.">
                Detail Info
              </button>
            </div>
          </div>

          {{-- 3. Penggerek Batang --}}
          <div class="p-4 flex items-start gap-3 flex-1">
            <div class="w-12 h-12 rounded-xl shrink-0 bg-pink-50 flex items-center justify-center">
              <i class="ti ti-bug text-2xl text-pink-600"></i>
            </div>
            <div class="flex-1 min-w-0">
              <div class="flex items-center justify-between gap-1 mb-1">
                <h4 class="font-bold text-green-950 text-base truncate">Penggerek Batang</h4>
                <span class="badge badge-warning badge-sm text-xs font-semibold shrink-0 px-2.5 py-2">Risiko
                  Sedang</span>
              </div>
              <p class="text-sm text-base-content/70 leading-relaxed mb-3">
                Larva <em>Scirpophaga</em> merusak batang dari dalam. Ciri khas: sundep pada fase vegetatif.
              </p>
              <button type="button"
                class="btn btn-sm btn-success btn-soft font-bold text-green-800 px-4 btn-detail-hama"
                data-nama="Penggerek Batang"
                data-deskripsi="Hama ngengat yang larvanya melubangi dan memakan bagian dalam batang padi. Mengakibatkan malai mati/hampa (beluk) atau pucuk layu kering (sundep)."
                data-pencegahan="Lakukan penggenangan air sesaat setelah panen untuk membunuh kepompong, gunakan jebakan lampu (light trap), atau aplikasikan insektisida granular berbahan aktif karbofuran jika populasi tinggi.">
                Detail Info
              </button>
            </div>
          </div>

          {{-- 4. Hawar Daun Bakteri --}}
          <div class="p-4 flex items-start gap-3 flex-1">
            <div class="w-12 h-12 rounded-xl shrink-0 bg-blue-50 flex items-center justify-center">
              <i class="ti ti-seeding text-2xl text-blue-500"></i>
            </div>
            <div class="flex-1 min-w-0">
              <div class="flex items-center justify-between gap-1 mb-1">
                <h4 class="font-bold text-green-950 text-base truncate">Hawar Daun Bakteri</h4>
                <span class="badge badge-info badge-sm text-xs font-semibold shrink-0 px-2.5 py-2">Waspada</span>
              </div>
              <p class="text-sm text-base-content/70 leading-relaxed mb-3">
                <em>Xanthomonas oryzae</em> menyebar cepat di musim hujan. Tandai pinggir daun menguning & layu.
              </p>
              <button type="button"
                class="btn btn-sm btn-success btn-soft font-bold text-green-800 px-4 btn-detail-hama"
                data-nama="Hawar Daun Bakteri (Kresek)"
                data-deskripsi="Infeksi sistemik bakteri <em>Xanthomonas oryzae</em> yang masuk lewat luka tanaman. Menimbulkan gejala garis basah di tepian daun hingga mengering kelabu."
                data-pencegahan="Gunakan bibit sehat bebas penyakit, kurangi luka mekanis saat pindah tanam, pastikan drainase lahan lancar, dan semprotkan bakterisida berbahan aktif tembaga jika diperlukan.">
                Detail Info
              </button>
            </div>
          </div>

        </div>
      </div>

    </div>
  </div>
@endsection

{{-- SCRIPT SWEETALERT2 --}}
@push('js')
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const buttons = document.querySelectorAll('.btn-detail-hama');

      buttons.forEach(button => {
        button.addEventListener('click', function(e) {
          e.preventDefault();

          const nama = this.getAttribute('data-nama');
          const deskripsi = this.getAttribute('data-deskripsi');
          const pencegahan = this.getAttribute('data-pencegahan');

          Swal.fire({
            title: `<span class="text-green-950 font-bold text-2xl">🛡️ ${nama}</span>`,
            html: `
              <div class="text-left space-y-4 font-sans text-slate-700">
                <div class="p-3 bg-base-200/50 rounded-xl border border-base-content/5">
                  <h5 class="font-bold text-sm text-emerald-800 mb-1">📋 Deskripsi & Gejala:</h5>
                  <p class="text-sm leading-relaxed">${deskripsi}</p>
                </div>
                <div class="p-3 bg-emerald-50/60 rounded-xl border border-emerald-200">
                  <h5 class="font-bold text-sm text-emerald-900 mb-1">💡 Solusi & Pencegahan:</h5>
                  <p class="text-sm leading-relaxed text-slate-800">${pencegahan}</p>
                </div>
              </div>
            `,
            icon: 'info',
            iconColor: '#059669',
            {{-- Emerald-600 --}}
            confirmButtonText: 'Tutup Panduan',
            confirmButtonColor: '#047857',
            {{-- Emerald-700 --}}
            customClass: {
              popup: 'rounded-2xl border border-emerald-800/10 shadow-xl bg-base-100',
              confirmButton: 'btn btn-success px-6 font-bold rounded-xl'
            }
          });
        });
      });
    });
  </script>
@endpush
