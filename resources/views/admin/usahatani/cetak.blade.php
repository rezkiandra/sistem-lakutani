<!DOCTYPE html>
<html lang="id">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Hasil Analisis Usaha Tani - {{ $produksi->id }}</title>
  <style>
    @page {
      margin: 1.2cm;
    }

    body {
      /* 🔴 WAJIB Menggunakan DejaVu Sans agar HTML Entity (&) bisa dirender menjadi simbol */
      font-family: 'DejaVu Sans', sans-serif;
      color: #1e293b;
      font-size: 10pt;
      line-height: 1.5;
    }

    /* Header Banner Utama */
    .header-banner {
      background-color: #4a3728;
      color: #ffffff;
      padding: 18px 24px;
      border-radius: 8px;
      margin-bottom: 15px;
    }

    .header-banner h2 {
      margin: 0;
      font-size: 15pt;
      font-weight: bold;
    }

    .header-banner p {
      margin: 4px 0 0 0;
      font-size: 9pt;
      opacity: 0.85;
    }

    /* Alert Status Laba / Rugi */
    .alert-box {
      padding: 14px 20px;
      border-radius: 8px;
      margin-bottom: 20px;
    }

    .alert-rugi {
      background-color: #fef2f2;
      border: 1px solid #fee2e2;
      color: #991b1b;
    }

    .alert-laba {
      background-color: #f0fdf4;
      border: 1px solid #dcfce7;
      color: #166534;
    }

    /* Grid Kolom Menggunakan Tabel */
    .table-grid {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 15px;
    }

    .table-grid td {
      vertical-align: top;
      padding: 0;
    }

    /* Card Berwarna Putih */
    .card {
      background: #ffffff;
      border: 1px solid #e2e8f0;
      border-radius: 8px;
      padding: 14px;
      margin-bottom: 15px;
    }

    .card-title {
      font-size: 10.5pt;
      font-weight: bold;
      color: #334155;
      margin-bottom: 10px;
      border-bottom: 1px solid #f1f5f9;
      padding-bottom: 6px;
    }

    /* Box Mini Angka */
    .stat-box {
      background: #ffffff;
      border: 1px solid #e2e8f0;
      border-radius: 6px;
      padding: 10px 12px;
    }

    .stat-label {
      font-size: 8.5pt;
      color: #64748b;
      margin-bottom: 4px;
    }

    .stat-value {
      font-size: 13pt;
      font-weight: bold;
    }

    /* Pewarnaan Teks */
    .text-hijau {
      color: #16a34a;
    }

    .text-merah {
      color: #dc2626;
    }

    .text-biru {
      color: #2563eb;
    }

    .text-oranye {
      color: #ea580c;
    }

    /* Tabel Data Dalam Card */
    .data-table {
      width: 100%;
      border-collapse: collapse;
    }

    .data-table th {
      text-align: left;
      font-size: 8.5pt;
      text-transform: uppercase;
      color: #64748b;
      padding: 6px 4px;
      border-bottom: 1px solid #e2e8f0;
    }

    .data-table td {
      padding: 7px 4px;
      font-size: 9.5pt;
      border-bottom: 1px solid #f1f5f9;
    }

    .subtotal-row td {
      font-weight: bold;
      border-top: 1px solid #e2e8f0;
      background-color: #f8fafc;
    }

    .text-right {
      text-align: right;
    }

    .font-bold {
      font-weight: bold;
    }
  </style>
</head>

