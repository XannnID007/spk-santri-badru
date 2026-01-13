@extends('layouts.dashboard')

@section('title', 'Pengumuman Hasil Seleksi')

@section('content')
    <div class="max-w-3xl mx-auto">

        <div class="mb-8 text-center md:text-left">
            <h1 class="text-2xl font-bold text-slate-800">Hasil Seleksi</h1>
            <p class="text-sm text-slate-500 mt-1">Informasi kelulusan penerimaan santri baru.</p>
        </div>

        @if (!$pengumuman)
            <div class="bg-white rounded-2xl p-12 text-center border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.03)]">
                <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="far fa-clock text-4xl text-slate-300"></i>
                </div>
                <h2 class="text-xl font-bold text-slate-800 mb-2">Pengumuman Belum Tersedia</h2>
                <p class="text-slate-500 text-sm mb-8 max-w-md mx-auto">
                    Hasil seleksi saat ini sedang dalam proses atau belum dipublikasikan oleh panitia.
                    Silakan cek kembali secara berkala.
                </p>
                <a href="{{ route('pendaftar.dashboard') }}"
                    class="inline-flex items-center px-6 py-2.5 bg-white border border-slate-200 text-slate-600 rounded-xl font-bold text-sm hover:bg-slate-50 transition">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali ke Dashboard
                </a>
            </div>
        @else
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-8 border border-slate-100">
                @if ($pengumuman->status_kelulusan === 'diterima')
                    <div class="bg-emerald-500 p-8 text-center text-white relative overflow-hidden">
                        <div class="absolute top-0 left-0 w-full h-full bg-white/10"
                            style="background-image: radial-gradient(circle, #ffffff 1px, transparent 1px); background-size: 20px 20px; opacity: 0.2;">
                        </div>
                        <div class="relative z-10">
                            <div
                                class="w-20 h-20 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center mx-auto mb-4 border-4 border-white/30">
                                <i class="fas fa-check text-4xl"></i>
                            </div>
                            <h2 class="text-3xl font-black mb-1 tracking-tight">SELAMAT!</h2>
                            <p class="text-emerald-100 font-medium text-lg">Anda Dinyatakan DITERIMA</p>
                        </div>
                    </div>
                @elseif($pengumuman->status_kelulusan === 'cadangan')
                    <div class="bg-amber-500 p-8 text-center text-white relative overflow-hidden">
                        <div class="relative z-10">
                            <div
                                class="w-20 h-20 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center mx-auto mb-4 border-4 border-white/30">
                                <i class="fas fa-exclamation text-4xl"></i>
                            </div>
                            <h2 class="text-3xl font-black mb-1 tracking-tight">DAFTAR CADANGAN</h2>
                            <p class="text-amber-100 font-medium text-lg">Anda Masuk Kuota Cadangan</p>
                        </div>
                    </div>
                @else
                    <div class="bg-rose-500 p-8 text-center text-white relative overflow-hidden">
                        <div class="relative z-10">
                            <div
                                class="w-20 h-20 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center mx-auto mb-4 border-4 border-white/30">
                                <i class="fas fa-times text-4xl"></i>
                            </div>
                            <h2 class="text-3xl font-black mb-1 tracking-tight">MOHON MAAF</h2>
                            <p class="text-rose-100 font-medium text-lg">Anda Belum Lolos Seleksi</p>
                        </div>
                    </div>
                @endif

                <div class="p-6 md:p-8">
                    <div
                        class="flex flex-col md:flex-row justify-center gap-4 md:gap-12 text-center pb-8 border-b border-slate-100">
                        <div>
                            <p class="text-xs text-slate-400 uppercase font-bold mb-1">Periode</p>
                            <p class="text-slate-700 font-semibold">{{ $pendaftaran->periode->nama_periode }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400 uppercase font-bold mb-1">Total Nilai</p>
                            <p class="text-2xl font-bold text-slate-800">
                                {{ number_format($pengumuman->nilai_akhir * 100, 2) }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400 uppercase font-bold mb-1">Peringkat</p>
                            <div
                                class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-slate-100 font-bold text-slate-600">
                                {{ $pengumuman->ranking }}
                            </div>
                        </div>
                    </div>

                    <div class="mt-8">
                        <h3 class="text-sm font-bold text-slate-800 mb-4 flex items-center">
                            <i class="fas fa-list-ul mr-2 text-slate-400"></i> Rincian Penilaian
                        </h3>
                        <div class="space-y-3">
                            @foreach ($nilaiDetails as $detail)
                                <div
                                    class="flex justify-between items-center p-3 bg-slate-50 rounded-lg border border-slate-100">
                                    <div>
                                        <p class="text-sm font-semibold text-slate-700">{{ $detail['kriteria'] }}</p>
                                        <p class="text-[10px] text-slate-400">Bobot: {{ $detail['bobot'] }}%</p>
                                    </div>
                                    <span class="font-mono font-bold text-slate-600">
                                        @if (strpos($detail['kriteria'], 'Penghasilan') !== false)
                                            Rp {{ number_format($detail['nilai'], 0, ',', '.') }}
                                        @else
                                            {{ number_format($detail['nilai'], 2) }}
                                        @endif
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    @if ($pengumuman->catatan)
                        <div class="mt-6 p-4 bg-orange-50 border border-orange-100 rounded-xl text-sm text-orange-800">
                            <p class="font-bold mb-1"><i class="fas fa-sticky-note mr-2"></i>Catatan Panitia:</p>
                            <p>{{ $pengumuman->catatan }}</p>
                        </div>
                    @endif

                    <div class="mt-8 flex flex-col sm:flex-row gap-4">
                        @if ($pengumuman->status_kelulusan === 'diterima')
                            <a href="{{ route('pendaftar.download-sk', $pengumuman->perhitungan_id) }}"
                                class="flex-1 py-3 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-bold text-sm text-center transition shadow-lg shadow-emerald-600/20">
                                <i class="fas fa-file-download mr-2"></i> Download Surat Keputusan
                            </a>
                        @endif
                        <a href="{{ route('pendaftar.dashboard') }}"
                            class="flex-1 py-3 bg-white border border-slate-200 text-slate-600 hover:bg-slate-50 rounded-xl font-bold text-sm text-center transition">
                            Kembali ke Dashboard
                        </a>
                    </div>
                </div>
            </div>

            @if ($pengumuman->status_kelulusan === 'diterima')
                <div class="bg-blue-50 border border-blue-100 rounded-2xl p-6">
                    <h4 class="text-blue-900 font-bold mb-3 flex items-center">
                        <i class="fas fa-info-circle mr-2"></i> Langkah Selanjutnya
                    </h4>
                    <ul class="space-y-2 text-sm text-blue-800">
                        <li class="flex items-start gap-2">
                            <i class="fas fa-check mt-1 text-blue-500"></i>
                            <span>Silakan download dan cetak Surat Keputusan (SK) Kelulusan di atas.</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fas fa-check mt-1 text-blue-500"></i>
                            <span>Lakukan daftar ulang dengan membawa dokumen asli ke sekretariat pondok.</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fas fa-check mt-1 text-blue-500"></i>
                            <span>Hubungi panitia jika ada kendala atau pertanyaan lebih lanjut.</span>
                        </li>
                    </ul>
                </div>
            @elseif($pengumuman->status_kelulusan === 'cadangan')
                <div class="bg-amber-50 border border-amber-100 rounded-2xl p-6 text-amber-800 text-sm">
                    <p class="font-bold mb-2"><i class="fas fa-info-circle mr-2"></i> Informasi Penting</p>
                    <p>Nama Anda saat ini berada dalam daftar tunggu (waiting list). Apabila ada calon santri utama yang
                        mengundurkan diri, panitia akan segera menghubungi Anda sesuai urutan peringkat.</p>
                </div>
            @else
                <div class="bg-slate-50 border border-slate-200 rounded-2xl p-6 text-slate-600 text-sm text-center">
                    <p>Terima kasih telah mengikuti seleksi masuk Pondok Pesantren Al-Badru. Tetap semangat dan jangan
                        menyerah!</p>
                </div>
            @endif

        @endif
    </div>
@endsection
