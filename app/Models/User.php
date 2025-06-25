<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // tambah role di sini
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

    // Relasi: pemesanan yang dibuat oleh user ini
    public function pemesanan(): HasMany
    {
        return $this->hasMany(PemesananKendaraan::class);
    }

    // Relasi: user sebagai approver level 1
    public function approved1(): HasMany
    {
        return $this->hasMany(PemesananKendaraan::class, 'approver1_id');
    }

    // Relasi: user sebagai approver level 2
    public function approved2(): HasMany
    {
        return $this->hasMany(PemesananKendaraan::class, 'approver2_id');
    }

    // Akses cepat: apakah user ini admin?
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    // Akses cepat: apakah user ini approver?
    public function isApprover(): bool
    {
        return $this->role === 'approver';
    }
}
