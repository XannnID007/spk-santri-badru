@extends('layouts.dashboard')

@section('title', 'Detail Pendaftar')

@section('content')
    <div class="container mx-auto px-6 py-8">
        <!-- Header -->
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-white mb-2">
                    <i class="fas fa-user-circle mr-3"></i>Detail Pendaftar
                </h1>
                <p class="text-gray-400">{{ $pendaftaran->no_pendaftaran }}</p>
            </div>
            <a href="{{ route('admin.pendaftar') }}"
                class="px-6 py-3 glass-orange rounded-lg hover:bg-orange-500/20 transition">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Sidebar Info -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Foto -->
                <div class="glass-dark rounded-xl p-6 text-center">
                    @if ($pendaftaran->pengguna->profil && $pendaftaran->pengguna->profil->foto)
                        <img src="{{ asset('storage/' . $pendaftaran->pengguna->profil->foto) }}" alt="Foto"
                            class="w-32 h-40 object-cover rounded-lg mx-auto mb-4">
                    @else
                        <div class="w-32 h-40 bg-gray-700 rounded-lg mx-auto mb-4 flex items-center justify-center">
                            <i class="fas fa-user text-5xl text-gray-500"></i>
                        </div>
                    @endif
                    <h3 class="text-xl font-bold text-white">
                        {{ $pendaftaran->pengguna->profil->nama_lengkap ?? $pendaftaran->pengguna->nama }}
                    </h3>
                    <p class="text-gray-400 text-sm">{{ $pendaftaran->no_pendaftaran }}</p>
                </div>

                <!-- Status -->
                <div class="glass-dark rounded-xl p-6">
                    <h3 class="text-lg font-semibold text-white mb-4">Status</h3>
                    <div class="space-y-3">
                        <div>
                            <p class="text-sm text-gray-400 mb-1">Verifikasi</p>
                            @if ($pendaftaran->status_verifikasi === 'pending')
                                <span class="px-3 py-1 bg-yellow-500/20 text-yellow-400 rounded-full text-sm">
                                    <i class="fas fa-clock mr-1"></i>Pending
                                </span>
                            @elseif($pendaftaran->status_verifikasi === 'diterima')
                                <span class="px-3 py-1 bg-green-500/20 text-green-400 rounded-full text-sm">
                                    <i class="fas fa-check-circle mr-1"></i>Diverifikasi
                                </span>
                            @else
                                <span class="px-3 py-1 bg-red-500/20 text-red-400 rounded-full text-sm">
                                    <i class="fas fa-times-circle mr-1"></i>Ditolak
                                </span>
                            @endif
                        </div>
                        <div>
                            <p class="text-sm text-gray-400 mb-1">Periode</p>
                            <p class="text-white">{{ $pendaftaran->periode->nama_periode }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-400 mb-1">Tanggal Submit</p>
                            <p class="text-white">{{ $pendaftaran->tanggal_submit->format('d F Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Data Pribadi -->
                <div class="glass-dark rounded-xl p-6">
                    <h3 class="text-xl font-semibold text-white mb-4 border-b border-gray-700 pb-2">
                        <i class="fas fa-user mr-2"></i>Data Pribadi
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-400">NIK</p>
                            <p class="text-white">{{ $pendaftaran->pengguna->profil->nik ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-400">Tempat, Tanggal Lahir</p>
                            <p class="text-white">
                                {{ $pendaftaran->pengguna->profil->tempat_lahir ?? '-' }},
                                {{ $pendaftaran->pengguna->profil ? $pendaftaran->pengguna->profil->tanggal_lahir->format('d M Y') : '-' }}
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-400">Jenis Kelamin</p>
                            <p class="text-white">
                                {{ $pendaftaran->pengguna->profil ? ($pendaftaran->pengguna->profil->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan') : '-' }}
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-400">No. HP</p>
                            <p class="text-white">{{ $pendaftaran->pengguna->no_hp }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <p class="text-sm text-gray-400">Alamat</p>
                            <p class="text-white">{{ $pendaftaran->pengguna->profil->alamat_lengkap ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Data Orang Tua -->
                <div class="glass-dark rounded-xl p-6">
                    <h3 class="text-xl font-semibold text-white mb-4 border-b border-gray-700 pb-2">
                        <i class="fas fa-users mr-2"></i>Data Orang Tua
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-400">Nama Ayah</p>
                            <p class="text-white">{{ $pendaftaran->pengguna->profil->nama_ayah ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-400">Pekerjaan Ayah</p>
                            <p class="text-white">{{ $pendaftaran->pengguna->profil->pekerjaan_ayah ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-400">Nama Ibu</p>
                            <p class="text-white">{{ $pendaftaran->pengguna->profil->nama_ibu ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-400">Pekerjaan Ibu</p>
                            <p class="text-white">{{ $pendaftaran->pengguna->profil->pekerjaan_ibu ?? '-' }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <p class="text-sm text-gray-400">Penghasilan Orang Tua</p>
                            <p class="text-white">Rp
                                {{ number_format($pendaftaran->pengguna->profil->penghasilan_ortu ?? 0, 0, ',', '.') }} /
                                bulan</p>
                        </div>
                    </div>
                </div>

                <!-- Data Pendidikan -->
                <div class="glass-dark rounded-xl p-6">
                    <h3 class="text-xl font-semibold text-white mb-4 border-b border-gray-700 pb-2">
                        <i class="fas fa-school mr-2"></i>Data Pendidikan
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-400">Asal Sekolah</p>
                            <p class="text-white">{{ $pendaftaran->asal_sekolah }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-400">Rata-rata Nilai</p>
                            <p class="text-white">{{ $pendaftaran->rata_nilai }}</p>
                        </div>
                        @if ($pendaftaran->prestasi)
                            <div class="md:col-span-2">
                                <p class="text-sm text-gray-400">Prestasi</p>
                                <p class="text-white">{{ $pendaftaran->prestasi }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Dokumen -->
                <div class="glass-dark rounded-xl p-6">
                    <h3 class="text-xl font-semibold text-white mb-4 border-b border-gray-700 pb-2">
                        <i class="fas fa-file-alt mr-2"></i>Dokumen Persyaratan
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @if ($pendaftaran->file_kk)
                            <div class="glass-orange p-4 rounded-lg">
                                <p class="text-sm text-gray-300 mb-2">Kartu Keluarga</p>
                                <a href="{{ asset('storage/' . $pendaftaran->file_kk) }}" target="_blank"
                                    class="text-orange-500 hover:text-orange-400 text-sm">
                                    <i class="fas fa-eye mr-1"></i>Lihat Dokumen
                                </a>
                            </div>
                        @endif
                        @if ($pendaftaran->file_akta)
                            <div class="glass-orange p-4 rounded-lg">
                                <p class="text-sm text-gray-300 mb-2">Akta Kelahiran</p>
                                <a href="{{ asset('storage/' . $pendaftaran->file_akta) }}" target="_blank"
                                    class="text-orange-500 hover:text-orange-400 text-sm">
                                    <i class="fas fa-eye mr-1"></i>Lihat Dokumen
                                </a>
                            </div>
                        @endif
                        @if ($pendaftaran->file_ijazah)
                            <div class="glass-orange p-4 rounded-lg">
                                <p class="text-sm text-gray-300 mb-2">Ijazah/SKL</p>
                                <a href="{{ asset('storage/' . $pendaftaran->file_ijazah) }}" target="_blank"
                                    class="text-orange-500 hover:text-orange-400 text-sm">
                                    <i class="fas fa-eye mr-1"></i>Lihat Dokumen
                                </a>
                            </div>
                        @endif
                        @if ($pendaftaran->file_foto)
                            <div class="glass-orange p-4 rounded-lg">
                                <p class="text-sm text-gray-300 mb-2">Pas Foto 3x4</p>
                                <a href="{{ asset('storage/' . $pendaftaran->file_foto) }}" target="_blank"
                                    class="text-orange-500 hover:text-orange-400 text-sm">
                                    <i class="fas fa-eye mr-1"></i>Lihat Dokumen
                                </a>
                            </div>
                        @endif
                        @if ($pendaftaran->file_sktm)
                            <div class="glass-orange p-4 rounded-lg">
                                <p class="text-sm text-gray-300 mb-2">SKTM</p>
                                <a href="{{ asset('storage/' . $pendaftaran->file_sktm) }}" target="_blank"
                                    class="text-orange-500 hover:text-orange-400 text-sm">
                                    <i class="fas fa-eye mr-1"></i>Lihat Dokumen
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
