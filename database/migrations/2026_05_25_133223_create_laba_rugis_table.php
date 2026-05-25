<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('laba_rugis', function (Blueprint $table) {
            $table->uuid('id')->primary();

            // Relasi ke pendapatan (bukan langsung ke produksi)
            $table->foreignUuid('pendapatan_id')
                ->constrained('pendapatans')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            // ── PENGELUARAN ──────────────────────────────
            // Input Usaha Tani
            $table->decimal('benih', 15, 2)->default(0);
            $table->decimal('urea', 15, 2)->default(0);
            $table->decimal('tsp_sp36', 15, 2)->default(0);
            $table->decimal('pupuk_lainnya', 15, 2)->default(0);
            $table->decimal('bahan_kimia', 15, 2)->default(0);
            $table->decimal('subtotal_input_usaha_tani', 15, 2)->default(0);

            // Biaya Pekerja
            $table->decimal('biaya_pekerja', 15, 2)->default(0);

            // Pengeluaran Lain Produksi
            $table->decimal('pembajakan', 15, 2)->default(0);
            $table->decimal('perataan_lahan', 15, 2)->default(0);
            $table->decimal('pemeliharaan_alat', 15, 2)->default(0);
            $table->decimal('pengeluaran_lain_produksi', 15, 2)->default(0);
            $table->decimal('subtotal_pengeluaran_lain', 15, 2)->default(0);

            // Biaya Panen & Penjualan
            $table->decimal('panen', 15, 2)->default(0);
            $table->decimal('pengeringan', 15, 2)->default(0);
            $table->decimal('transpor', 15, 2)->default(0);
            $table->decimal('perontokan', 15, 2)->default(0);
            $table->decimal('zakat_uang', 15, 2)->default(0);
            $table->decimal('penggilingan', 15, 2)->default(0);
            $table->decimal('subtotal_biaya_panen', 15, 2)->default(0);

            // Sewa Lahan & Asuransi
            $table->decimal('sewa_lahan', 15, 2)->default(0);
            $table->decimal('asuransi', 15, 2)->default(0);

            $table->decimal('total_pengeluaran_produksi', 15, 2)->default(0);
            $table->decimal('total_pendapatan', 15, 2)->default(0);

            // ── HASIL AKHIR ───────────────────────────────
            // total_pendapatan diambil dari tabel pendapatan saat kalkulasi
            $table->decimal('total_laba_rugi', 15, 2)->default(0); // total_pendapatan - total_pengeluaran

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laba_rugis');
    }
};
