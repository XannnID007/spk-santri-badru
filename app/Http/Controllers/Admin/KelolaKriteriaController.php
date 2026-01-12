<?php

namespace App\Http\Controllers\Admin;

use App\Models\Kriteria;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class KelolaKriteriaController extends Controller
{
    public function index()
    {
        $kriterias = Kriteria::orderBy('kode_kriteria', 'asc')->get();
        $totalBobot = $kriterias->sum('bobot');

        return view('admin.kriteria.index', compact('kriterias', 'totalBobot'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_kriteria' => 'required|unique:kriteria,kode_kriteria|max:5',
            'nama_kriteria' => 'required|max:100',
            'bobot' => 'required|numeric|between:0,1',
            'jenis' => 'required|in:benefit,cost',
        ]);

        // Cek total bobot
        $totalBobot = Kriteria::sum('bobot') + $validated['bobot'];
        if ($totalBobot > 1) {
            return response()->json([
                'success' => false,
                'message' => 'Total bobot melebihi 100%! Sisa bobot: ' . ((1 - Kriteria::sum('bobot')) * 100) . '%'
            ], 400);
        }

        Kriteria::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Kriteria berhasil ditambahkan!'
        ]);
    }

    public function update(Request $request, $id)
    {
        $kriteria = Kriteria::findOrFail($id);

        $validated = $request->validate([
            'kode_kriteria' => 'required|max:5|unique:kriteria,kode_kriteria,' . $id . ',kriteria_id',
            'nama_kriteria' => 'required|max:100',
            'bobot' => 'required|numeric|between:0,1',
            'jenis' => 'required|in:benefit,cost',
        ]);

        // Cek total bobot
        $totalBobot = Kriteria::where('kriteria_id', '!=', $id)->sum('bobot') + $validated['bobot'];
        if ($totalBobot > 1) {
            return response()->json([
                'success' => false,
                'message' => 'Total bobot melebihi 100%!'
            ], 400);
        }

        $kriteria->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Kriteria berhasil diperbarui!'
        ]);
    }

    public function destroy($id)
    {
        $kriteria = Kriteria::findOrFail($id);
        $kriteria->delete();

        return response()->json([
            'success' => true,
            'message' => 'Kriteria berhasil dihapus!'
        ]);
    }
}
