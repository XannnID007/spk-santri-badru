@extends('layouts.dashboard')

@section('title', 'Hasil Seleksi')

@section('content')
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.perhitungan') }}"
                class="w-10 h-10 flex items-center justify-center bg-white border border-slate-200 rounded-xl text-slate-500 hover:text-orange-600 hover:border-orange-200 transition shadow-sm">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Hasil Perhitungan</h1>
                <p class="text-sm text-slate-500">Periode: <span
                        class="font-semibold text-orange-600">{{ $periode->nama_periode }}</span></p>
            </div>
        </div>

        @if ($hasil->count() > 0)
            <div class="flex items-center gap-3">
                @php
                    $isPublished = $hasil->where('is_published', true)->count() > 0;
                    $hasStatus = $hasil->whereNotNull('status_kelulusan')->count() > 0;
                @endphp

                <button onclick="openModalKelulusan()"
                    class="px-4 py-2.5 bg-white border border-slate-200 text-slate-700 hover:border-blue-300 hover:text-blue-600 rounded-xl text-sm font-bold transition shadow-sm flex items-center gap-2">
                    <i class="fas fa-clipboard-check"></i> Tentukan Kelulusan
                </button>

                @if ($hasStatus && !$isPublished)
                    <button onclick="publishPengumuman()"
                        class="px-4 py-2.5 bg-slate-800 text-white hover:bg-slate-700 rounded-xl text-sm font-bold transition shadow-lg flex items-center gap-2">
                        <i class="fas fa-bullhorn"></i> Publish Pengumuman
                    </button>
                @endif

                @if ($isPublished)
                    <span
                        class="px-4 py-2.5 bg-emerald-50 text-emerald-600 border border-emerald-100 rounded-xl text-sm font-bold flex items-center gap-2 cursor-default">
                        <i class="fas fa-check-circle"></i> Terpublikasi
                    </span>
                @endif
            </div>
        @endif
    </div>

    @if ($hasil->count() == 0)
        <div class="bg-white rounded-2xl p-12 text-center border border-slate-100 shadow-sm">
            <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6 text-slate-300">
                <i class="fas fa-calculator text-3xl"></i>
            </div>
            <h3 class="text-xl font-bold text-slate-800 mb-2">Belum Ada Hasil</h3>
            <p class="text-slate-500 text-sm mb-6 max-w-md mx-auto">Data perhitungan belum tersedia untuk periode ini.
                Silakan lakukan proses hitung terlebih dahulu.</p>
            <a href="{{ route('admin.perhitungan') }}"
                class="inline-flex items-center px-6 py-3 bg-orange-600 hover:bg-orange-700 text-white rounded-xl font-bold text-sm transition shadow-lg shadow-orange-600/20">
                <i class="fas fa-play mr-2"></i> Mulai Perhitungan
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div
                class="bg-white p-5 rounded-2xl border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.03)] flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Total Peserta</p>
                    <h3 class="text-2xl font-black text-slate-800">{{ $hasil->count() }}</h3>
                </div>
                <div class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center text-slate-500">
                    <i class="fas fa-users"></i>
                </div>
            </div>

            <div
                class="bg-white p-5 rounded-2xl border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.03)] flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-emerald-500 uppercase tracking-wider mb-1">Diterima</p>
                    <h3 class="text-2xl font-black text-slate-800">
                        {{ $hasil->where('status_kelulusan', 'diterima')->count() }}</h3>
                </div>
                <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600">
                    <i class="fas fa-check"></i>
                </div>
            </div>

            <div
                class="bg-white p-5 rounded-2xl border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.03)] flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-amber-500 uppercase tracking-wider mb-1">Cadangan</p>
                    <h3 class="text-2xl font-black text-slate-800">
                        {{ $hasil->where('status_kelulusan', 'cadangan')->count() }}</h3>
                </div>
                <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center text-amber-600">
                    <i class="fas fa-clock"></i>
                </div>
            </div>

            <div
                class="bg-white p-5 rounded-2xl border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.03)] flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-rose-500 uppercase tracking-wider mb-1">Tidak Lulus</p>
                    <h3 class="text-2xl font-black text-slate-800">
                        {{ $hasil->where('status_kelulusan', 'tidak_diterima')->count() }}</h3>
                </div>
                <div class="w-10 h-10 rounded-xl bg-rose-50 flex items-center justify-center text-rose-600">
                    <i class="fas fa-times"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.03)] overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200">
                            <th
                                class="text-center py-4 px-6 text-xs font-bold text-slate-500 uppercase tracking-wider w-20">
                                Rank</th>
                            <th class="text-left py-4 px-6 text-xs font-bold text-slate-500 uppercase tracking-wider">
                                Identitas Pendaftar</th>
                            <th
                                class="text-center py-4 px-6 text-xs font-bold text-slate-500 uppercase tracking-wider w-32">
                                Nilai Akhir</th>
                            <th
                                class="text-center py-4 px-6 text-xs font-bold text-slate-500 uppercase tracking-wider w-40">
                                Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($hasil as $h)
                            <tr class="hover:bg-slate-50/50 transition group">
                                <td class="py-4 px-6 text-center">
                                    <div
                                        class="w-8 h-8 rounded-full bg-slate-100 border border-slate-200 text-slate-600 flex items-center justify-center font-bold mx-auto text-sm">
                                        {{ $h->ranking }}
                                    </div>
                                </td>

                                <td class="py-4 px-6">
                                    <div>
                                        <p class="text-sm font-bold text-slate-800">
                                            {{ $h->pendaftaran->pengguna->profil->nama_lengkap ?? $h->pendaftaran->pengguna->nama }}
                                        </p>
                                        <div class="flex items-center gap-2 mt-1">
                                            <span
                                                class="text-xs text-slate-500 bg-slate-100 px-2 py-0.5 rounded border border-slate-200 font-mono">
                                                {{ $h->pendaftaran->no_pendaftaran }}
                                            </span>
                                            <span class="text-[10px] text-slate-400">•
                                                {{ $h->pendaftaran->asal_sekolah }}</span>
                                        </div>
                                    </div>
                                </td>

                                <td class="py-4 px-6 text-center">
                                    <span
                                        class="text-lg font-bold text-slate-700">{{ number_format($h->nilai_akhir * 100, 2) }}</span>
                                </td>

                                <td class="py-4 px-6 text-center">
                                    @if ($h->status_kelulusan === 'diterima')
                                        <span
                                            class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-600 border border-emerald-100">
                                            Diterima
                                        </span>
                                    @elseif($h->status_kelulusan === 'cadangan')
                                        <span
                                            class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-600 border border-amber-100">
                                            Cadangan
                                        </span>
                                    @elseif($h->status_kelulusan === 'tidak_diterima')
                                        <span
                                            class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-rose-50 text-rose-600 border border-rose-100">
                                            Tidak Lulus
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-400 border border-slate-200">
                                            -
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    <div id="modalKelulusan" class="fixed inset-0 z-[100] hidden items-center justify-center px-4">
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity opacity-0" id="modalBackdrop"
            onclick="closeModalKelulusan()"></div>

        <div class="bg-white w-full max-w-lg p-0 rounded-2xl relative z-10 shadow-2xl transform scale-95 opacity-0 transition-all duration-300 overflow-hidden"
            id="modalContent">
            <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50">
                <h3 class="text-lg font-bold text-slate-800">Tentukan Kelulusan</h3>
                <button onclick="closeModalKelulusan()" class="text-slate-400 hover:text-slate-600 transition"><i
                        class="fas fa-times"></i></button>
            </div>

            <form id="formKelulusan" onsubmit="submitKelulusan(event)">
                <div class="p-6 space-y-6">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-3">Pilih Metode Penentuan</label>
                        <div class="grid grid-cols-2 gap-4">
                            <label class="cursor-pointer">
                                <input type="radio" name="metode" value="ranking" class="peer sr-only" checked
                                    onchange="toggleMetode()">
                                <div
                                    class="p-3 rounded-xl border border-slate-200 bg-white text-center peer-checked:border-orange-500 peer-checked:bg-orange-50 peer-checked:text-orange-700 transition">
                                    <span class="text-sm font-bold block">Ranking</span>
                                    <span class="text-[10px] text-slate-400">Berdasarkan kuota urutan</span>
                                </div>
                            </label>
                            <label class="cursor-pointer">
                                <input type="radio" name="metode" value="passing_grade" class="peer sr-only"
                                    onchange="toggleMetode()">
                                <div
                                    class="p-3 rounded-xl border border-slate-200 bg-white text-center peer-checked:border-blue-500 peer-checked:bg-blue-50 peer-checked:text-blue-700 transition">
                                    <span class="text-sm font-bold block">Passing Grade</span>
                                    <span class="text-[10px] text-slate-400">Berdasarkan batas nilai</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div id="rankingMethod" class="space-y-4">
                        <div
                            class="bg-blue-50 p-3 rounded-lg border border-blue-100 flex justify-between items-center text-sm text-blue-800">
                            <span>Total Peserta:</span>
                            <span class="font-bold">{{ $hasil->count() }}</span>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 mb-1">Batas Ranking Diterima</label>
                            <input type="number" name="batas_lulus_ranking"
                                class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-orange-500 transition"
                                placeholder="Misal: 50 (Ranking 1-50 Lulus)">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 mb-1">Batas Ranking Cadangan</label>
                            <input type="number" name="batas_cadangan_ranking"
                                class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-orange-500 transition"
                                placeholder="Misal: 70 (Ranking 51-70 Cadangan)">
                        </div>
                    </div>

                    <div id="passingGradeMethod" class="space-y-4 hidden">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 mb-1">Nilai Minimal Diterima
                                (0-100)</label>
                            <input type="number" name="batas_lulus_grade" step="0.01" max="100"
                                class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-orange-500 transition"
                                placeholder="Misal: 75">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 mb-1">Nilai Minimal Cadangan
                                (0-100)</label>
                            <input type="number" name="batas_cadangan_grade" step="0.01" max="100"
                                class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-orange-500 transition"
                                placeholder="Misal: 60">
                        </div>
                    </div>
                </div>

                <div class="px-6 pb-6 flex gap-3">
                    <button type="button" onclick="closeModalKelulusan()"
                        class="flex-1 py-2.5 bg-slate-100 text-slate-600 rounded-xl font-bold text-sm hover:bg-slate-200 transition">Batal</button>
                    <button type="submit"
                        class="flex-1 py-2.5 bg-orange-600 text-white rounded-xl font-bold text-sm hover:bg-orange-700 transition shadow-lg shadow-orange-600/20">Simpan
                        & Terapkan</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const modal = document.getElementById('modalKelulusan');
        const backdrop = document.getElementById('modalBackdrop');
        const content = document.getElementById('modalContent');

        // --- MODAL FUNCTIONS ---
        window.openModalKelulusan = function() {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            setTimeout(() => {
                backdrop.classList.remove('opacity-0');
                content.classList.remove('scale-95', 'opacity-0');
                content.classList.add('scale-100', 'opacity-100');
            }, 10);
        }

        window.closeModalKelulusan = function() {
            backdrop.classList.add('opacity-0');
            content.classList.remove('scale-100', 'opacity-100');
            content.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 300);
        }

        // --- TOGGLE METHOD ---
        window.toggleMetode = function() {
            const metode = document.querySelector('input[name="metode"]:checked').value;
            if (metode === 'ranking') {
                document.getElementById('rankingMethod').classList.remove('hidden');
                document.getElementById('passingGradeMethod').classList.add('hidden');
            } else {
                document.getElementById('rankingMethod').classList.add('hidden');
                document.getElementById('passingGradeMethod').classList.remove('hidden');
            }
        }

        // --- SUBMIT KELULUSAN ---
        window.submitKelulusan = async function(e) {
            e.preventDefault();

            const metode = document.querySelector('input[name="metode"]:checked').value;
            let batasLulus, batasCadangan;

            if (metode === 'ranking') {
                batasLulus = document.querySelector('input[name="batas_lulus_ranking"]').value;
                batasCadangan = document.querySelector('input[name="batas_cadangan_ranking"]').value;
            } else {
                batasLulus = document.querySelector('input[name="batas_lulus_grade"]').value;
                batasCadangan = document.querySelector('input[name="batas_cadangan_grade"]').value;
            }

            if (!batasLulus || !batasCadangan) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Data Kurang',
                    text: 'Mohon isi semua batas nilai/ranking.',
                    confirmButtonColor: '#f97316'
                });
                return;
            }

            try {
                Swal.fire({
                    title: 'Memproses...',
                    didOpen: () => Swal.showLoading()
                });

                const response = await fetch('{{ route('admin.perhitungan.tentukan-kelulusan') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        periode_id: {{ $periode->periode_id }},
                        metode: metode,
                        batas_lulus: batasLulus,
                        batas_cadangan: batasCadangan,
                    })
                });

                const data = await response.json();

                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: data.message,
                        confirmButtonColor: '#f97316'
                    }).then(() => {
                        closeModalKelulusan();
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: data.message,
                        confirmButtonColor: '#f97316'
                    });
                }
            } catch (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Terjadi kesalahan sistem',
                    confirmButtonColor: '#f97316'
                });
            }
        }

        // --- PUBLISH PENGUMUMAN ---
        window.publishPengumuman = function() {
            Swal.fire({
                title: 'Publish Pengumuman?',
                text: "Setelah dipublish, santri dapat melihat hasil kelulusan mereka.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#1e293b',
                cancelButtonColor: '#cbd5e1',
                confirmButtonText: 'Ya, Publish Sekarang',
                cancelButtonText: 'Batal'
            }).then(async (result) => {
                if (result.isConfirmed) {
                    try {
                        Swal.fire({
                            title: 'Memproses...',
                            didOpen: () => Swal.showLoading()
                        });
                        const response = await fetch(
                            '{{ route('admin.perhitungan.publish') }}?periode_id={{ $periode->periode_id }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': csrfToken
                                }
                            });
                        const data = await response.json();
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Terpublikasi',
                                text: data.message,
                                confirmButtonColor: '#f97316'
                            }).then(() => location.reload());
                        }
                    } catch (error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Gagal mempublish data',
                            confirmButtonColor: '#f97316'
                        });
                    }
                }
            });
        }
    </script>
@endsection
