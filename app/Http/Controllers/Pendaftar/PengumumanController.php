<?php

namespace App\Http\Controllers\Pendaftar;

use App\Models\Kriteria;
use App\Models\NilaiTes;
use App\Models\Pengaturan;
use App\Models\Pendaftaran;
use App\Models\Perhitungan;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Services\SmartCalculationService;

class PengumumanController extends Controller
{
    protected $smartService;

    public function __construct(SmartCalculationService $smartService)
    {
        $this->smartService = $smartService;
    }

    public function index()
    {
        $user = Auth::user();

        // Ambil pendaftaran user
        $pendaftaran = Pendaftaran::where('pengguna_id', $user->pengguna_id)->first();

        if (!$pendaftaran) {
            return redirect()->route('pendaftar.dashboard')
                ->with('error', 'Anda belum melakukan pendaftaran!');
        }

        // Cek apakah pengumuman sudah dipublish
        $perhitungan = Perhitungan::where('pendaftaran_id', $pendaftaran->pendaftaran_id)
            ->where('is_published', true)
            ->first();

        if (!$perhitungan) {
            return view('pendaftar.pengumuman', [
                'pengumuman' => null,
                'pendaftaran' => $pendaftaran,
            ]);
        }

        // ✅ PERBAIKAN: Gunakan SmartCalculationService untuk mendapatkan detail perhitungan yang BENAR
        $detailPerhitungan = $this->smartService->getDetailPerhitungan($pendaftaran->pendaftaran_id);

        // Format data untuk view
        $nilaiDetails = [];
        foreach ($detailPerhitungan['details'] as $detail) {
            $nilaiDetails[] = [
                'kriteria' => $detail['kriteria'],
                'kode' => $detail['kode'],
                'nilai_asli' => $detail['nilai_asli'],
                'nilai_normalisasi' => $detail['nilai_normalisasi'],
                'bobot' => $detail['bobot'] * 100, // Konversi ke persen
                'nilai_terbobot' => $detail['nilai_terbobot'],
                'jenis' => $detail['jenis'],
            ];
        }

        return view('pendaftar.pengumuman', [
            'pengumuman' => $perhitungan,
            'pendaftaran' => $pendaftaran,
            'nilaiDetails' => $nilaiDetails,
        ]);
    }

    public function downloadSK($id)
    {
        try {
            $perhitungan = Perhitungan::with(['pendaftaran.pengguna.profil', 'pendaftaran.periode'])
                ->where('perhitungan_id', $id)
                ->where('is_published', true)
                ->firstOrFail();

            // Hanya yang diterima yang bisa download SK
            if ($perhitungan->status_kelulusan !== 'diterima') {
                return redirect()->back()->with('error', 'Surat Keputusan hanya tersedia untuk yang diterima!');
            }

            // Cek apakah user yang download adalah pemilik
            if ($perhitungan->pendaftaran->pengguna_id !== Auth::id()) {
                abort(403, 'Anda tidak memiliki akses ke surat keputusan ini.');
            }

            $pendaftaran = $perhitungan->pendaftaran;
            $pengaturan = Pengaturan::first();
            $pengumuman = $perhitungan;

            $pdf = Pdf::loadView('pendaftar.surat-keputusan', compact('perhitungan', 'pendaftaran', 'pengaturan', 'pengumuman'))
                ->setPaper('a4', 'portrait')
                ->setOption('enable-local-file-access', true)
                ->setOption('isHtml5ParserEnabled', true)
                ->setOption('isRemoteEnabled', true);

            return $pdf->download('surat-keputusan-' . $pendaftaran->no_pendaftaran . '.pdf');
        } catch (\Exception $e) {
            Log::error('Error generating Surat Keputusan: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat membuat surat keputusan: ' . $e->getMessage());
        }
    }
}
