@extends('layouts.dashboard')

@section('title', 'Perhitungan SMART')

@section('content')
    <div class="container mx-auto px-6 py-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-white mb-2">
                <i class="fas fa-calculator mr-3"></i>Perhitungan Metode SMART
            </h1>
            <p class="text-gray-400">Simple Multi Attribute Rating Technique</p>
        </div>

        <!-- Pilih Periode -->
        <div class="glass-orange rounded-xl p-6 mb-8">
            <h3 class="text-xl font-semibold text-white mb-4">
                <i class="fas fa-filter mr-2"></i>Pilih Periode Pendaftaran
            </h3>
            <form id="periodeForm" class="flex items-end gap-4">
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-200 mb-2">Periode</label>
                    <select id="periodeSelect"
                        class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white focus:border-orange-500 focus:outline-none">
                        <option value="">Pilih Periode...</option>
                        @foreach ($periodes as $periode)
                            <option value="{{ $periode->periode_id }}"
                                {{ $periodeAktif && $periodeAktif->periode_id == $periode->periode_id ? 'selected' : '' }}>
                                {{ $periode->nama_periode }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type="button" onclick="loadInputNilai()"
                    class="px-6 py-3 gradient-orange rounded-lg font-semibold hover:opacity-90 transition">
                    <i class="fas fa-search mr-2"></i>Tampilkan
                </button>
            </form>
        </div>

        <!-- Menu Perhitungan -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6" id="menuPerhitungan" style="display: none;">
            <div class="glass-dark rounded-xl p-6 text-center hover:scale-105 transition transform cursor-pointer"
                onclick="loadInputNilai()">
                <div class="w-16 h-16 bg-blue-500/20 rounded-full mx-auto flex items-center justify-center mb-4">
                    <i class="fas fa-edit text-3xl text-blue-400"></i>
                </div>
                <h3 class="text-lg font-semibold text-white mb-2">Input Nilai Tes</h3>
                <p class="text-sm text-gray-400">Input nilai tes untuk setiap pendaftar</p>
            </div>

            <div class="glass-dark rounded-xl p-6 text-center hover:scale-105 transition transform cursor-pointer"
                onclick="hitungSMART()">
                <div class="w-16 h-16 bg-green-500/20 rounded-full mx-auto flex items-center justify-center mb-4">
                    <i class="fas fa-calculator text-3xl text-green-400"></i>
                </div>
                <h3 class="text-lg font-semibold text-white mb-2">Hitung & Ranking</h3>
                <p class="text-sm text-gray-400">Proses perhitungan SMART</p>
            </div>

            <div class="glass-dark rounded-xl p-6 text-center hover:scale-105 transition transform cursor-pointer"
                onclick="loadHasilPerhitungan()">
                <div class="w-16 h-16 bg-purple-500/20 rounded-full mx-auto flex items-center justify-center mb-4">
                    <i class="fas fa-trophy text-3xl text-purple-400"></i>
                </div>
                <h3 class="text-lg font-semibold text-white mb-2">Hasil & Kelulusan</h3>
                <p class="text-sm text-gray-400">Lihat hasil dan tentukan kelulusan</p>
            </div>
        </div>

        <!-- Content Area -->
        <div id="contentArea" class="mt-8"></div>
    </div>
@endsection

@section('scripts')
    let selectedPeriodeId = null;

    function loadInputNilai() {
    const periodeId = document.getElementById('periodeSelect').value;

    if (!periodeId) {
    Swal.fire({
    icon: 'warning',
    title: 'Perhatian',
    text: 'Pilih periode terlebih dahulu!',
    confirmButtonColor: '#ea580c',
    });
    return;
    }

    selectedPeriodeId = periodeId;
    document.getElementById('menuPerhitungan').style.display = 'grid';

    window.location.href = '{{ route('admin.perhitungan.input-nilai') }}?periode_id=' + periodeId;
    }

    function hitungSMART() {
    if (!selectedPeriodeId) {
    selectedPeriodeId = document.getElementById('periodeSelect').value;
    }

    if (!selectedPeriodeId) {
    Swal.fire({
    icon: 'warning',
    title: 'Perhatian',
    text: 'Pilih periode terlebih dahulu!',
    confirmButtonColor: '#ea580c',
    });
    return;
    }

    Swal.fire({
    title: 'Hitung SMART?',
    text: 'Sistem akan menghitung nilai akhir dan ranking untuk semua pendaftar',
    icon: 'question',
    showCancelButton: true,
    confirmButtonColor: '#ea580c',
    cancelButtonColor: '#6b7280',
    confirmButtonText: 'Ya, Hitung!',
    cancelButtonText: 'Batal',
    showLoaderOnConfirm: true,
    preConfirm: async () => {
    try {
    const response = await fetch('{{ route('admin.perhitungan.hitung-smart') }}?periode_id=' + selectedPeriodeId, {
    method: 'POST',
    headers: {
    'Content-Type': 'application/json',
    'X-CSRF-TOKEN': csrfToken,
    },
    });

    const data = await response.json();

    if (!data.success) {
    throw new Error(data.message);
    }

    return data;
    } catch (error) {
    Swal.showValidationMessage(`Request failed: ${error}`);
    }
    },
    allowOutsideClick: () => !Swal.isLoading()
    }).then((result) => {
    if (result.isConfirmed) {
    Swal.fire({
    icon: 'success',
    title: 'Berhasil!',
    text: result.value.message,
    confirmButtonColor: '#ea580c',
    }).then(() => {
    loadHasilPerhitungan();
    });
    }
    });
    }

    function loadHasilPerhitungan() {
    if (!selectedPeriodeId) {
    selectedPeriodeId = document.getElementById('periodeSelect').value;
    }

    if (!selectedPeriodeId) {
    Swal.fire({
    icon: 'warning',
    title: 'Perhatian',
    text: 'Pilih periode terlebih dahulu!',
    confirmButtonColor: '#ea580c',
    });
    return;
    }

    window.location.href = '{{ route('admin.perhitungan.hasil') }}?periode_id=' + selectedPeriodeId;
    }

    // Auto load menu if periode selected
    window.addEventListener('DOMContentLoaded', function() {
    const periodeSelect = document.getElementById('periodeSelect');
    if (periodeSelect.value) {
    selectedPeriodeId = periodeSelect.value;
    document.getElementById('menuPerhitungan').style.display = 'grid';
    }
    });
@endsection
