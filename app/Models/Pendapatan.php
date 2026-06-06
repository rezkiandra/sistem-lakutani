<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Pendapatan extends Model
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
        'produksi_id',
        'harga_padi_per_kg',
        'total_penjualan_padi',
        'jumlah_hasil_samping',
        'harga_hasil_samping',
        'total_hasil_samping',
        'total_pendapatan',
    ];

    public function produksi()
    {
        return $this->belongsTo(Produksi::class, 'produksi_id');
    }

    /** Pendapatan punya satu laba_rugi */
    public function labaRugi()
    {
        return $this->hasOne(LabaRugi::class, 'pendapatan_id');
    }
}
