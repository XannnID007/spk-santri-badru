<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengaturan;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KelolaPengaturanController extends Controller
{
    public function index()
    {
        $pengaturan = Pengaturan::first();

        // Mengambil semua banner untuk dikelola
        $banners = Banner::orderBy('urutan', 'asc')->get();

        if (!$pengaturan) {
            $pengaturan = Pengaturan::create([
                'nama_pesantren' => 'Yayasan Pondok Pesantren Al-Badru',
                'alamat' => 'Jl. Budi, Kelurahan Pasirkaliki, Kecamatan Cimahi Utara, Kota Cimahi',
                'telepon' => '0221234567',
                'email' => 'info@albadru.ac.id',
                'jumlah_santri' => 0,
                'jumlah_guru' => 0,
                'jumlah_alumni' => 0,
            ]);
        }

        return view('admin.pengaturan.index', compact('pengaturan', 'banners'));
    }

    public function update(Request $request)
    {
        $pengaturan = Pengaturan::first();

        $validated = $request->validate([
            'nama_pesantren' => 'required|max:150',
            'alamat' => 'required',
            'telepon' => 'required|max:15',
            'email' => 'required|email|max:100',
            'website' => 'nullable|max:100',
            'no_rekening' => 'nullable|max:30',
            'atas_nama' => 'nullable|max:100',
            'nama_bank' => 'nullable|max:50',
            'jumlah_santri' => 'required|integer|min:0',
            'jumlah_guru' => 'required|integer|min:0',
            'jumlah_alumni' => 'required|integer|min:0',
        ]);

        $pengaturan->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Pengaturan berhasil diperbarui!'
        ]);
    }

    public function uploadLogo(Request $request)
    {
        $request->validate([
            'logo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $pengaturan = Pengaturan::first();

        if ($pengaturan->logo && Storage::disk('public')->exists($pengaturan->logo)) {
            Storage::disk('public')->delete($pengaturan->logo);
        }

        $file = $request->file('logo');
        $filename = 'logo_' . time() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('pengaturan', $filename, 'public');

        $pengaturan->update(['logo' => $path]);

        return response()->json([
            'success' => true,
            'message' => 'Logo berhasil diupload!',
            'path' => asset('storage/' . $path)
        ]);
    }

    public function storeBanner(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|max:150',
            'tipe' => 'required|in:image,video',
            'file' => $request->tipe === 'image'
                ? 'required|image|mimes:jpg,jpeg,png|max:5120'
                : 'required|mimes:mp4,mov,avi|max:25600', // Video max 25MB
            'urutan' => 'required|integer',
        ]);

        $file = $request->file('file');
        $filename = 'banner_' . time() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('banners', $filename, 'public');

        Banner::create([
            'judul' => $validated['judul'],
            'tipe' => $validated['tipe'],
            'file' => $path,
            'urutan' => $validated['urutan'],
            'status_aktif' => true
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Banner berhasil ditambahkan!'
        ]);
    }

    public function destroyBanner($id)
    {
        $banner = Banner::findOrFail($id);

        if (Storage::disk('public')->exists($banner->file)) {
            Storage::disk('public')->delete($banner->file);
        }

        $banner->delete();

        return response()->json([
            'success' => true,
            'message' => 'Banner berhasil dihapus!'
        ]);
    }
}
