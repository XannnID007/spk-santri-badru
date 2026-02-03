<?php

namespace App\Http\Controllers\Admin;

use App\Models\Profil;
use App\Models\Periode;
use App\Models\Kriteria;
use App\Models\NilaiTes;
use App\Models\Pendaftaran;
use App\Models\Perhitungan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Services\SmartCalculationService;

class KelolaPerhitunganController extends Controller
{
    protected $smartService;

    public function __construct(SmartCalculationService $smartService)
    {
        $this->smartService = $smartService;
    }

    public function index()
    {
        $periodes = Periode::orderBy('periode_id', 'desc')->get();
        $periodeAktif = Periode::where('status_aktif', true)->first();

        return view('admin.perhitungan.index', compact('periodes', 'periodeAktif'));
    }

    public function inputNilai(Request $request)
    {
        $periodeId = $request->get('periode_id');

        if (!$periodeId) {
            return redirect()->route('admin.perhitungan')
                ->with('error', 'Silakan pilih periode terlebih dahulu.');
        }

        $periode = Periode::findOrFail($periodeId);

        // Ambil pendaftar yang sudah submit dan diverifikasi
        $pendaftarans = Pendaftaran::with(['pengguna.profil', 'nilaiTes.kriteria'])
            ->where('periode_id', $periodeId)
            ->where('status_pendaftaran', 'submitted')
            ->where('status_verifikasi', 'diterima')
            ->get();

        $kriterias = Kriteria::where('status_aktif', true)->get();

        // Validasi bobot kriteria
        $totalBobot = $kriterias->sum('bobot');
        if (abs($totalBobot - 1) > 0.001) {
            return redirect()->route('admin.kriteria')
                ->with('error', 'Total bobot kriteria harus 100%. Saat ini: ' . ($totalBobot * 100) . '%');
        }

        return view('admin.perhitungan.input-nilai', compact('pendaftarans', 'kriterias', 'periode'));
    }

    public function simpanNilai(Request $request)
    {
        $validated = $request->validate([
            'pendaftaran_id' => 'required|exists:pendaftaran,pendaftaran_id',
            'nilai' => 'required|array',
            'nilai.*' => 'required|numeric|min:0|max:100',
        ], [
            'nilai.*.required' => 'Semua nilai harus diisi',
            'nilai.*.numeric' => 'Nilai harus berupa angka',
            'nilai.*.min' => 'Nilai minimal 0',
            'nilai.*.max' => 'Nilai maksimal 100',
        ]);

        try {
            $savedCount = 0;

            foreach ($validated['nilai'] as $kriteriaId => $nilai) {
                // Skip kriteria C3 (Ekonomi) karena diambil dari profil
                $kriteria = Kriteria::find($kriteriaId);
                if ($kriteria && $kriteria->kode_kriteria === 'C3') {
                    continue;
                }

                // Validasi kriteria aktif
                if (!$kriteria || !$kriteria->status_aktif) {
                    continue;
                }

                NilaiTes::updateOrCreate(
                    [
                        'pendaftaran_id' => $validated['pendaftaran_id'],
                        'kriteria_id' => $kriteriaId,
                    ],
                    [
                        'nilai' => floatval($nilai),
                    ]
                );

                $savedCount++;
            }

            return response()->json([
                'success' => true,
                'message' => "Berhasil menyimpan {$savedCount} nilai kriteria!"
            ]);
        } catch (\Exception $e) {
            Log::error('Error simpan nilai: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function hitungSmart(Request $request)
    {
        $periodeId = $request->get('periode_id');

        if (!$periodeId) {
            return response()->json([
                'success' => false,
                'message' => 'Periode tidak ditemukan!'
            ], 400);
        }

        // Validasi periode exists
        $periode = Periode::find($periodeId);
        if (!$periode) {
            return response()->json([
                'success' => false,
                'message' => 'Periode tidak valid!'
            ], 404);
        }

        // Jalankan perhitungan
        $result = $this->smartService->hitungSemuaPendaftar($periodeId);

        return response()->json($result);
    }

    public function hasilPerhitungan(Request $request)
    {
        $periodeId = $request->get('periode_id');

        if (!$periodeId) {
            return redirect()->route('admin.perhitungan')
                ->with('error', 'Silakan pilih periode terlebih dahulu.');
        }

        $periode = Periode::findOrFail($periodeId);

        // Ambil hasil perhitungan
        $hasil = Perhitungan::whereHas('pendaftaran', function ($query) use ($periodeId) {
            $query->where('periode_id', $periodeId);
        })
            ->with(['pendaftaran.pengguna.profil'])
            ->orderBy('ranking', 'asc')
            ->get();

        $kriterias = Kriteria::where('status_aktif', true)->get();

        return view('admin.perhitungan.hasil', compact('hasil', 'periode', 'kriterias'));
    }

    public function tentukanKelulusan(Request $request)
    {
        $validated = $request->validate([
            'periode_id' => 'required|exists:periode,periode_id',
            'metode' => 'required|in:ranking,passing_grade',
            'batas_lulus' => 'required|numeric|min:0',
            'batas_cadangan' => 'required|numeric|min:0',
        ], [
            'batas_lulus.required' => 'Batas lulus harus diisi',
            'batas_lulus.numeric' => 'Batas lulus harus berupa angka',
            'batas_cadangan.required' => 'Batas cadangan harus diisi',
            'batas_cadangan.numeric' => 'Batas cadangan harus berupa angka',
        ]);

        $result = $this->smartService->tentukanKelulusan(
            $validated['periode_id'],
            $validated['batas_lulus'],
            $validated['batas_cadangan'],
            $validated['metode']
        );

        return response()->json($result);
    }

    public function publishPengumuman(Request $request)
    {
        $periodeId = $request->get('periode_id');

        if (!$periodeId) {
            return response()->json([
                'success' => false,
                'message' => 'Periode tidak ditemukan!'
            ], 400);
        }

        // Cek apakah sudah ada status kelulusan
        $countWithoutStatus = Perhitungan::whereHas('pendaftaran', function ($query) use ($periodeId) {
            $query->where('periode_id', $periodeId);
        })
            ->whereNull('status_kelulusan')
            ->count();

        if ($countWithoutStatus > 0) {
            return response()->json([
                'success' => false,
                'message' => "Masih ada {$countWithoutStatus} pendaftar tanpa status kelulusan. Harap tentukan kelulusan terlebih dahulu!"
            ], 400);
        }

        $result = $this->smartService->publishPengumuman($periodeId);

        return response()->json($result);
    }
}
