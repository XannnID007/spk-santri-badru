@extends('layouts.dashboard')

@section('title', 'Dashboard Admin')

@section('content')
    <div class="container mx-auto px-6 py-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-white mb-2">
                <i class="fas fa-tachometer-alt mr-3"></i>Dashboard Administrator
            </h1>
            <p class="text-gray-400">Selamat datang, {{ Auth::user()->nama }}!</p>
        </div>

        <!-- Periode Aktif Info -->
        @if ($periodeAktif)
            <div class="glass-orange rounded-xl p-6 mb-8">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <i class="fas fa-calendar-alt text-4xl text-orange-500 mr-4"></i>
                        <div>
                            <h3 class="text-xl font-semibold text-white mb-1">{{ $periodeAktif->nama_periode }}</h3>
                            <p class="text-gray-300">
                                {{ \Carbon\Carbon::parse($periodeAktif->tanggal_mulai)->format('d M Y') }} -
                                {{ \Carbon\Carbon::parse($periodeAktif->tanggal_selesai)->format('d M Y') }}
                            </p>
                            <p class="text-sm text-gray-400 mt-1">Kuota: {{ $periodeAktif->kuota_santri }} santri</p>
                        </div>
                    </div>
                    <span class="bg-green-500 text-white px-4 py-2 rounded-full font-semibold">
                        <i class="fas fa-circle text-xs mr-1"></i>Aktif
                    </span>
                </div>
            </div>
        @else
            <div class="glass-dark rounded-xl p-6 mb-8 border border-red-500/30">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-triangle text-4xl text-red-500 mr-4"></i>
                    <div>
                        <h3 class="text-xl font-semibold text-white mb-1">Tidak Ada Periode Aktif</h3>
                        <p class="text-gray-300">Silakan aktifkan periode pendaftaran terlebih dahulu.</p>
                    </div>
                    <a href="{{ route('admin.periode.index') }}"
                        class="ml-auto px-6 py-3 gradient-orange rounded-lg font-semibold hover:opacity-90 transition">
                        <i class="fas fa-cog mr-2"></i>Kelola Periode
                    </a>
                </div>
            </div>
        @endif

        <!-- Statistik Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Pendaftar -->
            <div class="glass-dark rounded-xl p-6 hover:scale-105 transition transform">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-blue-500/20 rounded-lg flex items-center justify-center">
                        <i class="fas fa-users text-2xl text-blue-400"></i>
                    </div>
                    <span class="text-sm text-gray-400">Total</span>
                </div>
                <h3 class="text-3xl font-bold text-white mb-1">{{ $totalPendaftar }}</h3>
                <p class="text-gray-400 text-sm">Pendaftar</p>
            </div>

            <!-- Diterima -->
            <div class="glass-dark rounded-xl p-6 hover:scale-105 transition transform">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-green-500/20 rounded-lg flex items-center justify-center">
                        <i class="fas fa-check-circle text-2xl text-green-400"></i>
                    </div>
                    <span class="text-sm text-gray-400">Diterima</span>
                </div>
                <h3 class="text-3xl font-bold text-white mb-1">{{ $totalDiterima }}</h3>
                <p class="text-gray-400 text-sm">Santri</p>
            </div>

            <!-- Cadangan -->
            <div class="glass-dark rounded-xl p-6 hover:scale-105 transition transform">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-yellow-500/20 rounded-lg flex items-center justify-center">
                        <i class="fas fa-exclamation-circle text-2xl text-yellow-400"></i>
                    </div>
                    <span class="text-sm text-gray-400">Cadangan</span>
                </div>
                <h3 class="text-3xl font-bold text-white mb-1">{{ $totalCadangan }}</h3>
                <p class="text-gray-400 text-sm">Santri</p>
            </div>

            <!-- Tidak Diterima -->
            <div class="glass-dark rounded-xl p-6 hover:scale-105 transition transform">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-red-500/20 rounded-lg flex items-center justify-center">
                        <i class="fas fa-times-circle text-2xl text-red-400"></i>
                    </div>
                    <span class="text-sm text-gray-400">Ditolak</span>
                </div>
                <h3 class="text-3xl font-bold text-white mb-1">{{ $totalDitolak }}</h3>
                <p class="text-gray-400 text-sm">Santri</p>
            </div>
        </div>

        <!-- Info Pesantren -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="glass-orange p-6 rounded-xl text-center">
                <i class="fas fa-users text-4xl text-orange-500 mb-3"></i>
                <h3 class="text-3xl font-bold text-white mb-1">{{ $pengaturan->jumlah_santri ?? 0 }}</h3>
                <p class="text-gray-300">Santri Aktif</p>
            </div>
            <div class="glass-orange p-6 rounded-xl text-center">
                <i class="fas fa-chalkboard-teacher text-4xl text-orange-500 mb-3"></i>
                <h3 class="text-3xl font-bold text-white mb-1">{{ $pengaturan->jumlah_guru ?? 0 }}</h3>
                <p class="text-gray-300">Guru & Ustadz</p>
            </div>
            <div class="glass-orange p-6 rounded-xl text-center">
                <i class="fas fa-user-graduate text-4xl text-orange-500 mb-3"></i>
                <h3 class="text-3xl font-bold text-white mb-1">{{ $pengaturan->jumlah_alumni ?? 0 }}</h3>
                <p class="text-gray-300">Alumni</p>
            </div>
        </div>

        <!-- Quick Menu -->
        <div class="glass-dark rounded-xl p-6">
            <h3 class="text-xl font-semibold text-white mb-6">
                <i class="fas fa-bolt mr-2"></i>Menu Cepat
            </h3>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <a href="{{ route('admin.pendaftar') }}"
                    class="glass-orange p-6 rounded-xl text-center hover:bg-orange-500/20 transition">
                    <i class="fas fa-users text-3xl text-orange-500 mb-3"></i>
                    <p class="text-white font-semibold">Data Pendaftar</p>
                </a>

                <a href="{{ route('admin.perhitungan') }}"
                    class="glass-orange p-6 rounded-xl text-center hover:bg-orange-500/20 transition">
                    <i class="fas fa-calculator text-3xl text-orange-500 mb-3"></i>
                    <p class="text-white font-semibold">Hitung SMART</p>
                </a>

                <a href="{{ route('admin.kriteria.index') }}"
                    class="glass-orange p-6 rounded-xl text-center hover:bg-orange-500/20 transition">
                    <i class="fas fa-sliders-h text-3xl text-orange-500 mb-3"></i>
                    <p class="text-white font-semibold">Kelola Kriteria</p>
                </a>

                <a href="{{ route('admin.periode.index') }}"
                    class="glass-orange p-6 rounded-xl text-center hover:bg-orange-500/20 transition">
                    <i class="fas fa-calendar-alt text-3xl text-orange-500 mb-3"></i>
                    <p class="text-white font-semibold">Kelola Periode</p>
                </a>

                <a href="{{ route('admin.pengaturan') }}"
                    class="glass-orange p-6 rounded-xl text-center hover:bg-orange-500/20 transition">
                    <i class="fas fa-cog text-3xl text-orange-500 mb-3"></i>
                    <p class="text-white font-semibold">Pengaturan</p>
                </a>

                <a href="{{ route('admin.laporan') }}"
                    class="glass-orange p-6 rounded-xl text-center hover:bg-orange-500/20 transition">
                    <i class="fas fa-file-pdf text-3xl text-orange-500 mb-3"></i>
                    <p class="text-white font-semibold">Laporan</p>
                </a>
            </div>
        </div>
    </div>
@endsection
