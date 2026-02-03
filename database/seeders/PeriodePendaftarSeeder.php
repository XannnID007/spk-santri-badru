<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Pengguna;
use App\Models\Profil;
use App\Models\Periode;
use App\Models\Pendaftaran;
use App\Models\NilaiTes;
use App\Models\Perhitungan;
use App\Models\Kriteria;

class PeriodePendaftarSeeder extends Seeder
{
    public function run(): void
    {
        // ====================================================
        // PERIODE 1: SUDAH SELESAI (2024/2025)
        // ====================================================
        $periode1 = Periode::create([
            'nama_periode' => 'Pendaftaran Santri Baru 2024/2025',
            'tanggal_mulai' => '2024-05-01',
            'tanggal_selesai' => '2024-08-31',
            'kuota_santri' => 50,
            'status_aktif' => false,
            'created_at' => '2024-01-01 00:00:00' // Set manual agar nomor pendaftaran konsisten 2024
        ]);

        // Data Pendaftar Periode 1 (15 orang, sudah ada hasil seleksi)
        $pendaftar1 = [
            [
                'nama' => 'Ahmad Fauzi',
                'email' => 'ahmad.fauzi@gmail.com',
                'no_hp' => '081234567891',
                'nik' => '3201010101990001',
                'tempat_lahir' => 'Bandung',
                'tanggal_lahir' => '2009-05-15',
                'jenis_kelamin' => 'L',
                'alamat' => 'Jl. Merdeka No. 10',
                'provinsi' => 'Jawa Barat',
                'kota' => 'Bandung',
                'kecamatan' => 'Cicendo',
                'kelurahan' => 'Pasirkaliki',
                'kode_pos' => '40171',
                'nama_ayah' => 'Budi Santoso',
                'nama_ibu' => 'Siti Aminah',
                'pekerjaan_ayah' => 'Wiraswasta',
                'pekerjaan_ibu' => 'Ibu Rumah Tangga',
                'penghasilan_ortu' => 3000000,
                'asal_sekolah' => 'SMP Negeri 1 Bandung',
                'rata_nilai' => 85.50,
                'prestasi' => 'Juara 1 Lomba Tahfidz Tingkat Kota',
                'nilai_c1' => 90, // Akhlak
                'nilai_c2' => 85, // Wawancara
                'nilai_c4' => 88, // Baca Quran
            ],
            [
                'nama' => 'Muhammad Rizki',
                'email' => 'rizki.muhammad@gmail.com',
                'no_hp' => '081234567892',
                'nik' => '3201010202990002',
                'tempat_lahir' => 'Cimahi',
                'tanggal_lahir' => '2009-08-20',
                'jenis_kelamin' => 'L',
                'alamat' => 'Jl. Gatot Subroto No. 25',
                'provinsi' => 'Jawa Barat',
                'kota' => 'Cimahi',
                'kecamatan' => 'Cimahi Tengah',
                'kelurahan' => 'Cibabat',
                'kode_pos' => '40522',
                'nama_ayah' => 'Rahmat Hidayat',
                'nama_ibu' => 'Nurul Azizah',
                'pekerjaan_ayah' => 'PNS',
                'pekerjaan_ibu' => 'Guru',
                'penghasilan_ortu' => 6000000,
                'asal_sekolah' => 'SMP Negeri 2 Cimahi',
                'rata_nilai' => 88.00,
                'prestasi' => 'Juara 2 Olimpiade Matematika',
                'nilai_c1' => 85,
                'nilai_c2' => 90,
                'nilai_c4' => 82,
            ],
            [
                'nama' => 'Abdullah Aziz',
                'email' => 'abdullah.aziz@gmail.com',
                'no_hp' => '081234567893',
                'nik' => '3201010303990003',
                'tempat_lahir' => 'Bandung',
                'tanggal_lahir' => '2009-03-10',
                'jenis_kelamin' => 'L',
                'alamat' => 'Jl. Asia Afrika No. 15',
                'provinsi' => 'Jawa Barat',
                'kota' => 'Bandung',
                'kecamatan' => 'Sumur Bandung',
                'kelurahan' => 'Braga',
                'kode_pos' => '40111',
                'nama_ayah' => 'Hasan Basri',
                'nama_ibu' => 'Fatimah Zahra',
                'pekerjaan_ayah' => 'Pedagang',
                'pekerjaan_ibu' => 'Ibu Rumah Tangga',
                'penghasilan_ortu' => 4000000,
                'asal_sekolah' => 'SMP IT Al-Azhar',
                'rata_nilai' => 87.25,
                'prestasi' => 'Hafal Juz 30',
                'nilai_c1' => 92,
                'nilai_c2' => 88,
                'nilai_c4' => 95,
            ],
            [
                'nama' => 'Yusuf Ibrahim',
                'email' => 'yusuf.ibrahim@gmail.com',
                'no_hp' => '081234567894',
                'nik' => '3201010404990004',
                'tempat_lahir' => 'Cimahi',
                'tanggal_lahir' => '2009-11-05',
                'jenis_kelamin' => 'L',
                'alamat' => 'Jl. Amir Machmud No. 8',
                'provinsi' => 'Jawa Barat',
                'kota' => 'Cimahi',
                'kecamatan' => 'Cimahi Utara',
                'kelurahan' => 'Citeureup',
                'kode_pos' => '40512',
                'nama_ayah' => 'Ibrahim Mansyur',
                'nama_ibu' => 'Khadijah',
                'pekerjaan_ayah' => 'Buruh Harian',
                'pekerjaan_ibu' => 'Ibu Rumah Tangga',
                'penghasilan_ortu' => 2000000,
                'asal_sekolah' => 'SMP Negeri 3 Cimahi',
                'rata_nilai' => 82.00,
                'prestasi' => '-',
                'nilai_c1' => 88,
                'nilai_c2' => 80,
                'nilai_c4' => 85,
            ],
            [
                'nama' => 'Umar Faruq',
                'email' => 'umar.faruq@gmail.com',
                'no_hp' => '081234567895',
                'nik' => '3201010505990005',
                'tempat_lahir' => 'Bandung',
                'tanggal_lahir' => '2009-07-22',
                'jenis_kelamin' => 'L',
                'alamat' => 'Jl. Cihampelas No. 45',
                'provinsi' => 'Jawa Barat',
                'kota' => 'Bandung',
                'kecamatan' => 'Cidadap',
                'kelurahan' => 'Cipaganti',
                'kode_pos' => '40131',
                'nama_ayah' => 'Faruq Rahman',
                'nama_ibu' => 'Aisyah',
                'pekerjaan_ayah' => 'Karyawan Swasta',
                'pekerjaan_ibu' => 'Karyawan Swasta',
                'penghasilan_ortu' => 7000000,
                'asal_sekolah' => 'SMP Pasundan 1',
                'rata_nilai' => 86.75,
                'prestasi' => 'Juara 3 Lomba Pidato',
                'nilai_c1' => 83,
                'nilai_c2' => 85,
                'nilai_c4' => 80,
            ],
            [
                'nama' => 'Ali Hasan',
                'email' => 'ali.hasan@gmail.com',
                'no_hp' => '081234567896',
                'nik' => '3201010606990006',
                'tempat_lahir' => 'Cimahi',
                'tanggal_lahir' => '2009-02-18',
                'jenis_kelamin' => 'L',
                'alamat' => 'Jl. Raya Cibabat No. 12',
                'provinsi' => 'Jawa Barat',
                'kota' => 'Cimahi',
                'kecamatan' => 'Cimahi Selatan',
                'kelurahan' => 'Cibeureum',
                'kode_pos' => '40531',
                'nama_ayah' => 'Hasan Ali',
                'nama_ibu' => 'Maryam',
                'pekerjaan_ayah' => 'Petani',
                'pekerjaan_ibu' => 'Ibu Rumah Tangga',
                'penghasilan_ortu' => 2500000,
                'asal_sekolah' => 'SMP Negeri 4 Cimahi',
                'rata_nilai' => 80.50,
                'prestasi' => '-',
                'nilai_c1' => 80,
                'nilai_c2' => 78,
                'nilai_c4' => 83,
            ],
            [
                'nama' => 'Zaki Mubarak',
                'email' => 'zaki.mubarak@gmail.com',
                'no_hp' => '081234567897',
                'nik' => '3201010707990007',
                'tempat_lahir' => 'Bandung',
                'tanggal_lahir' => '2009-09-30',
                'jenis_kelamin' => 'L',
                'alamat' => 'Jl. Dago No. 78',
                'provinsi' => 'Jawa Barat',
                'kota' => 'Bandung',
                'kecamatan' => 'Coblong',
                'kelurahan' => 'Dago',
                'kode_pos' => '40135',
                'nama_ayah' => 'Mubarak Zaki',
                'nama_ibu' => 'Halimah',
                'pekerjaan_ayah' => 'Dokter',
                'pekerjaan_ibu' => 'Dokter',
                'penghasilan_ortu' => 15000000,
                'asal_sekolah' => 'SMP Al-Irsyad',
                'rata_nilai' => 90.00,
                'prestasi' => 'Juara 1 Lomba Sains Nasional',
                'nilai_c1' => 78,
                'nilai_c2' => 80,
                'nilai_c4' => 75,
            ],
            [
                'nama' => 'Hamzah Malik',
                'email' => 'hamzah.malik@gmail.com',
                'no_hp' => '081234567898',
                'nik' => '3201010808990008',
                'tempat_lahir' => 'Cimahi',
                'tanggal_lahir' => '2009-06-12',
                'jenis_kelamin' => 'L',
                'alamat' => 'Jl. Raya Baros No. 20',
                'provinsi' => 'Jawa Barat',
                'kota' => 'Cimahi',
                'kecamatan' => 'Cimahi Tengah',
                'kelurahan' => 'Baros',
                'kode_pos' => '40521',
                'nama_ayah' => 'Malik Ahmad',
                'nama_ibu' => 'Zahra',
                'pekerjaan_ayah' => 'Guru',
                'pekerjaan_ibu' => 'Guru',
                'penghasilan_ortu' => 8000000,
                'asal_sekolah' => 'SMP Islam Terpadu',
                'rata_nilai' => 84.25,
                'prestasi' => 'Juara 2 Lomba Kaligrafi',
                'nilai_c1' => 86,
                'nilai_c2' => 82,
                'nilai_c4' => 87,
            ],
            [
                'nama' => 'Ikhsan Ramadhan',
                'email' => 'ikhsan.ramadhan@gmail.com',
                'no_hp' => '081234567899',
                'nik' => '3201010909990009',
                'tempat_lahir' => 'Bandung',
                'tanggal_lahir' => '2009-04-25',
                'jenis_kelamin' => 'L',
                'alamat' => 'Jl. Buah Batu No. 50',
                'provinsi' => 'Jawa Barat',
                'kota' => 'Bandung',
                'kecamatan' => 'Bandung Kidul',
                'kelurahan' => 'Turangga',
                'kode_pos' => '40264',
                'nama_ayah' => 'Ramadhan Ikhsan',
                'nama_ibu' => 'Nur Janah',
                'pekerjaan_ayah' => 'Wiraswasta',
                'pekerjaan_ibu' => 'Wiraswasta',
                'penghasilan_ortu' => 5000000,
                'asal_sekolah' => 'SMP Negeri 5 Bandung',
                'rata_nilai' => 83.00,
                'prestasi' => '-',
                'nilai_c1' => 84,
                'nilai_c2' => 83,
                'nilai_c4' => 81,
            ],
            [
                'nama' => 'Khalid Mustofa',
                'email' => 'khalid.mustofa@gmail.com',
                'no_hp' => '081234567800',
                'nik' => '3201011010990010',
                'tempat_lahir' => 'Cimahi',
                'tanggal_lahir' => '2009-12-08',
                'jenis_kelamin' => 'L',
                'alamat' => 'Jl. Kolonel Masturi No. 5',
                'provinsi' => 'Jawa Barat',
                'kota' => 'Cimahi',
                'kecamatan' => 'Cimahi Utara',
                'kelurahan' => 'Pasirkaliki',
                'kode_pos' => '40513',
                'nama_ayah' => 'Mustofa Khalid',
                'nama_ibu' => 'Umi Salamah',
                'pekerjaan_ayah' => 'Tukang Bangunan',
                'pekerjaan_ibu' => 'Ibu Rumah Tangga',
                'penghasilan_ortu' => 1800000,
                'asal_sekolah' => 'SMP Negeri 6 Cimahi',
                'rata_nilai' => 79.00,
                'prestasi' => '-',
                'nilai_c1' => 82,
                'nilai_c2' => 79,
                'nilai_c4' => 80,
            ],
            [
                'nama' => 'Luqman Hakim',
                'email' => 'luqman.hakim@gmail.com',
                'no_hp' => '081234567801',
                'nik' => '3201011111990011',
                'tempat_lahir' => 'Bandung',
                'tanggal_lahir' => '2009-01-15',
                'jenis_kelamin' => 'L',
                'alamat' => 'Jl. Soekarno Hatta No. 100',
                'provinsi' => 'Jawa Barat',
                'kota' => 'Bandung',
                'kecamatan' => 'Batununggal',
                'kelurahan' => 'Mengger',
                'kode_pos' => '40267',
                'nama_ayah' => 'Hakim Luqman',
                'nama_ibu' => 'Aminah',
                'pekerjaan_ayah' => 'PNS',
                'pekerjaan_ibu' => 'PNS',
                'penghasilan_ortu' => 10000000,
                'asal_sekolah' => 'SMP Negeri 7 Bandung',
                'rata_nilai' => 85.00,
                'prestasi' => 'Juara 1 Lomba Adzan',
                'nilai_c1' => 89,
                'nilai_c2' => 86,
                'nilai_c4' => 92,
            ],
            [
                'nama' => 'Nabil Harun',
                'email' => 'nabil.harun@gmail.com',
                'no_hp' => '081234567802',
                'nik' => '3201011212990012',
                'tempat_lahir' => 'Cimahi',
                'tanggal_lahir' => '2009-10-03',
                'jenis_kelamin' => 'L',
                'alamat' => 'Jl. Encep Kartawiria No. 30',
                'provinsi' => 'Jawa Barat',
                'kota' => 'Cimahi',
                'kecamatan' => 'Cimahi Selatan',
                'kelurahan' => 'Utama',
                'kode_pos' => '40533',
                'nama_ayah' => 'Harun Rasyid',
                'nama_ibu' => 'Siti Nurjanah',
                'pekerjaan_ayah' => 'Sopir',
                'pekerjaan_ibu' => 'Ibu Rumah Tangga',
                'penghasilan_ortu' => 3500000,
                'asal_sekolah' => 'SMP Negeri 7 Cimahi',
                'rata_nilai' => 81.50,
                'prestasi' => '-',
                'nilai_c1' => 81,
                'nilai_c2' => 80,
                'nilai_c4' => 79,
            ],
            [
                'nama' => 'Qais Taufik',
                'email' => 'qais.taufik@gmail.com',
                'no_hp' => '081234567803',
                'nik' => '3201011313990013',
                'tempat_lahir' => 'Bandung',
                'tanggal_lahir' => '2009-05-28',
                'jenis_kelamin' => 'L',
                'alamat' => 'Jl. Setiabudhi No. 88',
                'provinsi' => 'Jawa Barat',
                'kota' => 'Bandung',
                'kecamatan' => 'Cidadap',
                'kelurahan' => 'Sukagalih',
                'kode_pos' => '40164',
                'nama_ayah' => 'Taufik Hidayat',
                'nama_ibu' => 'Dewi Sartika',
                'pekerjaan_ayah' => 'Pengacara',
                'pekerjaan_ibu' => 'Ibu Rumah Tangga',
                'penghasilan_ortu' => 12000000,
                'asal_sekolah' => 'SMP BPI',
                'rata_nilai' => 87.50,
                'prestasi' => 'Juara 2 Lomba Debat Bahasa Arab',
                'nilai_c1' => 85,
                'nilai_c2' => 87,
                'nilai_c4' => 84,
            ],
            [
                'nama' => 'Rafli Zidan',
                'email' => 'rafli.zidan@gmail.com',
                'no_hp' => '081234567804',
                'nik' => '3201011414990014',
                'tempat_lahir' => 'Cimahi',
                'tanggal_lahir' => '2009-08-17',
                'jenis_kelamin' => 'L',
                'alamat' => 'Jl. Kihapit Barat No. 18',
                'provinsi' => 'Jawa Barat',
                'kota' => 'Cimahi',
                'kecamatan' => 'Cimahi Tengah',
                'kelurahan' => 'Karang Mekar',
                'kode_pos' => '40524',
                'nama_ayah' => 'Zidan Rafli',
                'nama_ibu' => 'Laila',
                'pekerjaan_ayah' => 'Karyawan Swasta',
                'pekerjaan_ibu' => 'Guru',
                'penghasilan_ortu' => 6500000,
                'asal_sekolah' => 'SMP Negeri 8 Cimahi',
                'rata_nilai' => 82.75,
                'prestasi' => '-',
                'nilai_c1' => 79,
                'nilai_c2' => 81,
                'nilai_c4' => 78,
            ],
            [
                'nama' => 'Salman Alfarizi',
                'email' => 'salman.alfarizi@gmail.com',
                'no_hp' => '081234567805',
                'nik' => '3201011515990015',
                'tempat_lahir' => 'Bandung',
                'tanggal_lahir' => '2009-03-22',
                'jenis_kelamin' => 'L',
                'alamat' => 'Jl. Cipaganti No. 25',
                'provinsi' => 'Jawa Barat',
                'kota' => 'Bandung',
                'kecamatan' => 'Coblong',
                'kelurahan' => 'Cipaganti',
                'kode_pos' => '40131',
                'nama_ayah' => 'Alfarizi Salman',
                'nama_ibu' => 'Rina Wati',
                'pekerjaan_ayah' => 'Buruh Pabrik',
                'pekerjaan_ibu' => 'Ibu Rumah Tangga',
                'penghasilan_ortu' => 2800000,
                'asal_sekolah' => 'SMP Negeri 8 Bandung',
                'rata_nilai' => 78.50,
                'prestasi' => '-',
                'nilai_c1' => 77,
                'nilai_c2' => 75,
                'nilai_c4' => 76,
            ],
        ];

        $this->createPendaftarWithResults($pendaftar1, $periode1);

        // ====================================================
        // PERIODE 2: SEDANG BERJALAN (2025/2026)
        // ====================================================
        $periode2 = Periode::create([
            'nama_periode' => 'Pendaftaran Santri Baru 2025/2026',
            'tanggal_mulai' => '2025-05-01',
            'tanggal_selesai' => '2025-08-31',
            'kuota_santri' => 100,
            'status_aktif' => true,
            'created_at' => '2025-01-01 00:00:00' // Set manual agar nomor pendaftaran konsisten 2025
        ]);

        // Data Pendaftar Periode 2 (8 orang, belum ada hasil seleksi)
        $pendaftar2 = [
            [
                'nama' => 'Farhan Maulana',
                'email' => 'farhan.maulana@gmail.com',
                'no_hp' => '082134567891',
                'nik' => '3201012001100001',
                'tempat_lahir' => 'Bandung',
                'tanggal_lahir' => '2010-01-10',
                'jenis_kelamin' => 'L',
                'alamat' => 'Jl. Ahmad Yani No. 45',
                'provinsi' => 'Jawa Barat',
                'kota' => 'Bandung',
                'kecamatan' => 'Cicadas',
                'kelurahan' => 'Cijaura',
                'kode_pos' => '40287',
                'nama_ayah' => 'Maulana Farid',
                'nama_ibu' => 'Dewi Sartika',
                'pekerjaan_ayah' => 'Wiraswasta',
                'pekerjaan_ibu' => 'Ibu Rumah Tangga',
                'penghasilan_ortu' => 4500000,
                'asal_sekolah' => 'SMP Negeri 9 Bandung',
                'rata_nilai' => 84.00,
                'prestasi' => 'Juara 1 Lomba Tartil',
            ],
            [
                'nama' => 'Ghani Pratama',
                'email' => 'ghani.pratama@gmail.com',
                'no_hp' => '082134567892',
                'nik' => '3201012002100002',
                'tempat_lahir' => 'Cimahi',
                'tanggal_lahir' => '2010-02-14',
                'jenis_kelamin' => 'L',
                'alamat' => 'Jl. Raya Cibeureum No. 33',
                'provinsi' => 'Jawa Barat',
                'kota' => 'Cimahi',
                'kecamatan' => 'Cimahi Selatan',
                'kelurahan' => 'Cibeureum',
                'kode_pos' => '40532',
                'nama_ayah' => 'Pratama Wijaya',
                'nama_ibu' => 'Siti Aminah',
                'pekerjaan_ayah' => 'PNS',
                'pekerjaan_ibu' => 'Guru',
                'penghasilan_ortu' => 7500000,
                'asal_sekolah' => 'SMP Negeri 1 Cimahi',
                'rata_nilai' => 86.50,
                'prestasi' => 'Juara 2 Olimpiade IPA',
            ],
            [
                'nama' => 'Hilal Ramadhan',
                'email' => 'hilal.ramadhan@gmail.com',
                'no_hp' => '082134567893',
                'nik' => '3201012003100003',
                'tempat_lahir' => 'Bandung',
                'tanggal_lahir' => '2010-03-20',
                'jenis_kelamin' => 'L',
                'alamat' => 'Jl. Sukajadi No. 67',
                'provinsi' => 'Jawa Barat',
                'kota' => 'Bandung',
                'kecamatan' => 'Sukajadi',
                'kelurahan' => 'Sukawarna',
                'kode_pos' => '40164',
                'nama_ayah' => 'Ramadhan Hadi',
                'nama_ibu' => 'Nur Halimah',
                'pekerjaan_ayah' => 'Pengusaha',
                'pekerjaan_ibu' => 'Ibu Rumah Tangga',
                'penghasilan_ortu' => 9000000,
                'asal_sekolah' => 'SMP Muhammadiyah 1',
                'rata_nilai' => 88.00,
                'prestasi' => 'Hafal 5 Juz',
            ],
            [
                'nama' => 'Irfan Hakim',
                'email' => 'irfan.hakim@gmail.com',
                'no_hp' => '082134567894',
                'nik' => '3201012004100004',
                'tempat_lahir' => 'Cimahi',
                'tanggal_lahir' => '2010-04-05',
                'jenis_kelamin' => 'L',
                'alamat' => 'Jl. Siliwangi No. 12',
                'provinsi' => 'Jawa Barat',
                'kota' => 'Cimahi',
                'kecamatan' => 'Cimahi Utara',
                'kelurahan' => 'Cigugur Tengah',
                'kode_pos' => '40514',
                'nama_ayah' => 'Hakim Mubarak',
                'nama_ibu' => 'Aisyah',
                'pekerjaan_ayah' => 'Buruh',
                'pekerjaan_ibu' => 'Ibu Rumah Tangga',
                'penghasilan_ortu' => 2200000,
                'asal_sekolah' => 'SMP Negeri 2 Cimahi',
                'rata_nilai' => 80.00,
                'prestasi' => '-',
            ],
            [
                'nama' => 'Jabir Affan',
                'email' => 'jabir.affan@gmail.com',
                'no_hp' => '082134567895',
                'nik' => '3201012005100005',
                'tempat_lahir' => 'Bandung',
                'tanggal_lahir' => '2010-05-18',
                'jenis_kelamin' => 'L',
                'alamat' => 'Jl. Pasir Koja No. 78',
                'provinsi' => 'Jawa Barat',
                'kota' => 'Bandung',
                'kecamatan' => 'Bandung Kaler',
                'kelurahan' => 'Cihaurgeulis',
                'kode_pos' => '40122',
                'nama_ayah' => 'Affan Jabir',
                'nama_ibu' => 'Maryam',
                'pekerjaan_ayah' => 'Karyawan Swasta',
                'pekerjaan_ibu' => 'Karyawan Swasta',
                'penghasilan_ortu' => 5500000,
                'asal_sekolah' => 'SMP Negeri 10 Bandung',
                'rata_nilai' => 83.50,
                'prestasi' => 'Juara 3 Lomba Kaligrafi',
            ],
            [
                'nama' => 'Karim Malik',
                'email' => 'karim.malik@gmail.com',
                'no_hp' => '082134567896',
                'nik' => '3201012006100006',
                'tempat_lahir' => 'Cimahi',
                'tanggal_lahir' => '2010-06-25',
                'jenis_kelamin' => 'L',
                'alamat' => 'Jl. Raya Baros No. 90',
                'provinsi' => 'Jawa Barat',
                'kota' => 'Cimahi',
                'kecamatan' => 'Cimahi Tengah',
                'kelurahan' => 'Baros',
                'kode_pos' => '40521',
                'nama_ayah' => 'Malik Karim',
                'nama_ibu' => 'Fatimah',
                'pekerjaan_ayah' => 'Petani',
                'pekerjaan_ibu' => 'Ibu Rumah Tangga',
                'penghasilan_ortu' => 1900000,
                'asal_sekolah' => 'SMP Negeri 3 Cimahi',
                'rata_nilai' => 79.50,
                'prestasi' => '-',
            ],
            [
                'nama' => 'Lukman Syah',
                'email' => 'lukman.syah@gmail.com',
                'no_hp' => '082134567897',
                'nik' => '3201012007100007',
                'tempat_lahir' => 'Bandung',
                'tanggal_lahir' => '2010-07-30',
                'jenis_kelamin' => 'L',
                'alamat' => 'Jl. Cikutra No. 55',
                'provinsi' => 'Jawa Barat',
                'kota' => 'Bandung',
                'kecamatan' => 'Cibeunying Kidul',
                'kelurahan' => 'Cikutra',
                'kode_pos' => '40124',
                'nama_ayah' => 'Syahrial',
                'nama_ibu' => 'Nurjanah',
                'pekerjaan_ayah' => 'Guru',
                'pekerjaan_ibu' => 'Guru',
                'penghasilan_ortu' => 8500000,
                'asal_sekolah' => 'SMP Al-Ma\'soem',
                'rata_nilai' => 85.75,
                'prestasi' => 'Juara 1 Lomba Pidato Bahasa Arab',
            ],
            [
                'nama' => 'Mahdi Firdaus',
                'email' => 'mahdi.firdaus@gmail.com',
                'no_hp' => '082134567898',
                'nik' => '3201012008100008',
                'tempat_lahir' => 'Cimahi',
                'tanggal_lahir' => '2010-08-12',
                'jenis_kelamin' => 'L',
                'alamat' => 'Jl. Transyogi No. 22',
                'provinsi' => 'Jawa Barat',
                'kota' => 'Cimahi',
                'kecamatan' => 'Cimahi Utara',
                'kelurahan' => 'Pasirkaliki',
                'kode_pos' => '40513',
                'nama_ayah' => 'Firdaus Ahmad',
                'nama_ibu' => 'Khadijah',
                'pekerjaan_ayah' => 'Tukang',
                'pekerjaan_ibu' => 'Ibu Rumah Tangga',
                'penghasilan_ortu' => 3200000,
                'asal_sekolah' => 'SMP Negeri 4 Cimahi',
                'rata_nilai' => 81.00,
                'prestasi' => '-',
            ],
        ];

        $this->createPendaftarOnly($pendaftar2, $periode2);
    }

