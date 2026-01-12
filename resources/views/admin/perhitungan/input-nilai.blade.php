@extends('layouts.dashboard')

@section('title', 'Input Nilai Tes')

@section('content')
    <div class="container mx-auto px-6 py-8">
        <!-- Header -->
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-white mb-2">
                    <i class="fas fa-edit mr-3"></i>Input Nilai Tes
                </h1>
                <p class="text-gray-400">{{ $periode->nama_periode }}</p>
            </div>
            <a href="{{ route('admin.perhitungan') }}"
                class="px-6 py-3 glass-orange rounded-lg hover:bg-orange-500/20 transition">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>

        @if ($pendaftarans->count() == 0)
            <div class="glass-dark rounded-xl p-12 text-center">
                <i class="fas fa-inbox text-6xl text-gray-500 mb-4"></i>
                <h3 class="text-2xl font-bold text-white mb-2">Tidak Ada Data</h3>
                <p class="text-gray-400">Belum ada pendaftar yang diverifikasi untuk periode ini</p>
            </div>
        @else
            <!-- Info Kriteria -->
            <div class="glass-orange rounded-xl p-6 mb-6">
                <h3 class="text-lg font-semibold text-white mb-4">
                    <i class="fas fa-info-circle mr-2"></i>Kriteria Penilaian
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    @foreach ($kriterias as $kriteria)
                        <div class="glass-dark p-4 rounded-lg">
                            <p class="text-sm text-gray-400">{{ $kriteria->kode_kriteria }}</p>
                            <p class="font-semibold text-white">{{ $kriteria->nama_kriteria }}</p>
                            <p class="text-sm text-orange-500">Bobot: {{ $kriteria->bobot * 100 }}%</p>
                            @if ($kriteria->kode_kriteria === 'C3')
                                <p class="text-xs text-gray-500 mt-1">* Auto dari profil</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Table Pendaftar -->
            <div class="glass-dark rounded-xl p-6">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-700">
                                <th class="text-left text-sm font-semibold text-gray-300 p-4">No</th>
                                <th class="text-left text-sm font-semibold text-gray-300 p-4">No. Pendaftaran</th>
                                <th class="text-left text-sm font-semibold text-gray-300 p-4">Nama</th>
                                <th class="text-center text-sm font-semibold text-gray-300 p-4">Status Nilai</th>
                                <th class="text-center text-sm font-semibold text-gray-300 p-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pendaftarans as $index => $pendaftaran)
                                <tr class="border-b border-gray-800 hover:bg-gray-800/50">
                                    <td class="p-4 text-gray-300">{{ $index + 1 }}</td>
                                    <td class="p-4">
                                        <span class="font-mono text-orange-500">{{ $pendaftaran->no_pendaftaran }}</span>
                                    </td>
                                    <td class="p-4">
                                        <p class="font-semibold text-white">
                                            {{ $pendaftaran->pengguna->profil->nama_lengkap ?? '-' }}</p>
                                        <p class="text-sm text-gray-400">{{ $pendaftaran->asal_sekolah }}</p>
                                    </td>
                                    <td class="p-4 text-center">
                                        @php
                                            $totalNilai = $pendaftaran->nilaiTes->count();
                                            $expectedNilai = $kriterias->where('kode_kriteria', '!=', 'C3')->count();
                                        @endphp
                                        @if ($totalNilai >= $expectedNilai)
                                            <span class="px-3 py-1 bg-green-500/20 text-green-400 rounded-full text-sm">
                                                <i class="fas fa-check-circle mr-1"></i>Lengkap
                                            </span>
                                        @else
                                            <span class="px-3 py-1 bg-yellow-500/20 text-yellow-400 rounded-full text-sm">
                                                <i
                                                    class="fas fa-exclamation-circle mr-1"></i>{{ $totalNilai }}/{{ $expectedNilai }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="p-4 text-center">
                                        <button
                                            onclick="openModalInput({{ $pendaftaran->pendaftaran_id }}, '{{ $pendaftaran->pengguna->profil->nama_lengkap ?? '' }}', {{ json_encode($pendaftaran->nilaiTes) }})"
                                            class="px-4 py-2 bg-blue-500 hover:bg-blue-600 rounded-lg text-sm font-semibold transition">
                                            <i class="fas fa-edit mr-1"></i>Input Nilai
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>

    <!-- Modal Input Nilai -->
    <div id="modalInput" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden items-center justify-center z-50"
        onclick="closeModalInput(event)">
        <div class="glass-dark rounded-2xl p-8 max-w-2xl w-full mx-4" onclick="event.stopPropagation()">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-2xl font-bold text-white">Input Nilai Tes</h3>
                    <p class="text-gray-400" id="modalNama"></p>
                </div>
                <button onclick="closeModalInput()" class="text-gray-400 hover:text-white">
                    <i class="fas fa-times text-2xl"></i>
                </button>
            </div>

            <form id="formNilai">
                <input type="hidden" id="pendaftaranId">

                <div class="space-y-4 mb-6">
                    @foreach ($kriterias as $kriteria)
                        @if ($kriteria->kode_kriteria !== 'C3')
                            <div>
                                <label class="block text-sm font-medium text-gray-200 mb-2">
                                    {{ $kriteria->nama_kriteria }}
                                    <span class="text-orange-500">(Bobot: {{ $kriteria->bobot * 100 }}%)</span>
                                </label>
                                <input type="number" name="nilai[{{ $kriteria->kriteria_id }}]" min="0"
                                    max="100" step="0.01" required
                                    class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white focus:border-orange-500 focus:outline-none"
                                    placeholder="0 - 100">
                            </div>
                        @else
                            <div class="glass-orange p-4 rounded-lg">
                                <p class="text-sm text-gray-300 mb-1">{{ $kriteria->nama_kriteria }}</p>
                                <p class="text-xs text-gray-400">Data diambil otomatis dari profil pendaftar</p>
                            </div>
                        @endif
                    @endforeach
                </div>

                <div class="flex justify-end space-x-4">
                    <button type="button" onclick="closeModalInput()"
                        class="px-6 py-3 bg-gray-600 hover:bg-gray-700 rounded-lg font-semibold transition">
                        <i class="fas fa-times mr-2"></i>Batal
                    </button>
                    <button type="submit"
                        class="px-6 py-3 gradient-orange rounded-lg font-semibold hover:opacity-90 transition">
                        <i class="fas fa-save mr-2"></i>Simpan Nilai
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    function openModalInput(pendaftaranId, nama, existingNilai) {
    document.getElementById('pendaftaranId').value = pendaftaranId;
    document.getElementById('modalNama').textContent = nama;

    // Reset form
    document.getElementById('formNilai').reset();

    // Fill existing nilai if any
    if (existingNilai && existingNilai.length > 0) {
    existingNilai.forEach(nilai => {
    const input = document.querySelector(`input[name="nilai[${nilai.kriteria_id}]"]`);
    if (input) {
    input.value = nilai.nilai;
    }
    });
    }

    document.getElementById('modalInput').classList.remove('hidden');
    document.getElementById('modalInput').classList.add('flex');
    }

    function closeModalInput(event) {
    if (!event || event.target === event.currentTarget) {
    document.getElementById('modalInput').classList.add('hidden');
    document.getElementById('modalInput').classList.remove('flex');
    }
    }

    document.getElementById('formNilai').addEventListener('submit', async function(e) {
    e.preventDefault();

    const pendaftaranId = document.getElementById('pendaftaranId').value;
    const formData = new FormData(this);

    const data = {
    pendaftaran_id: pendaftaranId,
    nilai: {}
    };

    formData.forEach((value, key) => {
    const match = key.match(/nilai\[(\d+)\]/);
    if (match) {
    data.nilai[match[1]] = value;
    }
    });

    try {
    const response = await fetch('{{ route('admin.perhitungan.simpan-nilai') }}', {
    method: 'POST',
    headers: {
    'Content-Type': 'application/json',
    'X-CSRF-TOKEN': csrfToken,
    },
    body: JSON.stringify(data)
    });

    const result = await response.json();

    if (result.success) {
    Swal.fire({
    icon: 'success',
    title: 'Berhasil!',
    text: result.message,
    confirmButtonColor: '#ea580c',
    }).then(() => {
    closeModalInput();
    location.reload();
    });
    } else {
    Swal.fire({
    icon: 'error',
    title: 'Gagal!',
    text: result.message,
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
@endsection
