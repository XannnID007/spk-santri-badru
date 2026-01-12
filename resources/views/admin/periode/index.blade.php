@extends('layouts.dashboard')

@section('title', 'Kelola Periode')

@section('content')
    <div class="container mx-auto px-6 py-8">
        <!-- Header -->
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-white mb-2">
                    <i class="fas fa-calendar-alt mr-3"></i>Kelola Periode Pendaftaran
                </h1>
                <p class="text-gray-400">Atur periode penerimaan santri baru</p>
            </div>
            <button onclick="openModalAdd()"
                class="px-6 py-3 gradient-orange rounded-lg font-semibold hover:opacity-90 transition">
                <i class="fas fa-plus mr-2"></i>Tambah Periode
            </button>
        </div>

        <!-- Table Periode -->
        <div class="grid grid-cols-1 gap-6">
            @forelse($periodes as $periode)
                <div class="glass-dark rounded-xl p-6 hover:bg-gray-800/70 transition">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-3">
                                <h3 class="text-xl font-bold text-white">{{ $periode->nama_periode }}</h3>
                                @if ($periode->status_aktif)
                                    <span
                                        class="px-3 py-1 bg-green-500/20 text-green-400 rounded-full text-sm font-semibold">
                                        <i class="fas fa-check-circle mr-1"></i>Aktif
                                    </span>
                                @else
                                    <span class="px-3 py-1 bg-gray-500/20 text-gray-400 rounded-full text-sm">
                                        <i class="fas fa-times-circle mr-1"></i>Nonaktif
                                    </span>
                                @endif
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="glass-orange p-4 rounded-lg">
                                    <p class="text-sm text-gray-400 mb-1"><i class="fas fa-calendar-day mr-2"></i>Tanggal
                                        Mulai</p>
                                    <p class="text-white font-semibold">
                                        {{ \Carbon\Carbon::parse($periode->tanggal_mulai)->format('d F Y') }}</p>
                                </div>
                                <div class="glass-orange p-4 rounded-lg">
                                    <p class="text-sm text-gray-400 mb-1"><i class="fas fa-calendar-check mr-2"></i>Tanggal
                                        Selesai</p>
                                    <p class="text-white font-semibold">
                                        {{ \Carbon\Carbon::parse($periode->tanggal_selesai)->format('d F Y') }}</p>
                                </div>
                                <div class="glass-orange p-4 rounded-lg">
                                    <p class="text-sm text-gray-400 mb-1"><i class="fas fa-users mr-2"></i>Kuota Santri</p>
                                    <p class="text-white font-semibold">{{ $periode->kuota_santri }} Santri</p>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col gap-2 ml-4">
                            <button
                                onclick="toggleStatus({{ $periode->periode_id }}, {{ $periode->status_aktif ? 'false' : 'true' }})"
                                class="px-4 py-2 {{ $periode->status_aktif ? 'bg-yellow-500 hover:bg-yellow-600' : 'bg-green-500 hover:bg-green-600' }} rounded-lg text-sm font-semibold transition whitespace-nowrap">
                                <i class="fas fa-{{ $periode->status_aktif ? 'pause' : 'play' }} mr-1"></i>
                                {{ $periode->status_aktif ? 'Nonaktifkan' : 'Aktifkan' }}
                            </button>
                            <button onclick='openModalEdit({{ json_encode($periode) }})'
                                class="px-4 py-2 bg-blue-500 hover:bg-blue-600 rounded-lg text-sm font-semibold transition">
                                <i class="fas fa-edit mr-1"></i>Edit
                            </button>
                            <button onclick="deletePeriode({{ $periode->periode_id }})"
                                class="px-4 py-2 bg-red-500 hover:bg-red-600 rounded-lg text-sm font-semibold transition">
                                <i class="fas fa-trash mr-1"></i>Hapus
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="glass-dark rounded-xl p-12 text-center">
                    <i class="fas fa-calendar-times text-6xl text-gray-500 mb-4"></i>
                    <h3 class="text-2xl font-bold text-white mb-2">Belum Ada Periode</h3>
                    <p class="text-gray-400 mb-6">Silakan tambah periode pendaftaran terlebih dahulu</p>
                    <button onclick="openModalAdd()"
                        class="inline-block px-6 py-3 gradient-orange rounded-lg font-semibold hover:opacity-90 transition">
                        <i class="fas fa-plus mr-2"></i>Tambah Periode
                    </button>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Modal Add/Edit -->
    <div id="modalPeriode" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden items-center justify-center z-50"
        onclick="closeModal(event)">
        <div class="glass-dark rounded-2xl p-8 max-w-2xl w-full mx-4" onclick="event.stopPropagation()">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-2xl font-bold text-white" id="modalTitle">Tambah Periode</h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-white">
                    <i class="fas fa-times text-2xl"></i>
                </button>
            </div>

            <form id="formPeriode">
                <input type="hidden" id="periodeId">
                <input type="hidden" id="isEdit" value="0">

                <div class="space-y-4 mb-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-200 mb-2">Nama Periode *</label>
                        <input type="text" id="nama_periode" name="nama_periode" required
                            class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white focus:border-orange-500 focus:outline-none"
                            placeholder="Contoh: Pendaftaran Santri Baru 2025/2026">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-200 mb-2">Tanggal Mulai *</label>
                            <input type="date" id="tanggal_mulai" name="tanggal_mulai" required
                                class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white focus:border-orange-500 focus:outline-none">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-200 mb-2">Tanggal Selesai *</label>
                            <input type="date" id="tanggal_selesai" name="tanggal_selesai" required
                                class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white focus:border-orange-500 focus:outline-none">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-200 mb-2">Kuota Santri *</label>
                        <input type="number" id="kuota_santri" name="kuota_santri" required min="1"
                            class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white focus:border-orange-500 focus:outline-none"
                            placeholder="Contoh: 100">
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
    document.getElementById('modalTitle').textContent = 'Tambah Periode';
    document.getElementById('formPeriode').reset();
    document.getElementById('periodeId').value = '';
    document.getElementById('isEdit').value = '0';
    document.getElementById('modalPeriode').classList.remove('hidden');
    document.getElementById('modalPeriode').classList.add('flex');
    }

    function openModalEdit(periode) {
    document.getElementById('modalTitle').textContent = 'Edit Periode';
    document.getElementById('periodeId').value = periode.periode_id;
    document.getElementById('isEdit').value = '1';
    document.getElementById('nama_periode').value = periode.nama_periode;
    document.getElementById('tanggal_mulai').value = periode.tanggal_mulai;
    document.getElementById('tanggal_selesai').value = periode.tanggal_selesai;
    document.getElementById('kuota_santri').value = periode.kuota_santri;

    document.getElementById('modalPeriode').classList.remove('hidden');
    document.getElementById('modalPeriode').classList.add('flex');
    }

    function closeModal(event) {
    if (!event || event.target === event.currentTarget) {
    document.getElementById('modalPeriode').classList.add('hidden');
    document.getElementById('modalPeriode').classList.remove('flex');
    }
    }

    document.getElementById('formPeriode').addEventListener('submit', async function(e) {
    e.preventDefault();

    const isEdit = document.getElementById('isEdit').value === '1';
    const periodeId = document.getElementById('periodeId').value;

    const data = {
    nama_periode: document.getElementById('nama_periode').value,
    tanggal_mulai: document.getElementById('tanggal_mulai').value,
    tanggal_selesai: document.getElementById('tanggal_selesai').value,
    kuota_santri: parseInt(document.getElementById('kuota_santri').value),
    };

    try {
    let url = '{{ route('admin.periode.store') }}';
    let method = 'POST';

    if (isEdit) {
    url = `/admin/periode/${periodeId}`;
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

    function toggleStatus(id, newStatus) {
    const action = newStatus === 'true' ? 'mengaktifkan' : 'menonaktifkan';

    Swal.fire({
    title: `${newStatus === 'true' ? 'Aktifkan' : 'Nonaktifkan'} Periode?`,
    text: `Anda akan ${action} periode ini`,
    icon: 'question',
    showCancelButton: true,
    confirmButtonColor: '#ea580c',
    cancelButtonColor: '#6b7280',
    confirmButtonText: 'Ya!',
    cancelButtonText: 'Batal'
    }).then(async (result) => {
    if (result.isConfirmed) {
    try {
    const response = await fetch(`/admin/periode/${id}/toggle-status`, {
    method: 'PUT',
    headers: {
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

    function deletePeriode(id) {
    Swal.fire({
    title: 'Hapus Periode?',
    text: 'Data periode akan dihapus permanent!',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#ef4444',
    cancelButtonColor: '#6b7280',
    confirmButtonText: 'Ya, Hapus!',
    cancelButtonText: 'Batal'
    }).then(async (result) => {
    if (result.isConfirmed) {
    try {
    const response = await fetch(`/admin/periode/${id}`, {
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