    /**
     * Helper untuk membuat pendaftar dengan hasil seleksi
     */
    private function createPendaftarWithResults($dataPendaftar, $periode)
    {
        $kriterias = Kriteria::all();
        $no = 1;

        foreach ($dataPendaftar as $data) {
            // Buat user
            $user = Pengguna::create([
                'nama' => $data['nama'],
                'email' => $data['email'],
                'no_hp' => $data['no_hp'],
                'password' => Hash::make('password123'),
                'role' => 'pendaftar',
            ]);

            // Buat profil
            Profil::create([
                'pengguna_id' => $user->pengguna_id,
                'nik' => $data['nik'],
                'nama_lengkap' => $data['nama'],
                'tempat_lahir' => $data['tempat_lahir'],
                'tanggal_lahir' => $data['tanggal_lahir'],
                'jenis_kelamin' => $data['jenis_kelamin'],
                'alamat_lengkap' => $data['alamat'],
                'provinsi' => $data['provinsi'],
                'kota' => $data['kota'],
                'kecamatan' => $data['kecamatan'],
                'kelurahan' => $data['kelurahan'],
                'kode_pos' => $data['kode_pos'],
                'nama_ayah' => $data['nama_ayah'],
                'nama_ibu' => $data['nama_ibu'],
                'pekerjaan_ayah' => $data['pekerjaan_ayah'],
                'pekerjaan_ibu' => $data['pekerjaan_ibu'],
                'penghasilan_ortu' => $data['penghasilan_ortu'],
                'is_lengkap' => true,
            ]);

            // Buat pendaftaran
            $pendaftaran = Pendaftaran::create([
                'no_pendaftaran' => 'PSB' . $periode->created_at->format('Y') . sprintf('%04d', $no++),
                'pengguna_id' => $user->pengguna_id,
                'periode_id' => $periode->periode_id,
                'asal_sekolah' => $data['asal_sekolah'],
                'rata_nilai' => $data['rata_nilai'],
                'prestasi' => $data['prestasi'],
                'status_verifikasi' => 'diterima',
                'status_pendaftaran' => 'submitted',
                'tanggal_submit' => now()->subDays(rand(30, 90)),
            ]);

            // Buat nilai tes untuk setiap kriteria (kecuali C3)
            foreach ($kriterias as $kriteria) {
                if ($kriteria->kode_kriteria !== 'C3') {
                    $nilaiKey = 'nilai_' . strtolower($kriteria->kode_kriteria);
                    NilaiTes::create([
                        'pendaftaran_id' => $pendaftaran->pendaftaran_id,
                        'kriteria_id' => $kriteria->kriteria_id,
                        'nilai' => $data[$nilaiKey],
                    ]);
                }
            }
        }

        // Hitung SMART dan tentukan kelulusan
        $this->calculateSmartAndDetermineResults($periode);
    }

