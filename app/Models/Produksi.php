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
        'hasil_panen',
        'konsumsi_sendiri',
        'zakat',
        'sewa_lahan',
        'input_usaha_tani',
        'layanan_lain',
        'lain_lain',
        'padi_terjual',
        'beras_terjual'
    ];
}
