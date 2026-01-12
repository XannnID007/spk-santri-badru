@extends('layouts.dashboard')

@section('title', 'Pengaturan Sistem')

@section('content')
    <div class="container mx-auto px-6 py-8">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-white mb-2">
                <i class="fas fa-cog mr-3"></i>Pengaturan Sistem
            </h1>
            <p class="text-gray-400">Kelola informasi dan pengaturan pesantren</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Logo Upload -->
            <div class="lg:col-span-1">
                <div class="glass-dark rounded-xl p-6">
                    <h3 class="text-xl font-semibold text-white mb-4">
                        <i class="fas fa-image mr-2"></i>Logo Pesantren
                    </h3>

                    <div class="text-center">
                        @if ($pengaturan->logo)
                            <img src="{{ asset('storage/' . $pengaturan->logo) }}" alt="Logo"
                                class="w-40 h-40 object-contain mx-auto mb-4 rounded-lg bg-gray-800/50 p-4">
                        @else
                            <div class="w-40 h-40 mx-auto mb-4 rounded-lg bg-gray-800/50 flex items-center justify-center">
                                <i class="fas fa-image text-6xl text-gray-600"></i>
                            </div>
                        @endif

                        <form id="formLogo" enctype="multipart/form-data">
                            @csrf
                            <input type="file" id="logo" name="logo" accept="image/*" class="hidden"
                                onchange="uploadLogo()">
                            <button type="button" onclick="document.getElementById('logo').click()"
                                class="w-full px-4 py-3 gradient-orange rounded-lg font-semibold hover:opacity-90 transition">
                                <i class="fas fa-upload mr-2"></i>Upload Logo
                            </button>
                            <p class="text-xs text-gray-400 mt-2">Format: JPG, PNG (Max: 2MB)</p>
                        </form>
                    </div>
                </div>

                <!-- Statistik Pesantren -->
                <div class="glass-dark rounded-xl p-6 mt-6">
                    <h3 class="text-xl font-semibold text-white mb-4">
                        <i class="fas fa-chart-bar mr-2"></i>Statistik Pesantren
                    </h3>

                    <div class="space-y-3">
                        <div class="glass-orange p-3 rounded-lg">
                            <p class="text-sm text-gray-400">Santri Aktif</p>
                            <p class="text-2xl font-bold text-orange-500">{{ $pengaturan->jumlah_santri }}</p>
                        </div>
                        <div class="glass-orange p-3 rounded-lg">
                            <p class="text-sm text-gray-400">Guru & Ustadz</p>
                            <p class="text-2xl font-bold text-orange-500">{{ $pengaturan->jumlah_guru }}</p>
                        </div>
                        <div class="glass-orange p-3 rounded-lg">
                            <p class="text-sm text-gray-400">Alumni</p>
                            <p class="text-2xl font-bold text-orange-500">{{ $pengaturan->jumlah_alumni }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Pengaturan -->
            <div class="lg:col-span-2">
                <div class="glass-dark rounded-xl p-6">
                    <h3 class="text-xl font-semibold text-white mb-6">
                        <i class="fas fa-edit mr-2"></i>Informasi Pesantren
                    </h3>

                    <form id="formPengaturan">
                        @csrf

                        <div class="space-y-6">
                            <!-- Identitas Pesantren -->
                            <div>
                                <h4 class="text-lg font-semibold text-orange-500 mb-4">Identitas Pesantren</h4>

                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-200 mb-2">Nama Pesantren *</label>
                                        <input type="text" name="nama_pesantren"
                                            value="{{ $pengaturan->nama_pesantren }}" required
                                            class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white focus:border-orange-500 focus:outline-none">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-200 mb-2">Alamat Lengkap *</label>
                                        <textarea name="alamat" rows="3" required
                                            class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white focus:border-orange-500 focus:outline-none">{{ $pengaturan->alamat }}</textarea>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-200 mb-2">Telepon *</label>
                                            <input type="text" name="telepon" value="{{ $pengaturan->telepon }}" required
                                                class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white focus:border-orange-500 focus:outline-none">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-200 mb-2">Email *</label>
                                            <input type="email" name="email" value="{{ $pengaturan->email }}" required
                                                class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white focus:border-orange-500 focus:outline-none">
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-200 mb-2">Website
                                            (Opsional)</label>
                                        <input type="text" name="website" value="{{ $pengaturan->website }}"
                                            class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white focus:border-orange-500 focus:outline-none"
                                            placeholder="www.pesantren.com">
                                    </div>
                                </div>
                            </div>

                            <!-- Informasi Rekening -->
                            <div>
                                <h4 class="text-lg font-semibold text-orange-500 mb-4">Informasi Rekening (Opsional)</h4>

                                <div class="space-y-4">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-200 mb-2">Nama Bank</label>
                                            <input type="text" name="nama_bank" value="{{ $pengaturan->nama_bank }}"
                                                class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white focus:border-orange-500 focus:outline-none"
                                                placeholder="Bank Mandiri">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-200 mb-2">Atas Nama</label>
                                            <input type="text" name="atas_nama" value="{{ $pengaturan->atas_nama }}"
                                                class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white focus:border-orange-500 focus:outline-none"
                                                placeholder="Yayasan PP Al-Badru">
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-200 mb-2">Nomor Rekening</label>
                                        <input type="text" name="no_rekening" value="{{ $pengaturan->no_rekening }}"
                                            class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white focus:border-orange-500 focus:outline-none"
                                            placeholder="1234567890">
                                    </div>
                                </div>
                            </div>

                            <!-- Statistik -->
                            <div>
                                <h4 class="text-lg font-semibold text-orange-500 mb-4">Statistik Pesantren</h4>

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-200 mb-2">Jumlah Santri *</label>
                                        <input type="number" name="jumlah_santri"
                                            value="{{ $pengaturan->jumlah_santri }}" required min="0"
                                            class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white focus:border-orange-500 focus:outline-none">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-200 mb-2">Jumlah Guru *</label>
                                        <input type="number" name="jumlah_guru" value="{{ $pengaturan->jumlah_guru }}"
                                            required min="0"
                                            class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white focus:border-orange-500 focus:outline-none">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-200 mb-2">Jumlah Alumni *</label>
                                        <input type="number" name="jumlah_alumni"
                                            value="{{ $pengaturan->jumlah_alumni }}" required min="0"
                                            class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white focus:border-orange-500 focus:outline-none">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-8 flex justify-end">
                            <button type="submit"
                                class="px-8 py-3 gradient-orange rounded-lg font-semibold hover:opacity-90 transition">
                                <i class="fas fa-save mr-2"></i>Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    async function uploadLogo() {
    const fileInput = document.getElementById('logo');
    const file = fileInput.files[0];

    if (!file) return;

    // Validate file size
    if (file.size > 2048000) {
    Swal.fire({
    icon: 'error',
    title: 'File Terlalu Besar!',
    text: 'Ukuran file maksimal 2MB',
    confirmButtonColor: '#ea580c',
    });
    return;
    }

    const formData = new FormData();
    formData.append('logo', file);

    try {
    const response = await fetch('{{ route('admin.pengaturan.upload-logo') }}', {
    method: 'POST',
    headers: {
    'X-CSRF-TOKEN': csrfToken,
    },
    body: formData
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

    document.getElementById('formPengaturan').addEventListener('submit', async function(e) {
    e.preventDefault();

    const formData = new FormData(this);
    const data = Object.fromEntries(formData.entries());

    try {
    const response = await fetch('{{ route('admin.pengaturan.update') }}', {
    method: 'PUT',
    headers: {
    'Content-Type': 'application/json',
    'X-CSRF-TOKEN': csrfToken,
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
@endsection
