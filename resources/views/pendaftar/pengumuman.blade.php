@extends('layouts.dashboard')

@section('title', 'Pengumuman Hasil Seleksi')

@section('content')
    <div class="max-w-4xl mx-auto">

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
                {{-- Tambahkan print:hidden di sini --}}
                <a href="{{ route('pendaftar.dashboard') }}"
                    class="print:hidden inline-flex items-center px-6 py-2.5 bg-white border border-slate-200 text-slate-600 rounded-xl font-bold text-sm hover:bg-slate-50 transition">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali ke Dashboard
                </a>
            </div>
        @else
            {{-- CARD HASIL --}}
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

                    {{-- DETAIL PERHITUNGAN SMART --}}
                    <div class="mt-8">
                        <h3 class="text-sm font-bold text-slate-800 mb-4 flex items-center">
                            <i class="fas fa-calculator mr-2 text-slate-400"></i> Detail Perhitungan SMART
                        </h3>

                        <div class="bg-gradient-to-br from-blue-50 to-slate-50 rounded-xl border border-blue-100 p-5 mb-4">
                            <div class="flex items-start gap-3 mb-3">
                                <div class="w-8 h-8 rounded-lg bg-blue-600 flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-lightbulb text-white text-sm"></i>
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-blue-900 mb-1">Metode SMART</h4>
                                    <p class="text-xs text-blue-700 leading-relaxed">
                                        <strong>Simple Multi-Attribute Rating Technique</strong> adalah metode pengambilan
                                        keputusan yang menghitung
                                        nilai akhir berdasarkan normalisasi nilai kriteria dikalikan dengan bobot
                                        masing-masing.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
                            <div class="overflow-x-auto">
                                <table class="w-full text-sm">
                                    <thead>
                                        <tr class="bg-slate-50 border-b border-slate-200">
                                            <th class="text-left py-3 px-4 font-bold text-slate-600 text-xs uppercase">
                                                Kriteria</th>
                                            <th class="text-center py-3 px-4 font-bold text-slate-600 text-xs uppercase">
                                                Nilai Asli</th>
                                            <th class="text-center py-3 px-4 font-bold text-slate-600 text-xs uppercase">
                                                Normalisasi</th>
                                            <th class="text-center py-3 px-4 font-bold text-slate-600 text-xs uppercase">
                                                Bobot</th>
                                            <th class="text-center py-3 px-4 font-bold text-slate-600 text-xs uppercase">
                                                Nilai Terbobot</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-100">
                                        @php
                                            $totalNilaiTerbobot = 0;
                                        @endphp
                                        @foreach ($nilaiDetails as $detail)
                                            @php
                                                $totalNilaiTerbobot += $detail['nilai_terbobot'];
                                            @endphp
                                            <tr class="hover:bg-slate-50 transition">
                                                <td class="py-3 px-4">
                                                    <div>
                                                        <p class="font-semibold text-slate-700">{{ $detail['kriteria'] }}
                                                        </p>
                                                        <div class="flex items-center gap-2 mt-1">
                                                            <span
                                                                class="text-xs text-slate-400">{{ $detail['kode'] }}</span>
                                                            <span
                                                                class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold 
                                                                {{ $detail['jenis'] === 'benefit' ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }}">
                                                                @if ($detail['jenis'] === 'benefit')
                                                                    <i class="fas fa-arrow-up mr-1 text-[10px]"></i> Benefit
                                                                @else
                                                                    <i class="fas fa-arrow-down mr-1 text-[10px]"></i> Cost
                                                                @endif
                                                            </span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="py-3 px-4 text-center">
                                                    <div class="font-mono font-bold text-slate-700">
                                                        @if ($detail['kode'] === 'C3')
                                                            <span class="text-xs">Rp</span>
                                                            {{ number_format($detail['nilai_asli'], 0, ',', '.') }}
                                                        @else
                                                            {{ number_format($detail['nilai_asli'], 2) }}
                                                        @endif
                                                    </div>
                                                </td>
                                                <td class="py-3 px-4">
                                                    <div class="flex flex-col items-center gap-1">
                                                        <span
                                                            class="text-sm font-bold text-blue-600">{{ number_format($detail['nilai_normalisasi'], 4) }}</span>
                                                        <div
                                                            class="w-full max-w-[80px] h-2 bg-slate-100 rounded-full overflow-hidden print:hidden">
                                                            <div class="h-full bg-gradient-to-r from-blue-400 to-blue-600 transition-all duration-500"
                                                                style="width: {{ $detail['nilai_normalisasi'] * 100 }}%">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="py-3 px-4 text-center">
                                                    <span
                                                        class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-orange-100 text-orange-700">
                                                        {{ number_format($detail['bobot'], 0) }}%
                                                    </span>
                                                </td>
                                                <td class="py-3 px-4 text-center">
                                                    <div class="flex flex-col items-center">
                                                        <span
                                                            class="text-lg font-bold text-slate-800">{{ number_format($detail['nilai_terbobot'], 4) }}</span>
                                                        <span class="text-xs text-slate-400">
                                                            ({{ number_format($detail['nilai_terbobot'] * 100, 2) }}%)
                                                        </span>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot class="bg-gradient-to-r from-slate-50 to-orange-50 border-t-2 border-orange-200">
                                        <tr>
                                            <td colspan="4" class="py-4 px-4 text-right font-bold text-slate-800">
                                                <i class="fas fa-equals mr-2 text-orange-500"></i>
                                                Nilai Akhir (Σ Nilai Terbobot):
                                            </td>
                                            <td class="py-4 px-4 text-center">
                                                <div
                                                    class="inline-flex flex-col items-center gap-1 px-4 py-2 bg-white rounded-lg border-2 border-orange-300 shadow-sm">
                                                    <div class="flex items-center gap-2">
                                                        <i class="fas fa-star text-orange-500"></i>
                                                        <span class="text-xl font-black text-orange-600">
                                                            {{ number_format($totalNilaiTerbobot, 4) }}
                                                        </span>
                                                    </div>
                                                    <span class="text-xs text-slate-500">
                                                        = {{ number_format($totalNilaiTerbobot * 100, 2) }} / 100
                                                    </span>
                                                </div>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                        {{-- Penjelasan Formula --}}
                        <div class="mt-4 p-4 bg-slate-50 border border-slate-200 rounded-xl">
                            <h5 class="text-xs font-bold text-slate-700 mb-3 flex items-center gap-2">
                                <i class="fas fa-info-circle text-slate-400"></i>
                                Rumus Perhitungan SMART
                            </h5>
                            <div class="space-y-3 text-xs text-slate-600">
                                <div class="bg-white p-3 rounded-lg border border-slate-200">
                                    <p class="font-bold text-slate-700 mb-1">1️⃣ Normalisasi (skala 0-1)</p>
                                    <div class="font-mono text-xs bg-slate-50 p-2 rounded border border-slate-200 mb-1">
                                        • Benefit: (nilai - min) / (max - min)<br>
                                        • Cost: (max - nilai) / (max - min)
                                    </div>
                                    <p class="text-slate-500">Mengubah semua nilai ke skala yang sama (0 sampai 1)</p>
                                </div>

                                <div class="bg-white p-3 rounded-lg border border-slate-200">
                                    <p class="font-bold text-slate-700 mb-1">2️⃣ Nilai Terbobot</p>
                                    <div class="font-mono text-xs bg-slate-50 p-2 rounded border border-slate-200 mb-1">
                                        Nilai Terbobot = Normalisasi × Bobot
                                    </div>
                                    <p class="text-slate-500">Mengalikan hasil normalisasi dengan bobot kriteria</p>
                                </div>

                                <div class="bg-white p-3 rounded-lg border border-slate-200">
                                    <p class="font-bold text-slate-700 mb-1">3️⃣ Nilai Akhir</p>
                                    <div class="font-mono text-xs bg-slate-50 p-2 rounded border border-slate-200 mb-1">
                                        Nilai Akhir = Σ (Semua Nilai Terbobot)
                                    </div>
                                    <p class="text-slate-500">Menjumlahkan semua nilai terbobot dari setiap kriteria</p>
                                </div>
                            </div>
                        </div>

                        {{-- Contoh Perhitungan --}}
                        <div class="mt-4 p-4 bg-blue-50 border border-blue-200 rounded-xl break-inside-avoid">
                            <h5 class="text-xs font-bold text-blue-800 mb-2 flex items-center gap-2">
                                <i class="fas fa-graduation-cap"></i>
                                Contoh Perhitungan untuk {{ $nilaiDetails[0]['kriteria'] ?? 'Kriteria 1' }}
                            </h5>
                            <div class="text-xs text-blue-700 space-y-1">
                                @if (isset($nilaiDetails[0]))
                                    <p>• Nilai Asli:
                                        <strong>{{ number_format($nilaiDetails[0]['nilai_asli'], 2) }}</strong>
                                    </p>
                                    <p>• Setelah Normalisasi:
                                        <strong>{{ number_format($nilaiDetails[0]['nilai_normalisasi'], 4) }}</strong>
                                    </p>
                                    <p>• Bobot Kriteria:
                                        <strong>{{ number_format($nilaiDetails[0]['bobot'], 0) }}%</strong> =
                                        <strong>{{ number_format($detail['bobot'] / 100, 2) }}</strong>
                                    </p>
                                    <p class="pt-2 border-t border-blue-200 mt-2">
                                        • Nilai Terbobot = {{ number_format($nilaiDetails[0]['nilai_normalisasi'], 4) }} ×
                                        {{ number_format($detail['bobot'] / 100, 2) }}
                                        = <strong
                                            class="text-blue-900">{{ number_format($nilaiDetails[0]['nilai_terbobot'], 4) }}</strong>
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>

                    @if ($pengumuman->catatan)
                        <div
                            class="mt-6 p-4 bg-orange-50 border border-orange-100 rounded-xl text-sm text-orange-800 break-inside-avoid">
                            <p class="font-bold mb-1"><i class="fas fa-sticky-note mr-2"></i>Catatan Panitia:</p>
                            <p>{{ $pengumuman->catatan }}</p>
                        </div>
                    @endif

                    {{-- INI BAGIAN UTAMA YANG DIPERBAIKI: Tambahkan print:hidden --}}
                    <div class="mt-8 flex flex-col sm:flex-row gap-4 print:hidden">
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

            {{-- Sembunyikan juga bagian "Langkah Selanjutnya" saat dicetak agar kertas print terlihat lebih formal --}}
            <div class="print:hidden">
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
                        <p>Terima kasih telah mengikuti seleksi masuk Pondok Pesantren. Tetap semangat dan jangan menyerah!
                        </p>
                    </div>
                @endif
            </div>

        @endif
    </div>
@endsection
