@extends('layouts.dashboard')

@section('title', 'Kelola Kriteria')

@section('content')
    <div class="container mx-auto px-6 py-8">
        <!-- Header -->
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-white mb-2">
                    <i class="fas fa-sliders-h mr-3"></i>Kelola Kriteria & Bobot
                </h1>
                <p class="text-gray-400">Atur kriteria penilaian metode SMART</p>
            </div>
            <button onclick="openModalAdd()"
                class="px-6 py-3 gradient-orange rounded-lg font-semibold hover:opacity-90 transition">
                <i class="fas fa-plus mr-2"></i>Tambah Kriteria
            </button>
        </div>

        <!-- Info Total Bobot -->
        <div class="glass-orange rounded-xl p-6 mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-white mb-1">Total Bobot Kriteria</h3>
                    <p class="text-sm text-gray-300">Pastikan total bobot = 100%</p>
                </div>
                <div class="text-right">
                    <p class="text-4xl font-bold {{ $totalBobot == 1 ? 'text-green-400' : 'text-red-400' }}">
                        {{ number_format($totalBobot * 100, 0) }}%
                    </p>
                    @if ($totalBobot == 1)
                        <span class="text-sm text-green-400"><i class="fas fa-check-circle mr-1"></i>Valid</span>
                    @else
                        <span class="text-sm text-red-400"><i class="fas fa-exclamation-circle mr-1"></i>Invalid</span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Table Kriteria -->
        <div class="glass-dark rounded-xl p-6">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-700">
                            <th class="text-left text-sm font-semibold text-gray-300 p-4">Kode</th>
                            <th class="text-left text-sm font-semibold text-gray-300 p-4">Nama Kriteria</th>
                            <th class="text-center text-sm font-semibold text-gray-300 p-4">Bobot</th>
                            <th class="text-center text-sm font-semibold text-gray-300 p-4">Jenis</th>
                            <th class="text-center text-sm font-semibold text-gray-300 p-4">Status</th>
                            <th class="text-center text-sm font-semibold text-gray-300 p-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kriterias as $kriteria)
                            <tr class="border-b border-gray-800 hover:bg-gray-800/50">
                                <td class="p-4">
                                    <span
                                        class="font-mono font-bold text-orange-500 text-lg">{{ $kriteria->kode_kriteria }}</span>
                                </td>
                                <td class="p-4">
                                    <p class="font-semibold text-white">{{ $kriteria->nama_kriteria }}</p>
                                </td>
                                <td class="p-4 text-center">
                                    <span class="text-2xl font-bold text-orange-500">{{ $kriteria->bobot * 100 }}%</span>
                                </td>
                                <td class="p-4 text-center">
                                    @if ($kriteria->jenis === 'benefit')
                                        <span class="px-3 py-1 bg-green-500/20 text-green-400 rounded-full text-sm">
                                            <i class="fas fa-arrow-up mr-1"></i>Benefit
                                        </span>
                                    @else
                                        <span class="px-3 py-1 bg-blue-500/20 text-blue-400 rounded-full text-sm">
                                            <i class="fas fa-arrow-down mr-1"></i>Cost
                                        </span>
                                    @endif
                                </td>
                                <td class="p-4 text-center">
                                    @if ($kriteria->status_aktif)
                                        <span class="px-3 py-1 bg-green-500/20 text-green-400 rounded-full text-sm">
                                            <i class="fas fa-check-circle mr-1"></i>Aktif
                                        </span>
                                    @else
                                        <span class="px-3 py-1 bg-gray-500/20 text-gray-400 rounded-full text-sm">
                                            <i class="fas fa-times-circle mr-1"></i>Nonaktif
                                        </span>
                                    @endif
                                </td>
                                <td class="p-4 text-center">
                                    <button onclick='openModalEdit({{ json_encode($kriteria) }})'
                                        class="px-3 py-2 bg-blue-500 hover:bg-blue-600 rounded-lg text-sm font-semibold transition mr-2">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button onclick="deleteKriteria({{ $kriteria->kriteria_id }})"
                                        class="px-3 py-2 bg-red-500 hover:bg-red-600 rounded-lg text-sm font-semibold transition">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-8 text-center text-gray-400">
                                    <i class="fas fa-inbox text-4xl mb-2"></i>
                                    <p>Belum ada kriteria</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Add/Edit -->
    <div id="modalKriteria" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden items-center justify-center z-50"
        onclick="closeModal(event)">
        <div class="glass-dark rounded-2xl p-8 max-w-2xl w-full mx-4" onclick="event.stopPropagation()">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-2xl font-bold text-white" id="modalTitle">Tambah Kriteria</h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-white">
                    <i class="fas fa-times text-2xl"></i>
                </button>
            </div>

            <form id="formKriteria">
                <input type="hidden" id="kriteriaId">
                <input type="hidden" id="isEdit" value="0">

                <div class="space-y-4 mb-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-200 mb-2">Kode Kriteria *</label>
                        <input type="text" id="kode_kriteria" name="kode_kriteria" required maxlength="5"
                            class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white focus:border-orange-500 focus:outline-none"
                            placeholder="C1, C2, C3...">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-200 mb-2">Nama Kriteria *</label>
                        <input type="text" id="nama_kriteria" name="nama_kriteria" required
                            class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white focus:border-orange-500 focus:outline-none"
                            placeholder="Contoh: Tes Akhlak & Kepribadian">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-200 mb-2">Bobot (0-1 atau 0-100%) *</label>
                        <input type="number" id="bobot" name="bobot" required step="0.01" min="0"
                            max="1"
                            class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white focus:border-orange-500 focus:outline-none"
                            placeholder="0.35 atau 35%">
                        <p class="text-xs text-gray-400 mt-1">Contoh: 0.35 untuk 35%, 0.25 untuk 25%</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-200 mb-2">Jenis Kriteria *</label>
                        <select id="jenis" name="jenis" required
                            class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white focus:border-orange-500 focus:outline-none">
                            <option value="">Pilih Jenis...</option>
                            <option value="benefit">Benefit (Semakin tinggi semakin baik)</option>
                            <option value="cost">Cost (Semakin rendah semakin baik)</option>
                        </select>
                    </div>

                    <div>
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" id="status_aktif" name="status_aktif" checked
                                class="w-4 h-4 text-orange-500 bg-gray-800 border-gray-700 rounded focus:ring-orange-500">
                            <span class="ml-2 text-sm text-gray-200">Kriteria Aktif</span>
                        </label>
                    </div>
                </div>

                <div class="flex justify-end space-x-4">
                    <button type="button" onclick="closeModal()"
                        class="px-6 py-3 bg-gray-600 hover:bg-gray-700 rounded-lg font-semibold transition">
                        <i class="fas fa-times mr-2"></i>Batal
                    </button>
                    <button type="submit"
                        class="px-6 py-3 gradient-orange rounded-lg font-semibold hover:opacity-90 transition">
                        <i class="fas fa-save mr-2"></i>Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    function openModalAdd() {
    document.getElementById('modalTitle').textContent = 'Tambah Kriteria';
    document.getElementById('formKriteria').reset();
    document.getElementById('kriteriaId').value = '';
    document.getElementById('isEdit').value = '0';
    document.getElementById('modalKriteria').classList.remove('hidden');
    document.getElementById('modalKriteria').classList.add('flex');
    }

    function openModalEdit(kriteria) {
    document.getElementById('modalTitle').textContent = 'Edit Kriteria';
    document.getElementById('kriteriaId').value = kriteria.kriteria_id;
    document.getElementById('isEdit').value = '1';
    document.getElementById('kode_kriteria').value = kriteria.kode_kriteria;
    document.getElementById('nama_kriteria').value = kriteria.nama_kriteria;
    document.getElementById('bobot').value = kriteria.bobot;
    document.getElementById('jenis').value = kriteria.jenis;
    document.getElementById('status_aktif').checked = kriteria.status_aktif;

    document.getElementById('modalKriteria').classList.remove('hidden');
    document.getElementById('modalKriteria').classList.add('flex');
    }

    function closeModal(event) {
    if (!event || event.target === event.currentTarget) {
    document.getElementById('modalKriteria').classList.add('hidden');
    document.getElementById('modalKriteria').classList.remove('flex');
    }
    }

    document.getElementById('formKriteria').addEventListener('submit', async function(e) {
    e.preventDefault();

    const isEdit = document.getElementById('isEdit').value === '1';
    const kriteriaId = document.getElementById('kriteriaId').value;

    const data = {
    kode_kriteria: document.getElementById('kode_kriteria').value,
    nama_kriteria: document.getElementById('nama_kriteria').value,
    bobot: parseFloat(document.getElementById('bobot').value),
    jenis: document.getElementById('jenis').value,
    status_aktif: document.getElementById('status_aktif').checked,
    };

    try {
    let url = '{{ route('admin.kriteria.store') }}';
    let method = 'POST';

    if (isEdit) {
    url = `/admin/kriteria/${kriteriaId}`;
    method = 'PUT';
    }

    const response = await fetch(url, {
    method: method,
    headers: {
    'Content-Type': 'application/json',
    'X-CSRF-TOKEN': csrfToken,
    'X-HTTP-Method-Override': method
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

    function deleteKriteria(id) {
    Swal.fire({
    title: 'Hapus Kriteria?',
    text: 'Data ini akan dihapus permanent!',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#ef4444',
    cancelButtonColor: '#6b7280',
    confirmButtonText: 'Ya, Hapus!',
    cancelButtonText: 'Batal'
    }).then(async (result) => {
    if (result.isConfirmed) {
    try {
    const response = await fetch(`/admin/kriteria/${id}`, {
    method: 'DELETE',
    headers: {
    'X-CSRF-TOKEN': csrfToken,
    }
    });

    const data = await response.json();

    if (data.success) {
    Swal.fire({
    icon: 'success',
    title: 'Terhapus!',
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
