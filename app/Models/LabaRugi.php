<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class LabaRugi extends Model
{
    public $incrementing = false;

    protected $keyType = 'string';

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->id = Str::uuid();
        });
    }

    protected $fillable = [
        'pendapatan_id',
        'benih',
        'urea',
        'tsp_sp36',
        'pupuk_lainnya',
        'bahan_kimia',
        'subtotal_input_usaha_tani',
        'biaya_pekerja',
        'pembajakan',
        'perataan_lahan',
        'pemeliharaan_alat',
        'pengeluaran_lain_produksi',
        'subtotal_pengeluaran_lain',
        'panen',
        'pengeringan',
        'transpor',
        'perontonkan',
        'zakat_uang',
        'penggilingan',
        'subtotal_biaya_panen',
        'sewa_lahan',
        'asuransi',
        'total_pengeluaran_produksi',
        'total_pendapatan',
        'total_laba_rugi',
    ];
}