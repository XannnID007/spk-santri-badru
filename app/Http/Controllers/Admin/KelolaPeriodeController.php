<?php

namespace App\Http\Controllers\Admin;

use App\Models\Periode;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class KelolaPeriodeController extends Controller
{
    public function index()
    {
        $periodes = Periode::orderBy('periode_id', 'desc')->get();
        return view('admin.periode.index', compact('periodes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_periode' => 'required|max:100',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'kuota_santri' => 'required|integer|min:1',
        ]);

        Periode::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Periode berhasil ditambahkan!'
        ]);
    }

    public function update(Request $request, $id)
    {
        $periode = Periode::findOrFail($id);

        $validated = $request->validate([
            'nama_periode' => 'required|max:100',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'kuota_santri' => 'required|integer|min:1',
        ]);

        $periode->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Periode berhasil diperbarui!'
        ]);
    }

    public function toggleStatus($id)
    {
        $periode = Periode::findOrFail($id);

        if (!$periode->status_aktif) {
            // Nonaktifkan semua periode lain
            Periode::where('periode_id', '!=', $id)->update(['status_aktif' => false]);
        }

        $periode->update(['status_aktif' => !$periode->status_aktif]);

        return response()->json([
            'success' => true,
            'message' => 'Status periode berhasil diubah!'
        ]);
    }

    public function destroy($id)
    {
        $periode = Periode::findOrFail($id);

        // Cek apakah ada pendaftaran
        if ($periode->pendaftaran()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak dapat menghapus periode yang sudah memiliki pendaftar!'
            ], 400);
        }

        $periode->delete();

        return response()->json([
            'success' => true,
            'message' => 'Periode berhasil dihapus!'
        ]);
    }
}
