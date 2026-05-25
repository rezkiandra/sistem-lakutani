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
        Schema::create('produksis', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama_petani')->nullable();

            $table->decimal('hasil_panen_padi_kg', 10, 2)->default(0);

            // Alokasi padi yang dipanen
            $table->decimal('konsumsi_sendiri_kg', 10, 2)->default(0);
            $table->decimal('zakat_kg', 10, 2)->default(0);
            $table->decimal('sewa_lahan_kg', 10, 2)->default(0);
            $table->decimal('input_usaha_tani_kg', 10, 2)->default(0);
            $table->decimal('layanan_lain_kg', 10, 2)->default(0);
            $table->decimal('lain_lain_kg', 10, 2)->default(0);

            // Hasil produksi yang terjual
            $table->decimal('padi_terjual_kg', 10, 2)->default(0);
            $table->decimal('beras_terjual_kg', 10, 2)->default(0);

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produksis');
    }
};
