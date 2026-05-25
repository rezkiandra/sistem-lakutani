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
        Schema::create('pendapatans', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignUuid('produksi_id')
                ->constrained('produksis')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->decimal('harga_padi_per_kg', 10, 2)->default(0);
            $table->decimal('total_penjualan_padi', 15, 2)->default(0);
            
            $table->decimal('jumlah_hasil_samping', 10, 2)->default(0);
            $table->decimal('harga_hasil_samping', 10, 2)->default(0);
            $table->decimal('total_hasil_samping', 15, 2)->default(0);
            
            $table->decimal('total_pendapatan', 15, 2)->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendapatans');
    }
};
