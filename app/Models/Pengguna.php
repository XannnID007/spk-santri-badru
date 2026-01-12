<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Pengguna extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'pengguna';
    protected $primaryKey = 'pengguna_id';

    protected $fillable = [
        'nama',
        'email',
        'no_hp',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Method untuk authentication
    public function getAuthIdentifierName()
    {
        return 'pengguna_id';
    }

    public function getAuthIdentifier()
    {
        return $this->pengguna_id;
    }

    public function getAuthPassword()
    {
        return $this->password;
    }

    public function getRememberToken()
    {
        return $this->remember_token;
    }

    public function setRememberToken($value)
    {
        $this->remember_token = $value;
    }

    public function getRememberTokenName()
    {
        return 'remember_token';
    }

    // Relationships
    public function profil()
    {
        return $this->hasOne(Profil::class, 'pengguna_id', 'pengguna_id');
    }

    public function pendaftaran()
    {
        return $this->hasMany(Pendaftaran::class, 'pengguna_id', 'pengguna_id');
    }

    public function logAktivitas()
    {
        return $this->hasMany(LogAktivitas::class, 'pengguna_id', 'pengguna_id');
    }

    // Helper methods
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isPendaftar()
    {
        return $this->role === 'pendaftar';
    }
}
