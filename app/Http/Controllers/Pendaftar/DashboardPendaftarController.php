<?php

namespace App\Http\Controllers\Pendaftar;

use App\Http\Controllers\Controller;
use App\Models\Profil;
use App\Models\Pendaftaran;
use App\Models\Periode;
use App\Models\Perhitungan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

// Dashboard Pendaftar Controller
class DashboardPendaftarController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $profil = Profil::where('pengguna_id', $user->pengguna_id)->first();
        $pendaftaran = Pendaftaran::where('pengguna_id', $user->pengguna_id)->first();
        $periodeAktif = Periode::where('status_aktif', true)->first();

        $statusProfil = $profil && $profil->is_lengkap;
        $statusPendaftaran = $pendaftaran && $pendaftaran->status_pendaftaran === 'submitted';

        // Cek pengumuman
        $pengumuman = null;
        if ($pendaftaran) {
            $pengumuman = Perhitungan::where('pendaftaran_id', $pendaftaran->pendaftaran_id)
                ->where('is_published', true)
                ->first();
        }

        return view('pendaftar.dashboard', compact(
            'profil',
            'pendaftaran',
            'periodeAktif',
            'statusProfil',
            'statusPendaftaran',
            'pengumuman'
        ));
    }
}
