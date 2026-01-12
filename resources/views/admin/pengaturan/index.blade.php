@extends('layouts.dashboard')

@section('title', 'Pengaturan Sistem')

@section('styles')
    <style>
        /* Style untuk animasi reveal agar terlihat keren */
        .reveal {
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.7s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .reveal.active {
            opacity: 1;
            transform: translateY(0);
        }

        .logo-preview {
            max-width: 100%;
            max-height: 200px;
            object-fit: contain;
            /* Background dihapus sesuai permintaan */
        }

        .glass-card-header {
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            padding-bottom: 1.5rem;
            margin-bottom: 2rem;
        }
    </style>
@endsection

@section('content')
    <div class="container mx-auto px-6 py-8">
        <div class="mb-8 reveal">
            <h1 class="text-3xl font-bold text-white mb-2">
                <i class="fas fa-cog mr-3 text-orange-500"></i>Pengaturan Sistem
            </h1>
            <p class="text-gray-400">Kelola identitas, statistik, dan media visual pendaftaran.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-1 space-y-6">
                <div class="glass-dark rounded-2xl p-6 reveal" style="transition-delay: 100ms">
                    <h3 class="text-xl font-semibold text-white mb-6">
                        <i class="fas fa-image mr-2 text-orange-500"></i>Logo Pesantren
                    </h3>

                    <div class="text-center">
                        <div class="mb-6">
                            @if ($pengaturan->logo)
                                <img src="{{ asset('storage/' . $pengaturan->logo) }}" alt="Logo"
                                    class="logo-preview mx-auto">
                            @else
                                <div
                                    class="w-40 h-40 mx-auto flex items-center justify-center border-2 border-dashed border-gray-700 rounded-2xl">
                                    <i class="fas fa-image text-6xl text-gray-700"></i>
                                </div>
                            @endif
                        </div>

                        <form id="formLogo" enctype="multipart/form-data">
                            @csrf
                            <input type="file" id="logo" name="logo" accept="image/*" class="hidden"
                                onchange="uploadLogo()">
                            <button type="button" onclick="document.getElementById('logo').click()"
                                class="w-full px-4 py-3 gradient-orange rounded-xl font-bold hover:opacity-90 transition shadow-lg shadow-orange-900/20 text-white">
                                <i class="fas fa-upload mr-2"></i>Ganti Logo
                            </button>
                            <p class="text-[10px] text-gray-500 mt-3 italic tracking-wider uppercase">Format: PNG/JPG (Maks.
                                2MB)</p>
                        </form>
                    </div>
                </div>

                <div class="glass-dark rounded-2xl p-6 reveal" style="transition-delay: 200ms">
                    <h3 class="text-xl font-semibold text-white mb-6">
                        <i class="fas fa-chart-pie mr-2 text-orange-500"></i>Live Data
                    </h3>

                    <div class="space-y-4">
                        <div class="glass-orange p-4 rounded-xl border border-orange-500/10">
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Santri Aktif</p>
                            <p class="text-2xl font-bold text-orange-500">{{ $pengaturan->jumlah_santri }}</p>
                        </div>
                        <div class="glass-orange p-4 rounded-xl border border-orange-500/10">
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Guru & Ustadz</p>
                            <p class="text-2xl font-bold text-orange-500">{{ $pengaturan->jumlah_guru }}</p>
                        </div>
                        <div class="glass-orange p-4 rounded-xl border border-orange-500/10">
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Total Alumni</p>
                            <p class="text-2xl font-bold text-orange-500">{{ $pengaturan->jumlah_alumni }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-2 space-y-8">
                <div class="glass-dark rounded-2xl p-8 reveal" style="transition-delay: 300ms">
                    <h3 class="text-xl font-semibold text-white mb-8 border-b border-white/5 pb-4">
                        <i class="fas fa-edit mr-2 text-orange-500"></i>Informasi Umum
                    </h3>

                    <form id="formPengaturan">
                        @csrf
                        <div class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-semibold text-gray-300 mb-2">Nama Pesantren</label>
                                    <input type="text" name="nama_pesantren" value="{{ $pengaturan->nama_pesantren }}"
                                        required
                                        class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-xl text-white focus:border-orange-500 outline-none transition">
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-semibold text-gray-300 mb-2">Alamat Lengkap</label>
                                    <textarea name="alamat" rows="2" required
                                        class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-xl text-white focus:border-orange-500 outline-none transition">{{ $pengaturan->alamat }}</textarea>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-300 mb-2">Telepon</label>
                                    <input type="text" name="telepon" value="{{ $pengaturan->telepon }}" required
                                        class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-xl text-white focus:border-orange-500 outline-none transition">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-300 mb-2">Email</label>
                                    <input type="email" name="email" value="{{ $pengaturan->email }}" required
                                        class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-xl text-white focus:border-orange-500 outline-none transition">
                                </div>
                            </div>

                            <div class="pt-6 mt-6 border-t border-white/5">
                                <h4 class="text-sm font-bold text-orange-500 uppercase tracking-widest mb-4">Update
                                    Statistik</h4>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <label class="block text-[11px] font-bold text-gray-400 mb-2">Jml Santri</label>
                                        <input type="number" name="jumlah_santri" value="{{ $pengaturan->jumlah_santri }}"
                                            required
                                            class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded-lg text-white focus:border-orange-500 outline-none">
                                    </div>
                                    <div>
                                        <label class="block text-[11px] font-bold text-gray-400 mb-2">Jml Guru</label>
                                        <input type="number" name="jumlah_guru" value="{{ $pengaturan->jumlah_guru }}"
                                            required
                                            class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded-lg text-white focus:border-orange-500 outline-none">
                                    </div>
                                    <div>
                                        <label class="block text-[11px] font-bold text-gray-400 mb-2">Jml Alumni</label>
                                        <input type="number" name="jumlah_alumni" value="{{ $pengaturan->jumlah_alumni }}"
                                            required
                                            class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded-lg text-white focus:border-orange-500 outline-none">
                                    </div>
                                </div>
                            </div>

                            <div class="flex justify-end mt-8">
                                <button type="submit"
                                    class="px-8 py-3 gradient-orange rounded-xl font-bold hover:scale-105 transition-all text-white shadow-lg">
                                    <i class="fas fa-save mr-2"></i>Simpan Perubahan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="glass-dark rounded-2xl p-8 reveal" style="transition-delay: 400ms">
                    <div class="flex justify-between items-center mb-8 border-b border-white/5 pb-4">
                        <h3 class="text-xl font-semibold text-white">
                            <i class="fas fa-images mr-2 text-orange-500"></i>Media Background
                        </h3>
                        <button onclick="openModalBanner()"
                            class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-xl text-xs font-bold transition">
                            <i class="fas fa-plus mr-1"></i>Tambah Media
                        </button>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @forelse($banners as $banner)
                            <div class="relative group rounded-xl overflow-hidden border border-gray-700 aspect-video">
                                @if ($banner->tipe === 'image')
                                    <img src="{{ asset('storage/' . $banner->file) }}"
                                        class="w-full h-full object-cover group-hover:scale-110 transition duration-500 opacity-60">
                                @else
                                    <div class="w-full h-full bg-black/40 flex items-center justify-center">
                                        <i class="fas fa-video text-3xl text-gray-500"></i>
                                    </div>
                                @endif
                                <div class="absolute inset-0 bg-black/40 p-4 flex flex-col justify-between">
                                    <div class="flex justify-between items-start">
                                        <span
                                            class="px-2 py-1 bg-orange-500 text-[9px] text-white font-black uppercase rounded">{{ $banner->tipe }}</span>
                                        <button onclick="deleteBanner({{ $banner->banner_id }})"
                                            class="w-8 h-8 bg-red-600/20 hover:bg-red-600 text-red-500 hover:text-white rounded-lg transition-all flex items-center justify-center">
                                            <i class="fas fa-trash text-xs"></i>
                                        </button>
                                    </div>
                                    <h4 class="text-white font-bold text-xs truncate">{{ $banner->judul }}</h4>
                                </div>
                            </div>
                        @empty
                            <div
                                class="md:col-span-2 py-12 text-center border-2 border-dashed border-gray-700 rounded-2xl text-gray-600">
                                <i class="fas fa-photo-video text-4xl mb-3"></i>
                                <p class="text-sm">Belum ada media background yang diunggah.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="modalBanner" class="fixed inset-0 z-[100] hidden items-center justify-center px-4">
        <div class="absolute inset-0 bg-black/80 backdrop-blur-sm" onclick="closeModalBanner()"></div>
        <div class="glass-dark w-full max-w-md p-8 rounded-3xl relative z-10 border border-gray-700 shadow-2xl">
            <h3 class="text-2xl font-bold text-white mb-6">Tambah Banner Baru</h3>
            <form id="formBanner">
                @csrf
                <div class="space-y-4">
                    <input type="text" name="judul" placeholder="Judul" required
                        class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-xl text-white outline-none">
                    <select name="tipe"
                        class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-xl text-white outline-none">
                        <option value="image">Gambar (JPG/PNG)</option>
                        <option value="video">Video (MP4)</option>
                    </select>
                    <input type="file" name="file" required
                        class="w-full text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-black file:bg-orange-600 file:text-white">
                    <input type="number" name="urutan" value="1" placeholder="Urutan"
                        class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-xl text-white outline-none">
                </div>
                <div class="flex gap-3 mt-8">
                    <button type="button" onclick="closeModalBanner()"
                        class="flex-1 py-3 bg-gray-700 text-white rounded-xl font-bold">Batal</button>
                    <button type="submit"
                        class="flex-1 py-3 gradient-orange text-white rounded-xl font-bold shadow-lg">Upload</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    // Reveal Observer
    const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
    if (entry.isIntersecting) entry.target.classList.add('active');
    });
    }, { threshold: 0.1 });

    document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

    // Modal Logic
    function openModalBanner() {
    document.getElementById('modalBanner').classList.remove('hidden');
    document.getElementById('modalBanner').classList.add('flex');
    }
    function closeModalBanner() {
    document.getElementById('modalBanner').classList.add('hidden');
    document.getElementById('modalBanner').classList.remove('flex');
    }

    // Logo Upload
    async function uploadLogo() {
    const file = document.getElementById('logo').files[0];
    if (!file) return;

    const formData = new FormData();
    formData.append('logo', file);
    formData.append('_token', '{{ csrf_token() }}');

    try {
    Swal.fire({ title: 'Mengupload...', allowOutsideClick: false, didOpen: () => Swal.showLoading() });
    const res = await fetch('{{ route('admin.pengaturan.upload-logo') }}', { method: 'POST', body: formData });
    const data = await res.json();
    if (data.success) Swal.fire('Berhasil!', data.message, 'success').then(() => location.reload());
    } catch (e) { Swal.fire('Error', 'Gagal upload logo', 'error'); }
    }

    // Update Identitas & Statistik
    document.getElementById('formPengaturan').addEventListener('submit', async function(e) {
    e.preventDefault();
    const data = Object.fromEntries(new FormData(this));
    try {
    Swal.fire({ title: 'Menyimpan...', allowOutsideClick: false, didOpen: () => Swal.showLoading() });
    const res = await fetch('{{ route('admin.pengaturan.update') }}', {
    method: 'PUT',
    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
    body: JSON.stringify(data)
    });
    const result = await res.json();
    if (result.success) Swal.fire('Berhasil!', result.message, 'success').then(() => location.reload());
    } catch (e) { Swal.fire('Error', 'Terjadi kesalahan sistem', 'error'); }
    });

    // Banner Logic
    document.getElementById('formBanner').addEventListener('submit', async function(e) {
    e.preventDefault();
    try {
    Swal.fire({ title: 'Mengupload...', allowOutsideClick: false, didOpen: () => Swal.showLoading() });
    const res = await fetch('{{ route('admin.pengaturan.banner.store') }}', {
    method: 'POST',
    headers: { 'X-CSRF-TOKEN': csrfToken },
    body: new FormData(this)
    });
    const result = await res.json();
    if (result.success) location.reload();
    } catch (e) { Swal.fire('Error', 'Gagal upload media', 'error'); }
    });

    async function deleteBanner(id) {
    if (confirm('Hapus media ini?')) {
    try {
    const res = await fetch(`/admin/pengaturan/banner/${id}`, {
    method: 'DELETE',
    headers: { 'X-CSRF-TOKEN': csrfToken }
    });
    if ((await res.json()).success) location.reload();
    } catch (e) { Swal.fire('Error', 'Gagal menghapus', 'error'); }
    }
    }
@endsection