    /**
     * Helper untuk membuat pendaftar tanpa hasil seleksi
     */
    private function createPendaftarOnly($dataPendaftar, $periode)
    {
        $no = 1;
        $tahun = substr($periode->nama_periode, -9, 4);

        foreach ($dataPendaftar as $data) {
            // Buat user
            $user = Pengguna::create([
                'nama' => $data['nama'],
                'email' => $data['email'],
                'no_hp' => $data['no_hp'],
                'password' => Hash::make('password123'),
                'role' => 'pendaftar',
            ]);

            // Buat profil
            Profil::create([
                'pengguna_id' => $user->pengguna_id,
                'nik' => $data['nik'],
                'nama_lengkap' => $data['nama'],
                'tempat_lahir' => $data['tempat_lahir'],
                'tanggal_lahir' => $data['tanggal_lahir'],
                'jenis_kelamin' => $data['jenis_kelamin'],
                'alamat_lengkap' => $data['alamat'],
                'provinsi' => $data['provinsi'],
                'kota' => $data['kota'],
                'kecamatan' => $data['kecamatan'],
                'kelurahan' => $data['kelurahan'],
                'kode_pos' => $data['kode_pos'],
                'nama_ayah' => $data['nama_ayah'],
                'nama_ibu' => $data['nama_ibu'],
                'pekerjaan_ayah' => $data['pekerjaan_ayah'],
                'pekerjaan_ibu' => $data['pekerjaan_ibu'],
                'penghasilan_ortu' => $data['penghasilan_ortu'],
                'is_lengkap' => true,
            ]);

            // Buat pendaftaran
            Pendaftaran::create([
                'no_pendaftaran' => 'PSB' . $tahun . sprintf('%04d', $no++),
                'pengguna_id' => $user->pengguna_id,
                'periode_id' => $periode->periode_id,
                'asal_sekolah' => $data['asal_sekolah'],
                'rata_nilai' => $data['rata_nilai'],
                'prestasi' => $data['prestasi'],
                'status_verifikasi' => 'diterima',
                'status_pendaftaran' => 'submitted',
                'tanggal_submit' => now()->subDays(rand(1, 15)),
            ]);
        }
    }

