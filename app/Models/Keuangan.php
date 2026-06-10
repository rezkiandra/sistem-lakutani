<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Keuangan extends Model
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
        'user_id',
        'tanggal',
        'jenis',
        'kategori',
        'jumlah',
        'keterangan',
        'saldo_berjalan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeMilikSaya($query)
    {
        return $query->where('user_id', auth()->id());
    }

    public function labaRugi()
    {
        return $this->hasOne(LabaRugi::class, 'pendapatan_id');
    }

    public function produksi()
    {
        return $this->belongsTo(Produksi::class, 'produksi_id');
    }
}
