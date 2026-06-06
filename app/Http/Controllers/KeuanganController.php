<?php

namespace App\Http\Controllers;

use App\Models\Keuangan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class KeuanganController extends Controller
{
    // --------------------------------------------------------
    // INDEX — daftar transaksi
    // --------------------------------------------------------
    public function index()
    {
        $userId = Auth::id();

        // Ambil semua transaksi milik user, urutkan by tanggal
        $semuaTransaksi = Keuangan::where('user_id', $userId)
            ->orderBy('tanggal')
            ->orderBy('created_at')
            ->get();

        // Hitung saldo berjalan
        $saldo = 0;
        foreach ($semuaTransaksi as $t) {
            $saldo += $t->jenis === 'pemasukan' ? $t->jumlah : -$t->jumlah;
            $t->saldo_berjalan = $saldo;
        }

        // Paginate manual — ambil 15 terbaru
        $transaksi = Keuangan::where('user_id', $userId)
            ->orderByDesc('tanggal')
            ->orderByDesc('created_at')
            ->paginate(15);

        // Stat
        $totalPemasukan = Keuangan::where('user_id', $userId)->where('jenis', 'pemasukan')->sum('jumlah');
        $totalPengeluaran = Keuangan::where('user_id', $userId)->where('jenis', 'pengeluaran')->sum('jumlah');
        $saldoAkhir = $totalPemasukan - $totalPengeluaran;

        // Saldo berjalan per baris (inject ke koleksi paginate)
        $saldoTemp = 0;
        $semuaUrut = Keuangan::where('user_id', $userId)
            ->orderBy('tanggal')
            ->orderBy('created_at')
            ->pluck('id')
            ->flip(); // id => index urut

        foreach ($transaksi as $item) {
            // Hitung saldo sampai transaksi ini
            $saldoSampai = Keuangan::where('user_id', $userId)
                ->where(function ($q) use ($item) {
                    $q->where('tanggal', '<', $item->tanggal)
                        ->orWhere(function ($q2) use ($item) {
                            $q2->where('tanggal', $item->tanggal)
                                ->where('created_at', '<=', $item->created_at);
                        });
                })
                ->selectRaw("SUM(CASE WHEN jenis = 'pemasukan' THEN jumlah ELSE -jumlah END) as saldo")
                ->value('saldo');

            $item->saldo_berjalan = $saldoSampai ?? 0;
        }

        return view('petani.usahatani.keuangan', compact(
            'transaksi',
            'totalPemasukan',
            'totalPengeluaran',
            'saldoAkhir',
        ));
    }

    // --------------------------------------------------------
    // CREATE
    // --------------------------------------------------------
    public function create()
    {
        return view('petani.usahatani.create_keuangan');
    }

    // --------------------------------------------------------
    // STORE
    // --------------------------------------------------------
    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'jenis' => 'required|in:pemasukan,pengeluaran',
            'kategori' => 'required|string|max:255',
            'jumlah' => 'required|numeric|min:0',
        ], [
            'tanggal.required' => 'Tanggal wajib diisi',
            'jenis.required' => 'Jenis transaksi wajib dipilih',
            'kategori.required' => 'Kategori wajib diisi',
            'jumlah.required' => 'Jumlah wajib diisi',
            'jumlah.numeric' => 'Jumlah harus berupa angka',
            'jumlah.min' => 'Jumlah tidak boleh negatif',
        ]);

        // Hitung saldo berjalan terbaru
        $userId = Auth::id();
        $totalMasuk = Keuangan::where('user_id', $userId)->where('jenis', 'pemasukan')->sum('jumlah');
        $totalKeluar = Keuangan::where('user_id', $userId)->where('jenis', 'pengeluaran')->sum('jumlah');
        $saldoSkrg = $totalMasuk - $totalKeluar;
        $saldoBaru = $request->jenis === 'pemasukan'
            ? $saldoSkrg + $request->jumlah
            : $saldoSkrg - $request->jumlah;

        Keuangan::create([
            'user_id' => $userId,
            'tanggal' => $request->tanggal,
            'jenis' => $request->jenis,
            'kategori' => $request->kategori,
            'jumlah' => $request->jumlah,
            'keterangan' => $request->keterangan,
            'saldo_berjalan' => $saldoBaru,
        ]);

        return redirect()->route('petani.catatKeuangan')
            ->with('success', 'Transaksi berhasil disimpan!');
    }

    // --------------------------------------------------------
    // EDIT
    // --------------------------------------------------------
    public function edit(Keuangan $keuangan)
    {
        $this->otorisasi($keuangan);

        return view('petani.usahatani.edit_keuangan', compact('keuangan'));
    }

    // --------------------------------------------------------
    // UPDATE
    // --------------------------------------------------------
    public function update(Request $request, Keuangan $keuangan)
    {
        $this->otorisasi($keuangan);

        $request->validate([
            'tanggal' => 'required|date',
            'jenis' => 'required|in:pemasukan,pengeluaran',
            'kategori' => 'required|string|max:255',
            'jumlah' => 'required|numeric|min:0',
        ]);

        $keuangan->update([
            'tanggal' => $request->tanggal,
            'jenis' => $request->jenis,
            'kategori' => $request->kategori,
            'jumlah' => $request->jumlah,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('petani.catatKeuangan')
            ->with('success', 'Transaksi berhasil diperbarui!');
    }

    // --------------------------------------------------------
    // DESTROY
    // --------------------------------------------------------
    public function destroy(Keuangan $keuangan)
    {
        $this->otorisasi($keuangan);

        $keuangan->delete();

        return redirect()->route('petani.catatKeuangan')
            ->with('success', 'Transaksi berhasil dihapus!');
    }

    // --------------------------------------------------------
    // LAPORAN
    // --------------------------------------------------------
    public function laporan()
    {
        $userId = Auth::id();

        // Ringkasan
        $totalPemasukan = Keuangan::where('user_id', $userId)->where('jenis', 'pemasukan')->sum('jumlah');
        $totalPengeluaran = Keuangan::where('user_id', $userId)->where('jenis', 'pengeluaran')->sum('jumlah');
        $saldoAkhir = $totalPemasukan - $totalPengeluaran;

        // Breakdown per kategori
        $pemasukanPerKategori = Keuangan::where('user_id', $userId)
            ->where('jenis', 'pemasukan')
            ->selectRaw('kategori, SUM(jumlah) as total')
            ->groupBy('kategori')
            ->orderByDesc('total')
            ->get();

        $pengeluaranPerKategori = Keuangan::where('user_id', $userId)
            ->where('jenis', 'pengeluaran')
            ->selectRaw('kategori, SUM(jumlah) as total')
            ->groupBy('kategori')
            ->orderByDesc('total')
            ->get();

        // Grafik 6 bulan terakhir
        $labelBulan = [];
        $dataPemasukan = [];
        $dataPengeluaran = [];

        for ($i = 5; $i >= 0; $i--) {
            $bulan = now()->subMonths($i);
            $labelBulan[] = $bulan->isoFormat('MMM YY');

            $dataPemasukan[] = Keuangan::where('user_id', $userId)
                ->where('jenis', 'pemasukan')
                ->whereYear('tanggal', $bulan->year)
                ->whereMonth('tanggal', $bulan->month)
                ->sum('jumlah');

            $dataPengeluaran[] = Keuangan::where('user_id', $userId)
                ->where('jenis', 'pengeluaran')
                ->whereYear('tanggal', $bulan->year)
                ->whereMonth('tanggal', $bulan->month)
                ->sum('jumlah');
        }

        return view('petani.usahatani.laporan_keuangan', compact(
            'totalPemasukan',
            'totalPengeluaran',
            'saldoAkhir',
            'pemasukanPerKategori',
            'pengeluaranPerKategori',
            'labelBulan',
            'dataPemasukan',
            'dataPengeluaran',
        ));
    }

    // --------------------------------------------------------
    // EXPORT — download laporan sebagai CSV
    // --------------------------------------------------------
    public function export()
    {
        $userId = Auth::id();
        $transaksi = Keuangan::where('user_id', $userId)
            ->orderBy('tanggal')
            ->get();

        $filename = 'laporan_keuangan_'.now()->format('Ymd').'.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($transaksi) {
            $file = fopen('php://output', 'w');

            // Header CSV
            fputcsv($file, ['Tanggal', 'Jenis', 'Kategori', 'Jumlah (Rp)', 'Keterangan', 'Saldo Berjalan']);

            $saldo = 0;
            foreach ($transaksi as $t) {
                $saldo += $t->jenis === 'pemasukan' ? $t->jumlah : -$t->jumlah;
                fputcsv($file, [
                    Carbon::parse($t->tanggal)->format('d/m/Y'),
                    ucfirst($t->jenis),
                    $t->kategori,
                    number_format($t->jumlah, 0, ',', '.'),
                    $t->keterangan ?? '-',
                    number_format($saldo, 0, ',', '.'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    // --------------------------------------------------------
    // HELPER — cek kepemilikan transaksi
    // --------------------------------------------------------
    private function otorisasi(Keuangan $keuangan)
    {
        if ($keuangan->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke transaksi ini.');
        }
    }
}
