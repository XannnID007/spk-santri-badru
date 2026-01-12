@extends('layouts.dashboard')

@section('title', 'Hasil Perhitungan SMART')

@section('content')
    <div class="container mx-auto px-6 py-8">
        <!-- Header -->
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-white mb-2">
                    <i class="fas fa-trophy mr-3"></i>Hasil Perhitungan & Ranking
                </h1>
                <p class="text-gray-400">{{ $periode->nama_periode }}</p>
            </div>
            <a href="{{ route('admin.perhitungan') }}"
                class="px-6 py-3 glass-orange rounded-lg hover:bg-orange-500/20 transition">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>

        @if ($hasil->count() == 0)
            <div class="glass-dark rounded-xl p-12 text-center">
                <i class="fas fa-calculator text-6xl text-gray-500 mb-4"></i>
                <h3 class="text-2xl font-bold text-white mb-2">Belum Ada Perhitungan</h3>
                <p class="text-gray-400 mb-6">Silakan hitung nilai SMART terlebih dahulu</p>
                <a href="{{ route('admin.perhitungan') }}"
                    class="inline-block px-6 py-3 gradient-orange rounded-lg font-semibold hover:opacity-90 transition">
                    <i class="fas fa-calculator mr-2"></i>Hitung Sekarang
                </a>
            </div>
        @else
            <!-- Statistik Hasil -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div class="glass-orange p-6 rounded-xl text-center">
                    <i class="fas fa-users text-3xl text-orange-500 mb-2"></i>
                    <h3 class="text-3xl font-bold text-white">{{ $hasil->count() }}</h3>
                    <p class="text-gray-300">Total</p>
                </div>
                <div class="glass-dark p-6 rounded-xl text-center">
                    <i class="fas fa-check-circle text-3xl text-green-400 mb-2"></i>
                    <h3 class="text-3xl font-bold text-white">{{ $hasil->where('status_kelulusan', 'diterima')->count() }}
                    </h3>
                    <p class="text-gray-300">Diterima</p>
                </div>
                <div class="glass-dark p-6 rounded-xl text-center">
                    <i class="fas fa-exclamation-circle text-3xl text-yellow-400 mb-2"></i>
                    <h3 class="text-3xl font-bold text-white">{{ $hasil->where('status_kelulusan', 'cadangan')->count() }}
                    </h3>
                    <p class="text-gray-300">Cadangan</p>
                </div>
                <div class="glass-dark p-6 rounded-xl text-center">
                    <i class="fas fa-times-circle text-3xl text-red-400 mb-2"></i>
                    <h3 class="text-3xl font-bold text-white">
                        {{ $hasil->where('status_kelulusan', 'tidak_diterima')->count() }}</h3>
                    <p class="text-gray-300">Ditolak</p>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="glass-orange rounded-xl p-6 mb-6">
                <div class="flex flex-wrap items-center gap-4">
                    <button onclick="openModalKelulusan()"
                        class="px-6 py-3 bg-blue-500 hover:bg-blue-600 rounded-lg font-semibold transition">
                        <i class="fas fa-clipboard-check mr-2"></i>Tentukan Kelulusan
                    </button>

                    @php
                        $hasStatus = $hasil->whereNotNull('status_kelulusan')->count() > 0;
                        $isPublished = $hasil->where('is_published', true)->count() > 0;
                    @endphp

                    @if ($hasStatus && !$isPublished)
                        <button onclick="publishPengumuman()"
                            class="px-6 py-3 gradient-orange rounded-lg font-semibold hover:opacity-90 transition">
                            <i class="fas fa-bullhorn mr-2"></i>Publish Pengumuman
                        </button>
                    @endif

                    @if ($isPublished)
                        <span class="px-4 py-2 bg-green-500/20 text-green-400 rounded-lg font-semibold">
                            <i class="fas fa-check-circle mr-2"></i>Sudah Dipublish
                        </span>
                    @endif
                </div>
            </div>

            <!-- Table Hasil -->
            <div class="glass-dark rounded-xl p-6">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-700">
                                <th class="text-center text-sm font-semibold text-gray-300 p-4">Rank</th>
                                <th class="text-left text-sm font-semibold text-gray-300 p-4">No. Pendaftaran</th>
                                <th class="text-left text-sm font-semibold text-gray-300 p-4">Nama</th>
                                <th class="text-center text-sm font-semibold text-gray-300 p-4">Nilai Akhir</th>
                                <th class="text-center text-sm font-semibold text-gray-300 p-4">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($hasil as $h)
                                <tr class="border-b border-gray-800 hover:bg-gray-800/50">
                                    <td class="p-4 text-center">
                                        @if ($h->ranking <= 3)
                                            <div
                                                class="inline-flex items-center justify-center w-10 h-10 rounded-full
                                            {{ $h->ranking == 1 ? 'bg-yellow-500' : ($h->ranking == 2 ? 'bg-gray-400' : 'bg-orange-600') }}">
                                                <span class="font-bold text-white">{{ $h->ranking }}</span>
                                            </div>
                                        @else
                                            <span class="text-2xl font-bold text-gray-400">{{ $h->ranking }}</span>
                                        @endif
                                    </td>
                                    <td class="p-4">
                                        <span
                                            class="font-mono text-orange-500">{{ $h->pendaftaran->no_pendaftaran }}</span>
                                    </td>
                                    <td class="p-4">
                                        <p class="font-semibold text-white">
                                            {{ $h->pendaftaran->pengguna->profil->nama_lengkap ?? '-' }}</p>
                                        <p class="text-sm text-gray-400">{{ $h->pendaftaran->asal_sekolah }}</p>
                                    </td>
                                    <td class="p-4 text-center">
                                        <span
                                            class="text-2xl font-bold text-orange-500">{{ number_format($h->nilai_akhir * 100, 2) }}</span>
                                    </td>
                                    <td class="p-4 text-center">
                                        @if ($h->status_kelulusan === 'diterima')
                                            <span
                                                class="px-3 py-1 bg-green-500/20 text-green-400 rounded-full text-sm font-semibold">
                                                <i class="fas fa-check-circle mr-1"></i>DITERIMA
                                            </span>
                                        @elseif($h->status_kelulusan === 'cadangan')
                                            <span
                                                class="px-3 py-1 bg-yellow-500/20 text-yellow-400 rounded-full text-sm font-semibold">
                                                <i class="fas fa-exclamation-circle mr-1"></i>CADANGAN
                                            </span>
                                        @elseif($h->status_kelulusan === 'tidak_diterima')
                                            <span
                                                class="px-3 py-1 bg-red-500/20 text-red-400 rounded-full text-sm font-semibold">
                                                <i class="fas fa-times-circle mr-1"></i>TIDAK DITERIMA
                                            </span>
                                        @else
                                            <span class="px-3 py-1 bg-gray-500/20 text-gray-400 rounded-full text-sm">
                                                <i class="fas fa-minus-circle mr-1"></i>Belum Ditentukan
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
    </div>

    <!-- Modal Tentukan Kelulusan -->
    <div id="modalKelulusan" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden items-center justify-center z-50"
        onclick="closeModalKelulusan(event)">
        <div class="glass-dark rounded-2xl p-8 max-w-2xl w-full mx-4" onclick="event.stopPropagation()">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-2xl font-bold text-white">Tentukan Kelulusan</h3>
                    <p class="text-gray-400">Atur batas kelulusan santri baru</p>
                </div>
                <button onclick="closeModalKelulusan()" class="text-gray-400 hover:text-white">
                    <i class="fas fa-times text-2xl"></i>
                </button>
            </div>

            <form id="formKelulusan">
                <div class="space-y-6 mb-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-200 mb-2">Metode Penentuan</label>
                        <select id="metode" name="metode" required onchange="toggleMetode()"
                            class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white focus:border-orange-500 focus:outline-none">
                            <option value="ranking">Berdasarkan Ranking</option>
                            <option value="passing_grade">Berdasarkan Passing Grade</option>
                        </select>
                    </div>

                    <div id="rankingMethod">
                        <div class="glass-orange p-4 rounded-lg mb-4">
                            <p class="text-sm text-gray-300">Total Pendaftar: <span
                                    class="font-bold text-white">{{ $hasil->count() }}</span></p>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-200 mb-2">
                                Batas Ranking DITERIMA (1 - ...)
                            </label>
                            <input type="number" name="batas_lulus_ranking" min="1" max="{{ $hasil->count() }}"
                                class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white focus:border-orange-500 focus:outline-none"
                                placeholder="Contoh: 50">
                            <p class="text-xs text-gray-400 mt-1">Ranking 1 - N akan diterima</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-200 mb-2">
                                Batas Ranking CADANGAN (sampai ...)
                            </label>
                            <input type="number" name="batas_cadangan_ranking" min="1"
                                max="{{ $hasil->count() }}"
                                class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white focus:border-orange-500 focus:outline-none"
                                placeholder="Contoh: 70">
                            <p class="text-xs text-gray-400 mt-1">Ranking N+1 - M akan masuk cadangan</p>
                        </div>
                    </div>

                    <div id="passingGradeMethod" style="display: none;">
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-200 mb-2">
                                Passing Grade DITERIMA (0-100)
                            </label>
                            <input type="number" name="batas_lulus_grade" min="0" max="100" step="0.01"
                                class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white focus:border-orange-500 focus:outline-none"
                                placeholder="Contoh: 75">
                            <p class="text-xs text-gray-400 mt-1">Nilai ≥ N akan diterima</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-200 mb-2">
                                Passing Grade CADANGAN (0-100)
                            </label>
                            <input type="number" name="batas_cadangan_grade" min="0" max="100"
                                step="0.01"
                                class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white focus:border-orange-500 focus:outline-none"
                                placeholder="Contoh: 60">
                            <p class="text-xs text-gray-400 mt-1">Nilai N ≤ X < M akan masuk cadangan</p>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end space-x-4">
                    <button type="button" onclick="closeModalKelulusan()"
                        class="px-6 py-3 bg-gray-600 hover:bg-gray-700 rounded-lg font-semibold transition">
                        <i class="fas fa-times mr-2"></i>Batal
                    </button>
                    <button type="submit"
                        class="px-6 py-3 gradient-orange rounded-lg font-semibold hover:opacity-90 transition">
                        <i class="fas fa-check mr-2"></i>Terapkan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    function openModalKelulusan() {
    document.getElementById('modalKelulusan').classList.remove('hidden');
    document.getElementById('modalKelulusan').classList.add('flex');
    }

    function closeModalKelulusan(event) {
    if (!event || event.target === event.currentTarget) {
    document.getElementById('modalKelulusan').classList.add('hidden');
    document.getElementById('modalKelulusan').classList.remove('flex');
    }
    }

    function toggleMetode() {
    const metode = document.getElementById('metode').value;
    const rankingMethod = document.getElementById('rankingMethod');
    const passingGradeMethod = document.getElementById('passingGradeMethod');

    if (metode === 'ranking') {
    rankingMethod.style.display = 'block';
    passingGradeMethod.style.display = 'none';
    } else {
    rankingMethod.style.display = 'none';
    passingGradeMethod.style.display = 'block';
    }
    }

    document.getElementById('formKelulusan').addEventListener('submit', async function(e) {
    e.preventDefault();

    const metode = document.getElementById('metode').value;
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
    title: 'Perhatian',
    text: 'Harap isi semua field!',
    confirmButtonColor: '#ea580c',
    });
    return;
    }

    try {
    const response = await fetch('{{ route('admin.perhitungan.tentukan-kelulusan') }}', {
    method: 'POST',
    headers: {
    'Content-Type': 'application/json',
    'X-CSRF-TOKEN': csrfToken,
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
    title: 'Berhasil!',
    text: data.message,
    confirmButtonColor: '#ea580c',
    }).then(() => {
    closeModalKelulusan();
    location.reload();
    });
    } else {
    Swal.fire({
    icon: 'error',
    title: 'Gagal!',
    text: data.message,
    confirmButtonColor: '#ea580c',
    });
    }
    } catch (error) {
    Swal.fire({
    icon: 'error',
    title: 'Error!',
    text: 'Terjadi kesalahan sistem',
    confirmButtonColor: '#ea580c',
    });
    }
    });

    function publishPengumuman() {
    Swal.fire({
    title: 'Publish Pengumuman?',
    html: `
    <p>Pengumuman akan ditampilkan ke semua pendaftar.</p>
    <p class="text-red-500 mt-2">Data tidak dapat diubah setelah dipublish!</p>
    `,
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#ea580c',
    cancelButtonColor: '#6b7280',
    confirmButtonText: 'Ya, Publish!',
    cancelButtonText: 'Batal'
    }).then(async (result) => {
    if (result.isConfirmed) {
    try {
    const response = await fetch('{{ route('admin.perhitungan.publish') }}?periode_id={{ $periode->periode_id }}', {
    method: 'POST',
    headers: {
    'Content-Type': 'application/json',
    'X-CSRF-TOKEN': csrfToken,
    }
    });

    const data = await response.json();

    if (data.success) {
    Swal.fire({
    icon: 'success',
    title: 'Berhasil!',
    text: data.message,
    confirmButtonColor: '#ea580c',
    }).then(() => {
    location.reload();
    });
    } else {
    Swal.fire({
    icon: 'error',
    title: 'Gagal!',
    text: data.message,
    confirmButtonColor: '#ea580c',
    });
    }
    } catch (error) {
    Swal.fire({
    icon: 'error',
    title: 'Error!',
    text: 'Terjadi kesalahan sistem',
    confirmButtonColor: '#ea580c',
    });
    }
    }
    });
    }
@endsection
