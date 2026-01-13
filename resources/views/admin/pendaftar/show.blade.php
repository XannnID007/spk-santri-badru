@extends('layouts.dashboard')

@section('title', 'Detail Santri')

@section('content')
    <div class="flex items-center justify-between mb-8">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.pendaftar') }}"
                class="w-10 h-10 flex items-center justify-center bg-white border border-slate-200 rounded-xl text-slate-500 hover:text-orange-600 hover:border-orange-200 transition shadow-sm">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Detail Pendaftar</h1>
                <p class="text-sm text-slate-500">Informasi lengkap calon santri</p>
            </div>
        </div>

        <div class="hidden md:block">
            <span class="px-4 py-2 rounded-xl text-sm font-bold bg-slate-100 text-slate-600 border border-slate-200">
                #{{ $pendaftaran->no_pendaftaran }}
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

        <div class="lg:col-span-4 space-y-6">

            <div
                class="bg-white rounded-2xl p-6 border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.03)] text-center relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-24 bg-gradient-to-br from-orange-400 to-orange-600"></div>

                <div class="relative z-10 -mt-2">
                    @if ($pendaftaran->pengguna->profil && $pendaftaran->pengguna->profil->foto)
                        <img src="{{ asset('storage/' . $pendaftaran->pengguna->profil->foto) }}" alt="Foto"
                            class="w-32 h-32 object-cover rounded-2xl mx-auto border-4 border-white shadow-md">
                    @else
                        <div
                            class="w-32 h-32 bg-slate-100 rounded-2xl mx-auto border-4 border-white shadow-md flex items-center justify-center text-slate-300">
                            <i class="fas fa-user text-5xl"></i>
                        </div>
                    @endif

                    <h2 class="mt-4 text-xl font-bold text-slate-800">
                        {{ $pendaftaran->pengguna->profil->nama_lengkap ?? $pendaftaran->pengguna->nama }}
                    </h2>
                    <p class="text-sm text-slate-500">{{ $pendaftaran->pengguna->email }}</p>

                    <div class="mt-6 pt-6 border-t border-slate-100 flex justify-center gap-4">
                        <a href="https://wa.me/{{ $pendaftaran->pengguna->no_hp }}" target="_blank"
                            class="flex flex-col items-center gap-1 group">
                            <div
                                class="w-10 h-10 rounded-full bg-green-50 text-green-600 flex items-center justify-center group-hover:bg-green-500 group-hover:text-white transition">
                                <i class="fab fa-whatsapp text-lg"></i>
                            </div>
                            <span class="text-xs text-slate-500 font-medium">WhatsApp</span>
                        </a>
                        <a href="mailto:{{ $pendaftaran->pengguna->email }}" class="flex flex-col items-center gap-1 group">
                            <div
                                class="w-10 h-10 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center group-hover:bg-blue-500 group-hover:text-white transition">
                                <i class="far fa-envelope text-lg"></i>
                            </div>
                            <span class="text-xs text-slate-500 font-medium">Email</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.03)]">
                <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider mb-4 border-b border-slate-50 pb-3">
                    Status Pendaftaran</h3>

                <div class="space-y-4">
                    <div>
                        <p class="text-xs text-slate-400 mb-1">Status Verifikasi</p>
                        @if ($pendaftaran->status_verifikasi === 'pending')
                            <div
                                class="inline-flex items-center px-3 py-1.5 rounded-lg bg-amber-50 text-amber-600 border border-amber-100 text-sm font-bold">
                                <span class="w-2 h-2 rounded-full bg-amber-500 mr-2 animate-pulse"></span>
                                Menunggu Verifikasi
                            </div>
                        @elseif($pendaftaran->status_verifikasi === 'diterima')
                            <div
                                class="inline-flex items-center px-3 py-1.5 rounded-lg bg-emerald-50 text-emerald-600 border border-emerald-100 text-sm font-bold">
                                <i class="fas fa-check-circle mr-2"></i> Terverifikasi
                            </div>
                        @else
                            <div
                                class="inline-flex items-center px-3 py-1.5 rounded-lg bg-rose-50 text-rose-600 border border-rose-100 text-sm font-bold">
                                <i class="fas fa-times-circle mr-2"></i> Ditolak
                            </div>
                        @endif
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-xs text-slate-400 mb-1">Periode</p>
                            <p class="text-sm font-semibold text-slate-700">{{ $pendaftaran->periode->nama_periode }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400 mb-1">Tanggal Daftar</p>
                            <p class="text-sm font-semibold text-slate-700">
                                {{ $pendaftaran->tanggal_submit->format('d M Y') }}</p>
                        </div>
                    </div>
                </div>

                @if ($pendaftaran->status_verifikasi === 'pending')
                    <div class="mt-6 pt-6 border-t border-slate-100 grid grid-cols-2 gap-3">
                        <button onclick="verifikasi({{ $pendaftaran->pendaftaran_id }}, 'diterima')"
                            class="w-full py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white rounded-xl text-sm font-bold transition shadow-lg shadow-emerald-500/20">
                            Terima
                        </button>
                        <button onclick="verifikasi({{ $pendaftaran->pendaftaran_id }}, 'ditolak')"
                            class="w-full py-2.5 bg-white border border-rose-200 text-rose-600 hover:bg-rose-50 rounded-xl text-sm font-bold transition">
                            Tolak
                        </button>
                    </div>
                @endif
            </div>

        </div>

        <div class="lg:col-span-8 space-y-6">

            <div class="bg-white rounded-2xl p-8 border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.03)]">
                <div class="flex items-center gap-3 mb-6 pb-4 border-b border-slate-50">
                    <div class="w-10 h-10 rounded-xl bg-orange-50 flex items-center justify-center text-orange-600">
                        <i class="far fa-id-card text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-slate-800">Biodata Lengkap</h3>
                        <p class="text-xs text-slate-400">Data diri dan keluarga calon santri</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                    <div class="group">
                        <p class="text-xs text-slate-400 mb-1 font-medium group-hover:text-orange-500 transition">NIK</p>
                        <p class="text-slate-700 font-semibold">{{ $pendaftaran->pengguna->profil->nik ?? '-' }}</p>
                    </div>
                    <div class="group">
                        <p class="text-xs text-slate-400 mb-1 font-medium group-hover:text-orange-500 transition">Tempat,
                            Tanggal Lahir</p>
                        <p class="text-slate-700 font-semibold">
                            {{ $pendaftaran->pengguna->profil->tempat_lahir ?? '-' }},
                            {{ $pendaftaran->pengguna->profil ? $pendaftaran->pengguna->profil->tanggal_lahir->format('d M Y') : '-' }}
                        </p>
                    </div>
                    <div class="group">
                        <p class="text-xs text-slate-400 mb-1 font-medium group-hover:text-orange-500 transition">Jenis
                            Kelamin</p>
                        <p class="text-slate-700 font-semibold">
                            {{ $pendaftaran->pengguna->profil ? ($pendaftaran->pengguna->profil->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan') : '-' }}
                        </p>
                    </div>
                    <div class="group">
                        <p class="text-xs text-slate-400 mb-1 font-medium group-hover:text-orange-500 transition">Alamat
                            Lengkap</p>
                        <p class="text-slate-700 font-semibold">{{ $pendaftaran->pengguna->profil->alamat_lengkap ?? '-' }}
                        </p>
                    </div>

                    <div class="md:col-span-2 border-t border-slate-50 my-2"></div>

                    <div class="group">
                        <p class="text-xs text-slate-400 mb-1 font-medium group-hover:text-orange-500 transition">Nama Ayah
                        </p>
                        <p class="text-slate-700 font-semibold">{{ $pendaftaran->pengguna->profil->nama_ayah ?? '-' }}</p>
                    </div>
                    <div class="group">
                        <p class="text-xs text-slate-400 mb-1 font-medium group-hover:text-orange-500 transition">Pekerjaan
                            Ayah</p>
                        <p class="text-slate-700 font-semibold">{{ $pendaftaran->pengguna->profil->pekerjaan_ayah ?? '-' }}
                        </p>
                    </div>
                    <div class="group">
                        <p class="text-xs text-slate-400 mb-1 font-medium group-hover:text-orange-500 transition">Nama Ibu
                        </p>
                        <p class="text-slate-700 font-semibold">{{ $pendaftaran->pengguna->profil->nama_ibu ?? '-' }}</p>
                    </div>
                    <div class="group">
                        <p class="text-xs text-slate-400 mb-1 font-medium group-hover:text-orange-500 transition">
                            Penghasilan Orang Tua</p>
                        <p class="text-slate-700 font-semibold">Rp
                            {{ number_format($pendaftaran->pengguna->profil->penghasilan_ortu ?? 0, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-8 border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.03)]">
                <div class="flex items-center gap-3 mb-6 pb-4 border-b border-slate-50">
                    <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600">
                        <i class="fas fa-graduation-cap text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-slate-800">Riwayat Pendidikan</h3>
                        <p class="text-xs text-slate-400">Asal sekolah dan prestasi</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-xs text-slate-400 mb-1 font-medium">Asal Sekolah</p>
                        <p class="text-slate-700 font-bold text-lg">{{ $pendaftaran->asal_sekolah }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 mb-1 font-medium">Rata-rata Nilai</p>
                        <span
                            class="inline-block px-3 py-1 bg-slate-100 text-slate-700 rounded-lg font-bold text-sm border border-slate-200">
                            {{ $pendaftaran->rata_nilai }}
                        </span>
                    </div>
                    @if ($pendaftaran->prestasi)
                        <div class="md:col-span-2 p-4 bg-yellow-50 rounded-xl border border-yellow-100">
                            <p class="text-xs text-yellow-600 mb-1 font-bold uppercase tracking-wider">Prestasi</p>
                            <p class="text-slate-700 text-sm leading-relaxed">{{ $pendaftaran->prestasi }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="bg-white rounded-2xl p-8 border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.03)]">
                <div class="flex items-center gap-3 mb-6 pb-4 border-b border-slate-50">
                    <div class="w-10 h-10 rounded-xl bg-purple-50 flex items-center justify-center text-purple-600">
                        <i class="fas fa-folder-open text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-slate-800">Dokumen Lampiran</h3>
                        <p class="text-xs text-slate-400">Berkas persyaratan pendaftaran</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @foreach ([['label' => 'Kartu Keluarga', 'file' => $pendaftaran->file_kk, 'icon' => 'fa-users'], ['label' => 'Akta Kelahiran', 'file' => $pendaftaran->file_akta, 'icon' => 'fa-baby'], ['label' => 'Ijazah / SKL', 'file' => $pendaftaran->file_ijazah, 'icon' => 'fa-certificate'], ['label' => 'Pas Foto', 'file' => $pendaftaran->file_foto, 'icon' => 'fa-camera'], ['label' => 'SKTM', 'file' => $pendaftaran->file_sktm, 'icon' => 'fa-file-invoice']] as $doc)
                        @if ($doc['file'])
                            <div
                                class="flex items-center p-4 rounded-xl border border-slate-200 hover:border-orange-200 hover:bg-orange-50/30 transition group">
                                <div
                                    class="w-10 h-10 rounded-lg bg-slate-100 flex items-center justify-center text-slate-500 mr-4 group-hover:bg-orange-100 group-hover:text-orange-500 transition">
                                    <i class="fas {{ $doc['icon'] }}"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-bold text-slate-700">{{ $doc['label'] }}</p>
                                    <a href="{{ asset('storage/' . $doc['file']) }}" target="_blank"
                                        class="text-xs text-blue-500 hover:underline flex items-center gap-1 mt-0.5">
                                        Lihat File <i class="fas fa-external-link-alt text-[10px]"></i>
                                    </a>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>

        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function verifikasi(id, status) {
            const actionText = status === 'diterima' ? 'Menerima' : 'Menolak';
            const color = status === 'diterima' ? '#10b981' : '#ef4444';

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
                        Swal.fire({
                            icon: 'error',
                            title: 'Terjadi Kesalahan',
                            text: 'Gagal menghubungi server.',
                            confirmButtonColor: '#f97316'
                        });
                    }
                }
            });
        }
    </script>
@endsection
