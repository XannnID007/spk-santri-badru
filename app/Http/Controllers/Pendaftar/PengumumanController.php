<?php

namespace App\Http\Controllers\Pendaftar;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use App\Models\Perhitungan;
use App\Models\Kriteria;
use App\Models\NilaiTes;
use App\Models\Pengaturan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class PengumumanController extends Controller
{
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

        // Ambil detail nilai per kriteria
        $kriterias = Kriteria::where('status_aktif', true)->get();
        $nilaiDetails = [];

        foreach ($kriterias as $kriteria) {
            if ($kriteria->kode_kriteria === 'C3') {
                // Untuk ekonomi, ambil dari profil
                $nilai = $pendaftaran->pengguna->profil->penghasilan_ortu ?? 0;
            } else {
                $nilaiTes = NilaiTes::where('pendaftaran_id', $pendaftaran->pendaftaran_id)
                    ->where('kriteria_id', $kriteria->kriteria_id)
                    ->first();
                $nilai = $nilaiTes ? $nilaiTes->nilai : 0;
            }

            $nilaiDetails[] = [
                'kriteria' => $kriteria->nama_kriteria,
                'nilai' => $nilai,
                'bobot' => $kriteria->bobot * 100,
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
            abort(403);
        }

        $pendaftaran = $perhitungan->pendaftaran;
        $pengaturan = Pengaturan::first();
        $pengumuman = $perhitungan;

        $pdf = Pdf::loadView('pendaftar.surat-keputusan', compact('perhitungan', 'pendaftaran', 'pengaturan', 'pengumuman'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('surat-keputusan-' . $pendaftaran->no_pendaftaran . '.pdf');
    }
}
