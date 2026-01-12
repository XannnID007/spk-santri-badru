<?php

namespace App\Services;

use App\Models\Pendaftaran;
use App\Models\Kriteria;
use App\Models\NilaiTes;
use App\Models\Perhitungan;
use App\Models\Profil;
use Illuminate\Support\Facades\DB;

class SmartCalculationService
{
     /**
      * Hitung nilai SMART untuk semua pendaftar
      */
     public function hitungSemuaPendaftar($periodeId)
     {
          DB::beginTransaction();

          try {
               // Ambil semua pendaftar yang sudah submit dan diverifikasi
               $pendaftarans = Pendaftaran::where('periode_id', $periodeId)
                    ->where('status_pendaftaran', 'submitted')
                    ->where('status_verifikasi', 'diterima')
                    ->get();

               // Ambil semua kriteria aktif
               $kriterias = Kriteria::where('status_aktif', true)->get();

               // Ambil semua nilai untuk normalisasi
               $allNilai = [];
               foreach ($kriterias as $kriteria) {
                    $nilaiKriteria = NilaiTes::where('kriteria_id', $kriteria->kriteria_id)
                         ->whereIn('pendaftaran_id', $pendaftarans->pluck('pendaftaran_id'))
                         ->pluck('nilai')
                         ->toArray();

                    // Untuk kriteria ekonomi (penghasilan), ambil dari profil
                    if ($kriteria->kode_kriteria === 'C3') {
                         $nilaiKriteria = [];
                         foreach ($pendaftarans as $pendaftaran) {
                              $profil = Profil::where('pengguna_id', $pendaftaran->pengguna_id)->first();
                              if ($profil) {
                                   $nilaiKriteria[] = $profil->penghasilan_ortu;
                              }
                         }
                    }

                    $allNilai[$kriteria->kriteria_id] = [
                         'jenis' => $kriteria->jenis,
                         'nilai' => $nilaiKriteria,
                         'max' => !empty($nilaiKriteria) ? max($nilaiKriteria) : 100,
                         'min' => !empty($nilaiKriteria) ? min($nilaiKriteria) : 0,
                    ];
               }

               $results = [];

               // Hitung untuk setiap pendaftar
               foreach ($pendaftarans as $pendaftaran) {
                    $nilaiAkhir = 0;

                    foreach ($kriterias as $kriteria) {
                         // Ambil nilai untuk kriteria ini
                         if ($kriteria->kode_kriteria === 'C3') {
                              // Untuk ekonomi, ambil dari profil
                              $profil = Profil::where('pengguna_id', $pendaftaran->pengguna_id)->first();
                              $nilai = $profil ? $profil->penghasilan_ortu : 0;
                         } else {
                              // Untuk kriteria lain, ambil dari nilai_tes
                              $nilaiTes = NilaiTes::where('pendaftaran_id', $pendaftaran->pendaftaran_id)
                                   ->where('kriteria_id', $kriteria->kriteria_id)
                                   ->first();
                              $nilai = $nilaiTes ? $nilaiTes->nilai : 0;
                         }

                         // Normalisasi nilai
                         $nilaiNormalisasi = $this->normalisasiNilai(
                              $nilai,
                              $allNilai[$kriteria->kriteria_id]['max'],
                              $allNilai[$kriteria->kriteria_id]['min'],
                              $kriteria->jenis
                         );

                         // Kalikan dengan bobot
                         $nilaiAkhir += $nilaiNormalisasi * $kriteria->bobot;
                    }

                    $results[] = [
                         'pendaftaran_id' => $pendaftaran->pendaftaran_id,
                         'nilai_akhir' => round($nilaiAkhir, 4),
                    ];
               }

               // Urutkan berdasarkan nilai akhir (DESC)
               usort($results, function ($a, $b) {
                    return $b['nilai_akhir'] <=> $a['nilai_akhir'];
               });

               // Simpan hasil perhitungan dengan ranking
               foreach ($results as $index => $result) {
                    Perhitungan::updateOrCreate(
                         ['pendaftaran_id' => $result['pendaftaran_id']],
                         [
                              'nilai_akhir' => $result['nilai_akhir'],
                              'ranking' => $index + 1,
                         ]
                    );
               }

               DB::commit();

               return [
                    'success' => true,
                    'message' => 'Perhitungan SMART berhasil!',
                    'total' => count($results),
               ];
          } catch (\Exception $e) {
               DB::rollBack();
               return [
                    'success' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
               ];
          }
     }

