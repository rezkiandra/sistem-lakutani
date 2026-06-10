<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Analisis Kelayakan Usaha Tani</title>
  <style>
    body {
      font-family: 'Helvetica', 'Arial', sans-serif;
      font-size: 12px;
      color: #333;
      line-height: 1.4;
    }

    .header {
      text-align: center;
      margin-bottom: 25px;
      border-bottom: 2px solid #2e7d32;
      padding-bottom: 10px;
    }

    .header h2 {
      margin: 0;
      color: #2e7d32;
      font-size: 18px;
      text-transform: uppercase;
    }

    .header p {
      margin: 4px 0 0 0;
      font-size: 11px;
      color: #666;
    }

    .info-table {
      width: 100%;
      margin-bottom: 20px;
      border-collapse: collapse;
    }

    .info-table td {
      padding: 4px 0;
      vertical-align: top;
    }

    .section-title {
      font-size: 13px;
      font-weight: bold;
      color: #2e7d32;
      margin-top: 15px;
      margin-bottom: 8px;
      border-left: 3px solid #2e7d32;
      padding-left: 6px;
    }

    .data-table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 20px;
    }

    .data-table th {
      background-color: #f5f5f5;
      border: 1px solid #ddd;
      padding: 8px;
      text-align: left;
      font-size: 11px;
    }

    .data-table td {
      border: 1px solid #ddd;
      padding: 8px;
      font-size: 11px;
    }

    .text-right {
      text-align: right;
    }

    .text-center {
      text-align: center;
    }

    .badge {
      padding: 4px 8px;
      border-radius: 4px;
      font-weight: bold;
      font-size: 10px;
      display: inline-block;
    }

    .badge-success {
      background-color: #e8f5e9;
      color: #2e7d32;
      border: 1px solid #c8e6c9;
    }

    .badge-error {
      background-color: #ffebee;
      color: #c62828;
      border: 1px solid #ffcdd2;
    }

    .badge-info {
      background-color: #e3f2fd;
      color: #1565c0;
      border: 1px solid #bbdefb;
    }

    .badge-warning {
      background-color: #fff3e0;
      color: #ef6c00;
      border: 1px solid #ffe0b2;
    }

    .box-kesimpulan {
      background-color: #fafafa;
      border: 1px solid #e0e0e0;
      padding: 12px;
      border-radius: 6px;
      margin-bottom: 20px;
    }

    .footer-ttd {
      margin-top: 50px;
      float: right;
      text-align: center;
      width: 200px;
    }
  </style>
</head>

