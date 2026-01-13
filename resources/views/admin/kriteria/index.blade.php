@extends('layouts.dashboard')

@section('title', 'Kelola Kriteria')

@section('content')
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Kriteria & Bobot</h1>
            <p class="text-sm text-slate-500 mt-1">Kelola variabel penilaian untuk metode SMART.</p>
        </div>

        <button onclick="openModalAdd()"
            class="px-5 py-2.5 bg-orange-600 text-white rounded-xl hover:bg-orange-700 transition text-sm font-bold shadow-lg shadow-orange-600/20 flex items-center">
            <i class="fas fa-plus mr-2"></i> Tambah Kriteria
        </button>
    </div>

    <div
        class="bg-white rounded-2xl p-6 border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.03)] mb-8 flex flex-col md:flex-row items-center justify-between gap-6 relative overflow-hidden">
        <div class="absolute left-0 top-0 bottom-0 w-1 {{ $totalBobot == 1 ? 'bg-emerald-500' : 'bg-rose-500' }}"></div>

        <div class="flex items-center gap-4 z-10">
            <div
                class="w-12 h-12 rounded-full {{ $totalBobot == 1 ? 'bg-emerald-50 text-emerald-600' : 'bg-rose-50 text-rose-600' }} flex items-center justify-center text-xl">
                <i class="fas {{ $totalBobot == 1 ? 'fa-balance-scale' : 'fa-exclamation-triangle' }}"></i>
            </div>
            <div>
                <h3 class="text-lg font-bold text-slate-800">Total Bobot Saat Ini</h3>
                <p class="text-sm text-slate-500">Jumlah keseluruhan bobot harus tepat 100% (1.0)</p>
            </div>
        </div>

        <div class="text-right z-10">
            <div class="flex items-center justify-end gap-3 mb-1">
                <span class="text-3xl font-black {{ $totalBobot == 1 ? 'text-emerald-600' : 'text-rose-600' }}">
                    {{ number_format($totalBobot * 100, 0) }}%
                </span>
                @if ($totalBobot == 1)
                    <span
                        class="px-2.5 py-1 bg-emerald-100 text-emerald-700 text-xs font-bold rounded-lg border border-emerald-200">
                        VALID
                    </span>
                @else
                    <span class="px-2.5 py-1 bg-rose-100 text-rose-700 text-xs font-bold rounded-lg border border-rose-200">
                        INVALID
                    </span>
                @endif
            </div>
            @if ($totalBobot != 1)
                <p class="text-xs text-rose-500 font-medium">Harap sesuaikan kembali bobot kriteria.</p>
            @endif
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-[0_4px_20px_rgba(0,0,0,0.03)] border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200">
                        <th class="text-left py-4 px-6 text-xs font-bold text-slate-500 uppercase tracking-wider w-24">Kode
                        </th>
                        <th class="text-left py-4 px-6 text-xs font-bold text-slate-500 uppercase tracking-wider">Nama
                            Kriteria</th>
                        <th class="text-center py-4 px-6 text-xs font-bold text-slate-500 uppercase tracking-wider w-32">
                            Bobot</th>
                        <th class="text-center py-4 px-6 text-xs font-bold text-slate-500 uppercase tracking-wider w-32">
                            Jenis</th>
                        <th class="text-center py-4 px-6 text-xs font-bold text-slate-500 uppercase tracking-wider w-32">
                            Status</th>
                        <th class="text-right py-4 px-6 text-xs font-bold text-slate-500 uppercase tracking-wider w-40">Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($kriterias as $kriteria)
                        <tr class="hover:bg-slate-50/50 transition-colors group">
                            <td class="py-4 px-6">
                                <span
                                    class="font-mono font-bold text-slate-700 bg-slate-100 px-2 py-1 rounded text-xs border border-slate-200">
                                    {{ $kriteria->kode_kriteria }}
                                </span>
                            </td>
                            <td class="py-4 px-6">
                                <p class="font-bold text-slate-700 text-sm">{{ $kriteria->nama_kriteria }}</p>
                            </td>
                            <td class="py-4 px-6 text-center">
                                <span class="font-bold text-slate-700">{{ $kriteria->bobot * 100 }}%</span>
                            </td>
                            <td class="py-4 px-6 text-center">
                                @if ($kriteria->jenis === 'benefit')
                                    <span
                                        class="inline-flex items-center px-2.5 py-1 rounded-lg bg-blue-50 text-blue-600 border border-blue-100 text-xs font-bold">
                                        <i class="fas fa-arrow-up mr-1.5 text-[10px]"></i> Benefit
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center px-2.5 py-1 rounded-lg bg-amber-50 text-amber-600 border border-amber-100 text-xs font-bold">
                                        <i class="fas fa-arrow-down mr-1.5 text-[10px]"></i> Cost
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-center">
                                @if ($kriteria->status_aktif)
                                    <span
                                        class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-600 border border-emerald-100">
                                        Aktif
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-500 border border-slate-200">
                                        Nonaktif
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <button onclick='openModalEdit({{ json_encode($kriteria) }})'
                                        class="w-8 h-8 rounded-lg bg-slate-50 border border-slate-200 text-slate-500 hover:bg-white hover:border-blue-200 hover:text-blue-600 hover:shadow-md transition-all flex items-center justify-center">
                                        <i class="fas fa-pen text-xs"></i>
                                    </button>
                                    <button onclick="deleteKriteria({{ $kriteria->kriteria_id }})"
                                        class="w-8 h-8 rounded-lg bg-slate-50 border border-slate-200 text-slate-500 hover:bg-white hover:border-rose-200 hover:text-rose-600 hover:shadow-md transition-all flex items-center justify-center">
                                        <i class="fas fa-trash text-xs"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center">
                                <div class="flex flex-col items-center justify-center text-slate-400">
                                    <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-3">
                                        <i class="fas fa-layer-group text-2xl text-slate-300"></i>
                                    </div>
                                    <p class="text-sm font-medium text-slate-500">Belum ada kriteria</p>
                                    <p class="text-xs text-slate-400 mt-1">Silakan tambahkan kriteria baru</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div id="modalKriteria"
        class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm hidden items-center justify-center z-50 transition-opacity"
        onclick="closeModal(event)">
        <div class="bg-white rounded-2xl shadow-2xl max-w-lg w-full mx-4 overflow-hidden transform transition-all scale-95"
            id="modalContent" onclick="event.stopPropagation()">
            <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50">
                <h3 class="text-lg font-bold text-slate-800" id="modalTitle">Tambah Kriteria</h3>
                <button onclick="closeModal()" class="text-slate-400 hover:text-slate-600 transition">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>

            <form id="formKriteria" class="p-6">
                <input type="hidden" id="kriteriaId">
                <input type="hidden" id="isEdit" value="0">

                <div class="space-y-5">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Kode</label>
                            <input type="text" id="kode_kriteria" name="kode_kriteria" required maxlength="5"
                                placeholder="C1"
                                class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition placeholder-slate-300">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Bobot (0-1)</label>
                            <input type="number" id="bobot" name="bobot" required step="0.01" min="0"
                                max="1" placeholder="0.25"
                                class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition placeholder-slate-300">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Nama Kriteria</label>
                        <input type="text" id="nama_kriteria" name="nama_kriteria" required
                            placeholder="Contoh: Tes Wawancara"
                            class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition placeholder-slate-300">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Jenis Atribut</label>
                        <div class="grid grid-cols-2 gap-4">
                            <label class="relative flex cursor-pointer">
                                <input type="radio" name="jenis" id="jenis_benefit" value="benefit"
                                    class="peer sr-only" required>
                                <div
                                    class="w-full p-3 text-center bg-white border border-slate-200 rounded-xl peer-checked:bg-blue-50 peer-checked:border-blue-500 peer-checked:text-blue-600 transition cursor-pointer">
                                    <span class="text-sm font-bold">Benefit</span>
                                    <p class="text-[10px] text-slate-400 mt-0.5 peer-checked:text-blue-400">Nilai tinggi
                                        lebih baik</p>
                                </div>
                            </label>
                            <label class="relative flex cursor-pointer">
                                <input type="radio" name="jenis" id="jenis_cost" value="cost"
                                    class="peer sr-only" required>
                                <div
                                    class="w-full p-3 text-center bg-white border border-slate-200 rounded-xl peer-checked:bg-amber-50 peer-checked:border-amber-500 peer-checked:text-amber-600 transition cursor-pointer">
                                    <span class="text-sm font-bold">Cost</span>
                                    <p class="text-[10px] text-slate-400 mt-0.5 peer-checked:text-amber-400">Nilai rendah
                                        lebih baik</p>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div class="pt-2">
                        <label
                            class="flex items-center gap-3 p-3 border border-slate-200 rounded-xl cursor-pointer hover:bg-slate-50 transition">
                            <div class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" id="status_aktif" name="status_aktif" class="sr-only peer"
                                    checked>
                                <div
                                    class="w-11 h-6 bg-slate-200 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-500">
                                </div>
                            </div>
                            <span class="text-sm font-medium text-slate-700">Status Aktif</span>
                        </label>
                    </div>
                </div>

                <div class="mt-8 flex gap-3">
                    <button type="button" onclick="closeModal()"
                        class="flex-1 py-2.5 bg-white border border-slate-200 text-slate-600 rounded-xl hover:bg-slate-50 transition font-semibold text-sm">
                        Batal
                    </button>
                    <button type="submit"
                        class="flex-1 py-2.5 bg-slate-800 text-white rounded-xl hover:bg-slate-700 transition font-semibold text-sm shadow-lg shadow-slate-800/20">
                        Simpan Data
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Animation Helper
        const modal = document.getElementById('modalKriteria');
        const modalContent = document.getElementById('modalContent');

        function openModalAdd() {
            document.getElementById('modalTitle').textContent = 'Tambah Kriteria';
            document.getElementById('formKriteria').reset();
            document.getElementById('kriteriaId').value = '';
            document.getElementById('isEdit').value = '0';

            // Reset Radio Buttons
            document.querySelectorAll('input[name="jenis"]').forEach(el => el.checked = false);

            modal.classList.remove('hidden');
            modal.classList.add('flex');
            setTimeout(() => {
                modalContent.classList.remove('scale-95', 'opacity-0');
                modalContent.classList.add('scale-100', 'opacity-100');
            }, 10);
        }

        function openModalEdit(kriteria) {
            document.getElementById('modalTitle').textContent = 'Edit Kriteria';
            document.getElementById('kriteriaId').value = kriteria.kriteria_id;
            document.getElementById('isEdit').value = '1';
            document.getElementById('kode_kriteria').value = kriteria.kode_kriteria;
            document.getElementById('nama_kriteria').value = kriteria.nama_kriteria;
            document.getElementById('bobot').value = kriteria.bobot;
            document.getElementById('status_aktif').checked = kriteria.status_aktif;

            // Set Radio Button
            if (kriteria.jenis === 'benefit') {
                document.getElementById('jenis_benefit').checked = true;
            } else {
                document.getElementById('jenis_cost').checked = true;
            }

            modal.classList.remove('hidden');
            modal.classList.add('flex');
            setTimeout(() => {
                modalContent.classList.remove('scale-95', 'opacity-0');
                modalContent.classList.add('scale-100', 'opacity-100');
            }, 10);
        }

        function closeModal(event) {
            if (!event || event.target === event.currentTarget || event.currentTarget.tagName === 'BUTTON') {
                modalContent.classList.remove('scale-100', 'opacity-100');
                modalContent.classList.add('scale-95', 'opacity-0');
                setTimeout(() => {
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                }, 200);
            }
        }

        document.getElementById('formKriteria').addEventListener('submit', async function(e) {
            e.preventDefault();

            const isEdit = document.getElementById('isEdit').value === '1';
            const kriteriaId = document.getElementById('kriteriaId').value;
            const jenis = document.querySelector('input[name="jenis"]:checked')?.value;

            if (!jenis) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Perhatian',
                    text: 'Silakan pilih jenis kriteria (Benefit/Cost)'
                });
                return;
            }

            const data = {
                kode_kriteria: document.getElementById('kode_kriteria').value,
                nama_kriteria: document.getElementById('nama_kriteria').value,
                bobot: parseFloat(document.getElementById('bobot').value),
                jenis: jenis,
                status_aktif: document.getElementById('status_aktif').checked,
            };

            try {
                let url = '{{ route('admin.kriteria.store') }}';
                let method = 'POST';

                if (isEdit) {
                    url = `/admin/kriteria/${kriteriaId}`;
                    method = 'PUT';
                }

                // Loading state
                Swal.fire({
                    title: 'Menyimpan...',
                    didOpen: () => Swal.showLoading()
                });

                const response = await fetch(url, {
                    method: method,
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
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
                        confirmButtonColor: '#f97316',
                        customClass: {
                            popup: 'rounded-2xl',
                            confirmButton: 'rounded-xl'
                        }
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    throw new Error(result.message);
                }
            } catch (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: error.message || 'Terjadi kesalahan sistem',
                    confirmButtonColor: '#f97316',
                    customClass: {
                        popup: 'rounded-2xl',
                        confirmButton: 'rounded-xl'
                    }
                });
            }
        });

        function deleteKriteria(id) {
            Swal.fire({
                title: 'Hapus Kriteria?',
                text: 'Data yang dihapus tidak dapat dikembalikan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#94a3b8',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal',
                customClass: {
                    popup: 'rounded-2xl',
                    confirmButton: 'px-5 py-2.5 rounded-xl font-bold',
                    cancelButton: 'px-5 py-2.5 rounded-xl'
                }
            }).then(async (result) => {
                if (result.isConfirmed) {
                    try {
                        const response = await fetch(`/admin/kriteria/${id}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .content,
                            }
                        });

                        const data = await response.json();

                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Terhapus!',
                                text: data.message,
                                confirmButtonColor: '#f97316',
                                customClass: {
                                    popup: 'rounded-2xl',
                                    confirmButton: 'rounded-xl'
                                }
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            throw new Error(data.message);
                        }
                    } catch (error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Gagal menghapus data',
                            confirmButtonColor: '#f97316',
                            customClass: {
                                popup: 'rounded-2xl',
                                confirmButton: 'rounded-xl'
                            }
                        });
                    }
                }
            });
        }
    </script>
@endsection
