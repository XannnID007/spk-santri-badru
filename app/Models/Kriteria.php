<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kriteria extends Model
{
    use HasFactory;

    protected $table = 'kriteria';
    protected $primaryKey = 'kriteria_id';

    protected $fillable = [
        'kode_kriteria',
        'nama_kriteria',
        'bobot',
        'jenis',
        'status_aktif',
    ];

    protected $casts = [
        'bobot' => 'decimal:2',
        'status_aktif' => 'boolean',
    ];

    public function nilaiTes()
    {
        return $this->hasMany(NilaiTes::class, 'kriteria_id', 'kriteria_id');
    }
}
