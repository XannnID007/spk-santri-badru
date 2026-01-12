<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persyaratan extends Model
{
    use HasFactory;

    protected $table = 'persyaratan';
    protected $primaryKey = 'persyaratan_id';

    protected $fillable = [
        'nama_dokumen',
        'deskripsi',
        'wajib',
        'format_file',
        'max_size',
        'status_aktif',
    ];

    protected $casts = [
        'wajib' => 'boolean',
        'status_aktif' => 'boolean',
    ];
}
