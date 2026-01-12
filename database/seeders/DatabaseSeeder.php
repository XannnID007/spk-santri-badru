<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Pengguna;
use App\Models\Kriteria;
use App\Models\Pengaturan;
use App\Models\Persyaratan;
use App\Models\Periode;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Seeder Admin
        Pengguna::create([
            'nama' => 'Administrator',
            'email' => 'admin@albadru.ac.id',
            'no_hp' => '081234567890',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        // Seeder Kriteria SMART
        $kriterias = [
            [
                'kode_kriteria' => 'C1',
                'nama_kriteria' => 'Tes Akhlak & Kepribadian',
                'bobot' => 0.35,
                'jenis' => 'benefit',
                'status_aktif' => true,
            ],
            [
                'kode_kriteria' => 'C2',
                'nama_kriteria' => 'Wawancara Motivasi',
                'bobot' => 0.25,
                'jenis' => 'benefit',
                'status_aktif' => true,
            ],
            [
                'kode_kriteria' => 'C3',
                'nama_kriteria' => 'Penghasilan Orang Tua',
                'bobot' => 0.25,
                'jenis' => 'cost',
                'status_aktif' => true,
            ],
            [
                'kode_kriteria' => 'C4',
                'nama_kriteria' => 'Tes Baca Al-Quran',
                'bobot' => 0.15,
                'jenis' => 'benefit',
                'status_aktif' => true,
            ],
        ];

        foreach ($kriterias as $kriteria) {
            Kriteria::create($kriteria);
        }

        // Seeder Pengaturan
        Pengaturan::create([
            'nama_pesantren' => 'Yayasan Pondok Pesantren Al-Badru',
            'alamat' => 'Jl. Budi, Kelurahan Pasirkaliki, Kecamatan Cimahi Utara, Kota Cimahi, RT 02 / RW 04, Jawa Barat',
            'telepon' => '0221234567',
            'email' => 'info@albadru.ac.id',
            'website' => 'www.albadru.ac.id',
            'jumlah_santri' => 450,
            'jumlah_guru' => 35,
            'jumlah_alumni' => 1200,
        ]);

        // Seeder Persyaratan
        $persyaratans = [
            [
                'nama_dokumen' => 'Kartu Keluarga',
                'deskripsi' => 'Scan Kartu Keluarga (KK) yang masih berlaku',
                'wajib' => true,
                'format_file' => 'pdf,jpg,jpeg,png',
                'max_size' => 2048,
                'status_aktif' => true,
            ],
            [
                'nama_dokumen' => 'Akta Kelahiran',
                'deskripsi' => 'Scan Akta Kelahiran',
                'wajib' => true,
                'format_file' => 'pdf,jpg,jpeg,png',
                'max_size' => 2048,
                'status_aktif' => true,
            ],
            [
                'nama_dokumen' => 'Ijazah/Surat Keterangan Lulus',
                'deskripsi' => 'Scan Ijazah atau Surat Keterangan Lulus',
                'wajib' => true,
                'format_file' => 'pdf,jpg,jpeg,png',
                'max_size' => 2048,
                'status_aktif' => true,
            ],
            [
                'nama_dokumen' => 'Pas Foto 3x4',
                'deskripsi' => 'Pas foto terbaru ukuran 3x4 berlatar belakang merah',
                'wajib' => true,
                'format_file' => 'jpg,jpeg,png',
                'max_size' => 1024,
                'status_aktif' => true,
            ],
            [
                'nama_dokumen' => 'Surat Keterangan Tidak Mampu (SKTM)',
                'deskripsi' => 'Surat Keterangan Tidak Mampu dari Kelurahan (Opsional)',
                'wajib' => false,
                'format_file' => 'pdf,jpg,jpeg,png',
                'max_size' => 2048,
                'status_aktif' => true,
            ],
        ];

        foreach ($persyaratans as $persyaratan) {
            Persyaratan::create($persyaratan);
        }

        // Seeder Periode Aktif
        Periode::create([
            'nama_periode' => 'Pendaftaran Santri Baru 2025/2026',
            'tanggal_mulai' => '2025-05-01',
            'tanggal_selesai' => '2025-08-31',
            'kuota_santri' => 100,
            'status_aktif' => true,
        ]);
    }
}
