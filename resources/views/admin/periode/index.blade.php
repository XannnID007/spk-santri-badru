@extends('layouts.dashboard')

@section('title', 'Kelola Periode')

@section('content')
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Periode Pendaftaran</h1>
            <p class="text-sm text-slate-500 mt-1">Atur jadwal dan kuota penerimaan santri baru.</p>
        </div>

        <button onclick="openModalAdd()"
            class="px-5 py-2.5 bg-orange-600 text-white rounded-xl hover:bg-orange-700 transition text-sm font-bold shadow-lg shadow-orange-600/20 flex items-center">
            <i class="fas fa-plus mr-2"></i> Tambah Periode
        </button>
    </div>

    <div class="grid grid-cols-1 gap-6">
        @forelse($periodes as $periode)
            <div
                class="bg-white rounded-2xl p-6 border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.03)] relative overflow-hidden transition hover:shadow-md">

                <div
                    class="absolute left-0 top-0 bottom-0 w-1.5 {{ $periode->status_aktif ? 'bg-emerald-500' : 'bg-slate-300' }}">
                </div>

                <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6 pl-4">

                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-3">
                            <h3 class="text-xl font-bold text-slate-800">{{ $periode->nama_periode }}</h3>
                            @if ($periode->status_aktif)
                                <span
                                    class="px-3 py-1 bg-emerald-50 text-emerald-600 border border-emerald-100 rounded-full text-xs font-bold flex items-center gap-1">
                                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span> Aktif
                                </span>
                            @else
                                <span
                                    class="px-3 py-1 bg-slate-100 text-slate-500 border border-slate-200 rounded-full text-xs font-bold">
                                    Nonaktif
                                </span>
                            @endif
                        </div>

                        <div class="flex flex-wrap gap-4 text-sm">
                            <div
                                class="flex items-center gap-2 px-3 py-1.5 bg-slate-50 rounded-lg border border-slate-100 text-slate-600">
                                <i class="far fa-calendar-alt text-orange-500"></i>
                                <span>{{ \Carbon\Carbon::parse($periode->tanggal_mulai)->format('d M Y') }} -
                                    {{ \Carbon\Carbon::parse($periode->tanggal_selesai)->format('d M Y') }}</span>
                            </div>
                            <div
                                class="flex items-center gap-2 px-3 py-1.5 bg-slate-50 rounded-lg border border-slate-100 text-slate-600">
                                <i class="fas fa-users text-blue-500"></i>
                                <span>Kuota: <strong>{{ $periode->kuota_santri }}</strong></span>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 w-full lg:w-auto">
                        <button
                            onclick="toggleStatus({{ $periode->periode_id }}, {{ $periode->status_aktif ? 'true' : 'false' }})"
                            class="flex-1 lg:flex-none px-4 py-2 rounded-xl text-sm font-bold border transition flex items-center justify-center gap-2
                            {{ $periode->status_aktif
                                ? 'bg-white border-slate-200 text-slate-500 hover:text-rose-600 hover:border-rose-200'
                                : 'bg-emerald-50 border-emerald-100 text-emerald-600 hover:bg-emerald-100' }}">
                            <i class="fas fa-power-off"></i>
                            {{ $periode->status_aktif ? 'Nonaktifkan' : 'Aktifkan' }}
                        </button>

                        <button onclick='openModalEdit({{ json_encode($periode) }})'
                            class="w-10 h-10 rounded-xl bg-white border border-slate-200 text-slate-500 hover:text-blue-600 hover:border-blue-200 hover:shadow-sm transition flex items-center justify-center">
                            <i class="fas fa-pen"></i>
                        </button>

                        <button onclick="deletePeriode({{ $periode->periode_id }})"
                            class="w-10 h-10 rounded-xl bg-white border border-slate-200 text-slate-500 hover:text-rose-600 hover:border-rose-200 hover:shadow-sm transition flex items-center justify-center">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-2xl p-12 text-center border border-slate-100 border-dashed">
                <div
                    class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-300">
                    <i class="far fa-calendar-times text-3xl"></i>
                </div>
                <h3 class="text-lg font-bold text-slate-800 mb-1">Belum Ada Periode</h3>
                <p class="text-sm text-slate-500 mb-6">Silakan buat periode pendaftaran baru untuk memulai.</p>
                <button onclick="openModalAdd()"
                    class="px-6 py-2.5 bg-slate-800 text-white rounded-xl text-sm font-bold hover:bg-slate-700 transition">
                    Buat Periode Baru
                </button>
            </div>
        @endforelse
    </div>

    <div id="modalPeriode" class="fixed inset-0 z-[100] hidden items-center justify-center px-4">
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity opacity-0" id="modalBackdrop"
            onclick="closeModal()"></div>

        <div class="bg-white w-full max-w-lg p-0 rounded-2xl relative z-10 shadow-2xl transform scale-95 opacity-0 transition-all duration-300 overflow-hidden"
            id="modalContent">
            <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50">
                <h3 class="text-lg font-bold text-slate-800" id="modalTitle">Tambah Periode</h3>
                <button onclick="closeModal()" class="text-slate-400 hover:text-slate-600 transition"><i
                        class="fas fa-times"></i></button>
            </div>

            <form id="formPeriode" onsubmit="submitPeriode(event)">
                <input type="hidden" id="periodeId">
                <input type="hidden" id="isEdit" value="0">

                <div class="p-6 space-y-5">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Nama Periode</label>
                        <input type="text" id="nama_periode" required placeholder="Contoh: Gelombang 1 Tahun 2025"
                            class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-orange-500 transition font-medium text-slate-700">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Tanggal Mulai</label>
                            <input type="date" id="tanggal_mulai" required
                                class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-orange-500 transition text-slate-700">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Tanggal Selesai</label>
                            <input type="date" id="tanggal_selesai" required
                                class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-orange-500 transition text-slate-700">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Kuota Santri</label>
                        <input type="number" id="kuota_santri" required min="1" placeholder="Contoh: 100"
                            class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-orange-500 transition text-slate-700">
                    </div>
                </div>

                <div class="px-6 pb-6 flex gap-3">
                    <button type="button" onclick="closeModal()"
                        class="flex-1 py-2.5 bg-slate-100 text-slate-600 rounded-xl font-bold text-sm hover:bg-slate-200 transition">Batal</button>
                    <button type="submit"
                        class="flex-1 py-2.5 bg-orange-600 text-white rounded-xl font-bold text-sm hover:bg-orange-700 transition shadow-lg shadow-orange-600/20">Simpan
                        Data</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const modal = document.getElementById('modalPeriode');
        const backdrop = document.getElementById('modalBackdrop');
        const content = document.getElementById('modalContent');

        // --- MODAL FUNCTIONS ---
        window.openModalAdd = function() {
            document.getElementById('modalTitle').textContent = 'Tambah Periode';
            document.getElementById('formPeriode').reset();
            document.getElementById('periodeId').value = '';
            document.getElementById('isEdit').value = '0';
            showModal();
        }

        window.openModalEdit = function(periode) {
            document.getElementById('modalTitle').textContent = 'Edit Periode';
            document.getElementById('periodeId').value = periode.periode_id;
            document.getElementById('isEdit').value = '1';
            document.getElementById('nama_periode').value = periode.nama_periode;
            document.getElementById('tanggal_mulai').value = periode.tanggal_mulai;
            document.getElementById('tanggal_selesai').value = periode.tanggal_selesai;
            document.getElementById('kuota_santri').value = periode.kuota_santri;
            showModal();
        }

        function showModal() {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            setTimeout(() => {
                backdrop.classList.remove('opacity-0');
                content.classList.remove('scale-95', 'opacity-0');
                content.classList.add('scale-100', 'opacity-100');
            }, 10);
        }

        window.closeModal = function() {
            backdrop.classList.add('opacity-0');
            content.classList.remove('scale-100', 'opacity-100');
            content.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 300);
        }

        // --- SUBMIT DATA ---
        window.submitPeriode = async function(e) {
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

                Swal.fire({
                    title: 'Menyimpan...',
                    didOpen: () => Swal.showLoading()
                });

                const response = await fetch(url, {
                    method: method,
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'X-HTTP-Method-Override': method // Penting untuk PUT via fetch
                    },
                    body: JSON.stringify(data)
                });

                const result = await response.json();

                if (data && result.success) {
                    Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: result.message,
                            confirmButtonColor: '#f97316'
                        })
                        .then(() => location.reload());
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: result.message,
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

        // --- TOGGLE STATUS ---
        window.toggleStatus = function(id, currentStatus) {
            // currentStatus: true (aktif) atau false (nonaktif)
            const actionText = currentStatus ? 'Nonaktifkan' : 'Aktifkan';
            const confirmColor = currentStatus ? '#ef4444' : '#10b981'; // Merah jika nonaktifkan, Hijau jika aktifkan

            Swal.fire({
                title: `${actionText} Periode?`,
                text: `Anda akan ${actionText.toLowerCase()} periode ini.`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: confirmColor,
                cancelButtonColor: '#cbd5e1',
                confirmButtonText: `Ya, ${actionText}`
            }).then(async (result) => {
                if (result.isConfirmed) {
                    try {
                        Swal.fire({
                            title: 'Memproses...',
                            didOpen: () => Swal.showLoading()
                        });

                        const response = await fetch(`/admin/periode/${id}/toggle-status`, {
                            method: 'PUT',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken
                            }
                        });

                        const data = await response.json();

                        if (data.success) {
                            Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: data.message,
                                    confirmButtonColor: '#f97316'
                                })
                                .then(() => location.reload());
                        }
                    } catch (error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Gagal mengubah status',
                            confirmButtonColor: '#f97316'
                        });
                    }
                }
            });
        }

        // --- DELETE PERIODE ---
        window.deletePeriode = function(id) {
            Swal.fire({
                title: 'Hapus Periode?',
                text: 'Data periode beserta pendaftar di dalamnya akan dihapus permanen!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#cbd5e1',
                confirmButtonText: 'Ya, Hapus'
            }).then(async (result) => {
                if (result.isConfirmed) {
                    try {
                        Swal.fire({
                            title: 'Menghapus...',
                            didOpen: () => Swal.showLoading()
                        });

                        const response = await fetch(`/admin/periode/${id}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken
                            }
                        });

                        const data = await response.json();

                        if (data.success) {
                            Swal.fire({
                                    icon: 'success',
                                    title: 'Terhapus',
                                    text: data.message,
                                    confirmButtonColor: '#f97316'
                                })
                                .then(() => location.reload());
                        }
                    } catch (error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Gagal menghapus data',
                            confirmButtonColor: '#f97316'
                        });
                    }
                }
            });
        }
    </script>
@endsection
