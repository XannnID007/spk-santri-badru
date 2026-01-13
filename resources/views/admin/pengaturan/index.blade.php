@extends('layouts.dashboard')

@section('title', 'Pengaturan Sistem')

@section('content')
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-slate-800">Konfigurasi Sistem</h1>
        <p class="text-sm text-slate-500 mt-1">Kelola identitas, statistik pondok, dan media halaman depan.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

        <div class="lg:col-span-4 space-y-8">

            <div
                class="bg-white rounded-2xl p-6 border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.03)] text-center relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-orange-500"></div>
                <h3 class="text-lg font-bold text-slate-800 mb-6">Logo Pesantren</h3>

                <div class="mb-6 relative group mx-auto w-40 h-40">
                    @if ($pengaturan->logo)
                        <img src="{{ asset('storage/' . $pengaturan->logo) }}" alt="Logo" id="previewLogo"
                            class="w-full h-full object-contain p-2 border-2 border-slate-100 rounded-2xl group-hover:border-orange-200 transition bg-white">
                    @else
                        <div class="w-full h-full flex items-center justify-center border-2 border-dashed border-slate-300 rounded-2xl bg-slate-50 group-hover:bg-slate-100 transition"
                            id="placeholderLogo">
                            <i class="fas fa-image text-4xl text-slate-300"></i>
                        </div>
                    @endif

                    <div class="absolute inset-0 bg-black/50 rounded-2xl flex items-center justify-center opacity-0 group-hover:opacity-100 transition cursor-pointer backdrop-blur-[2px] z-10"
                        onclick="document.getElementById('inputLogo').click()">
                        <div class="text-white text-xs font-bold pointer-events-none">
                            <i class="fas fa-camera text-xl mb-1 block"></i> Ubah Logo
                        </div>
                    </div>
                </div>

                <form id="formLogo">
                    <input type="file" id="inputLogo" name="logo" accept="image/png, image/jpeg" class="hidden"
                        onchange="handleLogoUpload(this)">

                    <button type="button" onclick="document.getElementById('inputLogo').click()"
                        class="w-full py-2.5 bg-slate-800 text-white rounded-xl text-sm font-bold hover:bg-slate-700 transition">
                        Pilih Gambar
                    </button>
                    <p class="text-[10px] text-slate-400 mt-2">Format: PNG/JPG (Maks. 2MB)</p>
                </form>
            </div>

            <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.03)]">
                <h3 class="text-lg font-bold text-slate-800 mb-6">Statistik Dashboard</h3>
                <div class="space-y-4">
                    <div class="flex items-center justify-between p-4 bg-orange-50 rounded-xl border border-orange-100">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-orange-500 shadow-sm">
                                <i class="fas fa-user-graduate"></i></div>
                            <span class="text-xs font-bold text-slate-600 uppercase tracking-wide">Santri</span>
                        </div>
                        <span class="text-xl font-bold text-slate-800">{{ $pengaturan->jumlah_santri }}</span>
                    </div>
                    <div class="flex items-center justify-between p-4 bg-blue-50 rounded-xl border border-blue-100">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-blue-500 shadow-sm">
                                <i class="fas fa-chalkboard-teacher"></i></div>
                            <span class="text-xs font-bold text-slate-600 uppercase tracking-wide">Guru</span>
                        </div>
                        <span class="text-xl font-bold text-slate-800">{{ $pengaturan->jumlah_guru }}</span>
                    </div>
                    <div class="flex items-center justify-between p-4 bg-emerald-50 rounded-xl border border-emerald-100">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-emerald-500 shadow-sm">
                                <i class="fas fa-graduation-cap"></i></div>
                            <span class="text-xs font-bold text-slate-600 uppercase tracking-wide">Alumni</span>
                        </div>
                        <span class="text-xl font-bold text-slate-800">{{ $pengaturan->jumlah_alumni }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-8 space-y-8">

            <div class="bg-white rounded-2xl p-8 border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.03)]">
                <h3 class="text-lg font-bold text-slate-800 mb-6 border-b border-slate-100 pb-4">Informasi Umum & Data</h3>

                <form id="formPengaturan" onsubmit="submitPengaturan(event)">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Nama Pesantren</label>
                            <input type="text" name="nama_pesantren" value="{{ $pengaturan->nama_pesantren }}" required
                                class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-orange-500 transition text-slate-700 font-medium">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Alamat Lengkap</label>
                            <textarea name="alamat" rows="2" required
                                class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-orange-500 transition text-slate-700">{{ $pengaturan->alamat }}</textarea>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Telepon / WhatsApp</label>
                            <input type="text" name="telepon" value="{{ $pengaturan->telepon }}" required
                                class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-orange-500 transition text-slate-700">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Email Resmi</label>
                            <input type="email" name="email" value="{{ $pengaturan->email }}" required
                                class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-orange-500 transition text-slate-700">
                        </div>
                    </div>

                    <div class="p-5 bg-slate-50 rounded-xl border border-slate-100">
                        <div class="flex items-center gap-2 mb-4">
                            <i class="fas fa-chart-bar text-orange-500"></i>
                            <h4 class="text-xs font-bold text-slate-700 uppercase tracking-widest">Update Data Statistik
                            </h4>
                        </div>
                        <div class="grid grid-cols-3 gap-4">
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 mb-1">Jumlah Santri</label>
                                <input type="number" name="jumlah_santri" value="{{ $pengaturan->jumlah_santri }}" required
                                    class="w-full px-3 py-2 bg-white border border-slate-200 rounded-lg text-sm text-center font-bold focus:outline-none focus:border-orange-500 text-slate-700">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 mb-1">Jumlah Guru</label>
                                <input type="number" name="jumlah_guru" value="{{ $pengaturan->jumlah_guru }}" required
                                    class="w-full px-3 py-2 bg-white border border-slate-200 rounded-lg text-sm text-center font-bold focus:outline-none focus:border-orange-500 text-slate-700">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 mb-1">Jumlah Alumni</label>
                                <input type="number" name="jumlah_alumni" value="{{ $pengaturan->jumlah_alumni }}"
                                    required
                                    class="w-full px-3 py-2 bg-white border border-slate-200 rounded-lg text-sm text-center font-bold focus:outline-none focus:border-orange-500 text-slate-700">
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end">
                        <button type="submit"
                            class="px-6 py-2.5 bg-slate-800 text-white rounded-xl text-sm font-bold shadow-lg shadow-slate-800/20 hover:bg-slate-700 transition flex items-center gap-2">
                            <i class="fas fa-save"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>

            <div class="bg-white rounded-2xl p-8 border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.03)]">
                <div class="flex justify-between items-center mb-6 border-b border-slate-100 pb-4">
                    <div>
                        <h3 class="text-lg font-bold text-slate-800">Media Background</h3>
                        <p class="text-xs text-slate-400">Gambar/Video slide di halaman depan</p>
                    </div>
                    <button type="button" onclick="toggleModal(true)"
                        class="px-4 py-2 bg-emerald-50 text-emerald-600 rounded-lg text-xs font-bold hover:bg-emerald-100 transition border border-emerald-100 flex items-center gap-2">
                        <i class="fas fa-plus"></i> Tambah Media
                    </button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @forelse($banners as $banner)
                        <div
                            class="relative group rounded-xl overflow-hidden border border-slate-200 aspect-video bg-slate-50 shadow-sm">
                            @if ($banner->tipe === 'image')
                                <img src="{{ asset('storage/' . $banner->file) }}"
                                    class="w-full h-full object-cover transition duration-500 group-hover:scale-105">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-slate-800">
                                    <i class="fas fa-play text-3xl text-white/50"></i>
                                </div>
                            @endif
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent p-4 flex flex-col justify-end opacity-0 group-hover:opacity-100 transition duration-300">
                                <div class="flex justify-between items-end">
                                    <div>
                                        <span
                                            class="px-2 py-0.5 bg-orange-500 text-[9px] text-white font-bold uppercase rounded mb-1 inline-block shadow-sm">{{ $banner->tipe }}</span>
                                        <h4 class="text-white font-bold text-xs truncate max-w-[150px]">
                                            {{ $banner->judul }}</h4>
                                    </div>
                                    <button onclick="deleteBanner({{ $banner->banner_id }})"
                                        class="w-8 h-8 bg-white/20 backdrop-blur-sm hover:bg-red-500 text-white rounded-lg flex items-center justify-center transition shadow-md">
                                        <i class="fas fa-trash text-xs"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div
                            class="md:col-span-2 py-10 text-center border-2 border-dashed border-slate-200 rounded-2xl bg-slate-50/50">
                            <div
                                class="w-12 h-12 bg-white rounded-full flex items-center justify-center text-slate-300 mx-auto mb-3 border border-slate-100 shadow-sm">
                                <i class="fas fa-images text-lg"></i></div>
                            <p class="text-sm font-medium text-slate-500">Belum ada media</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <div id="modalBanner" class="fixed inset-0 z-[9999] hidden items-center justify-center px-4">
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity opacity-0" id="modalBackdrop"
            onclick="toggleModal(false)"></div>

        <div class="bg-white w-full max-w-md p-0 rounded-2xl relative z-10 shadow-2xl transform scale-95 opacity-0 transition-all duration-300 overflow-hidden"
            id="modalContent">
            <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50">
                <h3 class="text-lg font-bold text-slate-800">Upload Media Baru</h3>
                <button type="button" onclick="toggleModal(false)"
                    class="text-slate-400 hover:text-slate-600 transition"><i class="fas fa-times"></i></button>
            </div>

            <form id="formBanner" onsubmit="submitBanner(event)">
                <div class="p-6 space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Judul Media</label>
                        <input type="text" name="judul" required
                            class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-orange-500 transition text-slate-700">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Tipe File</label>
                        <select name="tipe"
                            class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-orange-500 transition text-slate-700">
                            <option value="image">Gambar (JPG/PNG)</option>
                            <option value="video">Video (MP4)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-2">File</label>
                        <input type="file" name="file" required
                            class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-orange-50 file:text-orange-600 hover:file:bg-orange-100">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Urutan Tampil</label>
                        <input type="number" name="urutan" value="1"
                            class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-orange-500 transition text-slate-700">
                    </div>
                </div>
                <div class="px-6 pb-6 flex gap-3">
                    <button type="button" onclick="toggleModal(false)"
                        class="flex-1 py-2.5 bg-slate-100 text-slate-600 rounded-xl font-bold text-sm hover:bg-slate-200 transition">Batal</button>
                    <button type="submit"
                        class="flex-1 py-2.5 bg-orange-600 text-white rounded-xl font-bold text-sm hover:bg-orange-700 transition shadow-lg shadow-orange-600/20">Upload</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Ambil Token CSRF
        const getCsrfToken = () => document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // --- 1. MODAL LOGIC (GLOBAL) ---
        window.toggleModal = function(show) {
            const modal = document.getElementById('modalBanner');
            const backdrop = document.getElementById('modalBackdrop');
            const content = document.getElementById('modalContent');

            if (show) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                setTimeout(() => {
                    backdrop.classList.remove('opacity-0');
                    content.classList.remove('scale-95', 'opacity-0');
                    content.classList.add('scale-100', 'opacity-100');
                }, 10);
            } else {
                backdrop.classList.add('opacity-0');
                content.classList.remove('scale-100', 'opacity-100');
                content.classList.add('scale-95', 'opacity-0');
                setTimeout(() => {
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                }, 300);
            }
        }

        // --- 2. UPLOAD LOGO (ONCHANGE) ---
        window.handleLogoUpload = async function(input) {
            if (input.files && input.files[0]) {
                const file = input.files[0];
                const formData = new FormData();
                formData.append('logo', file);
                formData.append('_token', getCsrfToken());

                try {
                    Swal.fire({
                        title: 'Mengupload Logo...',
                        didOpen: () => Swal.showLoading()
                    });

                    const response = await fetch('{{ route('admin.pengaturan.upload-logo') }}', {
                        method: 'POST',
                        body: formData
                    });

                    const data = await response.json();

                    if (response.ok && data.success) {
                        Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: 'Logo berhasil diperbarui',
                                confirmButtonColor: '#f97316'
                            })
                            .then(() => location.reload());
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: data.message || 'Gagal upload',
                            confirmButtonColor: '#f97316'
                        });
                    }
                } catch (e) {
                    console.error(e);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Terjadi kesalahan sistem',
                        confirmButtonColor: '#f97316'
                    });
                }
            }
        }

        // --- 3. SUBMIT PENGATURAN (ONSUBMIT) ---
        window.submitPengaturan = function(e) {
            e.preventDefault();
            const form = document.getElementById('formPengaturan');
            const formData = new FormData(form);
            if (!formData.has('_token')) formData.append('_token', getCsrfToken());

            Swal.fire({
                title: 'Simpan Perubahan?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#1e293b',
                cancelButtonColor: '#cbd5e1',
                confirmButtonText: 'Ya, Simpan'
            }).then(async (result) => {
                if (result.isConfirmed) {
                    try {
                        Swal.fire({
                            title: 'Menyimpan...',
                            didOpen: () => Swal.showLoading()
                        });

                        const response = await fetch('{{ route('admin.pengaturan.update') }}', {
                            method: 'POST', // Blade sends _method: PUT
                            headers: {
                                'Accept': 'application/json'
                            },
                            body: formData
                        });

                        const data = await response.json();

                        if (response.ok && data.success) {
                            Swal.fire({
                                    icon: 'success',
                                    title: 'Tersimpan!',
                                    text: data.message,
                                    confirmButtonColor: '#f97316'
                                })
                                .then(() => location.reload());
                        } else {
                            let msg = data.message;
                            if (data.errors) msg = Object.values(data.errors)[0][0];
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: msg,
                                confirmButtonColor: '#f97316'
                            });
                        }
                    } catch (e) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Gagal menyimpan data',
                            confirmButtonColor: '#f97316'
                        });
                    }
                }
            });
        }

        // --- 4. SUBMIT BANNER (ONSUBMIT) ---
        window.submitBanner = async function(e) {
            e.preventDefault();
            const form = document.getElementById('formBanner');
            const formData = new FormData(form);
            formData.append('_token', getCsrfToken());

            try {
                Swal.fire({
                    title: 'Mengupload...',
                    didOpen: () => Swal.showLoading()
                });

                const response = await fetch('{{ route('admin.pengaturan.banner.store') }}', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json'
                    },
                    body: formData
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: 'Media ditambahkan',
                            confirmButtonColor: '#f97316'
                        })
                        .then(() => location.reload());
                } else {
                    let msg = data.message;
                    if (data.errors) msg = Object.values(data.errors)[0][0];
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: msg,
                        confirmButtonColor: '#f97316'
                    });
                }
            } catch (e) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Gagal upload media',
                    confirmButtonColor: '#f97316'
                });
            }
        }

        // --- 5. DELETE BANNER ---
        window.deleteBanner = function(id) {
            Swal.fire({
                title: 'Hapus Media?',
                text: 'Data tidak bisa dikembalikan',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#cbd5e1',
                confirmButtonText: 'Ya, Hapus'
            }).then(async (result) => {
                if (result.isConfirmed) {
                    try {
                        const response = await fetch(`/admin/pengaturan/banner/${id}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': getCsrfToken(),
                                'Accept': 'application/json'
                            }
                        });
                        const data = await response.json();
                        if (response.ok && data.success) {
                            Swal.fire({
                                    icon: 'success',
                                    title: 'Terhapus',
                                    text: 'Media dihapus',
                                    confirmButtonColor: '#f97316'
                                })
                                .then(() => location.reload());
                        }
                    } catch (e) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Gagal menghapus',
                            confirmButtonColor: '#f97316'
                        });
                    }
                }
            });
        }
    </script>
@endsection
