@extends('layouts.dashboard')

@section('title', 'Data Santri')

@section('content')
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Kelola Pendaftar</h1>
            <p class="text-sm text-slate-500 mt-1">Verifikasi berkas dan pantau status pendaftaran calon santri.</p>
        </div>

        <div class="flex gap-2">
            <button onclick="window.print()"
                class="px-4 py-2 bg-white border border-slate-200 text-slate-600 rounded-xl hover:bg-slate-50 transition text-sm font-medium shadow-sm">
                <i class="fas fa-print mr-2"></i> Cetak
            </button>
            <button
                class="px-4 py-2 bg-emerald-500 text-white rounded-xl hover:bg-emerald-600 transition text-sm font-medium shadow-lg shadow-emerald-500/20">
                <i class="fas fa-file-excel mr-2"></i> Export
            </button>
        </div>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-[0_4px_20px_rgba(0,0,0,0.03)] border border-slate-100 mb-8">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-6 items-end">
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Periode
                    Pendaftaran</label>
                <div class="relative">
                    <select name="periode_id"
                        class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition appearance-none text-slate-700">
                        <option value="">Semua Periode</option>
                        @foreach ($periodes as $p)
                            <option value="{{ $p->periode_id }}"
                                {{ request('periode_id') == $p->periode_id ? 'selected' : '' }}>
                                {{ $p->nama_periode }}
                            </option>
                        @endforeach
                    </select>
                    <i class="fas fa-calendar-alt absolute left-3.5 top-3 text-slate-400"></i>
                    <i class="fas fa-chevron-down absolute right-3.5 top-3.5 text-xs text-slate-400"></i>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Status
                    Verifikasi</label>
                <div class="relative">
                    <select name="status"
                        class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition appearance-none text-slate-700">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu Verifikasi
                        </option>
                        <option value="diterima" {{ request('status') == 'diterima' ? 'selected' : '' }}>Diterima</option>
                        <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                    <i class="fas fa-check-circle absolute left-3.5 top-3 text-slate-400"></i>
                    <i class="fas fa-chevron-down absolute right-3.5 top-3.5 text-xs text-slate-400"></i>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Pencarian</label>
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari nama atau no. pendaftaran..."
                        class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition text-slate-700">
                    <i class="fas fa-search absolute left-3.5 top-3 text-slate-400"></i>
                </div>
            </div>

            <div>
                <button type="submit"
                    class="w-full px-4 py-2.5 bg-slate-800 text-white rounded-xl hover:bg-slate-700 transition font-semibold text-sm shadow-lg shadow-slate-800/20 flex items-center justify-center gap-2">
                    <i class="fas fa-filter text-xs"></i> Terapkan Filter
                </button>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-2xl shadow-[0_4px_20px_rgba(0,0,0,0.03)] border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200">
                        <th class="text-left py-4 px-6 text-xs font-bold text-slate-500 uppercase tracking-wider">No.
                            Pendaftaran</th>
                        <th class="text-left py-4 px-6 text-xs font-bold text-slate-500 uppercase tracking-wider">Data Diri
                        </th>
                        <th class="text-left py-4 px-6 text-xs font-bold text-slate-500 uppercase tracking-wider">Kontak
                        </th>
                        <th class="text-center py-4 px-6 text-xs font-bold text-slate-500 uppercase tracking-wider">Status
                        </th>
                        <th class="text-right py-4 px-6 text-xs font-bold text-slate-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($pendaftarans as $pendaftaran)
                        <tr class="hover:bg-orange-50/30 transition-colors group">
                            <td class="py-4 px-6 align-top">
                                <div class="flex flex-col">
                                    <span
                                        class="font-mono font-bold text-slate-700 text-sm group-hover:text-orange-600 transition">{{ $pendaftaran->no_pendaftaran }}</span>
                                    <span class="text-xs text-slate-400 mt-1">
                                        <i class="far fa-calendar-alt mr-1"></i>
                                        {{ $pendaftaran->tanggal_submit->format('d M Y') }}
                                    </span>
                                </div>
                            </td>

                            <td class="py-4 px-6 align-top">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-10 h-10 rounded-full bg-orange-100 text-orange-600 flex items-center justify-center text-sm font-bold flex-shrink-0">
                                        {{ strtoupper(substr($pendaftaran->pengguna->nama, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-800 text-sm">
                                            {{ $pendaftaran->pengguna->profil->nama_lengkap ?? $pendaftaran->pengguna->nama }}
                                        </p>
                                        <p class="text-xs text-slate-500 mt-0.5">
                                            <i class="fas fa-school mr-1 text-slate-300"></i>
                                            {{ $pendaftaran->asal_sekolah }}
                                        </p>
                                    </div>
                                </div>
                            </td>

                            <td class="py-4 px-6 align-top">
                                <div class="flex flex-col gap-1">
                                    <a href="mailto:{{ $pendaftaran->pengguna->email }}"
                                        class="text-xs text-slate-600 hover:text-orange-600 transition flex items-center">
                                        <i class="far fa-envelope w-4 mr-1 text-slate-400"></i>
                                        {{ $pendaftaran->pengguna->email }}
                                    </a>
                                    <a href="https://wa.me/{{ $pendaftaran->pengguna->no_hp }}" target="_blank"
                                        class="text-xs text-slate-600 hover:text-green-600 transition flex items-center">
                                        <i class="fab fa-whatsapp w-4 mr-1 text-slate-400"></i>
                                        {{ $pendaftaran->pengguna->no_hp }}
                                    </a>
                                </div>
                            </td>

                            <td class="py-4 px-6 align-top text-center">
                                @if ($pendaftaran->status_verifikasi === 'pending')
                                    <span
                                        class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-600 border border-amber-100">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 mr-2 animate-pulse"></span>
                                        Menunggu
                                    </span>
                                @elseif($pendaftaran->status_verifikasi === 'diterima')
                                    <span
                                        class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-600 border border-emerald-100">
                                        <i class="fas fa-check-circle mr-1.5"></i> Terverifikasi
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-rose-50 text-rose-600 border border-rose-100">
                                        <i class="fas fa-times-circle mr-1.5"></i> Ditolak
                                    </span>
                                @endif
                            </td>

                            <td class="py-4 px-6 align-top text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.pendaftar.show', $pendaftaran->pendaftaran_id) }}"
                                        class="w-8 h-8 rounded-lg bg-slate-50 border border-slate-200 text-slate-500 hover:bg-white hover:border-orange-200 hover:text-orange-500 hover:shadow-md transition-all flex items-center justify-center"
                                        title="Lihat Detail">
                                        <i class="fas fa-eye text-xs"></i>
                                    </a>

                                    @if ($pendaftaran->status_verifikasi === 'pending')
                                        <button onclick="verifikasi({{ $pendaftaran->pendaftaran_id }}, 'diterima')"
                                            class="w-8 h-8 rounded-lg bg-emerald-50 border border-emerald-100 text-emerald-600 hover:bg-emerald-500 hover:text-white hover:shadow-md transition-all flex items-center justify-center"
                                            title="Terima">
                                            <i class="fas fa-check text-xs"></i>
                                        </button>
                                        <button onclick="verifikasi({{ $pendaftaran->pendaftaran_id }}, 'ditolak')"
                                            class="w-8 h-8 rounded-lg bg-rose-50 border border-rose-100 text-rose-600 hover:bg-rose-500 hover:text-white hover:shadow-md transition-all flex items-center justify-center"
                                            title="Tolak">
                                            <i class="fas fa-times text-xs"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center">
                                <div class="flex flex-col items-center justify-center text-slate-400">
                                    <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-3">
                                        <i class="fas fa-search text-2xl text-slate-300"></i>
                                    </div>
                                    <p class="text-sm font-medium text-slate-500">Data pendaftar tidak ditemukan</p>
                                    <p class="text-xs text-slate-400 mt-1">Coba ubah filter atau kata kunci pencarian Anda
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($pendaftarans->hasPages())
            <div class="px-6 py-4 border-t border-slate-100 bg-slate-50">
                {{ $pendaftarans->links() }}
            </div>
        @endif
    </div>
@endsection

@section('scripts')
    <script>
        function verifikasi(id, status) {
            const actionText = status === 'diterima' ? 'Menerima' : 'Menolak';
            const color = status === 'diterima' ? '#10b981' : '#ef4444'; // Emerald or Red

            Swal.fire({
                title: 'Konfirmasi Verifikasi',
                text: `Apakah Anda yakin ingin ${actionText.toLowerCase()} berkas pendaftar ini?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: color,
                cancelButtonColor: '#94a3b8',
                confirmButtonText: `Ya, ${actionText}`,
                cancelButtonText: 'Batal',
                customClass: {
                    popup: 'rounded-2xl',
                    confirmButton: 'px-5 py-2.5 rounded-xl font-bold',
                    cancelButton: 'px-5 py-2.5 rounded-xl'
                }
            }).then(async (result) => {
                if (result.isConfirmed) {
                    try {
                        // Tampilkan loading state
                        Swal.fire({
                            title: 'Memproses...',
                            text: 'Mohon tunggu sebentar',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        const response = await fetch(`/admin/pendaftar/${id}/verifikasi`, {
                            method: 'PUT',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .content,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                status: status
                            })
                        });

                        const data = await response.json();

                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
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
                            throw new Error(data.message || 'Gagal memproses data');
                        }
                    } catch (error) {
                        console.error(error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Terjadi Kesalahan',
                            text: 'Gagal menghubungi server. Silakan coba lagi.',
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
