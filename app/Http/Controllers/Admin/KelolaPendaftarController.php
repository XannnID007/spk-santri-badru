<?php

namespace App\Http\Controllers\Admin;

use App\Models\Periode;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class KelolaPendaftarController extends Controller
{
    public function index(Request $request)
    {
        $periodeId = $request->get('periode_id');
        $search = $request->get('search');
        $status = $request->get('status');

        $query = Pendaftaran::with(['pengguna.profil', 'periode'])
            ->where('status_pendaftaran', 'submitted');

        if ($periodeId) {
            $query->where('periode_id', $periodeId);
        }

        if ($search) {
            $query->whereHas('pengguna', function ($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            })->orWhere('no_pendaftaran', 'like', '%' . $search . '%');
        }

        if ($status) {
            $query->where('status_verifikasi', $status);
        }

        $pendaftarans = $query->orderBy('tanggal_submit', 'desc')->paginate(20);
        $periodes = Periode::orderBy('periode_id', 'desc')->get();

        return view('admin.pendaftar.index', compact('pendaftarans', 'periodes'));
    }

    public function show($id)
    {
        $pendaftaran = Pendaftaran::with(['pengguna.profil', 'periode'])->findOrFail($id);
        return view('admin.pendaftar.show', compact('pendaftaran'));
    }

    public function verifikasi(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:diterima,ditolak',
        ]);

        $pendaftaran = Pendaftaran::findOrFail($id);
        $pendaftaran->update(['status_verifikasi' => $validated['status']]);

        return response()->json([
            'success' => true,
            'message' => 'Status verifikasi berhasil diubah!'
        ]);
    }

    public function destroy($id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);

        // Hapus file dokumen
        $files = ['file_kk', 'file_akta', 'file_ijazah', 'file_foto', 'file_sktm'];
        foreach ($files as $file) {
            if ($pendaftaran->$file) {
                Storage::disk('public')->delete($pendaftaran->$file);
            }
        }

        $pendaftaran->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data pendaftar berhasil dihapus!'
        ]);
    }
}
