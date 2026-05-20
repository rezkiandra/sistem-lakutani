<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Produksi;
use Illuminate\Http\Request;

class ProduksiController extends Controller
{
    public function index()
    {
        $produksis = Produksi::orderBy('created_at', 'ASC')->get();
        return view('admin.produksi.index', compact('produksis'));
    }

    public function create()
    {
        return view('admin.produksi.create');
    }

    public function store(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'hasil_panen' => 'required|integer|min:0',
            'konsumsi_sendiri' => 'required|integer|min:0',

            'zakat' => 'sometimes|integer|min:0',
            'sewa_lahan' => 'sometimes|integer|min:0',
            'input_usaha_tani' => 'sometimes|integer|min:0',
            'layanan_lain' => 'sometimes|integer|min:0',
            'lain_lain' => 'sometimes|integer|min:0',

            'padi_terjual' => 'required|integer|min:0',
            'beras_terjual' => 'sometimes|integer|min:0',
        ], [
            'required' => ':attribute wajib diisi',
            'integer' => ':attribute harus berupa angka (isi 0 jika tidak ada)',
            'min' => ':attribute harus lebih besar atau sama dengan :min',
        ], [
            'hasil_panen' => 'Hasil Panen',
            'konsumsi_sendiri' => 'Konsumsi Sendiri',
            'zakat' => 'Zakat',
            'sewa_lahan' => 'Sewa Lahan',
            'input_usaha_tani' => 'Input Usaha Tani',
            'layanan_lain' => 'Layanan Lain',
            'lain_lain' => 'Lain-lain',
            'padi_terjual' => 'Padi Terjual',
            'beras_terjual' => 'Beras Terjual',
        ]);

        $produksi = Produksi::create($request->all());

        return redirect()->route('produksi.index')->with('success', 'Data berhasil disimpan.');
    }

    public function show(Produksi $produksi)
    {
        return view('admin.produksi.show', compact('produksi'));
    }

    public function edit(Produksi $produksi)
    {
        return view('admin.produksi.edit', compact('produksi'));
    }

    public function update(Request $request, Produksi $produksi)
    {
        $request->validate([
            'hasil_panen' => 'required|integer|min:0',
            'konsumsi_sendiri' => 'required|integer|min:0',

            'zakat' => 'sometimes|integer|min:0',
            'sewa_lahan' => 'sometimes|integer|min:0',
            'input_usaha_tani' => 'sometimes|integer|min:0',
            'layanan_lain' => 'sometimes|integer|min:0',
            'lain_lain' => 'sometimes|integer|min:0',

            'padi_terjual' => 'required|integer|min:0',
            'beras_terjual' => 'sometimes|integer|min:0',
        ], [
            'required' => ':attribute wajib diisi',
            'integer' => ':attribute harus berupa angka (isi 0 jika tidak ada)',
            'min' => ':attribute harus lebih besar atau sama dengan :min',
        ], [
            'hasil_panen' => 'Hasil Panen',
            'konsumsi_sendiri' => 'Konsumsi Sendiri',
            'zakat' => 'Zakat',
            'sewa_lahan' => 'Sewa Lahan',
            'input_usaha_tani' => 'Input Usaha Tani',
            'layanan_lain' => 'Layanan Lain',
            'lain_lain' => 'Lain-lain',
            'padi_terjual' => 'Padi Terjual',
            'beras_terjual' => 'Beras Terjual',
        ]);

        $produksi->update($request->all());

        return redirect()->route('produksi.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy(Produksi $produksi)
    {
        $produksi->delete();

        return redirect()->route('produksi.index')->with('success', 'Data berhasil dihapus.');
    }
}
