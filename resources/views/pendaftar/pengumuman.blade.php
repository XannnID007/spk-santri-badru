@extends('layouts.dashboard')

@section('title', 'Pengumuman Hasil Seleksi')

@section('content')
    <div class="container mx-auto px-6 py-8">
        <div class="max-w-4xl mx-auto">
            @if (!$pengumuman)
                <!-- Belum Ada Pengumuman -->
                <div class="glass-dark rounded-xl p-12 text-center">
                    <i class="fas fa-clock text-6xl text-gray-500 mb-6"></i>
                    <h2 class="text-3xl font-bold text-white mb-4">Pengumuman Belum Tersedia</h2>
                    <p class="text-gray-400 mb-6">
                        Hasil seleksi penerimaan santri baru belum dipublikasikan. <br>
                        Silakan cek kembali secara berkala atau tunggu pemberitahuan lebih lanjut.
                    </p>
                    <a href="{{ route('pendaftar.dashboard') }}"
                        class="inline-block px-6 py-3 glass-orange rounded-lg hover:bg-orange-500/20 transition">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali ke Dashboard
                    </a>
                </div>
            @else
                <!-- Header Pengumuman -->
                <div class="glass-orange rounded-xl p-6 mb-6 text-center">
                    <i class="fas fa-bullhorn text-4xl text-orange-500 mb-4"></i>
                    <h2 class="text-3xl font-bold text-white mb-2">Pengumuman Hasil Seleksi</h2>
                    <p class="text-gray-300">{{ $pendaftaran->periode->nama_periode }}</p>
                </div>

                <!-- Status Kelulusan -->
                <div class="glass-dark rounded-xl p-8 mb-6">
                    <div class="text-center mb-6">
                        @if ($pengumuman->status_kelulusan === 'diterima')
                            <div class="w-24 h-24 bg-green-500 rounded-full mx-auto flex items-center justify-center mb-4">
                                <i class="fas fa-check text-white text-5xl"></i>
                            </div>
                            <h3 class="text-4xl font-bold text-green-400 mb-2">SELAMAT!</h3>
                            <p class="text-2xl text-white mb-4">Anda DITERIMA</p>
                        @elseif($pengumuman->status_kelulusan === 'cadangan')
                            <div class="w-24 h-24 bg-yellow-500 rounded-full mx-auto flex items-center justify-center mb-4">
                                <i class="fas fa-exclamation text-white text-5xl"></i>
                            </div>
                            <h3 class="text-4xl font-bold text-yellow-400 mb-2">CADANGAN</h3>
                            <p class="text-2xl text-white mb-4">Anda Masuk Daftar Cadangan</p>
                        @else
                            <div class="w-24 h-24 bg-red-500 rounded-full mx-auto flex items-center justify-center mb-4">
                                <i class="fas fa-times text-white text-5xl"></i>
                            </div>
                            <h3 class="text-4xl font-bold text-red-400 mb-2">BELUM BERHASIL</h3>
                            <p class="text-2xl text-white mb-4">Anda Belum Diterima</p>
                        @endif

                        <p class="text-gray-400">sebagai Santri Baru Pondok Pesantren Al-Badru</p>
                    </div>

                    <!-- Info Detail -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-8">
                        <div class="glass-orange p-4 rounded-lg text-center">
                            <i class="fas fa-id-card text-2xl text-orange-500 mb-2"></i>
                            <p class="text-sm text-gray-400">No. Pendaftaran</p>
                            <p class="text-lg font-bold text-white">{{ $pendaftaran->no_pendaftaran }}</p>
                        </div>
                        <div class="glass-orange p-4 rounded-lg text-center">
                            <i class="fas fa-chart-line text-2xl text-orange-500 mb-2"></i>
                            <p class="text-sm text-gray-400">Nilai Akhir</p>
                            <p class="text-lg font-bold text-white">{{ number_format($pengumuman->nilai_akhir * 100, 2) }}
                            </p>
                        </div>
                        <div class="glass-orange p-4 rounded-lg text-center">
                            <i class="fas fa-trophy text-2xl text-orange-500 mb-2"></i>
                            <p class="text-sm text-gray-400">Peringkat</p>
                            <p class="text-lg font-bold text-white">{{ $pengumuman->ranking }}</p>
                        </div>
                    </div>
                </div>

                <!-- Detail Nilai Per Kriteria -->
                <div class="glass-dark rounded-xl p-6 mb-6">
                    <h3 class="text-xl font-semibold text-white mb-4">
                        <i class="fas fa-list-alt mr-2"></i>Detail Nilai Per Kriteria
                    </h3>
                    <div class="space-y-3">
                        @foreach ($nilaiDetails as $detail)
                            <div class="flex justify-between items-center p-3 glass-orange rounded-lg">
                                <div>
                                    <p class="text-white font-semibold">{{ $detail['kriteria'] }}</p>
                                    <p class="text-xs text-gray-400">Bobot: {{ $detail['bobot'] }}%</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-2xl font-bold text-orange-500">
                                        @if (strpos($detail['kriteria'], 'Penghasilan') !== false)
                                            Rp {{ number_format($detail['nilai'], 0, ',', '.') }}
                                        @else
                                            {{ number_format($detail['nilai'], 2) }}
                                        @endif
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Catatan -->
                @if ($pengumuman->catatan)
                    <div class="glass-orange rounded-xl p-6 mb-6">
                        <h3 class="text-xl font-semibold text-white mb-3">
                            <i class="fas fa-sticky-note mr-2"></i>Catatan Panitia
                        </h3>
                        <p class="text-gray-200">{{ $pengumuman->catatan }}</p>
                    </div>
                @endif

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4">
                    @if ($pengumuman->status_kelulusan === 'diterima')
                        <a href="{{ route('pendaftar.download-sk', $pengumuman->perhitungan_id) }}"
                            class="flex-1 text-center px-6 py-4 bg-green-500 hover:bg-green-600 rounded-lg font-semibold transition">
                            <i class="fas fa-download mr-2"></i>Download Surat Keputusan
                        </a>
                    @endif

                    <a href="{{ route('pendaftar.dashboard') }}"
                        class="flex-1 text-center px-6 py-4 glass-orange hover:bg-orange-500/20 rounded-lg font-semibold transition">
                        <i class="fas fa-home mr-2"></i>Kembali ke Dashboard
                    </a>
                </div>

                <!-- Info Tambahan -->
                @if ($pengumuman->status_kelulusan === 'diterima')
                    <div class="mt-6 glass-dark rounded-xl p-6 border-l-4 border-green-500">
                        <h4 class="text-lg font-semibold text-white mb-3">
                            <i class="fas fa-info-circle mr-2"></i>Langkah Selanjutnya
                        </h4>
                        <ul class="space-y-2 text-gray-300">
                            <li><i class="fas fa-check-circle text-green-500 mr-2"></i>Download dan cetak Surat Keputusan
                            </li>
                            <li><i class="fas fa-check-circle text-green-500 mr-2"></i>Siapkan dokumen persyaratan asli</li>
                            <li><i class="fas fa-check-circle text-green-500 mr-2"></i>Hadir pada waktu daftar ulang yang
                                ditentukan</li>
                            <li><i class="fas fa-check-circle text-green-500 mr-2"></i>Hubungi panitia untuk informasi lebih
                                lanjut</li>
                        </ul>
                    </div>
                @elseif($pengumuman->status_kelulusan === 'cadangan')
                    <div class="mt-6 glass-dark rounded-xl p-6 border-l-4 border-yellow-500">
                        <h4 class="text-lg font-semibold text-white mb-3">
                            <i class="fas fa-info-circle mr-2"></i>Informasi
                        </h4>
                        <p class="text-gray-300">
                            Anda masuk dalam daftar cadangan. Jika ada calon santri yang mengundurkan diri,
                            Anda berkesempatan untuk dipanggil. Mohon tunggu pemberitahuan lebih lanjut dari panitia.
                        </p>
                    </div>
                @else
                    <div class="mt-6 glass-dark rounded-xl p-6 border-l-4 border-red-500">
                        <h4 class="text-lg font-semibold text-white mb-3">
                            <i class="fas fa-info-circle mr-2"></i>Informasi
                        </h4>
                        <p class="text-gray-300">
                            Terima kasih atas partisipasi Anda dalam proses seleksi penerimaan santri baru.
                            Tetap semangat dan jangan menyerah! Silakan mencoba lagi pada periode berikutnya.
                        </p>
                    </div>
                @endif
            @endif
        </div>
    </div>
@endsection