<body>

  @php
    $totalPendapatan = $labaRugi?->total_pendapatan ?? 0;
    $totalPengeluaran = $labaRugi?->total_pengeluaran ?? 0;
    $keuntunganBersih = $totalPendapatan - $totalPengeluaran;
  @endphp

  <div class="header-banner">
    <h2>&#128466; Hasil Analisis Usaha Tani</h2>
    <p>Ringkasan lengkap produksi, pendapatan, dan laba/rugi usaha tani</p>
  </div>

  @if ($keuntunganBersih < 0)
    <div class="alert-box alert-rugi">
      <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
          <td style="font-weight: bold; font-size: 11.5pt;">
            <span style="font-size: 13pt;">&#9660;</span> Usaha Tani Merugi
          </td>
          <td class="text-right font-bold" style="font-size: 14pt;">Rp
            {{ number_format(abs($keuntunganBersih), 0, ',', '.') }}</td>
        </tr>
        <tr>
          <td colspan="2" style="font-size: 8.5pt; opacity: 0.85; padding-top: 4px;">Nilai minus diperoleh
            berdasarkan akumulasi total pengeluaran yang lebih besar dari total pendapatan kotor.</td>
        </tr>
      </table>
    </div>
  @else
    <div class="alert-box alert-laba">
      <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
          <td style="font-weight: bold; font-size: 11.5pt;">
            <span style="font-size: 13pt;">&#9650;</span> Usaha Tani Untung (Laba)
          </td>
          <td class="text-right font-bold" style="font-size: 14pt;">Rp
            {{ number_format($keuntunganBersih, 0, ',', '.') }}</td>
        </tr>
        <tr>
          <td colspan="2" style="font-size: 8.5pt; opacity: 0.85; padding-top: 4px;">Selamat! Hasil usaha tani
            berjalan produktif dan menghasilkan keuntungan bersih.</td>
        </tr>
      </table>
    </div>
  @endif

  <table class="table-grid" style="margin-bottom: 20px;">
    <tr>
      <td width="23.5%">
        <div class="stat-box">
          <div class="stat-label">Total Panen</div>
          <div class="stat-value text-oranye">{{ number_format($produksi->total_panen ?? 0, 0, ',', '.') }} kg</div>
        </div>
      </td>
      <td width="2%"></td>
      <td width="23.5%">
        <div class="stat-box">
          <div class="stat-label">Padi Terjual</div>
          <div class="stat-value text-biru">{{ number_format($produksi->padi_terjual ?? 0, 0, ',', '.') }} kg</div>
        </div>
      </td>
      <td width="2%"></td>
      <td width="24.5%">
        <div class="stat-box">
          <div class="stat-label">Total Pendapatan</div>
          <div class="stat-value text-hijau">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
        </div>
      </td>
      <td width="2%"></td>
      <td width="22.5%">
        <div class="stat-box">
          <div class="stat-label">Total Pengeluaran</div>
          <div class="stat-value text-merah">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</div>
        </div>
      </td>
    </tr>
  </table>

  <table class="table-grid">
    <tr>
      <td width="49%">
        <div class="card" style="min-height: 220px;">
          <div class="card-title">Data Produksi</div>
          <table class="data-table">
            <thead>
              <tr>
                <th>Jenis</th>
                <th class="text-right">Jumlah</th>
                <th style="padding-left: 5px;">Unit</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Hasil Panen Padi</td>
                <td class="text-right font-bold">{{ number_format($produksi->total_panen ?? 0, 0, ',', '.') }}</td>
                <td style="padding-left: 5px; color:#64748b;">kg</td>
              </tr>
              <tr>
                <td style="color:#64748b; padding-left: 8px;">• Konsumsi Sendiri</td>
                <td class="text-right text-merah">-{{ number_format($produksi->konsumsi_sendiri ?? 0, 0, ',', '.') }}
                </td>
                <td style="padding-left: 5px; color:#64748b;">kg</td>
              </tr>
              <tr>
                <td style="color:#64748b; padding-left: 8px;">• Zakat</td>
                <td class="text-right text-merah">-{{ number_format($produksi->zakat ?? 0, 0, ',', '.') }}</td>
                <td style="padding-left: 5px; color:#64748b;">kg</td>
              </tr>
              <tr>
                <td style="color:#64748b; padding-left: 8px;">• Sewa Lahan</td>
                <td class="text-right text-merah">-{{ number_format($produksi->sewa_lahan ?? 0, 0, ',', '.') }}</td>
                <td style="padding-left: 5px; color:#64748b;">kg</td>
              </tr>
              <tr class="subtotal-row">
                <td>Padi Terjual</td>
                <td class="text-right text-biru">{{ number_format($produksi->padi_terjual ?? 0, 0, ',', '.') }}</td>
                <td style="padding-left: 5px;">kg</td>
              </tr>
            </tbody>
          </table>
        </div>
      </td>

      <td width="2%"></td>

      <td width="49%">
        <div class="card" style="min-height: 220px;">
          <div class="card-title">Data Pendapatan</div>
          <table class="data-table">
            <thead>
              <tr>
                <th>Jenis Pendapatan</th>
                <th class="text-right">Nilai</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>
                  <strong>Penjualan Padi</strong><br>
                  <span style="font-size: 8pt; color:#64748b;">
                    {{ number_format($produksi->padi_terjual ?? 0, 0, ',', '.') }} kg &times; Rp
                    {{ number_format($pendapatan->harga_per_kg ?? 0, 0, ',', '.') }}
                  </span>
                </td>
                <td class="text-right text-hijau" style="vertical-align: middle;">
                  Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
                </td>
              </tr>
              <tr class="subtotal-row">
                <td style="padding-top: 65px;">Total Pendapatan</td>
                <td class="text-right text-hijau" style="padding-top: 65px;">
                  Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </td>
    </tr>
  </table>

  <div class="card">
    <div class="card-title">Rincian Pengeluaran Produksi</div>
    <table class="data-table">
      <thead>
        <tr>
          <th>Komponen Pengeluaran</th>
          <th class="text-right">Subtotal</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td><strong>1. Input Usaha Tani</strong> (Benih, Urea, TSP, Pupuk Lain, Kimia)</td>
          <td class="text-right text-merah">Rp {{ number_format($labaRugi->input_usaha_tani ?? 0, 0, ',', '.') }}</td>
        </tr>
        <tr>
          <td><strong>2. Pengeluaran Lain</strong> (Pekerja, Pembajakan, Perataan, Alat)</td>
          <td class="text-right text-merah">Rp {{ number_format($labaRugi->pengeluaran_lain ?? 0, 0, ',', '.') }}</td>
        </tr>
        <tr>
          <td><strong>3. Biaya Panen</strong> (Sewa Alsintan, Pengeringan, Transpor, Giling)</td>
          <td class="text-right text-merah">Rp {{ number_format($labaRugi->biaya_panen ?? 0, 0, ',', '.') }}</td>
        </tr>
        <tr>
          <td><strong>4. Biaya Lainnya</strong> (Sewa Lahan Finansial, Asuransi Tani)</td>
          <td class="text-right text-merah">Rp {{ number_format($labaRugi->biaya_lainnya ?? 0, 0, ',', '.') }}</td>
        </tr>
        <tr class="subtotal-row">
          <td>Total Seluruh Pengeluaran</td>
          <td class="text-right text-merah" style="font-size: 10.5pt;">Rp
            {{ number_format($totalPengeluaran, 0, ',', '.') }}</td>
        </tr>
      </tbody>
    </table>
  </div>

  <div class="card" style="background-color: #f8fafc; border-left: 4px solid #4a3728;">
    <div class="card-title" style="border: none; margin-bottom: 5px;">Kesimpulan Laba / Rugi Akhir</div>
    <table width="100%">
      <tr>
        <td style="font-size: 9.5pt; color: #475569;">Total Pendapatan (Kotor)</td>
        <td class="text-right text-hijau font-bold">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</td>
      </tr>
      <tr>
        <td style="font-size: 9.5pt; color: #475569; padding-bottom: 6px; border-bottom: 1px dashed #cbd5e1;">Total
          Pengeluaran (Biaya Operasional)</td>
        <td class="text-right text-merah font-bold" style="padding-bottom: 6px; border-bottom: 1px dashed #cbd5e1;">-
          Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</td>
      </tr>
      <tr>
        <td style="font-size: 11pt; font-weight: bold; padding-top: 8px;">
          {{ $keuntunganBersih < 0 ? 'Total Kerugian Bersih' : 'Total Keuntungan Bersih (Laba)' }}
        </td>
        <td class="text-right font-bold"
          style="font-size: 12.5pt; padding-top: 8px; color: {{ $keuntunganBersih < 0 ? '#dc2626' : '#16a34a' }}">
          Rp {{ number_format($keuntunganBersih, 0, ',', '.') }}
        </td>
      </tr>
    </table>
  </div>

</body>

</html>
