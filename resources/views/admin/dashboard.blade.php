@extends('layouts.dashboard')

@section('title', 'Overview')

@section('content')
    <div class="mb-8">
        @if ($periodeAktif)
            <div
                class="relative overflow-hidden bg-white rounded-2xl p-6 border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.03)] flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                <div class="absolute top-0 left-0 w-1 h-full bg-emerald-500"></div>
                <div class="flex items-center gap-4 z-10">
                    <div class="w-12 h-12 rounded-full bg-emerald-50 flex items-center justify-center text-emerald-600">
                        <i class="far fa-calendar-check text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-slate-800 font-bold text-lg leading-tight">{{ $periodeAktif->nama_periode }}</h3>
                        <p class="text-slate-500 text-sm mt-1">
                            <span class="font-medium text-slate-700">Kuota: {{ $periodeAktif->kuota_santri }}</span> &bull;
                            {{ \Carbon\Carbon::parse($periodeAktif->tanggal_mulai)->format('d M') }} -
                            {{ \Carbon\Carbon::parse($periodeAktif->tanggal_selesai)->format('d M Y') }}
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-2 z-10">
                    <span class="flex h-3 w-3 relative">
                        <span
                            class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
                    </span>
                    <span class="text-xs font-bold text-emerald-600 uppercase tracking-wider">Sedang Berlangsung</span>
                </div>

                <div class="absolute right-0 top-0 opacity-5 pointer-events-none">
                    <i class="fas fa-calendar-alt text-9xl text-slate-800 -mr-4 -mt-4 transform rotate-12"></i>
                </div>
            </div>
        @else
            <div
                class="relative overflow-hidden bg-white rounded-2xl p-6 border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.03)] flex items-center justify-between">
                <div class="absolute top-0 left-0 w-1 h-full bg-red-500"></div>
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-red-50 flex items-center justify-center text-red-600">
                        <i class="far fa-calendar-times text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-slate-800 font-bold text-lg">Tidak Ada Periode Aktif</h3>
                        <p class="text-slate-500 text-sm">Penerimaan santri baru sedang ditutup.</p>
                    </div>
                </div>
                <a href="{{ route('admin.periode.index') }}"
                    class="px-5 py-2.5 bg-slate-900 text-white text-xs font-bold rounded-xl hover:bg-slate-800 transition">
                    Buka Periode
                </a>
            </div>
        @endif
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

        <div
            class="bg-white p-6 rounded-2xl shadow-[0_4px_20px_rgba(0,0,0,0.03)] border border-slate-100 hover:-translate-y-1 transition-transform duration-300 group">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Total Pendaftar</p>
                    <h3 class="text-3xl font-extrabold text-slate-800 mt-1">{{ $totalPendaftar }}</h3>
                </div>
                <div
                    class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center group-hover:bg-blue-600 group-hover:text-white transition-colors">
                    <i class="fas fa-users text-lg"></i>
                </div>
            </div>
            <div class="w-full bg-slate-100 rounded-full h-1.5 mt-2">
                <div class="bg-blue-500 h-1.5 rounded-full" style="width: 100%"></div>
            </div>
        </div>

        <div
            class="bg-white p-6 rounded-2xl shadow-[0_4px_20px_rgba(0,0,0,0.03)] border border-slate-100 hover:-translate-y-1 transition-transform duration-300 group">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Lulus Seleksi</p>
                    <h3 class="text-3xl font-extrabold text-slate-800 mt-1">{{ $totalDiterima }}</h3>
                </div>
                <div
                    class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center group-hover:bg-emerald-600 group-hover:text-white transition-colors">
                    <i class="fas fa-check-circle text-lg"></i>
                </div>
            </div>
            <div class="w-full bg-slate-100 rounded-full h-1.5 mt-2">
                @php $persenLulus = $totalPendaftar > 0 ? ($totalDiterima / $totalPendaftar) * 100 : 0; @endphp
                <div class="bg-emerald-500 h-1.5 rounded-full" style="width: {{ $persenLulus }}%"></div>
            </div>
        </div>

        <div
            class="bg-white p-6 rounded-2xl shadow-[0_4px_20px_rgba(0,0,0,0.03)] border border-slate-100 hover:-translate-y-1 transition-transform duration-300 group">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Waiting List</p>
                    <h3 class="text-3xl font-extrabold text-slate-800 mt-1">{{ $totalCadangan }}</h3>
                </div>
                <div
                    class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center group-hover:bg-amber-600 group-hover:text-white transition-colors">
                    <i class="fas fa-clock text-lg"></i>
                </div>
            </div>
            <div class="w-full bg-slate-100 rounded-full h-1.5 mt-2">
                @php $persenCadangan = $totalPendaftar > 0 ? ($totalCadangan / $totalPendaftar) * 100 : 0; @endphp
                <div class="bg-amber-500 h-1.5 rounded-full" style="width: {{ $persenCadangan }}%"></div>
            </div>
        </div>

        <div
            class="bg-white p-6 rounded-2xl shadow-[0_4px_20px_rgba(0,0,0,0.03)] border border-slate-100 hover:-translate-y-1 transition-transform duration-300 group">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Tidak Lulus</p>
                    <h3 class="text-3xl font-extrabold text-slate-800 mt-1">{{ $totalDitolak }}</h3>
                </div>
                <div
                    class="w-10 h-10 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center group-hover:bg-rose-600 group-hover:text-white transition-colors">
                    <i class="fas fa-times-circle text-lg"></i>
                </div>
            </div>
            <div class="w-full bg-slate-100 rounded-full h-1.5 mt-2">
                @php $persenDitolak = $totalPendaftar > 0 ? ($totalDitolak / $totalPendaftar) * 100 : 0; @endphp
                <div class="bg-rose-500 h-1.5 rounded-full" style="width: {{ $persenDitolak }}%"></div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl p-8 border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.03)]">
        <div class="flex items-center justify-between mb-6">
            <h4 class="text-slate-800 font-bold text-lg">Data Pondok Pesantren</h4>
            <a href="{{ route('admin.pengaturan') }}"
                class="text-orange-500 hover:text-orange-600 text-sm font-medium transition">
                Edit Data <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="flex items-center gap-4 p-4 rounded-xl bg-slate-50 border border-slate-100">
                <div class="w-12 h-12 rounded-full bg-white flex items-center justify-center text-indigo-500 shadow-sm">
                    <i class="fas fa-user-graduate text-xl"></i>
                </div>
                <div>
                    <p class="text-2xl font-bold text-slate-800">{{ $pengaturan->jumlah_santri ?? 0 }}</p>
                    <p class="text-xs text-slate-500 uppercase tracking-wide font-semibold">Total Santri</p>
                </div>
            </div>

            <div class="flex items-center gap-4 p-4 rounded-xl bg-slate-50 border border-slate-100">
                <div class="w-12 h-12 rounded-full bg-white flex items-center justify-center text-violet-500 shadow-sm">
                    <i class="fas fa-chalkboard-teacher text-xl"></i>
                </div>
                <div>
                    <p class="text-2xl font-bold text-slate-800">{{ $pengaturan->jumlah_guru ?? 0 }}</p>
                    <p class="text-xs text-slate-500 uppercase tracking-wide font-semibold">Total Guru</p>
                </div>
            </div>

            <div class="flex items-center gap-4 p-4 rounded-xl bg-slate-50 border border-slate-100">
                <div class="w-12 h-12 rounded-full bg-white flex items-center justify-center text-orange-500 shadow-sm">
                    <i class="fas fa-graduation-cap text-xl"></i>
                </div>
                <div>
                    <p class="text-2xl font-bold text-slate-800">{{ $pengaturan->jumlah_alumni ?? 0 }}</p>
                    <p class="text-xs text-slate-500 uppercase tracking-wide font-semibold">Total Alumni</p>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Cek apakah ini login baru (redirect dari login biasanya bawa session 'success' atau 'status')
            // Atau kita bisa paksa tampilkan notifikasi welcome sekali saja menggunakan session flash spesifik

            @if (session('success') && str_contains(session('success'), 'Login'))
                // Jika pesan sukses mengandung kata "Login" (sesuaikan dengan controller Anda)
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 4000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                });

                Toast.fire({
                    icon: 'success',
                    title: 'Selamat Datang, {{ Auth::user()->nama }}!',
                    text: 'Senang melihat Anda kembali.'
                });
            @endif
        });
    </script>
@endsection
