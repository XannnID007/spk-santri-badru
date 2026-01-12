@extends('layouts.dashboard')

@section('title', 'Kelola Data Pendaftar')

@section('content')
    <div class="container mx-auto px-6 py-8">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-white mb-2">
                <i class="fas fa-users mr-3"></i>Kelola Data Pendaftar
            </h1>
            <p class="text-gray-400">Verifikasi dan kelola data calon santri</p>
        </div>

        <!-- Filter -->
        <div class="glass-orange rounded-xl p-6 mb-6">
            <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-200 mb-2">Periode</label>
                    <select name="periode_id"
                        class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded-lg text-white text-sm focus:border-orange-500 focus:outline-none">
                        <option value="">Semua Periode</option>
                        @foreach ($periodes as $p)
                            <option value="{{ $p->periode_id }}"
                                {{ request('periode_id') == $p->periode_id ? 'selected' : '' }}>
                                {{ $p->nama_periode }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-200 mb-2">Status</label>
                    <select name="status"
                        class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded-lg text-white text-sm focus:border-orange-500 focus:outline-none">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="diterima" {{ request('status') == 'diterima' ? 'selected' : '' }}>Diterima</option>
                        <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-200 mb-2">Cari</label>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Nama/Email/No Pendaftaran"
                        class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded-lg text-white text-sm focus:border-orange-500 focus:outline-none">
                </div>
                <div class="flex items-end">
                    <button type="submit"
                        class="w-full px-4 py-2 gradient-orange rounded-lg font-semibold hover:opacity-90 transition">
                        <i class="fas fa-search mr-2"></i>Filter
                    </button>
                </div>
            </form>
        </div>

        <!-- Table -->
        <div class="glass-dark rounded-xl p-6">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-700">
                            <th class="text-left text-sm font-semibold text-gray-300 p-4">No. Pendaftaran</th>
                            <th class="text-left text-sm font-semibold text-gray-300 p-4">Nama</th>
                            <th class="text-left text-sm font-semibold text-gray-300 p-4">Kontak</th>
                            <th class="text-center text-sm font-semibold text-gray-300 p-4">Status</th>
                            <th class="text-center text-sm font-semibold text-gray-300 p-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pendaftarans as $pendaftaran)
                            <tr class="border-b border-gray-800 hover:bg-gray-800/50">
                                <td class="p-4">
                                    <span
                                        class="font-mono text-orange-500 font-bold">{{ $pendaftaran->no_pendaftaran }}</span>
                                    <p class="text-xs text-gray-400">{{ $pendaftaran->tanggal_submit->format('d M Y') }}</p>
                                </td>
                                <td class="p-4">
                                    <p class="font-semibold text-white">
                                        {{ $pendaftaran->pengguna->profil->nama_lengkap ?? $pendaftaran->pengguna->nama }}
                                    </p>
                                    <p class="text-sm text-gray-400">{{ $pendaftaran->asal_sekolah }}</p>
                                </td>
                                <td class="p-4">
                                    <p class="text-sm text-white">{{ $pendaftaran->pengguna->email }}</p>
                                    <p class="text-sm text-gray-400">{{ $pendaftaran->pengguna->no_hp }}</p>
                                </td>
                                <td class="p-4 text-center">
                                    @if ($pendaftaran->status_verifikasi === 'pending')
                                        <span class="px-3 py-1 bg-yellow-500/20 text-yellow-400 rounded-full text-sm">
                                            <i class="fas fa-clock mr-1"></i>Pending
                                        </span>
                                    @elseif($pendaftaran->status_verifikasi === 'diterima')
                                        <span class="px-3 py-1 bg-green-500/20 text-green-400 rounded-full text-sm">
                                            <i class="fas fa-check-circle mr-1"></i>Diverifikasi
                                        </span>
                                    @else
                                        <span class="px-3 py-1 bg-red-500/20 text-red-400 rounded-full text-sm">
                                            <i class="fas fa-times-circle mr-1"></i>Ditolak
                                        </span>
                                    @endif
                                </td>
                                <td class="p-4 text-center">
                                    <a href="{{ route('admin.pendaftar.show', $pendaftaran->pendaftaran_id) }}"
                                        class="inline-block px-3 py-2 bg-blue-500 hover:bg-blue-600 rounded-lg text-sm font-semibold transition mr-2">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if ($pendaftaran->status_verifikasi === 'pending')
                                        <button onclick="verifikasi({{ $pendaftaran->pendaftaran_id }}, 'diterima')"
                                            class="px-3 py-2 bg-green-500 hover:bg-green-600 rounded-lg text-sm font-semibold transition mr-2">
                                            <i class="fas fa-check"></i>
                                        </button>
                                        <button onclick="verifikasi({{ $pendaftaran->pendaftaran_id }}, 'ditolak')"
                                            class="px-3 py-2 bg-red-500 hover:bg-red-600 rounded-lg text-sm font-semibold transition">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-8 text-center text-gray-400">
                                    <i class="fas fa-inbox text-4xl mb-2"></i>
                                    <p>Belum ada data pendaftar</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($pendaftarans->hasPages())
                <div class="mt-6">
                    {{ $pendaftarans->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection

@section('scripts')
    function verifikasi(id, status) {
    const action = status === 'diterima' ? 'menerima' : 'menolak';

    Swal.fire({
    title: `${status === 'diterima' ? 'Terima' : 'Tolak'} Verifikasi?`,
    text: `Anda akan ${action} dokumen pendaftar ini`,
    icon: 'question',
    showCancelButton: true,
    confirmButtonColor: status === 'diterima' ? '#10b981' : '#ef4444',
    cancelButtonColor: '#6b7280',
    confirmButtonText: 'Ya!',
    cancelButtonText: 'Batal'
    }).then(async (result) => {
    if (result.isConfirmed) {
    try {
    const response = await fetch(`/admin/pendaftar/${id}/verifikasi`, {
    method: 'PUT',
    headers: {
    'Content-Type': 'application/json',
    'X-CSRF-TOKEN': csrfToken,
    },
    body: JSON.stringify({ status })
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
