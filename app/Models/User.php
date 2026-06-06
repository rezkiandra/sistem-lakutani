<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

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
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function produksis()
    {
        return $this->hasMany(Produksi::class);
    }

    public function keuangans()
    {
        return $this->hasMany(Keuangan::class);
    }
}