<body>

  @php
    // Ambil data variabel awal
    $totalPendapatan = $pendapatan?->total_pendapatan ?? 0;
    $totalPengeluaran = $labaRugi?->total_pengeluaran_produksi ?? 0;
    $keuntungan = $labaRugi?->total_laba_rugi ?? 0;
    $volProduksi = $produksi->padi_terjual_kg ?? 0;
    $hargaJual = $pendapatan?->harga_padi_per_kg ?? 0;

    // Kalkulasi Rumus Analisis Kelayakan
    $roi = $totalPengeluaran > 0 ? ($keuntungan / $totalPengeluaran) * 100 : 0;
    $rcRatio = $totalPengeluaran > 0 ? $totalPendapatan / $totalPengeluaran : 0;
    $bepHarga = $volProduksi > 0 ? $totalPengeluaran / $volProduksi : 0;
    $bepVol = $hargaJual > 0 ? $totalPengeluaran / $hargaJual : 0;

    $layak = $rcRatio >= 1;

    if ($roi >= 50) {
        $roiLabel = 'Sangat Menguntungkan';
        $roiColor = 'badge-success';
    } elseif ($roi >= 20) {
        $roiLabel = 'Layak';
        $roiColor = 'badge-info';
    } elseif ($roi >= 0) {
        $roiLabel = 'Tipis';
        $roiColor = 'badge-warning';
    } else {
        $roiLabel = 'Merugi';
        $roiColor = 'badge-error';
    }
  @endphp

  {{-- KOP / Header Laporan --}}
  <div class="header">
    <h2>Laporan Analisis Kelayakan Usaha Tani</h2>
    <p>Sistem Informasi Manajemen Usaha Tani · Tanggal Cetak: {{ now()->format('d-m-Y H:i') }}</p>
  </div>

  {{-- Identitas Pengelompokan Data --}}
  <table class="info-table">
    <tr>
      <td style="width: 18%;"><strong>ID Produksi</strong></td>
      <td style="width: 2%;">:</td>
      <td style="width: 30%;">#{{ $produksi->id }}</td>
      <td style="width: 18%;"><strong>Komoditas</strong></td>
      <td style="width: 2%;">:</td>
      <td style="width: 30%;">Padi</td>
    </tr>
    <tr>
      <td><strong>Tanggal Produksi</strong></td>
      <td>:</td>
      <td>{{ \Carbon\Carbon::parse($produksi->created_at)->format('d-m-Y') }}</td>
      <td><strong>Volume Penjualan</strong></td>
      <td>:</td>
      <td>{{ number_format($volProduksi, 0, ',', '.') }} kg</td>
    </tr>
  </table>

  <div class="section-title">Kesimpulan Analisis Kelayakan</div>
  <div class="box-kesimpulan">
    <table width="100%" cellpadding="0" cellspacing="0">
      <tr>
        <td>
          <span style="font-size: 14px; font-weight: bold; color: {{ $layak ? '#2e7d32' : '#c62828' }}">
            Usaha tani ini dinyatakan: {{ $layak ? 'LAYAK DIJALANKAN' : 'TIDAK LAYAK DIJALANKAN' }}
          </span>
          <p style="margin: 5px 0 0 0; color: #666; font-size: 11px;">
            Keputusan didasarkan pada nilai kriteria R/C Ratio
            {{ $layak ? '≥ 1 yang berarti perolehan pendapatan mampu menutupi seluruh biaya produksi.' : '< 1 yang berarti usaha tani mengalami defisit/kerugian.' }}
          </p>
        </td>
        <td class="text-right" style="width: 120px; vertical-align: middle;">
          <div style="font-size: 22px; font-weight: bold; color: {{ $layak ? '#2e7d32' : '#c62828' }}">
            {{ number_format($rcRatio, 2) }}
          </div>
          <span style="font-size: 10px; color: #888;">Nilai R/C Ratio</span>
        </td>
      </tr>
    </table>
  </div>

  <div class="section-title">Rincian Indikator Keuangan & Kelayakan</div>
  <table class="data-table">
    <thead>
      <tr>
        <th style="width: 5%;" class="text-center">No</th>
        <th style="width: 25%;">Indikator Kelayakan</th>
        <th style="width: 30%;">Formula Analisis</th>
        <th style="width: 20%;" class="text-right">Hasil Perhitungan</th>
        <th style="width: 20%;" class="text-center">Status / Keterangan</th>
      </tr>
    </thead>
    <tbody>
      {{-- 1. R/C Ratio --}}
      <tr>
        <td class="text-center">1</td>
        <td><strong>R/C Ratio</strong><br><span style="color:#777; font-size:10px;">Revenue Cost Ratio</span></td>
        <td>Total Pendapatan / Total Biaya</td>
        <td class="text-right"><strong>{{ number_format($rcRatio, 2) }}</strong></td>
        <td class="text-center">
          <span class="badge {{ $layak ? 'badge-success' : 'badge-error' }}">
            {{ $layak ? 'Layak (≥ 1)' : 'Tidak Layak' }}
          </span>
        </td>
      </tr>
      {{-- 2. ROI --}}
      <tr>
        <td class="text-center">2</td>
        <td><strong>ROI</strong><br><span style="color:#777; font-size:10px;">Return on Investment</span></td>
        <td>(Keuntungan / Total Biaya) × 100%</td>
        <td class="text-right"><strong>{{ number_format($roi, 1) }}%</strong></td>
        <td class="text-center">
          <span class="badge {{ $roiColor }}">{{ $roiLabel }}</span>
        </td>
      </tr>
      {{-- 3. BEP Harga --}}
      <tr>
        <td class="text-center">3</td>
        <td><strong>BEP Harga</strong><br><span style="color:#777; font-size:10px;">Break Even Point Harga</span></td>
        <td>Total Biaya / Volume Produksi</td>
        <td class="text-right"><strong>Rp {{ number_format($bepHarga, 0, ',', '.') }} / kg</strong></td>
        <td class="text-center">
          <span class="badge {{ $hargaJual >= $bepHarga ? 'badge-success' : 'badge-error' }}">
            {{ $hargaJual >= $bepHarga ? 'Harga Aman' : 'Di Bawah BEP' }}
          </span>
        </td>
      </tr>
      {{-- 4. BEP Volume --}}
      <tr>
        <td class="text-center">4</td>
        <td><strong>BEP Volume</strong><br><span style="color:#777; font-size:10px;">Break Even Point Volume</span></td>
        <td>Total Biaya / Harga Jual per kg</td>
        <td class="text-right"><strong>{{ number_format($bepVol, 0, ',', '.') }} kg</strong></td>
        <td class="text-center">
          <span class="badge {{ $volProduksi >= $bepVol ? 'badge-success' : 'badge-error' }}">
            {{ $volProduksi >= $bepVol ? 'Volume Aman' : 'Di Bawah BEP' }}
          </span>
        </td>
      </tr>
    </tbody>
  </table>

  <div class="section-title">Parameter Dasar Komponen Finansial</div>
  <table class="data-table">
    <tr>
      <td style="width: 40%;">Total Pendapatan Kotor (Revenue)</td>
      <td style="width: 10%;" class="text-center">=</td>
      <td style="width: 50%;" class="text-right">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</td>
    </tr>
    <tr>
      <td>Total Biaya Produksi (Cost)</td>
      <td class="text-center">=</td>
      <td class="text-right">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</td>
    </tr>
    <tr>
      <td><strong>Keuntungan Bersih (Laba)</strong></td>
      <td class="text-center"><strong>=</strong></td>
      <td class="text-right" style="color: {{ $keuntungan >= 0 ? '#2e7d32' : '#c62828' }}">
        <strong>Rp {{ number_format($keuntungan, 0, ',', '.') }}</strong>
      </td>
    </tr>
    <tr>
      <td>Harga Jual Aktual Aktual di Pasar</td>
      <td class="text-center">=</td>
      <td class="text-right">Rp {{ number_format($hargaJual, 0, ',', '.') }} / kg</td>
    </tr>
  </table>

  {{-- Tanda Tangan --}}
  <div class="footer-ttd">
    <p>Verifikasi Sistem,</p>
    <br><br><br>
    <p><strong>Manajemen Usaha Tani</strong></p>
  </div>

</body>

</html>
