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
            $table->integer('hasil_panen');
            $table->integer('konsumsi_sendiri');

            $table->integer('zakat')->default(0);
            $table->integer('sewa_lahan')->default(0);
            $table->integer('input_usaha_tani')->default(0);
            $table->integer('layanan_lain')->default(0);
            $table->integer('lain_lain')->default(0);

            $table->integer('padi_terjual');

            $table->integer('beras_terjual')->default(0);
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
