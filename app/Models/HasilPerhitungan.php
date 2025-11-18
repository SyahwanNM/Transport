<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HasilPerhitungan extends Model
{
    protected $table = 'hasil_perhitungan';
    
    protected $fillable = [
        'kota_id',
        'kode_kriteria',
        'nilai_asli',
        'nilai_normalisasi',
        'bobot',
        'skor_preferensi'
    ];

    protected $casts = [
        'nilai_asli' => 'decimal:2',
        'nilai_normalisasi' => 'decimal:6',
        'bobot' => 'decimal:4',
        'skor_preferensi' => 'decimal:6'
    ];

    public function kota(): BelongsTo
    {
        return $this->belongsTo(Kota::class);
    }

    public function kriteria(): BelongsTo
    {
        return $this->belongsTo(Kriteria::class, 'kode_kriteria', 'kode_kriteria');
    }
}
