<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perhitungan extends Model
{
    use HasFactory;

    protected $table = 'perhitungan';
    protected $primaryKey = 'perhitungan_id';

    protected $fillable = [
        'pendaftaran_id',
        'nilai_akhir',
        'ranking',
        'status_kelulusan',
        'catatan',
        'is_published',
    ];

    protected $casts = [
        'nilai_akhir' => 'decimal:4',
        'is_published' => 'boolean',
    ];

    public function pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class, 'pendaftaran_id', 'pendaftaran_id');
    }
}
