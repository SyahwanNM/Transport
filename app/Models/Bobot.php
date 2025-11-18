<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Bobot extends Model
{
    protected $table = 'bobot';
    
    protected $fillable = [
        'kode_kriteria',
        'bobot'
    ];

    protected $casts = [
        'bobot' => 'decimal:4'
    ];

    public function kriteria(): BelongsTo
    {
        return $this->belongsTo(Kriteria::class, 'kode_kriteria', 'kode_kriteria');
    }
}
