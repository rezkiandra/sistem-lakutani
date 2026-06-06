<?php

namespace App\Http\Controllers;

use App\Models\Keuangan;
use App\Models\LabaRugi;
use App\Models\Pendapatan;
use App\Models\Produksi;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        if (Auth::user()->role === 'admin') {
            return $this->dashboardAdmin();
        }

        return $this->dashboardPetani();
    }

    // =========================================================
    //  DASHBOARD ADMIN
    // =========================================================
    private function dashboardAdmin()
    {
        // ---- Statistik Pengguna ----
        $totalPengguna = User::count();
        $penggunaBaru = User::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $statistikPengguna = collect([
            ['label' => 'Admin',  'jumlah' => User::where('role', 'admin')->count(),  'warna' => '#6366f1'],
            ['label' => 'Petani', 'jumlah' => User::where('role', 'petani')->count(), 'warna' => '#22c55e'],
        ]);

        $penggunaTerbaru = User::latest()->take(5)->get();

        // ---- Statistik Produksi ----
        $totalProduksi = Produksi::count();
        $totalPanen = Produksi::sum('hasil_panen_padi_kg');
        $totalTerjual = Produksi::sum('padi_terjual_kg');
        $totalPendapatanSemua = Pendapatan::sum('total_pendapatan');
        $totalPengeluaranSemua = LabaRugi::sum('total_pengeluaran_produksi');
        $rataLaba = LabaRugi::avg('total_laba_rugi') ?? 0;

        // ---- Keuangan ----
        $totalPemasukan = Keuangan::where('jenis', 'pemasukan')->sum('jumlah');
        $totalPengeluaran = Keuangan::where('jenis', 'pengeluaran')->sum('jumlah');
        $saldoKeuangan = $totalPemasukan - $totalPengeluaran;

        // ---- Grafik Keuangan Bulanan (12 bulan terakhir) ----
        $labelBulan = [];
        $dataPemasukan = [];
        $dataPengeluaran = [];

        for ($i = 11; $i >= 0; $i--) {
            $bulan = now()->subMonths($i);
            $labelBulan[] = $bulan->isoFormat('MMM YY');

            $dataPemasukan[] = Keuangan::where('jenis', 'pemasukan')
                ->whereYear('tanggal', $bulan->year)
                ->whereMonth('tanggal', $bulan->month)
                ->sum('jumlah');

            $dataPengeluaran[] = Keuangan::where('jenis', 'pengeluaran')
                ->whereYear('tanggal', $bulan->year)
                ->whereMonth('tanggal', $bulan->month)
                ->sum('jumlah');
        }

        // ---- Aktivitas Terbaru ----
        $aktivitasTerbaru = collect();

        // 3 produksi terbaru
        Produksi::with('user')->latest()->take(3)->get()->each(function ($p) use (&$aktivitasTerbaru) {
            $aktivitasTerbaru->push([
                'tipe' => 'produksi',
                'pesan' => ($p->user->name ?? 'Petani').' menginput data produksi '.number_format($p->hasil_panen_padi_kg, 0, ',', '.').' kg',
                'waktu' => $p->created_at->diffForHumans(),
            ]);
        });

        // 3 transaksi terbaru
        Keuangan::latest('tanggal')->take(3)->get()->each(function ($k) use (&$aktivitasTerbaru) {
            $aktivitasTerbaru->push([
                'tipe' => 'keuangan',
                'pesan' => ucfirst($k->jenis).' — '.$k->kategori.' Rp '.number_format($k->jumlah, 0, ',', '.'),
                'waktu' => Carbon::parse($k->tanggal)->diffForHumans(),
            ]);
        });

        // 2 pengguna terbaru
        User::latest()->take(2)->get()->each(function ($u) use (&$aktivitasTerbaru) {
            $aktivitasTerbaru->push([
                'tipe' => 'pengguna',
                'pesan' => 'Pengguna baru bergabung: '.$u->name,
                'waktu' => $u->created_at->diffForHumans(),
            ]);
        });

        // Urutkan berdasarkan waktu terbaru (gunakan created_at asli)
        $aktivitasTerbaru = $aktivitasTerbaru->take(7);

        return view('admin.dashboard', compact(
            'totalPengguna',
            'penggunaBaru',
            'statistikPengguna',
            'penggunaTerbaru',
            'totalProduksi',
            'totalPanen',
            'totalTerjual',
            'totalPendapatanSemua',
            'totalPengeluaranSemua',
            'rataLaba',
            'totalPemasukan',
            'totalPengeluaran',
            'saldoKeuangan',
            'labelBulan',
            'dataPemasukan',
            'dataPengeluaran',
            'aktivitasTerbaru',
        ));
    }

    // =========================================================
    //  DASHBOARD PETANI
    // =========================================================
    private function dashboardPetani()
    {
        $userId = Auth::id();

        // ---- Ringkasan Usaha Tani ----
        $produksiQuery = Produksi::where('user_id', $userId);

        $totalPanen = (clone $produksiQuery)->sum('hasil_panen_padi_kg');
        $totalPendapatan = Pendapatan::whereHas('produksi', fn ($q) => $q->where('user_id', $userId))
            ->sum('total_pendapatan');
        $totalPengeluaran = LabaRugi::whereHas('pendapatan.produksi', fn ($q) => $q->where('user_id', $userId))
            ->sum('total_pengeluaran_produksi');
        $totalLabaRugi = LabaRugi::whereHas('pendapatan.produksi', fn ($q) => $q->where('user_id', $userId))
            ->sum('total_laba_rugi');

        // ---- Keuangan Kas ----
        $totalPemasukan = Keuangan::where('user_id', $userId)->where('jenis', 'pemasukan')->sum('jumlah');
        $totalPengeluaranKas = Keuangan::where('user_id', $userId)->where('jenis', 'pengeluaran')->sum('jumlah');
        $saldoAkhir = $totalPemasukan - $totalPengeluaranKas;

        // ---- Riwayat Produksi (5 terbaru) ----
        $riwayatProduksi = Produksi::where('user_id', $userId)
            ->with(['pendapatan.labaRugi'])
            ->latest()
            ->take(5)
            ->get();

        // ---- Transaksi Kas Terbaru ----
        $transaksiTerbaru = Keuangan::where('user_id', $userId)
            ->orderByDesc('tanggal')
            ->take(6)
            ->get();

        // ---- Grafik Pendapatan vs Pengeluaran per Musim ----
        $labelMusim = [];
        $dataGrafikPendapatan = [];
        $dataGrafikPengeluaran = [];

        $produksiGrafik = Produksi::where('user_id', $userId)
            ->with(['pendapatan.labaRugi'])
            ->latest()
            ->take(6)
            ->get()
            ->reverse();

        foreach ($produksiGrafik as $p) {
            $labelMusim[] = Carbon::parse($p->created_at)->isoFormat('MMM YY');
            $dataGrafikPendapatan[] = $p->pendapatan?->total_pendapatan ?? 0;
            $dataGrafikPengeluaran[] = $p->pendapatan?->labaRugi?->total_pengeluaran_produksi ?? 0;
        }

        return view('petani.dashboard', compact(
            'totalPanen',
            'totalPendapatan',
            'totalPengeluaran',
            'totalLabaRugi',
            'totalPemasukan',
            'totalPengeluaranKas',
            'saldoAkhir',
            'riwayatProduksi',
            'transaksiTerbaru',
            'labelMusim',
            'dataGrafikPendapatan',
            'dataGrafikPengeluaran',
        ));
    }
}
