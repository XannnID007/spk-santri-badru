@extends('layouts.dashboard')

@section('title', 'Dashboard Admin')

@section('content')
    <!-- Welcome Header -->
    <div class="bg-gradient-to-r from-orange-500 to-orange-600 rounded-2xl p-6 mb-6 text-white shadow-lg">
        <div class="flex items-center justify-between flex-wrap gap-4">
            <div>
                <h1 class="text-xl font-bold mb-1">Selamat Datang, {{ Auth::user()->nama }}! 👋</h1>
                <p class="text-sm text-orange-100">Kelola sistem penerimaan santri dengan mudah</p>
            </div>
            <div class="text-right">
                <p class="text-xs text-orange-100">Hari ini</p>
                <p class="text-base font-semibold">{{ now()->format('d F Y') }}</p>
            </div>
        </div>
    </div>

    <!-- Periode Aktif -->
    @if ($periodeAktif)
        <div class="bg-white rounded-xl p-5 mb-6 shadow-sm border-l-4 border-green-500">
            <div class="flex items-center justify-between flex-wrap gap-4">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-calendar-check text-xl text-green-600"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-gray-800">{{ $periodeAktif->nama_periode }}</h3>
                        <p class="text-xs text-gray-600">
                            {{ \Carbon\Carbon::parse($periodeAktif->tanggal_mulai)->format('d M Y') }} -
                            {{ \Carbon\Carbon::parse($periodeAktif->tanggal_selesai)->format('d M Y') }}
                        </p>
                        <p class="text-xs text-gray-500 mt-0.5">Kuota: {{ $periodeAktif->kuota_santri }} santri</p>
                    </div>
                </div>
                <span class="bg-green-100 text-green-700 px-3 py-1.5 rounded-full text-xs font-semibold">
                    <i class="fas fa-circle text-xs mr-1"></i>Periode Aktif
                </span>
            </div>
        </div>
    @else
        <div class="bg-white rounded-xl p-5 mb-6 shadow-sm border-l-4 border-red-500">
            <div class="flex items-center justify-between flex-wrap gap-4">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-exclamation-triangle text-xl text-red-600"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-gray-800">Tidak Ada Periode Aktif</h3>
                        <p class="text-xs text-gray-600">Aktifkan periode untuk memulai penerimaan</p>
                    </div>
                </div>
                <a href="{{ route('admin.periode.index') }}"
                    class="px-4 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition text-xs font-semibold">
                    <i class="fas fa-plus mr-1"></i>Kelola Periode
                </a>
            </div>
        </div>
    @endif

    <!-- Statistik Utama -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mb-6">
        <!-- Total Pendaftar -->
        <div class="bg-white rounded-xl p-5 shadow-sm hover:shadow-md transition border border-gray-100">
            <div class="flex items-center justify-between mb-3">
                <div class="w-11 h-11 bg-blue-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-users text-lg text-blue-600"></i>
                </div>
                <span class="text-xs font-medium text-gray-500">Total</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-800 mb-0.5">{{ $totalPendaftar }}</h3>
            <p class="text-xs text-gray-500">Pendaftar</p>
        </div>

        <!-- Diterima -->
        <div class="bg-white rounded-xl p-5 shadow-sm hover:shadow-md transition border border-gray-100">
            <div class="flex items-center justify-between mb-3">
                <div class="w-11 h-11 bg-green-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-check-circle text-lg text-green-600"></i>
                </div>
                <span class="text-xs font-medium text-gray-500">Lulus</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-800 mb-0.5">{{ $totalDiterima }}</h3>
            <p class="text-xs text-gray-500">Diterima</p>
        </div>

        <!-- Cadangan -->
        <div class="bg-white rounded-xl p-5 shadow-sm hover:shadow-md transition border border-gray-100">
            <div class="flex items-center justify-between mb-3">
                <div class="w-11 h-11 bg-yellow-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-clock text-lg text-yellow-600"></i>
                </div>
                <span class="text-xs font-medium text-gray-500">Waiting</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-800 mb-0.5">{{ $totalCadangan }}</h3>
            <p class="text-xs text-gray-500">Cadangan</p>
        </div>

        <!-- Ditolak -->
        <div class="bg-white rounded-xl p-5 shadow-sm hover:shadow-md transition border border-gray-100">
            <div class="flex items-center justify-between mb-3">
                <div class="w-11 h-11 bg-red-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-times-circle text-lg text-red-600"></i>
                </div>
                <span class="text-xs font-medium text-gray-500">Rejected</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-800 mb-0.5">{{ $totalDitolak }}</h3>
            <p class="text-xs text-gray-500">Ditolak</p>
        </div>
    </div>

    <!-- Info Pesantren & Akses Cepat -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Info Pesantren -->
        <div class="bg-white rounded-xl p-6 shadow-sm">
            <h3 class="text-sm font-bold text-gray-800 mb-4 flex items-center">
                <i class="fas fa-mosque text-orange-500 mr-2"></i>
                Informasi Pesantren
            </h3>
            <div class="space-y-3">
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-user-graduate text-blue-600"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Santri Aktif</p>
                            <p class="text-sm font-bold text-gray-800">{{ $pengaturan->jumlah_santri ?? 0 }} Santri</p>
                        </div>
                    </div>
                </div>
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 bg-green-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-chalkboard-teacher text-green-600"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Tenaga Pengajar</p>
                            <p class="text-sm font-bold text-gray-800">{{ $pengaturan->jumlah_guru ?? 0 }} Guru</p>
                        </div>
                    </div>
                </div>
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 bg-purple-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-graduation-cap text-purple-600"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Alumni</p>
                            <p class="text-sm font-bold text-gray-800">{{ $pengaturan->jumlah_alumni ?? 0 }} Alumni</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Akses Cepat -->
        <div class="bg-white rounded-xl p-6 shadow-sm">
            <h3 class="text-sm font-bold text-gray-800 mb-4 flex items-center">
                <i class="fas fa-bolt text-orange-500 mr-2"></i>
                Akses Cepat
            </h3>
            <div class="grid grid-cols-2 gap-3">
                <a href="{{ route('admin.pendaftar') }}"
                    class="p-4 bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl hover:shadow-md transition text-center border border-blue-200">
                    <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center mx-auto mb-2">
                        <i class="fas fa-users text-white"></i>
                    </div>
                    <p class="text-xs font-semibold text-gray-700">Pendaftar</p>
                </a>
                <a href="{{ route('admin.perhitungan') }}"
                    class="p-4 bg-gradient-to-br from-green-50 to-green-100 rounded-xl hover:shadow-md transition text-center border border-green-200">
                    <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center mx-auto mb-2">
                        <i class="fas fa-calculator text-white"></i>
                    </div>
                    <p class="text-xs font-semibold text-gray-700">Perhitungan</p>
                </a>
                <a href="{{ route('admin.kriteria.index') }}"
                    class="p-4 bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl hover:shadow-md transition text-center border border-purple-200">
                    <div class="w-10 h-10 bg-purple-500 rounded-lg flex items-center justify-center mx-auto mb-2">
                        <i class="fas fa-sliders-h text-white"></i>
                    </div>
                    <p class="text-xs font-semibold text-gray-700">Kriteria</p>
                </a>
                <a href="{{ route('admin.laporan') }}"
                    class="p-4 bg-gradient-to-br from-orange-50 to-orange-100 rounded-xl hover:shadow-md transition text-center border border-orange-200">
                    <div class="w-10 h-10 bg-orange-500 rounded-lg flex items-center justify-center mx-auto mb-2">
                        <i class="fas fa-file-pdf text-white"></i>
                    </div>
                    <p class="text-xs font-semibold text-gray-700">Laporan</p>
                </a>
            </div>
        </div>
    </div>
@endsection
