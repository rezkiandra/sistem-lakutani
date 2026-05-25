<?php

namespace App\Http\Controllers;

use App\Models\Pendapatan;
use App\Models\Produksi;
use Illuminate\Http\Request;

class UsahaTaniController extends Controller
{
    public function index()
    {
        $data = Produksi::orderBy('created_at', 'desc')->get();

        return view('admin.usahatani.index', compact('data'));
    }

    public function createProduksi()
    {
        return view('admin.usahatani.create_produksi');
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

        $produksi = Produksi::create($validated);

        return redirect()
            ->route('createPendapatan', $produksi)
            ->with('success', 'Data berhasil disimpan.');
    }

    public function createPendapatan(Produksi $produksi)
    {
        return view('admin.usahatani.create_pendapatan', compact('produksi'));
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
            ->route('createLabaRugi', $pendapatan->id)
            ->with('success', 'Data Pendapatan berhasil disimpan!');
    }

    public function createLabaRugi(Pendapatan $pendapatan)
    {
        $pendapatan->load('produksi');
        return view('admin.usahatani.create_laba_rugi', compact('pendapatan'));
    }

}
