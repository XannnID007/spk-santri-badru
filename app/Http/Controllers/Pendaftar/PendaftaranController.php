<?php

namespace App\Http\Controllers\Pendaftar;

use App\Models\Profil;
use App\Models\Periode;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PendaftaranController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $profil = Profil::where('pengguna_id', $user->pengguna_id)->first();
        $pendaftaran = Pendaftaran::where('pengguna_id', $user->pengguna_id)->first();
        $periodeAktif = Periode::where('status_aktif', true)->first();

        // Cek apakah profil sudah lengkap
        if (!$profil || !$profil->is_lengkap) {
            return redirect()->route('pendaftar.profil')
                ->with('error', 'Harap lengkapi profil terlebih dahulu!');
        }

        return view('pendaftar.pendaftaran', compact('profil', 'pendaftaran', 'periodeAktif'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $periodeAktif = Periode::where('status_aktif', true)->firstOrFail();

        // Cek apakah sudah pernah daftar
        $existingPendaftaran = Pendaftaran::where('pengguna_id', $user->pengguna_id)
            ->where('periode_id', $periodeAktif->periode_id)
            ->first();

        if ($existingPendaftaran) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah melakukan pendaftaran untuk periode ini!'
            ], 400);
        }

        // Cek kuota
        $totalPendaftar = Pendaftaran::where('periode_id', $periodeAktif->periode_id)
            ->where('status_pendaftaran', 'submitted')
            ->count();

        if ($totalPendaftar >= $periodeAktif->kuota_santri) {
            return response()->json([
                'success' => false,
                'message' => 'Maaf, kuota pendaftaran sudah penuh!'
            ], 400);
        }

        $validated = $request->validate([
            'asal_sekolah' => 'required|string|max:100',
            'rata_nilai' => 'required|numeric|between:0,100',
            'prestasi' => 'nullable|string',
            'file_kk' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'file_akta' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'file_ijazah' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'file_foto' => 'required|file|mimes:jpg,jpeg,png|max:1024',
            'file_sktm' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        // Generate nomor pendaftaran
        $noPendaftaran = 'PSB' . date('Y') . sprintf('%04d', $totalPendaftar + 1);

        $validated['no_pendaftaran'] = $noPendaftaran;
        $validated['pengguna_id'] = $user->pengguna_id;
        $validated['periode_id'] = $periodeAktif->periode_id;
        $validated['status_pendaftaran'] = 'submitted';
        $validated['tanggal_submit'] = now();

        // Upload files
        foreach (['file_kk', 'file_akta', 'file_ijazah', 'file_foto', 'file_sktm'] as $fileField) {
            if ($request->hasFile($fileField)) {
                $file = $request->file($fileField);
                $filename = time() . '_' . $fileField . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('dokumen', $filename, 'public');
                $validated[$fileField] = $path;
            }
        }

        Pendaftaran::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Pendaftaran berhasil! Silakan cetak kartu ujian.',
            'no_pendaftaran' => $noPendaftaran
        ]);
    }

    public function cetakKartu($id)
    {
        $pendaftaran = Pendaftaran::with(['pengguna.profil', 'periode'])
            ->where('pendaftaran_id', $id)
            ->where('pengguna_id', Auth::id())
            ->firstOrFail();

        $pdf = Pdf::loadView('pendaftar.kartu-ujian', compact('pendaftaran'));
        return $pdf->download('kartu-ujian-' . $pendaftaran->no_pendaftaran . '.pdf');
    }
}
