<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengaturan extends Model
{
    use HasFactory;

    protected $table = 'pengaturan';
    protected $primaryKey = 'pengaturan_id';

    protected $fillable = [
        'nama_pesantren',
        'logo',
        'alamat',
        'telepon',
        'email',
        'website',
        'no_rekening',
        'atas_nama',
        'nama_bank',
        'jumlah_santri',
        'jumlah_guru',
        'jumlah_alumni',
    ];
}
