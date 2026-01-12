<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    use HasFactory;

    protected $table = 'pendaftaran';
    protected $primaryKey = 'pendaftaran_id';

    protected $fillable = [
        'no_pendaftaran',
        'pengguna_id',
        'periode_id',
        'asal_sekolah',
        'rata_nilai',
        'prestasi',
        'file_kk',
        'file_akta',
        'file_ijazah',
        'file_foto',
        'file_sktm',
        'status_verifikasi',
        'status_pendaftaran',
        'tanggal_submit',
    ];

    protected $casts = [
        'rata_nilai' => 'decimal:2',
        'tanggal_submit' => 'datetime',
    ];

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'pengguna_id', 'pengguna_id');
    }

    public function periode()
    {
        return $this->belongsTo(Periode::class, 'periode_id', 'periode_id');
    }

    public function nilaiTes()
    {
        return $this->hasMany(NilaiTes::class, 'pendaftaran_id', 'pendaftaran_id');
    }

    public function perhitungan()
    {
        return $this->hasOne(Perhitungan::class, 'pendaftaran_id', 'pendaftaran_id');
    }
}
