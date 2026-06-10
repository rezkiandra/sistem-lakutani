<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Keuangan;
use App\Models\LabaRugi;
use App\Models\Pendapatan;
use App\Models\Produksi;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    public function index()
    {
        if (Auth::user()->role === 'admin') {
            return $this->dashboardAdmin();
        }

        return $this->dashboardPetani();
    }

    public function produksis()
    {
        $produksis = Produksi::with(['pendapatan', 'user'])
            ->latest()
            ->paginate(10);

        return view('admin.usahatani.produksis', compact('produksis')); // Sesuaikan dengan folder view kamu
    }

    public function keuangans()
    {
        $keuangans = Keuangan::with(['user'])
            ->latest()
            ->paginate(10);

        return view('admin.usahatani.keuangans', compact('keuangans')); // Sesuaikan dengan folder view kamu
    }

    public function laporanKeuangan()
    {
        // 1. Ringkasan Kas Global (Seluruh Sistem)
        $totalPemasukan = Keuangan::where('jenis', 'pemasukan')->sum('jumlah');
        $totalPengeluaran = Keuangan::where('jenis', 'pengeluaran')->sum('jumlah');
        $saldoAkhir = $totalPemasukan - $totalPengeluaran;

        // 2. Breakdown Pemasukan & Pengeluaran Terbesar per Petani
        // Menggabungkan data keuangan dengan data user agar admin tahu siapa yang paling aktif
        $pemasukanPerPetani = Keuangan::with('user')
            ->where('jenis', 'pemasukan')
            ->selectRaw('user_id, SUM(jumlah) as total')
            ->groupBy('user_id')
            ->orderByDesc('total')
            ->get();

        $pengeluaranPerPetani = Keuangan::with('user')
            ->where('jenis', 'pengeluaran')
            ->selectRaw('user_id, SUM(jumlah) as total')
            ->groupBy('user_id')
            ->orderByDesc('total')
            ->get();

        // 3. Grafik Tren Keuangan 6 Bulan Terakhir (Global)
        $labelBulan = [];
        $dataPemasukan = [];
        $dataPengeluaran = [];

        for ($i = 5; $i >= 0; $i--) {
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

        return view('admin.usahatani.laporan_keuangan', compact(
            'totalPemasukan',
            'totalPengeluaran',
            'saldoAkhir',
            'pemasukanPerPetani',
            'pengeluaranPerPetani',
            'labelBulan',
            'dataPemasukan',
            'dataPengeluaran'
        ));
    }

    // --------------------------------------------------------
    // EXPORT — download laporan sebagai CSV
    // --------------------------------------------------------
    public function cetakLaporanKeuangan()
    {
        // Ambil semua data keuangan dan urutkan berdasarkan petani dulu, lalu tanggalnya
        $transaksi = Keuangan::with('user')
            ->orderBy('user_id')
            ->orderBy('tanggal')
            ->get();

        $filename = 'laporan_keuangan_petani_'.now()->format('Ymd').'.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($transaksi) {
            $file = fopen('php://output', 'w');

            // Header CSV dibuat sejajar satu baris lurus
            fputcsv($file, ['Petani', 'Tanggal', 'Jenis', 'Kategori', 'Jumlah (Rp)', 'Keterangan', 'Saldo Berjalan']);

            $saldo = 0;
            $currentUserId = null;

            foreach ($transaksi as $t) {
                // Jika berganti petani, reset perhitungan saldo berjalannya dari 0 lagi
                if ($currentUserId !== $t->user_id) {
                    $currentUserId = $t->user_id;
                    $saldo = 0;
                }

                $saldo += $t->jenis === 'pemasukan' ? $t->jumlah : -$t->jumlah;
                $namaPetani = $t->user?->name ?? 'Tidak Diketahui';

                // Masukkan data sejajar dengan headernya
                fputcsv($file, [
                    $namaPetani, // Masuk ke kolom pertama (Petani)
                    Carbon::parse($t->tanggal)->format('d/m/Y'),
                    ucfirst($t->jenis),
                    $t->kategori,
                    $t->jumlah,
                    $t->keterangan ?? '-',
                    $saldo, // Saldo berjalan murni per petani tersebut
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function kelayakans()
    {
        $produksis = Produksi::with(['pendapatan.labaRugi'])->paginate(10);

        $totalPanen = Produksi::sum('hasil_panen_padi_kg');

        $totalPendapatan = Produksi::whereHas('pendapatan', function ($query) {
            $query->whereNotNull('total_pendapatan');
        })->get()->sum(function ($produksi) {
            return $produksi->pendapatan->total_pendapatan;
        });

        $totalLabaRugi = Produksi::whereHas('pendapatan.labaRugi', function ($query) {
            $query->whereNotNull('total_laba_rugi');
        })->get()->sum(function ($produksi) {
            return $produksi->pendapatan->labaRugi->total_laba_rugi;
        });

        return view('admin.usahatani.kelayakans', compact(
            'produksis',
            'totalPanen',
            'totalPendapatan',
            'totalLabaRugi'
        ));
    }

    public function ujiKelayakanUsaha(Produksi $produksi)
    {
        $produksi->load(['pendapatan.labaRugi']);
        $pendapatan = $produksi->pendapatan;
        $labaRugi = $pendapatan?->labaRugi;

        return view('admin.usahatani.uji_kelayakan_usaha', compact('produksi', 'pendapatan', 'labaRugi'));
    }

    public function hasilAnalisis(Produksi $produksi)
    {
        // Eager load semua relasi sekaligus
        $produksi->load(['pendapatan.labaRugi']);

        $pendapatan = $produksi->pendapatan;
        $labaRugi = $pendapatan?->labaRugi;

        return view('admin.usahatani.hasil', compact('produksi', 'pendapatan', 'labaRugi'));
    }

    public function cetakHasilAnalisis(Produksi $produksi)
    {
        $produksi->load(['pendapatan.labaRugi']);

        $pendapatan = $produksi->pendapatan;
        $labaRugi = $pendapatan?->labaRugi;

        $pdf = Pdf::loadView('admin.usahatani.cetak', compact('produksi', 'pendapatan', 'labaRugi'))
            ->setPaper('f4', 'landscape');

        $filename = 'Hasil_Analisis_Usaha_Tani_'.$produksi->id.'_'.now()->format('Ymd').'.pdf';

        return $pdf->stream($filename);
    }

    public function cetakUjiKelayakan(Produksi $produksi)
    {
        $produksi->load(['pendapatan.labaRugi']);

        $pendapatan = $produksi->pendapatan;
        $labaRugi = $pendapatan?->labaRugi;

        $pdf = Pdf::loadView('admin.usahatani.cetak_kelayakan', compact('produksi', 'pendapatan', 'labaRugi'))
            ->setPaper('a4', 'portrait');

        // Beri nama file yang dinamis berdasarkan ID produksi dan tanggal hari ini
        $filename = 'Analisis_Kelayakan_Usaha_Tani_'.$produksi->id.'_'.now()->format('Ymd').'.pdf';

        // Stream PDF ke browser agar bisa langsung dilihat/dicetak oleh user
        return $pdf->stream($filename);
    }

    public function ujiKelayakan(Produksi $produksi)
    {
        $produksi->load(['pendapatan.labaRugi']);
        $pendapatan = $produksi->pendapatan;
        $labaRugi = $pendapatan?->labaRugi;

        return view('admin.usahatani.kelayakan', compact('produksi', 'pendapatan', 'labaRugi'));
    }

    public function users()
    {
        $users = User::orderBy('name', 'asc')
            ->paginate(10);

        return view('admin.usahatani.users', compact('users')); // Sesuaikan dengan folder view kamu
    }

    public function createUser()
    {
        return view('admin.create_user'); // Sesuaikan dengan folder view Anda
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'], // Wajib diisi untuk user baru
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email ini sudah terdaftar di sistem.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min' => 'Kata sandi minimal harus 8 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Enkripsi password demi keamanan
        ]);

        return redirect()->route('admin.users')->with('success', 'Pengguna baru berhasil ditambahkan!');
    }

    public function editUser($encryptedId)
    {
        try {
            // Dekripsi string acak dari URL kembali menjadi ID angka asli
            $idAsli = Crypt::decryptString($encryptedId);
        } catch (DecryptException $e) {
            // Jika teks acak di URL dimanipulasi / tidak valid, lempar ke halaman 404
            abort(404);
        }

        $user = User::findOrFail($idAsli);

        return view('admin.edit_user', compact('user'));
    }

    // Memproses Update Data User
    public function updateUser(Request $request, $encryptedId)
    {
        try {
            $idAsli = Crypt::decryptString($encryptedId);
        } catch (DecryptException $e) {
            abort(404);
        }

        $user = User::findOrFail($idAsli);

        // Validasi dan simpan data seperti biasa
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id],
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        return redirect()->route('admin.users')->with('success', 'Data pengguna berhasil diperbarui!');
    }

    public function destroyUser(User $user)
    {
        $user->delete();

        return redirect()->route('admin.users')->with('success', 'Pengguna berhasil dihapus');
    }

    public function destroyProduksi(Produksi $produksi)
    {
        $produksi->delete();

        return redirect()->route('admin.produksis')->with('success', 'Produksi berhasil dihapus');
    }

    public function destroyKeuangan(Pendapatan $pendapatan)
    {
        $pendapatan->delete();

        return redirect()->route('admin.keuangans')->with('success', 'Keuangan berhasil dihapus');
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

        $rankingPengguna = User::all()->sortByDesc('saldo')->values()->all();

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
            'rankingPengguna',
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

        return view('admin.dashboard', compact(
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