     /**
      * Normalisasi nilai berdasarkan jenis kriteria
      */
     private function normalisasiNilai($nilai, $max, $min, $jenis)
     {
          if ($jenis === 'benefit') {
               // Untuk benefit: semakin tinggi semakin baik
               return $max > 0 ? $nilai / $max : 0;
          } else {
               // Untuk cost: semakin rendah semakin baik
               return $nilai > 0 ? $min / $nilai : 0;
          }
     }

     /**
      * Tentukan kelulusan berdasarkan ranking atau passing grade
      */
     public function tentukanKelulusan($periodeId, $batasLulus, $batasCadangan, $metode = 'ranking')
     {
          DB::beginTransaction();

          try {
               $perhitungans = Perhitungan::whereHas('pendaftaran', function ($query) use ($periodeId) {
                    $query->where('periode_id', $periodeId);
               })->orderBy('ranking', 'asc')->get();

               foreach ($perhitungans as $perhitungan) {
                    if ($metode === 'ranking') {
                         // Berdasarkan ranking
                         if ($perhitungan->ranking <= $batasLulus) {
                              $status = 'diterima';
                         } elseif ($perhitungan->ranking <= $batasCadangan) {
                              $status = 'cadangan';
                         } else {
                              $status = 'tidak_diterima';
                         }
                    } else {
                         // Berdasarkan passing grade (nilai akhir)
                         $nilaiPersen = $perhitungan->nilai_akhir * 100;
                         if ($nilaiPersen >= $batasLulus) {
                              $status = 'diterima';
                         } elseif ($nilaiPersen >= $batasCadangan) {
                              $status = 'cadangan';
                         } else {
                              $status = 'tidak_diterima';
                         }
                    }

                    $perhitungan->update(['status_kelulusan' => $status]);
               }

               DB::commit();

               return [
                    'success' => true,
                    'message' => 'Status kelulusan berhasil ditentukan!',
               ];
          } catch (\Exception $e) {
               DB::rollBack();
               return [
                    'success' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
               ];
          }
     }

     /**
      * Publish pengumuman
      */
     public function publishPengumuman($periodeId)
     {
          DB::beginTransaction();

          try {
               $updated = Perhitungan::whereHas('pendaftaran', function ($query) use ($periodeId) {
                    $query->where('periode_id', $periodeId);
               })->update(['is_published' => true]);

               DB::commit();

               return [
                    'success' => true,
                    'message' => "Pengumuman berhasil dipublish! Total: {$updated} pendaftar.",
               ];
          } catch (\Exception $e) {
               DB::rollBack();
               return [
                    'success' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
               ];
          }
     }

     /**
      * Get detail perhitungan untuk satu pendaftar
      */
     public function getDetailPerhitungan($pendaftaranId)
     {
          $pendaftaran = Pendaftaran::with(['pengguna.profil', 'nilaiTes.kriteria', 'perhitungan'])
               ->findOrFail($pendaftaranId);

          $kriterias = Kriteria::where('status_aktif', true)->get();

          $details = [];
          foreach ($kriterias as $kriteria) {
               if ($kriteria->kode_kriteria === 'C3') {
                    $nilai = $pendaftaran->pengguna->profil->penghasilan_ortu ?? 0;
               } else {
                    $nilaiTes = $pendaftaran->nilaiTes->where('kriteria_id', $kriteria->kriteria_id)->first();
                    $nilai = $nilaiTes ? $nilaiTes->nilai : 0;
               }

               $details[] = [
                    'kriteria' => $kriteria->nama_kriteria,
                    'kode' => $kriteria->kode_kriteria,
                    'nilai' => $nilai,
                    'bobot' => $kriteria->bobot,
                    'jenis' => $kriteria->jenis,
               ];
          }

          return [
               'pendaftaran' => $pendaftaran,
               'details' => $details,
          ];
     }
}
