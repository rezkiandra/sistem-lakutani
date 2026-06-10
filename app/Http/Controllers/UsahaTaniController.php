<?php

namespace App\Http\Controllers;

use App\Models\LabaRugi;
use App\Models\Pendapatan;
use App\Models\Produksi;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class UsahaTaniController extends Controller
{
    public function index()
    {
        $query = Auth::user()->isAdmin()
            ? Produksi::with(['user', 'pendapatan.labaRugi'])->latest()
            : Produksi::with(['pendapatan.labaRugi'])->milikSaya()->latest();

        $produksis = $query->paginate(10);

        // Stat cards
        $baseQuery = Auth::user()->isAdmin()
            ? Produksi::query()
            : Produksi::milikSaya();

        $totalPanen = (clone $baseQuery)->sum('hasil_panen_padi_kg');
        $totalPendapatan = Pendapatan::whereHas('produksi', function ($q) {
            if (! Auth::user()->isAdmin()) {
                $q->where('user_id', Auth::id());
            }
        })->sum('total_pendapatan');

        $totalLabaRugi = LabaRugi::whereHas('pendapatan.produksi', function ($q) {
            if (! Auth::user()->isAdmin()) {
                $q->where('user_id', Auth::id());
            }
        })->sum('total_laba_rugi');

        return view('petani.usahatani.index', compact(
            'produksis',
            'totalPanen',
            'totalPendapatan',
            'totalLabaRugi',
        ));
    }

    public function createProduksi()
    {
        return view('petani.usahatani.create_produksi');
    }

    public function storeProduksi(Request $request)
    {
        $validated = $request->validate([
            'hasil_panen_padi_kg' => 'required|numeric|min:0',
            'konsumsi_sendiri_kg' => 'required|numeric|min:0',

            'zakat_kg' => 'sometimes|numeric|min:0',
            'sewa_lahan_kg' => 'sometimes|numeric|min:0',
            'input_usaha_tani_kg' => 'sometimes|numeric|min:0',
            'layanan_lain_kg' => 'sometimes|numeric|min:0',
            'lain_lain_kg' => 'sometimes|numeric|min:0',

            'padi_terjual_kg' => 'required|numeric|min:0',
            'beras_terjual_kg' => 'sometimes|numeric|min:0',
        ], [
            'required' => ':attribute wajib diisi',
            'numeric' => ':attribute harus berupa angka (isi 0 jika tidak ada)',
            'min' => ':attribute harus lebih besar atau sama dengan :min',
        ], [
            'hasil_panen_padi_kg' => 'Hasil Panen Padi',
            'konsumsi_sendiri_kg' => 'Konsumsi Sendiri',
            'zakat_kg' => 'Zakat',
            'sewa_lahan_kg' => 'Sewa Lahan',
            'input_usaha_tani_kg' => 'Input Usaha Tani',
            'layanan_lain_kg' => 'Layanan Lain',
            'lain_lain_kg' => 'Lain-lain',
            'padi_terjual_kg' => 'Padi Terjual',
            'beras_terjual_kg' => 'Beras Terjual',
        ]);

        $validated['nama_petani'] = Auth::user()->name;
        $validated['user_id'] = Auth::user()->id;

        $produksi = Produksi::create($validated);

        return redirect()
            ->route('petani.createPendapatan', $produksi)
            ->with('success', 'Data Produksi berhasil disimpan.');
    }

    public function editProduksi(Produksi $produksi)
    {
        return view('petani.usahatani.edit_produksi', compact('produksi'));
    }

    public function createPendapatan(Produksi $produksi)
    {
        return view('petani.usahatani.create_pendapatan', compact('produksi'));
    }

    public function storePendapatan(Request $request, Produksi $produksi)
    {
        $validated = $request->validate([
            'harga_padi_per_kg' => 'required|numeric|min:0',
            'hasil_samping_jumlah' => 'nullable|numeric|min:0',
            'hasil_samping_harga' => 'nullable|numeric|min:0',
        ]);

        $validated['produksi_id'] = $produksi->id;

        // Kalkulasi otomatis menggunakan data produksi
        $validated['total_penjualan_padi'] = (float) $produksi->padi_terjual_kg * (float) $validated['harga_padi_per_kg'];
        $validated['total_hasil_samping'] = (float) ($validated['hasil_samping_jumlah'] ?? 0) * (float) ($validated['hasil_samping_harga'] ?? 0);
        $validated['total_pendapatan'] = $validated['total_penjualan_padi'] + $validated['total_hasil_samping'];

        $pendapatan = Pendapatan::create($validated);

        return redirect()
            ->route('petani.createLabaRugi', $pendapatan->id)
            ->with('success', 'Data Pendapatan berhasil disimpan!');
    }

    public function createLabaRugi(Pendapatan $pendapatan)
    {
        $pendapatan->load('produksi');

        return view('petani.usahatani.create_laba_rugi', compact('pendapatan'));
    }

    public function storeLabaRugi(Request $request, Pendapatan $pendapatan)
    {
        $validated = $request->validate([
            'benih' => 'nullable|numeric|min:0',
            'urea' => 'nullable|numeric|min:0',
            'tsp_sp36' => 'nullable|numeric|min:0',
            'pupuk_lainnya' => 'nullable|numeric|min:0',
            'bahan_kimia' => 'nullable|numeric|min:0',
            'biaya_pekerja' => 'nullable|numeric|min:0',
            'pembajakan' => 'nullable|numeric|min:0',
            'perataan_lahan' => 'nullable|numeric|min:0',
            'pemeliharaan_alat' => 'nullable|numeric|min:0',
            'pengeluaran_lain_produksi' => 'nullable|numeric|min:0',
            'panen' => 'nullable|numeric|min:0',
            'pengeringan' => 'nullable|numeric|min:0',
            'transpor' => 'nullable|numeric|min:0',
            'perontokan' => 'nullable|numeric|min:0',
            'zakat_uang' => 'nullable|numeric|min:0',
            'penggilingan' => 'nullable|numeric|min:0',
            'sewa_lahan' => 'nullable|numeric|min:0',
            'asuransi' => 'nullable|numeric|min:0',
        ]);

        $validated['pendapatan_id'] = $pendapatan->id;

        // Kalkulasi subtotal
        $subInput = (float) ($validated['benih'] ?? 0)
                    + (float) ($validated['urea'] ?? 0)
                    + (float) ($validated['tsp_sp36'] ?? 0)
                    + (float) ($validated['pupuk_lainnya'] ?? 0)
                    + (float) ($validated['bahan_kimia'] ?? 0);

        $subProduksi = (float) ($validated['pembajakan'] ?? 0)
                    + (float) ($validated['perataan_lahan'] ?? 0)
                    + (float) ($validated['pemeliharaan_alat'] ?? 0)
                    + (float) ($validated['pengeluaran_lain_produksi'] ?? 0);

        $subPanen = (float) ($validated['panen'] ?? 0)
                    + (float) ($validated['pengeringan'] ?? 0)
                    + (float) ($validated['transpor'] ?? 0)
                    + (float) ($validated['perontokan'] ?? 0)
                    + (float) ($validated['zakat_uang'] ?? 0)
                    + (float) ($validated['penggilingan'] ?? 0);

        $totalPengeluaranProduksi = $subInput
                    + (float) ($validated['biaya_pekerja'] ?? 0)
                    + $subProduksi
                    + $subPanen
                    + (float) ($validated['sewa_lahan'] ?? 0)
                    + (float) ($validated['asuransi'] ?? 0);

        // Ambil total_pendapatan dari relasi pendapatan
        $totalPendapatan = (float) $pendapatan->total_pendapatan;

        $validated['subtotal_input_usaha_tani'] = $subInput;
        $validated['subtotal_pengeluaran_lain'] = $subProduksi;
        $validated['subtotal_biaya_panen'] = $subPanen;
        $validated['total_pengeluaran_produksi'] = $totalPengeluaranProduksi;
        $validated['total_pendapatan'] = $totalPendapatan;
        $validated['total_laba_rugi'] = $totalPendapatan - $totalPengeluaranProduksi;

        LabaRugi::create($validated);

        return redirect()
            ->route('petani.hasilAnalisis', $pendapatan->produksi_id)
            ->with('success', 'Analisis Laba/Rugi berhasil disimpan!');
    }

    public function hasilAnalisis(Produksi $produksi)
    {
        // Eager load semua relasi sekaligus
        $produksi->load(['pendapatan.labaRugi']);

        $pendapatan = $produksi->pendapatan;
        $labaRugi = $pendapatan?->labaRugi;

        return view('petani.usahatani.hasil', compact('produksi', 'pendapatan', 'labaRugi'));
    }

    public function cetakHasilAnalisis(Produksi $produksi)
    {
        $produksi->load(['pendapatan.labaRugi']);

        $pendapatan = $produksi->pendapatan;
        $labaRugi = $pendapatan?->labaRugi;

        $pdf = Pdf::loadView('petani.usahatani.cetak', compact('produksi', 'pendapatan', 'labaRugi'))
            ->setPaper('f4', 'landscape');

        $filename = 'Hasil_Analisis_Usaha_Tani_'.$produksi->id.'_'.now()->format('Ymd').'.pdf';

        return $pdf->stream($filename);
    }

    public function cetakUjiKelayakan(Produksi $produksi)
    {
        $produksi->load(['pendapatan.labaRugi']);

        $pendapatan = $produksi->pendapatan;
        $labaRugi = $pendapatan?->labaRugi;

        $pdf = Pdf::loadView('petani.usahatani.cetak_kelayakan', compact('produksi', 'pendapatan', 'labaRugi'))
            ->setPaper('a4', 'portrait');

        // Beri nama file yang dinamis berdasarkan ID produksi dan tanggal hari ini
        $filename = 'Analisis_Kelayakan_Usaha_Tani_'.$produksi->id.'_'.now()->format('Ymd').'.pdf';

        // Stream PDF ke browser agar bisa langsung dilihat/dicetak oleh user
        return $pdf->stream($filename);
    }

    public function createUjiKelayakan()
    {
        $produksis = Produksi::all();

        return view('petani.usahatani.create_ujikelayakan', compact('produksis'));
    }

    public function ujiKelayakan(Produksi $produksi)
    {
        $produksi->load(['pendapatan.labaRugi']);
        $pendapatan = $produksi->pendapatan;
        $labaRugi = $pendapatan?->labaRugi;

        return view('petani.usahatani.kelayakan', compact('produksi', 'pendapatan', 'labaRugi'));
    }

    private function authorize(Produksi $produksi)
    {
        if (! Auth::user()->isAdmin() && $produksi->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke data ini.');
        }
    }
}
