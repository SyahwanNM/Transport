<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kriteria extends Model
{
    protected $table = 'kriteria';
    
    protected $fillable = [
        'kode_kriteria',
        'nama_kriteria',
        'jenis'
    ];

    public function bobot(): HasMany
    {
        return $this->hasMany(Bobot::class, 'kode_kriteria', 'kode_kriteria');
    }

    public function hasilPerhitungan(): HasMany
    {
        return $this->hasMany(HasilPerhitungan::class, 'kode_kriteria', 'kode_kriteria');
    }
}