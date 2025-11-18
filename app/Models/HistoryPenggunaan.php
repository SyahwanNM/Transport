<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HistoryPenggunaan extends Model
{
    protected $table = 'history_penggunaan';
    
    public $timestamps = false; // Nonaktifkan timestamps karena hanya ada created_at di migration
    
    protected $fillable = [
        'nama_kota_user',
        'umr_user',
        'waktu_tempuh_user',
        'jumlah_armada_user',
        'jumlah_kendaraan_pribadi_user',
        'tarif_minimum_aktual_user',
        'kota_pembanding_id',
        'tarif_rekomendasi',
        'selisih',
        'skor_user',
        'skor_pembanding',
        'ip_address',
    ];

    protected $casts = [
        'umr_user' => 'decimal:2',
        'waktu_tempuh_user' => 'decimal:2',
        'tarif_minimum_aktual_user' => 'decimal:2',
        'tarif_rekomendasi' => 'decimal:2',
        'selisih' => 'decimal:2',
        'skor_user' => 'decimal:6',
        'skor_pembanding' => 'decimal:6',
        'created_at' => 'datetime',
    ];

    public function kotaPembanding(): BelongsTo
    {
        return $this->belongsTo(Kota::class, 'kota_pembanding_id');
    }
}
