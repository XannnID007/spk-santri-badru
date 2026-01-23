<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use App\Models\Perhitungan;
use App\Models\Periode;
use App\Models\Pengaturan;

// Dashboard Admin Controller
class DashboardAdminController extends Controller
{
    public function index()
    {
        $periodeAktif = Periode::where('status_aktif', true)->first();

        $totalPendaftar = 0;
        $totalDiterima = 0;
        $totalCadangan = 0;
        $totalDitolak = 0;

        if ($periodeAktif) {
            $totalPendaftar = Pendaftaran::where('periode_id', $periodeAktif->periode_id)
                ->where('status_pendaftaran', 'submitted')
                ->count();

            $totalDiterima = Perhitungan::whereHas('pendaftaran', function ($q) use ($periodeAktif) {
                $q->where('periode_id', $periodeAktif->periode_id);
            })->where('status_kelulusan', 'diterima')->count();

            $totalCadangan = Perhitungan::whereHas('pendaftaran', function ($q) use ($periodeAktif) {
                $q->where('periode_id', $periodeAktif->periode_id);
            })->where('status_kelulusan', 'cadangan')->count();

            $totalDitolak = Perhitungan::whereHas('pendaftaran', function ($q) use ($periodeAktif) {
                $q->where('periode_id', $periodeAktif->periode_id);
            })->where('status_kelulusan', 'tidak_diterima')->count();
        }

        $pengaturan = Pengaturan::first();

        return view('admin.dashboard', compact(
            'periodeAktif',
            'totalPendaftar',
            'totalDiterima',
            'totalCadangan',
            'totalDitolak',
            'pengaturan'
        ));
    }
}
