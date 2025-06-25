<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PemesananKendaraan extends Model
{
    protected $table = 'pemesanan_kendaraans';

    protected $fillable = [
        'user_id',
        'kendaraan_id',
        'driver',
        'approver1_id',
        'approver2_id',
        'tanggal_mulai',
        'tanggal_selesai',
        'keperluan',
        'status',
    ];


    // Relasi ke user yang melakukan pemesanan
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke kendaraan
    public function kendaraan(): BelongsTo
    {
        return $this->belongsTo(Kendaraan::class);
    }

    // Relasi ke approver level 1
    public function approver1(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approver1_id');
    }

    // Relasi ke approver level 2
    public function approver2(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approver2_id');
    }
}
