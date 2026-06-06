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
        Schema::create('keuangans', function (Blueprint $table) {
        $table->uuid('id')->primary();
        $table->foreignId('user_id')->constrained()->cascadeOnDelete();
        $table->date('tanggal');
        $table->enum('jenis', ['pemasukan', 'pengeluaran']);
        $table->string('kategori');
        $table->decimal('jumlah', 15, 2)->default(0);
        $table->text('keterangan')->nullable();
        $table->decimal('saldo_berjalan', 15, 2)->default(0);
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keuangans');
    }
};
