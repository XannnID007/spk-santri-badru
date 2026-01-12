@extends('layouts.dashboard')

@section('title', 'Dashboard Pendaftar')

@section('content')
    <div class="container mx-auto px-6 py-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-white mb-2">
                <i class="fas fa-tachometer-alt mr-3"></i>Dashboard Pendaftar
            </h1>
            <p class="text-gray-400">Selamat datang, {{ Auth::user()->nama }}!</p>
        </div>

        <!-- Alert Periode -->
        @if ($periodeAktif)
            <div class="glass-orange rounded-xl p-6 mb-8">
                <div class="flex items-center">
                    <i class="fas fa-calendar-alt text-3xl text-orange-500 mr-4"></i>
                    <div>
                        <h3 class="text-xl font-semibold text-white mb-1">{{ $periodeAktif->nama_periode }}</h3>
                        <p class="text-gray-300">
                            Periode: {{ \Carbon\Carbon::parse($periodeAktif->tanggal_mulai)->format('d M Y') }} -
                            {{ \Carbon\Carbon::parse($periodeAktif->tanggal_selesai)->format('d M Y') }}
                        </p>
                    </div>
                </div>
            </div>
        @else
            <div class="glass-dark rounded-xl p-6 mb-8 border border-red-500/30">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-triangle text-3xl text-red-500 mr-4"></i>
                    <div>
                        <h3 class="text-xl font-semibold text-white mb-1">Tidak Ada Periode Aktif</h3>
                        <p class="text-gray-300">Saat ini belum ada periode pendaftaran yang dibuka.</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Progress Timeline -->
        <div class="glass-dark rounded-xl p-6 mb-8">
            <h3 class="text-xl font-semibold text-white mb-6">
                <i class="fas fa-tasks mr-2"></i>Progress Pendaftaran
            </h3>

            <div class="space-y-6">
                <!-- Step 1: Profil -->
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        @if ($statusProfil)
                            <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center">
                                <i class="fas fa-check text-white text-xl"></i>
                            </div>
                        @else
                            <div class="w-12 h-12 bg-gray-600 rounded-full flex items-center justify-center">
                                <span class="text-white font-bold">1</span>
                            </div>
                        @endif
                    </div>
                    <div class="ml-4 flex-1">
                        <h4 class="text-lg font-semibold text-white">Lengkapi Profil</h4>
                        <p class="text-gray-400 text-sm mb-2">Isi data pribadi dan data orang tua</p>
                        @if ($statusProfil)
                            <span class="inline-block px-3 py-1 bg-green-500/20 text-green-400 rounded-full text-sm">
                                <i class="fas fa-check-circle mr-1"></i>Selesai
                            </span>
                        @else
                            <a href="{{ route('pendaftar.profil') }}"
                                class="inline-block px-4 py-2 gradient-orange rounded-lg text-sm font-semibold hover:opacity-90 transition">
                                <i class="fas fa-edit mr-1"></i>Lengkapi Sekarang
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Connector Line -->
                <div class="ml-6 w-0.5 h-8 bg-gray-700"></div>

                <!-- Step 2: Pendaftaran -->
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        @if ($statusPendaftaran)
                            <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center">
                                <i class="fas fa-check text-white text-xl"></i>
                            </div>
                        @elseif($statusProfil)
                            <div class="w-12 h-12 bg-orange-500 rounded-full flex items-center justify-center">
                                <span class="text-white font-bold">2</span>
                            </div>
                        @else
                            <div class="w-12 h-12 bg-gray-600 rounded-full flex items-center justify-center">
                                <span class="text-white font-bold">2</span>
                            </div>
                        @endif
                    </div>
                    <div class="ml-4 flex-1">
                        <h4 class="text-lg font-semibold text-white">Submit Pendaftaran</h4>
                        <p class="text-gray-400 text-sm mb-2">Upload dokumen dan submit formulir pendaftaran</p>
                        @if ($statusPendaftaran)
                            <span class="inline-block px-3 py-1 bg-green-500/20 text-green-400 rounded-full text-sm">
                                <i class="fas fa-check-circle mr-1"></i>Selesai - No: {{ $pendaftaran->no_pendaftaran }}
                            </span>
                        @elseif($statusProfil && $periodeAktif)
                            <a href="{{ route('pendaftar.pendaftaran') }}"
                                class="inline-block px-4 py-2 gradient-orange rounded-lg text-sm font-semibold hover:opacity-90 transition">
                                <i class="fas fa-file-alt mr-1"></i>Daftar Sekarang
                            </a>
                        @else
                            <span class="inline-block px-3 py-1 bg-gray-600/20 text-gray-400 rounded-full text-sm">
                                <i class="fas fa-lock mr-1"></i>Lengkapi profil terlebih dahulu
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Connector Line -->
                <div class="ml-6 w-0.5 h-8 bg-gray-700"></div>

                <!-- Step 3: Ujian -->
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        @if ($statusPendaftaran)
                            <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center">
                                <i class="fas fa-file-pdf text-white text-xl"></i>
                            </div>
                        @else
                            <div class="w-12 h-12 bg-gray-600 rounded-full flex items-center justify-center">
                                <span class="text-white font-bold">3</span>
                            </div>
                        @endif
                    </div>
                    <div class="ml-4 flex-1">
                        <h4 class="text-lg font-semibold text-white">Cetak Kartu Ujian</h4>
                        <p class="text-gray-400 text-sm mb-2">Download dan cetak kartu untuk tes & wawancara</p>
                        @if ($statusPendaftaran)
                            <a href="{{ route('pendaftar.cetak-kartu', $pendaftaran->pendaftaran_id) }}" target="_blank"
                                class="inline-block px-4 py-2 bg-blue-500 hover:bg-blue-600 rounded-lg text-sm font-semibold transition">
                                <i class="fas fa-download mr-1"></i>Download Kartu
                            </a>
                        @else
                            <span class="inline-block px-3 py-1 bg-gray-600/20 text-gray-400 rounded-full text-sm">
                                <i class="fas fa-lock mr-1"></i>Submit pendaftaran terlebih dahulu
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Connector Line -->
                <div class="ml-6 w-0.5 h-8 bg-gray-700"></div>

                <!-- Step 4: Pengumuman -->
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        @if ($pengumuman)
                            <div class="w-12 h-12 bg-purple-500 rounded-full flex items-center justify-center">
                                <i class="fas fa-bullhorn text-white text-xl"></i>
                            </div>
                        @else
                            <div class="w-12 h-12 bg-gray-600 rounded-full flex items-center justify-center">
                                <span class="text-white font-bold">4</span>
                            </div>
                        @endif
                    </div>
                    <div class="ml-4 flex-1">
                        <h4 class="text-lg font-semibold text-white">Lihat Pengumuman</h4>
                        <p class="text-gray-400 text-sm mb-2">Cek hasil seleksi penerimaan santri baru</p>
                        @if ($pengumuman)
                            <a href="{{ route('pendaftar.pengumuman') }}"
                                class="inline-block px-4 py-2 bg-purple-500 hover:bg-purple-600 rounded-lg text-sm font-semibold transition">
                                <i class="fas fa-eye mr-1"></i>Lihat Hasil
                            </a>
                        @else
                            <span class="inline-block px-3 py-1 bg-gray-600/20 text-gray-400 rounded-full text-sm">
                                <i class="fas fa-clock mr-1"></i>Menunggu pengumuman
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Info Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="glass-orange p-6 rounded-xl">
                <div class="flex items-center mb-4">
                    <i class="fas fa-user-circle text-3xl text-orange-500 mr-3"></i>
                    <h3 class="text-lg font-semibold text-white">Status Profil</h3>
                </div>
                @if ($statusProfil)
                    <p class="text-green-400 font-semibold">
                        <i class="fas fa-check-circle mr-1"></i>Lengkap
                    </p>
                @else
                    <p class="text-yellow-400 font-semibold">
                        <i class="fas fa-exclamation-circle mr-1"></i>Belum Lengkap
                    </p>
                @endif
            </div>

            <div class="glass-orange p-6 rounded-xl">
                <div class="flex items-center mb-4">
                    <i class="fas fa-clipboard-check text-3xl text-orange-500 mr-3"></i>
                    <h3 class="text-lg font-semibold text-white">Status Pendaftaran</h3>
                </div>
                @if ($statusPendaftaran)
                    @if ($pendaftaran->status_verifikasi === 'pending')
                        <p class="text-yellow-400 font-semibold">
                            <i class="fas fa-clock mr-1"></i>Menunggu Verifikasi
                        </p>
                    @elseif($pendaftaran->status_verifikasi === 'diterima')
                        <p class="text-green-400 font-semibold">
                            <i class="fas fa-check-circle mr-1"></i>Diverifikasi
                        </p>
                    @else
                        <p class="text-red-400 font-semibold">
                            <i class="fas fa-times-circle mr-1"></i>Ditolak
                        </p>
                    @endif
                @else
                    <p class="text-gray-400 font-semibold">
                        <i class="fas fa-minus-circle mr-1"></i>Belum Daftar
                    </p>
                @endif
            </div>

            <div class="glass-orange p-6 rounded-xl">
                <div class="flex items-center mb-4">
                    <i class="fas fa-trophy text-3xl text-orange-500 mr-3"></i>
                    <h3 class="text-lg font-semibold text-white">Hasil Seleksi</h3>
                </div>
                @if ($pengumuman)
                    @if ($pengumuman->status_kelulusan === 'diterima')
                        <p class="text-green-400 font-semibold">
                            <i class="fas fa-check-circle mr-1"></i>DITERIMA
                        </p>
                    @elseif($pengumuman->status_kelulusan === 'cadangan')
                        <p class="text-yellow-400 font-semibold">
                            <i class="fas fa-exclamation-circle mr-1"></i>CADANGAN
                        </p>
                    @else
                        <p class="text-red-400 font-semibold">
                            <i class="fas fa-times-circle mr-1"></i>TIDAK DITERIMA
                        </p>
                    @endif
                @else
                    <p class="text-gray-400 font-semibold">
                        <i class="fas fa-clock mr-1"></i>Belum Ada
                    </p>
                @endif
            </div>
        </div>
    </div>
@endsection
