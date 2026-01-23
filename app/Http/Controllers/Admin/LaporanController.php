<?php

namespace App\Http\Controllers\Admin;

use App\Models\Periode;
use App\Models\Pendaftaran;
use App\Models\Perhitungan;
use App\Models\Pengaturan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;

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

        if (!$periodeId) {
            return redirect()->back()->with('error', 'Silakan pilih periode terlebih dahulu!');
        }

        $periode = Periode::findOrFail($periodeId);
        $pengaturan = Pengaturan::first();

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
            'rejected',
            'pengaturan'
        ))->setPaper('a4', 'landscape');

        return $pdf->download('laporan-pendaftaran-' . $periode->nama_periode . '.pdf');
    }

    public function laporanHasilSeleksi(Request $request)
    {
        $periodeId = $request->get('periode_id');

        if (!$periodeId) {
            return redirect()->back()->with('error', 'Silakan pilih periode terlebih dahulu!');
        }

        $periode = Periode::findOrFail($periodeId);
        $pengaturan = Pengaturan::first();

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
            'totalDitolak',
            'pengaturan'
        ))->setPaper('a4', 'landscape');

        return $pdf->download('laporan-hasil-seleksi-' . $periode->nama_periode . '.pdf');
    }

    public function exportExcel(Request $request)
    {
        // Implementasi export Excel menggunakan Laravel Excel
        // Install dulu: composer require maatwebsite/excel

        return response()->json([
            'success' => false,
            'message' => 'Fitur Export Excel dalam pengembangan. Gunakan format PDF terlebih dahulu.'
        ], 501);
    }
}
