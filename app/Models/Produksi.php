<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Produksi extends Model
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
        'nama_petani',
        'hasil_panen_padi_kg',
        'konsumsi_sendiri_kg',
        'zakat_kg',
        'sewa_lahan_kg',
        'input_usaha_tani_kg',
        'layanan_lain_kg',
        'lain_lain_kg',
        'padi_terjual_kg',
        'beras_terjual_kg',
    ];

    public function getUuidRouteName()
    {
        return Str::uuid();
    }

    public function pendapatan()
    {
        return $this->hasOne(Pendapatan::class, 'produksi_id');
    }
}

