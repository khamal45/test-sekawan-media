<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kendaraan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'jenis', // 'angkutan orang' / 'angkutan barang'
        'tipe', // 'milik perusahaan' / 'sewaan'
        'no_polisi',
        'region',
        'konsumsi_bbm', // misal: liter per km
        'jadwal_service_berikutnya',
    ];

    protected $casts = [
        'jadwal_service_berikutnya' => 'date',
    ];

    public function pemesanan()
    {
        return $this->hasMany(PemesananKendaraan::class);
    }

    // public function riwayat()
    // {
    //     return $this->hasMany(RiwayatPemakaian::class); // opsional jika pakai tabel riwayat terpisah
    // }
}
