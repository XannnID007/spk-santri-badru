@extends('layouts.dashboard')

@section('title', 'Dashboard Pendaftar')

@section('content')
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-slate-800">Selamat Datang, {{ Auth::user()->nama }}! 👋</h1>
        <p class="text-sm text-slate-500 mt-1">Pantau status pendaftaran dan hasil seleksi Anda di sini.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

        <div class="lg:col-span-8 space-y-8">

            @if ($periodeAktif)
                <div
                    class="bg-gradient-to-r from-orange-500 to-orange-600 rounded-2xl p-6 text-white shadow-lg relative overflow-hidden">
                    <div class="absolute right-0 top-0 h-full w-1/3 bg-white/10 skew-x-12 transform translate-x-12"></div>
                    <div class="relative z-10 flex items-center gap-4">
                        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                            <i class="far fa-calendar-alt text-2xl"></i>
                        </div>
                        <div>
                            <p class="text-orange-100 text-xs font-bold uppercase tracking-wider mb-1">Periode Aktif</p>
                            <h3 class="text-xl font-bold">{{ $periodeAktif->nama_periode }}</h3>
                            <p class="text-sm text-orange-50 mt-1">
                                {{ \Carbon\Carbon::parse($periodeAktif->tanggal_mulai)->format('d M Y') }} s/d
                                {{ \Carbon\Carbon::parse($periodeAktif->tanggal_selesai)->format('d M Y') }}
                            </p>
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-rose-50 rounded-2xl p-6 border border-rose-100 flex items-center gap-4">
                    <div class="w-12 h-12 bg-rose-100 rounded-xl flex items-center justify-center text-rose-500">
                        <i class="fas fa-calendar-times text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-rose-700">Tidak Ada Periode Aktif</h3>
                        <p class="text-sm text-rose-600">Pendaftaran santri baru sedang ditutup saat ini.</p>
                    </div>
                </div>
            @endif

            <div class="bg-white rounded-2xl p-8 border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.03)]">
                <h3 class="text-lg font-bold text-slate-800 mb-6">Tahapan Pendaftaran</h3>

                <div class="relative pl-4">
                    <div class="absolute left-[19px] top-2 bottom-4 w-0.5 bg-slate-200"></div>

                    <div class="relative flex gap-6 pb-8 group">
                        <div
                            class="w-10 h-10 rounded-full flex items-center justify-center border-4 border-white shadow-sm z-10 relative transition
                            {{ $statusProfil ? 'bg-emerald-500 text-white' : 'bg-white border-orange-500 text-orange-500' }}">
                            @if ($statusProfil)
                                <i class="fas fa-check"></i>
                            @else
                                <span>1</span>
                            @endif
                        </div>
                        <div class="flex-1 pt-1">
                            <h4 class="font-bold text-slate-800 {{ $statusProfil ? 'text-emerald-600' : '' }}">Lengkapi
                                Biodata</h4>
                            <p class="text-sm text-slate-500 mb-3">Isi data diri, orang tua, dan asal sekolah.</p>
                            @if (!$statusProfil)
                                <a href="{{ route('pendaftar.profil') }}"
                                    class="inline-flex items-center px-4 py-2 bg-orange-600 text-white text-xs font-bold rounded-lg hover:bg-orange-700 transition shadow-lg shadow-orange-600/20">
                                    Lengkapi Sekarang <i class="fas fa-arrow-right ml-2"></i>
                                </a>
                            @endif
                        </div>
                    </div>

                    <div class="relative flex gap-6 pb-8 group">
                        <div
                            class="w-10 h-10 rounded-full flex items-center justify-center border-4 border-white shadow-sm z-10 relative transition
                            {{ $statusPendaftaran ? 'bg-emerald-500 text-white' : ($statusProfil ? 'bg-white border-orange-500 text-orange-500' : 'bg-slate-100 text-slate-400') }}">
                            @if ($statusPendaftaran)
                                <i class="fas fa-check"></i>
                            @else
                                <span>2</span>
                            @endif
                        </div>
                        <div class="flex-1 pt-1">
                            <h4 class="font-bold text-slate-800 {{ $statusPendaftaran ? 'text-emerald-600' : '' }}">Upload
                                Berkas & Daftar</h4>
                            <p class="text-sm text-slate-500 mb-3">Unggah dokumen persyaratan dan kirim pendaftaran.</p>
                            @if ($statusProfil && !$statusPendaftaran && $periodeAktif)
                                <a href="{{ route('pendaftar.pendaftaran') }}"
                                    class="inline-flex items-center px-4 py-2 bg-orange-600 text-white text-xs font-bold rounded-lg hover:bg-orange-700 transition shadow-lg shadow-orange-600/20">
                                    Daftar Sekarang <i class="fas fa-arrow-right ml-2"></i>
                                </a>
                            @elseif($statusPendaftaran)
                                <span
                                    class="text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-1 rounded border border-emerald-100">
                                    Sudah Mendaftar (#{{ $pendaftaran->no_pendaftaran }})
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="relative flex gap-6 pb-8 group">
                        <div
                            class="w-10 h-10 rounded-full flex items-center justify-center border-4 border-white shadow-sm z-10 relative transition
                            {{ $statusPendaftaran ? 'bg-blue-500 text-white' : 'bg-slate-100 text-slate-400' }}">
                            <span>3</span>
                        </div>
                        <div class="flex-1 pt-1">
                            <h4 class="font-bold text-slate-800">Verifikasi & Cetak Kartu</h4>
                            <p class="text-sm text-slate-500 mb-2">Admin akan memverifikasi berkas Anda.</p>

                            @if ($statusPendaftaran)
                                <div class="flex items-center gap-3 mt-2">
                                    @if ($pendaftaran->status_verifikasi == 'diterima')
                                        <span
                                            class="text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-1 rounded border border-emerald-100">
                                            <i class="fas fa-check-circle mr-1"></i> Berkas Diverifikasi
                                        </span>
                                        <a href="{{ route('pendaftar.cetak-kartu', $pendaftaran->pendaftaran_id) }}"
                                            target="_blank" class="text-xs font-bold text-blue-600 hover:underline">
                                            <i class="fas fa-print mr-1"></i> Cetak Kartu Ujian
                                        </a>
                                    @elseif($pendaftaran->status_verifikasi == 'ditolak')
                                        <span
                                            class="text-xs font-bold text-rose-600 bg-rose-50 px-2 py-1 rounded border border-rose-100">
                                            <i class="fas fa-times-circle mr-1"></i> Berkas Ditolak
                                        </span>
                                    @else
                                        <span
                                            class="text-xs font-bold text-amber-600 bg-amber-50 px-2 py-1 rounded border border-amber-100">
                                            <i class="fas fa-clock mr-1"></i> Menunggu Verifikasi
                                        </span>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="relative flex gap-6 group">
                        <div
                            class="w-10 h-10 rounded-full flex items-center justify-center border-4 border-white shadow-sm z-10 relative transition
                            {{ $pengumuman ? 'bg-purple-500 text-white' : 'bg-slate-100 text-slate-400' }}">
                            <span>4</span>
                        </div>
                        <div class="flex-1 pt-1">
                            <h4 class="font-bold text-slate-800">Hasil Seleksi</h4>
                            <p class="text-sm text-slate-500">Pengumuman kelulusan akhir.</p>
                            @if ($pengumuman)
                                <a href="{{ route('pendaftar.pengumuman') }}"
                                    class="mt-3 inline-flex items-center px-4 py-2 bg-purple-600 text-white text-xs font-bold rounded-lg hover:bg-purple-700 transition shadow-lg shadow-purple-600/20">
                                    Lihat Hasil <i class="fas fa-eye ml-2"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="lg:col-span-4 space-y-6">

            <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.03)]">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center text-slate-500">
                        <i class="far fa-user text-xl"></i>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 uppercase font-bold">Status Profil</p>
                        @if ($statusProfil)
                            <p class="text-emerald-600 font-bold flex items-center gap-1">
                                <i class="fas fa-check-circle"></i> Lengkap
                            </p>
                        @else
                            <p class="text-rose-500 font-bold flex items-center gap-1">
                                <i class="fas fa-times-circle"></i> Belum Lengkap
                            </p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.03)]">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center text-slate-500">
                        <i class="far fa-file-alt text-xl"></i>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 uppercase font-bold">Pendaftaran</p>
                        @if ($statusPendaftaran)
                            <p class="text-blue-600 font-bold">Sudah Submit</p>
                        @else
                            <p class="text-slate-500 font-bold">Belum Submit</p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.03)]">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center text-slate-500">
                        <i class="fas fa-trophy text-xl"></i>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 uppercase font-bold">Hasil Akhir</p>
                        @if ($pengumuman)
                            @if ($pengumuman->status_kelulusan == 'diterima')
                                <p class="text-emerald-600 font-bold">LULUS</p>
                            @elseif ($pengumuman->status_kelulusan == 'cadangan')
                                <p class="text-amber-500 font-bold">CADANGAN</p>
                            @else
                                <p class="text-rose-500 font-bold">TIDAK LULUS</p>
                            @endif
                        @else
                            <p class="text-slate-500 font-bold">Belum Ada</p>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
