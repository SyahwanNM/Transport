<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kota extends Model
{
    protected $table = 'kota';
    
    protected $fillable = [
        'nama_kota',
        'umr',
        'waktu_tempuh',
        'jumlah_armada',
        'jumlah_kendaraan_pribadi',
        'tarif_minimum_aktual'
    ];

    protected $casts = [
        'umr' => 'decimal:2',
        'waktu_tempuh' => 'decimal:2',
        'tarif_minimum_aktual' => 'decimal:2'
    ];

    public function hasilPerhitungan(): HasMany
    {
        return $this->hasMany(HasilPerhitungan::class);
    }

    public function tarifRekomendasiAcuan(): HasMany
    {
        return $this->hasMany(TarifRekomendasi::class, 'kota_acuan_id');
    }

    public function tarifRekomendasiBanding(): HasMany
    {
        return $this->hasMany(TarifRekomendasi::class, 'kota_banding_id');
    }
}
