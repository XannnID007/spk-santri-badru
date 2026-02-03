<?php

namespace App\Services;

use App\Models\Pendaftaran;
use App\Models\Kriteria;
use App\Models\NilaiTes;
use App\Models\Perhitungan;
use App\Models\Profil;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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

               if ($pendaftarans->isEmpty()) {
                    return [
                         'success' => false,
                         'message' => 'Tidak ada pendaftar yang memenuhi syarat untuk dihitung.',
                    ];
               }

               // Ambil semua kriteria aktif
               $kriterias = Kriteria::where('status_aktif', true)->get();

               if ($kriterias->isEmpty()) {
                    return [
                         'success' => false,
                         'message' => 'Tidak ada kriteria aktif. Silakan aktifkan kriteria terlebih dahulu.',
                    ];
               }

               // Validasi total bobot harus = 1 (100%)
               $totalBobot = $kriterias->sum('bobot');
               if (abs($totalBobot - 1) > 0.001) {
                    return [
                         'success' => false,
                         'message' => "Total bobot kriteria harus 100% (saat ini: " . ($totalBobot * 100) . "%)",
                    ];
               }

               // Ambil semua nilai untuk normalisasi
               $allNilai = [];
               foreach ($kriterias as $kriteria) {
                    $nilaiKriteria = [];

                    // Untuk kriteria ekonomi (penghasilan), ambil dari profil
                    if ($kriteria->kode_kriteria === 'C3') {
                         foreach ($pendaftarans as $pendaftaran) {
                              $profil = Profil::where('pengguna_id', $pendaftaran->pengguna_id)->first();
                              if ($profil && $profil->penghasilan_ortu !== null) {
                                   $nilaiKriteria[] = floatval($profil->penghasilan_ortu);
                              }
                         }
                    } else {
                         // Untuk kriteria lain, ambil dari nilai_tes
                         $nilaiKriteria = NilaiTes::where('kriteria_id', $kriteria->kriteria_id)
                              ->whereIn('pendaftaran_id', $pendaftarans->pluck('pendaftaran_id'))
                              ->whereNotNull('nilai')
                              ->pluck('nilai')
                              ->map(fn($n) => floatval($n))
                              ->toArray();
                    }

                    // Validasi ada nilai untuk kriteria ini
                    if (empty($nilaiKriteria)) {
                         return [
                              'success' => false,
                              'message' => "Tidak ada nilai untuk kriteria: {$kriteria->nama_kriteria}. Pastikan semua pendaftar memiliki nilai.",
                         ];
                    }

                    $maxNilai = max($nilaiKriteria);
                    $minNilai = min($nilaiKriteria);

                    $allNilai[$kriteria->kriteria_id] = [
                         'jenis' => $kriteria->jenis,
                         'nilai' => $nilaiKriteria,
                         'max' => $maxNilai,
                         'min' => $minNilai,
                    ];
               }

               $results = [];

               // Hitung untuk setiap pendaftar
               foreach ($pendaftarans as $pendaftaran) {
                    $nilaiAkhir = 0;
                    $detailKriteria = [];
                    $isComplete = true;

                    foreach ($kriterias as $kriteria) {
                         // Ambil nilai untuk kriteria ini
                         if ($kriteria->kode_kriteria === 'C3') {
                              // Untuk ekonomi, ambil dari profil
                              $profil = Profil::where('pengguna_id', $pendaftaran->pengguna_id)->first();
                              $nilai = $profil && $profil->penghasilan_ortu !== null
                                   ? floatval($profil->penghasilan_ortu)
                                   : null;
                         } else {
                              // Untuk kriteria lain, ambil dari nilai_tes
                              $nilaiTes = NilaiTes::where('pendaftaran_id', $pendaftaran->pendaftaran_id)
                                   ->where('kriteria_id', $kriteria->kriteria_id)
                                   ->first();
                              $nilai = $nilaiTes && $nilaiTes->nilai !== null
                                   ? floatval($nilaiTes->nilai)
                                   : null;
                         }

                         // Jika ada nilai yang null, tandai sebagai tidak lengkap
                         if ($nilai === null) {
                              $isComplete = false;
                              Log::warning("Pendaftar {$pendaftaran->no_pendaftaran} tidak memiliki nilai untuk kriteria {$kriteria->nama_kriteria}");
                              continue;
                         }

                         // Normalisasi nilai
                         $nilaiNormalisasi = $this->normalisasiNilai(
                              $nilai,
                              $allNilai[$kriteria->kriteria_id]['max'],
                              $allNilai[$kriteria->kriteria_id]['min'],
                              $kriteria->jenis
                         );

                         // Kalikan dengan bobot
                         $nilaiTerbobot = $nilaiNormalisasi * $kriteria->bobot;
                         $nilaiAkhir += $nilaiTerbobot;

                         $detailKriteria[] = [
                              'kriteria' => $kriteria->nama_kriteria,
                              'nilai_asli' => $nilai,
                              'nilai_normalisasi' => round($nilaiNormalisasi, 4),
                              'bobot' => $kriteria->bobot,
                              'nilai_terbobot' => round($nilaiTerbobot, 4),
                         ];
                    }

                    // Hanya simpan jika data lengkap
                    if ($isComplete) {
                         $results[] = [
                              'pendaftaran_id' => $pendaftaran->pendaftaran_id,
                              'nilai_akhir' => round($nilaiAkhir, 4),
                              'detail' => $detailKriteria,
                         ];
                    }
               }

               if (empty($results)) {
                    return [
                         'success' => false,
                         'message' => 'Tidak ada pendaftar dengan data nilai lengkap. Pastikan semua nilai telah diinput.',
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
                    'details' => $results,
               ];
          } catch (\Exception $e) {
               DB::rollBack();
               Log::error('Error dalam perhitungan SMART: ' . $e->getMessage());
               Log::error($e->getTraceAsString());

               return [
                    'success' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
               ];
          }
     }

     /**
      * Normalisasi nilai berdasarkan jenis kriteria (DIPERBAIKI)
      */
     private function normalisasiNilai($nilai, $max, $min, $jenis)
     {
          // Konversi ke float untuk memastikan
          $nilai = floatval($nilai);
          $max = floatval($max);
          $min = floatval($min);

          // Jika semua nilai sama (max = min), return 1 (sempurna)
          if ($max == $min) {
               return 1.0;
          }

          if ($jenis === 'benefit') {
               // Untuk benefit: semakin tinggi semakin baik
               // Rumus: (nilai - min) / (max - min)
               return ($nilai - $min) / ($max - $min);
          } else {
               // Untuk cost: semakin rendah semakin baik
               // Rumus: (max - nilai) / (max - min)
               return ($max - $nilai) / ($max - $min);
          }
     }

     /**
      * Tentukan kelulusan berdasarkan ranking atau passing grade
      */
     public function tentukanKelulusan($periodeId, $batasLulus, $batasCadangan, $metode = 'ranking')
     {
          DB::beginTransaction();

          try {
               // Validasi input
               $batasLulus = floatval($batasLulus);
               $batasCadangan = floatval($batasCadangan);

               if ($batasLulus <= 0 || $batasCadangan <= 0) {
                    return [
                         'success' => false,
                         'message' => 'Batas lulus dan cadangan harus lebih dari 0',
                    ];
               }

               if ($metode === 'ranking') {
                    // Untuk ranking, cadangan harus lebih besar dari lulus
                    if ($batasCadangan <= $batasLulus) {
                         return [
                              'success' => false,
                              'message' => 'Batas ranking cadangan harus lebih besar dari batas lulus',
                         ];
                    }
               } else {
                    // Untuk passing grade, cadangan harus lebih kecil dari lulus
                    if ($batasCadangan >= $batasLulus) {
                         return [
                              'success' => false,
                              'message' => 'Batas nilai cadangan harus lebih kecil dari batas lulus',
                         ];
                    }
               }

               $perhitungans = Perhitungan::whereHas('pendaftaran', function ($query) use ($periodeId) {
                    $query->where('periode_id', $periodeId);
               })->orderBy('ranking', 'asc')->get();

               if ($perhitungans->isEmpty()) {
                    return [
                         'success' => false,
                         'message' => 'Belum ada hasil perhitungan. Silakan hitung SMART terlebih dahulu.',
                    ];
               }

               $statusCount = [
                    'diterima' => 0,
                    'cadangan' => 0,
                    'tidak_diterima' => 0,
               ];

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
                         // Berdasarkan passing grade (nilai akhir dalam persen)
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
                    $statusCount[$status]++;
               }

               DB::commit();

               return [
                    'success' => true,
                    'message' => 'Status kelulusan berhasil ditentukan!',
                    'summary' => $statusCount,
               ];
          } catch (\Exception $e) {
               DB::rollBack();
               Log::error('Error dalam menentukan kelulusan: ' . $e->getMessage());

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
               // Cek apakah semua perhitungan sudah memiliki status kelulusan
               $withoutStatus = Perhitungan::whereHas('pendaftaran', function ($query) use ($periodeId) {
                    $query->where('periode_id', $periodeId);
               })
                    ->whereNull('status_kelulusan')
                    ->count();

               if ($withoutStatus > 0) {
                    return [
                         'success' => false,
                         'message' => "Masih ada {$withoutStatus} pendaftar tanpa status kelulusan. Tentukan kelulusan terlebih dahulu.",
                    ];
               }

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
               Log::error('Error dalam publish pengumuman: ' . $e->getMessage());

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

          // Ambil data untuk normalisasi
          $allNilai = [];
          foreach ($kriterias as $kriteria) {
               if ($kriteria->kode_kriteria === 'C3') {
                    $nilai = Profil::whereHas('pengguna.pendaftaran', function ($q) use ($pendaftaran) {
                         $q->where('periode_id', $pendaftaran->periode_id);
                    })->pluck('penghasilan_ortu')->toArray();
               } else {
                    $nilai = NilaiTes::where('kriteria_id', $kriteria->kriteria_id)
                         ->whereHas('pendaftaran', function ($q) use ($pendaftaran) {
                              $q->where('periode_id', $pendaftaran->periode_id);
                         })
                         ->pluck('nilai')->toArray();
               }

               $allNilai[$kriteria->kriteria_id] = [
                    'max' => !empty($nilai) ? max($nilai) : 100,
                    'min' => !empty($nilai) ? min($nilai) : 0,
               ];
          }

          $details = [];
          foreach ($kriterias as $kriteria) {
               if ($kriteria->kode_kriteria === 'C3') {
                    $nilai = $pendaftaran->pengguna->profil->penghasilan_ortu ?? 0;
               } else {
                    $nilaiTes = $pendaftaran->nilaiTes->where('kriteria_id', $kriteria->kriteria_id)->first();
                    $nilai = $nilaiTes ? $nilaiTes->nilai : 0;
               }

               $nilaiNormalisasi = $this->normalisasiNilai(
                    $nilai,
                    $allNilai[$kriteria->kriteria_id]['max'],
                    $allNilai[$kriteria->kriteria_id]['min'],
                    $kriteria->jenis
               );

               $details[] = [
                    'kriteria' => $kriteria->nama_kriteria,
                    'kode' => $kriteria->kode_kriteria,
                    'nilai_asli' => $nilai,
                    'nilai_normalisasi' => round($nilaiNormalisasi, 4),
                    'bobot' => $kriteria->bobot,
                    'jenis' => $kriteria->jenis,
                    'nilai_terbobot' => round($nilaiNormalisasi * $kriteria->bobot, 4),
               ];
          }

          return [
               'pendaftaran' => $pendaftaran,
               'details' => $details,
          ];
     }
}
