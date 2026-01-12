<?php

namespace App\Http\Controllers\Pendaftar;

use App\Models\Profil;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfilController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $profil = Profil::where('pengguna_id', $user->pengguna_id)->first();

        return view('pendaftar.profil', compact('profil'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nik' => 'required|numeric|digits:16|unique:profil,nik',
            'nama_lengkap' => 'required|string|max:100',
            'tempat_lahir' => 'required|string|max:50',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat_lengkap' => 'required|string',
            'provinsi' => 'required|string|max:50',
            'kota' => 'required|string|max:50',
            'kecamatan' => 'required|string|max:50',
            'kelurahan' => 'required|string|max:50',
            'kode_pos' => 'required|numeric|digits:5',
            'nama_ayah' => 'required|string|max:100',
            'nama_ibu' => 'required|string|max:100',
            'pekerjaan_ayah' => 'required|string|max:50',
            'pekerjaan_ibu' => 'required|string|max:50',
            'penghasilan_ortu' => 'required|numeric|min:0',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:1024',
        ]);

        $user = Auth::user();
        $validated['pengguna_id'] = $user->pengguna_id;
        $validated['is_lengkap'] = true;

        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $filename = time() . '_' . $foto->getClientOriginalName();
            $path = $foto->storeAs('profil', $filename, 'public');
            $validated['foto'] = $path;
        }

        Profil::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Profil berhasil disimpan!'
        ]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $profil = Profil::where('pengguna_id', $user->pengguna_id)->firstOrFail();

        $validated = $request->validate([
            'nik' => 'required|numeric|digits:16|unique:profil,nik,' . $profil->profil_id . ',profil_id',
            'nama_lengkap' => 'required|string|max:100',
            'tempat_lahir' => 'required|string|max:50',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat_lengkap' => 'required|string',
            'provinsi' => 'required|string|max:50',
            'kota' => 'required|string|max:50',
            'kecamatan' => 'required|string|max:50',
            'kelurahan' => 'required|string|max:50',
            'kode_pos' => 'required|numeric|digits:5',
            'nama_ayah' => 'required|string|max:100',
            'nama_ibu' => 'required|string|max:100',
            'pekerjaan_ayah' => 'required|string|max:50',
            'pekerjaan_ibu' => 'required|string|max:50',
            'penghasilan_ortu' => 'required|numeric|min:0',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:1024',
        ]);

        if ($request->hasFile('foto')) {
            // Hapus foto lama
            if ($profil->foto) {
                Storage::disk('public')->delete($profil->foto);
            }

            $foto = $request->file('foto');
            $filename = time() . '_' . $foto->getClientOriginalName();
            $path = $foto->storeAs('profil', $filename, 'public');
            $validated['foto'] = $path;
        }

        $profil->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Profil berhasil diperbarui!'
        ]);
    }
}
