<?php

namespace App\Http\Controllers\Admin;

use App\Models\Periode;
use App\Models\Pengaturan;
use App\Models\Pendaftaran;
use App\Models\Perhitungan;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class LaporanController extends Controller
{
    /**
     * Sanitize filename untuk mencegah karakter ilegal
     */
    private function sanitizeFilename($filename)
    {
        // Hapus atau ganti karakter yang tidak diperbolehkan: / \ : * ? " < > |
        $filename = str_replace(['/', '\\', ':', '*', '?', '"', '<', '>', '|'], '-', $filename);

        // Hapus spasi berlebih dan ganti dengan dash
        $filename = preg_replace('/\s+/', '-', $filename);

        // Hapus dash berlebih
        $filename = preg_replace('/-+/', '-', $filename);

        // Trim dash di awal dan akhir
        $filename = trim($filename, '-');

        return $filename;
    }

    public function index()
    {
        $periodes = Periode::orderBy('periode_id', 'desc')->get();
        return view('admin.laporan.index', compact('periodes'));
    }

    public function laporanPendaftaran(Request $request)
    {
        try {
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
            ))
                ->setPaper('a4', 'landscape')
                ->setOption('enable-local-file-access', true)
                ->setOption('isHtml5ParserEnabled', true)
                ->setOption('isRemoteEnabled', true);

            // Sanitize filename - hapus karakter yang tidak diperbolehkan
            $filename = $this->sanitizeFilename('laporan-pendaftaran-' . $periode->nama_periode . '.pdf');

            return $pdf->download($filename);
        } catch (\Exception $e) {
            Log::error('Error generating Laporan Pendaftaran: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat membuat laporan: ' . $e->getMessage());
        }
    }

    public function laporanHasilSeleksi(Request $request)
    {
        try {
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

            if ($hasil->isEmpty()) {
                return redirect()->back()->with('error', 'Belum ada hasil perhitungan untuk periode ini!');
            }

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
            ))
                ->setPaper('a4', 'landscape')
                ->setOption('enable-local-file-access', true)
                ->setOption('isHtml5ParserEnabled', true)
                ->setOption('isRemoteEnabled', true);

            // Sanitize filename - hapus karakter yang tidak diperbolehkan
            $filename = $this->sanitizeFilename('laporan-hasil-seleksi-' . $periode->nama_periode . '.pdf');

            return $pdf->download($filename);
        } catch (\Exception $e) {
            Log::error('Error generating Laporan Hasil Seleksi: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat membuat laporan: ' . $e->getMessage());
        }
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
