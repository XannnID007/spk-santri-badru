<?php

namespace App\Http\Controllers;

use App\Models\Pengaturan;
use App\Models\Periode;
use App\Models\Banner;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        $pengaturan = Pengaturan::first();
        $periodeAktif = Periode::where('status_aktif', true)->first();
        $banners = Banner::where('status_aktif', true)
            ->orderBy('urutan', 'asc')
            ->get();

        // Hitung total pendaftar periode aktif
        $totalPendaftar = 0;
        if ($periodeAktif) {
            $totalPendaftar = Pendaftaran::where('periode_id', $periodeAktif->periode_id)
                ->where('status_pendaftaran', 'submitted')
                ->count();
        }

        return view('landing', compact('pengaturan', 'periodeAktif', 'banners', 'totalPendaftar'));
    }
}