    /**
     * Helper untuk menghitung SMART dan menentukan hasil
     */
    private function calculateSmartAndDetermineResults($periode)
    {
        $pendaftarans = Pendaftaran::where('periode_id', $periode->periode_id)
            ->where('status_pendaftaran', 'submitted')
            ->where('status_verifikasi', 'diterima')
            ->get();

        $kriterias = Kriteria::where('status_aktif', true)->get();

        // Ambil semua nilai untuk normalisasi
        $allNilai = [];
        foreach ($kriterias as $kriteria) {
            if ($kriteria->kode_kriteria === 'C3') {
                $nilaiKriteria = [];
                foreach ($pendaftarans as $pendaftaran) {
                    $profil = Profil::where('pengguna_id', $pendaftaran->pengguna_id)->first();
                    if ($profil) {
                        $nilaiKriteria[] = $profil->penghasilan_ortu;
                    }
                }
            } else {
                $nilaiKriteria = NilaiTes::where('kriteria_id', $kriteria->kriteria_id)
                    ->whereIn('pendaftaran_id', $pendaftarans->pluck('pendaftaran_id'))
                    ->pluck('nilai')
                    ->toArray();
            }

            $allNilai[$kriteria->kriteria_id] = [
                'jenis' => $kriteria->jenis,
                'max' => !empty($nilaiKriteria) ? max($nilaiKriteria) : 100,
                'min' => !empty($nilaiKriteria) ? min($nilaiKriteria) : 0,
            ];
        }

        $results = [];

        // Hitung untuk setiap pendaftar
        foreach ($pendaftarans as $pendaftaran) {
            $nilaiAkhir = 0;

            foreach ($kriterias as $kriteria) {
                if ($kriteria->kode_kriteria === 'C3') {
                    $profil = Profil::where('pengguna_id', $pendaftaran->pengguna_id)->first();
                    $nilai = $profil ? $profil->penghasilan_ortu : 0;
                } else {
                    $nilaiTes = NilaiTes::where('pendaftaran_id', $pendaftaran->pendaftaran_id)
                        ->where('kriteria_id', $kriteria->kriteria_id)
                        ->first();
                    $nilai = $nilaiTes ? $nilaiTes->nilai : 0;
                }

                // Normalisasi nilai
                if ($kriteria->jenis === 'benefit') {
                    $nilaiNormalisasi = $allNilai[$kriteria->kriteria_id]['max'] > 0
                        ? $nilai / $allNilai[$kriteria->kriteria_id]['max']
                        : 0;
                } else {
                    $nilaiNormalisasi = $nilai > 0
                        ? $allNilai[$kriteria->kriteria_id]['min'] / $nilai
                        : 0;
                }

                $nilaiAkhir += $nilaiNormalisasi * $kriteria->bobot;
            }

            $results[] = [
                'pendaftaran_id' => $pendaftaran->pendaftaran_id,
                'nilai_akhir' => round($nilaiAkhir, 4),
            ];
        }

        // Urutkan berdasarkan nilai akhir
        usort($results, function ($a, $b) {
            return $b['nilai_akhir'] <=> $a['nilai_akhir'];
        });

        // Simpan hasil dengan ranking dan status kelulusan
        $kuota = $periode->kuota_santri;
        $batasCadangan = ceil($kuota * 1.2); // 20% lebih banyak untuk cadangan

        foreach ($results as $index => $result) {
            $ranking = $index + 1;

            if ($ranking <= $kuota) {
                $statusKelulusan = 'diterima';
            } elseif ($ranking <= $batasCadangan) {
                $statusKelulusan = 'cadangan';
            } else {
                $statusKelulusan = 'tidak_diterima';
            }

            Perhitungan::create([
                'pendaftaran_id' => $result['pendaftaran_id'],
                'nilai_akhir' => $result['nilai_akhir'],
                'ranking' => $ranking,
                'status_kelulusan' => $statusKelulusan,
                'is_published' => true, // Untuk periode lama sudah dipublish
            ]);
        }
    }
}
