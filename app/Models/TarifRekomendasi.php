<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TarifRekomendasi extends Model
{
    protected $table = 'tarif_rekomendasi';
    
    protected $fillable = [
        'kota_acuan_id',
        'kota_banding_id',
        'tarif_acuan',
        'skor_acuan',
        'skor_banding',
        'tarif_rekomendasi',
        'tarif_aktual',
        'selisih'
    ];

    protected $casts = [
        'tarif_acuan' => 'decimal:2',
        'skor_acuan' => 'decimal:6',
        'skor_banding' => 'decimal:6',
        'tarif_rekomendasi' => 'decimal:2',
        'tarif_aktual' => 'decimal:2',
        'selisih' => 'decimal:2'
    ];

    public function kotaAcuan(): BelongsTo
    {
        return $this->belongsTo(Kota::class, 'kota_acuan_id');
    }

    public function kotaBanding(): BelongsTo
    {
        return $this->belongsTo(Kota::class, 'kota_banding_id');
    }
}
