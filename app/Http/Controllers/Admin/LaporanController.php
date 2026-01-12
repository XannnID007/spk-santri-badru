<?php

namespace App\Http\Controllers\Admin;

use App\Models\Periode;
use App\Models\Pendaftaran;
use App\Models\Perhitungan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LaporanController extends Controller
{
    public function index()
    {
        $periodes = Periode::orderBy('periode_id', 'desc')->get();
        return view('admin.laporan.index', compact('periodes'));
    }

    public function laporanPendaftaran(Request $request)
    {
        $periodeId = $request->get('periode_id');
        $periode = Periode::findOrFail($periodeId);

        $pendaftarans = Pendaftaran::with(['pengguna.profil', 'periode'])
            ->where('periode_id', $periodeId)
            ->where('status_pendaftaran', 'submitted')
            ->orderBy('tanggal_submit', 'asc')
            ->get();

        $totalPendaftar = $pendaftarans->count();
        $verified = $pendaftarans->where('status_verifikasi', 'diterima')->count();
        $pending = $pendaftarans->where('status_verifikasi', 'pending')->count();
        $rejected = $pendaftarans->where('status_verifikasi', 'ditolak')->count();

        $pdf = Pdf::loadView('admin.laporan.pendaftaran', compact(
            'periode',
            'pendaftarans',
            'totalPendaftar',
            'verified',
            'pending',
            'rejected'
        ));

        return $pdf->download('laporan-pendaftaran-' . $periode->nama_periode . '.pdf');
    }

    public function laporanHasilSeleksi(Request $request)
    {
        $periodeId = $request->get('periode_id');
        $periode = Periode::findOrFail($periodeId);

        $hasil = Perhitungan::whereHas('pendaftaran', function ($query) use ($periodeId) {
            $query->where('periode_id', $periodeId);
        })
            ->with(['pendaftaran.pengguna.profil'])
            ->orderBy('ranking', 'asc')
            ->get();

        $totalDiterima = $hasil->where('status_kelulusan', 'diterima')->count();
        $totalCadangan = $hasil->where('status_kelulusan', 'cadangan')->count();
        $totalDitolak = $hasil->where('status_kelulusan', 'tidak_diterima')->count();

        $pdf = Pdf::loadView('admin.laporan.hasil-seleksi', compact(
            'periode',
            'hasil',
            'totalDiterima',
            'totalCadangan',
            'totalDitolak'
        ));

        return $pdf->download('laporan-hasil-seleksi-' . $periode->nama_periode . '.pdf');
    }

    public function exportExcel(Request $request)
    {
        // Implementasi export Excel bisa menggunakan Laravel Excel
        // Untuk saat ini return JSON sebagai placeholder

        return response()->json([
            'success' => true,
            'message' => 'Export Excel akan segera tersedia'
        ]);
    }
}
